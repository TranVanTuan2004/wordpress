<?php
/**
 * Template: Phim đang chiếu (slider)
 */

if (!defined('ABSPATH')) {
    exit;
}

$args = array(
    'post_type'      => 'movie',
    'posts_per_page' => 10,
    'tax_query'      => array(
        array(
            'taxonomy' => 'movie_status',
            'field'    => 'slug',
            'terms'    => 'dang-chieu'
        )
    ),
    'meta_key'   => 'movie_release_date',
    'orderby'    => 'meta_value',
    'order'      => 'DESC'
);

$movies_query = new WP_Query($args);
$movie_index  = 1;
?>

<section class="slp-now-showing">
    <div class="slp-ns-container">
        <header class="slp-ns-heading">
            <div class="slp-ns-heading-main">
                <div class="slp-ns-heading-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="3" width="18" height="18" rx="4" ry="4"/>
                        <path d="M8 7v10"/>
                        <path d="M12 7v10"/>
                        <path d="M16 7v10"/>
                    </svg>
                </div>
                <div>
                    <h2 class="slp-ns-title">Phim đang chiếu</h2>
                    <p class="slp-ns-subtitle">Top phim hot nhất đang được công chiếu tại rạp</p>
                </div>
            </div>
            <div class="slp-ns-heading-accent"></div>
        </header>

        <div class="slp-slider slp-ns-slider" data-slp-slider>
            <button class="slp-slider-nav slp-slider-prev" type="button" aria-label="Phim trước">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            <div class="slp-slider-track slp-ns-track">
                <?php if ($movies_query->have_posts()) :
                    while ($movies_query->have_posts()) :
                        $movies_query->the_post();
                        $movie_id    = get_the_ID();
                        $rating      = get_post_meta($movie_id, 'movie_rating', true) ?: 'P';
                        $imdb_rating = get_post_meta($movie_id, 'movie_imdb_rating', true);
                        $imdb_rating = $imdb_rating !== '' ? number_format((float) $imdb_rating, 1) : '9.0';

                        $genres      = wp_get_post_terms($movie_id, 'movie_genre');
                        $genre_names = wp_list_pluck($genres, 'name');
                        $genre_text  = !empty($genre_names) ? implode(', ', $genre_names) : 'Đang cập nhật';

                        $poster      = get_the_post_thumbnail_url($movie_id, 'medium');
                        if (!$poster) {
                            $poster = 'https://via.placeholder.com/320x430/111827/FFFFFF?text=' . urlencode(get_the_title());
                        }
                        ?>
                        <a class="slp-slider-card slp-ns-card" href="<?php the_permalink(); ?>" target="_blank" rel="noopener">
                            <div class="slp-ns-card-poster">
                                <img src="<?php echo esc_url($poster); ?>" alt="<?php the_title_attribute(); ?>">
                                <div class="slp-ns-card-rank">#<?php echo esc_html($movie_index); ?></div>
                                <span class="slp-ns-card-badge"><?php echo esc_html($rating); ?></span>
                                <div class="slp-ns-card-overlay">
                                    <span class="slp-ns-card-play">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="slp-ns-card-body">
                                <h3 class="slp-ns-card-title"><?php the_title(); ?></h3>
                                <p class="slp-ns-card-genre"><?php echo esc_html($genre_text); ?></p>
                                <div class="slp-ns-card-meta">
                                    <span class="slp-ns-card-meta-icon">⭐</span>
                                    <span class="slp-ns-card-meta-value"><?php echo esc_html($imdb_rating); ?></span>
                                </div>
                            </div>
                        </a>
                        <?php
                        $movie_index++;
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <div class="slp-ns-empty">Chưa có phim đang chiếu. Vui lòng thêm dữ liệu từ trang quản trị.</div>
                <?php endif; ?>
            </div>

            <button class="slp-slider-nav slp-slider-next" type="button" aria-label="Phim tiếp theo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>
    </div>
</section>

<style>
.slp-now-showing {
    position: relative;
    padding: 80px 0;
    background: radial-gradient(circle at 10% 10%, rgba(245, 158, 11, 0.12), transparent 60%),
                radial-gradient(circle at 90% 0%, rgba(239, 68, 68, 0.12), transparent 55%),
                radial-gradient(circle at 50% 100%, rgba(59, 130, 246, 0.12), transparent 50%),
                #0f0f0f;
    overflow: hidden;
}

.slp-now-showing::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(15, 15, 15, 0.75) 70%, #0f0f0f 100%);
    pointer-events: none;
}

.slp-ns-container {
    position: relative;
    z-index: 1;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 32px;
}

.slp-ns-heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 32px;
    margin-bottom: 36px;
}

.slp-ns-heading-main {
    display: flex;
    align-items: center;
    gap: 18px;
}

.slp-ns-heading-icon {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 12px 30px rgba(239, 68, 68, 0.35);
    color: #fff;
}

.slp-ns-heading-icon svg {
    width: 28px;
    height: 28px;
}

.slp-ns-title {
    margin: 0;
    font-size: 36px;
    line-height: 1.2;
    font-weight: 800;
    letter-spacing: -0.5px;
    color: #ffffff;
}

.slp-ns-subtitle {
    margin: 6px 0 0;
    font-size: 15px;
    color: rgba(255, 255, 255, 0.68);
    font-weight: 500;
}

.slp-ns-heading-accent {
    flex: 1;
    height: 2px;
    border-radius: 9999px;
    background: linear-gradient(90deg, rgba(245, 158, 11, 0.0), rgba(245, 158, 11, 0.85), rgba(239, 68, 68, 0.0));
    filter: blur(0.2px);
}

.slp-slider {
    position: relative;
}

.slp-slider-track {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 28px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 16px 4px;
    scrollbar-width: none;
}

.slp-slider-track::-webkit-scrollbar {
    display: none;
}

.slp-slider-track.is-compact {
    justify-content: center;
}

.slp-slider-card {
    display: block;
    background: rgba(17, 24, 39, 0.94);
    border: 1px solid rgba(148, 163, 184, 0.12);
    border-radius: 22px;
    padding: 12px;
    text-decoration: none;
    color: inherit;
    position: relative;
    transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease;
    box-shadow: 0 12px 40px rgba(15, 23, 42, 0.45);
}

.slp-slider-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 22px 60px rgba(239, 68, 68, 0.28);
}

.slp-ns-card-poster {
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    aspect-ratio: 3 / 4;
    background: #111827;
}

.slp-ns-card-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.45s ease;
}

.slp-slider-card:hover .slp-ns-card-poster img {
    transform: scale(1.05);
}

.slp-ns-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.0) 20%, rgba(0, 0, 0, 0.75) 100%);
    opacity: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.3s ease;
}

.slp-slider-card:hover .slp-ns-card-overlay {
    opacity: 1;
}

.slp-ns-card-play {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(245,158,11,0.9), rgba(239,68,68,0.9));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    box-shadow: 0 12px 30px rgba(239, 68, 68, 0.45);
}

.slp-ns-card-play svg {
    width: 26px;
    height: 26px;
    margin-left: 2px;
}

.slp-ns-card-rank {
    position: absolute;
    top: 14px;
    left: 14px;
    min-width: 42px;
    padding: 8px 12px;
    font-size: 13px;
    font-weight: 700;
    border-radius: 999px;
    color: #fff;
    background: rgba(17, 24, 39, 0.75);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(148, 163, 184, 0.25);
}

.slp-ns-card-badge {
    position: absolute;
    top: 14px;
    right: 14px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 700;
    border-radius: 999px;
    color: #0f172a;
    background: linear-gradient(135deg, #fde68a, #facc15);
    box-shadow: 0 6px 18px rgba(250, 204, 21, 0.35);
}

.slp-ns-card-body {
    padding: 18px 6px 6px;
}

.slp-ns-card-title {
    margin: 0 0 10px;
    color: #f8fafc;
    font-size: 17px;
    font-weight: 700;
    line-height: 1.35;
    min-height: 46px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.slp-ns-card-genre {
    margin: 0 0 16px;
    color: rgba(226, 232, 240, 0.75);
    font-size: 13px;
    min-height: 34px;
}

.slp-ns-card-meta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 700;
    color: #facc15;
    font-size: 14px;
}

.slp-ns-card-meta-icon {
    font-size: 16px;
}

.slp-slider-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 48px;
    height: 48px;
    border-radius: 50%;
    border: 1px solid rgba(148, 163, 184, 0.25);
    background: rgba(15, 23, 42, 0.85);
    color: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.4);
    z-index: 2;
}

.slp-slider-nav svg {
    width: 20px;
    height: 20px;
}

.slp-slider-nav:hover {
    background: rgba(239, 68, 68, 0.95);
    border-color: rgba(239, 68, 68, 0.6);
    color: #fff;
}

.slp-slider-prev {
    left: -12px;
}

.slp-slider-next {
    right: -12px;
}

.slp-slider-nav.is-disabled {
    opacity: 0.35;
    pointer-events: none;
}

.slp-ns-empty {
    flex: 1 1 100%;
    text-align: center;
    color: rgba(255, 255, 255, 0.7);
    font-size: 16px;
    padding: 50px 20px;
    border: 1px dashed rgba(148, 163, 184, 0.4);
    border-radius: 18px;
    background: rgba(15, 23, 42, 0.55);
}

@media (max-width: 1024px) {
    .slp-ns-title {
        font-size: 30px;
    }
    .slp-slider-card {
        flex-basis: 220px;
    }
    .slp-slider-prev {
        left: -6px;
    }
    .slp-slider-next {
        right: -6px;
    }
}

@media (max-width: 768px) {
    .slp-now-showing {
        padding: 60px 0;
    }
    .slp-ns-container {
        padding: 0 20px;
    }
    .slp-ns-heading {
        flex-direction: column;
        align-items: flex-start;
        gap: 18px;
    }
    .slp-ns-heading-accent {
        width: 100%;
    }
    .slp-slider-nav {
        display: none;
    }
    .slp-slider-track {
        gap: 20px;
        padding: 8px 2px;
    }
    .slp-slider-card {
        flex-basis: 200px;
    }
}

@media (max-width: 520px) {
    .slp-ns-title {
        font-size: 26px;
    }
    .slp-ns-heading-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
    }
    .slp-ns-container {
        padding: 0 16px;
    }
}
</style>
