<?php
/**
 * Template for displaying single mbs_movie posts
 */

// Include header tự tạo
if (defined('SITE_LAYOUT_DIR')) {
    include SITE_LAYOUT_DIR . 'templates/header.php';
} else {
    get_header();
}

while (have_posts()) : the_post();
    $movie_id = get_the_ID();
    
    // Display movie detail using shortcode
    echo do_shortcode('[mbs_movie_detail id="' . $movie_id . '"]');
endwhile;

// Include footer tự tạo
if (defined('SITE_LAYOUT_DIR')) {
    include SITE_LAYOUT_DIR . 'templates/footer.php';
} else {
    get_footer();
}
?>


