<?php 
function mytheme_enqueue_styles() {
    wp_enqueue_style('mytheme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_styles');



//thêm navbar phim
function create_movie_post_type() {
    $labels = array(
        'name' => 'Phim',
        'singular_name' => 'Phim',
        'add_new' => 'Thêm phim',
        'add_new_item' => 'Thêm phim mới',
        'edit_item' => 'Chỉnh sửa phim',
        'all_items' => 'Tất cả phim',
        'menu_name' => 'Phim'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_position' => 5,
        'menu_icon' => 'dashicons-video-alt2',
        'show_in_rest' => true, // để Gutenberg editor hoạt động
    );

    register_post_type('mbs_movie', $args);
}
add_action('init', 'create_movie_post_type');



//css header, footer in all page
function mytheme_global_styles() {
    // Header CSS
    wp_enqueue_style(
        'header-style',
        get_stylesheet_directory_uri() . '/header.css',
        array(),
        '1.0',
        
    );

    // Footer CSS
    wp_enqueue_style(
        'footer-style',
        get_stylesheet_directory_uri() . '/footer.css',
        array(),
        '1.0'
    );
}
add_action('wp_enqueue_scripts', 'mytheme_global_styles');


// css in file front-page.php
function mytheme_front_page_styles() {
    if ( is_front_page() ) {  
        wp_enqueue_style(
            'mytheme-front-page-style',
            get_stylesheet_directory_uri() . '/front-page.css',
            array(),      // không phụ thuộc file khác
            // filemtime(get_template_directory() . '/front-page.css'), //Update khi thay đổi
            '1.0'         // version (để tránh cache)
        );
    }
}
add_action( 'wp_enqueue_scripts', 'mytheme_front_page_styles' );

// script in file front-page.php
function mytheme_front_page_scripts() {
    if ( is_front_page() ) {
        wp_enqueue_script(
            'mytheme-front-script',
            get_stylesheet_directory_uri() . '/script.js',
            array('jquery'), // phụ thuộc jquery nếu cần
            '1.0',
            true // load ở footer
        );
    }
}
add_shortcode('movie_list', 'movie_theme_movie_list_shortcode');

// Register image sizes
add_action('after_setup_theme', function () {
    add_image_size('movie-thumb', 400, 225, true);
});
// css in file single-mbs_movie.php
function mytheme_single_movie_styles() {
    if ( is_singular('mbs_movie') ) { // hoặc 'movie' nếu bạn đổi lại
        wp_enqueue_style(
            'single-movie-style',
            get_stylesheet_directory_uri() . '/single-movie.css',
            array('header-style', 'footer-style'),
            filemtime(get_stylesheet_directory() . '/single-movie.css')
        );
    }
}
add_action('wp_enqueue_scripts', 'mytheme_single_movie_styles');

// Script riêng cho trang chi tiết phim (single-mbs_movie.php)
function mytheme_single_movie_scripts() {
    if ( is_singular('mbs_movie') ) {
        wp_enqueue_script(
            'mytheme-single-movie-script',
            get_stylesheet_directory_uri() . '/script-movie.js',
            array('jquery'), // phụ thuộc jquery nếu cần
            '1.0',
            true // load ở footer
        );
    }
}
add_action('wp_enqueue_scripts', 'mytheme_single_movie_scripts');


function movie_theme_handle_auth_post()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cns_action']) && $_POST['cns_action'] === 'login') {
        $error_message = '';
        if (! isset($_POST['cns_auth_nonce']) || ! wp_verify_nonce($_POST['cns_auth_nonce'], 'cns_auth_login')) {
            $error_message = __('Phiên không hợp lệ, vui lòng thử lại.', 'movie-theme');
        } else {
            $username = isset($_POST['log']) ? sanitize_text_field(wp_unslash($_POST['log'])) : '';
            $password = isset($_POST['pwd']) ? (string) $_POST['pwd'] : '';
            $remember = ! empty($_POST['rememberme']);
            if ($username === '' || $password === '') {
                $error_message = __('Vui lòng nhập đầy đủ tài khoản và mật khẩu.', 'movie-theme');
            } else {
                $signon = wp_signon(array(
                    'user_login'    => $username,
                    'user_password' => $password,
                    'remember'      => $remember,
                ), is_ssl());
                if (is_wp_error($signon)) {
                    $error_message = __('Tài khoản hoặc mật khẩu không hợp lệ. Vui lòng kiểm tra lại.', 'movie-theme');
                } else {
                    $redirect_to = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : home_url('/');
                    wp_safe_redirect($redirect_to);
                    exit;
                }
            }
        }
        // Redirect back to the page with a transient error key
        $referer = isset($_POST['form_url']) ? esc_url_raw(wp_unslash($_POST['form_url'])) : wp_get_referer();
        if (! $referer) {
            $referer = home_url('/');
        }
        $key = wp_generate_password(12, false);
        set_transient('cns_login_err_' . $key, $error_message, 60);
        $url = add_query_arg(array('tab' => 'login', 'cnsle' => $key), $referer);
        wp_safe_redirect($url);
        exit;
    }
}
add_action('template_redirect', 'movie_theme_handle_auth_post');

// Handle Profile POST (update info / change password) before output
function movie_theme_handle_profile_post()
{
    if (! is_user_logged_in()) {
        return;
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ! isset($_POST['cns_action'])) {
        return;
    }

    $user_id = get_current_user_id();
    $referer = wp_get_referer() ?: home_url('/profile');

    // Update profile basic info
    if ($_POST['cns_action'] === 'profile_update') {
        if (! isset($_POST['cns_profile_nonce']) || ! wp_verify_nonce($_POST['cns_profile_nonce'], 'cns_profile_update')) {
            $msg = __('Phiên không hợp lệ, vui lòng thử lại.', 'movie-theme');
            $key = wp_generate_password(12, false);
            set_transient('cns_profile_err_' . $key, $msg, 60);
            wp_safe_redirect(add_query_arg('cnspre', $key, $referer));
            exit;
        }
        $display_name = isset($_POST['display_name']) ? sanitize_text_field(wp_unslash($_POST['display_name'])) : '';
        $email = isset($_POST['user_email']) ? sanitize_email(wp_unslash($_POST['user_email'])) : '';
        $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
        $birthday = isset($_POST['birthday']) ? sanitize_text_field(wp_unslash($_POST['birthday'])) : '';

        $update = array('ID' => $user_id);
        if ($display_name !== '') {
            $update['display_name'] = $display_name;
        }
        if ($email !== '' && is_email($email)) {
            $update['user_email'] = $email;
        }
        $err = wp_update_user($update);
        if (is_wp_error($err)) {
            $msg = $err->get_error_message();
            $key = wp_generate_password(12, false);
            set_transient('cns_profile_err_' . $key, $msg, 60);
            wp_safe_redirect(add_query_arg('cnspre', $key, $referer));
            exit;
        }
        update_user_meta($user_id, 'phone', $phone);
        update_user_meta($user_id, 'birthday', $birthday);

        $key = wp_generate_password(12, false);
        set_transient('cns_profile_ok_' . $key, __('Đã lưu thông tin.', 'movie-theme'), 60);
        wp_safe_redirect(add_query_arg('cnspok', $key, $referer));
        exit;
    }

    // Change password
    if ($_POST['cns_action'] === 'change_password') {
        if (! isset($_POST['cns_password_nonce']) || ! wp_verify_nonce($_POST['cns_password_nonce'], 'cns_profile_password')) {
            $msg = __('Phiên không hợp lệ, vui lòng thử lại.', 'movie-theme');
            $key = wp_generate_password(12, false);
            set_transient('cns_profile_err_' . $key, $msg, 60);
            wp_safe_redirect(add_query_arg('cnspre', $key, $referer));
            exit;
        }
        $old = isset($_POST['old_pass']) ? (string) $_POST['old_pass'] : '';
        $new = isset($_POST['new_pass']) ? (string) $_POST['new_pass'] : '';
        $cfm = isset($_POST['confirm_pass']) ? (string) $_POST['confirm_pass'] : '';
        if ($new === '' || $cfm === '' || $old === '') {
            $msg = __('Vui lòng điền đủ các trường mật khẩu.', 'movie-theme');
        } elseif ($new !== $cfm) {
            $msg = __('Xác thực mật khẩu không khớp.', 'movie-theme');
        } else {
            $user = get_userdata($user_id);
            if (! wp_check_password($old, $user->user_pass, $user_id)) {
                $msg = __('Mật khẩu cũ không đúng.', 'movie-theme');
            } else {
                $res = wp_update_user(array('ID' => $user_id, 'user_pass' => $new));
                if (is_wp_error($res)) {
                    $msg = $res->get_error_message();
                } else {
                    $key = wp_generate_password(12, false);
                    set_transient('cns_profile_ok_' . $key, __('Đổi mật khẩu thành công. Vui lòng đăng nhập lại.', 'movie-theme'), 60);
                    // Đăng xuất tất cả và chuyển về trang đăng nhập
                    wp_logout();
                    wp_safe_redirect(add_query_arg('msg', $key, home_url('/dangnhap')));
                    exit;
                }
            }
        }
        $key = wp_generate_password(12, false);
        set_transient('cns_profile_err_' . $key, $msg, 60);
        wp_safe_redirect(add_query_arg('cnspre', $key, $referer));
        exit;
    }
}
add_action('template_redirect', 'movie_theme_handle_profile_post');

// Shortcode: [cns_auth tab="login|register"]
function movie_theme_auth_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'tab' => 'login',
    ), $atts, 'cns_auth');

    $active_tab = strtolower(trim($atts['tab'])) === 'register' ? 'register' : 'login';

    ob_start();
    $file = locate_template('auth/auth-tabs.php', false, false);
    if ($file) {
        include $file;
    } else {
        echo '<p>Auth component not found.</p>';
    }
    return ob_get_clean();
}
add_shortcode('cns_auth', 'movie_theme_auth_shortcode');

function movie_theme_home_shortcode($atts)
{
    ob_start();
    $file = locate_template('home.php', false, false);
    if ($file) {
        include $file;
    }
    return ob_get_clean();
}
add_shortcode('home', 'movie_theme_home_shortcode');

// Shortcode: [cns_profile]
function movie_theme_profile_shortcode()
{
    if (! is_user_logged_in()) {
        $redirect_to = urlencode(home_url('/profile'));
        wp_safe_redirect(home_url('/dangnhap') . '?redirect_to=' . $redirect_to);
        exit;
    }
    ob_start();
    $file = locate_template('auth/profile.php', false, false);
    if ($file) {
        include $file;
    }
    return ob_get_clean();
}
add_shortcode('cns_profile', 'movie_theme_profile_shortcode');
?>



