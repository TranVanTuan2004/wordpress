<?php
/**
 * Shortcodes Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class MBS_Shortcodes {
    
    public function __construct() {
        add_shortcode('mbs_movies_list', array($this, 'movies_list'));
        add_shortcode('mbs_movie_detail', array($this, 'movie_detail'));
        add_shortcode('mbs_cinema_list', array($this, 'cinema_list'));
        add_shortcode('mbs_booking_form', array($this, 'booking_form'));
    }
    
    /**
     * Display movies list (Home page)
     */
    public function movies_list($atts) {
        $atts = shortcode_atts(array(
            'per_page' => 12,
            'genre' => '',
        ), $atts);
        
        $args = array(
            'post_type' => 'mbs_movie',
            'posts_per_page' => $atts['per_page'],
            'post_status' => 'publish'
        );
        
        if (!empty($atts['genre'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'mbs_genre',
                    'field' => 'slug',
                    'terms' => $atts['genre']
                )
            );
        }
        
        $movies = new WP_Query($args);
        
        ob_start();
        include MBS_PLUGIN_DIR . 'templates/movies-list.php';
        return ob_get_clean();
    }
    
    /**
     * Display movie detail with showtimes
     */
    public function movie_detail($atts) {
        $atts = shortcode_atts(array(
            'id' => get_the_ID(),
        ), $atts);
        
        $movie_id = $atts['id'];
        $movie = get_post($movie_id);
        
        if (!$movie || $movie->post_type != 'mbs_movie') {
            return '<p>Phim không tồn tại.</p>';
        }
        
        // Get movie metadata
        $duration = get_post_meta($movie_id, '_mbs_duration', true);
        $director = get_post_meta($movie_id, '_mbs_director', true);
        $actors = get_post_meta($movie_id, '_mbs_actors', true);
        $rating = get_post_meta($movie_id, '_mbs_rating', true);
        $language = get_post_meta($movie_id, '_mbs_language', true);
        $trailer_url = get_post_meta($movie_id, '_mbs_trailer_url', true);
        
        // Get showtimes for this movie
        $showtimes = $this->get_movie_showtimes($movie_id);
        
        ob_start();
        include MBS_PLUGIN_DIR . 'templates/movie-detail.php';
        return ob_get_clean();
    }
    
    /**
     * Display cinema list
     */
    public function cinema_list($atts) {
        $atts = shortcode_atts(array(
            'per_page' => -1,
        ), $atts);
        
        $cinemas = get_posts(array(
            'post_type' => 'mbs_cinema',
            'posts_per_page' => $atts['per_page'],
            'post_status' => 'publish'
        ));
        
        ob_start();
        include MBS_PLUGIN_DIR . 'templates/cinema-list.php';
        return ob_get_clean();
    }
    
    /**
     * Display booking form with seat selection
     */
    public function booking_form($atts) {
        $atts = shortcode_atts(array(
            'showtime_id' => 0,
        ), $atts);
        
        $showtime_id = $atts['showtime_id'];
        if (isset($_GET['showtime_id'])) {
            $showtime_id = intval($_GET['showtime_id']);
        }
        
        if (!$showtime_id) {
            return '<p>Vui lòng chọn suất chiếu.</p>';
        }
        
        $showtime = get_post($showtime_id);
        if (!$showtime || $showtime->post_type != 'mbs_showtime') {
            return '<p>Suất chiếu không tồn tại.</p>';
        }
        
        // Get showtime details
        $movie_id = get_post_meta($showtime_id, '_mbs_movie_id', true);
        $cinema_id = get_post_meta($showtime_id, '_mbs_cinema_id', true);
        $showtime_datetime = get_post_meta($showtime_id, '_mbs_showtime', true);
        $room = get_post_meta($showtime_id, '_mbs_room', true);
        $format = get_post_meta($showtime_id, '_mbs_format', true);
        $price = get_post_meta($showtime_id, '_mbs_price', true);
        
        $movie = get_post($movie_id);
        $cinema = get_post($cinema_id);
        
        // Get booked seats
        $booked_seats = MBS_Database::get_booked_seats($showtime_id);
        
        ob_start();
        include MBS_PLUGIN_DIR . 'templates/booking-form.php';
        return ob_get_clean();
    }
    
    /**
     * Get showtimes for a movie
     */
    private function get_movie_showtimes($movie_id) {
        global $wpdb;
        
        $showtimes = get_posts(array(
            'post_type' => 'mbs_showtime',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_mbs_movie_id',
                    'value' => $movie_id,
                    'compare' => '='
                )
            )
        ));
        
        // Group by cinema and date
        $grouped_showtimes = array();
        foreach ($showtimes as $showtime) {
            $cinema_id = get_post_meta($showtime->ID, '_mbs_cinema_id', true);
            $showtime_datetime = get_post_meta($showtime->ID, '_mbs_showtime', true);
            $date = date('Y-m-d', strtotime($showtime_datetime));
            
            if (!isset($grouped_showtimes[$cinema_id])) {
                $cinema = get_post($cinema_id);
                $grouped_showtimes[$cinema_id] = array(
                    'cinema' => $cinema,
                    'dates' => array()
                );
            }
            
            if (!isset($grouped_showtimes[$cinema_id]['dates'][$date])) {
                $grouped_showtimes[$cinema_id]['dates'][$date] = array();
            }
            
            $grouped_showtimes[$cinema_id]['dates'][$date][] = array(
                'id' => $showtime->ID,
                'time' => date('H:i', strtotime($showtime_datetime)),
                'room' => get_post_meta($showtime->ID, '_mbs_room', true),
                'format' => get_post_meta($showtime->ID, '_mbs_format', true),
                'price' => get_post_meta($showtime->ID, '_mbs_price', true)
            );
        }
        
        return $grouped_showtimes;
    }
}

