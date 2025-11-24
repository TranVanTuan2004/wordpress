<?php
/**
 * Booking History page component
 * Hiển thị lịch sử đặt vé của người dùng
 */

if (! is_user_logged_in()) {
    return;
}

$user = wp_get_current_user();
$user_id = $user->ID;

// Pagination settings
$items_per_page = 5;
$current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
$offset = ($current_page - 1) * $items_per_page;

// Lấy tất cả ticket orders của user
$ticket_orders_all = get_posts(array(
    'post_type' => 'ticket_order',
    'post_status' => 'publish',
    'numberposts' => -1,
    'meta_query' => array(
        array(
            'key' => 'user_id',
            'value' => $user_id,
            'compare' => '='
        )
    ),
    'orderby' => 'date',
    'order' => 'DESC'
));

// Lấy WooCommerce orders có ticket
$wc_orders_all = wc_get_orders(array(
    'customer_id' => $user_id,
    'limit' => -1,
    'meta_key' => '_is_ticket_order',
    'meta_value' => 'yes',
    'orderby' => 'date',
    'order' => 'DESC'
));

// Gộp và sắp xếp tất cả orders
$all_orders = array();

// Thêm ticket orders
foreach ($ticket_orders_all as $ticket_order) {
    $wc_order_id = get_post_meta($ticket_order->ID, 'wc_order_id', true);
    $order_date = get_the_date('U', $ticket_order->ID);
    
    if ($wc_order_id && class_exists('WooCommerce')) {
        $wc_order = wc_get_order($wc_order_id);
        if ($wc_order) {
            $order_date = $wc_order->get_date_created()->getTimestamp();
        }
    }
    
    $all_orders[] = array(
        'type' => 'ticket_order',
        'id' => $ticket_order->ID,
        'date' => $order_date,
        'data' => $ticket_order
    );
}

// Thêm WooCommerce orders chưa có ticket_order
foreach ($wc_orders_all as $wc_order) {
    $ticket_order_id = $wc_order->get_meta('_ticket_order_id');
    if (!$ticket_order_id) {
        $all_orders[] = array(
            'type' => 'wc_order',
            'id' => $wc_order->get_id(),
            'date' => $wc_order->get_date_created()->getTimestamp(),
            'data' => $wc_order
        );
    }
}

// Sắp xếp theo date (mới nhất trước)
usort($all_orders, function($a, $b) {
    return $b['date'] - $a['date'];
});

// Tính tổng số items
$total_items = count($all_orders);
$total_pages = ceil($total_items / $items_per_page);

// Lấy items cho trang hiện tại
$all_orders = array_slice($all_orders, $offset, $items_per_page);
?>
<main class="cns-profile">
  <div class="cns-profile__container">
    <aside class="cns-profile__aside">
      <div class="cns-profile__card">
        <div class="cns-profile__avatar">
          <div class="cns-profile__avatar-circle"><?php echo esc_html( strtoupper( mb_substr( $user->display_name ?: $user->user_login, 0, 1 ) ) ); ?></div>
          <a class="cns-link--sm" href="<?php echo esc_url( get_edit_profile_url( $user->ID ) ); ?>">Thay đổi ảnh đại diện</a>
        </div>
        <div class="cns-profile__name"><?php echo esc_html( $user->display_name ?: $user->user_login ); ?></div>
        <a class="cns-profile__btn-primary" href="#">C'Friends</a>
      </div>

      <div class="cns-profile__menu">
        <a href="<?php echo esc_url( home_url('/profile') ); ?>">Thông tin khách hàng</a>
        <a href="#">Thành viên Cinestar</a>
        <a class="is-active" href="<?php echo esc_url( home_url('/profile?tab=history') ); ?>">Lịch sử mua hàng</a>
        <a href="<?php echo esc_url( wp_logout_url( home_url('/') ) ); ?>">Đăng xuất</a>
      </div>
    </aside>

    <section class="cns-profile__content">
      <h1 class="cns-title">LỊCH SỬ ĐẶT VÉ</h1>

      <?php if (empty($all_orders)) : ?>
        <div class="cns-panel">
          <p style="text-align: center; padding: 40px 20px; color: rgba(255, 255, 255, 0.7);">
            Bạn chưa có đơn đặt vé nào.
          </p>
        </div>
      <?php else : ?>
        <div class="booking-history-list">
          <?php 
          // Hiển thị orders
          foreach ($all_orders as $order_item) :
            if ($order_item['type'] === 'ticket_order') {
              $ticket_order = $order_item['data'];
              $movie_id = get_post_meta($ticket_order->ID, 'movie_id', true);
              $cinema_id = get_post_meta($ticket_order->ID, 'cinema_id', true);
              $show_date = get_post_meta($ticket_order->ID, 'show_date', true);
              $show_time = get_post_meta($ticket_order->ID, 'show_time', true);
              $seats = get_post_meta($ticket_order->ID, 'seats', true);
              $total = get_post_meta($ticket_order->ID, 'total', true);
              $wc_order_id = get_post_meta($ticket_order->ID, 'wc_order_id', true);
              $status = get_post_meta($ticket_order->ID, 'status', true);
              
              $movie_title = $movie_id ? get_the_title($movie_id) : 'N/A';
              $cinema_title = $cinema_id ? get_the_title($cinema_id) : 'N/A';
              $seats_str = is_array($seats) ? implode(', ', $seats) : $seats;
              $order_date = get_the_date('d/m/Y H:i', $ticket_order->ID);
              
              if ($wc_order_id && class_exists('WooCommerce')) {
                $wc_order = wc_get_order($wc_order_id);
                if ($wc_order) {
                  $order_date = $wc_order->get_date_created()->date_i18n('d/m/Y H:i');
                }
              }
            } else {
              // WooCommerce order
              $wc_order = $order_item['data'];
              $items = $wc_order->get_items();
              $movie_id = 0;
              $cinema_id = 0;
              $show_date = '';
              $show_time = '';
              $seats = array();
              
              foreach ($items as $item) {
                $movie_id = intval($item->get_meta('_ticket_movie_id'));
                $cinema_id = intval($item->get_meta('_ticket_cinema_id'));
                $show_date = $item->get_meta('_ticket_date');
                $show_time = $item->get_meta('_ticket_time');
                $seats = (array) $item->get_meta('_ticket_seats');
                break;
              }
              
              if (!$movie_id) continue; // Không phải ticket order
              
              $movie_title = $movie_id ? get_the_title($movie_id) : 'N/A';
              $cinema_title = $cinema_id ? get_the_title($cinema_id) : 'N/A';
              $seats_str = is_array($seats) ? implode(', ', $seats) : '';
              $order_date = $wc_order->get_date_created()->date_i18n('d/m/Y H:i');
              $total = $wc_order->get_total();
              $status = $wc_order->get_status();
            }
          ?>
            <div class="booking-history-item">
              <div class="booking-history-header">
                <div class="booking-history-movie">
                  <h3><?php echo esc_html($movie_title); ?></h3>
                  <span class="booking-history-date"><?php echo esc_html($order_date); ?></span>
                </div>
                <div class="booking-history-status status-<?php echo esc_attr($status); ?>">
                  <?php 
                  if ($order_item['type'] === 'ticket_order') {
                    $status_text = array(
                      'completed' => 'Đã thanh toán',
                      'pending' => 'Chờ thanh toán',
                      'cancelled' => 'Đã hủy'
                    );
                    echo esc_html(isset($status_text[$status]) ? $status_text[$status] : $status);
                  } else {
                    echo esc_html(wc_get_order_status_name($status));
                  }
                  ?>
                </div>
              </div>
              
              <div class="booking-history-details">
                <div class="booking-detail-row">
                  <span class="detail-label">Rạp:</span>
                  <span class="detail-value"><?php echo esc_html($cinema_title); ?></span>
                </div>
                <div class="booking-detail-row">
                  <span class="detail-label">Ngày chiếu:</span>
                  <span class="detail-value"><?php echo esc_html($show_date); ?></span>
                </div>
                <div class="booking-detail-row">
                  <span class="detail-label">Giờ chiếu:</span>
                  <span class="detail-value"><?php echo esc_html($show_time); ?></span>
                </div>
                <div class="booking-detail-row">
                  <span class="detail-label">Ghế:</span>
                  <span class="detail-value seats"><?php echo esc_html($seats_str); ?></span>
                </div>
                <div class="booking-detail-row">
                  <span class="detail-label">Tổng tiền:</span>
                  <span class="detail-value price">
                    <?php 
                    if ($order_item['type'] === 'ticket_order') {
                      echo number_format($total, 0, ',', '.') . ' ₫';
                    } else {
                      echo $wc_order->get_formatted_order_total();
                    }
                    ?>
                  </span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          
          <?php if ($total_pages > 1) : ?>
            <div class="booking-history-pagination">
              <?php
              $base_url = home_url('/profile?tab=history');
              
              // Previous button
              if ($current_page > 1) :
                $prev_url = add_query_arg('paged', $current_page - 1, $base_url);
              ?>
                <a href="<?php echo esc_url($prev_url); ?>" class="pagination-btn pagination-prev">‹ Trước</a>
              <?php endif; ?>
              
              <?php
              // Page numbers
              $start_page = max(1, $current_page - 2);
              $end_page = min($total_pages, $current_page + 2);
              
              if ($start_page > 1) :
                $first_url = add_query_arg('paged', 1, $base_url);
              ?>
                <a href="<?php echo esc_url($first_url); ?>" class="pagination-number">1</a>
                <?php if ($start_page > 2) : ?>
                  <span class="pagination-dots">...</span>
                <?php endif; ?>
              <?php endif; ?>
              
              <?php for ($i = $start_page; $i <= $end_page; $i++) : 
                $page_url = $i == 1 ? $base_url : add_query_arg('paged', $i, $base_url);
              ?>
                <a href="<?php echo esc_url($page_url); ?>" class="pagination-number <?php echo $i == $current_page ? 'active' : ''; ?>">
                  <?php echo $i; ?>
                </a>
              <?php endfor; ?>
              
              <?php
              if ($end_page < $total_pages) :
                $last_url = add_query_arg('paged', $total_pages, $base_url);
                if ($end_page < $total_pages - 1) :
              ?>
                  <span class="pagination-dots">...</span>
                <?php endif; ?>
                <a href="<?php echo esc_url($last_url); ?>" class="pagination-number"><?php echo $total_pages; ?></a>
              <?php endif; ?>
              
              <?php
              // Next button
              if ($current_page < $total_pages) :
                $next_url = add_query_arg('paged', $current_page + 1, $base_url);
              ?>
                <a href="<?php echo esc_url($next_url); ?>" class="pagination-btn pagination-next">Sau ›</a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </section>
  </div>

  <style>
    .cns-profile{background:linear-gradient(180deg, rgba(10,10,40,0.00) 0%, rgba(7,30,61,0.25) 100%);color:inherit;min-height:calc(100vh - 120px)}
    .cns-profile__container{max-width:1200px;margin:0 auto;padding:24px 16px;display:grid;grid-template-columns:280px 1fr;gap:20px}

    .cns-profile__aside{position:static;top:auto;height:auto}
    .cns-profile__card{background:rgba(7,30,61,.65);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:16px;display:grid;gap:10px}
    .cns-profile__avatar{display:flex;align-items:center;gap:10px}
    .cns-profile__avatar-circle{width:44px;height:44px;border-radius:50%;background:#6f45c4;display:flex;align-items:center;justify-content:center;font-weight:900}
    .cns-profile__name{font-weight:800}
    .cns-profile__btn-primary{display:inline-block;text-align:center;background:#ffe44d;color:#0e1220;font-weight:800;border-radius:10px;padding:10px 12px;text-decoration:none}

    .cns-profile__menu{margin-top:12px;background:rgba(7,30,61,.65);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.14);border-radius:12px;display:grid}
    .cns-profile__menu a{padding:12px 14px;text-decoration:none;color:#e9eef7;border-bottom:1px solid rgba(255,255,255,.06)}
    .cns-profile__menu a:last-child{border-bottom:none}
    .cns-profile__menu a.is-active{background:rgba(255,255,255,.06);font-weight:800;border-left:3px solid #ffe44d;padding-left:11px}

    .cns-title{font-size:26px;font-weight:900;letter-spacing:.04em;margin:4px 0 14px;color:#ffffff}
    
    .booking-history-list{display:flex;flex-direction:column;gap:16px}
    .booking-history-item{background:rgba(7,30,61,.65);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:20px;box-shadow:0 10px 28px rgba(0,0,0,.25)}
    
    .booking-history-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;padding-bottom:16px;border-bottom:1px solid rgba(255,255,255,.1)}
    .booking-history-movie h3{margin:0 0 8px 0;font-size:20px;font-weight:800;color:#ffffff}
    .booking-history-date{color:rgba(255,255,255,.6);font-size:14px}
    
    .booking-history-status{padding:6px 12px;border-radius:8px;font-size:13px;font-weight:700}
    .booking-history-status.status-completed{background:rgba(34,197,94,.2);color:#4ade80;border:1px solid rgba(34,197,94,.3)}
    .booking-history-status.status-pending{background:rgba(251,191,36,.2);color:#fbbf24;border:1px solid rgba(251,191,36,.3)}
    .booking-history-status.status-cancelled{background:rgba(239,68,68,.2);color:#f87171;border:1px solid rgba(239,68,68,.3)}
    
    .booking-history-details{display:grid;gap:12px;margin-bottom:16px}
    .booking-detail-row{display:flex;gap:12px}
    .detail-label{font-weight:700;color:rgba(255,255,255,.8);min-width:100px}
    .detail-value{color:#ffffff;flex:1}
    .detail-value.seats{color:#ffe44d;font-weight:700}
    .detail-value.price{color:#4ade80;font-weight:800;font-size:16px}
    
    .booking-history-pagination{display:flex;justify-content:center;align-items:center;gap:8px;margin-top:32px;flex-wrap:wrap}
    .pagination-btn,.pagination-number{display:inline-flex;align-items:center;justify-content:center;min-width:40px;height:40px;padding:8px 12px;background:rgba(7,30,61,.65);border:1px solid rgba(255,255,255,.14);border-radius:8px;color:#e9eef7;text-decoration:none;font-weight:700;transition:all 0.3s;backdrop-filter:blur(6px)}
    .pagination-btn:hover,.pagination-number:hover{background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.25);color:#ffffff}
    .pagination-number.active{background:#ffe44d;color:#0e1220;border-color:#ffe44d;box-shadow:0 4px 12px rgba(255,228,77,.3)}
    .pagination-dots{color:rgba(255,255,255,.5);padding:0 4px}

    @media (max-width:960px){
      .cns-profile__container{grid-template-columns:1fr}
      .cns-profile__aside{position:static}
      .booking-history-header{flex-direction:column;gap:12px}
    }
  </style>
</main>

