<?php get_header(); ?>
<main>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article>
                <div><?php the_content();?></div>
            </article>
        <?php endwhile;
    else: ?>
        <p>No content found.</p>
    <?php endif; ?>
</main>
<?php get_footer(); ?>


<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
</style>