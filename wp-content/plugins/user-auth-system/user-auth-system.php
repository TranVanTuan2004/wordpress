<?php
/**
 * Plugin Name: User Auth System
 * Description: Hệ thống đăng ký, đăng nhập và profile với giao diện đẹp
 * Version: 2.0.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

define('UAS_DIR', plugin_dir_path(__FILE__));
define('UAS_URL', plugin_dir_url(__FILE__));

// Enqueue CSS và JS
add_action('wp_enqueue_scripts', 'uas_enqueue_assets');
function uas_enqueue_assets() {
    wp_enqueue_style('uas-style', UAS_URL . 'assets/style.css', array(), '2.0.0');
    wp_enqueue_script('uas-script', UAS_URL . 'assets/script.js', array('jquery'), '2.0.0', true);
    
    // Localize script cho AJAX
    wp_localize_script('uas-script', 'uasAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('uas_nonce')
    ));
}

// Include các file chức năng
require_once UAS_DIR . 'includes/login.php';
require_once UAS_DIR . 'includes/register.php';
require_once UAS_DIR . 'includes/profile.php';

// Register Shortcodes
add_shortcode('uas_login', 'uas_login_form');
add_shortcode('uas_register', 'uas_register_form');
add_shortcode('uas_profile', 'uas_profile_page');

// Template redirect để bypass theme (TẮT để dùng header/footer của theme)
// Nếu muốn dùng lại, bỏ comment ở 3 dòng dưới
/*
add_action('template_redirect', 'uas_template_redirect');
function uas_template_redirect() {
    global $post;
    
    if (is_page() && isset($post->post_content)) {
        $has_auth_shortcode = (
            has_shortcode($post->post_content, 'uas_login') ||
            has_shortcode($post->post_content, 'uas_register') ||
            has_shortcode($post->post_content, 'uas_profile')
        );
        
        if ($has_auth_shortcode) {
            // Render trang với layout tùy chỉnh
            include UAS_DIR . 'templates/page-wrapper.php';
            exit;
        }
    }
}
*/

