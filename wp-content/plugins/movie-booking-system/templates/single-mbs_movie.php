<?php
/**
 * Single Movie Template
 */

get_header();
?>

<div class="mbs-single-movie-wrapper">
    <?php
    while (have_posts()) : the_post();
        // Display movie detail shortcode
        echo do_shortcode('[mbs_movie_detail id="' . get_the_ID() . '"]');
    endwhile;
    ?>
</div>

<?php
get_footer();

