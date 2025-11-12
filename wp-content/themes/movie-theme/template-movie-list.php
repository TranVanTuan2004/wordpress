<?php
/*
Template Name: Movie List
*/
get_header(); ?>
<main>
    <h1>Movie List</h1>
    <?php echo do_shortcode('[movie_list posts_per_page="12"]'); ?>
</main>
<?php get_footer(); ?>