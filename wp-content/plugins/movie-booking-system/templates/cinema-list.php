<?php
/**
 * Template: Cinema List
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="mbs-cinema-list-container">
    <h2 class="mbs-section-title">Hệ Thống Rạp</h2>
    
    <div class="mbs-cinema-grid">
        <?php
        if (!empty($cinemas)) :
            foreach ($cinemas as $cinema) :
                $cinema_id = $cinema->ID;
                $address = get_post_meta($cinema_id, '_mbs_address', true);
                $phone = get_post_meta($cinema_id, '_mbs_phone', true);
                $total_rooms = get_post_meta($cinema_id, '_mbs_total_rooms', true);
                ?>
                
                <div class="mbs-cinema-card">
                    <?php if (has_post_thumbnail($cinema_id)) : ?>
                        <div class="mbs-cinema-image">
                            <?php echo get_the_post_thumbnail($cinema_id, 'medium'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mbs-cinema-card-content">
                        <h3 class="mbs-cinema-title">
                            <i class="dashicons dashicons-location"></i>
                            <?php echo esc_html($cinema->post_title); ?>
                        </h3>
                        
                        <?php if ($address) : ?>
                            <p class="mbs-cinema-address">
                                <strong>Địa chỉ:</strong> <?php echo esc_html($address); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ($phone) : ?>
                            <p class="mbs-cinema-phone">
                                <strong>Điện thoại:</strong> <?php echo esc_html($phone); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ($total_rooms) : ?>
                            <p class="mbs-cinema-rooms">
                                <strong>Số phòng chiếu:</strong> <?php echo esc_html($total_rooms); ?>
                            </p>
                        <?php endif; ?>
                        
                        <div class="mbs-cinema-description">
                            <?php echo wpautop($cinema->post_content); ?>
                        </div>
                    </div>
                </div>
                
            <?php endforeach; ?>
        <?php else : ?>
            <p class="mbs-no-cinemas">Chưa có rạp phim nào.</p>
        <?php endif; ?>
    </div>
</div>

<style>
.mbs-cinema-list-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.mbs-cinema-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 24px;
    margin-top: 30px;
}

.mbs-cinema-card {
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.mbs-cinema-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.mbs-cinema-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.mbs-cinema-card-content {
    padding: 20px;
}

.mbs-cinema-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 16px;
    color: #1a1a1a;
}

.mbs-cinema-title .dashicons {
    color: #c71585;
}

.mbs-cinema-card-content p {
    margin-bottom: 8px;
    color: #6b7280;
    font-size: 14px;
}

.mbs-cinema-description {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #f3f4f6;
    color: #6b7280;
    font-size: 14px;
    line-height: 1.6;
}
</style>

