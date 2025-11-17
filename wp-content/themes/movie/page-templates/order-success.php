<?php
/**
 * Template Name: Order Success
 */
get_header();

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$order    = $order_id ? get_post($order_id) : null;
?>
<main class="os-page">
  <div class="os-container">
    <h1 class="os-title">Đặt vé thành công</h1>
    <?php if ($order): ?>
      <div class="os-card">
        <div class="os-body">
          <?php echo movie_render_order_summary($order_id); ?>
          <p><a class="os-btn" href="<?php echo esc_url( home_url('/') ); ?>">Về trang chủ</a></p>
        </div>
      </div>
    <?php else: ?>
      <div class="os-card"><div class="os-body">Không tìm thấy đơn vé.</div></div>
    <?php endif; ?>
  </div>
  <style>
    .os-container{max-width:900px;margin:0 auto;padding:24px 16px;color:#e5e7eb}
    .os-title{margin:0 0 16px;font-size:28px;font-weight:800}
    .os-card{background:rgba(15,23,42,.9);border:1px solid rgba(148,163,184,.14);border-radius:14px}
    .os-body{padding:16px}
    .os-btn{display:inline-flex;align-items:center;justify-content:center;height:40px;padding:0 14px;border-radius:10px;background:#ffe44d;color:#0e1220;text-decoration:none;font-weight:800}
  </style>
</main>
<?php get_footer(); ?>

