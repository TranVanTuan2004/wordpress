<?php
/**
 * Template for Movie Detail Shortcode
 * Usage: [movie_detail id="123"]
 */

if (!defined('ABSPATH')) exit;

$movie_id = isset($atts['id']) ? intval($atts['id']) : get_the_ID();

if (!$movie_id) {
    return '<p style="color: red;">⚠️ Vui lòng cung cấp ID phim. Ví dụ: [movie_detail id="123"]</p>';
}

$movie = get_post($movie_id);
if (!$movie || $movie->post_type !== 'movie') {
    return '<p style="color: red;">⚠️ Không tìm thấy phim với ID: ' . $movie_id . '</p>';
}

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
    $poster = 'https://via.placeholder.com/400x600/1f2937/fff?text=' . urlencode($movie->post_title);
}

// Format release date
$release_date_formatted = 'Đang cập nhật';
if ($release_date) {
    $date = new DateTime($release_date);
    $release_date_formatted = $date->format('d/m/Y');
}
?>

<!-- Movie Detail Shortcode -->
<div class="movie-detail-shortcode" id="movie-<?php echo $movie_id; ?>">
    
    <div class="movie-detail-grid">
        
        <!-- Poster Section -->
        <div class="movie-poster-section">
            <div class="movie-poster-wrapper">
                <img src="<?php echo esc_url($poster); ?>" alt="<?php echo esc_attr($movie->post_title); ?>" class="movie-poster-image">
                <div class="movie-rating-badge"><?php echo esc_html($rating); ?></div>
            </div>
            
            <?php if ($trailer_link): ?>
            <a href="<?php echo esc_url($trailer_link); ?>" target="_blank" class="btn-watch-trailer">
                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                    <path d="M8 5v14l11-7z"/>
                </svg>
                Xem Trailer
            </a>
            <?php endif; ?>
        </div>
        
        <!-- Info Section -->
        <div class="movie-info-section">
            
            <h2 class="movie-detail-title"><?php echo esc_html($movie->post_title); ?></h2>
            
            <div class="movie-meta-info">
                <div class="meta-info-item">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span class="imdb-rating"><?php echo esc_html($imdb_rating); ?></span>
                    <span class="imdb-text">IMDb</span>
                </div>
                
                <div class="meta-divider"></div>
                
                <div class="meta-info-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span><?php echo esc_html($duration); ?> phút</span>
                </div>
                
                <div class="meta-divider"></div>
                
                <div class="meta-info-item">
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
            <div class="movie-genre-tags">
                <?php foreach ($genre_names as $genre_name): ?>
                <span class="genre-tag-item"><?php echo esc_html($genre_name); ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <div class="movie-description-text">
                <?php echo wpautop($movie->post_content); ?>
            </div>
            
            <div class="movie-info-details">
                <div class="info-detail-row">
                    <span class="info-detail-label">Đạo diễn:</span>
                    <span class="info-detail-value"><?php echo esc_html($director); ?></span>
                </div>
                
                <div class="info-detail-row">
                    <span class="info-detail-label">Diễn viên:</span>
                    <span class="info-detail-value"><?php echo esc_html($cast); ?></span>
                </div>
                
                <div class="info-detail-row">
                    <span class="info-detail-label">Trạng thái:</span>
                    <span class="info-detail-value status-<?php echo sanitize_title($status); ?>"><?php echo esc_html($status); ?></span>
                </div>
            </div>
            
            <div class="movie-action-buttons">
                <a href="<?php echo get_permalink($movie_id); ?>" class="btn-view-full" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    Xem chi tiết đầy đủ
                </a>
                
                <button class="btn-book-ticket">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                        <path d="M22 4H2v16h20V4z" stroke="currentColor" fill="none" stroke-width="2"/>
                    </svg>
                    Đặt vé ngay
                </button>
            </div>
            
        </div>
        
    </div>
    
</div>

<style>
/* Movie Detail Shortcode Styles */
.movie-detail-shortcode {
    background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 100%);
    border-radius: 24px;
    padding: 40px;
    margin: 40px 0;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    border: 1px solid rgba(63, 63, 70, 0.5);
}

.movie-detail-grid {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 50px;
    align-items: start;
}

/* Poster Section */
.movie-poster-section {
    position: sticky;
    top: 100px;
}

.movie-poster-wrapper {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.7);
    transition: transform 0.3s ease;
}

.movie-poster-wrapper:hover {
    transform: translateY(-8px);
}

.movie-poster-image {
    width: 100%;
    display: block;
    aspect-ratio: 2/3;
    object-fit: cover;
}

.movie-rating-badge {
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

.btn-watch-trailer {
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

.btn-watch-trailer:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(245, 158, 11, 0.6);
    color: white;
}

/* Info Section */
.movie-info-section {
    padding: 10px 0;
}

.movie-detail-title {
    font-size: 42px;
    font-weight: 900;
    color: #fff;
    margin: 0 0 24px 0;
    line-height: 1.2;
    letter-spacing: -1px;
}

.movie-meta-info {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.meta-info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #f3f4f6;
    font-size: 16px;
    font-weight: 600;
}

.meta-info-item svg {
    color: #fbbf24;
}

.imdb-rating {
    color: #fbbf24;
    font-size: 18px;
    font-weight: 800;
}

.imdb-text {
    color: #9ca3af;
    font-size: 14px;
}

.meta-divider {
    width: 1px;
    height: 20px;
    background: #4b5563;
}

.movie-genre-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 28px;
}

.genre-tag-item {
    padding: 8px 20px;
    background: rgba(245, 158, 11, 0.15);
    color: #fbbf24;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.movie-description-text {
    color: #d1d5db;
    font-size: 16px;
    line-height: 1.8;
    margin-bottom: 32px;
}

.movie-description-text p {
    margin: 0 0 16px 0;
}

.movie-info-details {
    display: grid;
    gap: 16px;
    margin-bottom: 40px;
}

.info-detail-row {
    display: flex;
    gap: 12px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(75, 85, 99, 0.5);
}

.info-detail-label {
    color: #9ca3af;
    font-size: 15px;
    font-weight: 600;
    min-width: 120px;
}

.info-detail-value {
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

.movie-action-buttons {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.btn-view-full,
.btn-book-ticket {
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
    text-decoration: none;
}

.btn-view-full {
    background: rgba(75, 85, 99, 0.5);
    color: white;
    border: 2px solid rgba(156, 163, 175, 0.3);
    flex: 1;
}

.btn-view-full:hover {
    background: rgba(75, 85, 99, 0.8);
    border-color: rgba(245, 158, 11, 0.5);
    transform: translateY(-2px);
    color: white;
}

.btn-book-ticket {
    background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
    color: white;
    box-shadow: 0 8px 24px rgba(245, 158, 11, 0.4);
    flex: 1;
}

.btn-book-ticket:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(245, 158, 11, 0.6);
}

/* Responsive */
@media (max-width: 1024px) {
    .movie-detail-shortcode {
        padding: 30px;
    }
    
    .movie-detail-grid {
        grid-template-columns: 260px 1fr;
        gap: 35px;
    }
    
    .movie-detail-title {
        font-size: 32px;
    }
}

@media (max-width: 768px) {
    .movie-detail-shortcode {
        padding: 24px;
        margin: 20px 0;
    }
    
    .movie-detail-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .movie-poster-section {
        position: relative;
        top: 0;
    }
    
    .movie-poster-wrapper {
        max-width: 280px;
        margin: 0 auto;
    }
    
    .movie-detail-title {
        font-size: 28px;
    }
    
    .movie-action-buttons {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .movie-detail-shortcode {
        padding: 20px;
        border-radius: 16px;
    }
    
    .movie-detail-title {
        font-size: 24px;
    }
    
    .movie-meta-info {
        gap: 12px;
    }
    
    .meta-info-item {
        font-size: 14px;
    }
}
</style>

