<?php
/**
 * Template Name: Danh Sách Yêu Thích
 * Template for page with slug: favorites
 */

get_header();

if (!is_user_logged_in()) {
    ?>
    <main class="favorites-page">
        <div class="favorites-container">
            <div class="favorites-login-required">
                <div class="login-icon">🔒</div>
                <h1>Vui lòng đăng nhập</h1>
                <p>Bạn cần đăng nhập để xem danh sách phim yêu thích của mình.</p>
                <a href="<?php echo esc_url(home_url('/dangnhap')); ?>" class="login-btn">Đăng nhập</a>
            </div>
        </div>
    </main>
    <?php
    get_footer();
    return;
}

$user_id = get_current_user_id();
$favorites = get_user_meta($user_id, 'favorite_movies', true);
$favorites = is_array($favorites) ? $favorites : array();
$favorites = array_filter($favorites); // Remove empty values

if (empty($favorites)) {
    ?>
    <main class="favorites-page">
        <div class="favorites-container">
            <h1 class="favorites-title">PHIM YÊU THÍCH</h1>
            <div class="favorites-empty">
                <div class="empty-icon">❤️</div>
                <h2>Chưa có phim yêu thích</h2>
                <p>Bạn chưa thêm phim nào vào danh sách yêu thích.</p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="browse-movies-btn">Khám phá phim</a>
            </div>
        </div>
    </main>
    <?php
    get_footer();
    return;
}

// Lấy thông tin các phim yêu thích
$movies_query = new WP_Query(array(
    'post_type' => 'mbs_movie',
    'post__in' => $favorites,
    'posts_per_page' => -1,
    'orderby' => 'post__in', // Giữ nguyên thứ tự trong mảng
    'post_status' => 'publish'
));
?>

<main class="favorites-page">
    <div class="favorites-container">
        <h1 class="favorites-title">PHIM YÊU THÍCH <span class="favorites-count">(<?php echo count($favorites); ?>)</span></h1>

        <?php if ($movies_query->have_posts()) : ?>
            <div class="favorites-grid">
                <?php while ($movies_query->have_posts()) : $movies_query->the_post(); 
                    $movie_id = get_the_ID();
                    $thumb_url = get_the_post_thumbnail_url($movie_id, 'medium');
                    $duration = get_post_meta($movie_id, '_mbs_duration', true);
                    $release_date = get_post_meta($movie_id, '_mbs_release_date', true);
                ?>
                    <article class="favorite-movie-card">
                        <a href="<?php the_permalink(); ?>" class="movie-card-link">
                            <div class="movie-card-thumbnail">
                                <?php if ($thumb_url) : ?>
                                    <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>" />
                                <?php else : ?>
                                    <div class="movie-card-placeholder">
                                        <i class="bx bx-movie"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="movie-card-overlay">
                                    <button class="favorite-btn-remove is-favorite" data-movie-id="<?php echo esc_attr($movie_id); ?>" title="Xóa khỏi yêu thích">
                                        <i class="bx bxs-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="movie-card-info">
                                <h3 class="movie-card-title"><?php the_title(); ?></h3>
                                <div class="movie-card-meta">
                                    <?php if ($duration) : ?>
                                        <span class="meta-item"><i class="bx bx-time"></i> <?php echo esc_html($duration); ?> phút</span>
                                    <?php endif; ?>
                                    <?php if ($release_date) : ?>
                                        <span class="meta-item"><i class="bx bx-calendar"></i> <?php echo esc_html($release_date); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endwhile; 
                wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="favorites-empty">
                <div class="empty-icon">❤️</div>
                <h2>Không tìm thấy phim</h2>
                <p>Các phim yêu thích của bạn có thể đã bị xóa hoặc không còn tồn tại.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
    .favorites-page {
        min-height: calc(100vh - 120px);
        background: linear-gradient(180deg, rgba(10,10,40,0.00) 0%, rgba(7,30,61,0.25) 100%);
        color: #ffffff;
        padding: 40px 0;
    }

    .favorites-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 16px;
    }

    .favorites-title {
        font-size: 32px;
        font-weight: 900;
        margin-bottom: 30px;
        color: #ffffff;
        letter-spacing: 0.04em;
    }

    .favorites-count {
        font-size: 20px;
        color: #ffe44d;
        font-weight: 700;
    }

    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 24px;
    }

    .favorite-movie-card {
        background: rgba(7, 30, 61, 0.65);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .favorite-movie-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4);
    }

    .movie-card-link {
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .movie-card-thumbnail {
        position: relative;
        width: 100%;
        padding-top: 150%;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.05);
    }

    .movie-card-thumbnail img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .movie-card-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
    }

    .movie-card-placeholder i {
        font-size: 48px;
        color: rgba(255, 255, 255, 0.3);
    }

    .movie-card-overlay {
        position: absolute;
        top: 8px;
        right: 8px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .favorite-movie-card:hover .movie-card-overlay {
        opacity: 1;
    }

    .favorite-btn-remove {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 107, 157, 0.9);
        border: none;
        color: #ffffff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(255, 107, 157, 0.4);
    }

    .favorite-btn-remove:hover {
        background: rgba(199, 21, 133, 0.9);
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(255, 107, 157, 0.6);
    }

    .favorite-btn-remove i {
        font-size: 20px;
    }

    .movie-card-info {
        padding: 16px;
    }

    .movie-card-title {
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 8px 0;
        color: #ffffff;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .movie-card-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .meta-item i {
        font-size: 14px;
    }

    .favorites-empty,
    .favorites-login-required {
        text-align: center;
        padding: 60px 20px;
        background: rgba(7, 30, 61, 0.65);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 12px;
    }

    .empty-icon,
    .login-icon {
        font-size: 64px;
        margin-bottom: 20px;
    }

    .favorites-empty h2,
    .favorites-login-required h1 {
        font-size: 24px;
        font-weight: 800;
        margin: 0 0 16px 0;
        color: #ffffff;
    }

    .favorites-empty p,
    .favorites-login-required p {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 24px;
    }

    .browse-movies-btn,
    .login-btn {
        display: inline-block;
        padding: 12px 24px;
        background: #ffe44d;
        color: #0e1220;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 800;
        transition: all 0.2s ease;
    }

    .browse-movies-btn:hover,
    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(255, 228, 77, 0.35);
    }

    @media (max-width: 768px) {
        .favorites-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 16px;
        }

        .favorites-title {
            font-size: 24px;
        }
    }
</style>

<script>
jQuery(document).ready(function($) {
    // Xử lý xóa khỏi yêu thích từ trang danh sách
    $('.favorite-btn-remove').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var $btn = $(this);
        var $card = $btn.closest('.favorite-movie-card');
        var movieId = $btn.data('movie-id');
        
        if (!confirm('Bạn có chắc muốn xóa phim này khỏi danh sách yêu thích?')) {
            return;
        }
        
        $btn.prop('disabled', true);
        
        $.ajax({
            url: movieFavorite.ajaxurl,
            type: 'POST',
            data: {
                action: 'movie_toggle_favorite',
                movie_id: movieId,
                nonce: movieFavorite.nonce
            },
            success: function(response) {
                if (response.success && !response.data.is_favorite) {
                    // Fade out và xóa card
                    $card.fadeOut(300, function() {
                        $(this).remove();
                        // Cập nhật số lượng
                        var count = $('.favorite-movie-card').length;
                        $('.favorites-count').text('(' + count + ')');
                        
                        // Nếu không còn phim nào, reload trang
                        if (count === 0) {
                            location.reload();
                        }
                    });
                }
            },
            error: function() {
                alert('Có lỗi xảy ra');
                $btn.prop('disabled', false);
            }
        });
    });
});
</script>

<?php
get_footer();
?>

