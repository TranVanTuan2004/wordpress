<?php
/**
 * Helper Functions Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class MBS_Helpers {
    
    /**
     * Format price in Vietnamese currency
     */
    public static function format_price($price) {
        return number_format($price, 0, ',', '.') . ' VNĐ';
    }
    
    /**
     * Get movie rating label
     */
    public static function get_rating_label($rating) {
        $labels = array(
            'P' => 'P - Phổ biến',
            'C13' => 'C13 - 13+',
            'C16' => 'C16 - 16+',
            'C18' => 'C18 - 18+'
        );
        
        return isset($labels[$rating]) ? $labels[$rating] : $rating;
    }
    
    /**
     * Get payment status label
     */
    public static function get_payment_status_label($status) {
        $labels = array(
            'pending' => 'Chờ thanh toán',
            'completed' => 'Đã thanh toán',
            'cancelled' => 'Đã hủy'
        );
        
        return isset($labels[$status]) ? $labels[$status] : $status;
    }
    
    /**
     * Generate unique booking code
     */
    public static function generate_booking_code() {
        return 'MBS' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
    }
    
    /**
     * Get seat type label
     */
    public static function get_seat_type_label($type) {
        $labels = array(
            'regular' => 'Ghế thường',
            'vip' => 'Ghế VIP',
            'sweetbox' => 'Ghế Sweetbox'
        );
        
        return isset($labels[$type]) ? $labels[$type] : $type;
    }
    
    /**
     * Format datetime for display
     */
    public static function format_datetime($datetime, $format = 'd/m/Y H:i') {
        return date($format, strtotime($datetime));
    }
    
    /**
     * Get weekday in Vietnamese
     */
    public static function get_weekday($date) {
        $weekdays = array('CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7');
        $date_obj = new DateTime($date);
        return $weekdays[$date_obj->format('w')];
    }
    
    /**
     * Validate email
     */
    public static function validate_email($email) {
        return is_email($email);
    }
    
    /**
     * Validate phone number (Vietnamese)
     */
    public static function validate_phone($phone) {
        // Remove spaces and dashes
        $phone = preg_replace('/[\s\-]/', '', $phone);
        
        // Check if it's a valid Vietnamese phone number
        // 10 digits starting with 0 or 84
        return preg_match('/^(0|\+?84)[0-9]{9}$/', $phone);
    }
    
    /**
     * Sanitize seat number
     */
    public static function sanitize_seat_number($seat) {
        // Format: A1, B12, etc.
        return strtoupper(preg_replace('/[^A-Z0-9]/', '', $seat));
    }
    
    /**
     * Get available seat types with prices
     */
    public static function get_seat_types_with_prices() {
        return array(
            'regular' => array(
                'label' => 'Ghế thường',
                'price' => get_option('mbs_regular_seat_price', 70000)
            ),
            'vip' => array(
                'label' => 'Ghế VIP',
                'price' => get_option('mbs_vip_seat_price', 100000)
            ),
            'sweetbox' => array(
                'label' => 'Ghế Sweetbox',
                'price' => get_option('mbs_sweetbox_seat_price', 150000)
            )
        );
    }
    
    /**
     * Calculate discount (for future use)
     */
    public static function calculate_discount($price, $discount_percent) {
        return $price - ($price * $discount_percent / 100);
    }
    
    /**
     * Check if showtime is in the past
     */
    public static function is_showtime_past($showtime_datetime) {
        return strtotime($showtime_datetime) < time();
    }
    
    /**
     * Get movie poster URL
     */
    public static function get_movie_poster($movie_id, $size = 'medium') {
        $poster_url = get_the_post_thumbnail_url($movie_id, $size);
        
        if (!$poster_url) {
            $poster_url = MBS_PLUGIN_URL . 'assets/images/no-poster.jpg';
        }
        
        return $poster_url;
    }
    
    /**
     * Send email notification
     */
    public static function send_email($to, $subject, $message) {
        $headers = array('Content-Type: text/html; charset=UTF-8');
        return wp_mail($to, $subject, $message, $headers);
    }
    
    /**
     * Log activity (for debugging)
     */
    public static function log($message, $type = 'info') {
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            error_log('[MBS ' . strtoupper($type) . '] ' . $message);
        }
    }
}

