<?php
/**
 * Template for displaying single movie posts
 */

get_header();

while (have_posts()) : the_post();
    $movie_id = get_the_ID();
    
    // Get movie meta data
    $rating = get_post_meta($movie_id, 'movie_rating', true) ?: 'P';
    $duration = get_post_meta($movie_id, 'movie_duration', true) ?: '120';
    $release_date = get_post_meta($movie_id, 'movie_release_date', true);
    $trailer_link = get_post_meta($movie_id, 'movie_trailer_link', true);
    $imdb_rating = get_post_meta($movie_id, 'movie_imdb_rating', true) ?: '0.0';
    $director = get_post_meta($movie_id, 'movie_director', true) ?: 'Đang cập nhật';
    $cast = get_post_meta($movie_id, 'movie_cast', true) ?: 'Đang cập nhật';
    
    // Get genres
    $genres = wp_get_post_terms($movie_id, 'movie_genre');
    $genre_names = array();
    foreach ($genres as $genre) {
        $genre_names[] = $genre->name;
    }
    $genre_text = implode(', ', $genre_names);
    
    // Get status
    $status_terms = wp_get_post_terms($movie_id, 'movie_status');
    $status = !empty($status_terms) ? $status_terms[0]->name : 'Đang cập nhật';
    
    // Get poster
    $poster = get_the_post_thumbnail_url($movie_id, 'large');
    if (!$poster) {
        $poster = 'https://via.placeholder.com/400x600/1f2937/fff?text=' . urlencode(get_the_title());
    }
    
    // Format release date
    $release_date_formatted = 'Đang cập nhật';
    if ($release_date) {
        $date = new DateTime($release_date);
        $release_date_formatted = $date->format('d/m/Y');
    }
?>

<!-- Single Movie Detail Page -->
<div class="movie-detail-page">
    
    <!-- Hero Section with Backdrop -->
    <section class="movie-hero">
        <div class="hero-backdrop" style="background-image: url('<?php echo esc_url($poster); ?>')"></div>
        <div class="hero-overlay"></div>
        
        <div class="hero-content-wrapper">
            <div class="container">
                <div class="hero-grid">
                    
                    <!-- Movie Poster -->
                    <div class="poster-section">
                        <div class="poster-wrapper">
                            <img src="<?php echo esc_url($poster); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="movie-poster-img">
                            <div class="rating-badge"><?php echo esc_html($rating); ?></div>
                        </div>
                        
                        <?php if ($trailer_link): ?>
                        <a href="<?php echo esc_url($trailer_link); ?>" target="_blank" class="btn-trailer">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            Xem Trailer
                        </a>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Movie Info -->
                    <div class="info-section">
                        <div class="breadcrumb">
                            <a href="<?php echo home_url(); ?>">Trang chủ</a>
                            <span>/</span>
                            <a href="<?php echo home_url('/movies'); ?>">Phim</a>
                            <span>/</span>
                            <span><?php the_title(); ?></span>
                        </div>
                        
                        <h1 class="movie-title"><?php the_title(); ?></h1>
                        
                        <div class="movie-meta">
                            <div class="meta-item">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <span class="imdb-score"><?php echo esc_html($imdb_rating); ?></span>
                                <span class="imdb-label">IMDb</span>
                            </div>
                            
                            <div class="meta-divider"></div>
                            
                            <div class="meta-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <span><?php echo esc_html($duration); ?> phút</span>
                            </div>
                            
                            <div class="meta-divider"></div>
                            
                            <div class="meta-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <span><?php echo esc_html($release_date_formatted); ?></span>
                            </div>
                        </div>
                        
                        <?php if ($genre_text): ?>
                        <div class="movie-genres">
                            <?php foreach ($genre_names as $genre_name): ?>
                            <span class="genre-tag"><?php echo esc_html($genre_name); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <div class="movie-description">
                            <?php the_content(); ?>
                        </div>
                        
                        <div class="movie-details-grid">
                            <div class="detail-item">
                                <span class="detail-label">Đạo diễn:</span>
                                <span class="detail-value"><?php echo esc_html($director); ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Diễn viên:</span>
                                <span class="detail-value"><?php echo esc_html($cast); ?></span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">Trạng thái:</span>
                                <span class="detail-value status-<?php echo sanitize_title($status); ?>"><?php echo esc_html($status); ?></span>
                            </div>
                        </div>
                        
                        <div class="action-buttons">
                            <button class="btn-primary btn-book">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                    <path d="M20 12H4M4 12l5-5m-5 5l5 5"/>
                                    <path d="M22 4H2v16h20V4z" stroke="currentColor" fill="none" stroke-width="2"/>
                                </svg>
                                Đặt vé ngay
                            </button>
                            
                            <button class="btn-secondary btn-favorite">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                                Yêu thích
                            </button>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    
    <!-- Related Movies -->
    <section class="related-movies-section">
        <div class="container">
            <h2 class="section-title">
                <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8 14H9.5v-2h-2v2H6V7h1.5v2h2V7H11v10zm7 0h-1.75l-1.75-2.25V17H13V7h1.5v2.25L16.25 7H18l-2.25 3L18 13z"/>
                </svg>
                Phim liên quan
            </h2>
            
            <div class="related-movies-grid">
                <?php
                // Get related movies (same genre)
                $related_args = array(
                    'post_type' => 'movie',
                    'posts_per_page' => 6,
                    'post__not_in' => array($movie_id),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'movie_genre',
                            'field' => 'term_id',
                            'terms' => wp_list_pluck($genres, 'term_id'),
                        ),
                    ),
                );
                
                $related_query = new WP_Query($related_args);
                
                if ($related_query->have_posts()):
                    while ($related_query->have_posts()): $related_query->the_post();
                        $related_id = get_the_ID();
                        $related_poster = get_the_post_thumbnail_url($related_id, 'medium');
                        if (!$related_poster) {
                            $related_poster = 'https://via.placeholder.com/300x450/1f2937/fff?text=' . urlencode(get_the_title());
                        }
                        $related_rating = get_post_meta($related_id, 'movie_rating', true) ?: 'P';
                        $related_imdb = get_post_meta($related_id, 'movie_imdb_rating', true) ?: '0.0';
                        
                        // Get genres
                        $related_genres = wp_get_post_terms($related_id, 'movie_genre');
                        $related_genre_names = array();
                        foreach ($related_genres as $g) {
                            $related_genre_names[] = $g->name;
                        }
                        $related_genre_text = implode(', ', $related_genre_names);
                ?>
                <a href="<?php the_permalink(); ?>" class="related-movie-card">
                    <div class="related-poster">
                        <img src="<?php echo esc_url($related_poster); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                        <div class="related-rating"><?php echo esc_html($related_rating); ?></div>
                        <div class="related-overlay">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="48" height="48">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="related-info">
                        <h3 class="related-title"><?php the_title(); ?></h3>
                        <p class="related-genre"><?php echo esc_html($related_genre_text); ?></p>
                        <div class="related-rating-stars">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <span><?php echo esc_html($related_imdb); ?></span>
                        </div>
                    </div>
                </a>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                ?>
                <p class="no-related">Không có phim liên quan.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
</div>

<style>
/* Movie Detail Page Styles */
.movie-detail-page {
    background: #f9fafb;
    min-height: 100vh;
}

/* Hero Section */
.movie-hero {
    position: relative;
    min-height: 600px;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-size: cover;
    background-position: center;
    filter: blur(20px);
    transform: scale(1.1);
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 15, 15, 0.95) 0%, rgba(26, 26, 26, 0.9) 50%, rgba(15, 15, 15, 0.95) 100%);
}

.hero-content-wrapper {
    position: relative;
    z-index: 1;
    width: 100%;
    padding: 80px 0;
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 30px;
}

.hero-grid {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 60px;
    align-items: start;
}

/* Poster Section */
.poster-section {
    position: sticky;
    top: 100px;
}

.poster-wrapper {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    transition: transform 0.3s ease;
}

.poster-wrapper:hover {
    transform: translateY(-8px);
}

.movie-poster-img {
    width: 100%;
    display: block;
    aspect-ratio: 2/3;
    object-fit: cover;
}

.rating-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
    color: white;
    padding: 8px 16px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.5);
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.btn-trailer {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    margin-top: 20px;
    padding: 16px;
    background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 8px 24px rgba(245, 158, 11, 0.4);
}

.btn-trailer:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(245, 158, 11, 0.6);
}

/* Info Section */
.info-section {
    padding: 20px 0;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    font-size: 14px;
    color: #9ca3af;
}

.breadcrumb a {
    color: #9ca3af;
    text-decoration: none;
    transition: color 0.3s;
}

.breadcrumb a:hover {
    color: #f59e0b;
}

.breadcrumb span:not(.rating-badge) {
    color: #6b7280;
}

.movie-title {
    font-size: 48px;
    font-weight: 900;
    color: #fff;
    margin: 0 0 24px 0;
    line-height: 1.2;
    letter-spacing: -1px;
}

.movie-meta {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 24px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #f3f4f6;
    font-size: 16px;
    font-weight: 600;
}

.meta-item svg {
    color: #fbbf24;
}

.imdb-score {
    color: #fbbf24;
    font-size: 18px;
    font-weight: 800;
}

.imdb-label {
    color: #9ca3af;
    font-size: 14px;
}

.meta-divider {
    width: 1px;
    height: 20px;
    background: #4b5563;
}

.movie-genres {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 28px;
}

.genre-tag {
    padding: 8px 20px;
    background: rgba(245, 158, 11, 0.15);
    color: #fbbf24;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.movie-description {
    color: #d1d5db;
    font-size: 16px;
    line-height: 1.8;
    margin-bottom: 32px;
}

.movie-details-grid {
    display: grid;
    gap: 16px;
    margin-bottom: 40px;
}

.detail-item {
    display: flex;
    gap: 12px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(75, 85, 99, 0.5);
}

.detail-label {
    color: #9ca3af;
    font-size: 15px;
    font-weight: 600;
    min-width: 120px;
}

.detail-value {
    color: #f3f4f6;
    font-size: 15px;
    font-weight: 500;
}

.status-dang-chieu {
    color: #10b981;
}

.status-sap-chieu {
    color: #f59e0b;
}

.action-buttons {
    display: flex;
    gap: 16px;
}

.btn-primary,
.btn-secondary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 16px 32px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
}

.btn-primary {
    background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
    color: white;
    box-shadow: 0 8px 24px rgba(245, 158, 11, 0.4);
    flex: 1;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(245, 158, 11, 0.6);
}

.btn-secondary {
    background: rgba(75, 85, 99, 0.5);
    color: white;
    border: 2px solid rgba(156, 163, 175, 0.3);
}

.btn-secondary:hover {
    background: rgba(75, 85, 99, 0.8);
    border-color: rgba(245, 158, 11, 0.5);
}

/* Related Movies Section */
.related-movies-section {
    padding: 80px 0;
    background: #f9fafb;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 32px;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 40px;
}

.section-title svg {
    color: #f59e0b;
}

.related-movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 28px;
}

.related-movie-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(229, 231, 235, 1);
    padding: 10px;
}

.related-movie-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 32px rgba(245, 158, 11, 0.2);
}

.related-poster {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 2/3;
}

.related-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-movie-card:hover .related-poster img {
    transform: scale(1.05);
}

.related-rating {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
    color: white;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 800;
    z-index: 2;
}

.related-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.related-movie-card:hover .related-overlay {
    opacity: 1;
}

.related-overlay svg {
    color: #fbbf24;
}

.related-info {
    padding: 14px 6px 6px 6px;
}

.related-title {
    color: #1f2937;
    font-size: 15px;
    font-weight: 700;
    margin: 0 0 6px 0;
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
}

.related-genre {
    color: #6b7280;
    font-size: 12px;
    margin: 0 0 8px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.related-rating-stars {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #fbbf24;
    font-size: 13px;
    font-weight: 700;
}

.no-related {
    grid-column: 1 / -1;
    text-align: center;
    color: #6b7280;
    font-size: 16px;
    padding: 40px;
}

/* Responsive */
@media (max-width: 1024px) {
    .hero-grid {
        grid-template-columns: 280px 1fr;
        gap: 40px;
    }
    
    .movie-title {
        font-size: 36px;
    }
}

@media (max-width: 768px) {
    .hero-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .poster-section {
        position: relative;
        top: 0;
    }
    
    .poster-wrapper {
        max-width: 300px;
        margin: 0 auto;
    }
    
    .movie-title {
        font-size: 28px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .related-movies-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 0 20px;
    }
    
    .hero-content-wrapper {
        padding: 40px 0;
    }
    
    .related-movies-section {
        padding: 40px 0;
    }
}
</style>

<?php
endwhile;

get_footer();
?>

