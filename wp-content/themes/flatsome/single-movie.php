<?php
/**
 * Template for displaying single movie posts
 * Design giống MovieHub/PhimMoi 100%
 */

// Include header tự tạo
if (defined('SITE_LAYOUT_DIR')) {
    include SITE_LAYOUT_DIR . 'templates/header.php';
} else {
    get_header();
}

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

<!-- Movie Detail Page - MovieHub Style -->
<div class="moviehub-page">
    <div class="moviehub-container">
        
        <!-- Main Content -->
        <div class="moviehub-main">
            
            <!-- Movie Header -->
            <div class="movie-header-section">
                <div class="movie-poster-col">
                    <img src="<?php echo esc_url($poster); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="movie-poster-main">
                    <div class="poster-overlay-badge"><?php echo esc_html($rating); ?></div>
                </div>
                
                <div class="movie-info-col">
                    <h1 class="movie-main-title"><?php the_title(); ?></h1>
                    
                    <div class="movie-original-title">Tên gốc đầy đủ</div>
                    
                    <div class="movie-quick-stats">
                        <span class="stat-item"><strong>Trạng thái:</strong> <?php echo esc_html($status); ?></span>
                        <span class="stat-item"><strong>Thời lượng:</strong> <?php echo esc_html($duration); ?> phút</span>
                        <span class="stat-item"><strong>Năm phát hành:</strong> <?php echo esc_html($release_date_formatted); ?></span>
                    </div>
                    
                    <div class="movie-description-text">
                        <?php the_content(); ?>
                    </div>
                    
                    <div class="movie-info-table">
                        <div class="info-row">
                            <span class="info-label">Đạo diễn:</span>
                            <span class="info-value"><?php echo esc_html($director); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Diễn viên:</span>
                            <span class="info-value"><?php echo esc_html($cast); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Thể loại:</span>
                            <span class="info-value"><?php echo esc_html($genre_text); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">IMDb:</span>
                            <span class="info-value rating-highlight"><?php echo esc_html($imdb_rating); ?> / 10</span>
                        </div>
                    </div>
                    
                    <div class="watch-buttons">
                        <?php if ($trailer_link): ?>
                        <a href="<?php echo esc_url($trailer_link); ?>" target="_blank" class="btn-watch-trailer">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            Xem Trailer
                        </a>
                        <?php endif; ?>
                        <button class="btn-watch-now">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            Xem phim
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Bình luận từ người xem -->
            <div class="comments-section">
                <h2 class="section-heading">Bình luận từ người xem</h2>
                <div class="comments-placeholder">
                    <p>Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                </div>
            </div>
            
            <!-- Diễn viên & Đoàn làm phim -->
            <div class="cast-section">
                <h2 class="section-heading">Diễn viên & Đoàn làm phim</h2>
                <div class="cast-grid">
                    <div class="cast-item">
                        <div class="cast-avatar">
                            <img src="https://via.placeholder.com/80/333/fff?text=Cast" alt="Cast">
                        </div>
                        <div class="cast-name">Tên diễn viên</div>
                    </div>
                    <!-- More cast items -->
                </div>
            </div>
            
            <!-- Hình ảnh & Video -->
            <div class="media-section">
                <h2 class="section-heading">Hình ảnh & Video</h2>
                <div class="media-grid">
                    <div class="media-item">
                        <img src="<?php echo esc_url($poster); ?>" alt="Media">
                    </div>
                    <!-- More media items -->
                </div>
            </div>
            
            <!-- Bình phim -->
            <div class="reviews-section">
                <h2 class="section-heading">Bình phim</h2>
                <div class="reviews-grid">
                    <div class="review-item">
                        <p>Chưa có bình luận nào.</p>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Sidebar -->
        <div class="moviehub-sidebar">
            <div class="sidebar-widget">
                <h3 class="widget-title">Phim đang chiếu</h3>
                <div class="sidebar-movies-list">
                    <?php
                    // Get movies đang chiếu for sidebar
                    $sidebar_args = array(
                        'post_type' => 'movie',
                        'posts_per_page' => 10,
                        'post__not_in' => array($movie_id),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'movie_status',
                                'field' => 'slug',
                                'terms' => 'dang-chieu',
                            ),
                        ),
                    );
                    
                    $sidebar_query = new WP_Query($sidebar_args);
                    
                    if ($sidebar_query->have_posts()):
                        while ($sidebar_query->have_posts()): $sidebar_query->the_post();
                            $sidebar_id = get_the_ID();
                            $sidebar_poster = get_the_post_thumbnail_url($sidebar_id, 'thumbnail');
                            if (!$sidebar_poster) {
                                $sidebar_poster = 'https://via.placeholder.com/100x150/333/fff?text=Movie';
                            }
                            $sidebar_imdb = get_post_meta($sidebar_id, 'movie_imdb_rating', true) ?: '0.0';
                    ?>
                    <a href="<?php the_permalink(); ?>" class="sidebar-movie-item">
                        <div class="sidebar-movie-poster">
                            <img src="<?php echo esc_url($sidebar_poster); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                        </div>
                        <div class="sidebar-movie-info">
                            <h4 class="sidebar-movie-title"><?php the_title(); ?></h4>
                            <div class="sidebar-movie-rating">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <?php echo esc_html($sidebar_imdb); ?>
                            </div>
                        </div>
                    </a>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </div>
        
    </div>
</div>

<style>
/* MovieHub Style - Giống PhimMoi 100% */
.moviehub-page {
    background: #0f0f0f;
    min-height: 100vh;
    padding: 30px 0;
}

.moviehub-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 30px;
}

/* Main Content */
.moviehub-main {
    background: #1a1a1a;
    border-radius: 8px;
    padding: 30px;
}

/* Movie Header */
.movie-header-section {
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: 30px;
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #333;
}

.movie-poster-col {
    position: relative;
}

.movie-poster-main {
    width: 100%;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
}

.poster-overlay-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #e74c3c;
    color: white;
    padding: 4px 10px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 12px;
}

.movie-info-col {
    color: #fff;
}

.movie-main-title {
    font-size: 32px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 10px 0;
    line-height: 1.2;
}

.movie-original-title {
    color: #999;
    font-size: 14px;
    margin-bottom: 15px;
}

.movie-quick-stats {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    font-size: 14px;
    color: #ccc;
}

.stat-item strong {
    color: #fff;
}

.movie-description-text {
    color: #ccc;
    font-size: 14px;
    line-height: 1.8;
    margin-bottom: 25px;
}

.movie-info-table {
    background: #222;
    border-radius: 6px;
    padding: 20px;
    margin-bottom: 25px;
}

.info-row {
    display: grid;
    grid-template-columns: 120px 1fr;
    padding: 10px 0;
    border-bottom: 1px solid #333;
    font-size: 14px;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    color: #999;
    font-weight: 600;
}

.info-value {
    color: #fff;
}

.rating-highlight {
    color: #fbbf24;
    font-weight: 700;
}

.watch-buttons {
    display: flex;
    gap: 15px;
}

.btn-watch-trailer,
.btn-watch-now {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    border: none;
    text-decoration: none;
}

.btn-watch-trailer {
    background: #3498db;
    color: white;
}

.btn-watch-trailer:hover {
    background: #2980b9;
    color: white;
}

.btn-watch-now {
    background: #e74c3c;
    color: white;
}

.btn-watch-now:hover {
    background: #c0392b;
}

/* Section Headings */
.section-heading {
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 20px 0;
    padding-bottom: 10px;
    border-bottom: 2px solid #e74c3c;
}

/* Comments Section */
.comments-section {
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #333;
}

.comments-placeholder {
    background: #222;
    padding: 40px;
    text-align: center;
    border-radius: 6px;
    color: #999;
}

/* Cast Section */
.cast-section {
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #333;
}

.cast-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 20px;
}

.cast-item {
    text-align: center;
}

.cast-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 10px;
    border: 2px solid #333;
}

.cast-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cast-name {
    font-size: 13px;
    color: #ccc;
}

/* Media Section */
.media-section {
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #333;
}

.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
}

.media-item img {
    width: 100%;
    border-radius: 6px;
}

/* Reviews Section */
.reviews-section {
    margin-bottom: 40px;
}

.reviews-grid {
    background: #222;
    padding: 40px;
    text-align: center;
    border-radius: 6px;
    color: #999;
}

/* Sidebar */
.moviehub-sidebar {
    position: sticky;
    top: 100px;
    align-self: start;
}

.sidebar-widget {
    background: #1a1a1a;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}

.widget-title {
    font-size: 18px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 20px 0;
    padding-bottom: 10px;
    border-bottom: 2px solid #e74c3c;
}

.sidebar-movies-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.sidebar-movie-item {
    display: flex;
    gap: 12px;
    padding: 10px;
    background: #222;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.3s;
}

.sidebar-movie-item:hover {
    background: #2a2a2a;
    transform: translateX(5px);
}

.sidebar-movie-poster {
    flex-shrink: 0;
    width: 60px;
    height: 90px;
    border-radius: 4px;
    overflow: hidden;
}

.sidebar-movie-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.sidebar-movie-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.sidebar-movie-title {
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    margin: 0 0 5px 0;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.sidebar-movie-rating {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    color: #fbbf24;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 1024px) {
    .moviehub-container {
        grid-template-columns: 1fr;
    }
    
    .moviehub-sidebar {
        position: relative;
        top: 0;
    }
}

@media (max-width: 768px) {
    .movie-header-section {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .movie-poster-main {
        max-width: 250px;
        margin: 0 auto;
    }
    
    .movie-main-title {
        font-size: 24px;
    }
    
    .movie-quick-stats {
        flex-direction: column;
        gap: 10px;
    }
    
    .watch-buttons {
        flex-direction: column;
    }
    
    .cast-grid {
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    }
}
</style>

<?php
endwhile;

// Include footer tự tạo
if (defined('SITE_LAYOUT_DIR')) {
    include SITE_LAYOUT_DIR . 'templates/footer.php';
} else {
    get_footer();
}
?>
