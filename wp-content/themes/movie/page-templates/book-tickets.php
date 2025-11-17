<?php
/**
 * Template Name: Đặt Vé Phim
 */
get_header();

$movie_id  = isset($_GET['movie'])  ? intval($_GET['movie'])  : 0;
$cinema_id = isset($_GET['cinema']) ? intval($_GET['cinema']) : 0;
$date      = isset($_GET['date'])   ? sanitize_text_field($_GET['date']) : date('Y-m-d');
$time      = isset($_GET['time'])   ? sanitize_text_field($_GET['time']) : '';

wp_enqueue_script('booking-js');
?>

<main class="bk-page">
  <div class="bk-container">
    <h1 class="bk-title">Đặt vé</h1>

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
          // 8 hàng x 12 cột
          $rows = range('A', 'H');
          for ($r = 0; $r < count($rows); $r++):
            for ($c = 1; $c <= 12; $c++):
              $seat = $rows[$r] . $c;
          ?>
              <button type="button" class="bk-seat" data-seat="<?php echo esc_attr($seat); ?>" onclick="return bkHandleSeatClick(this);"><?php echo esc_html($seat); ?></button>
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
            <option value="cod">COD (tại quầy)</option>
          </select>
        </div>
        <button id="bk-submit" class="bk-btn">Thanh toán</button>
        <div id="bk-result" class="bk-result" aria-live="polite"></div>
      </aside>
    </div>
  </div>

  <style>
    .bk-page{color:#e5e7eb}
    .bk-container{max-width:1200px;margin:0 auto;padding:24px 16px}
    .bk-title{margin:0 0 12px;font-size:28px;font-weight:800}
    .bk-summary{background:rgba(15,23,42,.9);border:1px solid rgba(148,163,184,.14);border-radius:14px;padding:12px;margin-bottom:18px}
    .bk-row{display:flex;gap:20px;margin:4px 0}
    .bk-label{color:#94a3b8}

    .bk-layout{display:grid;grid-template-columns:2fr 1fr;gap:20px}
    .bk-seats{background:rgba(15,23,42,.9);border:1px solid rgba(148,163,184,.14);border-radius:14px;padding:14px}
    .bk-screen{height:36px;border-radius:10px;background:#0b1221;border:1px solid rgba(148,163,184,.25);display:flex;align-items:center;justify-content:center;color:#cbd5e1;margin-bottom:12px}
    .bk-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:8px}
    .bk-seat{height:34px;border-radius:8px;border:1px solid rgba(148,163,184,.25);background:#0b1221;color:#e5e7eb;cursor:pointer}
    .bk-seat.is-sel{background:#4f46e5;border-color:#6366f1}
    .bk-seat.is-booked{background:#334155;border-color:#475569;color:#cbd5e1;cursor:not-allowed;opacity:.7}
    .bk-legend{margin-top:10px;color:#94a3b8;display:flex;gap:14px;align-items:center}
    .i{width:14px;height:14px;border-radius:4px;display:inline-block;margin-right:4px}
    .i.i-free{background:#0b1221;border:1px solid rgba(148,163,184,.25)}
    .i.i-selected{background:#4f46e5}
    .i.i-booked{background:#334155}

    .bk-sidebar{background:rgba(15,23,42,.9);border:1px solid rgba(148,163,184,.14);border-radius:14px;padding:14px}
    .bk-subtitle{margin:0 0 10px;font-size:18px;font-weight:800}
    .bk-info{display:grid;gap:8px;margin-bottom:12px}
    .bk-pay{margin-bottom:12px}
    .bk-pay select{width:100%;height:38px;border-radius:8px;border:1px solid rgba(148,163,184,.25);background:#0b1221;color:#e5e7eb;padding:0 8px}
    .bk-btn{width:100%;height:42px;border-radius:10px;border:none;background:#ffe44d;color:#0e1220;font-weight:800;cursor:pointer}
    .bk-result{margin-top:10px;color:#93c5fd}

    @media (max-width: 900px){ .bk-layout{grid-template-columns:1fr} }
  </style>

  <script>
  // Biến global
  window.bookingSeats = [];
  window.bookingPrice = 95000;
  window.BOOKING_AJAX = window.BOOKING_AJAX || {
    url: '<?php echo admin_url('admin-ajax.php'); ?>',
    nonce: '<?php echo wp_create_nonce('ticket_order_nonce'); ?>'
  };

  function bkFmt(n){ return n.toLocaleString('vi-VN') + 'đ'; }

  function bkUpdateInfo(){
    var listEl  = document.getElementById('bk-seats-list');
    var qtyEl   = document.getElementById('bk-qty');
    var totalEl = document.getElementById('bk-total');
    if (listEl)  listEl.textContent  = window.bookingSeats.length ? window.bookingSeats.join(', ') : '—';
    if (qtyEl)   qtyEl.textContent   = window.bookingSeats.length;
    if (totalEl) totalEl.textContent = bkFmt(window.bookingSeats.length * window.bookingPrice);
  }

  // Click ghế
  function bkHandleSeatClick(btn){
    if (!btn) return false;
    if (btn.classList.contains('is-booked') || btn.disabled) return false;
    var seat = btn.getAttribute('data-seat');
    if (!seat) return false;
    var idx = window.bookingSeats.indexOf(seat);
    if (idx > -1){
      window.bookingSeats.splice(idx,1);
      btn.classList.remove('is-sel');
    } else {
      window.bookingSeats.push(seat);
      btn.classList.add('is-sel');
    }
    bkUpdateInfo();
    return false;
  }

  // Load ghế đã đặt
  function bkLoadReservedSeats(){
    var dateEl = document.getElementById('bk-sum-date');
    var timeEl = document.getElementById('bk-sum-time');
    if (!dateEl || !timeEl) return;
    var fd = new FormData();
    fd.append('action','get_reserved_seats');
    fd.append('movie_id','<?php echo (int)$movie_id;?>');
    fd.append('cinema_id','<?php echo (int)$cinema_id;?>');
    fd.append('date', dateEl.textContent.trim());
    fd.append('time', timeEl.textContent.trim());
    fetch(window.BOOKING_AJAX.url,{method:'POST',body:fd})
      .then(function(r){return r.json();})
      .then(function(res){
        if(res && res.success && res.data && res.data.seats){
          res.data.seats.forEach(function(s){
            var btn = document.querySelector('.bk-seat[data-seat=\"'+s+'\"]');
            if(btn){
              btn.classList.add('is-booked');
              btn.disabled = true;
            }
          });
        }
      })
      .catch(function(e){console.error('loadReserved error',e);});
  }

  // Submit
  function bkHandleSubmit(){
    var resultEl = document.getElementById('bk-result');
    if(!window.bookingSeats.length){
      if(resultEl) resultEl.textContent = 'Vui lòng chọn ghế.';
      return;
    }
    var dateEl = document.getElementById('bk-sum-date');
    var timeEl = document.getElementById('bk-sum-time');
    var methodEl = document.getElementById('bk-method');
    if(!dateEl || !timeEl) return;

    var payload = {
      action:'create_ticket_order',
      nonce: window.BOOKING_AJAX.nonce,
      movie_id: <?php echo (int)$movie_id;?>,
      cinema_id: <?php echo (int)$cinema_id;?>,
      date: dateEl.textContent.trim(),
      time: timeEl.textContent.trim(),
      seats: window.bookingSeats,
      total: window.bookingSeats.length * window.bookingPrice,
      method: methodEl ? methodEl.value : 'pay_later'
    };
    var fd = new FormData();
    Object.keys(payload).forEach(function(k){
      if(Array.isArray(payload[k])){
        payload[k].forEach(function(v){fd.append(k+'[]',v);});
      }else{
        fd.append(k,payload[k]);
      }
    });

    var btn = document.getElementById('bk-submit');
    if(btn){btn.disabled=true;btn.textContent='Đang xử lý...';}

    fetch(window.BOOKING_AJAX.url,{method:'POST',body:fd})
      .then(function(r){return r.json();})
      .then(function(res){
        if(btn){btn.disabled=false;btn.textContent='Thanh toán';}
        if(res.success){
          if(res.data && res.data.redirect){window.location.href=res.data.redirect;return;}
          if(resultEl) resultEl.textContent = res.data.message+' Mã đơn: #'+res.data.order_id;
          window.bookingSeats.forEach(function(s){
            var b = document.querySelector('.bk-seat[data-seat=\"'+s+'\"]');
            if(b){
              b.classList.remove('is-sel');
              b.classList.add('is-booked');
              b.disabled = true;
            }
          });
          window.bookingSeats=[];
          bkUpdateInfo();
        }else{
          if(resultEl) resultEl.textContent = res.data && res.data.message ? res.data.message : 'Có lỗi xảy ra.';
        }
      })
      .catch(function(e){
        if(btn){btn.disabled=false;btn.textContent='Thanh toán';}
        if(resultEl) resultEl.textContent = 'Có lỗi xảy ra: '+e.message;
        console.error('submit error',e);
      });
  }

  document.addEventListener('DOMContentLoaded',function(){
    var btn = document.getElementById('bk-submit');
    if(btn){
      btn.addEventListener('click',function(e){
        e.preventDefault();
        bkHandleSubmit();
      });
    }
    bkLoadReservedSeats();
  });
  </script>
</main>

<?php get_footer(); ?>

