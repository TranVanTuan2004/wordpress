<?php
/**
 * Template Name: Phim Sắp Chiếu
 */
get_header(); 
?>

<div class="container" style="padding: 40px 20px;">
    <h1 style="text-align: center; margin-bottom: 40px; color: #fff;">PHIM SẮP CHIẾU</h1>
    
    <div class="movie-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 30px;">
        <?php
        // Query phim sắp chiếu theo meta field
        $args = array(
            'post_type' => 'mbs_movie',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => '_movie_status',
                    'value' => 'sap-chieu',
                    'compare' => '='
                )
            )
        );
        
        $movies = new WP_Query($args);
        
        if ($movies->have_posts()) :
            while ($movies->have_posts()) : $movies->the_post();
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
                                <p style="color: #ff6b6b; font-size: 14px; margin: 5px 0; font-weight: bold;">
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
            wp_reset_postdata();
        else:
        ?>
            <p style="color: #fff; text-align: center; grid-column: 1 / -1;">Hiện chưa có phim nào sắp chiếu.</p>
        <?php endif; ?>
    </div>
</div>

<style>
.movie-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(255, 228, 77, 0.3);
}
</style>

<?php get_footer(); ?>
