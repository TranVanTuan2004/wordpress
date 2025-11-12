
<nav class="cinestar-menu">
    <ul>
        <li><a href="#">Chọn rạp</a></li>
        <li><a href="#">Lịch chiếu</a></li>
        <li><a href="#">Khuyến mãi</a></li>
        <li><a href="#">Tổ chức sự kiện</a></li>
        <li><a href="#">Dịch vụ giải trí khác</a></li>
        <li><a href="#">Giới thiệu</a></li>
    </ul>
</nav>

<h1 class="title">Sự kiện</h1>
<div class="event-slider-wrapper">
    <button class="event-btn prev_event">←</button>
    <div class="event-slider" id="eventSlider">
        <?php 
        $args_event = array(
            'post_type' => 'event',
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $query_event = new WP_Query($args_event);
        if ($query_event->have_posts()) {
            while ($query_event->have_posts()) {
                $query_event->the_post();
                $date = get_post_meta(get_the_ID(), '_event_date', true);
                $location = get_post_meta(get_the_ID(), '_event_location', true);
        ?>
        <div class="event-item">
            <a href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('large');
                } else {
                    echo '<img src="' . get_template_directory_uri() . '/assets/no-image.jpg" alt="No image">';
                } ?>
            </a>
        </div>
        <?php 
            }
        }
        wp_reset_postdata();
        ?>
    </div>
    <button class="event-btn next_event">→</button>
</div>

    

<?php 
//slider content
//lấy tất cả phim
$args_movie = array(
    'post_type' => 'mbs_movie',
    // 'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC'
);
$query_movie = new WP_Query($args_movie);
?>


<div class="movie-slider-wrapper">
    <h1 class="title">Phim nổi bật</h1>
    <button class="slider-btn prev">←</button>
    <div class="movie-slider" id="movieSlider">
        <?php while($query_movie->have_posts()){ $query_movie->the_post();
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
    const scrollAmount = 285 * 4 + 20 * 3;

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
    }, 4000);

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
        }, 4000);
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const slider_event = document.getElementById('eventSlider');
    const scrollAmount = slider_event.clientWidth + 20; // 100% width + khoảng cách
    const prevBtn_Event = document.querySelector('.prev_event');
    const nextBtn_Event = document.querySelector('.next_event');
    //click
    prevBtn_Event.addEventListener('click', () => {
        slider_event.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });

    nextBtn_Event.addEventListener('click', () => {
        slider_event.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
    // Tự động trượt và quay về đầu khi tới cuối
    let autoScroll = setInterval(() => {
        const maxScroll = slider_event.scrollWidth - slider_event.clientWidth;
        if (slider_event.scrollLeft >= maxScroll - scrollAmount) {
            // Quay về đầu
            slider_event.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            // Trượt tiếp
            slider_event.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }, 4000); // trượt mỗi 5 giây

    // Dừng auto khi rê chuột vào slider
    slider_event.addEventListener('mouseenter', () => clearInterval(autoScroll));
    slider_event.addEventListener('mouseleave', () => {
        autoScroll = setInterval(() => {
            const maxScroll = slider_event.scrollWidth - slider_event.clientWidth;
            if (slider_event.scrollLeft >= maxScroll - scrollAmount) {
                slider_event.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                slider_event.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }, 4000);
    });
});

</script>


<style>
*{
    margin: 0;
    padding: 0;
}

body{
    background-color: #001f3f;
    color: #fff;
}

/* title */
.cinestar-menu {
    background-color: #001f3f;
    padding: 15px 0;
    font-family: Arial, sans-serif;
}

.cinestar-menu ul {
    display: flex;
    justify-content: center;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 40px;
}

.cinestar-menu li a {
    color: #ffffff;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    transition: color 0.3s ease;
}

.cinestar-menu li a:hover {
    color: #ffcc00; /* vàng nổi bật khi hover */
}

/* event */
.event-slider-wrapper {
    position: relative;
    max-width: 1200px; /* tăng kích thước slider */
    margin: auto;
    overflow: hidden;
    padding: 0 60px;
}

/* Slider ngang */
.event-slider {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    gap: 20px;
    scrollbar-width: none;
}
.event-slider::-webkit-scrollbar {
    display: none;
}

/* Mỗi ảnh sự kiện */
.event-item {
    flex: 0 0 100%;
    scroll-snap-align: center;
    text-align: center;
    position: relative;
}
.event-item img {
    width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

/* Nút điều hướng */
.event-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.8); /* màu trắng trong suốt */
    color: #001f3f;
    border: none;
    font-size: 24px;
    width: 45px;
    height: 45px;
    cursor: pointer;
    border-radius: 50%;
    z-index: 10;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    transition: background 0.3s ease;
}
.event-btn:hover {
    background: #ffffff;
}
.prev_event {
    left: 10px;
}
.next_event {
    right: 10px;
}

/* movie */
.title{
    padding: 40px;
    text-align: center;
    color: #e80a0aff;
    
}
/* Container bao toàn bộ slider */
.movie-slider-wrapper {
    position: relative;
    width: 100%;
    max-width: 1200px;
    margin: 100px auto;
    overflow: hidden;
    padding: 0 60px; /* chừa chỗ cho nút trái/phải */
}

/* Slider ngang */
.movie-slider {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    padding: 0; /* bỏ padding ngang nếu có */
    max-width: 1200px;
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
    /* flex: 0 0 calc((1200px - 3 * 20px) / 4); chia đều 4 phim + 3 khoảng cách */
    flex: 0 0 285px; /* đúng 4 phim trong 1200px */
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






