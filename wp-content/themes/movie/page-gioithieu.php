<?php
/**
 * Template Name: Trang Giới Thiệu
 * Template for About Page
 * 
 * @package Movie
 * @since 1.0
 */

get_header();

// Lấy danh sách rạp từ CPT
$candidates = array('rap_phim','rap-phim','cinema','theater','mbs_cinema','rap','rapfilm','rap_phim_cpt');
$cinema_pt = null;
foreach ($candidates as $cpt) {
    $probe = new WP_Query(array('post_type'=>$cpt, 'posts_per_page'=>1));
    if ($probe->have_posts()) { 
        $cinema_pt = $cpt; 
        wp_reset_postdata(); 
        break; 
    }
    wp_reset_postdata();
}

$cinemas = array();
if ($cinema_pt) {
    $cinemas_query = new WP_Query(array(
        'post_type' => $cinema_pt,
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    ));
    while ($cinemas_query->have_posts()) {
        $cinemas_query->the_post();
        $cinemas[] = array(
            'title' => get_the_title(),
            'link' => get_permalink(),
            'image' => get_the_post_thumbnail_url(get_the_ID(), 'large') ?: 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=600&h=400&fit=crop',
        );
    }
    wp_reset_postdata();
}

// Danh sách rạp mặc định nếu không có trong database
$default_cinemas = array(
    array('title' => 'CINESTAR QUỐC THANH', 'image' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=600&h=400&fit=crop'),
    array('title' => 'CINESTAR ĐÀ LẠT', 'image' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=600&h=400&fit=crop'),
    array('title' => 'DALAT OPERA HOUSE', 'image' => 'https://images.unsplash.com/photo-1503095396549-807759245b35?w=600&h=400&fit=crop'),
    array('title' => 'CINESTAR HAI BÀ TRƯNG (TP.HCM)', 'image' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=600&h=400&fit=crop'),
    array('title' => 'CINESTAR HUẾ', 'image' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=600&h=400&fit=crop'),
    array('title' => 'CINESTAR SINH VIÊN (TP.HCM)', 'image' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=600&h=400&fit=crop'),
    array('title' => 'CINESTAR MỸ THO', 'image' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=600&h=400&fit=crop'),
    array('title' => 'CINESTAR KIÊN GIANG', 'image' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=600&h=400&fit=crop'),
    array('title' => 'CINESTAR LÂM ĐỒNG', 'image' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=600&h=400&fit=crop'),
    array('title' => 'CINESTAR SATRA QUẬN 6', 'image' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=600&h=400&fit=crop'),
    array('title' => 'CINESTAR PARKCITY HÀ NỘI', 'image' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=600&h=400&fit=crop'),
);

// Kết hợp danh sách rạp từ database và mặc định
$all_cinemas = !empty($cinemas) ? $cinemas : $default_cinemas;
?>

<main class="about-page-wrapper">
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="hero-background">
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-content">
            <h1 class="hero-title">HỆ THỐNG CỤM RẠP TRÊN TOÀN QUỐC</h1>
        </div>
    </section>

    <div class="about-container">
        <!-- Introduction Section -->
        <section class="intro-section">
            <div class="intro-content">
                <p class="intro-text">
                    Cinestar là hệ thống rạp chiếu phim phổ biến tại Việt Nam, mang đến nhiều mô hình giải trí đa dạng bao gồm tổ hợp rạp chiếu phim hiện đại, nhà hát, khu vui chơi trẻ em Kidzona, bowling, billiards, games, gym, nhà hàng và phố C'Beer Street.
                </p>
                <p class="intro-text">
                    Cinestar hướng tới mục tiêu trở thành điểm đến giải trí cho gia đình Việt, hỗ trợ phim Việt Nam và đưa các tác phẩm điện ảnh trong nước đến gần hơn với khán giả, bên cạnh những bộ phim bom tấn quốc tế.
                </p>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="mission-section">
            <h2 class="mission-title">SỨ MỆNH</h2>
            <div class="mission-grid">
                <div class="mission-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="mission-number">01</div>
                    <div class="mission-content">
                        <h3 class="mission-card-title">Phát triển thị trường</h3>
                        <p class="mission-card-text">
                            Góp phần phát triển thị phần thị trường phim, văn hóa và giải trí cho người Việt Nam.
                        </p>
                    </div>
                </div>

                <div class="mission-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="mission-number">02</div>
                    <div class="mission-content">
                        <h3 class="mission-card-title">Dịch vụ tối ưu</h3>
                        <p class="mission-card-text">
                            Phát triển các dịch vụ tốt nhất với mức giá tối ưu, phù hợp với thu nhập của người Việt Nam.
                        </p>
                    </div>
                </div>

                <div class="mission-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="mission-number">03</div>
                    <div class="mission-content">
                        <h3 class="mission-card-title">Hội nhập quốc tế</h3>
                        <p class="mission-card-text">
                            Đưa nghệ thuật và văn hóa điện ảnh Việt Nam đến với hội nhập quốc tế.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Locations Grid Section -->
        <section class="locations-section">
            <h2 class="locations-title">HỆ THỐNG RẠP VÀ CƠ SỞ VẬT CHẤT</h2>
            <div class="locations-grid">
                <?php 
                $count = 0;
                foreach ($all_cinemas as $cinema): 
                    $count++;
                ?>
                    <div class="location-card" data-aos="zoom-in" data-aos-delay="<?php echo ($count % 3) * 100; ?>">
                        <div class="location-image">
                            <img src="<?php echo esc_url($cinema['image']); ?>" alt="<?php echo esc_attr($cinema['title']); ?>" />
                            <div class="location-overlay">
                                <?php if (isset($cinema['link'])): ?>
                                    <a href="<?php echo esc_url($cinema['link']); ?>" class="location-link">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <h3 class="location-label"><?php echo esc_html($cinema['title']); ?></h3>
                    </div>
                <?php endforeach; ?>

                <!-- Additional Facilities -->
                <div class="location-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="location-image">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=600&h=400&fit=crop" alt="GYM/KIDZONE" />
                        <div class="location-overlay">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                    </div>
                    <h3 class="location-label">GYM/KIDZONE</h3>
                </div>

                <div class="location-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="location-image">
                        <img src="https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=600&h=400&fit=crop" alt="CINESTAR HIỆP PHÚ" />
                        <div class="location-overlay">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                    <h3 class="location-label">CINESTAR HIỆP PHÚ</h3>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-overview-section">
            <h2 class="services-overview-title">DỊCH VỤ ĐA DẠNG</h2>
            <div class="services-overview-grid">
                <div class="service-overview-item">
                    <div class="service-icon">
                        <i class="fas fa-film"></i>
                    </div>
                    <h3>Rạp Chiếu Phim</h3>
                    <p>Hệ thống rạp chiếu phim hiện đại với công nghệ 2D, 3D và C'MÊ</p>
                </div>
                <div class="service-overview-item">
                    <div class="service-icon">
                        <i class="fas fa-theater-masks"></i>
                    </div>
                    <h3>Nhà Hát Opera</h3>
                    <p>Không gian biểu diễn nghệ thuật chuyên nghiệp</p>
                </div>
                <div class="service-overview-item">
                    <div class="service-icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h3>Kidzone</h3>
                    <p>Khu vui chơi an toàn và thú vị cho trẻ em</p>
                </div>
                <div class="service-overview-item">
                    <div class="service-icon">
                        <i class="fas fa-bowling-ball"></i>
                    </div>
                    <h3>Bowling</h3>
                    <p>Sân bowling chuyên nghiệp cho giải trí và team building</p>
                </div>
                <div class="service-overview-item">
                    <div class="service-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3>Nhà Hàng</h3>
                    <p>Không gian ẩm thực đa dạng và sang trọng</p>
                </div>
                <div class="service-overview-item">
                    <div class="service-icon">
                        <i class="fas fa-dice"></i>
                    </div>
                    <h3>Billiards & Games</h3>
                    <p>Khu vực giải trí với billiards và các trò chơi khác</p>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();
?>

