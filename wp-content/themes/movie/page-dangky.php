<?php
/**
 * Template Name: Đăng Ký
 */
get_header();
$active_tab = 'register';
include locate_template('auth/auth-tabs.php', false, false);
get_footer();
