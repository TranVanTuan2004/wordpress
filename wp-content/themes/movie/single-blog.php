<?php get_header(); ?>

<div class="single-blog-container">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
    ?>
            <h1 class="blog-title"><?php the_title(); ?></h1>

            <?php 
            // Hiển thị ảnh đại diện nếu có
            if ( has_post_thumbnail() ) {
                the_post_thumbnail('large', array('class' => 'featured-image'));
            } 
            ?>

            <div class="blog-content">
                <h1>Nội dung bài viết</h1>
                <?php the_content(); ?>
            </div>

            <p class="back-link">
                <a href="<?php echo site_url('/blog'); ?>">&larr; Quay lại danh sách blog</a>
            </p>
    <?php
        endwhile;
    else :
        echo '<p>Không tìm thấy bài viết nào.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>
