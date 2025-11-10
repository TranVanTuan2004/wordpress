<?php
/**
 * Template: Phim sắp chiếu (slider)
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
            'terms'    => 'sap-chieu'
        )
    ),
    'meta_key'   => 'movie_release_date',
    'orderby'    => 'meta_value',
    'order'      => 'ASC'
);

$coming_query = new WP_Query($args);
?>

<section class="slp-coming-soon">
    <div class="slp-cs-container">
        <header class="slp-cs-heading">
            <div class="slp-cs-heading-main">
                <div class="slp-cs-heading-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 4h16v16H4z"/>
                        <path d="M4 10h16"/>
                        <path d="M10 4v4"/>
                        <path d="M14 15l2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="slp-cs-title">Phim sắp chiếu</h2>
                    <p class="slp-cs-subtitle">Đặt vé trước để không bỏ lỡ những bom tấn sắp ra mắt</p>
                </div>
            </div>
            <div class="slp-cs-heading-accent"></div>
        </header>

        <div class="slp-slider slp-cs-slider" data-slp-slider>
            <button class="slp-slider-nav slp-slider-prev" type="button" aria-label="Phim trước">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            <div class="slp-slider-track slp-cs-track">
                <?php if ($coming_query->have_posts()) :
                    while ($coming_query->have_posts()) :
                        $coming_query->the_post();
                        $movie_id   = get_the_ID();
                        $rating     = get_post_meta($movie_id, 'movie_rating', true) ?: 'P';
                        $release    = get_post_meta($movie_id, 'movie_release_date', true);
                        $release    = $release ? date_i18n('d/m/Y', strtotime($release)) : 'Đang cập nhật';

                        $genres     = wp_get_post_terms($movie_id, 'movie_genre');
                        $genre_text = implode(', ', wp_list_pluck($genres, 'name'));
                        if (!$genre_text) {
                            $genre_text = 'Đang cập nhật';
                        }

                        $poster = get_the_post_thumbnail_url($movie_id, 'medium_large');
                        if (!$poster) {
                            $poster = 'https://via.placeholder.com/320x430/F1F5F9/1F2937?text=' . urlencode(get_the_title());
                        }
                        ?>
                        <a class="slp-slider-card slp-cs-card" href="<?php the_permalink(); ?>" target="_blank" rel="noopener">
                            <div class="slp-cs-card-poster">
                                <img src="<?php echo esc_url($poster); ?>" alt="<?php the_title_attribute(); ?>">
                                <span class="slp-cs-card-badge"><?php echo esc_html($rating); ?></span>
                            </div>
                            <div class="slp-cs-card-body">
                                <span class="slp-cs-card-release">Khởi chiếu: <?php echo esc_html($release); ?></span>
                                <h3 class="slp-cs-card-title"><?php the_title(); ?></h3>
                                <p class="slp-cs-card-genre"><?php echo esc_html($genre_text); ?></p>
                                <span class="slp-cs-card-link">Xem chi tiết</span>
                            </div>
                        </a>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <div class="slp-cs-empty">Chưa có dữ liệu phim sắp chiếu. Hãy cập nhật thêm phim mới!</div>
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
.slp-coming-soon {
    position: relative;
    padding: 80px 0;
    background: radial-gradient(circle at 10% 10%, rgba(216, 180, 254, 0.35), transparent 55%),
                radial-gradient(circle at 80% 0%, rgba(167, 139, 250, 0.35), transparent 50%),
                #f8fafc;
}

.slp-coming-soon::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(248, 250, 252, 0.95) 0%, rgba(248, 250, 252, 0.75) 80%, rgba(248, 250, 252, 1) 100%);
    pointer-events: none;
}

.slp-cs-container {
    position: relative;
    z-index: 1;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 32px;
}

.slp-cs-heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 28px;
    margin-bottom: 36px;
}

.slp-cs-heading-main {
    display: flex;
    align-items: center;
    gap: 18px;
}

.slp-cs-heading-icon {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    background: linear-gradient(135deg, #c084fc 0%, #8b5cf6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    box-shadow: 0 16px 32px rgba(139, 92, 246, 0.28);
}

.slp-cs-heading-icon svg {
    width: 28px;
    height: 28px;
}

.slp-cs-title {
    margin: 0;
    font-size: 36px;
    font-weight: 800;
    color: #1e1b4b;
    letter-spacing: -0.5px;
}

.slp-cs-subtitle {
    margin: 6px 0 0;
    font-size: 15px;
    color: rgba(30, 27, 75, 0.7);
    font-weight: 500;
}

.slp-cs-heading-accent {
    flex: 1;
    height: 2px;
    border-radius: 999px;
    background: linear-gradient(90deg, rgba(139, 92, 246, 0.0), rgba(139, 92, 246, 0.55), rgba(139, 92, 246, 0.0));
}

.slp-cs-slider .slp-slider-track {
    gap: 28px;
}

.slp-cs-card {
    flex: 0 0 250px;
    background: #ffffff;
    border-radius: 22px;
    border: 1px solid rgba(148, 163, 184, 0.24);
    box-shadow: 0 18px 40px rgba(148, 163, 184, 0.2);
    transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease;
    overflow: hidden;
}

.slp-cs-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 24px 60px rgba(129, 140, 248, 0.25);
}

.slp-cs-card-poster {
    position: relative;
    aspect-ratio: 3 / 4;
    overflow: hidden;
    background: #e2e8f0;
}

.slp-cs-card-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.45s ease;
}

.slp-cs-card:hover .slp-cs-card-poster img {
    transform: scale(1.05);
}

.slp-cs-card-badge {
    position: absolute;
    top: 14px;
    right: 14px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 700;
    color: #4c1d95;
    background: linear-gradient(135deg, #ede9fe, #ddd6fe);
    border-radius: 999px;
    box-shadow: 0 8px 18px rgba(129, 140, 248, 0.25);
}

.slp-cs-card-body {
    padding: 18px 18px 22px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.slp-cs-card-release {
    font-size: 13px;
    font-weight: 600;
    color: #6b21a8;
    background: rgba(236, 233, 254, 0.8);
    border-radius: 999px;
    padding: 6px 12px;
    align-self: flex-start;
}

.slp-cs-card-title {
    margin: 0;
    color: #1e293b;
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

.slp-cs-card-genre {
    margin: 0;
    color: rgba(30, 41, 59, 0.7);
    font-size: 13px;
    min-height: 34px;
}

.slp-cs-card-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
    color: #6d28d9;
    font-size: 14px;
}

.slp-cs-card-link::after {
    content: '›';
    font-size: 16px;
}

.slp-cs-empty {
    flex: 1 1 100%;
    text-align: center;
    font-size: 16px;
    color: rgba(30, 27, 75, 0.65);
    border: 1px dashed rgba(203, 213, 225, 0.8);
    border-radius: 18px;
    padding: 50px 20px;
    background: rgba(255, 255, 255, 0.85);
}

.slp-coming-soon .slp-slider-prev {
    left: -12px;
}

.slp-coming-soon .slp-slider-next {
    right: -12px;
}

.slp-coming-soon .slp-slider-nav {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(99, 102, 241, 0.25);
    color: #4c1d95;
}

.slp-coming-soon .slp-slider-nav:hover {
    background: linear-gradient(135deg, #c084fc, #8b5cf6);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 18px 30px rgba(139, 92, 246, 0.3);
}

@media (max-width: 1024px) {
    .slp-cs-title {
        font-size: 30px;
    }
    .slp-cs-card {
        flex-basis: 230px;
    }
}

@media (max-width: 768px) {
    .slp-coming-soon {
        padding: 60px 0;
    }
    .slp-cs-container {
        padding: 0 20px;
    }
    .slp-cs-heading {
        flex-direction: column;
        align-items: flex-start;
        gap: 18px;
    }
    .slp-cs-heading-accent {
        width: 100%;
    }
    .slp-coming-soon .slp-slider-nav {
        display: none;
    }
}

@media (max-width: 520px) {
    .slp-cs-container {
        padding: 0 16px;
    }
    .slp-cs-title {
        font-size: 26px;
    }
    .slp-cs-card {
        flex-basis: 210px;
    }
}
</style>
