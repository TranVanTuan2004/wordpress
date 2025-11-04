<?php
/**
 * Database Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class MBS_Database {
    
    public static function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        
        // Bookings table
        $table_bookings = $wpdb->prefix . 'mbs_bookings';
        $sql_bookings = "CREATE TABLE IF NOT EXISTS $table_bookings (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            showtime_id bigint(20) NOT NULL,
            customer_name varchar(255) NOT NULL,
            customer_email varchar(255) NOT NULL,
            customer_phone varchar(20) NOT NULL,
            total_seats int(11) NOT NULL,
            total_price decimal(10,2) NOT NULL,
            booking_code varchar(50) NOT NULL,
            payment_status varchar(20) DEFAULT 'pending',
            booking_date datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY showtime_id (showtime_id),
            KEY booking_code (booking_code)
        ) $charset_collate;";
        
        // Seats table
        $table_seats = $wpdb->prefix . 'mbs_seats';
        $sql_seats = "CREATE TABLE IF NOT EXISTS $table_seats (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            booking_id bigint(20) NOT NULL,
            showtime_id bigint(20) NOT NULL,
            seat_number varchar(10) NOT NULL,
            seat_type varchar(20) DEFAULT 'regular',
            seat_price decimal(10,2) NOT NULL,
            status varchar(20) DEFAULT 'booked',
            PRIMARY KEY  (id),
            KEY booking_id (booking_id),
            KEY showtime_id (showtime_id),
            UNIQUE KEY unique_seat (showtime_id, seat_number)
        ) $charset_collate;";
        
        // Cinema rooms table
        $table_rooms = $wpdb->prefix . 'mbs_cinema_rooms';
        $sql_rooms = "CREATE TABLE IF NOT EXISTS $table_rooms (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            cinema_id bigint(20) NOT NULL,
            room_name varchar(100) NOT NULL,
            total_rows int(11) DEFAULT 10,
            seats_per_row int(11) DEFAULT 17,
            seat_layout text,
            PRIMARY KEY  (id),
            KEY cinema_id (cinema_id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_bookings);
        dbDelta($sql_seats);
        dbDelta($sql_rooms);
    }
    
    public static function get_booked_seats($showtime_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'mbs_seats';
        
        $seats = $wpdb->get_results($wpdb->prepare(
            "SELECT seat_number, seat_type, status FROM $table WHERE showtime_id = %d AND status = 'booked'",
            $showtime_id
        ));
        
        return $seats;
    }
    
    public static function create_booking($data) {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'mbs_bookings';
        $table_seats = $wpdb->prefix . 'mbs_seats';
        
        // Generate booking code
        $booking_code = 'MBS' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        
        // Insert booking
        $wpdb->insert(
            $table_bookings,
            array(
                'showtime_id' => $data['showtime_id'],
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
                'total_seats' => count($data['seats']),
                'total_price' => $data['total_price'],
                'booking_code' => $booking_code,
                'payment_status' => 'pending'
            ),
            array('%d', '%s', '%s', '%s', '%d', '%f', '%s', '%s')
        );
        
        $booking_id = $wpdb->insert_id;
        
        // Insert seats
        if ($booking_id && !empty($data['seats'])) {
            foreach ($data['seats'] as $seat) {
                $wpdb->insert(
                    $table_seats,
                    array(
                        'booking_id' => $booking_id,
                        'showtime_id' => $data['showtime_id'],
                        'seat_number' => $seat['seat_number'],
                        'seat_type' => $seat['seat_type'],
                        'seat_price' => $seat['seat_price'],
                        'status' => 'booked'
                    ),
                    array('%d', '%d', '%s', '%s', '%f', '%s')
                );
            }
        }
        
        return array(
            'success' => true,
            'booking_id' => $booking_id,
            'booking_code' => $booking_code
        );
    }
    
    public static function get_booking_by_code($booking_code) {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'mbs_bookings';
        $table_seats = $wpdb->prefix . 'mbs_seats';
        
        $booking = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_bookings WHERE booking_code = %s",
            $booking_code
        ));
        
        if ($booking) {
            $seats = $wpdb->get_results($wpdb->prepare(
                "SELECT * FROM $table_seats WHERE booking_id = %d",
                $booking->id
            ));
            
            $booking->seats = $seats;
        }
        
        return $booking;
    }
}

