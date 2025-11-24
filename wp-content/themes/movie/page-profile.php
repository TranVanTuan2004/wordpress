<?php
/**
 * Template Name: Trang Profile
 */
get_header();
if (! is_user_logged_in()) {
    wp_safe_redirect(home_url('/dangnhap'));
    exit;
}

// Kiểm tra tab parameter
$tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'profile';

if ($tab === 'history') {
    include locate_template('auth/booking-history.php', false, false);
} else {
    include locate_template('auth/profile.php', false, false);
}

get_footer();