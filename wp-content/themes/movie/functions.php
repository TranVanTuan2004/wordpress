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

// Tự tạo các trang cần thiết nếu chưa có
function movie_theme_ensure_core_pages() {
    $pages = array(
        array(
            'title'    => 'Trang Đặt Vé',
            'slug'     => 'datve',
            'content'  => '[booking_page]',
            'template' => 'page-templates/book-tickets.php',
        ),
        array(
            'title'    => 'Order Success',
            'slug'     => 'order-success',
            'content'  => 'Order summary will be shown after booking.',
            'template' => 'page-templates/order-success.php',
        ),
        // Trang đăng nhập: có file page-dangnhap.php nên chỉ cần tạo trang với slug tương ứng
        array(
            'title'    => 'Đăng nhập',
            'slug'     => 'dangnhap',
            'content'  => '',
            'template' => '', // page-{slug}.php sẽ tự match
        ),
        // Trang hồ sơ: có page-profile.php
        array(
            'title'    => 'Hồ sơ cá nhân',
            'slug'     => 'profile',
            'content'  => '',
            'template' => '',
        ),
        // Alias thêm cho đặt vé dạng có dấu gạch "dat-ve"
        array(
            'title'    => 'Đặt Vé',
            'slug'     => 'dat-ve',
            'content'  => '',
            'template' => 'page-templates/book-tickets.php',
        ),
    );

    foreach ($pages as $cfg) {
        $page = get_page_by_path($cfg['slug']);
        if (! $page) {
            $page_id = wp_insert_post(array(
                'post_title'   => $cfg['title'],
                'post_name'    => $cfg['slug'],
                'post_content' => $cfg['content'],
                'post_type'    => 'page',
                'post_status'  => 'publish',
            ));
            if (! is_wp_error($page_id) && $page_id) {
                if (! empty($cfg['template'])) {
                    update_post_meta($page_id, '_wp_page_template', $cfg['template']);
                }
            }
        } else {
            // Đảm bảo template đúng nếu trang đã tồn tại
            if (! empty($cfg['template'])) {
                $current_tpl = get_page_template_slug($page->ID);
                if ($current_tpl !== $cfg['template']) {
                    update_post_meta($page->ID, '_wp_page_template', $cfg['template']);
                }
            }
        }
    }

    // Không tạo trang "rap-phim" nếu site đang có CPT rạp dùng slug này để tránh xung đột
    $cinema_pts = array('mbs_cinema','rap_phim','rap-phim','cinema','theater','rap','rapfilm','rap_phim_cpt');
    $has_cinema_cpt = false;
    foreach ($cinema_pts as $pt) { if (post_type_exists($pt)) { $has_cinema_cpt = true; break; } }
    if (! $has_cinema_cpt) {
        $page = get_page_by_path('rap-phim');
        if (! $page) {
            wp_insert_post(array(
                'post_title'  => 'Rạp Phim',
                'post_name'   => 'rap-phim',
                'post_type'   => 'page',
                'post_status' => 'publish',
            ));
        }
    }

    // Cập nhật lại permalink khi lần đầu tạo trang
    if (function_exists('flush_rewrite_rules')) {
        flush_rewrite_rules(false);
    }
}
add_action('after_switch_theme', 'movie_theme_ensure_core_pages');
add_action('init', function(){
    // Fallback: nếu ai đó xoá trang, mỗi lần init kiểm tra và khôi phục
    $required = array('datve','order-success','dangnhap','profile','dat-ve');
    foreach ($required as $slug){ if (! get_page_by_path($slug)) { movie_theme_ensure_core_pages(); break; } }
});

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
add_action('wp_enqueue_scripts', 'mytheme_front_page_scripts');

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
            array(), // phụ thuộc jquery nếu cần
            filemtime(get_stylesheet_directory() . '/script-movie.js'),
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


// ====== Ticket Order (Đơn vé) ======
add_action('init', function () {
    register_post_type('ticket_order', array(
        'labels' => array(
            'name' => 'Đơn vé',
            'singular_name' => 'Đơn vé'
        ),
        'public' => false,
        'show_ui' => true,
        'menu_position' => 25,
        'supports' => array('title'),
    ));
});

function movie_render_order_summary($order_id){
    $movie_id  = intval(get_post_meta($order_id,'movie_id',true));
    $cinema_id = intval(get_post_meta($order_id,'cinema_id',true));
    $date      = esc_html(get_post_meta($order_id,'show_date',true));
    $time      = esc_html(get_post_meta($order_id,'show_time',true));
    $seats     = (array) get_post_meta($order_id,'seats',true);
    $total     = floatval(get_post_meta($order_id,'total',true));
    $html  = '<h2>Thông tin đơn vé #' . $order_id . '</h2>';
    $html .= '<p><strong>Phim:</strong> '. esc_html(get_the_title($movie_id)) .'</p>';
    $html .= '<p><strong>Rạp:</strong> '. esc_html(get_the_title($cinema_id)) .'</p>';
    $html .= '<p><strong>Ngày/giờ:</strong> '. $date .' '. $time .'</p>';
    $html .= '<p><strong>Ghế:</strong> '. esc_html(implode(', ',$seats)) .'</p>';
    $html .= '<p><strong>Tổng tiền:</strong> '. number_format($total,0,',','.') .'đ</p>';
    $qr_data = home_url('/?order='.$order_id);
    $qr_url  = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . urlencode($qr_data);
    $html .= '<p><img alt="QR" src="'.$qr_url.'" style="max-width:200px"></p>';
    return $html;
}

add_action('wp_ajax_create_ticket_order', 'movie_create_ticket_order');
add_action('wp_ajax_nopriv_create_ticket_order', 'movie_create_ticket_order');
function movie_create_ticket_order() {
    check_ajax_referer('ticket_order_nonce', 'nonce');

    $movie_id  = isset($_POST['movie_id'])  ? intval($_POST['movie_id'])  : 0;
    $cinema_id = isset($_POST['cinema_id']) ? intval($_POST['cinema_id']) : 0;
    $date      = isset($_POST['date'])      ? sanitize_text_field($_POST['date']) : '';
    $time      = isset($_POST['time'])      ? sanitize_text_field($_POST['time']) : '';
    $seats     = isset($_POST['seats'])     ? (array) $_POST['seats'] : array();
    $total     = isset($_POST['total'])     ? floatval($_POST['total']) : 0;
    $method    = isset($_POST['method'])    ? sanitize_text_field($_POST['method']) : 'pay_later';

    if (!$movie_id || !$cinema_id || empty($date) || empty($time) || empty($seats)) {
        wp_send_json_error(array('message' => 'Thiếu dữ liệu.'));
    }

    $order_title = sprintf('Vé %s - %s %s', get_the_title($movie_id), $date, $time);
    $order_id = wp_insert_post(array(
        'post_type'   => 'ticket_order',
        'post_status' => 'publish',
        'post_title'  => $order_title,
    ));

    if (is_wp_error($order_id) || !$order_id) {
        wp_send_json_error(array('message' => 'Không tạo được đơn.'));
    }

    update_post_meta($order_id, 'movie_id',  $movie_id);
    update_post_meta($order_id, 'cinema_id', $cinema_id);
    update_post_meta($order_id, 'show_date', $date);
    update_post_meta($order_id, 'show_time', $time);
    update_post_meta($order_id, 'seats',     array_map('sanitize_text_field', $seats));
    update_post_meta($order_id, 'total',     $total);
    update_post_meta($order_id, 'user_id',   get_current_user_id());
    update_post_meta($order_id, 'method',    $method);
    update_post_meta($order_id, 'status',    'completed'); // hoàn tất ngay theo yêu cầu

    // Đồng bộ sang plugin Movie Booking System (bảng mbs_bookings/mbs_seats)
    global $wpdb; 
    $booking_table = $wpdb->prefix . 'mbs_bookings';
    $seats_table   = $wpdb->prefix . 'mbs_seats';

    // Lấy thông tin người dùng
    $user   = wp_get_current_user();
    $u_name = $user ? $user->display_name : '';
    $u_mail = $user ? $user->user_email : '';
    $u_phone= $user ? get_user_meta($user->ID,'phone',true) : '';

    $wpdb->insert($booking_table, array(
        'booking_code'   => 'MBS' . time(),
        'customer_name'  => $u_name,
        'customer_email' => $u_mail,
        'customer_phone' => $u_phone,
        'total_seats'    => count($seats),
        'total_price'    => $total,
        'payment_status' => 'completed',
        'booking_date'   => current_time('mysql'),
    ), array('%s','%s','%s','%s','%d','%f','%s','%s'));
    $mbs_booking_id = $wpdb->insert_id;

    if ( $mbs_booking_id ) {
        foreach ( $seats as $s ) {
            $wpdb->insert($seats_table, array(
                'booking_id' => $mbs_booking_id,
                'seat_code'  => sanitize_text_field($s)
            ), array('%d','%s'));
        }
    }

    // Gửi email xác nhận (nếu có email)
    if ($user && $user->user_email) {
        $subject = 'Xác nhận đặt vé #' . $order_id;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $body    = movie_render_order_summary($order_id);
        @wp_mail($user->user_email, $subject, $body, $headers);
    }

    $success_page = get_page_by_path('order-success');
    $success_url  = $success_page ? get_permalink($success_page) : home_url('/order-success/');
    $success_url  = add_query_arg('order_id', $order_id, $success_url);

    wp_send_json_success(array(
        'message'  => 'Đặt vé thành công!',
        'order_id' => $order_id,
        'redirect' => $success_url,
    ));
}

add_action('wp_ajax_get_reserved_seats', 'movie_get_reserved_seats');
add_action('wp_ajax_nopriv_get_reserved_seats', 'movie_get_reserved_seats');
function movie_get_reserved_seats(){
    $movie_id  = isset($_POST['movie_id'])  ? intval($_POST['movie_id'])  : 0;
    $cinema_id = isset($_POST['cinema_id']) ? intval($_POST['cinema_id']) : 0;
    $date      = isset($_POST['date'])      ? sanitize_text_field($_POST['date']) : '';
    $time      = isset($_POST['time'])      ? sanitize_text_field($_POST['time']) : '';

    if(!$movie_id || !$cinema_id || $date==='' || $time===''){
        wp_send_json_success(array('seats'=>array()));
    }

    $reserved = array();

    // 1) Lấy từ CPT ticket_order (chính xác theo movie/cinema/date/time)
    $orders = new WP_Query(array(
        'post_type'      => 'ticket_order',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query'     => array(
            'relation' => 'AND',
            array('key'=>'movie_id','value'=>$movie_id,'compare'=>'='),
            array('key'=>'cinema_id','value'=>$cinema_id,'compare'=>'='),
            array('key'=>'show_date','value'=>$date,'compare'=>'='),
            array('key'=>'show_time','value'=>$time,'compare'=>'='),
            array('key'=>'status','value'=>'completed','compare'=>'=')
        )
    ));
    if ($orders->have_posts()){
        while($orders->have_posts()){ $orders->the_post();
            $seats = (array) get_post_meta(get_the_ID(),'seats',true);
            foreach($seats as $s){ $reserved[] = sanitize_text_field($s); }
        }
        wp_reset_postdata();
    }

    // 2) Gộp thêm từ bảng plugin nếu có (không ràng buộc được theo time nên chỉ bổ sung tổng quát theo ngày)
    global $wpdb; 
    $table_bookings = $wpdb->prefix . 'mbs_bookings';
    $table_seats    = $wpdb->prefix . 'mbs_seats';
    $bookings = $wpdb->get_results($wpdb->prepare(
        "SELECT id FROM $table_bookings WHERE DATE(booking_date)=%s",
        $date
    ));
    if ($bookings) {
        $ids = wp_list_pluck($bookings, 'id');
        if (!empty($ids)) {
            $in = implode(',', array_map('intval',$ids));
            $rows = $wpdb->get_results("SELECT seat_code FROM $table_seats WHERE booking_id IN ($in)");
            foreach ($rows as $r) { $reserved[] = $r->seat_code; }
        }
    }

    wp_send_json_success(array('seats'=>array_values(array_unique($reserved))));
}

add_action('wp_enqueue_scripts', function () {
    wp_register_script('booking-js', get_stylesheet_directory_uri() . '/js/booking.js', array('jquery'), '1.0', true);
    wp_localize_script('booking-js', 'BOOKING_AJAX', array(
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ticket_order_nonce'),
    ));
});

?>







