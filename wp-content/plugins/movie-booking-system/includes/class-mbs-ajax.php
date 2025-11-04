<?php
/**
 * AJAX Handler Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class MBS_Ajax {
    
    public function __construct() {
        // Get booked seats
        add_action('wp_ajax_mbs_get_booked_seats', array($this, 'get_booked_seats'));
        add_action('wp_ajax_nopriv_mbs_get_booked_seats', array($this, 'get_booked_seats'));
        
        // Create booking
        add_action('wp_ajax_mbs_create_booking', array($this, 'create_booking'));
        add_action('wp_ajax_nopriv_mbs_create_booking', array($this, 'create_booking'));
        
        // Get showtimes by cinema and date
        add_action('wp_ajax_mbs_get_showtimes', array($this, 'get_showtimes'));
        add_action('wp_ajax_nopriv_mbs_get_showtimes', array($this, 'get_showtimes'));
        
        // Check seat availability
        add_action('wp_ajax_mbs_check_seats', array($this, 'check_seats'));
        add_action('wp_ajax_nopriv_mbs_check_seats', array($this, 'check_seats'));
    }
    
    /**
     * Get booked seats for a showtime
     */
    public function get_booked_seats() {
        check_ajax_referer('mbs_nonce', 'nonce');
        
        $showtime_id = isset($_POST['showtime_id']) ? intval($_POST['showtime_id']) : 0;
        
        if (!$showtime_id) {
            wp_send_json_error(array('message' => 'Invalid showtime ID'));
        }
        
        $seats = MBS_Database::get_booked_seats($showtime_id);
        
        $booked_seats = array();
        foreach ($seats as $seat) {
            $booked_seats[] = $seat->seat_number;
        }
        
        wp_send_json_success(array('booked_seats' => $booked_seats));
    }
    
    /**
     * Create a new booking
     */
    public function create_booking() {
        check_ajax_referer('mbs_nonce', 'nonce');
        
        // Validate input
        $showtime_id = isset($_POST['showtime_id']) ? intval($_POST['showtime_id']) : 0;
        $customer_name = isset($_POST['customer_name']) ? sanitize_text_field($_POST['customer_name']) : '';
        $customer_email = isset($_POST['customer_email']) ? sanitize_email($_POST['customer_email']) : '';
        $customer_phone = isset($_POST['customer_phone']) ? sanitize_text_field($_POST['customer_phone']) : '';
        $seats = isset($_POST['seats']) ? json_decode(stripslashes($_POST['seats']), true) : array();
        
        // Validation
        if (!$showtime_id || empty($customer_name) || empty($customer_email) || empty($customer_phone) || empty($seats)) {
            wp_send_json_error(array('message' => 'Vui lòng điền đầy đủ thông tin'));
            return;
        }
        
        if (!is_email($customer_email)) {
            wp_send_json_error(array('message' => 'Email không hợp lệ'));
            return;
        }
        
        // Check if seats are still available
        $booked_seats = MBS_Database::get_booked_seats($showtime_id);
        $booked_seat_numbers = array();
        foreach ($booked_seats as $seat) {
            $booked_seat_numbers[] = $seat->seat_number;
        }
        
        foreach ($seats as $seat) {
            if (in_array($seat['seat_number'], $booked_seat_numbers)) {
                wp_send_json_error(array('message' => 'Ghế ' . $seat['seat_number'] . ' đã được đặt. Vui lòng chọn ghế khác.'));
                return;
            }
        }
        
        // Calculate total price
        $total_price = 0;
        foreach ($seats as $seat) {
            $total_price += floatval($seat['seat_price']);
        }
        
        // Create booking
        $booking_data = array(
            'showtime_id' => $showtime_id,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_phone' => $customer_phone,
            'seats' => $seats,
            'total_price' => $total_price
        );
        
        $result = MBS_Database::create_booking($booking_data);
        
        if ($result['success']) {
            // Send confirmation email (optional)
            $this->send_booking_confirmation($customer_email, $result['booking_code'], $booking_data);
            
            wp_send_json_success(array(
                'message' => 'Đặt vé thành công!',
                'booking_code' => $result['booking_code'],
                'booking_id' => $result['booking_id']
            ));
        } else {
            wp_send_json_error(array('message' => 'Có lỗi xảy ra. Vui lòng thử lại.'));
        }
    }
    
    /**
     * Get showtimes by cinema and date
     */
    public function get_showtimes() {
        check_ajax_referer('mbs_nonce', 'nonce');
        
        $movie_id = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : 0;
        $cinema_id = isset($_POST['cinema_id']) ? intval($_POST['cinema_id']) : 0;
        $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';
        
        if (!$movie_id || !$cinema_id || !$date) {
            wp_send_json_error(array('message' => 'Invalid parameters'));
        }
        
        $meta_query = array(
            'relation' => 'AND',
            array(
                'key' => '_mbs_movie_id',
                'value' => $movie_id,
                'compare' => '='
            ),
            array(
                'key' => '_mbs_cinema_id',
                'value' => $cinema_id,
                'compare' => '='
            )
        );
        
        $showtimes = get_posts(array(
            'post_type' => 'mbs_showtime',
            'posts_per_page' => -1,
            'meta_query' => $meta_query
        ));
        
        $filtered_showtimes = array();
        foreach ($showtimes as $showtime) {
            $showtime_datetime = get_post_meta($showtime->ID, '_mbs_showtime', true);
            $showtime_date = date('Y-m-d', strtotime($showtime_datetime));
            
            if ($showtime_date == $date) {
                $filtered_showtimes[] = array(
                    'id' => $showtime->ID,
                    'time' => date('H:i', strtotime($showtime_datetime)),
                    'room' => get_post_meta($showtime->ID, '_mbs_room', true),
                    'format' => get_post_meta($showtime->ID, '_mbs_format', true),
                    'price' => get_post_meta($showtime->ID, '_mbs_price', true)
                );
            }
        }
        
        wp_send_json_success(array('showtimes' => $filtered_showtimes));
    }
    
    /**
     * Check if selected seats are still available
     */
    public function check_seats() {
        check_ajax_referer('mbs_nonce', 'nonce');
        
        $showtime_id = isset($_POST['showtime_id']) ? intval($_POST['showtime_id']) : 0;
        $seat_numbers = isset($_POST['seat_numbers']) ? json_decode(stripslashes($_POST['seat_numbers']), true) : array();
        
        if (!$showtime_id || empty($seat_numbers)) {
            wp_send_json_error(array('message' => 'Invalid parameters'));
        }
        
        $booked_seats = MBS_Database::get_booked_seats($showtime_id);
        $booked_seat_numbers = array();
        foreach ($booked_seats as $seat) {
            $booked_seat_numbers[] = $seat->seat_number;
        }
        
        $unavailable = array();
        foreach ($seat_numbers as $seat_number) {
            if (in_array($seat_number, $booked_seat_numbers)) {
                $unavailable[] = $seat_number;
            }
        }
        
        if (!empty($unavailable)) {
            wp_send_json_error(array(
                'message' => 'Một số ghế đã được đặt',
                'unavailable_seats' => $unavailable
            ));
        } else {
            wp_send_json_success(array('message' => 'Tất cả ghế đều còn trống'));
        }
    }
    
    /**
     * Send booking confirmation email
     */
    private function send_booking_confirmation($email, $booking_code, $booking_data) {
        $subject = 'Xác nhận đặt vé - Mã đặt vé: ' . $booking_code;
        
        $message = '<html><body>';
        $message .= '<h2>Cảm ơn bạn đã đặt vé!</h2>';
        $message .= '<p><strong>Mã đặt vé:</strong> ' . $booking_code . '</p>';
        $message .= '<p><strong>Tên khách hàng:</strong> ' . $booking_data['customer_name'] . '</p>';
        $message .= '<p><strong>Số điện thoại:</strong> ' . $booking_data['customer_phone'] . '</p>';
        $message .= '<p><strong>Tổng số ghế:</strong> ' . count($booking_data['seats']) . '</p>';
        $message .= '<p><strong>Tổng tiền:</strong> ' . number_format($booking_data['total_price'], 0, ',', '.') . ' VNĐ</p>';
        $message .= '<p>Vui lòng đến rạp trước giờ chiếu 15 phút để làm thủ tục.</p>';
        $message .= '</body></html>';
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        wp_mail($email, $subject, $message, $headers);
    }
}

