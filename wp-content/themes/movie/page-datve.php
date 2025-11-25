<?php
/**
 * Template Name: Trang Đặt Vé
 */
get_header();

$movie_id  = isset($_GET['movie'])  ? intval($_GET['movie'])  : 0;
$cinema_id = isset($_GET['cinema']) ? intval($_GET['cinema']) : 0;
$date      = isset($_GET['date'])   ? sanitize_text_field($_GET['date']) : date('Y-m-d');
$time      = isset($_GET['time'])   ? sanitize_text_field($_GET['time']) : '';

// --- LOGIC: MOVIE LISTING (If no movie selected) ---
if ( ! $movie_id ) {
    $args = array(
        'post_type'      => 'mbs_movie',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    $movies = get_posts($args);
    $now_showing = array();
    $coming_soon = array();
    $today = date('Y-m-d');

    foreach ($movies as $m) {
        $status = get_post_meta($m->ID, '_movie_status', true);
        if ($status === 'sap-chieu') {
            $coming_soon[] = $m;
        } else {
            // Default to now showing if 'dang-chieu' or empty
            $now_showing[] = $m;
        }
    }
?>
    <main class="bk-page bk-listing-mode">
        <div class="bk-container">
            <h1 class="bk-title">Chọn Phim Để Đặt Vé</h1>
            
            <!-- NOW SHOWING -->
            <section class="bk-section">
                <h2 class="bk-section-title">PHIM ĐANG CHIẾU</h2>
                <?php if (empty($now_showing)): ?>
                    <p class="bk-empty">Hiện không có phim đang chiếu.</p>
                <?php else: ?>
                    <div class="bk-movie-grid">
                        <?php foreach ($now_showing as $m): 
                            $thumb = get_the_post_thumbnail_url($m->ID, 'medium');
                            $duration = get_post_meta($m->ID, '_mbs_duration', true);
                            $rating = get_post_meta($m->ID, '_mbs_rating', true);
                        ?>
                        <a href="<?php echo esc_url(add_query_arg('movie', $m->ID)); ?>" class="bk-movie-card">
                            <div class="bk-movie-img">
                                <img src="<?php echo $thumb ? $thumb : 'https://via.placeholder.com/300x450'; ?>" alt="<?php echo esc_attr($m->post_title); ?>">
                                <span class="bk-tag"><?php echo $rating ? $rating : 'T13'; ?></span>
                            </div>
                            <div class="bk-movie-info">
                                <h3><?php echo esc_html($m->post_title); ?></h3>
                                <p><?php echo $duration ? $duration : '---'; ?></p>
                                <button class="bk-btn-select">Đặt vé</button>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- COMING SOON -->
            <section class="bk-section">
                <h2 class="bk-section-title">PHIM SẮP CHIẾU</h2>
                <?php if (empty($coming_soon)): ?>
                    <p class="bk-empty">Hiện không có phim sắp chiếu.</p>
                <?php else: ?>
                    <div class="bk-movie-grid">
                        <?php foreach ($coming_soon as $m): 
                            $thumb = get_the_post_thumbnail_url($m->ID, 'medium');
                            $duration = get_post_meta($m->ID, '_mbs_duration', true);
                            $rating = get_post_meta($m->ID, '_mbs_rating', true);
                            $release = get_post_meta($m->ID, '_mbs_release_date', true);
                        ?>
                        <a href="<?php echo esc_url(add_query_arg('movie', $m->ID)); ?>" class="bk-movie-card coming-soon">
                            <div class="bk-movie-img">
                                <img src="<?php echo $thumb ? $thumb : 'https://via.placeholder.com/300x450'; ?>" alt="<?php echo esc_attr($m->post_title); ?>">
                                <span class="bk-tag"><?php echo $rating ? $rating : 'T13'; ?></span>
                            </div>
                            <div class="bk-movie-info">
                                <h3><?php echo esc_html($m->post_title); ?></h3>
                                <p>Khởi chiếu: <?php echo $release; ?></p>
                                <button class="bk-btn-select">Xem chi tiết</button>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
        <style>
            .bk-page { background-color: #0f172a; min-height: 100vh; color: #fff; }
            .bk-container { max-width: 1200px; margin: 0 auto; padding: 40px 16px; }
            .bk-title { text-align: center; margin-bottom: 40px; font-size: 32px; font-weight: 800; color: #ffe44d; text-transform: uppercase; }
            .bk-section { margin-bottom: 50px; }
            .bk-section-title { font-size: 24px; border-left: 5px solid #ffe44d; padding-left: 15px; margin-bottom: 20px; text-transform: uppercase; }
            .bk-movie-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 24px; }
            .bk-movie-card { background: #1e293b; border-radius: 12px; overflow: hidden; display: block; text-decoration: none; color: inherit; transition: transform 0.2s; border: 1px solid rgba(255,255,255,0.05); }
            .bk-movie-card:hover { transform: translateY(-5px); border-color: #ffe44d; }
            .bk-movie-img { position: relative; aspect-ratio: 2/3; overflow: hidden; }
            .bk-movie-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
            .bk-movie-card:hover .bk-movie-img img { transform: scale(1.05); }
            .bk-tag { position: absolute; top: 10px; left: 10px; background: #e11d48; color: #fff; padding: 2px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; }
            .bk-movie-info { padding: 16px; text-align: center; }
            .bk-movie-info h3 { margin: 0 0 8px; font-size: 16px; height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
            .bk-movie-info p { color: #94a3b8; font-size: 13px; margin-bottom: 12px; }
            .bk-btn-select { background: #ffe44d; color: #000; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; transition: background 0.2s; }
            .bk-btn-select:hover { background: #ffd700; }
            .coming-soon .bk-btn-select { background: #334155; color: #fff; }
            .coming-soon .bk-btn-select:hover { background: #475569; }
        </style>
    </main>
<?php
    get_footer();
    exit; // Stop execution here if in listing mode
}

// --- LOGIC: CINEMA & SHOWTIME SELECTION (If movie selected but no cinema/time) ---
if ( $movie_id && ( ! $cinema_id || ! $date || ! $time ) ) {
    $current_movie = get_post($movie_id);
    $thumb = get_the_post_thumbnail_url($movie_id, 'medium');
    $duration = get_post_meta($movie_id, '_mbs_duration', true);
    
    // Fetch Showtimes Logic (similar to single-mbs_movie.php)
    $showtimes_by_cinema = array();
    global $wpdb;
    $st_table = $wpdb->prefix . 'mbs_showtimes';
    $table_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $st_table));

    if ( $table_exists === $st_table ) {
        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT cinema_id, show_date, show_time FROM $st_table WHERE movie_id = %d AND show_date >= CURDATE() ORDER BY show_date, show_time",
            $movie_id
        ));
        if ($rows) {
            foreach ($rows as $r) {
                $cid = intval($r->cinema_id);
                $d = esc_html($r->show_date);
                $t = esc_html($r->show_time);
                $showtimes_by_cinema[$cid][$d][] = $t;
            }
        }
    } elseif ( post_type_exists('mbs_showtime') ) {
        $st = new WP_Query(array(
            'post_type'  => 'mbs_showtime',
            'post_status'=> 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array('key'=>'_mbs_movie_id','value'=>$movie_id,'compare'=>'='),
                array('key'=>'_mbs_showtime','value'=>date('Y-m-d H:i:s'),'compare'=>'>=')
            )
        ));
        if ($st->have_posts()){
            while($st->have_posts()){ $st->the_post();
                $cid  = intval(get_post_meta(get_the_ID(),'_mbs_cinema_id',true));
                $dt   = sanitize_text_field(get_post_meta(get_the_ID(),'_mbs_showtime',true));
                $ts = strtotime($dt);
                if($ts && $cid){
                    $d = date('Y-m-d',$ts);
                    $t = date('H:i',$ts);
                    $showtimes_by_cinema[$cid][$d][] = $t;
                }
            }
            wp_reset_postdata();
        }
    }
    
    // Fetch All Cinemas (Universal Availability)
    $all_cinemas = get_posts(array(
        'post_type' => 'mbs_cinema',
        'posts_per_page' => -1,
        'orderby' => 'title', 
        'order' => 'ASC',
        'post_status' => 'publish'
    ));

    // Default Showtimes Configuration
    $default_times = array('09:00', '11:30', '14:00', '16:30', '19:00', '21:30');
    $default_dates = array(
        date('Y-m-d'), // Today
        date('Y-m-d', strtotime('+1 day')), // Tomorrow
        date('Y-m-d', strtotime('+2 days')) // Day after tomorrow
    );

    // Merge Real Showtimes with Defaults
    $final_showtimes = array();
    foreach ($all_cinemas as $cinema) {
        $cid = $cinema->ID;
        if (isset($showtimes_by_cinema[$cid]) && !empty($showtimes_by_cinema[$cid])) {
            // Use real showtimes if available
            $final_showtimes[$cid] = $showtimes_by_cinema[$cid];
        } else {
            // Generate default showtimes
            foreach ($default_dates as $d) {
                $final_showtimes[$cid][$d] = $default_times;
            }
        }
    }
?>
    <main class="bk-page bk-step-1">
        <div class="bk-container">
            <div style="margin-bottom: 20px;">
                <a href="<?php echo esc_url(get_permalink()); ?>" style="color: #94a3b8; text-decoration: none;">&larr; Chọn phim khác</a>
            </div>
            
            <div class="bk-movie-header">
                <div class="bk-mh-img">
                    <img src="<?php echo $thumb ? $thumb : 'https://via.placeholder.com/300x450'; ?>" alt="<?php echo esc_attr($current_movie->post_title); ?>">
                </div>
                <div class="bk-mh-info">
                    <h1 class="bk-mh-title"><?php echo esc_html($current_movie->post_title); ?></h1>
                    <p class="bk-mh-meta">Thời lượng: <?php echo $duration ? $duration : '---'; ?></p>
                    <p class="bk-mh-desc">Vui lòng chọn rạp và suất chiếu phù hợp.</p>
                </div>
            </div>

            <section class="bk-section">
                <h2 class="bk-section-title">LỊCH CHIẾU</h2>
                <?php if (empty($all_cinemas)): ?>
                    <p class="bk-empty">Hiện chưa có rạp nào hoạt động.</p>
                <?php else: ?>
                    <div class="bk-cinema-list">
                        <?php foreach ($all_cinemas as $cinema): 
                            $dates = $final_showtimes[$cinema->ID] ?? array();
                            ksort($dates);
                        ?>
                            <div class="bk-cinema-item">
                                <h3 class="bk-cinema-name"><?php echo esc_html($cinema->post_title); ?></h3>
                                <div class="bk-dates">
                                    <?php foreach ($dates as $date => $times): 
                                        sort($times);
                                    ?>
                                        <div class="bk-date-row">
                                            <div class="bk-date-label"><?php echo date('d/m/Y', strtotime($date)); ?></div>
                                            <div class="bk-time-list">
                                                <?php foreach ($times as $time): 
                                                    $link = add_query_arg(array(
                                                        'movie' => $movie_id,
                                                        'cinema' => $cinema->ID,
                                                        'date' => $date,
                                                        'time' => $time
                                                    ));
                                                ?>
                                                    <a href="<?php echo esc_url($link); ?>" class="bk-time-btn"><?php echo $time; ?></a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
        <style>
            .bk-page { background-color: #0f172a; min-height: 100vh; color: #fff; }
            .bk-container { max-width: 1000px; margin: 0 auto; padding: 40px 16px; }
            .bk-movie-header { display: flex; gap: 30px; margin-bottom: 40px; background: #1e293b; padding: 30px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); }
            .bk-mh-img { width: 150px; flex-shrink: 0; border-radius: 8px; overflow: hidden; }
            .bk-mh-img img { width: 100%; height: auto; display: block; }
            .bk-mh-info { flex: 1; }
            .bk-mh-title { margin: 0 0 10px; font-size: 28px; color: #ffe44d; }
            .bk-mh-meta { color: #cbd5e1; margin-bottom: 10px; }
            .bk-mh-desc { color: #94a3b8; }
            
            .bk-section-title { font-size: 24px; border-left: 5px solid #ffe44d; padding-left: 15px; margin-bottom: 20px; text-transform: uppercase; }
            .bk-cinema-list { display: flex; flex-direction: column; gap: 20px; }
            .bk-cinema-item { background: #1e293b; border-radius: 12px; padding: 20px; border: 1px solid rgba(255,255,255,0.05); }
            .bk-cinema-name { margin: 0 0 16px; color: #fff; font-size: 18px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px; }
            .bk-date-row { display: flex; gap: 20px; margin-bottom: 16px; align-items: flex-start; }
            .bk-date-row:last-child { margin-bottom: 0; }
            .bk-date-label { width: 100px; font-weight: bold; color: #cbd5e1; padding-top: 8px; }
            .bk-time-list { flex: 1; display: flex; flex-wrap: wrap; gap: 10px; }
            .bk-time-btn { 
                background: #0f172a; border: 1px solid rgba(148,163,184,0.3); color: #e2e8f0; 
                padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; transition: all 0.2s;
            }
            .bk-time-btn:hover { background: #ffe44d; color: #000; border-color: #ffe44d; transform: translateY(-2px); }
            
            @media (max-width: 600px) {
                .bk-movie-header { flex-direction: column; text-align: center; }
                .bk-mh-img { width: 120px; margin: 0 auto; }
                .bk-date-row { flex-direction: column; gap: 10px; }
            }
        </style>
    </main>
<?php
    get_footer();
    exit;
}

if ( function_exists('wp_enqueue_script') ) { 
  wp_enqueue_script('jquery');
  wp_enqueue_script('booking-js'); 
}

$cinema_options = get_posts(array(
  'post_type'      => 'mbs_cinema',
  'posts_per_page' => -1,
  'orderby'        => 'title',
  'order'          => 'ASC',
));

$movie_options = get_posts(array(
  'post_type'      => 'mbs_movie',
  'posts_per_page' => -1,
  'orderby'        => 'title',
  'order'          => 'ASC',
));
?>

<script>
// Khởi tạo biến global TRƯỚC KHI HTML render
window.bookingSeats = [];
window.bookingPrice = 95000;
window.BOOKING_AJAX = window.BOOKING_AJAX || {
  url: '<?php echo admin_url('admin-ajax.php'); ?>',
  nonce: '<?php echo wp_create_nonce('ticket_order_nonce'); ?>'
};
window.isUserLoggedIn = <?php echo is_user_logged_in() ? 'true' : 'false'; ?>;
window.selectedMovieId = <?php echo (int) $movie_id; ?>;
window.selectedCinemaId = <?php echo (int) $cinema_id; ?>;

// Hàm xử lý click ghế - ĐƠN GIẢN VÀ RÕ RÀNG
window.handleSeatClick = function(btn) {
  try {
    if (!btn) {
      console.error('Button is null');
      return false;
    }
    
    // Kiểm tra ghế đã đặt
    if (btn.classList.contains('is-booked') || btn.disabled) {
      console.log('Seat is booked');
      return false;
    }
    
    var seat = btn.getAttribute('data-seat');
    if (!seat) {
      console.error('No seat data');
      return false;
    }
    
    console.log('Seat clicked:', seat);
    
    // Toggle selection
    var index = window.bookingSeats.indexOf(seat);
    if (index > -1) {
      // Bỏ chọn
      window.bookingSeats.splice(index, 1);
      btn.classList.remove('is-sel');
      console.log('Deselected:', seat);
    } else {
      // Chọn
      window.bookingSeats.push(seat);
      btn.classList.add('is-sel');
      console.log('Selected:', seat);
    }
    
    // Cập nhật UI
    updateBookingInfo();
    return true;
  } catch (e) {
    console.error('Error in handleSeatClick:', e);
    return false;
  }
};

// Cập nhật thông tin đặt vé
function updateBookingInfo() {
  var listEl = document.getElementById('bk-seats-list');
  var qtyEl = document.getElementById('bk-qty');
  var totalEl = document.getElementById('bk-total');
  
  if (listEl) listEl.textContent = window.bookingSeats.length > 0 ? window.bookingSeats.join(', ') : '—';
  if (qtyEl) qtyEl.textContent = window.bookingSeats.length;
  if (totalEl) {
    var total = window.bookingSeats.length * window.bookingPrice;
    totalEl.textContent = total.toLocaleString('vi-VN') + 'đ';
  }
}

// Load ghế đã đặt
function loadReservedSeats() {
  if (!window.selectedMovieId || !window.selectedCinemaId) {
    console.warn('Missing movie or cinema when loading reserved seats');
    return;
  }

  var dateEl = document.getElementById('bk-sum-date');
  var timeEl = document.getElementById('bk-sum-time');
  if (!dateEl || !timeEl) {
    console.warn('Date or time element not found');
    return;
  }
  
  var formData = new FormData();
  formData.append('action', 'get_reserved_seats');
  formData.append('movie_id', window.selectedMovieId || 0);
  formData.append('cinema_id', window.selectedCinemaId || 0);
  formData.append('date', dateEl.textContent.trim());
  formData.append('time', timeEl.textContent.trim());
  
  fetch(window.BOOKING_AJAX.url, {
    method: 'POST',
    body: formData
  })
  .then(function(res) { return res.json(); })
  .then(function(data) {
    if (data && data.success && data.data && data.data.seats) {
      data.data.seats.forEach(function(s) {
        var btn = document.querySelector('.bk-seat[data-seat="' + s + '"]');
        if (btn) {
          btn.classList.add('is-booked');
          btn.disabled = true;
          btn.onclick = null; // Remove onclick để không click được
        }
      });
      console.log('Loaded reserved seats:', data.data.seats);
    }
  })
  .catch(function(err) { 
    console.error('Error loading reserved seats:', err); 
  });
}

// Xử lý chuyển bước
function handleNextStep() {
  var resultEl = document.getElementById('bk-result');
  
  // Validate login
  if (!window.isUserLoggedIn) {
    if (resultEl) {
      resultEl.textContent = 'Bạn cần vui lòng đăng nhập để đặt vé.';
      resultEl.style.color = '#fca5a5';
    }
    return;
  }
  
  // Validate seats
  if (!window.bookingSeats || window.bookingSeats.length === 0) {
    if (resultEl) resultEl.textContent = 'Vui lòng chọn ghế.';
    return;
  }

  // Hide seat selection, show popcorn
  document.getElementById('bk-step-seats').style.display = 'none';
  document.getElementById('bk-step-popcorn').style.display = 'block';
  
  // Update summary
  updateBookingInfo();
}

function handleBackStep() {
  document.getElementById('bk-step-popcorn').style.display = 'none';
  document.getElementById('bk-step-seats').style.display = 'block';
}

// Popcorn Logic
window.bookingFood = {}; // {productId: qty}

function updateFoodQty(productId, change, price, name) {
  if (!window.bookingFood[productId]) window.bookingFood[productId] = 0;
  window.bookingFood[productId] += change;
  if (window.bookingFood[productId] < 0) window.bookingFood[productId] = 0;
  
  // Update UI
  var qtyEl = document.getElementById('food-qty-' + productId);
  if (qtyEl) qtyEl.textContent = window.bookingFood[productId];
  
  updateBookingInfo();
}

// Cập nhật thông tin đặt vé (bao gồm cả bắp nước)
function updateBookingInfo() {
  var listEl = document.getElementById('bk-seats-list');
  var qtyEl = document.getElementById('bk-qty');
  var totalEl = document.getElementById('bk-total');
  
  // Seats
  if (listEl) listEl.textContent = window.bookingSeats.length > 0 ? window.bookingSeats.join(', ') : '—';
  if (qtyEl) qtyEl.textContent = window.bookingSeats.length;
  
  var seatTotal = window.bookingSeats.length * window.bookingPrice;
  
  // Food
  var foodTotal = 0;
  var foodList = [];
  for (var pid in window.bookingFood) {
    var qty = window.bookingFood[pid];
    if (qty > 0) {
      var el = document.getElementById('food-qty-' + pid);
      var price = el ? parseInt(el.dataset.price) : 0;
      var name = el ? el.dataset.name : '';
      foodTotal += qty * price;
      foodList.push(qty + 'x ' + name);
    }
  }
  
  // Update Total Display
  var grandTotal = seatTotal + foodTotal;
  if (totalEl) {
    totalEl.textContent = grandTotal.toLocaleString('vi-VN') + 'đ';
    if (foodTotal > 0) {
        totalEl.innerHTML += '<br><span style="font-size: 14px; color: #94a3b8;">(Vé: ' + seatTotal.toLocaleString('vi-VN') + 'đ + Bắp nước: ' + foodTotal.toLocaleString('vi-VN') + 'đ)</span>';
    }
  }
}

// Xử lý submit cuối cùng
function handleSubmit() {
  var resultEl = document.getElementById('bk-result');
  var dateEl = document.getElementById('bk-sum-date');
  var timeEl = document.getElementById('bk-sum-time');
  var methodEl = document.getElementById('bk-method');
  
  var data = {
    action: 'create_ticket_order',
    nonce: window.BOOKING_AJAX.nonce,
    movie_id: window.selectedMovieId || 0,
    cinema_id: window.selectedCinemaId || 0,
    date: dateEl.textContent.trim(),
    time: timeEl.textContent.trim(),
    seats: window.bookingSeats,
    food_items: window.bookingFood, // Send food items
    total: 0, // Calculated on server or re-calculated here? Better to let server handle or send both.
    // Let's send the calculated total for verification, but server should re-calc.
    // For now, we send the total we displayed.
    method: methodEl ? methodEl.value : 'pay_later'
  };
  
  // Calculate total again to be sure
  var seatTotal = window.bookingSeats.length * window.bookingPrice;
  var foodTotal = 0;
  for (var pid in window.bookingFood) {
    var qty = window.bookingFood[pid];
    if (qty > 0) {
       var el = document.getElementById('food-qty-' + pid);
       var price = el ? parseInt(el.dataset.price) : 0;
       foodTotal += qty * price;
    }
  }
  data.total = seatTotal + foodTotal;

  // Disable button
  var submitBtn = document.getElementById('bk-submit');
  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.textContent = 'Đang xử lý...';
  }
  
  // Gửi request
  var formData = new FormData();
  Object.keys(data).forEach(function(k) {
    if (k === 'food_items') {
        // Handle object
        for (var pid in data[k]) {
            formData.append('food_items[' + pid + ']', data[k][pid]);
        }
    } else if (Array.isArray(data[k])) {
      data[k].forEach(function(v) { formData.append(k + '[]', v); });
    } else {
      formData.append(k, data[k]);
    }
  });
  
  fetch(window.BOOKING_AJAX.url, { 
    method: 'POST', 
    body: formData 
  })
  .then(function(res) { return res.json(); })
  .then(function(res) {
    if (submitBtn) {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Thanh toán';
    }
    
    if (res.success) {
      if (res.data && res.data.redirect) {
        window.location.href = res.data.redirect;
        return;
      }
      // ... existing success logic ...
    } else {
      if (resultEl) resultEl.textContent = res.data && res.data.message ? res.data.message : 'Có lỗi xảy ra.';
    }
  })
  .catch(function(err) { 
    // ... existing error logic ...
    console.error('Submit error:', err);
  });
}

// Khởi tạo khi DOM ready
(function() {
  function init() {
    var submitBtn = document.getElementById('bk-submit');
    if (submitBtn && !submitBtn.dataset.bound) {
      submitBtn.dataset.bound = 'true';
      submitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        handleSubmit();
      });
    }

    var movieSelect = document.getElementById('bk-movie-select');
    if (movieSelect && !movieSelect.dataset.bound) {
      movieSelect.dataset.bound = 'true';
      movieSelect.addEventListener('change', function() {
        var selected = parseInt(this.value, 10) || 0;
        window.selectedMovieId = selected;
        var summaryMovie = document.getElementById('bk-summary-movie');
        var optionLabel = '';
        if (selected) {
          var opt = this.options[this.selectedIndex];
          optionLabel = (opt && opt.dataset && opt.dataset.name) ? opt.dataset.name : opt.textContent;
        }
        if (summaryMovie) {
          summaryMovie.textContent = optionLabel || 'Chưa chọn';
        }
        if (window.selectedMovieId && window.selectedCinemaId) {
          loadReservedSeats();
        }
      });
    }

    var cinemaSelect = document.getElementById('bk-cinema-select');
    if (cinemaSelect && !cinemaSelect.dataset.bound) {
      cinemaSelect.dataset.bound = 'true';
      cinemaSelect.addEventListener('change', function() {
        var selected = parseInt(this.value, 10) || 0;
        window.selectedCinemaId = selected;
        var summaryCinema = document.getElementById('bk-summary-cinema');
        var optionLabel = '';
        if (selected) {
          var opt = this.options[this.selectedIndex];
          optionLabel = (opt && opt.dataset && opt.dataset.name) ? opt.dataset.name : opt.textContent;
        }
        if (summaryCinema) {
          summaryCinema.textContent = optionLabel || 'Chưa chọn';
        }
        if (window.selectedMovieId && window.selectedCinemaId) {
          loadReservedSeats();
        }
      });
    }

    if (window.selectedMovieId && window.selectedCinemaId) {
      loadReservedSeats();
    }
  }
  
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>

<main class="bk-page">
  <div class="bk-container">
    <div style="margin-bottom: 20px;">
        <a href="<?php echo esc_url(get_permalink()); ?>" style="color: #94a3b8; text-decoration: none;">&larr; Quay lại danh sách phim</a>
    </div>
    <h1 class="bk-title">Đặt vé xem phim</h1>

    <div class="bk-summary">
      <div class="bk-row">
        <div><span class="bk-label">Phim:</span> <strong id="bk-summary-movie"><?php echo $movie_id ? esc_html(get_the_title($movie_id)) : 'Chưa chọn'; ?></strong></div>
        <div><span class="bk-label">Rạp:</span> <strong id="bk-summary-cinema"><?php echo $cinema_id ? esc_html(get_the_title($cinema_id)) : 'Chưa chọn'; ?></strong></div>
      </div>
      <div class="bk-row">
        <div><span class="bk-label">Ngày:</span> <strong id="bk-sum-date"><?php echo esc_html($date); ?></strong></div>
        <div><span class="bk-label">Giờ:</span> <strong id="bk-sum-time"><?php echo esc_html($time ?: '--:--'); ?></strong></div>
      </div>
      <?php if ( ! empty( $cinema_options ) ) : ?>
      <div class="bk-row bk-row--controls">
        <div class="bk-control">
          <label for="bk-movie-select" class="bk-label">Chọn phim</label>
          <select id="bk-movie-select">
            <option value="">— Chọn phim —</option>
            <?php foreach ( $movie_options as $movie ) : ?>
              <option value="<?php echo esc_attr( $movie->ID ); ?>"
                data-name="<?php echo esc_attr( $movie->post_title ); ?>"
                <?php selected( $movie_id, $movie->ID ); ?>>
                <?php echo esc_html( $movie->post_title ); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="bk-control">
          <label for="bk-cinema-select" class="bk-label">Chọn rạp</label>
          <select id="bk-cinema-select">
            <option value="">— Chọn rạp —</option>
            <?php foreach ( $cinema_options as $cinema ) : ?>
              <option value="<?php echo esc_attr( $cinema->ID ); ?>"
                data-name="<?php echo esc_attr( $cinema->post_title ); ?>"
                <?php selected( $cinema_id, $cinema->ID ); ?>>
                <?php echo esc_html( $cinema->post_title ); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <div class="bk-layout">
      <section class="bk-seats">
            <!-- STEP 2: SEATS -->
            <div id="bk-step-seats">
                <div class="bk-screen">MÀN HÌNH</div>
                <div class="bk-seats-grid">
                    <?php
                    $rows = array('A','B','C','D','E','F','G','H');
                    $cols = 12;
                    foreach ($rows as $row) {
                        echo '<div class="bk-row">';
                        for ($i=1; $i<=$cols; $i++) {
                            $seat_code = $row . $i;
                            // Check reserved logic via JS
                            echo '<button class="bk-seat" data-seat="'.$seat_code.'" onclick="handleSeatClick(this)">'.$seat_code.'</button>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                
                <div class="bk-note">
                    <span class="bk-note-item"><span class="bk-seat"></span> Ghế trống</span>
                    <span class="bk-note-item"><span class="bk-seat is-sel"></span> Đang chọn</span>
                    <span class="bk-note-item"><span class="bk-seat is-booked"></span> Đã đặt</span>
                </div>

                <div class="bk-actions">
                    <button class="bk-btn-next" onclick="handleNextStep()">Tiếp tục: Chọn Bắp Nước &rarr;</button>
                </div>
            </div>

            <!-- STEP 3: POPCORN & DRINKS -->
            <div id="bk-step-popcorn" style="display: none;">
                <h2 class="bk-section-title">CHỌN BẮP NƯỚC</h2>
                <div class="bk-popcorn-grid">
                    <?php
                    // Fetch WooCommerce Products
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'orderby' => 'menu_order title',
                        'order' => 'ASC',
                        'post_status' => 'publish',
                    );
                    $loop = new WP_Query($args);
                    if ($loop->have_posts()):
                        while ($loop->have_posts()): $loop->the_post(); global $product;
                            // Skip ticket products
                            if (strpos($product->get_sku(), 'ticket-movie-') === 0 || $product->get_name() === 'Vé xem phim') {
                                continue;
                            }
                            
                            $img_url = get_the_post_thumbnail_url($loop->post->ID, 'medium');
                            if (!$img_url) $img_url = wc_placeholder_img_src();
                            if (!$img_url) $img_url = 'https://placehold.co/300x300?text=No+Image';
                            $pid = $product->get_id();
                            $price = $product->get_price();
                    ?>
                    <div class="bk-food-item">
                        <div class="bk-food-img">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>">
                        </div>
                        <div class="bk-food-info">
                            <h3 class="bk-food-name"><?php the_title(); ?></h3>
                            <div class="bk-food-price"><?php echo wc_price($price); ?></div>
                            <div class="bk-food-qty-ctrl">
                                <button onclick="updateFoodQty(<?php echo $pid; ?>, -1, <?php echo $price; ?>, '<?php echo esc_js($product->get_name()); ?>')">-</button>
                                <span id="food-qty-<?php echo $pid; ?>" data-price="<?php echo $price; ?>" data-name="<?php echo esc_attr($product->get_name()); ?>">0</span>
                                <button onclick="updateFoodQty(<?php echo $pid; ?>, 1, <?php echo $price; ?>, '<?php echo esc_js($product->get_name()); ?>')">+</button>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                    <?php else: ?>
                        <p>Hiện chưa có bắp nước.</p>
                    <?php endif; ?>
                </div>
                
                <div class="bk-actions" style="margin-top: 30px; display: flex; justify-content: space-between;">
                    <button class="bk-btn-back" onclick="handleBackStep()">&larr; Quay lại chọn ghế</button>
                    <!-- Submit button moved here -->
                </div>
            </div>
      </section>

      <aside class="bk-sidebar">
        <h2 class="bk-subtitle">Thông tin vé</h2>
        <div class="bk-info">
          <div><span class="bk-label">Ghế:</span> <strong id="bk-seats-list">—</strong></div>
          <div><span class="bk-label">Số lượng:</span> <strong id="bk-qty">0</strong></div>
          <div><span class="bk-label">Giá vé:</span> <strong>95.000đ</strong></div>
          <div><span class="bk-label">Tổng tiền:</span> <strong id="bk-total">0đ</strong></div>
          <!-- Hidden fields for JS -->
          <span id="bk-sum-date" style="display:none;"><?php echo esc_html($date); ?></span>
          <span id="bk-sum-time" style="display:none;"><?php echo esc_html($time); ?></span>
        </div>
        <div class="bk-pay">
          <label for="bk-method" class="bk-label">Phương thức thanh toán</label>
          <select id="bk-method">
            <option value="pay_later">Thanh toán tại rạp</option>
            <?php if (class_exists('WooCommerce')): ?>
            <option value="credit_card">Thẻ tín dụng/Ghi nợ</option>
            <?php endif; ?>
          </select>
        </div>
        <button type="button" id="bk-submit" class="bk-btn">Thanh toán</button>
        <div id="bk-result" class="bk-result" aria-live="polite"></div>
      </aside>
    </div>
  </div>

  <style>
    .bk-page{color:#e5e7eb;min-height:100vh}
    .bk-container{max-width:1200px;margin:0 auto;padding:24px 16px}
    .bk-title{margin:0 0 12px;font-size:28px;font-weight:800;color:#fff}
    .bk-summary{background:rgba(15,23,42,.9);border:1px solid rgba(148,163,184,.14);border-radius:14px;padding:12px;margin-bottom:18px}
    .bk-row{display:flex;gap:20px;margin:4px 0}
    .bk-row--controls{align-items:flex-end;flex-wrap:wrap}
    .bk-control{display:flex;flex-direction:column;gap:6px;min-width:220px}
    .bk-label{color:#94a3b8}
    .bk-control select{
      height:38px;
      border-radius:8px;
      border:1px solid rgba(148,163,184,.25);
      background:#0b1221;
      color:#e5e7eb;
      padding:0 10px;
    }

    .bk-layout{display:grid;grid-template-columns:2fr 1fr;gap:20px}
    .bk-seats{background:rgba(15,23,42,.9);border:1px solid rgba(148,163,184,.14);border-radius:14px;padding:14px}
    .bk-screen{height:36px;border-radius:10px;background:#0b1221;border:1px solid rgba(148,163,184,.25);display:flex;align-items:center;justify-content:center;color:#cbd5e1;margin-bottom:12px;font-weight:600}
    .bk-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:8px}
    .bk-seats-grid{display:flex; flex-direction: column; gap: 8px; align-items: center;}
    .bk-row{display: flex; gap: 8px; justify-content: center;}
    .bk-seat{
      height:34px;
      min-width:34px;
      border-radius:8px;
      border:1px solid rgba(148,163,184,.25);
      background:#0b1221;
      color:#e5e7eb;
      cursor:pointer !important;
      pointer-events:auto !important;
      position:relative;
      z-index:10;
      font-size:12px;
      font-weight:600;
      transition:all 0.2s ease;
    }
    .bk-seat:hover:not(.is-booked):not(:disabled){
      background:#1e293b !important;
      border-color:#6366f1 !important;
      transform:scale(1.05);
    }
    .bk-seat.is-sel{
      background:#4f46e5 !important;
      border-color:#6366f1 !important;
      color:#fff !important;
    }
    .bk-seat.is-booked,
    .bk-seat:disabled{
      background:#334155 !important;
      border-color:#475569 !important;
      color:#cbd5e1 !important;
      cursor:not-allowed !important;
      opacity:.7;
      pointer-events:none !important;
    }
    .bk-legend, .bk-note{margin-top:10px;color:#94a3b8;display:flex;gap:14px;align-items:center;font-size:13px; justify-content: center;}
    .i, .bk-note-item span{width:14px;height:14px;border-radius:4px;display:inline-block;margin-right:4px}
    .i.i-free, .bk-note-item .bk-seat:not(.is-sel):not(.is-booked){background:#0b1221;border:1px solid rgba(148,163,184,.25); min-width: 14px; height: 14px;}
    .i.i-selected, .bk-note-item .is-sel{background:#4f46e5; min-width: 14px; height: 14px;}
    .i.i-booked, .bk-note-item .is-booked{background:#334155; min-width: 14px; height: 14px;}

    /* Popcorn Grid */
    .bk-popcorn-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .bk-food-item {
        background: #1e293b;
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s;
    }
    .bk-food-item:hover {
        transform: translateY(-5px);
        border-color: #ffe44d;
    }
    .bk-food-img {
        aspect-ratio: 1/1;
        overflow: hidden;
    }
    .bk-food-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .bk-food-info {
        padding: 12px;
        text-align: center;
    }
    .bk-food-name {
        font-size: 14px;
        font-weight: 600;
        margin: 0 0 8px;
        color: #fff;
        height: 40px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .bk-food-price {
        color: #ffe44d;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .bk-food-qty-ctrl {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #0f172a;
        padding: 4px;
        border-radius: 20px;
    }
    .bk-food-qty-ctrl button {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: none;
        background: #334155;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    .bk-food-qty-ctrl button:hover {
        background: #ffe44d;
        color: #000;
    }
    .bk-food-qty-ctrl span {
        min-width: 20px;
        text-align: center;
        font-weight: bold;
    }

    /* Actions */
    .bk-actions {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
    }
    .bk-btn-next, .bk-btn-back {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        text-transform: uppercase;
        font-size: 14px;
    }
    .bk-btn-next {
        background: #ffe44d;
        color: #0f172a;
    }
    .bk-btn-next:hover {
        background: #ffd700;
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(255, 228, 77, 0.3);
    }
    .bk-btn-back {
        background: transparent;
        border: 1px solid rgba(255,255,255,0.2);
        color: #cbd5e1;
    }
    .bk-btn-back:hover {
        border-color: #fff;
        color: #fff;
    }

    .bk-sidebar{background:rgba(15,23,42,.9);border:1px solid rgba(148,163,184,.14);border-radius:14px;padding:14px}
    .bk-subtitle{margin:0 0 10px;font-size:18px;font-weight:800;color:#fff}
    .bk-info{display:grid;gap:8px;margin-bottom:12px}
    .bk-pay{margin-bottom:12px}
    .bk-pay select{width:100%;height:38px;border-radius:8px;border:1px solid rgba(148,163,184,.25);background:#0b1221;color:#e5e7eb;padding:0 8px}
    .bk-btn{
      width:100%;
      height:42px;
      border-radius:10px;
      border:none;
      background:#ffe44d;
      color:#0e1220;
      font-weight:800;
      cursor:pointer;
      transition:all 0.2s ease;
    }
    .bk-btn:hover:not(:disabled){background:#ffd700;transform:translateY(-1px);box-shadow:0 4px 12px rgba(255,228,77,.3)}
    .bk-btn:disabled{opacity:.6;cursor:not-allowed}
    .bk-result{margin-top:10px;color:#93c5fd;min-height:20px}

    @media (max-width: 900px){ 
      .bk-layout{grid-template-columns:1fr} 
      .bk-grid{grid-template-columns:repeat(8,1fr)}
    }
  </style>
</main>

<?php get_footer(); ?>
