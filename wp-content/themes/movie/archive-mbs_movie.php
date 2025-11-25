<?php
/**
 * Archive template for mbs_movie post type
 */
get_header(); 
?>

<div class="container" style="padding: 40px 20px;">
    <h1 style="text-align: center; margin-bottom: 40px; color: #fff;">TẤT CẢ PHIM</h1>
    
    <div class="movie-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 30px;">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                $duration = get_post_meta(get_the_ID(), '_mbs_duration', true);
                $rating = get_post_meta(get_the_ID(), '_mbs_rating', true);
                $language = get_post_meta(get_the_ID(), '_mbs_language', true);
                $release_date = get_post_meta(get_the_ID(), '_mbs_release_date', true);
                $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
        ?>
                <a href="<?php echo get_permalink(); ?>" class="movie-link" style="text-decoration: none;">
                    <div class="movie-card" style="background: #1a1a2e; border-radius: 10px; overflow: hidden; transition: transform 0.3s;">
                        <img 
                            src="<?php echo $thumb_url ? $thumb_url : 'https://via.placeholder.com/300x450'; ?>" 
                            alt="<?php the_title_attribute(); ?>"
                            style="width: 100%; height: 300px; object-fit: cover;"
                        />
                        <div class="movie-overlay" style="padding: 15px;">
                            <h3 style="color: #ffe44d; font-size: 16px; margin-bottom: 10px;"><?php the_title(); ?></h3>
                            <?php if ($release_date): ?>
                                <p style="color: #ccc; font-size: 14px; margin: 5px 0;">
                                    Khởi chiếu: <?php echo esc_html($release_date); ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($duration): ?>
                                <p style="color: #ccc; font-size: 14px; margin: 5px 0;">
                                    <i class="bx bx-time"></i> <?php echo esc_html($duration); ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($rating): ?>
                                <p style="color: #ccc; font-size: 14px; margin: 5px 0;">
                                    Phân loại: <?php echo esc_html($rating); ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($language): ?>
                                <p style="color: #ccc; font-size: 14px; margin: 5px 0;">
                                    <i class="bx bx-message-square-dots"></i> <?php echo esc_html($language); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
        <?php
            endwhile;
        else:
        ?>
            <p style="color: #fff; text-align: center; grid-column: 1 / -1;">Hiện chưa có phim nào.</p>
        <?php endif; ?>
    </div>

    <?php
    // Pagination
    if (function_exists('the_posts_pagination')) {
        the_posts_pagination(array(
            'mid_size' => 2,
            'prev_text' => '« Trước',
            'next_text' => 'Sau »',
        ));
    }
    ?>
</div>

<style>
.movie-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(255, 228, 77, 0.3);
}

.pagination {
    text-align: center;
    margin-top: 40px;
}

.pagination .nav-links {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.pagination a,
.pagination span {
    background: #1a1a2e;
    color: #fff;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    transition: all 0.3s;
}

.pagination a:hover {
    background: #ffe44d;
    color: #0e1220;
}

.pagination .current {
    background: #ffe44d;
    color: #0e1220;
    font-weight: bold;
}
</style>

<?php get_footer(); ?>
