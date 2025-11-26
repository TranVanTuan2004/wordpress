<?php
get_header();
?>

<main class="cinema-page">
  <?php if ( have_posts() ) : the_post(); ?>
  <section class="c-hero">
    <div class="c-container">
      <div class="c-hero__top">
        <a class="c-breadcrumb" href="#">Rạp phim</a>
        <span class="c-breadcrumb-sep">/</span>
        <span class="c-breadcrumb-current"><?php the_title(); ?></span>
      </div>
      <h1 class="c-title"><?php the_title(); ?></h1>
      <div class="c-hero__actions">
        <?php
          $cinema_id = get_the_ID();
          $cinema_title = get_the_title();

          // Find all cinema IDs with the same title to handle duplicates
          $all_cinema_ids = array($cinema_id);
          $dup_query = new WP_Query(array(
              'post_type' => array('mbs_cinema', 'rap_phim', 'rap-phim', 'cinema'),
              'title'     => $cinema_title,
              'posts_per_page' => -1,
              'fields'    => 'ids',
              'post__not_in' => array($cinema_id),
              'post_status' => 'any'
          ));
          if ($dup_query->have_posts()) {
              $all_cinema_ids = array_merge($all_cinema_ids, $dup_query->posts);
          }

          $datve_page = get_page_by_path('datve');
          $datve_link = $datve_page ? get_permalink($datve_page) : home_url('/datve/');
          $datve_link = add_query_arg('cinema', $cinema_id, $datve_link);
        ?>
        <a class="c-btn c-btn--primary" href="<?php echo esc_url($datve_link); ?>">Xem phim tại rạp này</a>
      </div>
    </div>
  </section>

  <section class="c-content">
    <div class="c-container">
      <?php
        // 1. Get ALL "Now Showing" movies
        $movie_args = array(
          'post_type'      => 'mbs_movie',
          'posts_per_page' => -1,
          'orderby'        => 'title',
          'order'          => 'ASC',
          'meta_query'     => array(
            array(
              'key'     => '_movie_status',
              'value'   => 'dang-chieu',
              'compare' => '='
            )
          )
        );
        $movies_in_cinema = new WP_Query( $movie_args );

        // 2. Prepare showtimes (Real + Default)
        $showtimes_by_movie = array();
        
        // Fetch real showtimes first
        global $wpdb;
        $st_table = $wpdb->prefix . 'mbs_showtimes';
        $table_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $st_table));

        if ( $table_exists === $st_table ) {
            $placeholders = implode(',', array_fill(0, count($all_cinema_ids), '%d'));
            $sql = "SELECT movie_id, show_date, show_time FROM $st_table WHERE cinema_id IN ($placeholders) ORDER BY show_date, show_time";
            $rows = $wpdb->get_results($wpdb->prepare($sql, $all_cinema_ids));
            if ( $rows ) {
                foreach ( $rows as $r ) {
                    $mid = intval($r->movie_id);
                    $date = esc_html($r->show_date);
                    $time = esc_html($r->show_time);
                    $showtimes_by_movie[$mid][$date][] = $time;
                }
            }
        }
        
        // Also check CPT showtimes
        $args_st = array(
            'post_type'      => 'mbs_showtime',
            'posts_per_page' => -1,
            'meta_query'     => array(
              array(
                'key'     => '_mbs_cinema_id',
                'value'   => $all_cinema_ids,
                'compare' => 'IN',
              ),
            ),
        );
        $st = new WP_Query( $args_st );
        if ( $st->have_posts() ) {
            while ( $st->have_posts() ) {
                $st->the_post();
                $mid  = get_post_meta( get_the_ID(), '_mbs_movie_id', true );
                $time_str = get_post_meta( get_the_ID(), '_mbs_showtime', true ); 
                if ( $mid && $time_str ) {
                    $ts = strtotime($time_str);
                    if ($ts) {
                        $date = date('Y-m-d', $ts);
                        $time = date('H:i', $ts);
                        if (!isset($showtimes_by_movie[$mid][$date]) || !in_array($time, $showtimes_by_movie[$mid][$date])) {
                            $showtimes_by_movie[$mid][$date][] = $time;
                        }
                    }
                }
            }
            wp_reset_postdata();
        }

        // 3. Generate Default Showtimes for movies without real ones
        $default_times = array('09:00', '11:30', '14:00', '16:30', '19:00', '21:30');
        $default_dates = array(
            date('Y-m-d'), // Today
            date('Y-m-d', strtotime('+1 day')), // Tomorrow
            date('Y-m-d', strtotime('+2 days')) // Day after tomorrow
        );

        // We iterate through the query results later, but we can prepare the array now
        // Actually, we can just check inside the loop below.
      ?>

      <h2 class="c-section-title">Phim đang chiếu tại rạp</h2>

      <div class="c-grid">
        <?php if ( $movies_in_cinema->have_posts() ) : while ( $movies_in_cinema->have_posts() ) : $movies_in_cinema->the_post();
          $poster_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
          if ( ! $poster_url ) $poster_url = 'https://via.placeholder.com/320x430/111827/FFFFFF?text=' . urlencode( get_the_title() );
        ?>
          <article class="c-movie">
            <a class="c-movie__poster" href="<?php the_permalink(); ?>">
              <img src="<?php echo esc_url( $poster_url ); ?>" alt="<?php the_title_attribute(); ?>">
              <span class="c-movie__overlay"></span>
            </a>
            <div class="c-movie__body">
              <h3 class="c-movie__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <?php
                $meta_bits = array();
                $genres = wp_get_post_terms( get_the_ID(), 'mbs_genre' );
                if ( ! is_wp_error($genres) && ! empty($genres) ) {
                  $meta_bits[] = implode(', ', wp_list_pluck($genres, 'name'));
                }
                $duration = get_post_meta( get_the_ID(), '_mbs_duration', true );
                if ( ! empty($duration) ) {
                  $meta_bits[] = $duration;
                }
                $age_rating = get_post_meta( get_the_ID(), '_mbs_rating', true );
                if ( ! empty($age_rating) ) $meta_bits[] = $age_rating;
              ?>
              <?php if ( ! empty($meta_bits) ) : ?>
                <div class="c-movie__meta"><?php echo esc_html( implode(' • ', $meta_bits) ); ?></div>
              <?php endif; ?>
              
              <?php
                // Render giờ chiếu
                $by_date = isset($showtimes_by_movie[get_the_ID()]) ? $showtimes_by_movie[get_the_ID()] : array();
                
                // If no real showtimes, use defaults
                if (empty($by_date)) {
                    foreach ($default_dates as $d) {
                        $by_date[$d] = $default_times;
                    }
                }

                if (! empty($by_date)){
                  echo '<div class="c-movie__times">';
                  ksort($by_date);
                  
                  // Limit to next 3 days
                  $shown_dates = 0;
                  foreach ($by_date as $date => $times){
                    if ($shown_dates >= 3) break;
                    $shown_dates++;
                    
                    // echo '<div style="width:100%;font-size:12px;color:#94a3b8;margin-top:4px">'.date('d/m', strtotime($date)).':</div>';
                    sort($times);
                    foreach ($times as $t){
                      $book_page = get_page_by_path('datve');
                      $book_link = ($book_page ? get_permalink($book_page) : home_url('/datve/'));
                      $book_link = add_query_arg(array(
                        'cinema' => $cinema_id,
                        'movie'  => get_the_ID(),
                        'date'   => $date,
                        'time'   => $t
                      ), $book_link);
                      echo '<a class="c-chip" href="'. esc_url($book_link) .'">'. esc_html($t) .'</a>';
                    }
                  }
                  echo '</div>';
                } else {
                  // Should not happen with defaults, but fallback just in case
                  $book_page = get_page_by_path('datve');
                  $book_link = ($book_page ? get_permalink($book_page) : home_url('/datve/'));
                  $book_link = add_query_arg(array(
                    'cinema' => $cinema_id,
                    'movie'  => get_the_ID()
                  ), $book_link);
                  echo '<a class="c-btn c-btn--ghost" href="'. esc_url($book_link) .'">Đặt vé</a>';
                }
              ?>
            </div>
          </article>
        <?php endwhile; wp_reset_postdata(); else: ?>
          <div class="c-empty">Chưa có phim liên kết với rạp này.</div>
        <?php endif; ?>
      </div>

      <!-- PROMOTIONS SECTION -->
      <h2 class="c-section-title" style="margin-top:48px">Khuyến mãi</h2>
      <div class="c-promotions">
        <!-- C'SCHOOL Promotion -->
        <div class="c-promo-card">
            <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=800&q=80" alt="C'SCHOOL">
            <div class="c-promo-overlay">
                <h3>C'SCHOOL - Vé từ 45K</h3>
                <p style="font-size:13px;margin:4px 0;color:#e5e7eb">Dành cho HSSV/U22/Giáo viên</p>
                <a href="<?php echo home_url('/khuyenmai'); ?>" class="c-promo-link">Xem chi tiết →</a>
            </div>
        </div>
        
        <!-- HAPPY HOUR Promotion -->
        <div class="c-promo-card">
            <img src="https://images.unsplash.com/photo-1485846234645-a62644f84728?w=800&q=80" alt="Happy Hour">
            <div class="c-promo-overlay">
                <h3>Happy Hour - Vé từ 45K</h3>
                <p style="font-size:13px;margin:4px 0;color:#e5e7eb">Trước 10h & sau 22h</p>
                <a href="<?php echo home_url('/khuyenmai'); ?>" class="c-promo-link">Xem chi tiết →</a>
            </div>
        </div>
        
        <!-- HAPPY DAY Promotion -->
        <div class="c-promo-card">
            <img src="https://images.unsplash.com/photo-1513106580091-1d82408b8638?w=800&q=80" alt="Happy Day">
            <div class="c-promo-overlay">
                <h3>Happy Day - Đồng giá 45K</h3>
                <p style="font-size:13px;margin:4px 0;color:#e5e7eb">Thứ 2 hàng tuần</p>
                <a href="<?php echo home_url('/khuyenmai'); ?>" class="c-promo-link">Xem chi tiết →</a>
            </div>
        </div>
      </div>

      <!-- MAP SECTION -->
      <h2 class="c-section-title" style="margin-top:48px">Vị trí</h2>
      <div class="c-map-container">
        <?php
        // Hardcoded cinema addresses and coordinates
        $cinema_data = array(
            'RIOT Cinema Huế' => array(
                'address' => '95 Hai Bà Trưng, Phường Thuận Hòa, TP Huế',
                'lat' => '16.4637',
                'lng' => '107.5909'
            ),
            'RIOT Cinema Đà Nẵng' => array(
                'address' => '123 Trần Phú, Quận Hải Châu, TP Đà Nẵng',
                'lat' => '16.0544',
                'lng' => '108.2022'
            ),
            'RIOT Cinema Nha Trang' => array(
                'address' => '456 Trần Phú, TP Nha Trang, Khánh Hòa',
                'lat' => '12.2388',
                'lng' => '109.1967'
            ),
            'RIOT Cinema Cần Thơ' => array(
                'address' => '789 Mậu Thân, Quận Ninh Kiều, TP Cần Thơ',
                'lat' => '10.0452',
                'lng' => '105.7469'
            ),
            'RIOT Cinema Vũng Tàu' => array(
                'address' => '321 Trương Công Định, TP Vũng Tàu, Bà Rịa - Vũng Tàu',
                'lat' => '10.3460',
                'lng' => '107.0843'
            ),
            'RIOT Cinema Sài Gòn' => array(
                'address' => '234 Nguyễn Trãi, Quận 1, TP Hồ Chí Minh',
                'lat' => '10.7769',
                'lng' => '106.7009'
            ),
            'RIOT Cinema Hải Phòng' => array(
                'address' => '567 Lạch Tray, Quận Ngô Quyền, TP Hải Phòng',
                'lat' => '20.8449',
                'lng' => '106.6881'
            ),
            'RIOT Cinema Quốc Thanh' => array(
                'address' => '112 Nguyễn Văn Cừ, Quận 1, TP Hồ Chí Minh',
                'lat' => '10.7626',
                'lng' => '106.6834'
            )
        );
        
        // Get current cinema title
        $current_title = get_the_title();
        
        // Find matching cinema data
        $cinema_info = null;
        foreach ($cinema_data as $name => $data) {
            if (strpos($current_title, $name) !== false || strpos($name, $current_title) !== false) {
                $cinema_info = $data;
                break;
            }
        }
        
        // Default fallback
        if (!$cinema_info) {
            $cinema_info = array(
                'address' => $current_title . ', Việt Nam',
                'lat' => '16.0544',
                'lng' => '108.2022'
            );
        }
        
        $address = $cinema_info['address'];
        $lat = $cinema_info['lat'];
        $lng = $cinema_info['lng'];
        ?>
        <div class="c-address-info">
          <i class="fas fa-map-marker-alt"></i>
          <span><?php echo esc_html($address); ?></span>
        </div>
        <div class="c-map-embed">
          <iframe 
            width="100%" 
            height="400" 
            frameborder="0" 
            style="border:0;border-radius:12px" 
            src="https://maps.google.com/maps?q=<?php echo $lat; ?>,<?php echo $lng; ?>&hl=vi&z=15&output=embed"
            allowfullscreen>
          </iframe>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <style>
    :root{
      --c-bg:#0b1221;
      --c-card:#0f1b31;
      --c-text:#e5e7eb;
      --c-soft:#94a3b8;
      --c-primary:#ffe44d;
      --c-accent:#4f46e5;
    }
    .c-container{max-width:1200px;margin:0 auto;padding:0 16px}
    .c-hero{
      background: radial-gradient(80% 120% at 0% 0%, rgba(99,102,241,.22), transparent 60%),
                  radial-gradient(90% 120% at 100% 0%, rgba(236,72,153,.18), transparent 55%),
                  rgba(15,23,42,.85);
      border-bottom: 1px solid rgba(148,163,184,.15);
      color:#fff;
      padding:28px 0 26px;
    }
    .c-hero__top{display:flex;align-items:center;gap:8px;color:rgba(255,255,255,.75);font-size:14px}
    .c-breadcrumb{color:rgba(255,255,255,.8);text-decoration:none}
    .c-breadcrumb:hover{text-decoration:underline}
    .c-breadcrumb-sep{opacity:.6}
    .c-breadcrumb-current{opacity:1}
    .c-title{margin:8px 0 12px;font-size:30px;font-weight:800;letter-spacing:.02em}
    .c-hero__actions{display:flex;gap:10px}
    .c-btn{display:inline-flex;align-items:center;justify-content:center;border-radius:12px;padding:10px 14px;font-weight:800;text-decoration:none;border:1px solid rgba(148,163,184,.3);color:#fff}
    .c-btn--primary{background:var(--c-primary);border-color:var(--c-primary);color:#0e1220;box-shadow:0 10px 24px rgba(255,228,77,.3)}
    .c-btn--ghost:hover{border-color:var(--c-primary);color:var(--c-primary)}

    .c-content{color:var(--c-text);padding:24px 0 48px}
    .c-card{background:rgba(15,23,42,.9);border:1px solid rgba(148,163,184,.14);border-radius:14px;overflow:hidden}
    .c-card__body{padding:16px}
    .c-mb{margin-bottom:16px}

    .c-section-title{margin:8px 0 16px;font-size:22px;font-weight:800;color:#fff}

    .c-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
    .c-movie{background:rgba(15,23,42,.95);border:1px solid rgba(148,163,184,.14);border-radius:14px;overflow:hidden;display:flex;flex-direction:column}
    .c-movie__poster{display:block;position:relative;aspect-ratio:3/4;background:#111827}
    .c-movie__poster img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .45s ease}
    .c-movie__overlay{position:absolute;inset:0;background:linear-gradient(180deg, transparent 60%, rgba(0,0,0,.65));opacity:0;transition:.35s}
    .c-movie__poster:hover img{transform:scale(1.04)}
    .c-movie__poster:hover .c-movie__overlay{opacity:1}
    .c-movie__body{padding:14px;display:flex;flex-direction:column;gap:10px}
    .c-movie__title{margin:0;font-size:16px;font-weight:800;color:#fff}
    .c-movie__title a{color:inherit;text-decoration:none}
    .c-movie__title a:hover{color:var(--c-primary)}
    .c-movie__meta{color:var(--c-soft);font-size:13px}
    .c-movie__desc{color:rgba(229,231,235,.88);font-size:13px}
    .c-movie__times{display:flex;flex-wrap:wrap;gap:8px}
    .c-chip{display:inline-flex;min-width:54px;align-items:center;justify-content:center;height:32px;padding:0 10px;border-radius:10px;background:rgba(15,23,42,.85);border:1px solid rgba(148,163,184,.28);font-weight:700;color:#e5e7eb;text-decoration:none}
    .c-chip:hover{border-color:var(--c-primary);color:var(--c-primary)}
    .c-empty{padding:18px;border:1px dashed rgba(148,163,184,.35);border-radius:12px;background:rgba(15,23,42,.55)}

    /* Promotions Section */
    .c-promotions{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:40px}
    .c-promo-card{position:relative;border-radius:14px;overflow:hidden;cursor:pointer;transition:transform .3s ease}
    .c-promo-card:hover{transform:translateY(-4px)}
    .c-promo-card img{width:100%;height:200px;object-fit:cover;display:block}
    .c-promo-overlay{position:absolute;bottom:0;left:0;right:0;background:linear-gradient(180deg,transparent,rgba(0,0,0,.85));padding:20px;color:#fff}
    .c-promo-overlay h3{margin:0 0 8px;font-size:16px;font-weight:700}
    .c-promo-link{color:var(--c-primary);text-decoration:none;font-weight:600;font-size:14px}
    .c-promo-link:hover{text-decoration:underline}

    /* Map Section */
    .c-map-container{margin-bottom:40px}
    .c-address-info{display:flex;align-items:center;gap:10px;padding:16px;background:rgba(15,23,42,.6);border-radius:12px;margin-bottom:16px;color:#e5e7eb}
    .c-address-info i{color:var(--c-primary);font-size:18px}
    .c-map-embed{border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,.3)}

    @media (max-width: 1024px){ 
      .c-grid{grid-template-columns:repeat(2,1fr)} 
      .c-promotions{grid-template-columns:repeat(2,1fr)}
    }
    @media (max-width: 560px){ 
      .c-grid{grid-template-columns:1fr} 
      .c-title{font-size:26px} 
      .c-promotions{grid-template-columns:1fr}
    }
  </style>
</main>

<?php
get_footer();
?>
