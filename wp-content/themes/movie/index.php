<?php get_header(); ?>

<div class="container">
    <h1>This is file index.php</h1>

    <?php
    $args = array(
        'post_type' => 'mbs_movie',
        'posts_per_page' => -1 // lấy hết phim
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo "<h2>Danh sách phim (movie)</h2>";
        echo "<ul>";

        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <li>
                <a href="<?php echo get_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </li>
            <?php
        }

        echo "</ul>";
    }

    wp_reset_postdata();
    ?>


    <div class="blog-archive-container">
        <h1>Danh sách Blogs</h1>

        <?php if ( have_posts() ) : ?>
            <ul>
                <?php while ( have_posts() ) : the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <p><?php the_excerpt(); ?></p>
                    </li>
                <?php endwhile; ?>
            </ul>

            <?php the_posts_pagination(array(
                'prev_text' => '« Trước',
                'next_text' => 'Sau »',
            )); ?>

        <?php else : ?>
            <p>Chưa có bài viết nào.</p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>