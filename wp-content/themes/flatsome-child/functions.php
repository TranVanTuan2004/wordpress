<?php
function custom_post_type_phim() {
    $labels = array(
        'name' => 'Phim',
        'singular_name' => 'Phim',
        'add_new_item' => 'Thêm Phim Mới',
        'edit_item' => 'Chỉnh sửa Phim',
        'all_items' => 'Tất cả Phim',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,            // Bắt buộc để query thấy CPT
        'has_archive' => true,
        'show_in_rest' => true,      // Bắt buộc cho Gutenberg / UX Builder
        'supports' => array('title','editor','thumbnail','excerpt'),
        'menu_icon' => 'dashicons-video-alt2',
    );

    register_post_type('phim', $args);
}
add_action('init', 'custom_post_type_phim');


// Cho phép shortcode chạy trong UX Builder Text element
add_filter('ux_text_content', 'do_shortcode');

// Shortcode hiển thị 4 phim dạng grid
function phim_home_shortcode() {
    $args = array(
        'post_type'=>'phim',
        'posts_per_page'=>4,
        'orderby'=>'date',
        'order'=>'DESC',
        'post_status'=>'publish',   // chỉ lấy phim đã xuất bản
    );

    $query = new WP_Query($args);
    $output = '<div class="phim-grid" style="display:flex; flex-wrap:wrap; gap:20px;">';
    if($query->have_posts()) {
        while($query->have_posts()) {
            $query->the_post();
            $output .= '<div class="phim-item" style="width:calc(25%-20px); box-sizing:border-box;">';
            $output .= '<a href="'.get_permalink().'">';
            $output .= get_the_post_thumbnail(get_the_ID(),'medium');
            $output .= '<h3>'.get_the_title().'</h3>';
            $output .= '</a></div>';
        }
    }
    wp_reset_postdata();
    $output .= '</div>';

    return $output;
}
add_shortcode('phim_home','phim_home_shortcode');
