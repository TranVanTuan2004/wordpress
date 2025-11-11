<?php
/**
 * Template Name: Movies List Page - Danh Sách Phim Có Phân Trang
 * Description: Hiển thị tất cả phim với phân trang
 * Note: Template này chỉ hiển thị content, không include header/footer
 */

// Get current page number
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// Query args
$args = array(
    'post_type' => 'movie',
    'posts_per_page' => 12,
    'post_status' => 'publish',
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
);

// Get filter params
$current_genre = isset($_GET['genre']) ? sanitize_text_field($_GET['genre']) : '';
$current_status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';

// Add taxonomy filters
$tax_query = array();
if (!empty($current_genre)) {
    $tax_query[] = array(
        'taxonomy' => 'movie_genre',
        'field' => 'slug',
        'terms' => $current_genre,
    );
}
if (!empty($current_status)) {
    $tax_query[] = array(
        'taxonomy' => 'movie_status',
        'field' => 'slug',
        'terms' => $current_status,
    );
}
if (!empty($tax_query)) {
    $args['tax_query'] = $tax_query;
}

$movies_query = new WP_Query($args);
?>

<div class="movies-list-page-wrapper">
<div class="movies-list-page">
    <div class="movies-list-container">
        <header class="movies-list-header">
            <h1 class="page-title"><?php echo get_the_title(); ?></h1>
            <p class="page-description">Khám phá bộ sưu tập phim đa dạng của chúng tôi</p>
        </header>

        <!-- Filters -->
        <div class="movies-filters">
            <?php
            // Get all genres
            $genres = get_terms(array(
                'taxonomy' => 'movie_genre',
                'hide_empty' => true,
            ));

            // Get all statuses
            $statuses = get_terms(array(
                'taxonomy' => 'movie_status',
                'hide_empty' => true,
            ));
            ?>

            <div class="filter-group">
                <label>Thể Loại:</label>
                <div class="filter-buttons">
                    <a href="<?php echo esc_url(remove_query_arg('genre')); ?>" 
                       class="filter-btn <?php echo empty($current_genre) ? 'active' : ''; ?>">
                        Tất cả
                    </a>
                    <?php if (!empty($genres) && !is_wp_error($genres)) : ?>
                        <?php foreach ($genres as $genre) : ?>
                            <a href="<?php echo esc_url(add_query_arg('genre', $genre->slug)); ?>" 
                               class="filter-btn <?php echo $current_genre === $genre->slug ? 'active' : ''; ?>">
                                <?php echo esc_html($genre->name); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="filter-group">
                <label>Trạng Thái:</label>
                <div class="filter-buttons">
                    <a href="<?php echo esc_url(remove_query_arg('status')); ?>" 
                       class="filter-btn <?php echo empty($current_status) ? 'active' : ''; ?>">
                        Tất cả
                    </a>
                    <?php if (!empty($statuses) && !is_wp_error($statuses)) : ?>
                        <?php foreach ($statuses as $status) : ?>
                            <a href="<?php echo esc_url(add_query_arg('status', $status->slug)); ?>" 
                               class="filter-btn <?php echo $current_status === $status->slug ? 'active' : ''; ?>">
                                <?php echo esc_html($status->name); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Results Count -->
        <?php if ($movies_query->have_posts()) : ?>
            <div class="results-count">
                <p>Hiển thị <strong><?php echo $movies_query->post_count; ?></strong> / <strong><?php echo $movies_query->found_posts; ?></strong> phim</p>
            </div>
        <?php endif; ?>

        <!-- Movies Grid -->
        <div class="movies-grid">
            <?php
            if ($movies_query->have_posts()) :
                while ($movies_query->have_posts()) : $movies_query->the_post();
                    $movie_id = get_the_ID();
                    $poster = get_the_post_thumbnail_url($movie_id, 'medium');
                    if (!$poster) {
                        $poster = 'https://via.placeholder.com/300x450/1f2937/fff?text=' . urlencode(get_the_title());
                    }
                    
                    // Get movie meta
                    $rating = get_post_meta($movie_id, 'movie_rating', true);
                    $duration = get_post_meta($movie_id, 'movie_duration', true);
                    $imdb_rating = get_post_meta($movie_id, 'movie_imdb_rating', true);
                    
                    // Get genres
                    $movie_genres = wp_get_post_terms($movie_id, 'movie_genre');
                    $genre_names = array();
                    if (!empty($movie_genres) && !is_wp_error($movie_genres)) {
                        foreach ($movie_genres as $genre) {
                            $genre_names[] = $genre->name;
                        }
                    }
                    
                    // Get status
                    $movie_statuses = wp_get_post_terms($movie_id, 'movie_status');
                    $status_name = '';
                    if (!empty($movie_statuses) && !is_wp_error($movie_statuses)) {
                        $status_name = $movie_statuses[0]->name;
                    }
            ?>
                <article class="movie-card">
                    <a href="<?php the_permalink(); ?>" class="movie-card-link">
                        <div class="movie-poster">
                            <img src="<?php echo esc_url($poster); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                            <?php if ($rating) : ?>
                                <span class="movie-rating-badge"><?php echo esc_html($rating); ?></span>
                            <?php endif; ?>
                            <?php if ($status_name) : ?>
                                <span class="movie-status-badge status-<?php echo esc_attr(sanitize_title($status_name)); ?>">
                                    <?php echo esc_html($status_name); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="movie-info">
                            <h3 class="movie-title"><?php the_title(); ?></h3>
                            <?php if (!empty($genre_names)) : ?>
                                <div class="movie-genres">
                                    <?php echo esc_html(implode(', ', $genre_names)); ?>
                                </div>
                            <?php endif; ?>
                            <div class="movie-meta">
                                <?php if ($duration) : ?>
                                    <span class="meta-item"><?php echo esc_html($duration); ?> phút</span>
                                <?php endif; ?>
                                <?php if ($imdb_rating) : ?>
                                    <span class="meta-item">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#fbbf24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <?php echo esc_html($imdb_rating); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <div class="no-movies">
                    <p>Không tìm thấy phim nào.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($movies_query->max_num_pages > 1) : ?>
            <div class="movies-pagination">
                <?php
                $big = 999999999;
                $pagination_args = array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, $paged),
                    'total' => $movies_query->max_num_pages,
                    'prev_text' => '← Trước',
                    'next_text' => 'Sau →',
                    'type' => 'list',
                );
                
                // Preserve filter params in pagination
                if (!empty($current_genre)) {
                    $pagination_args['add_args'] = array('genre' => $current_genre);
                }
                if (!empty($current_status)) {
                    $pagination_args['add_args'] = array_merge(
                        isset($pagination_args['add_args']) ? $pagination_args['add_args'] : array(),
                        array('status' => $current_status)
                    );
                }
                
                echo paginate_links($pagination_args);
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>

<style>
/* Reset và base styles */
.movies-list-page-wrapper {
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
}

.movies-list-page-wrapper * {
    box-sizing: border-box;
}

/* Main page container - chỉ content area */
.movies-list-page-wrapper .movies-list-page,
.movies-list-page {
    padding: 80px 0 100px !important;
    background: 
        radial-gradient(ellipse at top left, rgba(239, 68, 68, 0.15) 0%, transparent 50%),
        radial-gradient(ellipse at top right, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
        radial-gradient(ellipse at bottom center, rgba(139, 92, 246, 0.1) 0%, transparent 60%),
        linear-gradient(180deg, #0a0a0a 0%, #111111 30%, #0f0f0f 70%, #0a0a0a 100%) !important;
    min-height: calc(100vh - 200px) !important;
    position: relative !important;
    overflow: hidden !important;
    margin: 0 !important;
    width: 100% !important;
    display: block !important;
}

.movies-list-page::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 15% 25%, rgba(239, 68, 68, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 85% 75%, rgba(59, 130, 246, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 50% 50%, rgba(139, 92, 246, 0.05) 0%, transparent 50%);
    pointer-events: none;
    animation: pulse 8s ease-in-out infinite;
}

.movies-list-page::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: 
        radial-gradient(circle, rgba(239, 68, 68, 0.03) 0%, transparent 70%);
    pointer-events: none;
    animation: rotate 20s linear infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.movies-list-container {
    max-width: 1400px !important;
    margin: 0 auto !important;
    padding: 0 40px !important;
    position: relative !important;
    z-index: 1 !important;
    width: 100% !important;
    box-sizing: border-box !important;
}

.movies-list-header {
    text-align: center;
    margin-bottom: 60px !important;
    padding: 50px 0 40px 0 !important;
}

.page-title {
    font-size: 56px;
    font-weight: 900;
    background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 40%, #e2e8f0 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 20px;
    letter-spacing: -2px;
    text-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
    line-height: 1.1;
}

.page-description {
    font-size: 20px;
    color: rgba(255, 255, 255, 0.75);
    margin: 0;
    font-weight: 400;
    letter-spacing: 0.3px;
}

.movies-filters {
    background: rgba(255, 255, 255, 0.06) !important;
    backdrop-filter: blur(20px) !important;
    -webkit-backdrop-filter: blur(20px) !important;
    padding: 36px 40px !important;
    border-radius: 20px !important;
    margin-bottom: 50px !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    box-shadow: 
        0 8px 32px rgba(0, 0, 0, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
}

.filter-group {
    margin-bottom: 24px;
}

.filter-group:last-child {
    margin-bottom: 0;
}

.filter-group label {
    display: block;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 14px;
    font-size: 15px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.filter-btn {
    padding: 10px 20px;
    border-radius: 25px;
    background: rgba(255, 255, 255, 0.08);
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    backdrop-filter: blur(10px);
}

.filter-btn:hover {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.filter-btn.active {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border-color: rgba(255, 255, 255, 0.2);
    box-shadow: 0 4px 20px rgba(239, 68, 68, 0.4);
}

.results-count {
    margin-bottom: 32px;
    padding: 16px 24px;
    background: rgba(255, 255, 255, 0.04);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: rgba(255, 255, 255, 0.7);
    font-size: 16px;
    font-weight: 500;
    display: inline-block;
}

.results-count strong {
    color: #ffffff;
    font-weight: 700;
}

.movies-grid {
    display: grid !important;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)) !important;
    gap: 32px !important;
    margin-bottom: 70px !important;
    padding: 10px 0 !important;
}

.movie-card {
    background: rgba(255, 255, 255, 0.05) !important;
    backdrop-filter: blur(10px) !important;
    -webkit-backdrop-filter: blur(10px) !important;
    border-radius: 16px !important;
    overflow: hidden !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4) !important;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative !important;
}

.movie-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
    opacity: 0;
    transition: opacity 0.4s;
    pointer-events: none;
}

.movie-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 16px 40px rgba(239, 68, 68, 0.3);
    border-color: rgba(239, 68, 68, 0.3);
}

.movie-card:hover::before {
    opacity: 1;
}

.movie-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.movie-poster {
    position: relative;
    width: 100%;
    padding-top: 150%;
    overflow: hidden;
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
}

.movie-poster::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 40%;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, transparent 100%);
    pointer-events: none;
}

.movie-poster img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.movie-card:hover .movie-poster img {
    transform: scale(1.1);
}

.movie-rating-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    z-index: 2;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.movie-status-badge {
    position: absolute;
    bottom: 12px;
    left: 12px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 2;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.movie-status-badge.status-dang-chieu {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.movie-status-badge.status-sap-chieu {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

.movie-info {
    padding: 20px;
    background: rgba(255, 255, 255, 0.03);
}

.movie-title {
    font-size: 18px;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 10px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.movie-genres {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.6);
    margin-bottom: 12px;
    font-weight: 500;
}

.movie-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.5);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
}

.meta-item svg {
    filter: drop-shadow(0 2px 4px rgba(251, 191, 36, 0.3));
}

.no-movies {
    text-align: center;
    padding: 80px 20px;
    color: rgba(255, 255, 255, 0.6);
    grid-column: 1 / -1;
    font-size: 18px;
}

.movies-pagination {
    display: flex !important;
    justify-content: center !important;
    margin-top: 90px !important;
    padding-top: 50px !important;
    border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
}

.movies-pagination ul {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: center;
}

.movies-pagination li {
    margin: 0;
}

.movies-pagination a,
.movies-pagination span {
    display: block;
    padding: 12px 18px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.08);
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-weight: 600;
    border: 1px solid rgba(255, 255, 255, 0.1);
    min-width: 48px;
    text-align: center;
    transition: all 0.3s;
    backdrop-filter: blur(10px);
}

.movies-pagination a:hover {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border-color: rgba(239, 68, 68, 0.5);
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(239, 68, 68, 0.4);
}

.movies-pagination .current {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border-color: rgba(239, 68, 68, 0.5);
    box-shadow: 0 4px 16px rgba(239, 68, 68, 0.4);
}

.movies-pagination .dots {
    background: transparent;
    border: none;
    cursor: default;
    color: rgba(255, 255, 255, 0.4);
}

.movies-pagination .dots:hover {
    background: transparent;
    color: rgba(255, 255, 255, 0.4);
    transform: none;
}

@media (max-width: 1024px) {
    .movies-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }
}

@media (max-width: 1024px) {
    .movies-list-container {
        padding: 0 24px;
    }
    
    .movies-list-header {
        margin-bottom: 50px;
        padding: 30px 0;
    }
    
    .page-title {
        font-size: 44px;
    }
}

@media (max-width: 768px) {
    .movies-list-page {
        padding: 60px 0 80px;
    }
    
    .movies-list-container {
        padding: 0 20px;
    }
    
    .movies-list-header {
        margin-bottom: 40px;
        padding: 24px 0;
    }
    
    .page-title {
        font-size: 36px;
        letter-spacing: -1px;
    }
    
    .page-description {
        font-size: 16px;
    }
    
    .movies-filters {
        padding: 24px 20px;
        border-radius: 16px;
        margin-bottom: 36px;
    }
    
    .movies-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 20px;
        margin-bottom: 50px;
    }
    
    .results-count {
        padding: 12px 18px;
        font-size: 14px;
        margin-bottom: 24px;
    }
    
    .movies-pagination {
        margin-top: 60px;
        padding-top: 32px;
    }
    
    .movies-pagination ul {
        gap: 6px;
    }
    
    .movies-pagination a,
    .movies-pagination span {
        padding: 10px 14px;
        font-size: 14px;
        min-width: 44px;
    }
}

@media (max-width: 480px) {
    .movies-list-page {
        padding: 40px 0 60px;
    }
    
    .movies-list-container {
        padding: 0 16px;
    }
    
    .movies-list-header {
        margin-bottom: 32px;
        padding: 20px 0;
    }
    
    .page-title {
        font-size: 32px;
        margin-bottom: 12px;
    }
    
    .page-description {
        font-size: 15px;
    }
    
    .movies-filters {
        padding: 20px 16px;
        margin-bottom: 32px;
    }
    
    .movies-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 40px;
    }
    
    .movies-pagination {
        margin-top: 50px;
        padding-top: 24px;
    }
}
</style>

<script>
// Force apply styles after page load
document.addEventListener('DOMContentLoaded', function() {
    const page = document.querySelector('.movies-list-page');
    if (page) {
        page.style.display = 'block';
        page.style.visibility = 'visible';
    }
});
</script>

<?php
// Include footer tự tạo
if (defined('SITE_LAYOUT_DIR')) {
    include SITE_LAYOUT_DIR . 'templates/footer.php';
} else {
    get_footer();
}
?>

