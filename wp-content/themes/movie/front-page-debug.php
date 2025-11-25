<?php
// Query phim từ CPT mbs_movie (Movie Booking System plugin)
$query = new WP_Query(array(
    'post_type' => 'mbs_movie',
    'posts_per_page' => 10,
    'post_status' => 'publish'
));

// DEBUG: Kiểm tra query
error_log('=== FRONT PAGE DEBUG ===');
error_log('Found posts: ' . $query->found_posts);
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
        error_log('Movie: ' . get_the_title() . ' | Thumbnail: ' . ($thumb_url ? $thumb_url : 'NONE'));
    }
    wp_reset_postdata();
}
?>
<?php get_header(); ?>
