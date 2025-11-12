




<!-- ****** Event ****** -->
<?php
    // ===== Đăng ký Custom Post Type: Event =====
function mytheme_register_event_post_type() {
    $labels = array(
        'name'               => 'Sự kiện',
        'singular_name'      => 'Sự kiện',
        'menu_name'          => 'Event',
        'name_admin_bar'     => 'Event',
        'add_new'            => 'Thêm sự kiện',
        'add_new_item'       => 'Thêm sự kiện mới',
        'new_item'           => 'Sự kiện mới',
        'edit_item'          => 'Chỉnh sửa sự kiện',
        'view_item'          => 'Xem sự kiện',
        'all_items'          => 'Tất cả sự kiện',
        'search_items'       => 'Tìm sự kiện',
        'not_found'          => 'Không có sự kiện nào',
        'not_found_in_trash' => 'Không có sự kiện trong thùng rác'
    );

    $args = array(
        'labels' => $labels,
        'public' => true, // hiển thị cả frontend và admin
        'has_archive' => true,
        'menu_icon' => 'dashicons-calendar-alt', // icon lịch
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'event'),
        'show_in_rest' => true // bật Gutenberg và REST API
    );

    register_post_type('event', $args);
}
add_action('init', 'mytheme_register_event_post_type');

?>