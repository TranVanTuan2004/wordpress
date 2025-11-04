<?php
/**
 * Plugin Name: Movie Booking System
 * Plugin URI: https://example.com
 * Description: Hệ thống đặt vé xem phim hoàn chỉnh với chức năng chọn ghế, lịch chiếu và quản lý rạp
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * Text Domain: movie-booking-system
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('MBS_VERSION', '1.0.0');
define('MBS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MBS_PLUGIN_URL', plugin_dir_url(__FILE__));

class Movie_Booking_System {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->includes();
        $this->init_hooks();
    }
    
    private function includes() {
        require_once MBS_PLUGIN_DIR . 'includes/class-mbs-helpers.php';
        require_once MBS_PLUGIN_DIR . 'includes/class-mbs-post-types.php';
        require_once MBS_PLUGIN_DIR . 'includes/class-mbs-database.php';
        require_once MBS_PLUGIN_DIR . 'includes/class-mbs-shortcodes.php';
        require_once MBS_PLUGIN_DIR . 'includes/class-mbs-ajax.php';
        require_once MBS_PLUGIN_DIR . 'includes/class-mbs-admin.php';
        require_once MBS_PLUGIN_DIR . 'includes/class-mbs-sample-data.php';
    }
    
    private function init_hooks() {
        add_action('plugins_loaded', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    public function init() {
        new MBS_Post_Types();
        new MBS_Shortcodes();
        new MBS_Ajax();
        new MBS_Admin();
    }
    
    public function enqueue_scripts() {
        // Enqueue CSS
        wp_enqueue_style('mbs-styles', MBS_PLUGIN_URL . 'assets/css/style.css', array(), MBS_VERSION);
        
        // Enqueue JS
        wp_enqueue_script('mbs-script', MBS_PLUGIN_URL . 'assets/js/script.js', array('jquery'), MBS_VERSION, true);
        
        // Localize script
        wp_localize_script('mbs-script', 'mbs_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('mbs_nonce')
        ));
    }
    
    public function activate() {
        MBS_Database::create_tables();
        
        // Set default options
        add_option('mbs_seat_rows', 10);
        add_option('mbs_seats_per_row', 17);
        add_option('mbs_regular_seat_price', 70000);
        add_option('mbs_vip_seat_price', 100000);
        add_option('mbs_sweetbox_seat_price', 150000);
        add_option('mbs_version', MBS_VERSION);
        
        flush_rewrite_rules();
    }
    
    public function deactivate() {
        flush_rewrite_rules();
    }
}

// Initialize the plugin
function MBS() {
    return Movie_Booking_System::get_instance();
}

MBS();

