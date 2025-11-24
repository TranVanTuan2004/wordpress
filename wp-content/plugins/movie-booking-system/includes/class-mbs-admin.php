<?php
/**
 * Admin Panel Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class MBS_Admin {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            'Movie Booking System',
            'Đặt Vé Phim',
            'manage_options',
            'mbs-dashboard',
            array($this, 'dashboard_page'),
            'dashicons-tickets-alt',
            26
        );
        
        add_submenu_page(
            'mbs-dashboard',
            'Danh Sách Đặt Vé',
            'Đặt Vé',
            'manage_options',
            'mbs-bookings',
            array($this, 'bookings_page')
        );
        
        add_submenu_page(
            'mbs-dashboard',
            'Thống Kê',
            'Thống Kê',
            'manage_options',
            'mbs-statistics',
            array($this, 'statistics_page')
        );
        
        add_submenu_page(
            'mbs-dashboard',
            'Cài Đặt',
            'Cài Đặt',
            'manage_options',
            'mbs-settings',
            array($this, 'settings_page')
        );
    }
    
    /**
     * Enqueue admin scripts
     */
    public function admin_scripts($hook) {
        if (strpos($hook, 'mbs-') === false) {
            return;
        }
        
        wp_enqueue_style('mbs-admin-styles', MBS_PLUGIN_URL . 'assets/css/admin-style.css', array(), MBS_VERSION);
        wp_enqueue_script('mbs-admin-script', MBS_PLUGIN_URL . 'assets/js/admin-script.js', array('jquery'), MBS_VERSION, true);
    }
    
    /**
     * Dashboard page
     */
    public function dashboard_page() {
        global $wpdb;
        
        // Get statistics
        $table_bookings = $wpdb->prefix . 'mbs_bookings';
        $total_bookings = $wpdb->get_var("SELECT COUNT(*) FROM $table_bookings");
        $today_bookings = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table_bookings WHERE DATE(booking_date) = %s",
            date('Y-m-d')
        ));
        $total_revenue = $wpdb->get_var("SELECT SUM(total_price) FROM $table_bookings WHERE payment_status = 'completed'");
        $pending_bookings = $wpdb->get_var("SELECT COUNT(*) FROM $table_bookings WHERE payment_status = 'pending'");
        
        ?>
        <div class="wrap">
            <h1>Movie Booking System Dashboard</h1>
            
            <div class="mbs-dashboard-stats">
                <div class="mbs-stat-box">
                    <h3>Tổng Đặt Vé</h3>
                    <p class="mbs-stat-number"><?php echo number_format($total_bookings); ?></p>
                </div>
                
                <div class="mbs-stat-box">
                    <h3>Đặt Vé Hôm Nay</h3>
                    <p class="mbs-stat-number"><?php echo number_format($today_bookings); ?></p>
                </div>
                
                <div class="mbs-stat-box">
                    <h3>Tổng Doanh Thu</h3>
                    <p class="mbs-stat-number"><?php echo number_format($total_revenue, 0, ',', '.'); ?> VNĐ</p>
                </div>
                
                <div class="mbs-stat-box">
                    <h3>Đang Chờ Thanh Toán</h3>
                    <p class="mbs-stat-number"><?php echo number_format($pending_bookings); ?></p>
                </div>
            </div>
            
            <div class="mbs-dashboard-content">
                <h2>Đặt Vé Gần Đây</h2>
                <?php $this->recent_bookings_table(); ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * Bookings page
     */
    public function bookings_page() {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'mbs_bookings';
        $table_seats = $wpdb->prefix . 'mbs_seats';
        
        // Handle actions
        if (isset($_GET['action']) && isset($_GET['booking_id'])) {
            $booking_id = intval($_GET['booking_id']);
            
            if ($_GET['action'] == 'complete' && check_admin_referer('mbs_complete_booking_' . $booking_id)) {
                $wpdb->update(
                    $table_bookings,
                    array('payment_status' => 'completed'),
                    array('id' => $booking_id),
                    array('%s'),
                    array('%d')
                );
                echo '<div class="notice notice-success"><p>Đã cập nhật trạng thái đặt vé.</p></div>';
            }
            
            if ($_GET['action'] == 'cancel' && check_admin_referer('mbs_cancel_booking_' . $booking_id)) {
                $wpdb->update(
                    $table_bookings,
                    array('payment_status' => 'cancelled'),
                    array('id' => $booking_id),
                    array('%s'),
                    array('%d')
                );
                
                // Delete seats
                $wpdb->delete($table_seats, array('booking_id' => $booking_id), array('%d'));
                
                echo '<div class="notice notice-success"><p>Đã hủy đặt vé.</p></div>';
            }
        }
        
        // Get bookings
        $bookings = $wpdb->get_results("SELECT * FROM $table_bookings ORDER BY booking_date DESC LIMIT 50");
        
        // Kiểm tra và đảm bảo bảng mbs_seats có cột seat_code
        $table_seats = $wpdb->prefix . 'mbs_seats';
        $seat_columns = $wpdb->get_col("SHOW COLUMNS FROM $table_seats");
        $has_seat_code = in_array('seat_code', $seat_columns);
        $has_seat_number = in_array('seat_number', $seat_columns);
        
        // Nếu không có cột seat_code nhưng có seat_number, thêm cột seat_code và copy dữ liệu
        if (!$has_seat_code && $has_seat_number) {
            $wpdb->query("ALTER TABLE $table_seats ADD COLUMN seat_code VARCHAR(10) AFTER booking_id");
            $wpdb->query("UPDATE $table_seats SET seat_code = seat_number WHERE seat_code IS NULL OR seat_code = ''");
            $has_seat_code = true;
        }
        
        ?>
        <div class="wrap">
            <h1>Danh Sách Đặt Vé</h1>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Mã Đặt Vé</th>
                        <th>Khách Hàng</th>
                        <th>Email</th>
                        <th>Điện Thoại</th>
                        <th>Số Ghế</th>
                        <th>Ghế Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Đặt</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): 
                        // Lấy danh sách ghế từ bảng mbs_seats
                        $seat_list = array();
                        if ($has_seat_code || $has_seat_number) {
                            // Xác định cột nào cần query
                            $seat_column = $has_seat_code ? 'seat_code' : 'seat_number';
                            // Query tất cả các cột để đảm bảo lấy đúng
                            $seats = $wpdb->get_results($wpdb->prepare(
                                "SELECT * FROM $table_seats WHERE booking_id = %d",
                                $booking->id
                            ));
                            if ($seats && is_array($seats)) {
                                foreach ($seats as $seat) {
                                    // Kiểm tra cả 2 cột
                                    $seat_value = '';
                                    if ($has_seat_code && isset($seat->seat_code) && !empty($seat->seat_code)) {
                                        $seat_value = $seat->seat_code;
                                    } elseif ($has_seat_number && isset($seat->seat_number) && !empty($seat->seat_number)) {
                                        $seat_value = $seat->seat_number;
                                    }
                                    if (!empty($seat_value)) {
                                        $seat_list[] = $seat_value;
                                    }
                                }
                            }
                        }
                        $seat_display = !empty($seat_list) ? implode(', ', $seat_list) : '-';
                    ?>
                    <tr>
                        <td><strong><?php echo esc_html($booking->booking_code); ?></strong></td>
                        <td><?php echo esc_html($booking->customer_name); ?></td>
                        <td><?php echo esc_html($booking->customer_email); ?></td>
                        <td><?php echo esc_html($booking->customer_phone); ?></td>
                        <td><?php echo $booking->total_seats; ?></td>
                        <td><strong style="color: #ffe44d;"><?php echo esc_html($seat_display); ?></strong></td>
                        <td><?php echo number_format($booking->total_price, 0, ',', '.'); ?> VNĐ</td>
                        <td>
                            <?php
                            $status_labels = array(
                                'pending' => '<span class="mbs-status-pending">Chờ thanh toán</span>',
                                'completed' => '<span class="mbs-status-completed">Đã thanh toán</span>',
                                'cancelled' => '<span class="mbs-status-cancelled">Đã hủy</span>'
                            );
                            echo $status_labels[$booking->payment_status] ?? $booking->payment_status;
                            ?>
                        </td>
                        <td><?php echo date('d/m/Y H:i', strtotime($booking->booking_date)); ?></td>
                        <td>
                            <?php if ($booking->payment_status == 'pending'): ?>
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=mbs-bookings&action=complete&booking_id=' . $booking->id), 'mbs_complete_booking_' . $booking->id); ?>" class="button button-small">Hoàn thành</a>
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=mbs-bookings&action=cancel&booking_id=' . $booking->id), 'mbs_cancel_booking_' . $booking->id); ?>" class="button button-small" onclick="return confirm('Bạn có chắc muốn hủy đặt vé này?')">Hủy</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
    /**
     * Statistics page
     */
    public function statistics_page() {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'mbs_bookings';
        
        // Get statistics by date
        $stats_by_date = $wpdb->get_results("
            SELECT DATE(booking_date) as date, 
                   COUNT(*) as total_bookings, 
                   SUM(total_price) as total_revenue 
            FROM $table_bookings 
            WHERE booking_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY DATE(booking_date)
            ORDER BY date DESC
        ");
        
        ?>
        <div class="wrap">
            <h1>Thống Kê</h1>
            
            <h2>Doanh Thu 30 Ngày Gần Đây</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Số Đặt Vé</th>
                        <th>Doanh Thu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats_by_date as $stat): ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($stat->date)); ?></td>
                        <td><?php echo number_format($stat->total_bookings); ?></td>
                        <td><?php echo number_format($stat->total_revenue, 0, ',', '.'); ?> VNĐ</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
    /**
     * Settings page
     */
    public function settings_page() {
        if (isset($_POST['mbs_settings_submit'])) {
            check_admin_referer('mbs_settings_nonce');
            
            update_option('mbs_seat_rows', intval($_POST['mbs_seat_rows']));
            update_option('mbs_seats_per_row', intval($_POST['mbs_seats_per_row']));
            update_option('mbs_regular_seat_price', floatval($_POST['mbs_regular_seat_price']));
            update_option('mbs_vip_seat_price', floatval($_POST['mbs_vip_seat_price']));
            update_option('mbs_sweetbox_seat_price', floatval($_POST['mbs_sweetbox_seat_price']));
            
            echo '<div class="notice notice-success"><p>Đã lưu cài đặt.</p></div>';
        }
        
        $seat_rows = get_option('mbs_seat_rows', 10);
        $seats_per_row = get_option('mbs_seats_per_row', 17);
        $regular_seat_price = get_option('mbs_regular_seat_price', 70000);
        $vip_seat_price = get_option('mbs_vip_seat_price', 100000);
        $sweetbox_seat_price = get_option('mbs_sweetbox_seat_price', 150000);
        
        ?>
        <div class="wrap">
            <h1>Cài Đặt</h1>
            
            <form method="post" action="">
                <?php wp_nonce_field('mbs_settings_nonce'); ?>
                
                <table class="form-table">
                    <tr>
                        <th><label for="mbs_seat_rows">Số Hàng Ghế</label></th>
                        <td><input type="number" id="mbs_seat_rows" name="mbs_seat_rows" value="<?php echo esc_attr($seat_rows); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="mbs_seats_per_row">Số Ghế Mỗi Hàng</label></th>
                        <td><input type="number" id="mbs_seats_per_row" name="mbs_seats_per_row" value="<?php echo esc_attr($seats_per_row); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="mbs_regular_seat_price">Giá Ghế Thường (VNĐ)</label></th>
                        <td><input type="number" id="mbs_regular_seat_price" name="mbs_regular_seat_price" value="<?php echo esc_attr($regular_seat_price); ?>" class="regular-text" step="1000"></td>
                    </tr>
                    <tr>
                        <th><label for="mbs_vip_seat_price">Giá Ghế VIP (VNĐ)</label></th>
                        <td><input type="number" id="mbs_vip_seat_price" name="mbs_vip_seat_price" value="<?php echo esc_attr($vip_seat_price); ?>" class="regular-text" step="1000"></td>
                    </tr>
                    <tr>
                        <th><label for="mbs_sweetbox_seat_price">Giá Ghế Sweetbox (VNĐ)</label></th>
                        <td><input type="number" id="mbs_sweetbox_seat_price" name="mbs_sweetbox_seat_price" value="<?php echo esc_attr($sweetbox_seat_price); ?>" class="regular-text" step="1000"></td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" name="mbs_settings_submit" class="button button-primary" value="Lưu Cài Đặt">
                </p>
            </form>
        </div>
        <?php
    }
    
    /**
     * Recent bookings table
     */
    private function recent_bookings_table() {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'mbs_bookings';
        $table_seats = $wpdb->prefix . 'mbs_seats';
        
        $bookings = $wpdb->get_results("SELECT * FROM $table_bookings ORDER BY booking_date DESC LIMIT 10");
        
        // Kiểm tra cấu trúc bảng mbs_seats để biết cột nào tồn tại
        $seat_columns = $wpdb->get_col("SHOW COLUMNS FROM $table_seats");
        $has_seat_code = in_array('seat_code', $seat_columns);
        $has_seat_number = in_array('seat_number', $seat_columns);
        
        if (empty($bookings)) {
            echo '<p>Chưa có đặt vé nào.</p>';
            return;
        }
        
        ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Mã Đặt Vé</th>
                    <th>Khách Hàng</th>
                    <th>Số Ghế</th>
                    <th>Ghế Đặt</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Đặt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): 
                    // Lấy danh sách ghế từ bảng mbs_seats
                    $seat_list = array();
                    if ($has_seat_code || $has_seat_number) {
                        // Query tất cả các cột để đảm bảo lấy đúng
                        $seats = $wpdb->get_results($wpdb->prepare(
                            "SELECT * FROM $table_seats WHERE booking_id = %d",
                            $booking->id
                        ));
                        if ($seats && is_array($seats)) {
                            foreach ($seats as $seat) {
                                // Kiểm tra cả 2 cột
                                $seat_value = '';
                                if ($has_seat_code && isset($seat->seat_code) && !empty($seat->seat_code)) {
                                    $seat_value = $seat->seat_code;
                                } elseif ($has_seat_number && isset($seat->seat_number) && !empty($seat->seat_number)) {
                                    $seat_value = $seat->seat_number;
                                }
                                if (!empty($seat_value)) {
                                    $seat_list[] = $seat_value;
                                }
                            }
                        }
                    }
                    $seat_display = !empty($seat_list) ? implode(', ', $seat_list) : '-';
                ?>
                <tr>
                    <td><strong><?php echo esc_html($booking->booking_code); ?></strong></td>
                    <td><?php echo esc_html($booking->customer_name); ?></td>
                    <td><?php echo $booking->total_seats; ?></td>
                    <td><strong style="color: #ffe44d;"><?php echo esc_html($seat_display); ?></strong></td>
                    <td><?php echo number_format($booking->total_price, 0, ',', '.'); ?> VNĐ</td>
                    <td>
                        <?php
                        $status_labels = array(
                            'pending' => 'Chờ thanh toán',
                            'completed' => 'Đã thanh toán',
                            'cancelled' => 'Đã hủy'
                        );
                        echo $status_labels[$booking->payment_status] ?? $booking->payment_status;
                        ?>
                    </td>
                    <td><?php echo date('d/m/Y H:i', strtotime($booking->booking_date)); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    /**
     * Check-in page (Mục 28)
     */
    public function checkin_page() {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'mbs_bookings';
        
        // --- XỬ LÝ FORM CHECK-IN ---
        if (isset($_POST['mbs_checkin_submit']) && isset($_POST['ticket_code'])) {
            check_admin_referer('mbs_checkin_nonce');
            
            $ticket_code = sanitize_text_field($_POST['ticket_code']);
            
            // 1. Tìm vé dựa trên mã code
            $booking = $wpdb->get_row($wpdb->prepare(
                "SELECT id, payment_status, is_checked_in FROM $table_bookings WHERE booking_code = %s",
                $ticket_code
            ));
            
            if ($booking) {
                if ($booking->payment_status !== 'completed') {
                    echo '<div class="notice notice-error"><p>LỖI: Mã vé chưa được thanh toán hoặc đã bị hủy.</p></div>';
                } elseif ($booking->is_checked_in == 1) {
                    echo '<div class="notice notice-warning"><p>CẢNH BÁO: Mã vé đã được check-in trước đó!</p></div>';
                } else {
                    // 2. Cập nhật trạng thái check-in
                    $wpdb->update(
                        $table_bookings,
                        array('is_checked_in' => 1, 'checkin_time' => current_time('mysql')),
                        array('id' => $booking->id),
                        array('%d', '%s'),
                        array('%d')
                    );
                    echo '<div class="notice notice-success"><p>✅ CHECK-IN THÀNH CÔNG! Chúc quý khách xem phim vui vẻ.</p></div>';
                }
            } else {
                echo '<div class="notice notice-error"><p>LỖI: Không tìm thấy mã vé này trong hệ thống.</p></div>';
            }
        }
        
        // --- GIAO DIỆN FORM ---
        ?>
        <div class="wrap">
            <h1>Check-in Vé (Mục 28)</h1>
            <p>Vui lòng nhập mã vé hoặc quét mã QR.</p>
            
            <form method="post" action="">
                <?php wp_nonce_field('mbs_checkin_nonce'); ?>
                
                <table class="form-table">
                    <tr>
                        <th><label for="ticket_code">Mã Vé</label></th>
                        <td>
                            <input type="text" id="ticket_code" name="ticket_code" class="regular-text" required autofocus>
                            <p class="description">Nhập Mã Đặt Vé để xác nhận.</p>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" name="mbs_checkin_submit" class="button button-primary" value="Xác Nhận Check-in">
                </p>
            </form>
        </div>
        <?php
    }
}

