<?php
/**
 * Template: Movie Detail with Showtimes
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="mbs-movie-detail-container">
    <div class="mbs-movie-detail-header">
        <div class="mbs-movie-detail-poster">
            <?php if (has_post_thumbnail($movie->ID)) : ?>
                <?php echo get_the_post_thumbnail($movie->ID, 'large'); ?>
            <?php endif; ?>
        </div>
        
        <div class="mbs-movie-detail-info">
            <h1 class="mbs-detail-title"><?php echo esc_html($movie->post_title); ?></h1>
            
            <?php if ($rating) : ?>
                <span class="mbs-detail-rating-badge"><?php echo esc_html($rating); ?></span>
            <?php endif; ?>
            
            <div class="mbs-detail-meta">
                <?php if ($duration) : ?>
                    <div class="mbs-meta-item">
                        <strong>Thời lượng:</strong> <?php echo $duration; ?> phút
                    </div>
                <?php endif; ?>
                
                <?php if ($director) : ?>
                    <div class="mbs-meta-item">
                        <strong>Đạo diễn:</strong> <?php echo esc_html($director); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($actors) : ?>
                    <div class="mbs-meta-item">
                        <strong>Diễn viên:</strong> <?php echo esc_html($actors); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($language) : ?>
                    <div class="mbs-meta-item">
                        <strong>Ngôn ngữ:</strong> <?php echo esc_html($language); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="mbs-detail-description">
                <h3>Nội dung phim</h3>
                <?php echo wpautop($movie->post_content); ?>
            </div>
            
            <?php if ($trailer_url) : ?>
                <div class="mbs-trailer">
                    <a href="<?php echo esc_url($trailer_url); ?>" target="_blank" class="mbs-btn mbs-btn-secondary">
                        <i class="dashicons dashicons-video-alt3"></i> Xem Trailer
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="mbs-showtimes-section">
        <h2 class="mbs-section-title">Lịch Chiếu & Đặt Vé</h2>
        
        <?php if (!empty($showtimes)) : ?>
            
            <?php foreach ($showtimes as $cinema_id => $cinema_data) : ?>
                <div class="mbs-cinema-showtimes">
                    <div class="mbs-cinema-header">
                        <h3 class="mbs-cinema-name">
                            <i class="dashicons dashicons-location"></i>
                            <?php echo esc_html($cinema_data['cinema']->post_title); ?>
                        </h3>
                        <?php
                        $address = get_post_meta($cinema_id, '_mbs_address', true);
                        if ($address) :
                        ?>
                            <p class="mbs-cinema-address"><?php echo esc_html($address); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mbs-dates-showtimes">
                        <?php foreach ($cinema_data['dates'] as $date => $times) : ?>
                            <div class="mbs-date-group">
                                <div class="mbs-date-label">
                                    <span class="mbs-date-day">
                                        <?php 
                                        $date_obj = new DateTime($date);
                                        echo $date_obj->format('d/m');
                                        ?>
                                    </span>
                                    <span class="mbs-date-weekday">
                                        <?php
                                        $weekdays = array('CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7');
                                        echo $weekdays[$date_obj->format('w')];
                                        ?>
                                    </span>
                                </div>
                                
                                <div class="mbs-time-slots">
                                    <?php foreach ($times as $showtime) : ?>
                                        <a href="<?php echo esc_url(add_query_arg('showtime_id', $showtime['id'], home_url('/dat-ve/'))); ?>" 
                                           class="mbs-time-slot">
                                            <span class="mbs-time"><?php echo $showtime['time']; ?></span>
                                            <span class="mbs-format-badge"><?php echo esc_html($showtime['format']); ?></span>
                                            <span class="mbs-price"><?php echo number_format($showtime['price'], 0, ',', '.'); ?>đ</span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
        <?php else : ?>
            <p class="mbs-no-showtimes">Hiện tại chưa có lịch chiếu cho phim này.</p>
        <?php endif; ?>
    </div>
</div>

