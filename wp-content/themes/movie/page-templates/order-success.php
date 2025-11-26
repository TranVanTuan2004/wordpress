<?php
/**
 * Template Name: Order Success
 */
get_header();

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$wc_order_id = isset($_GET['wc_order_id']) ? intval($_GET['wc_order_id']) : 0;

// Try to find the ticket order ID
$ticket_order_id = 0;
$wc_order = null;

if ($wc_order_id && class_exists('WooCommerce')) {
    $wc_order = wc_get_order($wc_order_id);
    if ($wc_order) {
        $ticket_order_id = $wc_order->get_meta('_ticket_order_id');
        if (!$ticket_order_id) {
            // Fallback: use WC order ID if ticket order not created yet
            $order_id = $wc_order_id;
        }
    }
}

if (!$ticket_order_id && $order_id) {
    $ticket_order_id = $order_id;
}

// Fetch Data
$movie_title = '';
$cinema_name = '';
$show_date   = '';
$show_time   = '';
$seats       = array();
$total       = 0;
$poster_url  = '';
$booking_code = '';

if ($ticket_order_id) {
    $post_type = get_post_type($ticket_order_id);
    
    if ($post_type === 'ticket_order') {
        $movie_id  = intval(get_post_meta($ticket_order_id, 'movie_id', true));
        $cinema_id = intval(get_post_meta($ticket_order_id, 'cinema_id', true));
        $show_date = get_post_meta($ticket_order_id, 'show_date', true);
        $show_time = get_post_meta($ticket_order_id, 'show_time', true);
        $seats     = (array) get_post_meta($ticket_order_id, 'seats', true);
        $total     = floatval(get_post_meta($ticket_order_id, 'total', true));
        
        $movie_title = get_the_title($movie_id);
        $cinema_name = get_the_title($cinema_id);
        $poster_url  = get_the_post_thumbnail_url($movie_id, 'large');
        $booking_code = '#' . $ticket_order_id;
    } 
    elseif ($wc_order) {
        // Fallback to WC Order Data if ticket_order post doesn't exist yet
        foreach ($wc_order->get_items() as $item) {
            if ($item->get_meta('_ticket_movie_id')) {
                $movie_id  = intval($item->get_meta('_ticket_movie_id'));
                $cinema_id = intval($item->get_meta('_ticket_cinema_id'));
                $show_date = $item->get_meta('_ticket_date');
                $show_time = $item->get_meta('_ticket_time');
                $seats     = (array) $item->get_meta('_ticket_seats');
                
                $movie_title = get_the_title($movie_id);
                $cinema_name = get_the_title($cinema_id);
                $poster_url  = get_the_post_thumbnail_url($movie_id, 'large');
                break;
            }
        }
        $total = $wc_order->get_total();
        $booking_code = '#' . $wc_order->get_order_number();
    }
}

// Default poster if missing
if (!$poster_url) {
    $poster_url = 'https://via.placeholder.com/400x600?text=No+Poster';
}
?>

<main class="os-page">
  <div class="os-overlay"></div>
  
  <div class="os-container">
    <?php if ($movie_title): ?>
        <div class="os-card">
            <div class="os-header">
                <div class="os-icon-circle">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <h1 class="os-title">Đặt vé thành công!</h1>
                <p class="os-subtitle">Cảm ơn bạn đã sử dụng dịch vụ. Vé của bạn đã được xác nhận.</p>
            </div>

            <div class="os-content">
                <div class="os-poster">
                    <img src="<?php echo esc_url($poster_url); ?>" alt="<?php echo esc_attr($movie_title); ?>">
                </div>
                
                <div class="os-details">
                    <div class="os-info-group">
                        <label>Mã đơn hàng</label>
                        <div class="os-value highlight"><?php echo esc_html($booking_code); ?></div>
                    </div>

                    <div class="os-info-group">
                        <label>Phim</label>
                        <div class="os-value movie-name"><?php echo esc_html($movie_title); ?></div>
                    </div>

                    <div class="os-grid-2">
                        <div class="os-info-group">
                            <label>Rạp chiếu</label>
                            <div class="os-value"><?php echo esc_html($cinema_name); ?></div>
                        </div>
                        <div class="os-info-group">
                            <label>Suất chiếu</label>
                            <div class="os-value">
                                <?php echo date('d/m/Y', strtotime($show_date)); ?> - <?php echo esc_html($show_time); ?>
                            </div>
                        </div>
                    </div>

                    <div class="os-info-group">
                        <label>Ghế đã chọn</label>
                        <div class="os-seats">
                            <?php foreach ($seats as $seat): ?>
                                <span class="os-seat-badge"><?php echo esc_html($seat); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="os-divider"></div>

                    <div class="os-total-row">
                        <label>Tổng thanh toán</label>
                        <div class="os-total-price"><?php echo number_format($total, 0, ',', '.'); ?>đ</div>
                    </div>
                    
                    <div class="os-qr">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode('ORDER:' . $booking_code); ?>" alt="QR Code">
                        <p>Quét mã này tại quầy vé</p>
                    </div>
                </div>
            </div>

            <div class="os-actions">
                <a href="<?php echo home_url('/'); ?>" class="os-btn os-btn-primary">Về trang chủ</a>
                <a href="<?php echo home_url('/profile'); ?>" class="os-btn os-btn-secondary">Lịch sử đặt vé</a>
            </div>
        </div>
    <?php else: ?>
        <div class="os-card os-card-empty">
            <div class="os-header">
                <h1 class="os-title">Không tìm thấy đơn hàng</h1>
                <p class="os-subtitle">Có vẻ như đơn hàng không tồn tại hoặc đã xảy ra lỗi.</p>
                <a href="<?php echo home_url('/'); ?>" class="os-btn os-btn-primary" style="margin-top: 20px;">Về trang chủ</a>
            </div>
        </div>
    <?php endif; ?>
  </div>
</main>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

.os-page {
    min-height: 100vh;
    background-color: #0f172a;
    background-image: 
        radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(236, 72, 153, 0.15) 0px, transparent 50%);
    font-family: 'Inter', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    position: relative;
    overflow: hidden;
}

.os-container {
    width: 100%;
    max-width: 900px;
    position: relative;
    z-index: 10;
}

.os-card {
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.os-header {
    text-align: center;
    padding: 40px 40px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.os-icon-circle {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 10px 20px rgba(34, 197, 94, 0.3);
    animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.2s both;
}

.os-icon-circle svg {
    width: 32px;
    height: 32px;
    color: white;
}

.os-title {
    font-size: 32px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 8px;
    letter-spacing: -0.02em;
}

.os-subtitle {
    color: #94a3b8;
    font-size: 16px;
    margin: 0;
}

.os-content {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 40px;
    padding: 40px;
}

.os-poster {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    aspect-ratio: 2/3;
}

.os-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.os-details {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.os-info-group label {
    display: block;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #94a3b8;
    margin-bottom: 6px;
    font-weight: 600;
}

.os-value {
    font-size: 16px;
    color: #e2e8f0;
    font-weight: 500;
}

.os-value.highlight {
    color: #ffe44d;
    font-weight: 700;
    font-family: monospace;
    font-size: 18px;
}

.os-value.movie-name {
    font-size: 24px;
    font-weight: 700;
    color: #fff;
    line-height: 1.3;
}

.os-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.os-seats {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.os-seat-badge {
    background: rgba(99, 102, 241, 0.2);
    color: #818cf8;
    border: 1px solid rgba(99, 102, 241, 0.3);
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
}

.os-divider {
    height: 1px;
    background: rgba(255, 255, 255, 0.1);
    margin: 10px 0;
}

.os-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.os-total-price {
    font-size: 28px;
    font-weight: 800;
    color: #ffe44d;
}

.os-qr {
    margin-top: auto;
    display: flex;
    align-items: center;
    gap: 16px;
    background: rgba(15, 23, 42, 0.5);
    padding: 12px;
    border-radius: 12px;
    border: 1px dashed rgba(255, 255, 255, 0.15);
}

.os-qr img {
    width: 60px;
    height: 60px;
    border-radius: 4px;
}

.os-qr p {
    margin: 0;
    font-size: 13px;
    color: #94a3b8;
    line-height: 1.4;
}

.os-actions {
    background: rgba(15, 23, 42, 0.3);
    padding: 24px 40px;
    display: flex;
    justify-content: flex-end;
    gap: 16px;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}

.os-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    font-size: 15px;
}

.os-btn-primary {
    background: #ffe44d;
    color: #0f172a;
    box-shadow: 0 4px 12px rgba(255, 228, 77, 0.2);
}

.os-btn-primary:hover {
    background: #ffd700;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255, 228, 77, 0.3);
}

.os-btn-secondary {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #cbd5e1;
}

.os-btn-secondary:hover {
    border-color: #fff;
    color: #fff;
    background: rgba(255, 255, 255, 0.05);
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.5); }
    to { opacity: 1; transform: scale(1); }
}

@media (max-width: 768px) {
    .os-content {
        grid-template-columns: 1fr;
        gap: 24px;
        padding: 24px;
    }
    
    .os-poster {
        max-width: 200px;
        margin: 0 auto;
    }
    
    .os-header {
        padding: 30px 20px;
    }
    
    .os-title {
        font-size: 24px;
    }
    
    .os-actions {
        flex-direction: column;
        padding: 20px;
    }
    
    .os-btn {
        width: 100%;
    }
}
</style>

<?php get_footer(); ?>
