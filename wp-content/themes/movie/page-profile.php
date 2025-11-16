<?php
/**
 * Template Name: Trang Profile
 */
get_header();
if (! is_user_logged_in()) {
    wp_safe_redirect(home_url('/dangnhap'));
    exit;
}
include locate_template('auth/profile.php', false, false);
get_footer();