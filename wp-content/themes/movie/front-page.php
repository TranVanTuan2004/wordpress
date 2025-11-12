<h1>This is file front-page.php </h1>
<?php 

//slider content

//lấy tất cả phim
$args = array(
    'post_type' => 'mbs_movie',
    // 'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC'
);
$query = new WP_Query($args);
?>
    <h1 class="title">Phim nỗi bật</h1>
<div class="movie-slider-wrapper">
    <button class="slider-btn prev">←</button>
    <div class="movie-slider" id="movieSlider">
        <?php while($query->have_posts()){ $query->the_post();
            // Lấy thông tin phim
            $duration = get_post_meta(get_the_ID(), '_mbs_duration', true);
            $director = get_post_meta(get_the_ID(), '_mbs_director', true);
            $actors = get_post_meta(get_the_ID(), '_mbs_actors', true);
            $release_date = get_post_meta(get_the_ID(), '_mbs_release_date', true);
            $rating = get_post_meta(get_the_ID(), '_mbs_rating', true);
            $trailer_url = get_post_meta(get_the_ID(), '_mbs_trailer_url', true);
            $language = get_post_meta(get_the_ID(), '_mbs_language', true);
        ?>
            
            <div class="movie-card">
                <h3><?php the_title(); ?></h3>
                <!-- thêm cái hình tiêu đề phim -->
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('medium');
                    } else {
                    echo '<img src="' . get_template_directory_uri() . '/assets/no-image.jpg" alt="No image">';
                    } ?>
                </a>
                <ul class="movie-info">
                    <li>🎬 <?php echo esc_html($duration); ?> phút</li>
                    <li>🎥 <?php echo esc_html($director); ?></li>
                    <li>👥 <?php echo esc_html($actors); ?></li>
                    <li>📅 <?php echo esc_html($release_date); ?></li>
                    <li>⭐ <?php echo esc_html($rating); ?></li>
                    <li>🗣️ <?php echo esc_html($language); ?></li>
                    <?php if ($trailer_url): ?>
                        <li>▶️ <a href="<?php echo esc_url($trailer_url); ?>" target="_blank">Xem trailer</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php } wp_reset_postdata(); ?>
    </div>
    <button class="slider-btn next">→</button>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('movieSlider');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    const scrollAmount = 320;

    // Nút điều hướng
    prevBtn.addEventListener('click', () => {
        slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });

    nextBtn.addEventListener('click', () => {
        slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });

    // Tự động trượt và quay về đầu khi tới cuối
    let autoScroll = setInterval(() => {
        const maxScroll = slider.scrollWidth - slider.clientWidth;
        if (slider.scrollLeft >= maxScroll - scrollAmount) {
            // Quay về đầu
            slider.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            // Trượt tiếp
            slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }, 2000);

    // Dừng auto khi rê chuột vào slider
    slider.addEventListener('mouseenter', () => clearInterval(autoScroll));
    slider.addEventListener('mouseleave', () => {
        autoScroll = setInterval(() => {
            const maxScroll = slider.scrollWidth - slider.clientWidth;
            if (slider.scrollLeft >= maxScroll - scrollAmount) {
                slider.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }, 2000);
    });
});
</script>


<style>
*{
    margin: 0;
    padding: 0;
}

body{
    background-color: #221d26;
    color: #fff;
}
.title{
    text-align: center;
    color: #e80a0aff;
}
/* Container bao toàn bộ slider */
.movie-slider-wrapper {
    /* width: 100%;
    overflow: hidden;
    display: flex;
    justify-content: center; */
    position: relative;
    width: 100%;
    max-width: 880px;
    margin: auto;
    overflow: hidden;
    padding: 0 60px; /* chừa chỗ cho nút trái/phải */
}

/* Slider ngang */
.movie-slider {
    display: flex;
    gap: 20px;
    scroll-snap-type: x mandatory;
    overflow-x: auto;
    padding: 20px;
    max-width: 880px; /* 4 phim x 200px + 3 khoảng cách 20px */
    scroll-behavior: smooth;
}

.movie-slider {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE 10+ */
}
.movie-slider::-webkit-scrollbar {
    display: none; /* Chrome, Safari */
}

/* Mỗi thẻ phim */
.movie-card {
    flex: 0 0 300px;
    scroll-snap-align: start;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    padding: 15px;
    transition: transform 0.3s ease;
}
.movie-card:hover {
    transform: translateY(-5px);
}

/* Ảnh phim */
.movie-card img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    object-fit: cover;
    margin-bottom: 10px;
}

/* Tiêu đề */
.movie-card h3 {
    font-size: 18px;
    margin: 10px 0;
    text-align: center;
    color: #e80a0aff;
}

/* Thông tin phim */
.movie-info {
    list-style: none;
    padding: 0;
    font-size: 14px;
    color: #555;
}
.movie-info li {
    margin-bottom: 6px;
    line-height: 1.4;
}
.movie-info a {
    color: #e50914;
    text-decoration: none;
    font-weight: bold;
}
.movie-info a:hover {
    text-decoration: underline;
}

.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: #e50914;
    color: #fff;
    border: none;
    font-size: 24px;
    width: 50px;
    height: 50px;
    cursor: pointer;
    border-radius: 50%;
    z-index: 10;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
}

/* Đặt nút nằm trong wrapper */
.prev {
    left: 0;
}
.next {
    right: 0;
}

</style>






