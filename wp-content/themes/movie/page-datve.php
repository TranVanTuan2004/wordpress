<?php
/**
 * Template Name: Trang Đặt Vé
 */
get_header();

$movie_id  = isset($_GET['movie'])  ? intval($_GET['movie'])  : 0;
$cinema_id = isset($_GET['cinema']) ? intval($_GET['cinema']) : 0;
$date      = isset($_GET['date'])   ? sanitize_text_field($_GET['date']) : date('Y-m-d');
$time      = isset($_GET['time'])   ? sanitize_text_field($_GET['time']) : '';

if ( function_exists('wp_enqueue_script') ) { 
  wp_enqueue_script('jquery');
  wp_enqueue_script('booking-js'); 
}
?>

<script>
// Khởi tạo biến global TRƯỚC KHI HTML render
window.bookingSeats = [];
window.bookingPrice = 95000;
window.BOOKING_AJAX = window.BOOKING_AJAX || {
  url: '<?php echo admin_url('admin-ajax.php'); ?>',
  nonce: '<?php echo wp_create_nonce('ticket_order_nonce'); ?>'
};

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
  var dateEl = document.getElementById('bk-sum-date');
  var timeEl = document.getElementById('bk-sum-time');
  if (!dateEl || !timeEl) {
    console.warn('Date or time element not found');
    return;
  }
  
  var formData = new FormData();
  formData.append('action', 'get_reserved_seats');
  formData.append('movie_id', <?php echo (int)$movie_id; ?>);
  formData.append('cinema_id', <?php echo (int)$cinema_id; ?>);
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

// Xử lý submit
function handleSubmit() {
  if (!window.bookingSeats || window.bookingSeats.length === 0) {
    var resultEl = document.getElementById('bk-result');
    if (resultEl) resultEl.textContent = 'Vui lòng chọn ghế.';
    return;
  }
  
  var dateEl = document.getElementById('bk-sum-date');
  var timeEl = document.getElementById('bk-sum-time');
  var methodEl = document.getElementById('bk-method');
  var resultEl = document.getElementById('bk-result');
  
  if (!dateEl || !timeEl) {
    console.error('Date or time element not found');
    return;
  }
  
  var data = {
    action: 'create_ticket_order',
    nonce: window.BOOKING_AJAX.nonce,
    movie_id: <?php echo (int)$movie_id; ?>,
    cinema_id: <?php echo (int)$cinema_id; ?>,
    date: dateEl.textContent.trim(),
    time: timeEl.textContent.trim(),
    seats: window.bookingSeats,
    total: window.bookingSeats.length * window.bookingPrice,
    method: methodEl ? methodEl.value : 'pay_later'
  };
  
  // Disable button
  var submitBtn = document.getElementById('bk-submit');
  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.textContent = 'Đang xử lý...';
  }
  
  // Gửi request
  var formData = new FormData();
  Object.keys(data).forEach(function(k) {
    if (Array.isArray(data[k])) {
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
      if (resultEl) resultEl.textContent = res.data.message + ' Mã đơn: #' + res.data.order_id;
      window.bookingSeats.forEach(function(s) {
        var btn = document.querySelector('.bk-seat[data-seat="' + s + '"]');
        if (btn) {
          btn.classList.remove('is-sel');
          btn.classList.add('is-booked');
          btn.disabled = true;
          btn.onclick = null;
        }
      });
      window.bookingSeats = [];
      updateBookingInfo();
    } else {
      if (resultEl) resultEl.textContent = res.data && res.data.message ? res.data.message : 'Có lỗi xảy ra.';
    }
  })
  .catch(function(err) { 
    if (submitBtn) {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Thanh toán';
    }
    if (resultEl) resultEl.textContent = 'Có lỗi xảy ra: ' + err.message;
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
    loadReservedSeats();
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
    <h1 class="bk-title">Đặt vé xem phim</h1>

    <div class="bk-summary">
      <div class="bk-row">
        <div><span class="bk-label">Phim:</span> <strong><?php echo $movie_id ? esc_html(get_the_title($movie_id)) : 'Chưa chọn'; ?></strong></div>
        <div><span class="bk-label">Rạp:</span> <strong><?php echo $cinema_id ? esc_html(get_the_title($cinema_id)) : 'Chưa chọn'; ?></strong></div>
      </div>
      <div class="bk-row">
        <div><span class="bk-label">Ngày:</span> <strong id="bk-sum-date"><?php echo esc_html($date); ?></strong></div>
        <div><span class="bk-label">Giờ:</span> <strong id="bk-sum-time"><?php echo esc_html($time ?: '--:--'); ?></strong></div>
      </div>
    </div>

    <div class="bk-layout">
      <section class="bk-seats">
        <div class="bk-screen">Màn hình</div>
        <div class="bk-grid" id="bk-grid">
          <?php
          $rows = range('A', 'H');
          for ($r = 0; $r < count($rows); $r++):
            for ($c = 1; $c <= 12; $c++):
              $seat = $rows[$r] . $c;
          ?>
              <button type="button" class="bk-seat" data-seat="<?php echo esc_attr($seat); ?>" onclick="return handleSeatClick(this);"><?php echo esc_html($seat); ?></button>
          <?php endfor; endfor; ?>
        </div>
        <div class="bk-legend">
          <span class="i i-free"></span> Trống
          <span class="i i-selected"></span> Đang chọn
          <span class="i i-booked"></span> Đã đặt
        </div>
      </section>

      <aside class="bk-sidebar">
        <h2 class="bk-subtitle">Thông tin vé</h2>
        <div class="bk-info">
          <div><span class="bk-label">Ghế:</span> <strong id="bk-seats-list">—</strong></div>
          <div><span class="bk-label">Số lượng:</span> <strong id="bk-qty">0</strong></div>
          <div><span class="bk-label">Giá vé:</span> <strong>95.000đ</strong></div>
          <div><span class="bk-label">Tổng tiền:</span> <strong id="bk-total">0đ</strong></div>
        </div>
        <div class="bk-pay">
          <label for="bk-method" class="bk-label">Phương thức thanh toán</label>
          <select id="bk-method">
            <option value="pay_later">Thanh toán tại rạp</option>
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
    .bk-label{color:#94a3b8}

    .bk-layout{display:grid;grid-template-columns:2fr 1fr;gap:20px}
    .bk-seats{background:rgba(15,23,42,.9);border:1px solid rgba(148,163,184,.14);border-radius:14px;padding:14px}
    .bk-screen{height:36px;border-radius:10px;background:#0b1221;border:1px solid rgba(148,163,184,.25);display:flex;align-items:center;justify-content:center;color:#cbd5e1;margin-bottom:12px;font-weight:600}
    .bk-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:8px}
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
    .bk-legend{margin-top:10px;color:#94a3b8;display:flex;gap:14px;align-items:center;font-size:13px}
    .i{width:14px;height:14px;border-radius:4px;display:inline-block;margin-right:4px}
    .i.i-free{background:#0b1221;border:1px solid rgba(148,163,184,.25)}
    .i.i-selected{background:#4f46e5}
    .i.i-booked{background:#334155}

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
