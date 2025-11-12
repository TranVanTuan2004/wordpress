<?php get_header(); ?>
<main>
    <h2><?php bloginfo('name'); ?></h2>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article>
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <div><?php the_excerpt(); ?></div>
            </article>
        <?php endwhile;
    else: ?>
        <p>No content found.</p>
    <?php endif; ?>
</main>
<?php get_footer(); ?>