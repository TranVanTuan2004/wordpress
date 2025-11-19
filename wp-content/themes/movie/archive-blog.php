<?php get_header(); ?>

<div class="blog-archive-container">
    <h1>Danh sách tất cả bài viết</h1>

    <?php 
    $args = array(
        'post_type' => 'blog',
        'posts_per_page' => -1, // tất cả bài viết
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $blog_query = new WP_Query($args);

    if ($blog_query->have_posts()) :
    ?>
        <ul>
            <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
                        <?php 
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('thumbnail'); // cỡ ảnh nhỏ, có thể dùng 'medium' hoặc 'large'
                        } 
                        ?>
                        <?php the_title(); ?>
                    </a>
                    <p><?php the_excerpt(); ?></p>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>Chưa có bài viết nào.</p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>
