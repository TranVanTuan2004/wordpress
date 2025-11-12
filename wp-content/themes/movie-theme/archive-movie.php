<?php
get_header(); ?>
<main>
    <h1>Movies</h1>
    <?php if (have_posts()) : ?>
        <div class="movie-grid">
            <?php while (have_posts()) : the_post(); ?>
                <div class="movie-card">
                    <a href="<?php the_permalink(); ?>"><?php if (has_post_thumbnail()) the_post_thumbnail('movie-thumb'); ?></a>
                    <div class="movie-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                    <div class="movie-meta"><?php the_excerpt(); ?></div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(); ?>
    <?php else: ?>
        <p>No movies found.</p>
    <?php endif; ?>
</main>
<?php get_footer(); ?>