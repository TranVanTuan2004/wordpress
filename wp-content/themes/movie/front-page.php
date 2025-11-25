<?php get_header(); ?>
      <!-- slider -->
      <div class="slider">
        <div class="slides">
          <a href="#" class="active">
            <img
              src="https://api-website.cinestar.com.vn/media/MageINIC/bannerslider/chaching2.jpg"
              class="slide"
            />
            <button class="book-ticker" onclick="document.querySelector('.booking').scrollIntoView({behavior: 'smooth'})">
              ĐẶT VÉ NGAY
            </button>
          </a>
          <a href="#">
            <img
              src="https://api-website.cinestar.com.vn/media/MageINIC/bannerslider/hoarac.jpg"
              class="slide"
            />
            <button class="book-ticker" onclick="document.querySelector('.booking').scrollIntoView({behavior: 'smooth'})">
              ĐẶT VÉ NGAY
            </button>
          </a>
          <a href="#">
            <img
              src="https://api-website.cinestar.com.vn/media/MageINIC/bannerslider/banner-web.jpg"
              class="slide"
            />
            <button class="book-ticker" onclick="document.querySelector('.booking').scrollIntoView({behavior: 'smooth'})">
              ĐẶT VÉ NGAY
            </button>
          </a>
          <a href="#">
            <img
              src="https://api-website.cinestar.com.vn/media/MageINIC/bannerslider/1215wx365h.jpg"
              class="slide"
            />
            <button class="book-ticker" onclick="document.querySelector('.booking').scrollIntoView({behavior: 'smooth'})">
              ĐẶT VÉ NGAY
            </button>
          </a>
          <a href="#">
            <img
              src="https://api-website.cinestar.com.vn/media/MageINIC/bannerslider/2400wx720h_1_.jpg"
              class="slide"
            />
            <button class="book-ticker" onclick="document.querySelector('.booking').scrollIntoView({behavior: 'smooth'})">
              ĐẶT VÉ NGAY
            </button>
          </a>
        </div>
        <button class="prev">&#10094;</button>
        <button class="next">&#10095;</button>
      </div>

      <!-- booking -->
      <div class="booking">
        <h2 class="booking-title">ĐẶT VÉ NHANH</h2>
        <!-- from-group -->
        <div class="form-group">
          <select id="booking-cinema" class="form-select">
            <option value="">1. Chọn rạp</option>
            <?php
              // Query cinemas from database
              $cinema_pts = array('mbs_cinema','rap_phim','rap-phim','cinema','theater','rap','rapfilm','rap_phim_cpt');
              $cinema_pt = null;
              foreach($cinema_pts as $pt){ 
                if ( post_type_exists($pt) ){ 
                  $cinema_pt = $pt; 
                  break; 
                } 
              }
              
              if ($cinema_pt) {
                $cinemas = new WP_Query(array(
                  'post_type' => $cinema_pt,
                  'post_status' => 'publish',
                  'posts_per_page' => -1,
                  'orderby' => 'title',
                  'order' => 'ASC'
                ));
                
                if ($cinemas->have_posts()) {
                  while ($cinemas->have_posts()) {
                    $cinemas->the_post();
                    echo '<option value="' . esc_attr(get_the_ID()) . '">' . esc_html(get_the_title()) . '</option>';
                  }
                  wp_reset_postdata();
                }
              }
            ?>
          </select>
        </div>

        <div class="form-group">
          <select id="booking-movie" class="form-select" disabled>
            <option value="">2. Chọn phim</option>
          </select>
        </div>

        <div class="form-group">
          <select id="booking-date" class="form-select" disabled>
            <option value="">3. Chọn ngày</option>
          </select>
        </div>

        <div class="form-group">
          <select id="booking-showtime" class="form-select" disabled>
            <option value="">4. Chọn suất</option>
          </select>
        </div>

        <button class="btn-booking" id="btn-booking">ĐẶT NGAY</button>
      </div>

      <!-- movie is showing-->
      <div class="movie">
        <div class="movie-section">
          <h2 class="section-title">PHIM ĐANG CHIẾU</h2>
          <button class="nav-btn left" onclick="scrollMovies1(-1)">
            &#10094;
          </button>
          <div class="movie-carousel">
            <div class="movie-list" id="movieList1">
              <?php 
                // Query phim đang chiếu
                $args = array(
                  'post_type' => 'mbs_movie',
                  'posts_per_page' => 10,
                  'post_status' => 'publish',
                  'meta_query' => array(
                    array(
                      'key' => '_movie_status',
                      'value' => 'dang-chieu',
                      'compare' => '='
                    )
                  )
                );
                $query = new WP_Query($args);
                
                while($query->have_posts()){
                  $query->the_post();
                  $duration = get_post_meta(get_the_ID(), '_mbs_duration', true);
                  $language = get_post_meta(get_the_ID(), '_mbs_language', true);
                  $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
              ?>

              <a href="<?php echo get_permalink(); ?>" class="movie-link">
                <div class="movie-card">
                  <img
                     src="<?php echo $thumb_url ? $thumb_url : 'https://via.placeholder.com/300x450'; ?>"
                    alt="<?php the_title_attribute(); ?>"
                  />
                  <div class="movie-overlay">
                    <h3><?php the_title(); ?></h3>
                    <?php if ($duration): ?>
                      <p><i class="bx bx-time"></i> <?php echo esc_html($duration); ?></p>
                    <?php endif; ?>
                    <?php if ($language): ?>
                      <p><i class="bx bx-message-square-dots"></i> <?php echo esc_html($language); ?></p>
                    <?php endif; ?>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book"><span>Đặt vé</span></button>
                    </div>
                  </div>
                </div>
              </a>
                <?php
                }
                wp_reset_postdata(); 
              ?>
            </div>
          </div>
          <button class="nav-btn right" onclick="scrollMovies1(1)">
            &#10095;
          </button>

          <?php
            $page = get_page_by_path('phim-dang-chieu');
            $movie_archive_url = $page ? get_permalink($page) : home_url('/phim-dang-chieu/');
          ?>
          <button class="btn-viewmore" onclick="window.location.href='<?php echo esc_url($movie_archive_url); ?>'">Xem thêm</button>
        </div>
      </div>

      <!-- movie coming soon -->
      <div class="movie coming">
        <div class="movie-section">
          <h2 class="section-title">PHIM SẮP CHIẾU</h2>
          <button class="nav-btn left" onclick="scrollMovies2(-1)">
            &#10094;
          </button>
          <div class="movie-carousel">
            <div class="movie-list" id="movieList2">
              <?php 
                // Query phim sắp chiếu
                $args_coming = array(
                  'post_type' => 'mbs_movie',
                  'posts_per_page' => 10,
                  'post_status' => 'publish',
                  'meta_query' => array(
                    array(
                      'key' => '_movie_status',
                      'value' => 'sap-chieu',
                      'compare' => '='
                    )
                  )
                );
                $query_coming = new WP_Query($args_coming);
                
                while($query_coming->have_posts()){
                  $query_coming->the_post();
                  $duration = get_post_meta(get_the_ID(), '_mbs_duration', true);
                  $release_date = get_post_meta(get_the_ID(), '_mbs_release_date', true);
                  $language = get_post_meta(get_the_ID(), '_mbs_language', true);
                  $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
              ?>
              <a href="<?php echo get_permalink(); ?>" class="movie-link">
                <div class="movie-card">
                  <img
                    src="<?php echo $thumb_url ? $thumb_url : 'https://via.placeholder.com/300x450'; ?>"
                    alt="<?php the_title_attribute(); ?>"
                  />
                  <div class="movie-overlay">
                    <h3><?php the_title(); ?></h3>
                    <?php if ($release_date): ?>
                      <p><i class="bx bx-calendar"></i> Khởi chiếu: <?php echo esc_html($release_date); ?></p>
                    <?php endif; ?>
                    <?php if ($duration): ?>
                      <p><i class="bx bx-time"></i> <?php echo esc_html($duration); ?></p>
                    <?php endif; ?>
                    <?php if ($language): ?>
                      <p><i class="bx bx-message-square-dots"></i> <?php echo esc_html($language); ?></p>
                    <?php endif; ?>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book">
                        <span>Tìm hiểu thêm</span>
                      </button>
                    </div>
                  </div>
                </div>
              </a>
                <?php
                }
                wp_reset_postdata(); 
              ?>
            </div>
          </div>
          <button class="nav-btn right" onclick="scrollMovies2(1)">
            &#10095;
          </button>

          <?php
            $coming_soon_url = home_url('/phim-sap-chieu/');
          ?>
          <button class="btn-viewmore" onclick="window.location.href='<?php echo esc_url($coming_soon_url); ?>'">Xem thêm</button>
        </div>
      </div>

      <!-- promotion -->
      <div class="promotion">
        <h1>KHUYẾN MÃI</h1>
        <div class="promotion-slider">
          <button class="promotion-nav promotion-prev">&#10094;</button>
          <div class="promotion-slides">
            <div class="promotion-slide promotion-active">
              <a href="#">
                <img
                  src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2FMageINIC%2Fbannerslider%2FTHU4.jpg&w=1920&q=75"
                  alt="Happy Day"
                />
              </a>
            </div>
            <div class="promotion-slide">
              <a href="#">
                <img
                  src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2FMageINIC%2Fbannerslider%2FHSSV-2.jpg&w=1920&q=75"
                  alt="C'School"
                />
              </a>
            </div>
            <div class="promotion-slide">
              <a href="#">
                <img
                  src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2FMageINIC%2Fbannerslider%2FCTEN.jpg&w=1920&q=75"
                  alt="Happy Hour"
                />
              </a>
            </div>
            <div class="promotion-slide">
              <a href="#">
                <img
                  src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2FMageINIC%2Fbannerslider%2FMONDAY_1.jpg&w=1920&q=75"
                  alt="Monday Deal"
                />
              </a>
            </div>
          </div>
          <button class="promotion-nav promotion-next">&#10095;</button>
        </div>
        <?php
          $promotions_page = get_page_by_path('khuyenmai');
          $promotions_url = $promotions_page ? get_permalink($promotions_page) : home_url('/khuyenmai/');
        ?>
        <button class="btn-viewmore" onclick="window.location.href='<?php echo esc_url($promotions_url); ?>'">Tất cả khuyến mãi</button>
      </div>
    </div>

    <!-- membership -->
    <div class="membership">
      <div class="overlay">
        <h2>CHƯƠNG TRÌNH THÀNH VIÊN</h2>
        <div class="cards">
          <div class="card">
            <a href="#">
              <img
                src="https://api-website.cinestar.com.vn/media/wysiwyg/CMSPage/Member/Desktop519x282_CMember.webp"
                alt="C'Friend"
              />
            </a>
            <a href="#" class="name_member">THÀNH VIÊN C'FRIEND</a>
            <p>Thẻ C'Friend mang đến nhiều ưu đãi cho thành viên mới</p>
            <button class="btn-viewmore">Tìm hiểu ngay</button>
          </div>
          <div class="card">
            <a href="#">
              <img
                src="https://api-website.cinestar.com.vn/media/wysiwyg/CMSPage/Member/c-vip.webp"
                alt="C'VIP"
              />
            </a>
            <a class="name_member" href="#">THÀNH VIÊN C'VIP</a>
            <p>
              Thẻ VIP Cinestar dành riêng cho bạn những đặc quyền chất riêng.
            </p>
            <button class="btn-viewmore">Tìm hiểu ngay</button>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <!-- entertaiment -->
      <section class="entertainment">
        <h2>DỊCH VỤ GIẢI TRÍ KHÁC</h2>
        <p>
          Cinestar không chỉ chiếu phim – chúng tôi còn mang đến nhiều mô hình
          giải trí đặc sắc khác, giúp bạn tận hưởng từng giây phút bên ngoài màn
          ảnh rộng.
        </p>
        <div class="service-grid">
          <div class="service-card">
            <a href="#">
              <img
                src="https://cinestar.com.vn/assets/images/img-service0.webp"
                alt="Kidzone"
              />
            </a>
          </div>
          <div class="service-card">
            <a href="#">
              <img
                src="https://cinestar.com.vn/assets/images/img-service1.webp"
                alt="Bowling"
              />
            </a>
          </div>
          <div class="service-card">
            <a href="#">
              <img
                src="https://cinestar.com.vn/assets/images/img-service2.webp"
                alt="Billiards"
              />
            </a>
          </div>
          <div class="service-card">
            <a href="#">
              <img
                src="https://cinestar.com.vn/assets/images/img-service3.webp"
                alt="Món ngon"
              />
            </a>
          </div>
          <div class="service-card">
            <a href="#">
              <img
                src="https://cinestar.com.vn/assets/images/img-service4.webp"
                alt="Gym"
              />
            </a>
          </div>
          <div class="service-card">
            <a href="#">
              <img
                src="https://cinestar.com.vn/assets/images/img-service5.webp"
                alt="Dalat Opera House"
              />
            </a>
          </div>
        </div>
      </section>

    </div>
    
    <!-- contact -->
    <div class="contact">
      <div class="contact-left">
        <h2>LIÊN HỆ VỚI CHÚNG TÔI</h2>
        <a href="#" class="social-button facebook">
          <img src="https://cinestar.com.vn/assets/images/ct-1.webp" alt="" />
          FACEBOOK
        </a>
        <a href="#" class="social-button zalo">
          <img src="https://cinestar.com.vn/assets/images/ct-2.webp" alt="" />
          ZALO CHAT
        </a>
      </div>

      <div class="contact-right">
        <h2>THÔNG TIN LIÊN HỆ</h2>
        <p>
          📧 <a href="mailto:cskh@cinestar.com.vn">cskh@cinestar.com.vn</a>
        </p>
        <p>📞 <a href="tel:19000085">1900 0085</a></p>
        <p>📍 <a href="#">135 Hai Bà Trưng, phường Sài Gòn, TP.HCM</a></p>

        <?php echo do_shortcode('[contact-form-7 id="e1f3189" title="Liên hệ"]'); ?>
        
        <style>
          /* CF7 Styling for Home Page */
          .contact-right .wpcf7-form p {
            margin-bottom: 0;
          }
          .contact-right .wpcf7-form-control-wrap {
            display: block;
            margin-bottom: 15px;
          }
          .contact-right input[type="text"],
          .contact-right input[type="email"],
          .contact-right input[type="tel"],
          .contact-right textarea {
            width: 100%;
            padding: 12px 16px;
            background: #1e293b;
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            margin-bottom: 0;
            box-sizing: border-box;
          }
          .contact-right input:focus,
          .contact-right textarea:focus {
            outline: none;
            border-color: #ffe44d;
            background: #0f172a;
          }
          .contact-right textarea {
            min-height: 100px;
            resize: vertical;
          }
          .contact-right input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #ffe44d;
            color: #000;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: uppercase;
          }
          .contact-right input[type="submit"]:hover {
            background: #ffd700;
            transform: translateY(-2px);
          }
          .contact-right .wpcf7-not-valid-tip {
            font-size: 12px;
            margin-top: 4px;
          }
          .contact-right .wpcf7-response-output {
            font-size: 13px;
            padding: 10px;
            border-radius: 6px;
            margin: 10px 0 0;
          }
        </style>
      </div>
    </div>
<?php get_footer(); ?>
