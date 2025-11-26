<?php 
function movie_theme_get_movie_post_type() {
    return 'mbs_movie';
}

function movie_theme_is_movie_singular() {
    return is_singular(movie_theme_get_movie_post_type());
}

function mytheme_enqueue_styles() {
    wp_enqueue_style('mytheme-style', get_stylesheet_uri());
    
    // Enqueue single movie CSS
    if (movie_theme_is_movie_singular()) {
        wp_enqueue_style('single-movie-style', get_template_directory_uri() . '/single-movie.css', array(), filemtime(get_template_directory() . '/single-movie.css'));
    }
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_styles');



// Đảm bảo comments luôn được bật cho movie (CPT từ plugin)
function movie_theme_enable_comments_for_movies($open, $post_id) {
    $post = get_post($post_id);
    if ($post && $post->post_type === movie_theme_get_movie_post_type()) {
        return true; // Luôn bật comments cho phim
    }
    return $open;
}
add_filter('comments_open', 'movie_theme_enable_comments_for_movies', 10, 2);

// Đảm bảo comments được bật mặc định khi tạo phim mới
function movie_theme_default_comments_open($post_id) {
    $post = get_post($post_id);
    if ($post && $post->post_type === movie_theme_get_movie_post_type()) {
        if ($post->comment_status !== 'open') {
            wp_update_post(array(
                'ID' => $post_id,
                'comment_status' => 'open'
            ));
        }
    }
}
add_action('save_post_' . movie_theme_get_movie_post_type(), 'movie_theme_default_comments_open');

// Bật comments cho tất cả các phim hiện có (chạy 1 lần)
function movie_theme_enable_comments_for_existing_movies() {
    // Chỉ chạy 1 lần
    if (get_option('movie_comments_enabled_for_all') === 'yes') {
        return;
    }
    
    $movies = get_posts(array(
        'post_type' => 'mbs_movie',
        'posts_per_page' => -1,
        'post_status' => 'any'
    ));
    
    foreach ($movies as $movie) {
        if ($movie->comment_status !== 'open') {
            wp_update_post(array(
                'ID' => $movie->ID,
                'comment_status' => 'open'
            ));
        }
    }
    
    // Đánh dấu đã chạy
    update_option('movie_comments_enabled_for_all', 'yes');
}
// Chạy khi admin init
add_action('admin_init', 'movie_theme_enable_comments_for_existing_movies');

// Tự tạo các trang cần thiết nếu chưa có
function movie_theme_ensure_core_pages() {
    $pages = array(
        array(
            'title'    => 'Trang Đặt Vé',
            'slug'     => 'datve',
            'content'  => '',
            'template' => 'page-datve.php',
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
        // Trang đăng ký
        array(
            'title'    => 'Đăng Ký',
            'slug'     => 'dangky',
            'content'  => '',
            'template' => 'page-dangky.php',
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
        // Trang checkout cho WooCommerce
        array(
            'title'    => 'Thanh toán',
            'slug'     => 'checkout',
            'content'  => '[woocommerce_checkout]',
            'template' => 'page-checkout.php',
        ),
        // Trang phim yêu thích
        array(
            'title'    => 'Phim Yêu Thích',
            'slug'     => 'favorites',
            'content'  => '',
            'template' => 'page-favorites.php',
        ),
        // Trang khuyến mãi
        array(
            'title'    => 'Khuyến mãi',
            'slug'     => 'khuyenmai',
            'content'  => '',
            'template' => 'page-khuyenmai.php',
        ),
        // Trang tổ chức sự kiện
        array(
            'title'    => 'Tổ chức sự kiện',
            'slug'     => 'tochucsukien',
            'content'  => '',
            'template' => 'page-tochucsukien.php',
        ),
        // Trang giới thiệu
        array(
            'title'    => 'Giới thiệu',
            'slug'     => 'gioithieu',
            'content'  => '',
            'template' => 'page-gioithieu.php',
        ),
        // Trang liên hệ
        array(
            'title'    => 'Liên Hệ',
            'slug'     => 'lien-he',
            'content'  => '',
            'template' => 'page-lien-he.php',
        ),
        // Trang phim đang chiếu
        array(
            'title'    => 'Phim Đang Chiếu',
            'slug'     => 'phim-dang-chieu',
            'content'  => '',
            'template' => 'page-phim-dang-chieu.php',
        ),
        // Trang phim sắp chiếu
        array(
            'title'    => 'Phim Sắp Chiếu',
            'slug'     => 'phim-sap-chieu',
            'content'  => '',
            'template' => 'page-phim-sap-chieu.php',
        ),
        // Trang suất chiếu đặc biệt
        array(
            'title'    => 'Suất Chiếu Đặc Biệt',
            'slug'     => 'suat-chieu-dac-biet',
            'content'  => '',
            'template' => 'page-suat-chieu-dac-biet.php',
        ),
        // Trang hệ thống rạp
        array(
            'title'    => 'Tất cả hệ thống rạp',
            'slug'     => 'he-thong-rap',
            'content'  => '',
            'template' => 'page-he-thong-rap.php',
        ),
        // Trang tuyển dụng
        array(
            'title'    => 'Tuyển Dụng',
            'slug'     => 'tuyen-dung',
            'content'  => '',
            'template' => 'page-tuyen-dung.php',
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
                // Đặc biệt cho trang checkout: set WooCommerce option
                if ($cfg['slug'] === 'checkout' && class_exists('WooCommerce')) {
                    update_option('woocommerce_checkout_page_id', $page_id);
                }
            }
        } else {
            // Force update template cho page favorites để đảm bảo nó được sử dụng
            if ($cfg['slug'] === 'favorites' && !empty($cfg['template'])) {
                update_post_meta($page->ID, '_wp_page_template', $cfg['template']);
            } elseif (! empty($cfg['template'])) {
                $current_tpl = get_page_template_slug($page->ID);
                if ($current_tpl !== $cfg['template']) {
                    update_post_meta($page->ID, '_wp_page_template', $cfg['template']);
                }
            }
            // Đặc biệt cho trang checkout: set WooCommerce option
            if ($cfg['slug'] === 'checkout' && class_exists('WooCommerce')) {
                update_option('woocommerce_checkout_page_id', $page->ID);
            }
        }
    }

    // Force update templates for movie pages
    $phim_dang_chieu = get_page_by_path('phim-dang-chieu');
    if ($phim_dang_chieu) {
        $current_template = get_post_meta($phim_dang_chieu->ID, '_wp_page_template', true);
        if ($current_template !== 'page-phim-dang-chieu.php') {
            update_post_meta($phim_dang_chieu->ID, '_wp_page_template', 'page-phim-dang-chieu.php');
        }
    }
    
    $phim_sap_chieu = get_page_by_path('phim-sap-chieu');
    if ($phim_sap_chieu) {
        $current_template = get_post_meta($phim_sap_chieu->ID, '_wp_page_template', true);
        if ($current_template !== 'page-phim-sap-chieu.php') {
            update_post_meta($phim_sap_chieu->ID, '_wp_page_template', 'page-phim-sap-chieu.php');
        }
    }

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

    if (function_exists('flush_rewrite_rules')) {
        flush_rewrite_rules(false);
    }
}
add_action('after_switch_theme', 'movie_theme_ensure_core_pages');
// Đảm bảo các trang được tạo khi theme được load
add_action('init', 'movie_theme_ensure_core_pages', 20);
add_action('init', function(){
    $required = array('datve','order-success','dangnhap','profile','dat-ve','checkout','favorites');
    foreach ($required as $slug){ if (! get_page_by_path($slug)) { movie_theme_ensure_core_pages(); break; } }
    
    // Đảm bảo trang checkout được tạo và cấu hình cho WooCommerce
    $checkout_page = get_page_by_path('checkout');
    if (!$checkout_page) {
        // Tạo trang checkout nếu chưa có
        $page_id = wp_insert_post(array(
            'post_title'   => 'Thanh toán',
            'post_name'    => 'checkout',
            'post_content' => '[woocommerce_checkout]',
            'post_type'    => 'page',
            'post_status'  => 'publish',
        ));
        if ($page_id && !is_wp_error($page_id)) {
            $checkout_page = get_post($page_id);
            // Flush rewrite rules để URL hoạt động ngay
            flush_rewrite_rules(false);
        }
    }
    
    // Set làm checkout page của WooCommerce
    if ($checkout_page && class_exists('WooCommerce')) {
        $current_checkout_id = get_option('woocommerce_checkout_page_id');
        if ($current_checkout_id != $checkout_page->ID) {
            update_option('woocommerce_checkout_page_id', $checkout_page->ID);
        }
    }
}, 20); // Priority 20 để chạy sau các hook khác

// Robust fix for pages and permalinks
add_action('init', function() {
    // 1. Ensure Permalink Structure is %postname%
    if (get_option('permalink_structure') !== '/%postname%/') {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/');
        update_option('permalink_structure', '/%postname%/');
        flush_rewrite_rules();
    }

    // 2. Ensure 'datve' page exists and is published
    $page_slug = 'datve';
    $page = get_page_by_path($page_slug);
    
    // If not found by path, try to find by ID or in Trash
    if (!$page) {
        $found = get_posts(array(
            'name' => $page_slug,
            'post_type' => 'page',
            'post_status' => 'any',
            'numberposts' => 1
        ));
        if ($found) {
            $page = $found[0];
        }
    }

    if ($page) {
        // If page exists but is not publish, publish it
        if ($page->post_status !== 'publish') {
            wp_update_post(array(
                'ID' => $page->ID,
                'post_status' => 'publish'
            ));
        }
        // Ensure template is correct
        $current_tpl = get_post_meta($page->ID, '_wp_page_template', true);
        if ($current_tpl !== 'page-datve.php') {
            update_post_meta($page->ID, '_wp_page_template', 'page-datve.php');
        }
    } else {
        // Create page if it doesn't exist
        $page_id = wp_insert_post(array(
            'post_title'   => 'Trang Đặt Vé',
            'post_name'    => $page_slug,
            'post_content' => '',
            'post_type'    => 'page',
            'post_status'  => 'publish',
        ));
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'page-datve.php');
        }
    }

    // 2.1 Ensure 'bapnuoc' page exists
    $bn_slug = 'bapnuoc';
    $bn_page = get_page_by_path($bn_slug);
    if (!$bn_page) {
        $found = get_posts(array('name' => $bn_slug, 'post_type' => 'page', 'post_status' => 'any', 'numberposts' => 1));
        if ($found) $bn_page = $found[0];
    }
    if ($bn_page) {
        if ($bn_page->post_status !== 'publish') {
            wp_update_post(array('ID' => $bn_page->ID, 'post_status' => 'publish'));
        }
        $current_tpl = get_post_meta($bn_page->ID, '_wp_page_template', true);
        if ($current_tpl !== 'page-bapnuoc.php') {
            update_post_meta($bn_page->ID, '_wp_page_template', 'page-bapnuoc.php');
        }
    } else {
        $page_id = wp_insert_post(array(
            'post_title'   => 'Đặt Bắp Nước',
            'post_name'    => $bn_slug,
            'post_content' => '',
            'post_type'    => 'page',
            'post_status'  => 'publish',
        ));
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'page-bapnuoc.php');
        }
    }

    // 3. Ensure Checkout Page (WooCommerce)
    if (class_exists('WooCommerce')) {
        $checkout_slug = 'checkout';
        $checkout_page = get_page_by_path($checkout_slug);
        if (!$checkout_page) {
             $page_id = wp_insert_post(array(
                'post_title'   => 'Thanh toán',
                'post_name'    => $checkout_slug,
                'post_content' => '[woocommerce_checkout]',
                'post_type'    => 'page',
                'post_status'  => 'publish',
            ));
            if ($page_id && !is_wp_error($page_id)) {
                update_option('woocommerce_checkout_page_id', $page_id);
            }
        }
    }

    // 4. Debug CPT Page
    $debug_slug = 'debug-cpt';
    $debug_page = get_page_by_path($debug_slug);
    if (!$debug_page) {
        wp_insert_post(array(
            'post_title'   => 'Debug CPT',
            'post_name'    => $debug_slug,
            'post_content' => '',
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'page_template'=> 'page-debug-cpt.php'
        ));
    } else {
        $current_tpl = get_post_meta($debug_page->ID, '_wp_page_template', true);
        if ($current_tpl !== 'page-debug-cpt.php') {
            update_post_meta($debug_page->ID, '_wp_page_template', 'page-debug-cpt.php');
        }
    }

    // 5. Debug Showtimes Page
    $ds_slug = 'debug-showtimes';
    $ds_page = get_page_by_path($ds_slug);
    if (!$ds_page) {
        wp_insert_post(array(
            'post_title'   => 'Debug Showtimes',
            'post_name'    => $ds_slug,
            'post_content' => '',
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'page_template'=> 'page-debug-showtimes.php'
        ));
    } else {
        $current_tpl = get_post_meta($ds_page->ID, '_wp_page_template', true);
        if ($current_tpl !== 'page-debug-showtimes.php') {
            update_post_meta($ds_page->ID, '_wp_page_template', 'page-debug-showtimes.php');
        }
    }

    // 6. Showtime Schedule Page (Lịch Chiếu)
    $lc_slug = 'lich-chieu';
    $lc_page = get_page_by_path($lc_slug);
    if (!$lc_page) {
        wp_insert_post(array(
            'post_title'   => 'Lịch Chiếu',
            'post_name'    => $lc_slug,
            'post_content' => '',
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'page_template'=> 'page-lich-chieu.php'
        ));
    } else {
        $current_tpl = get_post_meta($lc_page->ID, '_wp_page_template', true);
        if ($current_tpl !== 'page-lich-chieu.php') {
            update_post_meta($lc_page->ID, '_wp_page_template', 'page-lich-chieu.php');
        }
    }
}, 10);

// Force cinema CPTs to be public and queryable using filter
add_filter('register_post_type_args', function($args, $post_type) {
    $targets = array('mbs_cinema', 'rap_phim', 'rap-phim');
    if (in_array($post_type, $targets, true)) {
        $args['public'] = true;
        $args['publicly_queryable'] = true;
        $args['show_ui'] = true;
        $args['exclude_from_search'] = false;
        $args['show_in_nav_menus'] = true;
        $args['has_archive'] = true;
        // Ensure slug is consistent
        if (!isset($args['rewrite']) || !is_array($args['rewrite'])) {
            $args['rewrite'] = array();
        }
        $args['rewrite']['slug'] = 'rap-phim';
        $args['rewrite']['with_front'] = false;
    }
    return $args;
}, 10, 2);

// Flush rewrite rules on init if needed
add_action('init', function() {
    if (get_option('mbs_cinema_rewrite_flushed_v3') !== 'yes') {
        flush_rewrite_rules();
        update_option('mbs_cinema_rewrite_flushed_v3', 'yes');
    }
}, 999);

// Force template for cinema CPT
add_filter('template_include', function($template) {
    if (is_singular()) {
        $pt = get_post_type();
        $cinema_pts = array('rap_phim','rap-phim','cinema','theater','mbs_cinema','rap','rapfilm','rap_phim_cpt');
        if (in_array($pt, $cinema_pts, true)) {
            $new_template = locate_template(array('single-mbs_cinema.php'));
            if ($new_template) {
                return $new_template;
            }
        }
    }
    return $template;
});

// Fix 404 for ?p=ID queries by expanding allowed post types
add_action('pre_get_posts', function($query) {
    if ( ! is_admin() && $query->is_main_query() && $query->get('p') ) {
        $query->set('post_type', array('post', 'page', 'mbs_cinema', 'rap_phim', 'rap-phim', 'mbs_movie'));
    }
});

//css header, footer in all page
function mytheme_global_styles() {
    // Header CSS
    wp_enqueue_style(
        'header-style',
        get_stylesheet_directory_uri() . '/header.css',
        array(),
        '1.0'
        
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

// Enqueue booking form JavaScript on front page
function mytheme_booking_form_scripts() {
    if ( is_front_page() ) {
        wp_enqueue_script(
            'booking-form',
            get_template_directory_uri() . '/js/booking-form.js',
            array('jquery'),
            '1.0',
            true
        );
        
        // Localize script with AJAX URL and nonce
        wp_localize_script('booking-form', 'bookingAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('booking_nonce'),
            'bookingPageUrl' => home_url('/datve/')
        ));
    }
}
add_action( 'wp_enqueue_scripts', 'mytheme_booking_form_scripts' );

// CSS cho trang khuyến mãi
function mytheme_promotions_styles() {
    global $post;
    $page_slug = is_page() ? get_post_field('post_name', get_the_ID()) : '';
    $is_promotions_page = is_page('khuyenmai') || 
                          is_page_template('page-khuyenmai.php') || 
                          $page_slug === 'khuyenmai' ||
                          (isset($post) && $post->post_name === 'khuyenmai');
    
    if ( $is_promotions_page ) {
        wp_enqueue_style(
            'mytheme-promotions-style',
            get_stylesheet_directory_uri() . '/promotions.css',
            array('header-style', 'footer-style'),
            '1.2'
        );
        // Add body class
        add_filter('body_class', function($classes) {
            $classes[] = 'promotions-page';
            return $classes;
        });
    }
}
add_action( 'wp_enqueue_scripts', 'mytheme_promotions_styles', 20 );

// CSS cho trang tổ chức sự kiện
function mytheme_events_styles() {
    global $post;
    $page_slug = is_page() ? get_post_field('post_name', get_the_ID()) : '';
    $is_events_page = is_page('tochucsukien') || 
                      is_page_template('page-tochucsukien.php') || 
                      $page_slug === 'tochucsukien' ||
                      (isset($post) && $post->post_name === 'tochucsukien');
    
    if ( $is_events_page ) {
        wp_enqueue_style(
            'mytheme-events-style',
            get_stylesheet_directory_uri() . '/events.css',
            array('header-style', 'footer-style'),
            '1.0'
        );
        // Add body class
        add_filter('body_class', function($classes) {
            $classes[] = 'events-page';
            return $classes;
        });
    }
}
add_action( 'wp_enqueue_scripts', 'mytheme_events_styles', 20 );

// CSS cho trang giới thiệu
function mytheme_about_styles() {
    global $post;
    $page_slug = is_page() ? get_post_field('post_name', get_the_ID()) : '';
    $is_about_page = is_page('gioithieu') || 
                     is_page_template('page-gioithieu.php') || 
                     $page_slug === 'gioithieu' ||
                     (isset($post) && $post->post_name === 'gioithieu');
    
    if ( $is_about_page ) {
        wp_enqueue_style(
            'mytheme-about-style',
            get_stylesheet_directory_uri() . '/about.css',
            array('header-style', 'footer-style'),
            '1.0'
        );
        // Add body class
        add_filter('body_class', function($classes) {
            $classes[] = 'about-page';
            return $classes;
        });
    }
}
add_action( 'wp_enqueue_scripts', 'mytheme_about_styles', 20 );

function mytheme_enqueue_header_scripts() {
    $script_file = get_stylesheet_directory() . '/script.js';
    if (file_exists($script_file)) {
        // Enqueue với jquery dependency để đảm bảo hoạt động trên cả front page và các trang khác
        wp_enqueue_script(
            'mytheme-header-script',
            get_stylesheet_directory_uri() . '/script.js',
            array('jquery'), // phụ thuộc jquery
            filemtime($script_file),
            true // load ở footer
        );
    }
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_header_scripts');

// css in file single-movie.php
function mytheme_single_movie_styles() {
    if ( movie_theme_is_movie_singular() ) {
        wp_enqueue_style(
            'single-movie-style',
            get_stylesheet_directory_uri() . '/single-movie.css',
            array('header-style', 'footer-style'),
            filemtime(get_stylesheet_directory() . '/single-movie.css')
        );
    }
}
add_action('wp_enqueue_scripts', 'mytheme_single_movie_styles');

// Script riêng cho trang chi tiết phim (single-movie.php)
function mytheme_single_movie_scripts() {
    if ( movie_theme_is_movie_singular() ) {
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
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cns_action'])) {
        // Handle Login
        if ($_POST['cns_action'] === 'login') {
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
        
        // Handle Registration
        if ($_POST['cns_action'] === 'register') {
            $error_message = '';
            $success_message = '';
            
            // Validate nonce
            if (! isset($_POST['cns_register_nonce']) || ! wp_verify_nonce($_POST['cns_register_nonce'], 'cns_auth_register')) {
                $error_message = __('Phiên không hợp lệ, vui lòng thử lại.', 'movie-theme');
            } else {
                // Get form data
                $full_name = isset($_POST['full_name']) ? sanitize_text_field(wp_unslash($_POST['full_name'])) : '';
                $birthday = isset($_POST['birthday']) ? sanitize_text_field(wp_unslash($_POST['birthday'])) : '';
                $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
                $user_login = isset($_POST['user_login']) ? sanitize_user(wp_unslash($_POST['user_login'])) : '';
                $national_id = isset($_POST['national_id']) ? sanitize_text_field(wp_unslash($_POST['national_id'])) : '';
                $user_email = isset($_POST['user_email']) ? sanitize_email(wp_unslash($_POST['user_email'])) : '';
                $user_pass = isset($_POST['user_pass']) ? (string) $_POST['user_pass'] : '';
                $user_pass_confirm = isset($_POST['user_pass_confirm']) ? (string) $_POST['user_pass_confirm'] : '';
                $agree = isset($_POST['agree']);
                
                // Validation
                if (empty($full_name)) {
                    $error_message = __('Vui lòng nhập họ và tên.', 'movie-theme');
                } elseif (empty($birthday)) {
                    $error_message = __('Vui lòng chọn ngày sinh.', 'movie-theme');
                } elseif ($birthday) {
                    $birthday_timestamp = strtotime($birthday);
                    $today_timestamp = time();
                    if ($birthday_timestamp === false || $birthday_timestamp > $today_timestamp) {
                        $error_message = __('Ngày sinh không hợp lệ.', 'movie-theme');
                    } else {
                        $age = floor(($today_timestamp - $birthday_timestamp) / (365.25 * 24 * 60 * 60));
                        if ($age < 6) {
                            $error_message = __('Bạn phải từ 6 tuổi trở lên để đăng ký tài khoản.', 'movie-theme');
                        } elseif ($age > 120) {
                            $error_message = __('Ngày sinh không hợp lệ.', 'movie-theme');
                        }
                    }
                }
                
                if (empty($error_message) && empty($phone)) {
                    $error_message = __('Vui lòng nhập số điện thoại.', 'movie-theme');
                } elseif (empty($error_message) && !preg_match('/^(\+84|0)[0-9]{9,10}$/', preg_replace('/\s+/', '', $phone))) {
                    $error_message = __('Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam (10-11 số).', 'movie-theme');
                } elseif (empty($error_message) && empty($user_login)) {
                    $error_message = __('Vui lòng nhập tên đăng nhập.', 'movie-theme');
                } elseif (empty($error_message) && strlen($user_login) < 4) {
                    $error_message = __('Tên đăng nhập phải có ít nhất 4 ký tự.', 'movie-theme');
                } elseif (empty($error_message) && ! validate_username($user_login)) {
                    $error_message = __('Tên đăng nhập không hợp lệ. Chỉ được dùng chữ cái, số và dấu gạch dưới.', 'movie-theme');
                } elseif (empty($error_message) && username_exists($user_login)) {
                    $error_message = __('Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.', 'movie-theme');
                } elseif (empty($error_message) && empty($user_email)) {
                    $error_message = __('Vui lòng nhập email.', 'movie-theme');
                } elseif (empty($error_message) && ! is_email($user_email)) {
                    $error_message = __('Email không hợp lệ.', 'movie-theme');
                } elseif (empty($error_message) && email_exists($user_email)) {
                    $error_message = __('Email đã được sử dụng. Vui lòng sử dụng email khác hoặc đăng nhập.', 'movie-theme');
                } elseif (empty($error_message) && empty($user_pass)) {
                    $error_message = __('Vui lòng nhập mật khẩu.', 'movie-theme');
                } elseif (empty($error_message) && strlen($user_pass) < 6) {
                    $error_message = __('Mật khẩu phải có ít nhất 6 ký tự.', 'movie-theme');
                } elseif (empty($error_message) && $user_pass !== $user_pass_confirm) {
                    $error_message = __('Mật khẩu xác nhận không khớp.', 'movie-theme');
                } elseif (empty($error_message) && ! $agree) {
                    $error_message = __('Vui lòng đồng ý với các điều khoản và điều kiện.', 'movie-theme');
                } elseif (empty($error_message)) {
                    // Create user
                    $user_id = wp_create_user($user_login, $user_pass, $user_email);
                    
                    if (is_wp_error($user_id)) {
                        $error_message = $user_id->get_error_message();
                    } else {
                        // Update user meta
                        wp_update_user(array(
                            'ID' => $user_id,
                            'display_name' => $full_name
                        ));
                        
                        update_user_meta($user_id, 'phone', $phone);
                        update_user_meta($user_id, 'birthday', $birthday);
                        if (!empty($national_id)) {
                            update_user_meta($user_id, 'national_id', $national_id);
                        }
                        
                        // Auto login
                        wp_set_current_user($user_id);
                        wp_set_auth_cookie($user_id);
                        
                        // Redirect to profile or home
                        $redirect_to = home_url('/profile');
                        wp_safe_redirect($redirect_to);
                        exit;
                    }
                }
            }
            
            // Redirect back with error/success message
            $referer = wp_get_referer();
            if (! $referer) {
                $referer = home_url('/dangnhap');
            }
            
            if ($error_message) {
                $key = wp_generate_password(12, false);
                set_transient('cns_register_err_' . $key, $error_message, 60);
                $url = add_query_arg(array('tab' => 'register', 'cnsre' => $key), $referer);
            } else {
                $key = wp_generate_password(12, false);
                set_transient('cns_register_ok_' . $key, $success_message ?: __('Đăng ký thành công!', 'movie-theme'), 60);
                $url = add_query_arg(array('tab' => 'register', 'cnsro' => $key), $referer);
            }
            
            wp_safe_redirect($url);
            exit;
        }
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

function movie_render_order_summary($order_id, $is_email = false){
    $movie_id  = intval(get_post_meta($order_id,'movie_id',true));
    $cinema_id = intval(get_post_meta($order_id,'cinema_id',true));
    $date      = esc_html(get_post_meta($order_id,'show_date',true));
    $time      = esc_html(get_post_meta($order_id,'show_time',true));
    $seats     = (array) get_post_meta($order_id,'seats',true);
    $total     = floatval(get_post_meta($order_id,'total',true));
    $user_id   = intval(get_post_meta($order_id,'user_id',true));
    
    // Lấy thông tin user
    $user_name = '';
    $user_email = '';
    if ($user_id) {
        $user = get_userdata($user_id);
        if ($user) {
            $user_name = $user->display_name ?: $user->user_login;
            $user_email = $user->user_email;
        }
    }
    
    // Lấy poster phim
    $movie_poster = get_the_post_thumbnail_url($movie_id, 'medium');
    
    if ($is_email) {
        // Template email đẹp hơn
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0; }
                .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; }
                .email-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 20px; text-align: center; }
                .email-header h1 { color: #ffffff; margin: 0; font-size: 28px; }
                .email-body { padding: 30px 20px; }
                .success-badge { background-color: #10b981; color: white; padding: 8px 16px; border-radius: 20px; display: inline-block; font-weight: bold; margin-bottom: 20px; }
                .order-info { background-color: #f9fafb; border-left: 4px solid #667eea; padding: 20px; margin: 20px 0; border-radius: 4px; }
                .info-row { margin: 12px 0; display: flex; }
                .info-label { font-weight: bold; color: #4b5563; min-width: 120px; }
                .info-value { color: #111827; }
                .seats-list { background-color: #eff6ff; padding: 15px; border-radius: 8px; margin: 15px 0; }
                .seat-badge { display: inline-block; background-color: #3b82f6; color: white; padding: 6px 12px; margin: 4px; border-radius: 6px; font-weight: bold; }
                .total-price { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0; }
                .total-price .label { font-size: 14px; opacity: 0.9; }
                .total-price .amount { font-size: 32px; font-weight: bold; margin-top: 5px; }
                .qr-code { text-align: center; margin: 30px 0; padding: 20px; background-color: #f9fafb; border-radius: 8px; }
                .qr-code img { max-width: 200px; border: 3px solid #e5e7eb; border-radius: 8px; }
                .movie-poster { text-align: center; margin: 20px 0; }
                .movie-poster img { max-width: 200px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                .email-footer { background-color: #f9fafb; padding: 20px; text-align: center; color: #6b7280; font-size: 12px; border-top: 1px solid #e5e7eb; }
                .email-footer a { color: #667eea; text-decoration: none; }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-header">
                    <h1>🎬 Đặt Vé Thành Công!</h1>
                </div>
                <div class="email-body">
                    <div class="success-badge">✓ Đơn hàng đã được xác nhận</div>
                    
                    <p>Xin chào <strong>' . esc_html($user_name) . '</strong>,</p>
                    <p>Cảm ơn bạn đã đặt vé tại hệ thống của chúng tôi. Đơn hàng của bạn đã được xác nhận thành công!</p>
                    
                    <div class="order-info">
                        <h2 style="margin-top: 0; color: #667eea;">Thông tin đơn vé #' . $order_id . '</h2>';
        
        if ($movie_poster) {
            $html .= '<div class="movie-poster"><img src="' . esc_url($movie_poster) . '" alt="' . esc_attr(get_the_title($movie_id)) . '"></div>';
        }
        
        $html .= '
                        <div class="info-row">
                            <span class="info-label">Phim:</span>
                            <span class="info-value">' . esc_html(get_the_title($movie_id)) . '</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Rạp chiếu:</span>
                            <span class="info-value">' . esc_html(get_the_title($cinema_id)) . '</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Ngày chiếu:</span>
                            <span class="info-value">' . $date . '</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Giờ chiếu:</span>
                            <span class="info-value">' . $time . '</span>
                        </div>
                    </div>
                    
                    <div class="seats-list">
                        <strong style="display: block; margin-bottom: 10px; color: #1e40af;">Ghế đã đặt:</strong>';
        
        foreach ($seats as $seat) {
            $html .= '<span class="seat-badge">' . esc_html($seat) . '</span>';
        }
        
        $html .= '
                    </div>
                    
                    <div class="total-price">
                        <div class="label">Tổng thanh toán</div>
                        <div class="amount">' . number_format($total, 0, ',', '.') . ' đ</div>
                    </div>
                    
                    <div class="qr-code">
                        <p style="margin-bottom: 10px; font-weight: bold; color: #4b5563;">Mã QR đơn hàng:</p>
                        <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . urlencode(home_url('/?order='.$order_id)) . '" alt="QR Code">
                        <p style="margin-top: 10px; font-size: 12px; color: #6b7280;">Vui lòng xuất trình mã QR này khi đến rạp</p>
                    </div>
                    
                    <p style="margin-top: 30px; padding: 15px; background-color: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 4px;">
                        <strong>📌 Lưu ý:</strong> Vui lòng đến rạp trước giờ chiếu ít nhất 15 phút để làm thủ tục. Mang theo mã QR hoặc số đơn hàng #' . $order_id . ' để nhận vé.
                    </p>
                </div>
                <div class="email-footer">
                    <p>Nếu có thắc mắc, vui lòng liên hệ với chúng tôi.</p>
                    <p><a href="' . esc_url(home_url()) . '">Xem trang web</a> | <a href="' . esc_url(home_url('/profile?tab=booking-history')) . '">Xem lịch sử đặt vé</a></p>
                    <p style="margin-top: 15px;">© ' . date('Y') . ' - Hệ thống đặt vé xem phim</p>
                </div>
            </div>
        </body>
        </html>';
    } else {
        // Template hiển thị trên web (giữ nguyên format cũ)
        $html  = '<h2>Thông tin đơn vé #' . $order_id . '</h2>';
        $html .= '<p><strong>Phim:</strong> '. esc_html(get_the_title($movie_id)) .'</p>';
        $html .= '<p><strong>Rạp:</strong> '. esc_html(get_the_title($cinema_id)) .'</p>';
        $html .= '<p><strong>Ngày/giờ:</strong> '. $date .' '. $time .'</p>';
        $html .= '<p><strong>Ghế:</strong> '. esc_html(implode(', ',$seats)) .'</p>';
        $html .= '<p><strong>Tổng tiền:</strong> '. number_format($total,0,',','.') .'đ</p>';
        $qr_data = home_url('/?order='.$order_id);
        $qr_url  = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . urlencode($qr_data);
        $html .= '<p><img alt="QR" src="'.$qr_url.'" style="max-width:200px"></p>';
    }
    
    return $html;
}

add_action('wp_ajax_create_ticket_order', 'movie_create_ticket_order');
add_action('wp_ajax_nopriv_create_ticket_order', 'movie_create_ticket_order');
function movie_create_ticket_order() {
    check_ajax_referer('ticket_order_nonce', 'nonce');

    // Kiểm tra đăng nhập
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Bạn cần vui lòng đăng nhập để đặt vé.'));
    }

    $movie_id  = isset($_POST['movie_id'])  ? intval($_POST['movie_id'])  : 0;
    $cinema_id = isset($_POST['cinema_id']) ? intval($_POST['cinema_id']) : 0;
    $date      = isset($_POST['date'])      ? sanitize_text_field($_POST['date']) : '';
    $time      = isset($_POST['time'])      ? sanitize_text_field($_POST['time']) : '';
    $seats     = isset($_POST['seats'])     ? (array) $_POST['seats'] : array();
    $food_items = isset($_POST['food_items']) ? (array) $_POST['food_items'] : array();

    if (!$movie_id || !$cinema_id || empty($date) || empty($time) || empty($seats)) {
        wp_send_json_error(array('message' => 'Thiếu dữ liệu.'));
    }

    // Calculate total including food
    $ticket_price = 95000;
    $total = count($seats) * $ticket_price;
    $calculated_total = $total; // Start with ticket total
    
    // Add food cost
    $food_cart_data = array();
    if (!empty($food_items)) {
        foreach ($food_items as $pid => $qty) {
            $qty = intval($qty);
            if ($qty > 0) {
                $product = wc_get_product($pid);
                if ($product) {
                    $price = $product->get_price();
                    $calculated_total += $qty * $price;
                    $food_cart_data[$pid] = $qty;
                }
            }
        }
    }
    
    // Use calculated total
    $total = $calculated_total;

    // Kiểm tra WooCommerce có active không
    if (class_exists('WooCommerce')) {
        // Tạo hoặc lấy sản phẩm vé phim (sử dụng SKU để tìm sản phẩm có sẵn)
        $product_sku = 'ticket-movie-' . $movie_id;
        $product_id = wc_get_product_id_by_sku($product_sku);
        
        if (!$product_id) {
            // Tạo sản phẩm mới nếu chưa có
            $product = new WC_Product_Simple();
            $product->set_name('Vé xem phim');
            $product->set_sku($product_sku);
            $product->set_price(95000); // Base price
            $product->set_regular_price(95000);
            $product->set_virtual(true);
            $product->set_downloadable(false);
            $product->set_manage_stock(false);
            $product_id = $product->save();
        }

        // Xóa giỏ hàng cũ (nếu có)
        WC()->cart->empty_cart();

        // Lưu thông tin đặt vé vào session để dùng sau
        WC()->session->set('ticket_booking_data', array(
            'movie_id'  => $movie_id,
            'cinema_id' => $cinema_id,
            'date'      => $date,
            'time'      => $time,
            'seats'     => $seats,
            'food_items'=> $food_cart_data,
            'total'     => $total,
        ));

        // Lưu payment method được chọn vào session
        if ($method === 'credit_card') {
            WC()->session->set('chosen_payment_method', 'credit_card');
        }

        // Thêm sản phẩm VÉ vào giỏ hàng với giá động
        // Calculate ticket only total
        $ticket_total = count($seats) * 95000; // Assuming fixed price for now
        
        $cart_item_key = WC()->cart->add_to_cart($product_id, 1, 0, array(), array(
            'ticket_data' => array(
                'movie_id'  => $movie_id,
                'cinema_id' => $cinema_id,
                'date'      => $date,
                'time'      => $time,
                'seats'     => $seats,
            )
        ));

        if (!$cart_item_key) {
            wp_send_json_error(array('message' => 'Không thể thêm vào giỏ hàng.'));
        }

        // Cập nhật giá cho item VÉ trong giỏ hàng
        foreach (WC()->cart->get_cart() as $cart_key => $cart_item) {
            if ($cart_key === $cart_item_key) {
                $cart_item['data']->set_price($ticket_total);
                break;
            }
        }
        
        // Thêm sản phẩm BẮP NƯỚC vào giỏ hàng
        if (!empty($food_cart_data)) {
            foreach ($food_cart_data as $pid => $qty) {
                WC()->cart->add_to_cart($pid, $qty);
            }
        }
        
        WC()->cart->calculate_totals();

        // Redirect đến checkout
        // Đảm bảo trang checkout tồn tại
        $checkout_page = get_page_by_path('checkout');
        if (!$checkout_page) {
            // Tạo trang checkout ngay lập tức
            $page_id = wp_insert_post(array(
                'post_title'   => 'Thanh toán',
                'post_name'    => 'checkout',
                'post_content' => '[woocommerce_checkout]',
                'post_type'    => 'page',
                'post_status'  => 'publish',
            ));
            if ($page_id && !is_wp_error($page_id)) {
                // Set template nếu có
                $template_file = get_stylesheet_directory() . '/page-checkout.php';
                if (file_exists($template_file)) {
                    update_post_meta($page_id, '_wp_page_template', 'page-checkout.php');
                }
                update_option('woocommerce_checkout_page_id', $page_id);
                $checkout_page = get_post($page_id);
                flush_rewrite_rules(false);
                
                // Log để debug
                error_log('Movie Theme: Created checkout page with ID: ' . $page_id);
            }
        } else {
            // Đảm bảo WooCommerce biết trang này
            update_option('woocommerce_checkout_page_id', $checkout_page->ID);
        }
        
        // Lấy URL checkout
        if ($checkout_page) {
            $checkout_url = get_permalink($checkout_page->ID);
        } else {
            // Fallback: dùng wc_get_checkout_url() hoặc tạo URL thủ công
            $checkout_url = wc_get_checkout_url();
            if (!$checkout_url || $checkout_url === home_url('/')) {
                $checkout_url = home_url('/checkout/');
            }
        }
        
        // Nếu chọn thẻ tín dụng, thêm parameter để highlight
        if ($method === 'credit_card') {
            $checkout_url = add_query_arg('payment_method', 'credit_card', $checkout_url);
        }

        wp_send_json_success(array(
            'message'  => 'Đang chuyển đến trang thanh toán...',
            'redirect' => $checkout_url,
        ));
    } else {
        // Fallback: Tạo order cũ nếu không có WooCommerce
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
        update_post_meta($order_id, 'status',    'completed');

        // Đồng bộ sang plugin Movie Booking System
    global $wpdb; 
    $booking_table = $wpdb->prefix . 'mbs_bookings';
    $seats_table   = $wpdb->prefix . 'mbs_seats';

    $user   = wp_get_current_user();
    // Lấy tên khách hàng: ưu tiên display_name, nếu không có thì dùng user_login
    $u_name = '';
    if ($user) {
        $u_name = $user->display_name ?: $user->user_login;
        // Nếu có full name trong user meta, dùng nó
        $full_name = get_user_meta($user->ID, 'full_name', true);
        if (!empty($full_name)) {
            $u_name = $full_name;
        }
    }
    // Nếu vẫn không có, dùng giá trị mặc định
    if (empty($u_name)) {
        $u_name = 'Khách hàng';
    }
    
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
        // Đảm bảo cột seat_code tồn tại trước khi insert
        movie_theme_ensure_seat_code_column();
        
        // Debug: log số lượng ghế
        error_log('Movie Booking: Inserting ' . count($seats) . ' seats for booking ID: ' . $mbs_booking_id);
        
        foreach ( $seats as $s ) {
            $result = $wpdb->insert($seats_table, array(
                'booking_id' => $mbs_booking_id,
                'seat_code'  => sanitize_text_field($s)
            ), array('%d','%s'));
            
            if ($result === false) {
                error_log('Movie Booking: Failed to insert seat ' . $s . ' - ' . $wpdb->last_error);
            } else {
                error_log('Movie Booking: Successfully inserted seat ' . $s);
            }
        }
    }

        // Gửi email xác nhận
    if ($user && $user->user_email) {
        $subject = '🎬 Xác nhận đặt vé thành công - Đơn hàng #' . $order_id;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $body    = movie_render_order_summary($order_id, true); // true = is_email
        
        // Log để debug
        error_log('Movie Booking: Attempting to send email to ' . $user->user_email . ' for order #' . $order_id);
        
        $mail_result = wp_mail($user->user_email, $subject, $body, $headers);
        
        if ($mail_result) {
            error_log('Movie Booking: Email sent successfully to ' . $user->user_email);
            update_post_meta($order_id, '_email_sent', 'yes');
        } else {
            error_log('Movie Booking: Failed to send email to ' . $user->user_email);
            // Lưu email vào log file để có thể gửi lại sau
            $email_log = get_option('movie_booking_email_queue', array());
            $email_log[] = array(
                'order_id' => $order_id,
                'email' => $user->user_email,
                'subject' => $subject,
                'body' => $body,
                'time' => current_time('mysql')
            );
            update_option('movie_booking_email_queue', $email_log);
        }
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

// Load custom payment gateway
add_action('plugins_loaded', 'movie_init_credit_card_gateway', 5);
add_action('init', 'movie_init_credit_card_gateway', 5);
add_action('woocommerce_init', 'movie_init_credit_card_gateway', 5);
function movie_init_credit_card_gateway() {
    if (!class_exists('WC_Payment_Gateway')) {
        return;
    }

    $gateway_file = get_stylesheet_directory() . '/includes/class-wc-gateway-credit-card.php';
    if (file_exists($gateway_file) && !class_exists('WC_Gateway_Credit_Card')) {
        require_once $gateway_file;
    }
}

// Register custom payment gateway
add_filter('woocommerce_payment_gateways', 'movie_add_credit_card_gateway', 10, 1);
function movie_add_credit_card_gateway($gateways) {
    if (!class_exists('WC_Gateway_Credit_Card')) {
        movie_init_credit_card_gateway();
    }
    
    if (class_exists('WC_Gateway_Credit_Card')) {
        // Kiểm tra xem đã có trong danh sách chưa
        $found = false;
        foreach ($gateways as $gateway) {
            if (is_string($gateway) && $gateway === 'WC_Gateway_Credit_Card') {
                $found = true;
                break;
            } elseif (is_object($gateway) && $gateway instanceof WC_Gateway_Credit_Card) {
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $gateways[] = 'WC_Gateway_Credit_Card';
        }
    }
    
    return $gateways;
}

// Tự động enable payment gateway credit_card khi theme được kích hoạt
add_action('after_switch_theme', 'movie_auto_enable_credit_card_gateway');
add_action('init', 'movie_auto_enable_credit_card_gateway', 20);
add_action('wp_loaded', 'movie_auto_enable_credit_card_gateway', 20);
add_action('woocommerce_init', 'movie_auto_enable_credit_card_gateway', 20);
add_action('woocommerce_settings_saved', 'movie_auto_enable_credit_card_gateway');
function movie_auto_enable_credit_card_gateway() {
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    // Đảm bảo gateway class được load
    if (!class_exists('WC_Gateway_Credit_Card')) {
        movie_init_credit_card_gateway();
    }
    
    $settings = get_option('woocommerce_credit_card_settings', array());
    
    // Kiểm tra và set default settings
    $needs_update = false;
    
    if (empty($settings)) {
        $settings = array();
        $needs_update = true;
    }
    
    // Set các giá trị mặc định nếu chưa có
    if (!isset($settings['enabled']) || $settings['enabled'] !== 'yes') {
        $settings['enabled'] = 'yes';
        $needs_update = true;
    }
    
    if (!isset($settings['title']) || empty($settings['title'])) {
        $settings['title'] = 'Thẻ tín dụng/Ghi nợ';
        $needs_update = true;
    }
    
    if (!isset($settings['description']) || empty($settings['description'])) {
        $settings['description'] = 'Thanh toán bằng thẻ Visa, Mastercard, JCB, hoặc thẻ ghi nợ';
        $needs_update = true;
    }
    
    if (!isset($settings['testmode'])) {
        $settings['testmode'] = 'yes';
        $needs_update = true;
    }
    
    if ($needs_update) {
        update_option('woocommerce_credit_card_settings', $settings);
        // Clear WooCommerce cache
        delete_transient('woocommerce_payment_gateways');
        if (function_exists('wc_delete_product_transients')) {
            wc_delete_product_transients();
        }
    }
    
    // Force enable gateway instance nếu có
    if (class_exists('WC_Gateway_Credit_Card') && WC()->payment_gateways) {
        $gateways = WC()->payment_gateways->payment_gateways();
        if (isset($gateways['credit_card'])) {
            $gateways['credit_card']->enabled = 'yes';
            $gateways['credit_card']->update_option('enabled', 'yes');
        }
    }
}

// Đảm bảo payment gateway được hiển thị trên checkout
add_filter('woocommerce_available_payment_gateways', 'movie_ensure_credit_card_gateway_available', 999, 1);
function movie_ensure_credit_card_gateway_available($available_gateways) {
    if (!class_exists('WooCommerce')) {
        return $available_gateways;
    }
    
    // Kiểm tra xem credit_card gateway có trong danh sách không
    if (!isset($available_gateways['credit_card'])) {
        // Thử load lại gateway
        $gateways = WC()->payment_gateways->payment_gateways();
        if (isset($gateways['credit_card'])) {
            $gateway = $gateways['credit_card'];
            // Force enable và available
            $gateway->enabled = 'yes';
            // Đảm bảo gateway được enable
            if ($gateway->enabled === 'yes') {
                // Force add vào available gateways
                $available_gateways['credit_card'] = $gateway;
            }
        } else {
            // Nếu gateway chưa được register, thử register lại
            if (class_exists('WC_Gateway_Credit_Card')) {
                $gateway = new WC_Gateway_Credit_Card();
                $gateway->enabled = 'yes';
                $available_gateways['credit_card'] = $gateway;
            }
        }
    } else {
        // Đảm bảo gateway vẫn enabled
        $available_gateways['credit_card']->enabled = 'yes';
    }
    
    // Đảm bảo luôn có ít nhất 1 payment method
    if (empty($available_gateways)) {
        // Nếu không có payment method nào, force add credit_card
        if (class_exists('WC_Gateway_Credit_Card')) {
            $gateway = new WC_Gateway_Credit_Card();
            $gateway->enabled = 'yes';
            $available_gateways['credit_card'] = $gateway;
        }
    }
    
    return $available_gateways;
}

// Validate payment method khi checkout được process
add_action('woocommerce_checkout_process', 'movie_validate_payment_method');
function movie_validate_payment_method() {
    if (!class_exists('WooCommerce') || !WC()->session) {
        return;
    }
    
    $chosen_method = WC()->session->get('chosen_payment_method');
    if ($chosen_method === 'credit_card') {
        // Đảm bảo payment gateway credit_card có sẵn
        $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
        if (!isset($available_gateways['credit_card'])) {
            // Nếu gateway không available, xóa session và thêm notice
            WC()->session->__unset('chosen_payment_method');
            wc_add_notice(__('Phương thức thanh toán không khả dụng. Vui lòng chọn phương thức khác.', 'movie-theme'), 'error');
        }
    }
}

// Enqueue styles and scripts for credit card gateway
add_action('wp_enqueue_scripts', 'movie_credit_card_gateway_scripts');
function movie_credit_card_gateway_scripts() {
    // Kiểm tra xem WooCommerce có được load và function is_checkout() có tồn tại không
    if (!function_exists('is_checkout')) {
        return;
    }
    
    if (is_checkout()) {
        wp_enqueue_style(
            'movie-credit-card-gateway',
            get_stylesheet_directory_uri() . '/assets/css/credit-card-gateway.css',
            array(),
            '1.0'
        );
        wp_enqueue_script(
            'movie-credit-card-gateway',
            get_stylesheet_directory_uri() . '/assets/js/credit-card-gateway.js',
            array('jquery'),
            '1.0',
            true
        );
    }
}

// Hook: Lưu thông tin đặt vé vào WooCommerce order khi checkout
add_action('woocommerce_checkout_create_order_line_item', 'movie_save_ticket_data_to_order_item', 10, 4);
function movie_save_ticket_data_to_order_item($item, $cart_item_key, $values, $order) {
    if (isset($values['ticket_data'])) {
        $ticket_data = $values['ticket_data'];
        $item->add_meta_data('_ticket_movie_id', $ticket_data['movie_id']);
        $item->add_meta_data('_ticket_cinema_id', $ticket_data['cinema_id']);
        $item->add_meta_data('_ticket_date', $ticket_data['date']);
        $item->add_meta_data('_ticket_time', $ticket_data['time']);
        $item->add_meta_data('_ticket_seats', $ticket_data['seats']);
        $order->update_meta_data('_is_ticket_order', 'yes');
    }
}

// Redirect về trang order-success sau khi thanh toán thành công
add_filter('woocommerce_payment_successful_result', 'movie_redirect_to_success_page', 10, 2);
function movie_redirect_to_success_page($result, $order_id) {
    if (isset($result['result']) && $result['result'] === 'success') {
        // Đảm bảo ticket_order được tạo trước khi redirect
        // Hook này chạy sau khi payment complete, nên ticket_order đã được tạo
        $wc_order = wc_get_order($order_id);
        if ($wc_order) {
            $ticket_order_id = $wc_order->get_meta('_ticket_order_id');
            
            $success_page = get_page_by_path('order-success');
            $success_url = $success_page ? get_permalink($success_page->ID) : home_url('/order-success/');
            
            // Ưu tiên dùng ticket_order_id nếu có
            if ($ticket_order_id) {
                $success_url = add_query_arg('order_id', $ticket_order_id, $success_url);
            }
            // Luôn thêm wc_order_id để trang success có thể lấy thông tin
            $success_url = add_query_arg('wc_order_id', $order_id, $success_url);
            
            $result['redirect'] = $success_url;
        }
    }
    return $result;
}

// Hook: Tạo ticket_order sau khi WooCommerce order thanh toán thành công
// Priority cao để đảm bảo chạy trước redirect
add_action('woocommerce_payment_complete', 'movie_create_ticket_from_wc_order', 5, 1);
add_action('woocommerce_thankyou', 'movie_create_ticket_from_wc_order', 10, 1);
function movie_create_ticket_from_wc_order($order_id) {
    if (!class_exists('WooCommerce')) {
        return;
    }

    $order = wc_get_order($order_id);
    if (!$order) {
        return;
    }

    // Kiểm tra xem có phải là order đặt vé không
    $is_ticket_order = $order->get_meta('_is_ticket_order');
    if ($is_ticket_order !== 'yes') {
        return;
    }

    // Kiểm tra xem đã tạo ticket_order chưa
    $existing_ticket_id = $order->get_meta('_ticket_order_id');
    if ($existing_ticket_id) {
        return; // Đã tạo rồi
    }

    // Lấy thông tin từ order items
    $movie_id = 0;
    $cinema_id = 0;
    $date = '';
    $time = '';
    $seats = array();
    
    foreach ($order->get_items() as $item) {
        $movie_id  = intval($item->get_meta('_ticket_movie_id'));
        $cinema_id = intval($item->get_meta('_ticket_cinema_id'));
        $date      = $item->get_meta('_ticket_date');
        $time      = $item->get_meta('_ticket_time');
        $seats     = (array) $item->get_meta('_ticket_seats');
        break; // Lấy từ item đầu tiên
    }
    
    $total = floatval($order->get_total());

    if (!$movie_id || !$cinema_id || empty($date) || empty($time) || empty($seats)) {
        return;
    }

    // Tạo ticket_order
    $order_title = sprintf('Vé %s - %s %s', get_the_title($movie_id), $date, $time);
    $ticket_order_id = wp_insert_post(array(
        'post_type'   => 'ticket_order',
        'post_status' => 'publish',
        'post_title'  => $order_title,
    ));

    if (is_wp_error($ticket_order_id) || !$ticket_order_id) {
        return;
    }

    // Lưu thông tin
    update_post_meta($ticket_order_id, 'movie_id',  $movie_id);
    update_post_meta($ticket_order_id, 'cinema_id', $cinema_id);
    update_post_meta($ticket_order_id, 'show_date', $date);
    update_post_meta($ticket_order_id, 'show_time', $time);
    update_post_meta($ticket_order_id, 'seats',     array_map('sanitize_text_field', $seats));
    update_post_meta($ticket_order_id, 'total',     $total);
    update_post_meta($ticket_order_id, 'user_id',   $order->get_user_id());
    update_post_meta($ticket_order_id, 'wc_order_id', $order_id);
    update_post_meta($ticket_order_id, 'status',    'completed');

    // Lưu ticket_order_id vào WooCommerce order
    $order->update_meta_data('_ticket_order_id', $ticket_order_id);
    $order->save();

    // Đồng bộ sang plugin Movie Booking System
    global $wpdb; 
    $booking_table = $wpdb->prefix . 'mbs_bookings';
    $seats_table   = $wpdb->prefix . 'mbs_seats';

    // Lấy tên khách hàng: ưu tiên billing info, nếu không có thì lấy từ user
    $u_name = $order->get_billing_first_name() ?: $order->get_billing_company();
    if (empty($u_name)) {
        $user_id = $order->get_user_id();
        if ($user_id) {
            $user = get_userdata($user_id);
            if ($user) {
                $u_name = $user->display_name ?: $user->user_login;
            }
        }
    }
    // Nếu vẫn không có, dùng billing full name
    if (empty($u_name)) {
        $u_name = trim($order->get_billing_first_name() . ' ' . $order->get_billing_last_name());
    }
    // Cuối cùng, nếu vẫn không có, dùng email
    if (empty($u_name)) {
        $u_name = $order->get_billing_email() ?: 'Khách hàng';
    }
    
    $u_mail = $order->get_billing_email();
    $u_phone= $order->get_billing_phone();

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
        // Đảm bảo cột seat_code tồn tại trước khi insert
        movie_theme_ensure_seat_code_column();
        
        // Debug: log số lượng ghế
        error_log('Movie Booking (WC): Inserting ' . count($seats) . ' seats for booking ID: ' . $mbs_booking_id);
        
        foreach ( $seats as $s ) {
            $result = $wpdb->insert($seats_table, array(
                'booking_id' => $mbs_booking_id,
                'seat_code'  => sanitize_text_field($s)
            ), array('%d','%s'));
            
            if ($result === false) {
                error_log('Movie Booking (WC): Failed to insert seat ' . $s . ' - ' . $wpdb->last_error);
            } else {
                error_log('Movie Booking (WC): Successfully inserted seat ' . $s);
            }
        }
    }

    // Gửi email xác nhận
    if ($u_mail) {
        // Kiểm tra xem đã gửi email chưa
        $email_sent = get_post_meta($ticket_order_id, '_email_sent', true);
        if ($email_sent === 'yes') {
            return; // Đã gửi rồi
        }
        
        $subject = '🎬 Xác nhận đặt vé thành công - Đơn hàng #' . $ticket_order_id;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $body    = movie_render_order_summary($ticket_order_id, true); // true = is_email
        
        // Log để debug
        error_log('Movie Booking: Attempting to send email to ' . $u_mail . ' for ticket order #' . $ticket_order_id);
        
        $mail_result = wp_mail($u_mail, $subject, $body, $headers);
        
        if ($mail_result) {
            error_log('Movie Booking: Email sent successfully to ' . $u_mail);
            update_post_meta($ticket_order_id, '_email_sent', 'yes');
        } else {
            error_log('Movie Booking: Failed to send email to ' . $u_mail);
            // Lưu email vào log file để có thể gửi lại sau
            $email_log = get_option('movie_booking_email_queue', array());
            $email_log[] = array(
                'order_id' => $ticket_order_id,
                'email' => $u_mail,
                'subject' => $subject,
                'body' => $body,
                'time' => current_time('mysql')
            );
            update_option('movie_booking_email_queue', $email_log);
        }
    }
}

// Hook: Gửi email khi WooCommerce order status thay đổi thành "completed"
add_action('woocommerce_order_status_completed', 'movie_send_ticket_email_on_order_complete', 10, 1);
function movie_send_ticket_email_on_order_complete($order_id) {
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    $order = wc_get_order($order_id);
    if (!$order) {
        return;
    }
    
    // Kiểm tra xem có phải là order đặt vé không
    $is_ticket_order = $order->get_meta('_is_ticket_order');
    if ($is_ticket_order !== 'yes') {
        return;
    }
    
    // Lấy ticket_order_id
    $ticket_order_id = $order->get_meta('_ticket_order_id');
    if (!$ticket_order_id) {
        // Nếu chưa có ticket_order, thử tạo lại
        movie_create_ticket_from_wc_order($order_id);
        $ticket_order_id = $order->get_meta('_ticket_order_id');
    }
    
    if (!$ticket_order_id) {
        return;
    }
    
    // Kiểm tra xem đã gửi email chưa
    $email_sent = get_post_meta($ticket_order_id, '_email_sent', true);
    if ($email_sent === 'yes') {
        return; // Đã gửi rồi
    }
    
    // Lấy email từ order
    $user_email = $order->get_billing_email();
    if (!$user_email) {
        $user_id = $order->get_user_id();
        if ($user_id) {
            $user = get_userdata($user_id);
            if ($user) {
                $user_email = $user->user_email;
            }
        }
    }
    
    if ($user_email) {
        // Kiểm tra xem đã gửi email chưa
        $email_sent = get_post_meta($ticket_order_id, '_email_sent', true);
        if ($email_sent === 'yes') {
            return; // Đã gửi rồi
        }
        
        $subject = '🎬 Xác nhận đặt vé thành công - Đơn hàng #' . $ticket_order_id;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $body    = movie_render_order_summary($ticket_order_id, true); // true = is_email
        
        // Log để debug
        error_log('Movie Booking: Attempting to send email to ' . $user_email . ' for ticket order #' . $ticket_order_id);
        
        $mail_result = wp_mail($user_email, $subject, $body, $headers);
        
        if ($mail_result) {
            error_log('Movie Booking: Email sent successfully to ' . $user_email);
            update_post_meta($ticket_order_id, '_email_sent', 'yes');
        } else {
            error_log('Movie Booking: Failed to send email to ' . $user_email);
            // Lưu email vào log file để có thể gửi lại sau
            $email_log = get_option('movie_booking_email_queue', array());
            $email_log[] = array(
                'order_id' => $ticket_order_id,
                'email' => $user_email,
                'subject' => $subject,
                'body' => $body,
                'time' => current_time('mysql')
            );
            update_option('movie_booking_email_queue', $email_log);
        }
    }
}



// ====== CẤU HÌNH SMTP ĐỂ GỬI EMAIL ======
// Trên LOCALHOST: Email sẽ được lưu vào file log thay vì gửi thật
// Trên SERVER THẬT: Cần setup SMTP để gửi email thật

// Hook để log email trên localhost (sau khi wp_mail được gọi)
add_action('wp_mail_failed', 'movie_log_email_error', 10, 1);
add_filter('wp_mail', 'movie_log_email_on_localhost', 10, 1);

function movie_log_email_on_localhost($args) {
    // Chỉ log trên localhost
    $is_localhost = (
        strpos(home_url(), 'localhost') !== false || 
        strpos(home_url(), '127.0.0.1') !== false ||
        strpos(home_url(), '.local') !== false ||
        strpos(home_url(), '.test') !== false ||
        (defined('WP_DEBUG') && WP_DEBUG)
    );
    
    if ($is_localhost) {
        $to = is_array($args['to']) ? implode(', ', $args['to']) : $args['to'];
        $subject = $args['subject'];
        $message = $args['message'];
        
        $log_dir = WP_CONTENT_DIR . '/email-logs';
        if (!file_exists($log_dir)) {
            wp_mkdir_p($log_dir);
        }
        
        $log_file = $log_dir . '/email-' . date('Y-m-d') . '.html';
        $log_content = "\n\n" . str_repeat('=', 80) . "\n";
        $log_content .= "THỜI GIAN: " . current_time('Y-m-d H:i:s') . "\n";
        $log_content .= "ĐẾN: " . $to . "\n";
        $log_content .= "TIÊU ĐỀ: " . $subject . "\n";
        $log_content .= str_repeat('=', 80) . "\n\n";
        $log_content .= $message;
        $log_content .= "\n\n" . str_repeat('-', 80) . "\n";
        
        file_put_contents($log_file, $log_content, FILE_APPEND);
        
        // Lưu thông tin vào transient để hiển thị thông báo
        set_transient('movie_last_email_log', array(
            'to' => $to,
            'subject' => $subject,
            'file' => content_url('email-logs/email-' . date('Y-m-d') . '.html'),
            'time' => current_time('mysql')
        ), 300); // 5 phút
    }
    
    return $args; // Vẫn cho phép gửi email thật nếu có SMTP
}

function movie_log_email_error($wp_error) {
    error_log('Movie Booking Email Error: ' . $wp_error->get_error_message());
}

add_action('phpmailer_init', 'movie_configure_smtp', 10, 1);
function movie_configure_smtp($phpmailer) {
    // Chỉ cấu hình nếu chưa có plugin SMTP nào khác
    if (defined('WPMS_ON') && constant('WPMS_ON')) {
        return; // Đã có plugin SMTP (WP Mail SMTP)
    }
    
    // Kiểm tra xem có plugin SMTP nào đang active không
    if (function_exists('is_plugin_active')) {
        if (is_plugin_active('wp-mail-smtp/wp_mail_smtp.php') || 
            is_plugin_active('easy-wp-smtp/easy-wp-smtp.php') ||
            is_plugin_active('post-smtp/postman-smtp.php')) {
            return; // Đã có plugin SMTP
        }
    }
    
    // ====== CẤU HÌNH SMTP GMAIL ======
    // Lấy thông tin từ WordPress options (có thể set trong admin hoặc wp-config.php)
    $smtp_enabled = get_option('movie_smtp_enabled', false);
    $smtp_host = get_option('movie_smtp_host', '');
    $smtp_user = get_option('movie_smtp_user', '');
    $smtp_pass = get_option('movie_smtp_pass', '');
    
    // Hoặc dùng constants từ wp-config.php (an toàn hơn)
    if (defined('MOVIE_SMTP_ENABLED') && constant('MOVIE_SMTP_ENABLED')) {
        $smtp_enabled = true;
        $smtp_host = defined('MOVIE_SMTP_HOST') ? constant('MOVIE_SMTP_HOST') : 'smtp.gmail.com';
        $smtp_user = defined('MOVIE_SMTP_USER') ? constant('MOVIE_SMTP_USER') : '';
        $smtp_pass = defined('MOVIE_SMTP_PASS') ? constant('MOVIE_SMTP_PASS') : '';
    }
    
    // Nếu có cấu hình SMTP, sử dụng nó
    if ($smtp_enabled && $smtp_user && $smtp_pass) {
        $phpmailer->isSMTP();
        $phpmailer->Host = $smtp_host ?: 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = $smtp_user;
        $phpmailer->Password = $smtp_pass;
        $phpmailer->SMTPSecure = 'tls';
        $phpmailer->Port = 587;
        $phpmailer->setFrom($smtp_user, 'Hệ Thống Đặt Vé');
        $phpmailer->CharSet = 'UTF-8';
        
        // Debug (chỉ bật khi test, comment lại sau khi test xong)
        // $phpmailer->SMTPDebug = 2;
        // $phpmailer->Debugoutput = function($str, $level) {
        //     error_log("SMTP Debug: $str");
        // };
    }
}

// Cập nhật giá sản phẩm trong giỏ hàng dựa trên số lượng ghế
add_action('woocommerce_before_calculate_totals', 'movie_update_cart_item_price', 10, 1);
function movie_update_cart_item_price($cart) {
    if (!class_exists('WooCommerce')) {
        return;
    }

    $ticket_data = WC()->session->get('ticket_booking_data');
    if (!$ticket_data || empty($ticket_data['total'])) {
        return;
    }

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if (isset($cart_item['ticket_data'])) {
            $cart_item['data']->set_price($ticket_data['total']);
        }
    }
}

// Hiển thị thông tin đặt vé trong checkout
add_filter('woocommerce_cart_item_name', 'movie_display_ticket_info_in_cart', 10, 3);
function movie_display_ticket_info_in_cart($name, $cart_item, $cart_item_key) {
    if (isset($cart_item['ticket_data'])) {
        $data = $cart_item['ticket_data'];
        $movie_title = get_the_title($data['movie_id']);
        $cinema_title = get_the_title($data['cinema_id']);
        $name .= '<br><small>';
        $name .= '<strong>Phim:</strong> ' . esc_html($movie_title) . '<br>';
        $name .= '<strong>Rạp:</strong> ' . esc_html($cinema_title) . '<br>';
        $name .= '<strong>Ngày:</strong> ' . esc_html($data['date']) . '<br>';
        $name .= '<strong>Giờ:</strong> ' . esc_html($data['time']) . '<br>';
        $name .= '<strong>Ghế:</strong> ' . esc_html(implode(', ', $data['seats']));
        $name .= '</small>';
    }
    return $name;
}

// Tự động chọn payment method khi đến checkout từ đặt vé
add_action('woocommerce_before_checkout_form', 'movie_auto_select_payment_method');
add_action('woocommerce_checkout_init', 'movie_auto_select_payment_method');
function movie_auto_select_payment_method() {
    if (!class_exists('WooCommerce') || !WC()->session) {
        return;
    }

    // Kiểm tra nếu có payment method trong URL parameter
    if (isset($_GET['payment_method']) && $_GET['payment_method'] === 'credit_card') {
        // Đảm bảo payment gateway credit_card có sẵn
        $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
        if (isset($available_gateways['credit_card'])) {
            WC()->session->set('chosen_payment_method', 'credit_card');
        }
    }
    
    // Kiểm tra nếu có payment method được chọn từ đặt vé (trong session)
    $chosen_method = WC()->session->get('chosen_payment_method');
    if ($chosen_method === 'credit_card') {
        // Đảm bảo payment gateway credit_card có sẵn
        $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
        if (isset($available_gateways['credit_card'])) {
            WC()->session->set('chosen_payment_method', 'credit_card');
        } else {
            // Nếu gateway không available, xóa session để tránh lỗi
            WC()->session->__unset('chosen_payment_method');
        }
    }
}

// Highlight payment method khi có parameter hoặc session
add_action('wp_footer', 'movie_highlight_credit_card_payment');
function movie_highlight_credit_card_payment() {
    if (!is_checkout()) {
        return;
    }
    
    // Kiểm tra nếu có parameter hoặc session
    $should_select = false;
    if (isset($_GET['payment_method']) && $_GET['payment_method'] === 'credit_card') {
        $should_select = true;
    } elseif (class_exists('WooCommerce') && WC()->session) {
        $chosen_method = WC()->session->get('chosen_payment_method');
        if ($chosen_method === 'credit_card') {
            $should_select = true;
        }
    }
    
    if (!$should_select) {
        return;
    }
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Hàm để force hiển thị payment box
        function forceShowPaymentBox($paymentBox) {
            if ($paymentBox.length) {
                $paymentBox.css({
                    'display': 'block',
                    'visibility': 'visible',
                    'opacity': '1',
                    'height': 'auto',
                    'overflow': 'visible'
                }).show();
            }
        }
        
        // Hàm để chọn payment method
        function selectCreditCardPayment() {
            var creditCardRadio = $('input[value="credit_card"]');
            if (creditCardRadio.length) {
                if (!creditCardRadio.is(':checked')) {
                    creditCardRadio.prop('checked', true).trigger('change').trigger('click');
                }
                
                // Đảm bảo payment box được hiển thị
                var paymentBox = creditCardRadio.closest('li.wc_payment_method').find('.payment_box');
                forceShowPaymentBox(paymentBox);
                
                // Kiểm tra xem có form fields không
                var formFields = paymentBox.find('.wc-credit-card-form');
                if (formFields.length === 0) {
                    console.log('Warning: Credit card form fields not found in payment box');
                } else {
                    console.log('Credit card form fields found:', formFields.length);
                    formFields.css({
                        'display': 'block',
                        'visibility': 'visible'
                    });
                }
                
                // Scroll to payment section
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: creditCardRadio.closest('.wc_payment_methods').offset().top - 100
                    }, 500);
                }, 100);
            } else {
                console.log('Credit card payment method radio button not found');
            }
        }
        
        // Thử chọn ngay lập tức
        selectCreditCardPayment();
        
        // Thử lại sau khi form được load hoàn toàn
        setTimeout(selectCreditCardPayment, 500);
        setTimeout(selectCreditCardPayment, 1000);
        setTimeout(selectCreditCardPayment, 2000);
        
        // Lắng nghe sự kiện khi payment methods được load
        $(document.body).on('updated_checkout', function() {
            setTimeout(selectCreditCardPayment, 100);
        });
        
        // Lắng nghe khi chọn payment method
        $(document.body).on('change', 'input[name="payment_method"]', function() {
            if ($(this).val() === 'credit_card') {
                var paymentBox = $(this).closest('li.wc_payment_method').find('.payment_box');
                forceShowPaymentBox(paymentBox);
            }
        });
    });
    </script>
    <?php
}

// register_create blog page
function create_blog_post_type() {
    register_post_type('blog',
        array(
            'labels' => array(
                'name' => __('Blogs'),
                'singular_name' => __('Blog')
            ),
            'public' => true,
            'publicly_queryable' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'blog'),
            'menu_position' => 5,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        )
    );
}
add_action('init', 'create_blog_post_type');

function mytheme_blog_archive_styles() {
    if (is_post_type_archive('blog')) {
        wp_enqueue_style(
            'blog-archive-style',
            get_stylesheet_directory_uri() . '/blog-archive.css',
            array(),
            filemtime(get_stylesheet_directory() . '/blog-archive.css')
        );
    }
}
add_action('wp_enqueue_scripts', 'mytheme_blog_archive_styles');






// Dịch text checkout sang tiếng Việt
add_filter('woocommerce_checkout_fields', 'movie_remove_all_checkout_fields');
function movie_remove_all_checkout_fields($fields) {
    // Xóa tất cả billing fields
    if (isset($fields['billing'])) {
        unset($fields['billing']);
    }
    
    // Xóa tất cả shipping fields
    if (isset($fields['shipping'])) {
        unset($fields['shipping']);
    }
    
    // Xóa field ghi chú đơn hàng
    if (isset($fields['order']['order_comments'])) {
        unset($fields['order']['order_comments']);
    }
    
    return $fields;
}

// Dịch các text khác trong checkout
add_filter('gettext', 'movie_translate_checkout_texts', 20, 3);
function movie_translate_checkout_texts($translated_text, $text, $domain) {
    if ($domain === 'woocommerce') {
        $translations = array(
            'Billing details' => 'Thông tin thanh toán',
            'Additional information' => 'Thông tin bổ sung',
            'Order notes' => 'Ghi chú đơn hàng',
            'Place order' => 'Đặt hàng',
            'Your order' => 'Đơn hàng của bạn',
            'Product' => 'Sản phẩm',
            'Subtotal' => 'Tạm tính',
            'Total' => 'Tổng cộng',
            'Payment' => 'Thanh toán',
            'Payment method' => 'Phương thức thanh toán',
            'Credit Card / Debit Card' => 'Thẻ tín dụng / Thẻ ghi nợ',
            'Have a coupon?' => 'Có mã giảm giá?',
            'Click here to enter your code' => 'Nhấp vào đây để nhập mã của bạn',
            'First name' => 'Tên',
            'Last name' => 'Họ',
            'Company name' => 'Tên công ty',
            'Country / Region' => 'Quốc gia / Vùng',
            'Street address' => 'Địa chỉ',
            'Apartment, suite, etc. (optional)' => 'Căn hộ, tòa nhà, v.v. (tùy chọn)',
            'Postcode / ZIP' => 'Mã bưu điện',
            'Town / City' => 'Thành phố',
            'State / County' => 'Tỉnh / Thành phố',
            'Phone' => 'Số điện thoại',
            'Email address' => 'Địa chỉ email',
            'Order notes (optional)' => 'Ghi chú đơn hàng (tùy chọn)',
        );
        
        if (isset($translations[$text])) {
            return $translations[$text];
        }
    }
    return $translated_text;
}

// Dịch privacy policy text trong checkout
add_filter('woocommerce_get_privacy_policy_text', 'movie_translate_privacy_policy_text', 10, 2);
function movie_translate_privacy_policy_text($text, $type) {
   
}

// Thêm custom post types vào WordPress search
function movie_theme_add_custom_post_types_to_search($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_search()) {
            // Kiểm tra nếu có post_type trong URL parameter
            if (isset($_GET['post_type'])) {
                $post_types = sanitize_text_field($_GET['post_type']);
                $post_types_array = explode(',', $post_types);
                $query->set('post_type', $post_types_array);
            } else {
                // Mặc định tìm trong phim và rạp
                $query->set('post_type', array(movie_theme_get_movie_post_type(), 'mbs_cinema'));
            }
        }
    }
}
add_action('pre_get_posts', 'movie_theme_add_custom_post_types_to_search');

// AJAX handler cho chức năng yêu thích
function movie_theme_toggle_favorite() {
    // Kiểm tra nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'movie_favorite_nonce')) {
        wp_send_json_error(array('message' => 'Phiên không hợp lệ'));
    }
    
    // Kiểm tra đăng nhập
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Vui lòng đăng nhập để thêm yêu thích'));
    }
    
    $user_id = get_current_user_id();
    $movie_id = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : 0;
    
    if (!$movie_id || !get_post($movie_id)) {
        wp_send_json_error(array('message' => 'Phim không tồn tại'));
    }
    
    // Lấy danh sách yêu thích hiện tại
    $favorites = get_user_meta($user_id, 'favorite_movies', true);
    $favorites = is_array($favorites) ? $favorites : array();
    
    // Toggle yêu thích
    $is_favorite = in_array($movie_id, $favorites);
    
    if ($is_favorite) {
        // Xóa khỏi yêu thích
        $favorites = array_diff($favorites, array($movie_id));
        $favorites = array_values($favorites); // Re-index array
        $action = 'removed';
        $message = 'Đã xóa khỏi yêu thích';
    } else {
        // Thêm vào yêu thích
        $favorites[] = $movie_id;
        $favorites = array_unique($favorites);
        $favorites = array_values($favorites);
        $action = 'added';
        $message = 'Đã thêm vào yêu thích';
    }
    
    // Lưu lại
    update_user_meta($user_id, 'favorite_movies', $favorites);
    
    wp_send_json_success(array(
        'action' => $action,
        'is_favorite' => !$is_favorite,
        'message' => $message,
        'count' => count($favorites)
    ));
}
add_action('wp_ajax_movie_toggle_favorite', 'movie_theme_toggle_favorite');
add_action('wp_ajax_nopriv_movie_toggle_favorite', 'movie_theme_toggle_favorite');

// Enqueue script cho yêu thích
function movie_theme_favorite_scripts() {
    if (movie_theme_is_movie_singular() || is_page('favorites') || is_page_template('page-favorites.php')) {
        $js_file = get_template_directory() . '/js/movie-favorite.js';
        if (file_exists($js_file)) {
            wp_enqueue_script('movie-favorite', get_template_directory_uri() . '/js/movie-favorite.js', array('jquery'), filemtime($js_file), true);
            wp_localize_script('movie-favorite', 'movieFavorite', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('movie_favorite_nonce'),
                'login_required' => 'Vui lòng đăng nhập để thêm yêu thích'
            ));
        }
    }
}
add_action('wp_enqueue_scripts', 'movie_theme_favorite_scripts');

// Đảm bảo cột seat_code tồn tại trong bảng mbs_seats
function movie_theme_ensure_seat_code_column() {
    global $wpdb;
    $table_seats = $wpdb->prefix . 'mbs_seats';
    
    // Kiểm tra xem bảng có tồn tại không
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_seats'");
    if (!$table_exists) {
        return; // Bảng chưa tồn tại, không cần làm gì
    }
    
    // Kiểm tra xem cột seat_code đã tồn tại chưa
    $columns = $wpdb->get_col("SHOW COLUMNS FROM $table_seats");
    $has_seat_code = in_array('seat_code', $columns);
    
    if (!$has_seat_code) {
        // Thêm cột seat_code
        $wpdb->query("ALTER TABLE $table_seats ADD COLUMN seat_code VARCHAR(10) NULL AFTER booking_id");
        
        // Nếu có cột seat_number, copy dữ liệu sang seat_code
        if (in_array('seat_number', $columns)) {
            $wpdb->query("UPDATE $table_seats SET seat_code = seat_number WHERE seat_code IS NULL OR seat_code = ''");
        }
    }
    
    // Đảm bảo showtime_id có thể NULL để tránh lỗi khi insert không có showtime_id
    // Kiểm tra xem showtime_id có cho phép NULL không
    $showtime_info = $wpdb->get_row("SHOW COLUMNS FROM $table_seats WHERE Field = 'showtime_id'");
    if ($showtime_info && $showtime_info->Null === 'NO') {
        // Làm cho showtime_id có thể NULL
        $wpdb->query("ALTER TABLE $table_seats MODIFY COLUMN showtime_id bigint(20) NULL");
    }
    
    // Xóa UNIQUE constraint nếu có để tránh conflict khi insert nhiều ghế cùng booking_id
    // Kiểm tra xem có constraint unique_seat không
    $constraints = $wpdb->get_results("SHOW INDEX FROM $table_seats WHERE Key_name = 'unique_seat'");
    if (!empty($constraints)) {
        // Xóa constraint để cho phép insert nhiều ghế
        $wpdb->query("ALTER TABLE $table_seats DROP INDEX unique_seat");
    }
}
// Chạy migration khi admin init (mỗi lần vào admin)
add_action('admin_init', 'movie_theme_ensure_seat_code_column');
// Cũng chạy khi init để đảm bảo (nhưng chỉ 1 lần)
add_action('init', function() {
    static $migrated = false;
    if (!$migrated) {
        movie_theme_ensure_seat_code_column();
        $migrated = true;
    }
}, 999);

// ============================================
// AJAX Handlers for Dynamic Booking Form
// ============================================

// AJAX: Get movies available at selected cinema
function ajax_get_movies_by_cinema() {
    check_ajax_referer('booking_nonce', 'nonce');
    
    $cinema_id = isset($_POST['cinema_id']) ? intval($_POST['cinema_id']) : 0;
    
    if (!$cinema_id) {
        wp_send_json_error(array('message' => 'Invalid cinema ID'));
    }
    
    global $wpdb;
    $movies = array();
    
    // Try table first
    $st_table = $wpdb->prefix . 'mbs_showtimes';
    $table_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $st_table));
    
    if ($table_exists === $st_table) {
        // Get distinct movie IDs from showtimes table
        $movie_ids = $wpdb->get_col($wpdb->prepare(
            "SELECT DISTINCT movie_id FROM $st_table WHERE cinema_id = %d ORDER BY movie_id",
            $cinema_id
        ));
        
        if ($movie_ids) {
            foreach ($movie_ids as $movie_id) {
                $movie = get_post($movie_id);
                if ($movie && $movie->post_status === 'publish') {
                    $movies[] = array(
                        'id' => $movie_id,
                        'title' => get_the_title($movie_id)
                    );
                }
            }
        }
    } elseif (post_type_exists('mbs_showtime')) {
        // Fallback to CPT
        $st = new WP_Query(array(
            'post_type' => 'mbs_showtime',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array('key' => '_mbs_cinema_id', 'value' => $cinema_id, 'compare' => '=')
            )
        ));
        
        $movie_ids = array();
        if ($st->have_posts()) {
            while ($st->have_posts()) {
                $st->the_post();
                $movie_id = intval(get_post_meta(get_the_ID(), '_mbs_movie_id', true));
                if ($movie_id && !in_array($movie_id, $movie_ids)) {
                    $movie_ids[] = $movie_id;
                    $movies[] = array(
                        'id' => $movie_id,
                        'title' => get_the_title($movie_id)
                    );
                }
            }
            wp_reset_postdata();
        }
    }
    
    wp_send_json_success(array('movies' => $movies));
}
add_action('wp_ajax_get_movies_by_cinema', 'ajax_get_movies_by_cinema');
add_action('wp_ajax_nopriv_get_movies_by_cinema', 'ajax_get_movies_by_cinema');

// AJAX: Get dates available for selected cinema + movie
function ajax_get_dates_by_cinema_movie() {
    check_ajax_referer('booking_nonce', 'nonce');
    
    $cinema_id = isset($_POST['cinema_id']) ? intval($_POST['cinema_id']) : 0;
    $movie_id = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : 0;
    
    if (!$cinema_id || !$movie_id) {
        wp_send_json_error(array('message' => 'Invalid parameters'));
    }
    
    global $wpdb;
    $dates = array();
    
    // Try table first
    $st_table = $wpdb->prefix . 'mbs_showtimes';
    $table_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $st_table));
    
    if ($table_exists === $st_table) {
        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT DISTINCT show_date FROM $st_table 
             WHERE cinema_id = %d AND movie_id = %d 
             ORDER BY show_date",
            $cinema_id, $movie_id
        ));
        
        if ($rows) {
            foreach ($rows as $row) {
                $date = $row->show_date;
                $timestamp = strtotime($date);
                $day_names = array('Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy');
                $day_name = $day_names[date('w', $timestamp)];
                $formatted = $day_name . ', ' . date('d/m', $timestamp);
                
                $dates[] = array(
                    'value' => $date,
                    'label' => $formatted
                );
            }
        }
    } elseif (post_type_exists('mbs_showtime')) {
        // Fallback to CPT
        $st = new WP_Query(array(
            'post_type' => 'mbs_showtime',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array('key' => '_mbs_cinema_id', 'value' => $cinema_id, 'compare' => '='),
                array('key' => '_mbs_movie_id', 'value' => $movie_id, 'compare' => '=')
            )
        ));
        
        $date_list = array();
        if ($st->have_posts()) {
            while ($st->have_posts()) {
                $st->the_post();
                $dt = get_post_meta(get_the_ID(), '_mbs_showtime', true);
                $timestamp = strtotime($dt);
                if ($timestamp) {
                    $date = date('Y-m-d', $timestamp);
                    if (!in_array($date, $date_list)) {
                        $date_list[] = $date;
                    }
                }
            }
            wp_reset_postdata();
            
            sort($date_list);
            foreach ($date_list as $date) {
                $timestamp = strtotime($date);
                $day_names = array('Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy');
                $day_name = $day_names[date('w', $timestamp)];
                $formatted = $day_name . ', ' . date('d/m', $timestamp);
                
                $dates[] = array(
                    'value' => $date,
                    'label' => $formatted
                );
            }
        }
    }
    
    wp_send_json_success(array('dates' => $dates));
}
add_action('wp_ajax_get_dates_by_cinema_movie', 'ajax_get_dates_by_cinema_movie');
add_action('wp_ajax_nopriv_get_dates_by_cinema_movie', 'ajax_get_dates_by_cinema_movie');

// AJAX: Get showtimes for selected cinema + movie + date
function ajax_get_showtimes() {
    check_ajax_referer('booking_nonce', 'nonce');
    
    $cinema_id = isset($_POST['cinema_id']) ? intval($_POST['cinema_id']) : 0;
    $movie_id = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : 0;
    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';
    
    if (!$cinema_id || !$movie_id || !$date) {
        wp_send_json_error(array('message' => 'Invalid parameters'));
    }
    
    global $wpdb;
    $showtimes = array();
    
    // Try table first
    $st_table = $wpdb->prefix . 'mbs_showtimes';
    $table_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $st_table));
    
    if ($table_exists === $st_table) {
        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT show_time FROM $st_table 
             WHERE cinema_id = %d AND movie_id = %d AND show_date = %s 
             ORDER BY show_time",
            $cinema_id, $movie_id, $date
        ));
        
        if ($rows) {
            foreach ($rows as $row) {
                $showtimes[] = array(
                    'value' => $row->show_time,
                    'label' => $row->show_time . ' - 2D Standard'
                );
            }
        }
    } elseif (post_type_exists('mbs_showtime')) {
        // Fallback to CPT
        $st = new WP_Query(array(
            'post_type' => 'mbs_showtime',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array('key' => '_mbs_cinema_id', 'value' => $cinema_id, 'compare' => '='),
                array('key' => '_mbs_movie_id', 'value' => $movie_id, 'compare' => '=')
            )
        ));
        
        if ($st->have_posts()) {
            while ($st->have_posts()) {
                $st->the_post();
                $dt = get_post_meta(get_the_ID(), '_mbs_showtime', true);
                $timestamp = strtotime($dt);
                if ($timestamp) {
                    $show_date = date('Y-m-d', $timestamp);
                    if ($show_date === $date) {
                        $time = date('H:i', $timestamp);
                        $showtimes[] = array(
                            'value' => $time,
                            'label' => $time . ' - 2D Standard'
                        );
                    }
                }
            }
            wp_reset_postdata();
        }
    }
    
    wp_send_json_success(array('showtimes' => $showtimes));
}
add_action('wp_ajax_get_showtimes', 'ajax_get_showtimes');
add_action('wp_ajax_nopriv_get_showtimes', 'ajax_get_showtimes');

// ============================================
// Movie Status Meta Box (Thay thế Taxonomy)
// ============================================

// Add meta box for movie status
function movie_add_status_meta_box() {
    add_meta_box(
        'movie_status_meta_box',
        'Trạng Thái Phim',
        'movie_status_meta_box_callback',
        'mbs_movie',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'movie_add_status_meta_box');

// Meta box callback
function movie_status_meta_box_callback($post) {
    wp_nonce_field('movie_status_meta_box', 'movie_status_meta_box_nonce');
    $current_status = get_post_meta($post->ID, '_movie_status', true);
    ?>
    <p>
        <label>
            <input type="radio" name="movie_status" value="dang-chieu" <?php checked($current_status, 'dang-chieu'); ?>>
            Đang chiếu
        </label>
    </p>
        <label>
            <input type="radio" name="movie_status" value="sap-chieu" <?php checked($current_status, 'sap-chieu'); ?>>
            Sắp chiếu
        </label>
    </p>
    <p>
        <label>
            <input type="radio" name="movie_status" value="suat-chieu-dac-biet" <?php checked($current_status, 'suat-chieu-dac-biet'); ?>>
            Suất chiếu đặc biệt
        </label>
    </p>
    <p>
        <label>
            <input type="radio" name="movie_status" value="" <?php checked($current_status, ''); ?>>
            Không xác định
        </label>
    </p>
    <style>
        #movie_status_meta_box label {
            display: block;
            margin: 5px 0;
            cursor: pointer;
        }
        #movie_status_meta_box input[type="radio"] {
            margin-right: 5px;
        }
    </style>
    <?php
}

// Save meta box data
function movie_save_status_meta_box($post_id) {
    // Check nonce
    if (!isset($_POST['movie_status_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['movie_status_meta_box_nonce'], 'movie_status_meta_box')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save data
    if (isset($_POST['movie_status'])) {
        update_post_meta($post_id, '_movie_status', sanitize_text_field($_POST['movie_status']));
    }
}
add_action('save_post_mbs_movie', 'movie_save_status_meta_box');

// Add column to movies list
function movie_status_column($columns) {
    $columns['movie_status'] = 'Trạng thái';
    return $columns;
}
add_filter('manage_mbs_movie_posts_columns', 'movie_status_column');

// Display column content
function movie_status_column_content($column, $post_id) {
    if ($column === 'movie_status') {
        $status = get_post_meta($post_id, '_movie_status', true);
        $status_labels = array(
            'dang-chieu' => '🎬 Đang chiếu',
            'sap-chieu' => '🎞️ Sắp chiếu',
            'suat-chieu-dac-biet' => '🌟 Suất chiếu đặc biệt',
        );
        echo isset($status_labels[$status]) ? $status_labels[$status] : '—';
    }
}
add_action('manage_mbs_movie_posts_custom_column', 'movie_status_column_content', 10, 2);

// Ensure core pages are created
add_action('init', 'movie_theme_ensure_core_pages');


