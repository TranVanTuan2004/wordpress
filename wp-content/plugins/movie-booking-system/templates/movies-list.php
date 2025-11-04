<?php
/**
 * Template: Movies List (Home Page)
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="mbs-movies-container">
    <div class="mbs-header">
        <h1 class="mbs-page-title">Phim Đang Chiếu</h1>
        
        <!-- Filter by genre -->
        <div class="mbs-filter">
            <?php
            $genres = get_terms(array(
                'taxonomy' => 'mbs_genre',
                'hide_empty' => true
            ));
            
            if (!empty($genres)) :
            ?>
            <div class="mbs-genre-filter">
                <button class="mbs-genre-btn active" data-genre="all">Tất cả</button>
                <?php foreach ($genres as $genre) : ?>
                    <button class="mbs-genre-btn" data-genre="<?php echo esc_attr($genre->slug); ?>">
                        <?php echo esc_html($genre->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="mbs-movies-grid">
        <?php
        if ($movies->have_posts()) :
            while ($movies->have_posts()) : $movies->the_post();
                $movie_id = get_the_ID();
                $duration = get_post_meta($movie_id, '_mbs_duration', true);
                $rating = get_post_meta($movie_id, '_mbs_rating', true);
                $language = get_post_meta($movie_id, '_mbs_language', true);
                $release_date = get_post_meta($movie_id, '_mbs_release_date', true);
                
                // Get genres
                $terms = get_the_terms($movie_id, 'mbs_genre');
                $genres_list = array();
                if ($terms && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $genres_list[] = $term->name;
                    }
                }
                ?>
                
                <div class="mbs-movie-card">
                    <div class="mbs-movie-poster">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', array('class' => 'mbs-poster-img')); ?>
                        <?php else : ?>
                            <img src="<?php echo MBS_PLUGIN_URL; ?>assets/images/no-poster.jpg" alt="No poster" class="mbs-poster-img">
                        <?php endif; ?>
                        
                        <?php if ($rating) : ?>
                            <span class="mbs-rating-badge"><?php echo esc_html($rating); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mbs-movie-info">
                        <h3 class="mbs-movie-title">
                            <a href="<?php echo esc_url(add_query_arg('movie_id', $movie_id, get_permalink())); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        
                        <?php if (!empty($genres_list)) : ?>
                            <p class="mbs-movie-genre"><?php echo implode(', ', $genres_list); ?></p>
                        <?php endif; ?>
                        
                        <div class="mbs-movie-meta">
                            <?php if ($duration) : ?>
                                <span class="mbs-duration">
                                    <i class="dashicons dashicons-clock"></i> <?php echo $duration; ?> phút
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($language) : ?>
                                <span class="mbs-language">
                                    <i class="dashicons dashicons-translation"></i> <?php echo esc_html($language); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mbs-movie-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                        </div>
                        
                        <a href="<?php echo esc_url(add_query_arg('movie_id', $movie_id, get_permalink())); ?>" class="mbs-btn mbs-btn-primary">
                            Đặt Vé Ngay
                        </a>
                    </div>
                </div>
                
            <?php endwhile; ?>
            
        <?php else : ?>
            <p class="mbs-no-movies">Không có phim nào đang chiếu.</p>
        <?php endif; ?>
        
        <?php wp_reset_postdata(); ?>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Genre filter
    $('.mbs-genre-btn').on('click', function() {
        var genre = $(this).data('genre');
        
        $('.mbs-genre-btn').removeClass('active');
        $(this).addClass('active');
        
        if (genre === 'all') {
            $('.mbs-movie-card').fadeIn();
        } else {
            $('.mbs-movie-card').hide();
            $('.mbs-movie-card[data-genre*="' + genre + '"]').fadeIn();
        }
    });
});
</script>

