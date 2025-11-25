<?php
/**
 * Template Name: Debug Showtimes
 */
get_header();
?>
<div style="padding: 100px 20px; background: #fff; color: #000;">
    <h1>Debug Showtime Meta</h1>
    
    <h2>Search for "RIOT Cinema Huế" Showtimes</h2>
    <?php
    $args = array(
        'post_type' => 'mbs_showtime',
        'posts_per_page' => 5,
        's' => 'RIOT Cinema Huế' // Search by title
    );
    $q = new WP_Query($args);
    
    if ($q->have_posts()) {
        while ($q->have_posts()) {
            $q->the_post();
            echo '<div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">';
            echo '<h3>' . get_the_title() . ' (ID: ' . get_the_ID() . ')</h3>';
            echo '<h4>All Meta Data:</h4>';
            $meta = get_post_meta(get_the_ID());
            echo '<pre>' . print_r($meta, true) . '</pre>';
            echo '</div>';
        }
    } else {
        echo '<p>No showtimes found matching "RIOT Cinema Huế". Listing first 5 showtimes instead:</p>';
        
        // Fallback: List first 5 showtimes
        $q2 = new WP_Query(array('post_type' => 'mbs_showtime', 'posts_per_page' => 5));
        while ($q2->have_posts()) {
            $q2->the_post();
            echo '<div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">';
            echo '<h3>' . get_the_title() . ' (ID: ' . get_the_ID() . ')</h3>';
            echo '<h4>All Meta Data:</h4>';
            $meta = get_post_meta(get_the_ID());
            echo '<pre>' . print_r($meta, true) . '</pre>';
            echo '</div>';
        }
    }
    ?>
</div>
<?php get_footer(); ?>
