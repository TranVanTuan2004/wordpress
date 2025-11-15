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
            array('jquery'), // phụ thuộc jquery nếu cần
            '1.0',
            true // load ở footer
        );
    }
}
add_action('wp_enqueue_scripts', 'mytheme_single_movie_scripts');


?>


