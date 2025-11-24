<?php
/**
 * Template Name: Order Success
 */
get_header();

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$wc_order_id = isset($_GET['wc_order_id']) ? intval($_GET['wc_order_id']) : 0;

// Ưu tiên lấy từ WooCommerce order nếu có
$ticket_order_id = 0;
if ($wc_order_id && class_exists('WooCommerce')) {
    $wc_order = wc_get_order($wc_order_id);
    if ($wc_order) {
        // Lấy ticket_order_id từ WooCommerce order meta
        $ticket_order_id = $wc_order->get_meta('_ticket_order_id');
        if (!$ticket_order_id) {
            // Nếu chưa có ticket_order, có thể order vừa được tạo, đợi một chút
            // Hoặc hiển thị thông tin từ WooCommerce order
            $order_id = $wc_order_id;
        }
    }
}

// Nếu không có ticket_order_id, dùng order_id từ GET
if (!$ticket_order_id && $order_id) {
    $ticket_order_id = $order_id;
}

$order = $ticket_order_id ? get_post($ticket_order_id) : null;
?>
<main class="os-page" style="min-height: 100vh; background: linear-gradient(to bottom, #8e2de2, #4a00e0, #00c6ff); background-attachment: fixed; background-repeat: no-repeat; background-size: cover; padding: 40px 20px;">
  <div class="os-container">
    <h1 class="os-title">Đặt vé thành công</h1>
    <?php if ($order && $order->post_type === 'ticket_order'): ?>
      <div class="os-card">
        <div class="os-body">
          <?php echo movie_render_order_summary($ticket_order_id); ?>
          <p><a class="os-btn" href="<?php echo esc_url( home_url('/') ); ?>">Về trang chủ</a></p>
        </div>
      </div>
    <?php elseif ($wc_order_id && class_exists('WooCommerce')): ?>
      <?php 
      $wc_order = wc_get_order($wc_order_id);
      if ($wc_order): ?>
        <div class="os-card">
          <div class="os-body">
            <p style="color: #86efac; font-size: 18px; margin-bottom: 20px;">
              ✓ Thanh toán thành công! Đơn hàng #<?php echo esc_html($wc_order->get_order_number()); ?>
            </p>
            <p style="color: #94a3b8; margin-bottom: 20px;">
              Vé của bạn đang được xử lý. Bạn sẽ nhận được email xác nhận trong giây lát.
            </p>
            <p><a class="os-btn" href="<?php echo esc_url( home_url('/') ); ?>">Về trang chủ</a></p>
          </div>
        </div>
      <?php else: ?>
        <div class="os-card"><div class="os-body">Không tìm thấy đơn hàng.</div></div>
      <?php endif; ?>
    <?php else: ?>
      <div class="os-card"><div class="os-body">Không tìm thấy đơn vé.</div></div>
    <?php endif; ?>
  </div>
  <style>
    .os-container{max-width:900px;margin:0 auto;padding:24px 16px;color:#fff}
    .os-title{margin:0 0 16px;font-size:28px;font-weight:800;color:#fff}
    .os-card{background:rgba(255,255,255,.1);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.2);border-radius:14px;box-shadow:0 8px 32px rgba(0,0,0,.1)}
    .os-body{padding:16px;color:#fff}
    .os-btn{display:inline-flex;align-items:center;justify-content:center;height:40px;padding:0 14px;border-radius:10px;background:#ffe44d;color:#0e1220;text-decoration:none;font-weight:800;transition:all 0.3s ease}
    .os-btn:hover{background:#ffd700;transform:translateY(-2px);box-shadow:0 4px 12px rgba(255,228,77,.3)}
  </style>
</main>
<?php get_footer(); ?>

