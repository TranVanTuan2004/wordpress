<?php
get_header();
?>

<main class="cinema-page">
  <?php if ( have_posts() ) : the_post(); ?>
  <section class="c-hero">
    <div class="c-container">
      <div class="c-hero__top">
        <a class="c-breadcrumb" href="<?php echo esc_url( home_url('/rap-phim/') ); ?>">Rạp phim</a>
        <span class="c-breadcrumb-sep">/</span>
        <span class="c-breadcrumb-current"><?php the_title(); ?></span>
      </div>
      <h1 class="c-title"><?php the_title(); ?></h1>
      <div class="c-hero__actions">
        <?php
          $cinema_id = get_the_ID();
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
        // Lấy danh sách phim chiếu tại rạp này
        $movie_post_types = array('movie','mbs_movie');
        $movie_args = array(
          'post_type'      => $movie_post_types,
          'posts_per_page' => -1,
          'orderby'        => 'title',
          'order'          => 'ASC',
        );
        // Thử map bằng meta và/hoặc taxonomy
        $meta_keys = array('cinema_id','cinema','cinemas','rap_phim','rap','theater_id','theaters');
        $meta_or = array('relation' => 'OR');
        foreach ($meta_keys as $mk) {
          $meta_or[] = array(
            'key'     => $mk,
            'value'   => $cinema_id,
            'compare' => 'LIKE',
          );
        }
        $movie_args['meta_query'] = $meta_or;

        $maybe_tax = array('cinema','rap_phim','theater','rap');
        $tax_or = array('relation' => 'OR');
        foreach ($maybe_tax as $tx) {
          if ( taxonomy_exists($tx) ) {
            $tax_or[] = array(
              'taxonomy' => $tx,
              'field'    => 'name',
              'terms'    => array( get_the_title($cinema_id) ),
            );
          }
        }
        if ( count($tax_or) > 1 ) {
          $movie_args['tax_query'] = $tax_or;
        }

        $movies_in_cinema = new WP_Query( $movie_args );
        // Fallback: nếu chưa có liên kết, hiển thị danh sách gần đây để không bị rỗng
        if ( ! $movies_in_cinema->have_posts() ) {
          $movie_args_fallback = array(
            'post_type'      => $movie_post_types,
            'posts_per_page' => 8,
            'orderby'        => 'date',
            'order'          => 'DESC',
          );
          $movies_in_cinema = new WP_Query( $movie_args_fallback );
        }

        // Lấy toàn bộ suất chiếu thuộc rạp hiện tại (từ CPT mbs_showtime)
        $showtimes_by_movie = array();
        if ( post_type_exists('mbs_showtime') ) {
          $st = new WP_Query(array(
            'post_type'      => 'mbs_showtime',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'meta_query'     => array(
              array('key'=>'_mbs_cinema_id','value'=>$cinema_id,'compare'=>'=')
            )
          ));
          if ($st->have_posts()){
            while($st->have_posts()){ $st->the_post();
              $movie_id_ref = intval(get_post_meta(get_the_ID(),'_mbs_movie_id',true));
              $dt           = sanitize_text_field(get_post_meta(get_the_ID(),'_mbs_showtime',true));
              $ts = strtotime($dt);
              if ($movie_id_ref && $ts){
                $date = date('Y-m-d',$ts);
                $time = date('H:i',$ts);
                $showtimes_by_movie[$movie_id_ref][$date][] = $time;
              }
            }
            wp_reset_postdata();
          }
        }
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
                // Thông tin phim ngắn gọn
                $meta_bits = array();
                // Thể loại (taxonomy)
                $genres = wp_get_post_terms( get_the_ID(), 'movie_genre' );
                if ( ! is_wp_error($genres) && ! empty($genres) ) {
                  $meta_bits[] = implode(', ', wp_list_pluck($genres, 'name'));
                }
                // Thời lượng
                $duration = get_post_meta( get_the_ID(), 'movie_duration', true );
                if ( empty($duration) ) $duration = get_post_meta( get_the_ID(), 'duration', true );
                if ( ! empty($duration) ) {
                  // chuẩn hóa hiển thị phút
                  if ( is_numeric($duration) ) $duration = $duration . ' phút';
                  $meta_bits[] = $duration;
                }
                // Xếp loại độ tuổi
                $age_rating = get_post_meta( get_the_ID(), 'movie_rating', true );
                if ( ! empty($age_rating) ) $meta_bits[] = $age_rating;
                // Điểm IMDb (nếu có)
                $imdb = get_post_meta( get_the_ID(), 'movie_imdb_rating', true );
                if ( $imdb !== '' ) {
                  $imdb = number_format((float) $imdb, 1);
                  $meta_bits[] = 'IMDb ' . $imdb;
                }
              ?>
              <?php if ( ! empty($meta_bits) ) : ?>
                <div class="c-movie__meta"><?php echo esc_html( implode(' • ', $meta_bits) ); ?></div>
              <?php endif; ?>
              <?php if ( has_excerpt() ) : ?>
                <div class="c-movie__desc"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '…' ) ); ?></div>
              <?php endif; ?>

              <?php
                // Render giờ chiếu theo dữ liệu showtime của rạp này
                $by_date = isset($showtimes_by_movie[get_the_ID()]) ? $showtimes_by_movie[get_the_ID()] : array();
                if (! empty($by_date)){
                  echo '<div class="c-movie__times">';
                  // Sắp xếp ngày và giờ
                  ksort($by_date);
                  foreach ($by_date as $date => $times){
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
                  // Nếu chưa có suất chiếu, để nút Đặt vé tổng quát
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
    .c-chip{display:inline-flex;min-width:54px;align-items:center;justify-content:center;height:32px;padding:0 10px;border-radius:10px;background:rgba(15,23,42,.85);border:1px solid rgba(148,163,184,.28);font-weight:700;color:#e5e7eb}
    .c-chip:hover{border-color:var(--c-primary);color:var(--c-primary)}
    .c-empty{padding:18px;border:1px dashed rgba(148,163,184,.35);border-radius:12px;background:rgba(15,23,42,.55)}

    @media (max-width: 1024px){ .c-grid{grid-template-columns:repeat(2,1fr)} }
    @media (max-width: 560px){ .c-grid{grid-template-columns:1fr} .c-title{font-size:26px} }
  </style>
</main>

<?php
get_footer();
?>
