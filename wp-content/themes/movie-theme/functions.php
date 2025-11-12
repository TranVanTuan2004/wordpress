<?php

/**
 * Movie Theme functions and definitions
 */

if (! function_exists('movie_theme_setup')) :
    function movie_theme_setup()
    {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('custom-logo');
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

        register_nav_menus(array(
            'primary' => __('Primary Menu', 'movie-theme'),
        ));
    }
endif;
add_action('after_setup_theme', 'movie_theme_setup');

// Enqueue styles and scripts
function movie_theme_enqueue_assets()
{
    wp_enqueue_style('movie-theme-style', get_stylesheet_uri());
    wp_enqueue_style('movie-theme-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    wp_enqueue_script('movie-theme-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'movie_theme_enqueue_assets');

// Handle Auth POST before headers sent
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

// Register custom post type: movie
function movie_theme_register_post_type()
{
    $labels = array(
        'name'               => __('Movies', 'movie-theme'),
        'singular_name'      => __('Movie', 'movie-theme'),
        'menu_name'          => __('Movies', 'movie-theme'),
        'name_admin_bar'     => __('Movie', 'movie-theme'),
        'add_new'            => __('Add New', 'movie-theme'),
        'add_new_item'       => __('Add New Movie', 'movie-theme'),
        'new_item'           => __('New Movie', 'movie-theme'),
        'edit_item'          => __('Edit Movie', 'movie-theme'),
        'view_item'          => __('View Movie', 'movie-theme'),
        'all_items'          => __('All Movies', 'movie-theme'),
        'search_items'       => __('Search Movies', 'movie-theme'),
        'not_found'          => __('No movies found.', 'movie-theme'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'movies'),
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-video-alt3',
    );

    register_post_type('movie', $args);

    // Genre taxonomy
    $tax_labels = array(
        'name'              => _x('Genres', 'taxonomy general name', 'movie-theme'),
        'singular_name'     => _x('Genre', 'taxonomy singular name', 'movie-theme'),
        'search_items'      => __('Search Genres', 'movie-theme'),
        'all_items'         => __('All Genres', 'movie-theme'),
        'edit_item'         => __('Edit Genre', 'movie-theme'),
        'update_item'       => __('Update Genre', 'movie-theme'),
        'add_new_item'      => __('Add New Genre', 'movie-theme'),
        'new_item_name'     => __('New Genre Name', 'movie-theme'),
    );

    register_taxonomy('genre', array('movie'), array(
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'genre'),
    ));
}
add_action('init', 'movie_theme_register_post_type');

// Shortcode to list movies
function movie_theme_movie_list_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'posts_per_page' => 12,
        'genre' => '',
    ), $atts, 'movie_list');

    $args = array(
        'post_type' => 'movie',
        'posts_per_page' => intval($atts['posts_per_page']),
    );

    if (! empty($atts['genre'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'genre',
                'field' => 'slug',
                'terms' => sanitize_text_field($atts['genre']),
            ),
        );
    }

    $q = new WP_Query($args);
    ob_start();
    if ($q->have_posts()) {
        echo '<div class="movie-grid">';
        while ($q->have_posts()) {
            $q->the_post();
            echo '<div class="movie-card">';
            if (has_post_thumbnail()) {
                echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), 'medium') . '</a>';
            }
            echo '<div class="movie-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></div>';
            echo '<div class="movie-meta">' . get_the_excerpt() . '</div>';
            echo '</div>';
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>No movies found.</p>';
    }

    return ob_get_clean();
}
add_shortcode('movie_list', 'movie_theme_movie_list_shortcode');

// Register image sizes
add_action('after_setup_theme', function () {
    add_image_size('movie-thumb', 400, 225, true);
});

