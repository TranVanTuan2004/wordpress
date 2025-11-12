<?php
/**
 * Flatsome functions and definitions
 *
 * @package flatsome
 */
update_option( get_template() . '_wup_purchase_code', '*******' );
update_option( get_template() . '_wup_supported_until', '01.01.2030' );
update_option( get_template() . '_wup_buyer', 'GPL' );
require get_template_directory() . '/inc/init.php';

/**
 * Note: It's not recommended to add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * Learn more here: http://codex.wordpress.org/Child_Themes
 */

// Enqueue CSS cho template "User Profile"
add_action('wp_enqueue_scripts', function () {
	if (is_page_template('page-profile.php')) {
		wp_enqueue_style(
			'flatsome-profile',
			get_template_directory_uri() . '/assets/css/profile.css',
			array(),
			'1.0'
		);
	}
});