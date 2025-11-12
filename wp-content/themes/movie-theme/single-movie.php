<?php
get_header();
if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="movie-single container">
            <h1><?php the_title(); ?></h1>
            <div class="movie-meta">
                <?php
                $genres = get_the_terms(get_the_ID(), 'genre');
                if ($genres && ! is_wp_error($genres)) {
                    $out = array();
                    foreach ($genres as $g) $out[] = '<a href="' . get_term_link($g) . '">' . esc_html($g->name) . '</a>';
                    echo '<div><strong>Genres:</strong> ' . implode(', ', $out) . '</div>';
                }
                ?>
            </div>
            <div class="movie-thumbnail">
                <?php if (has_post_thumbnail()) the_post_thumbnail('large'); ?>
            </div>
            <div class="movie-content">
                <?php the_content(); ?>
            </div>
        </article>
<?php endwhile;
endif;
get_footer();
?>