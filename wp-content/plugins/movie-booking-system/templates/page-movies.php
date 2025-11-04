<?php
/**
 * Template Name: Movies Page
 * Description: Page template for displaying movies list
 */

get_header();
?>

<div class="mbs-page-wrapper">
    <?php
    // Display movies list shortcode
    echo do_shortcode('[mbs_movies_list per_page="12"]');
    ?>
</div>

<?php
get_footer();

