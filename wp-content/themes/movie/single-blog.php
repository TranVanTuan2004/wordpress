<?php get_header(); ?>

<div class="single-blog-container" style="max-width:800px;margin:40px auto;padding:0 20px;font-family:Segoe UI,sans-serif;">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
    ?>
            <h1 style="font-size:28px;color:red;text-transform: uppercase;margin-bottom:20px;"><?php the_title(); ?></h1>

            <?php 
            // Hiển thị ảnh đại diện nếu có
            if ( has_post_thumbnail() ) {
                the_post_thumbnail('large', array('style' => 'width:100%;height:auto;margin-bottom:20px;'));
            } 
            ?>

            <div class="blog-content" style="font-size:16px;line-height:1.8;color:#555;">
                <?php the_content(); ?>
            </div>

            <p style="margin-top:30px;">
                <a href="<?php echo site_url('/blog'); ?>" style="color:#0073aa;text-decoration:none;">&larr; Quay lại danh sách blog</a>
            </p>
    <?php
        endwhile;
    else :
        echo '<p>Không tìm thấy bài viết nào.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>
