<?php
/**
 * Custom Post Types Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class MBS_Post_Types {
    
    public function __construct() {
        add_action('init', array($this, 'register_post_types'));
        add_action('init', array($this, 'register_taxonomies'));
    }
    
    public function register_post_types() {
        // Register Movies Post Type
        $labels = array(
            'name' => 'Phim',
            'singular_name' => 'Phim',
            'menu_name' => 'Phim',
            'add_new' => 'Thêm Phim',
            'add_new_item' => 'Thêm Phim Mới',
            'edit_item' => 'Sửa Phim',
            'new_item' => 'Phim Mới',
            'view_item' => 'Xem Phim',
            'search_items' => 'Tìm Phim',
            'not_found' => 'Không tìm thấy phim',
            'not_found_in_trash' => 'Không có phim trong thùng rác'
        );
        
        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-video-alt2',
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'rewrite' => array('slug' => 'phim'),
            'show_in_rest' => true
        );
        
        register_post_type('mbs_movie', $args);
        
        // Register Cinemas Post Type
        $cinema_labels = array(
            'name' => 'Rạp Phim',
            'singular_name' => 'Rạp Phim',
            'menu_name' => 'Rạp Phim',
            'add_new' => 'Thêm Rạp',
            'add_new_item' => 'Thêm Rạp Mới',
            'edit_item' => 'Sửa Rạp',
            'new_item' => 'Rạp Mới',
            'view_item' => 'Xem Rạp',
            'search_items' => 'Tìm Rạp',
        );
        
        $cinema_args = array(
            'labels' => $cinema_labels,
            'public' => true,
            'menu_icon' => 'dashicons-building',
            'supports' => array('title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'rap-phim'),
            'show_in_rest' => true
        );
        
        register_post_type('mbs_cinema', $cinema_args);
        
        // Register Showtimes Post Type
        $showtime_labels = array(
            'name' => 'Suất Chiếu',
            'singular_name' => 'Suất Chiếu',
            'menu_name' => 'Suất Chiếu',
            'add_new' => 'Thêm Suất Chiếu',
            'add_new_item' => 'Thêm Suất Chiếu Mới',
            'edit_item' => 'Sửa Suất Chiếu',
        );
        
        $showtime_args = array(
            'labels' => $showtime_labels,
            'public' => true,
            'menu_icon' => 'dashicons-calendar-alt',
            'supports' => array('title'),
            'rewrite' => array('slug' => 'suat-chieu'),
            'show_in_rest' => true
        );
        
        register_post_type('mbs_showtime', $showtime_args);
    }
    
    public function register_taxonomies() {
        // Register Movie Genre Taxonomy
        $genre_labels = array(
            'name' => 'Thể Loại',
            'singular_name' => 'Thể Loại',
            'search_items' => 'Tìm Thể Loại',
            'all_items' => 'Tất cả Thể Loại',
            'edit_item' => 'Sửa Thể Loại',
            'update_item' => 'Cập nhật Thể Loại',
            'add_new_item' => 'Thêm Thể Loại Mới',
            'new_item_name' => 'Tên Thể Loại Mới',
        );
        
        register_taxonomy('mbs_genre', 'mbs_movie', array(
            'labels' => $genre_labels,
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'rewrite' => array('slug' => 'the-loai'),
            'show_in_rest' => true
        ));
    }
}

// Add meta boxes for custom fields
add_action('add_meta_boxes', 'mbs_add_meta_boxes');
function mbs_add_meta_boxes() {
    // Movie meta box
    add_meta_box(
        'mbs_movie_details',
        'Thông Tin Phim',
        'mbs_movie_details_callback',
        'mbs_movie',
        'normal',
        'high'
    );
    
    // Cinema meta box
    add_meta_box(
        'mbs_cinema_details',
        'Thông Tin Rạp',
        'mbs_cinema_details_callback',
        'mbs_cinema',
        'normal',
        'high'
    );
    
    // Showtime meta box
    add_meta_box(
        'mbs_showtime_details',
        'Thông Tin Suất Chiếu',
        'mbs_showtime_details_callback',
        'mbs_showtime',
        'normal',
        'high'
    );
}

function mbs_movie_details_callback($post) {
    wp_nonce_field('mbs_movie_meta_box', 'mbs_movie_meta_box_nonce');
    
    $duration = get_post_meta($post->ID, '_mbs_duration', true);
    $director = get_post_meta($post->ID, '_mbs_director', true);
    $actors = get_post_meta($post->ID, '_mbs_actors', true);
    $release_date = get_post_meta($post->ID, '_mbs_release_date', true);
    $rating = get_post_meta($post->ID, '_mbs_rating', true);
    $trailer_url = get_post_meta($post->ID, '_mbs_trailer_url', true);
    $language = get_post_meta($post->ID, '_mbs_language', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="mbs_duration">Thời Lượng (phút)</label></th>
            <td><input type="number" id="mbs_duration" name="mbs_duration" value="<?php echo esc_attr($duration); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="mbs_director">Đạo Diễn</label></th>
            <td><input type="text" id="mbs_director" name="mbs_director" value="<?php echo esc_attr($director); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="mbs_actors">Diễn Viên</label></th>
            <td><input type="text" id="mbs_actors" name="mbs_actors" value="<?php echo esc_attr($actors); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="mbs_release_date">Ngày Khởi Chiếu</label></th>
            <td><input type="date" id="mbs_release_date" name="mbs_release_date" value="<?php echo esc_attr($release_date); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="mbs_rating">Độ Tuổi</label></th>
            <td>
                <select id="mbs_rating" name="mbs_rating" class="regular-text">
                    <option value="P" <?php selected($rating, 'P'); ?>>P - Phổ biến</option>
                    <option value="C13" <?php selected($rating, 'C13'); ?>>C13 - 13+</option>
                    <option value="C16" <?php selected($rating, 'C16'); ?>>C16 - 16+</option>
                    <option value="C18" <?php selected($rating, 'C18'); ?>>C18 - 18+</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="mbs_language">Ngôn Ngữ</label></th>
            <td><input type="text" id="mbs_language" name="mbs_language" value="<?php echo esc_attr($language); ?>" class="regular-text" placeholder="Ví dụ: Phụ đề, Lồng tiếng"></td>
        </tr>
        <tr>
            <th><label for="mbs_trailer_url">Link Trailer</label></th>
            <td><input type="url" id="mbs_trailer_url" name="mbs_trailer_url" value="<?php echo esc_attr($trailer_url); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

function mbs_cinema_details_callback($post) {
    wp_nonce_field('mbs_cinema_meta_box', 'mbs_cinema_meta_box_nonce');
    
    $address = get_post_meta($post->ID, '_mbs_address', true);
    $phone = get_post_meta($post->ID, '_mbs_phone', true);
    $total_rooms = get_post_meta($post->ID, '_mbs_total_rooms', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="mbs_address">Địa Chỉ</label></th>
            <td><input type="text" id="mbs_address" name="mbs_address" value="<?php echo esc_attr($address); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="mbs_phone">Số Điện Thoại</label></th>
            <td><input type="text" id="mbs_phone" name="mbs_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="mbs_total_rooms">Số Phòng Chiếu</label></th>
            <td><input type="number" id="mbs_total_rooms" name="mbs_total_rooms" value="<?php echo esc_attr($total_rooms); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

function mbs_showtime_details_callback($post) {
    wp_nonce_field('mbs_showtime_meta_box', 'mbs_showtime_meta_box_nonce');
    
    $movie_id = get_post_meta($post->ID, '_mbs_movie_id', true);
    $cinema_id = get_post_meta($post->ID, '_mbs_cinema_id', true);
    $showtime = get_post_meta($post->ID, '_mbs_showtime', true);
    $room = get_post_meta($post->ID, '_mbs_room', true);
    $price = get_post_meta($post->ID, '_mbs_price', true);
    $format = get_post_meta($post->ID, '_mbs_format', true);
    
    $movies = get_posts(array('post_type' => 'mbs_movie', 'posts_per_page' => -1));
    $cinemas = get_posts(array('post_type' => 'mbs_cinema', 'posts_per_page' => -1));
    ?>
    <table class="form-table">
        <tr>
            <th><label for="mbs_movie_id">Phim</label></th>
            <td>
                <select id="mbs_movie_id" name="mbs_movie_id" class="regular-text">
                    <option value="">Chọn phim</option>
                    <?php foreach ($movies as $movie): ?>
                        <option value="<?php echo $movie->ID; ?>" <?php selected($movie_id, $movie->ID); ?>>
                            <?php echo esc_html($movie->post_title); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="mbs_cinema_id">Rạp Phim</label></th>
            <td>
                <select id="mbs_cinema_id" name="mbs_cinema_id" class="regular-text">
                    <option value="">Chọn rạp</option>
                    <?php foreach ($cinemas as $cinema): ?>
                        <option value="<?php echo $cinema->ID; ?>" <?php selected($cinema_id, $cinema->ID); ?>>
                            <?php echo esc_html($cinema->post_title); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="mbs_showtime">Thời Gian Chiếu</label></th>
            <td><input type="datetime-local" id="mbs_showtime" name="mbs_showtime" value="<?php echo esc_attr($showtime); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="mbs_room">Phòng Chiếu</label></th>
            <td><input type="text" id="mbs_room" name="mbs_room" value="<?php echo esc_attr($room); ?>" class="regular-text" placeholder="Ví dụ: Phòng 3"></td>
        </tr>
        <tr>
            <th><label for="mbs_format">Định Dạng</label></th>
            <td>
                <select id="mbs_format" name="mbs_format" class="regular-text">
                    <option value="2D" <?php selected($format, '2D'); ?>>2D</option>
                    <option value="3D" <?php selected($format, '3D'); ?>>3D</option>
                    <option value="IMAX" <?php selected($format, 'IMAX'); ?>>IMAX</option>
                    <option value="4DX" <?php selected($format, '4DX'); ?>>4DX</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="mbs_price">Giá Vé (VNĐ)</label></th>
            <td><input type="number" id="mbs_price" name="mbs_price" value="<?php echo esc_attr($price); ?>" class="regular-text" step="1000"></td>
        </tr>
    </table>
    <?php
}

// Save meta box data
add_action('save_post', 'mbs_save_meta_boxes');
function mbs_save_meta_boxes($post_id) {
    // Movie meta
    if (isset($_POST['mbs_movie_meta_box_nonce']) && wp_verify_nonce($_POST['mbs_movie_meta_box_nonce'], 'mbs_movie_meta_box')) {
        if (isset($_POST['mbs_duration'])) update_post_meta($post_id, '_mbs_duration', sanitize_text_field($_POST['mbs_duration']));
        if (isset($_POST['mbs_director'])) update_post_meta($post_id, '_mbs_director', sanitize_text_field($_POST['mbs_director']));
        if (isset($_POST['mbs_actors'])) update_post_meta($post_id, '_mbs_actors', sanitize_text_field($_POST['mbs_actors']));
        if (isset($_POST['mbs_release_date'])) update_post_meta($post_id, '_mbs_release_date', sanitize_text_field($_POST['mbs_release_date']));
        if (isset($_POST['mbs_rating'])) update_post_meta($post_id, '_mbs_rating', sanitize_text_field($_POST['mbs_rating']));
        if (isset($_POST['mbs_trailer_url'])) update_post_meta($post_id, '_mbs_trailer_url', esc_url_raw($_POST['mbs_trailer_url']));
        if (isset($_POST['mbs_language'])) update_post_meta($post_id, '_mbs_language', sanitize_text_field($_POST['mbs_language']));
    }
    
    // Cinema meta
    if (isset($_POST['mbs_cinema_meta_box_nonce']) && wp_verify_nonce($_POST['mbs_cinema_meta_box_nonce'], 'mbs_cinema_meta_box')) {
        if (isset($_POST['mbs_address'])) update_post_meta($post_id, '_mbs_address', sanitize_text_field($_POST['mbs_address']));
        if (isset($_POST['mbs_phone'])) update_post_meta($post_id, '_mbs_phone', sanitize_text_field($_POST['mbs_phone']));
        if (isset($_POST['mbs_total_rooms'])) update_post_meta($post_id, '_mbs_total_rooms', sanitize_text_field($_POST['mbs_total_rooms']));
    }
    
    // Showtime meta
    if (isset($_POST['mbs_showtime_meta_box_nonce']) && wp_verify_nonce($_POST['mbs_showtime_meta_box_nonce'], 'mbs_showtime_meta_box')) {
        if (isset($_POST['mbs_movie_id'])) update_post_meta($post_id, '_mbs_movie_id', sanitize_text_field($_POST['mbs_movie_id']));
        if (isset($_POST['mbs_cinema_id'])) update_post_meta($post_id, '_mbs_cinema_id', sanitize_text_field($_POST['mbs_cinema_id']));
        if (isset($_POST['mbs_showtime'])) update_post_meta($post_id, '_mbs_showtime', sanitize_text_field($_POST['mbs_showtime']));
        if (isset($_POST['mbs_room'])) update_post_meta($post_id, '_mbs_room', sanitize_text_field($_POST['mbs_room']));
        if (isset($_POST['mbs_price'])) update_post_meta($post_id, '_mbs_price', sanitize_text_field($_POST['mbs_price']));
        if (isset($_POST['mbs_format'])) update_post_meta($post_id, '_mbs_format', sanitize_text_field($_POST['mbs_format']));
    }
}

