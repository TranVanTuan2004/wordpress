<?php
/**
 * Plugin Name: Site Layout - Header & Footer
 * Description: Header và Footer chung cho toàn bộ website
 * Version: 1.0.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

define('SITE_LAYOUT_DIR', plugin_dir_path(__FILE__));
define('SITE_LAYOUT_URL', plugin_dir_url(__FILE__));

// Enqueue CSS và JS
add_action('wp_enqueue_scripts', 'site_layout_enqueue_assets');
function site_layout_enqueue_assets() {
    wp_enqueue_style('site-layout-css', SITE_LAYOUT_URL . 'assets/layout.css', array(), '1.0.0');
    wp_enqueue_script('site-layout-js', SITE_LAYOUT_URL . 'assets/layout.js', array('jquery'), '1.0.0', true);
}

// Shortcode để include header
add_shortcode('site_header', 'site_layout_header');
function site_layout_header() {
    ob_start();
    include SITE_LAYOUT_DIR . 'templates/header.php';
    return ob_get_clean();
}

// Shortcode để include footer
add_shortcode('site_footer', 'site_layout_footer');
function site_layout_footer() {
    ob_start();
    include SITE_LAYOUT_DIR . 'templates/footer.php';
    return ob_get_clean();
}

// Shortcode để include hero banner
add_shortcode('hero_banner', 'site_layout_hero_banner');
function site_layout_hero_banner() {
    ob_start();
    include SITE_LAYOUT_DIR . 'templates/hero-banner.php';
    return ob_get_clean();
}

// Shortcode: Phim đang chiếu
add_shortcode('movies_now_showing', 'site_layout_movies_now_showing');
function site_layout_movies_now_showing() {
    ob_start();
    include SITE_LAYOUT_DIR . 'templates/movies-now-showing.php';
    return ob_get_clean();
}

// Shortcode: Phim sắp chiếu
add_shortcode('movies_coming_soon', 'site_layout_movies_coming_soon');
function site_layout_movies_coming_soon() {
    ob_start();
    include SITE_LAYOUT_DIR . 'templates/movies-coming-soon.php';
    return ob_get_clean();
}

// Shortcode: Lịch chiếu phim
add_shortcode('movie_schedule', 'site_layout_movie_schedule');
function site_layout_movie_schedule() {
    ob_start();
    include SITE_LAYOUT_DIR . 'templates/movie-schedule.php';
    return ob_get_clean();
}

// Shortcode: Trang Home đầy đủ
add_shortcode('full_home_page', 'site_layout_full_home');
function site_layout_full_home() {
    ob_start();
    include SITE_LAYOUT_DIR . 'templates/hero-banner.php';
    include SITE_LAYOUT_DIR . 'templates/movies-now-showing.php';
    include SITE_LAYOUT_DIR . 'templates/movies-coming-soon.php';
    include SITE_LAYOUT_DIR . 'templates/movie-schedule.php';
    return ob_get_clean();
}

// Shortcode: Debug Movies (kiểm tra data)
add_shortcode('debug_movies', 'site_layout_debug_movies');
function site_layout_debug_movies() {
    ob_start();
    include SITE_LAYOUT_DIR . 'templates/debug-movies.php';
    return ob_get_clean();
}

// Shortcode: Lịch sử đặt vé của user
add_shortcode('user_booking_history', 'site_layout_user_booking_history');
function site_layout_user_booking_history() {
    ob_start();
    include SITE_LAYOUT_DIR . 'templates/user-booking-history.php';
    return ob_get_clean();
}

// Shortcode: Movie Detail (chi tiết phim)
// Usage: [movie_detail id="123"]
add_shortcode('movie_detail', 'site_layout_movie_detail');
function site_layout_movie_detail($atts) {
    $atts = shortcode_atts(array(
        'id' => 0,
    ), $atts);
    
    ob_start();
    include SITE_LAYOUT_DIR . 'templates/movie-detail-shortcode.php';
    return ob_get_clean();
}

// Shortcode: Movies List (danh sách phim từ CPT "movie")
// Usage: [movies_list genre="hanh-dong" status="dang-chieu" per_page="12"]
add_shortcode('movies_list', 'site_layout_movies_list');
function site_layout_movies_list($atts) {
   ob_start();
//    include SITE_LAYOUT_DIR . 'templates/hero-banner.php';
   include SITE_LAYOUT_DIR . 'templates/movies-now-showing.php';
   include SITE_LAYOUT_DIR . 'templates/movies-coming-soon.php';
   return ob_get_clean();
   
}

// Function helper để tạo trang full layout
function site_render_full_layout($content) {
    ob_start();
    include SITE_LAYOUT_DIR . 'templates/header.php';
    echo '<main class="site-content">';
    echo $content;
    echo '</main>';
    include SITE_LAYOUT_DIR . 'templates/footer.php';
    return ob_get_clean();
}

// Register Page Templates
add_filter('theme_page_templates', 'site_layout_add_page_templates');
function site_layout_add_page_templates($templates) {
    $templates['page-templates/full-width-with-header-footer.php'] = 'Full Width - Có Header Footer';
    $templates['page-templates/container-with-header-footer.php'] = 'Container - Có Header Footer';
    $templates['page-templates/blank-no-header-footer.php'] = 'Blank - Không Header Footer';
    $templates['page-templates/centered-box.php'] = 'Centered Box - Hộp Giữa Màn Hình';
    $templates['page-templates/auth-minimal.php'] = 'Auth Minimal - Không Header Footer';
    $templates['page-templates/empty-layout.php'] = 'Empty Layout - Layout Trống';
    $templates['page-templates/movies-list-page.php'] = 'Movies List Page - Danh Sách Phim Có Phân Trang';
    return $templates;
}

// Load Page Templates
add_filter('template_include', 'site_layout_load_page_templates');
function site_layout_load_page_templates($template) {
    if (is_page()) {
        $page_template = get_page_template_slug();
        
        if (strpos($page_template, 'page-templates/') === 0) {
            $plugin_template = SITE_LAYOUT_DIR . $page_template;
            
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }
    }
    
    return $template;
}

// Auto create Movie List page on activation
register_activation_hook(__FILE__, 'site_layout_create_movie_list_page');
function site_layout_create_movie_list_page() {
    // Check if page already exists
    $page_title = 'Danh Sách Phim';
    $page_slug = 'danh-sach-phim';
    
    $existing_page = get_page_by_path($page_slug);
    
    if (!$existing_page) {
        // Create the page
        $page_data = array(
            'post_title'    => $page_title,
            'post_name'     => $page_slug,
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => 1,
            'page_template' => 'page-templates/movies-list-page.php'
        );
        
        $page_id = wp_insert_post($page_data);
        
        if ($page_id && !is_wp_error($page_id)) {
            // Set page template
            update_post_meta($page_id, '_wp_page_template', 'page-templates/movies-list-page.php');
        }
    }
}

// Add admin notice to guide user
add_action('admin_notices', 'site_layout_movie_list_page_notice');
function site_layout_movie_list_page_notice() {
    $screen = get_current_screen();
    
    // Only show on pages list and edit page
    if ($screen && ($screen->id === 'edit-page' || $screen->id === 'page')) {
        $page_slug = 'danh-sach-phim';
        $existing_page = get_page_by_path($page_slug);
        
        if (!$existing_page) {
            ?>
            <div class="notice notice-info is-dismissible">
                <p>
                    <strong>Site Layout Plugin:</strong> 
                    Bạn có thể tạo trang "Danh Sách Phim" bằng cách: 
                    <a href="<?php echo admin_url('post-new.php?post_type=page'); ?>">Tạo trang mới</a> 
                    và chọn template <strong>"Movies List Page - Danh Sách Phim Có Phân Trang"</strong>
                </p>
            </div>
            <?php
        }
    }
}

