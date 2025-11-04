<?php
/**
 * Uninstall Movie Booking System
 * 
 * This file runs when the plugin is deleted
 */

// If uninstall not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

// Delete custom post types
$post_types = array('mbs_movie', 'mbs_cinema', 'mbs_showtime');
foreach ($post_types as $post_type) {
    $posts = get_posts(array(
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'post_status' => 'any'
    ));
    
    foreach ($posts as $post) {
        wp_delete_post($post->ID, true);
    }
}

// Delete taxonomies
$taxonomies = array('mbs_genre');
foreach ($taxonomies as $taxonomy) {
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false
    ));
    
    foreach ($terms as $term) {
        wp_delete_term($term->term_id, $taxonomy);
    }
}

// Delete custom tables
$table_bookings = $wpdb->prefix . 'mbs_bookings';
$table_seats = $wpdb->prefix . 'mbs_seats';
$table_rooms = $wpdb->prefix . 'mbs_cinema_rooms';

$wpdb->query("DROP TABLE IF EXISTS $table_seats");
$wpdb->query("DROP TABLE IF EXISTS $table_bookings");
$wpdb->query("DROP TABLE IF EXISTS $table_rooms");

// Delete options
delete_option('mbs_seat_rows');
delete_option('mbs_seats_per_row');
delete_option('mbs_regular_seat_price');
delete_option('mbs_vip_seat_price');
delete_option('mbs_sweetbox_seat_price');
delete_option('mbs_version');

// Clear any cached data
wp_cache_flush();

