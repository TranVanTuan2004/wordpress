<?php
/**
 * Template: Booking Form with Seat Selection
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get booked seats
$booked_seats_array = array();
if (!empty($booked_seats)) {
    foreach ($booked_seats as $seat) {
        $booked_seats_array[] = $seat->seat_number;
    }
}
?>

<div class="mbs-booking-container">
    <!-- Booking Header -->
    <div class="mbs-booking-header">
        <div class="mbs-back-btn">
            <a href="javascript:history.back()">
                <i class="dashicons dashicons-arrow-left-alt"></i> Quay lại
            </a>
        </div>
        <h1 class="mbs-booking-title">Mua vé xem phim</h1>
    </div>
    
    <!-- Movie Info Bar -->
    <div class="mbs-booking-movie-info">
        <div class="mbs-movie-poster-sm">
            <?php if (has_post_thumbnail($movie_id)) : ?>
                <?php echo get_the_post_thumbnail($movie_id, 'thumbnail'); ?>
            <?php endif; ?>
        </div>
        <div class="mbs-movie-info-text">
            <h2 class="mbs-movie-title-sm"><?php echo esc_html($movie->post_title); ?></h2>
            <div class="mbs-showtime-info">
                <span class="mbs-cinema-name"><?php echo esc_html($cinema->post_title); ?></span>
                <span class="mbs-separator">•</span>
                <span class="mbs-showtime">
                    <?php echo date('H:i - d/m/Y', strtotime($showtime_datetime)); ?>
                </span>
                <span class="mbs-separator">•</span>
                <span class="mbs-room"><?php echo esc_html($room); ?></span>
                <span class="mbs-separator">•</span>
                <span class="mbs-format-badge"><?php echo esc_html($format); ?></span>
            </div>
        </div>
    </div>
    
    <!-- Seat Selection -->
    <div class="mbs-seat-selection">
        <h3 class="mbs-section-title">Chọn ghế ngồi</h3>
        
        <!-- Screen -->
        <div class="mbs-screen-container">
            <div class="mbs-screen">MÀN HÌNH</div>
        </div>
        
        <!-- Seat Map -->
        <div class="mbs-seat-map">
            <?php
            // Generate seat layout
            $rows = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q');
            $seats_per_row = 17;
            
            // Get seat prices from settings
            $regular_price = get_option('mbs_regular_seat_price', 70000);
            $vip_price = get_option('mbs_vip_seat_price', 100000);
            $sweetbox_price = get_option('mbs_sweetbox_seat_price', 150000);
            
            // Use price from showtime if available
            if ($price) {
                $regular_price = $price;
                $vip_price = $price * 1.5;
            }
            
            foreach ($rows as $row_index => $row) :
                // Determine seat type based on row
                $seat_type = 'regular';
                $seat_price = $regular_price;
                
                if (in_array($row, array('A', 'B', 'C'))) {
                    $seat_type = 'regular';
                    $seat_price = $regular_price;
                } elseif (in_array($row, array('D', 'E', 'F', 'G', 'H', 'I'))) {
                    $seat_type = 'vip';
                    $seat_price = $vip_price;
                } else {
                    $seat_type = 'sweetbox';
                    $seat_price = $sweetbox_price;
                }
                ?>
                
                <div class="mbs-seat-row" data-row="<?php echo $row; ?>">
                    <span class="mbs-row-label"><?php echo $row; ?></span>
                    
                    <div class="mbs-seats">
                        <?php for ($i = 1; $i <= $seats_per_row; $i++) : 
                            $seat_number = $row . $i;
                            $is_booked = in_array($seat_number, $booked_seats_array);
                            $seat_class = 'mbs-seat mbs-seat-' . $seat_type;
                            
                            if ($is_booked) {
                                $seat_class .= ' mbs-seat-booked';
                            }
                            ?>
                            
                            <button 
                                class="<?php echo $seat_class; ?>"
                                data-seat="<?php echo $seat_number; ?>"
                                data-type="<?php echo $seat_type; ?>"
                                data-price="<?php echo $seat_price; ?>"
                                <?php echo $is_booked ? 'disabled' : ''; ?>>
                                <?php echo $i; ?>
                            </button>
                            
                        <?php endfor; ?>
                    </div>
                    
                    <span class="mbs-row-label"><?php echo $row; ?></span>
                </div>
                
            <?php endforeach; ?>
        </div>
        
        <!-- Seat Legend -->
        <div class="mbs-seat-legend">
            <div class="mbs-legend-item">
                <span class="mbs-seat mbs-seat-regular mbs-legend-seat"></span>
                <span class="mbs-legend-text">Ghế thường</span>
            </div>
            <div class="mbs-legend-item">
                <span class="mbs-seat mbs-seat-vip mbs-legend-seat"></span>
                <span class="mbs-legend-text">Ghế VIP</span>
            </div>
            <div class="mbs-legend-item">
                <span class="mbs-seat mbs-seat-sweetbox mbs-legend-seat"></span>
                <span class="mbs-legend-text">Ghế Sweetbox</span>
            </div>
            <div class="mbs-legend-item">
                <span class="mbs-seat mbs-seat-selected mbs-legend-seat"></span>
                <span class="mbs-legend-text">Ghế bạn chọn</span>
            </div>
            <div class="mbs-legend-item">
                <span class="mbs-seat mbs-seat-booked mbs-legend-seat"></span>
                <span class="mbs-legend-text">Đã đặt</span>
            </div>
        </div>
    </div>
    
    <!-- Booking Summary -->
    <div class="mbs-booking-summary">
        <div class="mbs-summary-container">
            <h3 class="mbs-summary-title">Thông tin đặt vé</h3>
            
            <div class="mbs-selected-seats">
                <label>Ghế đã chọn:</label>
                <div id="mbs-selected-seats-list" class="mbs-seats-list">
                    <span class="mbs-no-seats">Chưa chọn ghế</span>
                </div>
            </div>
            
            <div class="mbs-total-price">
                <label>Tạm tính:</label>
                <span id="mbs-total-price" class="mbs-price-value">0đ</span>
            </div>
            
            <button id="mbs-continue-btn" class="mbs-btn mbs-btn-primary mbs-btn-block" disabled>
                Tiếp tục
            </button>
        </div>
    </div>
</div>

<!-- Customer Info Modal -->
<div id="mbs-customer-modal" class="mbs-modal" style="display: none;">
    <div class="mbs-modal-content">
        <div class="mbs-modal-header">
            <h2>Thông tin khách hàng</h2>
            <button class="mbs-modal-close">&times;</button>
        </div>
        
        <form id="mbs-booking-form">
            <input type="hidden" name="showtime_id" value="<?php echo $showtime_id; ?>">
            <input type="hidden" name="seats" id="mbs-seats-input">
            
            <div class="mbs-form-group">
                <label for="customer_name">Họ và tên *</label>
                <input type="text" id="customer_name" name="customer_name" required class="mbs-form-control">
            </div>
            
            <div class="mbs-form-group">
                <label for="customer_email">Email *</label>
                <input type="email" id="customer_email" name="customer_email" required class="mbs-form-control">
            </div>
            
            <div class="mbs-form-group">
                <label for="customer_phone">Số điện thoại *</label>
                <input type="tel" id="customer_phone" name="customer_phone" required class="mbs-form-control">
            </div>
            
            <div class="mbs-booking-summary-modal">
                <div class="mbs-summary-row">
                    <span>Số ghế:</span>
                    <span id="mbs-modal-seats-count">0</span>
                </div>
                <div class="mbs-summary-row">
                    <span>Ghế:</span>
                    <span id="mbs-modal-seats-list"></span>
                </div>
                <div class="mbs-summary-row mbs-total-row">
                    <span>Tổng cộng:</span>
                    <span id="mbs-modal-total-price">0đ</span>
                </div>
            </div>
            
            <button type="submit" class="mbs-btn mbs-btn-primary mbs-btn-block">
                Xác nhận đặt vé
            </button>
        </form>
        
        <div id="mbs-booking-result" style="display: none;">
            <div class="mbs-success-message">
                <i class="dashicons dashicons-yes-alt"></i>
                <h3>Đặt vé thành công!</h3>
                <p>Mã đặt vé của bạn: <strong id="mbs-booking-code"></strong></p>
                <p>Vui lòng kiểm tra email để xem thông tin chi tiết.</p>
                <button onclick="location.reload()" class="mbs-btn mbs-btn-primary">Đặt vé khác</button>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    var selectedSeats = [];
    var showtimeId = <?php echo $showtime_id; ?>;
    
    // Seat selection
    $('.mbs-seat:not(.mbs-seat-booked)').on('click', function() {
        var seat = $(this).data('seat');
        var type = $(this).data('type');
        var price = $(this).data('price');
        
        if ($(this).hasClass('mbs-seat-selected')) {
            // Deselect
            $(this).removeClass('mbs-seat-selected');
            selectedSeats = selectedSeats.filter(function(s) {
                return s.seat_number !== seat;
            });
        } else {
            // Select
            $(this).addClass('mbs-seat-selected');
            selectedSeats.push({
                seat_number: seat,
                seat_type: type,
                seat_price: price
            });
        }
        
        updateSummary();
    });
    
    // Update summary
    function updateSummary() {
        if (selectedSeats.length === 0) {
            $('#mbs-selected-seats-list').html('<span class="mbs-no-seats">Chưa chọn ghế</span>');
            $('#mbs-total-price').text('0đ');
            $('#mbs-continue-btn').prop('disabled', true);
        } else {
            var seatsList = selectedSeats.map(function(s) {
                return '<span class="mbs-seat-tag">' + s.seat_number + '</span>';
            }).join('');
            
            var total = selectedSeats.reduce(function(sum, s) {
                return sum + parseFloat(s.seat_price);
            }, 0);
            
            $('#mbs-selected-seats-list').html(seatsList);
            $('#mbs-total-price').text(formatPrice(total));
            $('#mbs-continue-btn').prop('disabled', false);
        }
    }
    
    // Format price
    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(price).replace('₫', 'đ');
    }
    
    // Continue to customer info
    $('#mbs-continue-btn').on('click', function() {
        $('#mbs-seats-input').val(JSON.stringify(selectedSeats));
        
        // Update modal summary
        $('#mbs-modal-seats-count').text(selectedSeats.length);
        $('#mbs-modal-seats-list').text(selectedSeats.map(s => s.seat_number).join(', '));
        $('#mbs-modal-total-price').text($('#mbs-total-price').text());
        
        // Show modal
        $('#mbs-customer-modal').fadeIn();
    });
    
    // Close modal
    $('.mbs-modal-close').on('click', function() {
        $('#mbs-customer-modal').fadeOut();
    });
    
    // Submit booking
    $('#mbs-booking-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = {
            action: 'mbs_create_booking',
            nonce: mbs_ajax.nonce,
            showtime_id: showtimeId,
            customer_name: $('#customer_name').val(),
            customer_email: $('#customer_email').val(),
            customer_phone: $('#customer_phone').val(),
            seats: $('#mbs-seats-input').val()
        };
        
        // Disable submit button
        $('#mbs-booking-form button[type="submit"]').prop('disabled', true).text('Đang xử lý...');
        
        $.ajax({
            url: mbs_ajax.ajax_url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#mbs-booking-form').hide();
                    $('#mbs-booking-code').text(response.data.booking_code);
                    $('#mbs-booking-result').fadeIn();
                } else {
                    alert(response.data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
                    $('#mbs-booking-form button[type="submit"]').prop('disabled', false).text('Xác nhận đặt vé');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
                $('#mbs-booking-form button[type="submit"]').prop('disabled', false).text('Xác nhận đặt vé');
            }
        });
    });
    
    // Auto-refresh booked seats every 30 seconds
    setInterval(function() {
        $.ajax({
            url: mbs_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'mbs_get_booked_seats',
                nonce: mbs_ajax.nonce,
                showtime_id: showtimeId
            },
            success: function(response) {
                if (response.success) {
                    var bookedSeats = response.data.booked_seats;
                    
                    // Update seat status
                    $('.mbs-seat').each(function() {
                        var seat = $(this).data('seat');
                        if (bookedSeats.includes(seat) && !$(this).hasClass('mbs-seat-selected')) {
                            $(this).addClass('mbs-seat-booked').prop('disabled', true);
                        }
                    });
                }
            }
        });
    }, 30000);
});
</script>

