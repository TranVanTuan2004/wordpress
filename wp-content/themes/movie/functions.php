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

    register_post_type('movie', $args);
}
add_action('init', 'create_movie_post_type');

// css in file front-page.php
function mytheme_front_page_styles() {
    if ( is_front_page() ) {  
        wp_enqueue_style(
            'mytheme-front-page-style',
            get_template_directory_uri() . '/front-page.css',
            array(),      // không phụ thuộc file khác
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
            get_template_directory_uri() . '/script.js',
            array('jquery'), // phụ thuộc jquery nếu cần
            '1.0',
            true // load ở footer
        );
    }
}
add_action('wp_enqueue_scripts', 'mytheme_front_page_scripts');

?>


