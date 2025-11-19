<?php get_header(); ?>
<?php
//  echo get_post_type(); 
// echo "HEADER LOADED"; 
 ?>
<!--  -->
<?php 
  // Lấy các custom fields của phim hiện tại
  $duration     = get_post_meta(get_the_ID(), '_mbs_duration', true);
  $director     = get_post_meta(get_the_ID(), '_mbs_director', true);
  $actors       = get_post_meta(get_the_ID(), '_mbs_actors', true);
  $release_date = get_post_meta(get_the_ID(), '_mbs_release_date', true);
  $rating       = get_post_meta(get_the_ID(), '_mbs_rating', true);
  $trailer_url  = get_post_meta(get_the_ID(), '_mbs_trailer_url', true);
  $language     = get_post_meta(get_the_ID(), '_mbs_language', true);
  $thumb_url    = get_the_post_thumbnail_url(get_the_ID(), 'large');
?>
      <!-- movie detail -->
      <div class="movie-detail">
        <div class="movie-poster">
          <img
            src="<?php echo $thumb_url ? $thumb_url : 'https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Fnui-te-vong.jpg&w=1920&q=75'; ?>"
            alt="Núi Tế Vong Poster"
          />
        </div>

        <div class="movie-info">
          <h1><?php the_title(); ?></h1>
          <?php
            // Link tới trang đặt vé
            $book_page = get_page_by_path('datve');
            $book_link_base = $book_page ? get_permalink($book_page) : home_url('/datve/');
            $current_movie_id = get_the_ID();
          ?>
          <ul class="movie-meta">
            <li><strong>Thể loại:</strong> Kinh Dị</li>
            <li><strong>Thời lượng:</strong> <?php echo esc_html($duration); ?></li>
            <li><strong>Định dạng:</strong> 2D, Phụ Đề</li>
            <li>
              <strong>Phân loại:</strong> T16 - Phim dành cho khán giả từ đủ 16
              tuổi trở lên
            </li>
            <li><strong>Khởi chiếu:</strong> <?php echo esc_html($release_date); ?></li>
            <li>
              <strong>Diễn viên:</strong> <?php echo esc_html($actors); ?>
            </li>
          </ul>

          <div class="movie-description">
            <h2>Nội dung phim</h2>
             <p><?php the_content(); ?></p>
            <a href="<?php echo esc_url( add_query_arg('movie', get_the_ID(), $book_link_base) ); ?>" class="trailer-button" style="background:#ffe44d;color:#0e1220;font-weight:800">🎟 Đặt vé</a>
            <?php if (! empty($trailer_url)) : ?>
              <a href="<?php echo esc_url($trailer_url); ?>" class="trailer-button">🎬 Xem Trailer</a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- showtime -->
      <div class="showtime-section">
        <h2 class="section-title">LỊCH CHIẾU</h2>

        <?php
          // Chuẩn bị dữ liệu suất chiếu từ plugin nếu có
          $showtimes_by_cinema = array();
          $debug = array('source'=>'', 'count'=>0, 'items'=>array());
          global $wpdb;
          $today = date('Y-m-d');
          $st_table = $wpdb->prefix . 'mbs_showtimes';
          $table_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $st_table));

          if ( $table_exists === $st_table ) {
            $debug['source'] = 'table:mbs_showtimes';
            $rows = $wpdb->get_results($wpdb->prepare(
              "SELECT cinema_id, show_date, show_time FROM $st_table WHERE movie_id = %d ORDER BY show_date, show_time",
              $current_movie_id
            ));
            if ($rows) {
              foreach ($rows as $r) {
                $cid = intval($r->cinema_id);
                $date = esc_html($r->show_date);
                $time = esc_html($r->show_time);
                $showtimes_by_cinema[$cid][$date][] = $time;
                $debug['items'][] = array('cid'=>$cid,'date'=>$date,'time'=>$time);
              }
            }
          } elseif ( post_type_exists('mbs_showtime') ) {
            $debug['source'] = 'cpt:mbs_showtime';
            $st = new WP_Query(array(
              'post_type'  => 'mbs_showtime',
              'post_status'=> 'publish',
              'posts_per_page' => -1,
              'meta_query' => array(
                array('key'=>'_mbs_movie_id','value'=>$current_movie_id,'compare'=>'=')
              )
            ));
            if ($st->have_posts()){
              while($st->have_posts()){ $st->the_post();
                $cid  = intval(get_post_meta(get_the_ID(),'_mbs_cinema_id',true));
                $dt   = sanitize_text_field(get_post_meta(get_the_ID(),'_mbs_showtime',true));
                // Chuẩn hoá date/time từ datetime-local
                $ts = strtotime($dt); // nếu null => sai format
                $date = $ts ? date('Y-m-d',$ts) : '';
                $time = $ts ? date('H:i',$ts) : '';
                if($cid && $date && $time){
                  $showtimes_by_cinema[$cid][$date][] = $time;
                  $debug['items'][] = array('cid'=>$cid,'raw'=>$dt,'date'=>$date,'time'=>$time);
                } else {
                  $debug['items'][] = array('cid'=>$cid,'raw'=>$dt,'parse_error'=>true);
                }
              }
              wp_reset_postdata();
            }
          }
          $debug['count'] = count($debug['items']);

          // Tự tìm post type rạp
          $cinema_pts = array('mbs_cinema','rap_phim','rap-phim','cinema','theater','rap','rapfilm','rap_phim_cpt');
          $cinema_pt = null;
          foreach($cinema_pts as $pt){ if ( post_type_exists($pt) ){ $cinema_pt = $pt; break; } }
          if($cinema_pt){
            $cinemas = new WP_Query(array(
              'post_type'=>$cinema_pt,
              'post_status'=>'publish',
              'posts_per_page'=>-1,
              'orderby'=>'title','order'=>'ASC'
            ));
            if($cinemas->have_posts()):
              echo '<div class="cinema-list">';
              while($cinemas->have_posts()): $cinemas->the_post();
                $cid = get_the_ID();
                $date_times = $showtimes_by_cinema[$cid] ?? array();
                if (empty($date_times)) { echo '<div class="cinema-item"><div class="cinema-header"><span>'. esc_html(get_the_title()) .'</span><span class="arrow">▶</span></div><div class="cinema-detail"><p>Chưa có suất chiếu.</p></div></div>'; continue; }
                echo '<div class="cinema-item" onclick="toggleCinema(this)">';
                echo '<div class="cinema-header"><span>'. esc_html(get_the_title()) .'</span><span class="arrow">▶</span></div>';
                echo '<div class="cinema-detail">';
                foreach ($date_times as $date => $times_arr){
                  echo '<p><strong>'. esc_html( date('d/m/Y', strtotime($date)) ) .'</strong></p>';
                  echo '<div class="showtimes">';
                  foreach ($times_arr as $t){
                    $link = add_query_arg(array(
                      'movie'=> $current_movie_id,
                      'cinema'=> $cid,
                      'date'=> $date,
                      'time'=> $t
                    ), $book_link_base );
                    echo '<a href="'. esc_url($link) .'" class="time-chip">'. esc_html($t) .'</a>';
                  }
                  echo '</div>';
                }
                echo '</div></div>';
              endwhile; wp_reset_postdata();
              echo '</div>';
            else:
              echo '<p>Chưa có rạp.</p>';
            endif;
          } else {
            echo '<p>Chưa cấu hình post type rạp.</p>';
          }

          // DEBUG: In dữ liệu đọc được dưới dạng HTML comment
          echo "\n<!-- SHOWTIME_DEBUG\n" . print_r($debug,true) . "\n-->\n";
        ?>
      </div>
</div>

<?php get_footer(); ?>