<?php
/**
 * Archive Template: Movies List
 * Hiển thị danh sách phim từ custom post type "movie"
 */

// Include header tự tạo
if (defined('SITE_LAYOUT_DIR')) {
    include SITE_LAYOUT_DIR . 'templates/header.php';
} else {
    get_header();
}
?>

<div class="movies-archive-page">
    <div class="movies-archive-container">
        <header class="movies-archive-header">
            <h1 class="archive-title">Danh Sách Phim</h1>
            <p class="archive-description">Khám phá bộ sưu tập phim đa dạng của chúng tôi</p>
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

            $current_genre = isset($_GET['genre']) ? sanitize_text_field($_GET['genre']) : '';
            $current_status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
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

        <!-- Movies Grid -->
        <div class="movies-grid">
            <?php
            // Query args
            $args = array(
                'post_type' => 'movie',
                'posts_per_page' => 12,
                'post_status' => 'publish',
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
            );

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
                echo paginate_links(array(
                    'total' => $movies_query->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                    'prev_text' => '← Trước',
                    'next_text' => 'Sau →',
                ));
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.movies-archive-page {
    padding: 40px 0;
    background: #f5f5f5;
    min-height: 100vh;
}

.movies-archive-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.movies-archive-header {
    text-align: center;
    margin-bottom: 40px;
}

.archive-title {
    font-size: 36px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 10px;
}

.archive-description {
    font-size: 16px;
    color: #6b7280;
    margin: 0;
}

.movies-filters {
    background: white;
    padding: 24px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.filter-group {
    margin-bottom: 20px;
}

.filter-group:last-child {
    margin-bottom: 0;
}

.filter-group label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 12px;
    font-size: 14px;
}

.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.filter-btn {
    padding: 8px 16px;
    border-radius: 20px;
    background: #f3f4f6;
    color: #6b7280;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
    border: 2px solid transparent;
}

.filter-btn:hover {
    background: #e5e7eb;
    color: #374151;
}

.filter-btn.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.movie-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.movie-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
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
    background: #1f2937;
}

.movie-poster img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.movie-rating-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: #e74c3c;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 700;
}

.movie-status-badge {
    position: absolute;
    bottom: 8px;
    left: 8px;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.movie-status-badge.status-dang-chieu {
    background: #10b981;
    color: white;
}

.movie-status-badge.status-sap-chieu {
    background: #3b82f6;
    color: white;
}

.movie-info {
    padding: 16px;
}

.movie-title {
    font-size: 16px;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 8px;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.movie-genres {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 8px;
}

.movie-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 12px;
    color: #9ca3af;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 4px;
}

.no-movies {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
}

.movies-pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 40px;
}

.movies-pagination a,
.movies-pagination span {
    padding: 10px 16px;
    border-radius: 8px;
    background: white;
    color: #374151;
    text-decoration: none;
    font-weight: 500;
    border: 1px solid #e5e7eb;
}

.movies-pagination a:hover {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.movies-pagination .current {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

@media (max-width: 768px) {
    .movies-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 16px;
    }
    
    .archive-title {
        font-size: 28px;
    }
}
</style>

<?php
// Include footer tự tạo
if (defined('SITE_LAYOUT_DIR')) {
    include SITE_LAYOUT_DIR . 'templates/footer.php';
} else {
    get_footer();
}
?>


