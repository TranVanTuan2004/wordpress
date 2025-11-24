<?php
/**
 * Template Name: Trang Khuyến Mãi
 * Template for Promotions Page
 * 
 * @package Movie
 * @since 1.0
 */

get_header();
?>

<main class="promotions-page-wrapper">
    <div class="promotions-container">
        <!-- Header Section -->
        <div class="promotions-header">
            <h1 class="promotions-title">KHUYẾN MÃI</h1>
            <p class="promotions-subtitle">Ưu đãi hấp dẫn dành cho bạn</p>
        </div>

        <!-- C'SCHOOL Promotion Section -->
        <section class="promotion-section cschool-section" data-aos="fade-up">
            <div class="promotion-content">
                <div class="promotion-text">
                    <h2 class="promotion-title">
                        C'SCHOOL | ƯU ĐÃI GIÁ VÉ TỪ 45K DÀNH RIÊNG CHO HSSV/U22/GIÁO VIÊN
                    </h2>
                    
                    <div class="promotion-prices">
                        <h3><i class="fas fa-ticket-alt"></i> Giá vé ưu đãi:</h3>
                        <ul class="price-list">
                            <li>
                                <span class="price-type"><strong>2D:</strong></span>
                                <span class="price-value">45.000₫ / 49.000₫ / 55.000₫</span>
                            </li>
                            <li>
                                <span class="price-type"><strong>3D:</strong></span>
                                <span class="price-value">95.000₫ / 99.000₫</span>
                            </li>
                            <li>
                                <span class="price-type"><strong>C'MÊ (Ghế nằm):</strong></span>
                                <span class="price-value">95.000₫ / 99.000₫</span>
                            </li>
                        </ul>
                    </div>

                    <div class="promotion-conditions">
                        <h3><i class="fas fa-calendar-check"></i> Điều kiện áp dụng:</h3>
                        <ul class="conditions-list">
                            <li>
                                <span class="condition-label"><strong>Thời gian:</strong></span>
                                <span class="condition-value">Thứ 2 đến Thứ 6</span>
                            </li>
                            <li>
                                <span class="condition-label"><strong>Suất chiếu:</strong></span>
                                <span class="condition-value">Trước 10:00, sau 22:00 hoặc tất cả các suất còn lại</span>
                            </li>
                            <li>
                                <span class="condition-label"><strong>Rạp áp dụng:</strong></span>
                                <span class="condition-value">Cinestar Quốc Thanh, Cinestar Hai Bà Trưng, Cinestar Satra Quận 6</span>
                            </li>
                        </ul>
                    </div>

                    <div class="promotion-notes">
                        <h3><i class="fas fa-info-circle"></i> Lưu ý:</h3>
                        <ul class="notes-list">
                            <li><i class="fas fa-user-graduate"></i> Học sinh: Mặc đồng phục hoặc có thẻ học sinh</li>
                            <li><i class="fas fa-graduation-cap"></i> Sinh viên: Có thẻ sinh viên</li>
                            <li><i class="fas fa-id-card"></i> U22: Dưới 22 tuổi, có CMND/CCCD</li>
                            <li><i class="fas fa-chalkboard-teacher"></i> Giáo viên: Có giấy chứng nhận hoặc thẻ giáo viên</li>
                            <li><i class="fas fa-exclamation-triangle"></i> Mỗi thẻ/CMND chỉ được mua 1 vé</li>
                            <li><i class="fas fa-mobile-alt"></i> Có thể đặt vé online qua app/web Cinestar</li>
                            <li><i class="fas fa-ban"></i> Không áp dụng vào các ngày lễ, Tết</li>
                        </ul>
                    </div>

                    <div class="promotion-actions">
                        <a href="<?php echo esc_url(home_url('/datve')); ?>" class="btn-book-now">
                            <i class="fas fa-shopping-cart"></i> ĐẶT VÉ NGAY
                        </a>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-view-more">
                            <i class="fas fa-arrow-left"></i> Về trang chủ
                        </a>
                    </div>
                </div>

                <div class="promotion-banner cschool-banner">
                    <div class="banner-content">
                        <div class="banner-badge">HOT</div>
                        <h2 class="banner-title">C'SCHOOL</h2>
                        <p class="banner-subtitle">HỌC SINH - SINH VIÊN - GIÁO VIÊN</p>
                        <div class="banner-price-highlight">
                            <span class="price-from">CHỈ TỪ</span>
                            <span class="price-amount">45K</span>
                        </div>
                        <div class="banner-characters">
                            <div class="character character-backpack">
                                <div class="character-cap">🎓</div>
                                <div class="character-sign">VÉ XEM PHIM<br>HSSV 45K</div>
                            </div>
                            <div class="character character-bag">
                                <div class="character-item">🎒</div>
                            </div>
                        </div>
                        <p class="banner-footer-text">
                            ƯU ĐÃI GIÁ VÉ CHỈ TỪ 45K DÀNH CHO HỌC SINH SINH VIÊN, U22 VÀ GIÁO VIÊN CẢ TUẦN
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- HAPPY HOUR Promotion Section -->
        <section class="promotion-section happy-hour-section" data-aos="fade-up">
            <div class="promotion-content reverse">
                <div class="promotion-banner happy-hour-banner">
                    <div class="banner-content">
                        <div class="banner-badge">NEW</div>
                        <h2 class="banner-title">HAPPY HOUR</h2>
                        <div class="banner-price-highlight">
                            <span class="price-from">CHỈ TỪ</span>
                            <span class="price-amount">45K</span>
                        </div>
                        <div class="banner-characters">
                            <div class="character character-seated character-left">
                                <div class="character-face">😊</div>
                                <div class="character-sign">45.000₫</div>
                                <div class="character-item popcorn">🍿</div>
                            </div>
                            <div class="character character-seated character-right">
                                <div class="character-face">😊</div>
                                <div class="character-sign">49.000₫</div>
                                <div class="character-item drink">🥤</div>
                            </div>
                        </div>
                        <div class="banner-time-box">
                            <div class="time-item time-evening">
                                <i class="fas fa-moon"></i>
                                <span>SAU 22:00</span>
                            </div>
                            <div class="time-item time-morning">
                                <i class="fas fa-sun"></i>
                                <span>TRƯỚC 10:00</span>
                            </div>
                        </div>
                        <p class="banner-footer-text">
                            ƯU ĐÃI GIÁ VÉ CHO SUẤT CHIẾU TRƯỚC 10H00 VÀ 49K CHO SUẤT CHIẾU SAU 22H00
                        </p>
                    </div>
                </div>

                <div class="promotion-text">
                    <h2 class="promotion-title">
                        HAPPY HOUR | TRƯỚC 10H VÀ SAU 22H - GIÁ VÉ ƯU ĐÃI CHỈ TỪ 45K
                    </h2>
                    
                    <div class="promotion-prices">
                        <h3><i class="fas fa-ticket-alt"></i> Giá vé ưu đãi:</h3>
                        <ul class="price-list">
                            <li>
                                <span class="price-type"><strong>2D:</strong></span>
                                <span class="price-value">45.000₫ / 49.000₫ / 55.000₫</span>
                            </li>
                            <li>
                                <span class="price-type"><strong>3D:</strong></span>
                                <span class="price-value">95.000₫ / 99.000₫</span>
                            </li>
                            <li>
                                <span class="price-type"><strong>C'MÊ (Ghế nằm):</strong></span>
                                <span class="price-value">95.000₫ / 99.000₫</span>
                            </li>
                        </ul>
                    </div>

                    <div class="promotion-conditions">
                        <h3><i class="fas fa-calendar-check"></i> Điều kiện áp dụng:</h3>
                        <ul class="conditions-list">
                            <li>
                                <span class="condition-label"><strong>Thời gian:</strong></span>
                                <span class="condition-value">Thứ 3, Thứ 4, Thứ 5, Thứ 6</span>
                            </li>
                            <li>
                                <span class="condition-label"><strong>Suất chiếu:</strong></span>
                                <span class="condition-value">Trước 10:00 và sau 22:00</span>
                            </li>
                            <li>
                                <span class="condition-label"><strong>Rạp áp dụng:</strong></span>
                                <span class="condition-value">Cinestar Quốc Thanh, Cinestar Hai Bà Trưng, Cinestar Satra Quận 6</span>
                            </li>
                        </ul>
                    </div>

                    <div class="promotion-notes">
                        <h3><i class="fas fa-info-circle"></i> Lưu ý:</h3>
                        <ul class="notes-list">
                            <li><i class="fas fa-store"></i> Có thể mua vé trực tiếp tại rạp</li>
                            <li><i class="fas fa-globe"></i> Đặt vé online qua app/web Cinestar hoặc các kênh online khác</li>
                            <li><i class="fas fa-ban"></i> Không áp dụng vào các ngày lễ, Tết</li>
                        </ul>
                    </div>

                    <div class="promotion-actions">
                        <a href="<?php echo esc_url(home_url('/datve')); ?>" class="btn-book-now">
                            <i class="fas fa-shopping-cart"></i> ĐẶT VÉ NGAY
                        </a>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-view-more">
                            <i class="fas fa-arrow-left"></i> Về trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- HAPPY DAY Promotion Section -->
        <section class="promotion-section happy-day-section" data-aos="fade-up">
            <div class="promotion-content">
                <div class="promotion-text">
                    <h2 class="promotion-title">
                        HAPPY DAY | THỨ 2 - ĐỒNG GIÁ 45K CHO MỌI SUẤT
                    </h2>
                    
                    <div class="promotion-prices">
                        <h3><i class="fas fa-ticket-alt"></i> Giá vé ưu đãi:</h3>
                        <ul class="price-list">
                            <li>
                                <span class="price-type"><strong>2D:</strong></span>
                                <span class="price-value">45.000₫</span>
                            </li>
                            <li>
                                <span class="price-type"><strong>3D:</strong></span>
                                <span class="price-value">95.000₫</span>
                            </li>
                            <li>
                                <span class="price-type"><strong>C'MÊ (Ghế nằm):</strong></span>
                                <span class="price-value">95.000₫</span>
                            </li>
                        </ul>
                    </div>

                    <div class="promotion-conditions">
                        <h3><i class="fas fa-calendar-check"></i> Điều kiện áp dụng:</h3>
                        <ul class="conditions-list">
                            <li>
                                <span class="condition-label"><strong>Thời gian:</strong></span>
                                <span class="condition-value">Thứ 2 hàng tuần</span>
                            </li>
                            <li>
                                <span class="condition-label"><strong>Suất chiếu:</strong></span>
                                <span class="condition-value">Tất cả các suất trong ngày</span>
                            </li>
                            <li>
                                <span class="condition-label"><strong>Rạp áp dụng:</strong></span>
                                <span class="condition-value">Tất cả các rạp Cinestar</span>
                            </li>
                        </ul>
                    </div>

                    <div class="promotion-notes">
                        <h3><i class="fas fa-info-circle"></i> Lưu ý:</h3>
                        <ul class="notes-list">
                            <li><i class="fas fa-users"></i> Áp dụng cho tất cả khách hàng</li>
                            <li><i class="fas fa-store"></i> Có thể mua vé trực tiếp tại rạp hoặc đặt online</li>
                            <li><i class="fas fa-ban"></i> Không áp dụng vào các ngày lễ, Tết</li>
                            <li><i class="fas fa-clock"></i> Số lượng vé có hạn, đặt sớm để đảm bảo chỗ ngồi</li>
                        </ul>
                    </div>

                    <div class="promotion-actions">
                        <a href="<?php echo esc_url(home_url('/datve')); ?>" class="btn-book-now">
                            <i class="fas fa-shopping-cart"></i> ĐẶT VÉ NGAY
                        </a>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-view-more">
                            <i class="fas fa-arrow-left"></i> Về trang chủ
                        </a>
                    </div>
                </div>

                <div class="promotion-banner happy-day-banner">
                    <div class="banner-content">
                        <div class="banner-badge">POPULAR</div>
                        <h2 class="banner-title">HAPPY DAY</h2>
                        <p class="banner-subtitle">THỨ 2 HÀNG TUẦN</p>
                        <div class="banner-price-highlight">
                            <span class="price-from">ĐỒNG GIÁ</span>
                            <span class="price-amount">45K</span>
                        </div>
                        <div class="banner-characters">
                            <div class="character character-celebration">
                                <div class="character-face">🎉</div>
                                <div class="character-sign">TẤT CẢ<br>SUẤT CHIẾU</div>
                            </div>
                            <div class="character character-party">
                                <div class="character-item">🎊</div>
                            </div>
                        </div>
                        <p class="banner-footer-text">
                            ƯU ĐÃI ĐỒNG GIÁ 45K CHO TẤT CẢ CÁC SUẤT CHIẾU VÀO THỨ 2 HÀNG TUẦN
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Additional Info Section -->
        <section class="promotions-info-section">
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Hỗ trợ 24/7</h3>
                    <p>Đội ngũ chăm sóc khách hàng luôn sẵn sàng hỗ trợ bạn</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Đảm bảo chất lượng</h3>
                    <p>Cam kết mang đến trải nghiệm xem phim tuyệt vời nhất</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <h3>Ưu đãi độc quyền</h3>
                    <p>Nhiều chương trình khuyến mãi hấp dẫn mỗi tuần</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Đặt vé dễ dàng</h3>
                    <p>Đặt vé online nhanh chóng qua app hoặc website</p>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
get_footer();
?>
