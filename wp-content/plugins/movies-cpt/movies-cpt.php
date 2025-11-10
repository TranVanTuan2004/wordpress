<?php
/**
 * Plugin Name: Movies CPT
 * Description: Custom Post Type cho Phim
 * Version: 1.0.0
 */

if (!defined('ABSPATH')) exit;

// Đăng ký Custom Post Type: Movie
add_action('init', 'register_movie_post_type');
function register_movie_post_type() {
    $labels = array(
        'name' => 'Phim',
        'singular_name' => 'Phim',
        'add_new' => 'Thêm Phim',
        'add_new_item' => 'Thêm Phim Mới',
        'edit_item' => 'Sửa Phim',
        'new_item' => 'Phim Mới',
        'view_item' => 'Xem Phim',
        'search_items' => 'Tìm Phim',
        'not_found' => 'Không tìm thấy phim',
        'all_items' => 'Tất Cả Phim',
        'menu_name' => 'Phim'
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-video-alt3',
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'phim')  // Đổi thành 'movie' hoặc slug bạn muốn
    );
    
    register_post_type('movie', $args);
}

// Đăng ký Taxonomy: Thể loại
add_action('init', 'register_movie_taxonomy');
function register_movie_taxonomy() {
    register_taxonomy('movie_genre', 'movie', array(
        'label' => 'Thể Loại',
        'labels' => array(
            'name' => 'Thể Loại',
            'singular_name' => 'Thể Loại',
            'menu_name' => 'Thể Loại',
            'all_items' => 'Tất Cả Thể Loại',
            'edit_item' => 'Sửa Thể Loại',
            'add_new_item' => 'Thêm Thể Loại Mới'
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'the-loai')
    ));
    
    register_taxonomy('movie_status', 'movie', array(
        'label' => 'Trạng Thái',
        'labels' => array(
            'name' => 'Trạng Thái',
            'singular_name' => 'Trạng Thái',
            'menu_name' => 'Trạng Thái',
            'all_items' => 'Tất Cả Trạng Thái',
            'edit_item' => 'Sửa Trạng Thái',
            'add_new_item' => 'Thêm Trạng Thái Mới'
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'trang-thai'),
        'meta_box_cb' => 'post_categories_meta_box' // Hiển thị như checkbox
    ));
}

// Thêm Meta Box cho thông tin phim
add_action('add_meta_boxes', 'add_movie_meta_boxes');
function add_movie_meta_boxes() {
    add_meta_box(
        'movie_details',
        'Thông Tin Phim',
        'movie_details_callback',
        'movie',
        'normal',
        'high'
    );
}

function movie_details_callback($post) {
    wp_nonce_field('save_movie_details', 'movie_details_nonce');
    
    $rating = get_post_meta($post->ID, 'movie_rating', true);
    $duration = get_post_meta($post->ID, 'movie_duration', true);
    $release_date = get_post_meta($post->ID, 'movie_release_date', true);
    $trailer_url = get_post_meta($post->ID, 'movie_trailer_url', true);
    $imdb_rating = get_post_meta($post->ID, 'movie_imdb_rating', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="movie_rating">Độ Tuổi (P, 13+, 16+, 18+)</label></th>
            <td>
                <select name="movie_rating" id="movie_rating" style="width: 200px;">
                    <option value="P" <?php selected($rating, 'P'); ?>>P - Phổ thông</option>
                    <option value="13+" <?php selected($rating, '13+'); ?>>13+ - Trên 13 tuổi</option>
                    <option value="16+" <?php selected($rating, '16+'); ?>>16+ - Trên 16 tuổi</option>
                    <option value="18+" <?php selected($rating, '18+'); ?>>18+ - Trên 18 tuổi</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="movie_duration">Thời Lượng (phút)</label></th>
            <td><input type="number" name="movie_duration" id="movie_duration" value="<?php echo esc_attr($duration); ?>" style="width: 200px;"></td>
        </tr>
        <tr>
            <th><label for="movie_release_date">Ngày Khởi Chiếu</label></th>
            <td><input type="date" name="movie_release_date" id="movie_release_date" value="<?php echo esc_attr($release_date); ?>" style="width: 200px;"></td>
        </tr>
        <tr>
            <th><label for="movie_trailer_url">Link Trailer (YouTube)</label></th>
            <td><input type="url" name="movie_trailer_url" id="movie_trailer_url" value="<?php echo esc_attr($trailer_url); ?>" style="width: 100%;"></td>
        </tr>
        <tr>
            <th><label for="movie_imdb_rating">Điểm IMDb (0-10)</label></th>
            <td><input type="number" step="0.1" min="0" max="10" name="movie_imdb_rating" id="movie_imdb_rating" value="<?php echo esc_attr($imdb_rating); ?>" style="width: 200px;"></td>
        </tr>
    </table>
    <?php
}

// Lưu Meta Box
add_action('save_post_movie', 'save_movie_details');
function save_movie_details($post_id) {
    if (!isset($_POST['movie_details_nonce']) || !wp_verify_nonce($_POST['movie_details_nonce'], 'save_movie_details')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['movie_rating'])) {
        update_post_meta($post_id, 'movie_rating', sanitize_text_field($_POST['movie_rating']));
    }
    
    if (isset($_POST['movie_duration'])) {
        update_post_meta($post_id, 'movie_duration', intval($_POST['movie_duration']));
    }
    
    if (isset($_POST['movie_release_date'])) {
        update_post_meta($post_id, 'movie_release_date', sanitize_text_field($_POST['movie_release_date']));
    }
    
    if (isset($_POST['movie_trailer_url'])) {
        update_post_meta($post_id, 'movie_trailer_url', esc_url_raw($_POST['movie_trailer_url']));
    }
    
    if (isset($_POST['movie_imdb_rating'])) {
        update_post_meta($post_id, 'movie_imdb_rating', floatval($_POST['movie_imdb_rating']));
    }
}

// Flush rewrite rules khi activate
register_activation_hook(__FILE__, 'movies_cpt_activate');
function movies_cpt_activate() {
    register_movie_post_type();
    register_movie_taxonomy();
    flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'movies_cpt_deactivate');
function movies_cpt_deactivate() {
    flush_rewrite_rules();
}

