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

