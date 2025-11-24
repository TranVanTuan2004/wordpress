<?php

/**
 * Admin Panel Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class MBS_Admin
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu()
    {
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
    public function admin_scripts($hook)
    {
        if (strpos($hook, 'mbs-') === false) {
            return;
        }

        wp_enqueue_style('mbs-admin-styles', MBS_PLUGIN_URL . 'assets/css/admin-style.css', array(), MBS_VERSION);
        wp_enqueue_script('mbs-admin-script', MBS_PLUGIN_URL . 'assets/js/admin-script.js', array('jquery'), MBS_VERSION, true);
    }

    /**
     * Dashboard page
     */
    public function dashboard_page()
    {
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
    public function bookings_page()
    {
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
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Đặt</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><strong><?php echo esc_html($booking->booking_code); ?></strong></td>
                            <td><?php echo esc_html($booking->customer_name); ?></td>
                            <td><?php echo esc_html($booking->customer_email); ?></td>
                            <td><?php echo esc_html($booking->customer_phone); ?></td>
                            <td><?php echo $booking->total_seats; ?></td>
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


    public function statistics_page()
    {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'mbs_bookings';

        // --- Thống kê 30 ngày ---
        $stats_by_date = $wpdb->get_results("
    SELECT DATE(booking_date) as date, 
           SUM(total_seats) as total_bookings, -- Sửa: COUNT(*) -> SUM(total_seats)
           SUM(total_price) as total_revenue 
    FROM $table_bookings 
    WHERE booking_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    GROUP BY DATE(booking_date)
    ORDER BY date ASC
");

        // --- Chuẩn bị dữ liệu biểu đồ ---
        $chart_labels = [];
        $chart_data = [];
        foreach ($stats_by_date as $stat) {
            $chart_labels[] = date('d/m', strtotime($stat->date));
            $chart_data[]   = (int)$stat->total_revenue;
        }

        $today = date('Y-m-d');

        // --- Vé hôm nay chính xác ---
        $today_bookings = $wpdb->get_var("
    SELECT SUM(total_seats)  -- SỬA: Đếm tổng số ghế
    FROM $table_bookings 
    WHERE DATE(booking_date) = CURDATE()
");


        // --- Tổng số liệu ---
        $total_bookings = array_sum(array_column($stats_by_date, 'total_bookings'));
        $total_revenue  = array_sum(array_column($stats_by_date, 'total_revenue'));

        // --- Growth ---
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        $week_start = date('Y-m-d', strtotime('-7 days'));
        $last_week_start = date('Y-m-d', strtotime('-14 days'));
        $last_week_end = date('Y-m-d', strtotime('-7 days'));

        $total_last_week = $wpdb->get_var("
    SELECT COUNT(*) FROM $table_bookings
    WHERE DATE(booking_date) >= '$last_week_start'
    AND DATE(booking_date) < '$last_week_end'
");
        $growth_total = 0;

        // 2. Vé hôm nay vs hôm qua
        $yesterday_bookings = $wpdb->get_var("
    SELECT COUNT(*) FROM $table_bookings
    WHERE DATE(booking_date) = '$yesterday'
");
        $growth_today = $yesterday_bookings ? round((($today_bookings - $yesterday_bookings) / $yesterday_bookings) * 100) : 0;

        // 3. Doanh thu vs tuần trước
        $revenue_last_week = $wpdb->get_var("
    SELECT SUM(total_price) FROM $table_bookings
    WHERE payment_status='completed'
    AND DATE(booking_date) >= '$last_week_start'
    AND DATE(booking_date) < '$last_week_end'
");
        $growth_revenue =  0;

        // 4. Chưa thanh toán tuần này vs tuần trước
        $pending = $wpdb->get_var("
    SELECT COUNT(*) FROM $table_bookings WHERE payment_status='pending'
");
        $pending_last_week = $wpdb->get_var("
    SELECT COUNT(*) FROM $table_bookings
    WHERE payment_status='pending'
    AND DATE(booking_date) >= '$last_week_start'
    AND DATE(booking_date) < '$last_week_end'
");
        $growth_pending =  0;

        // 5. 7 ngày gần đây vs 7 ngày trước đó
        $recent = $wpdb->get_var("
    SELECT COUNT(*) FROM $table_bookings
    WHERE booking_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
");

        $recent_last_week = $wpdb->get_var("
    SELECT COUNT(*) FROM $table_bookings
    WHERE DATE(booking_date) >= DATE_SUB('$last_week_end', INTERVAL 7 DAY)
    AND DATE(booking_date) < '$last_week_end'
");
        $growth_recent =  0;





    ?>
        <div class="wrap" style="padding:20px;">

            <h1 style="margin-bottom:30px;">Thống Kê Doanh Thu & Bán Vé</h1>

            <!-- 5 box -->
            <div class="mbs-stats-container">
                <?php
                $boxes = [
                    ['title' => 'Tổng Đặt Vé', 'value' => $total_bookings, 'growth' => $growth_total, 'show_growth' => false, 'class' => 'total-bookings', 'icon' => 'dashicons-tickets-alt', 'colorStart' => '#4e54c8', 'colorEnd' => '#8f94fb'],
                    ['title' => 'Đặt Vé Hôm Nay', 'value' => $today_bookings, 'growth' => $growth_today, 'show_growth' => false, 'class' => 'today-bookings', 'icon' => 'dashicons-calendar-alt', 'colorStart' => '#00c6ff', 'colorEnd' => '#0072ff'],
                    ['title' => 'Tổng Doanh Thu', 'value' => $total_revenue, 'growth' => $growth_revenue, 'show_growth' => false, 'class' => 'total-revenue', 'icon' => 'dashicons-chart-line', 'colorStart' => '#f7971e', 'colorEnd' => '#ffd200'],
                    ['title' => 'Chưa Thanh Toán', 'value' => $pending, 'growth' => $growth_pending, 'show_growth' => false, 'class' => 'pending', 'icon' => 'dashicons-clock', 'colorStart' => '#e53935', 'colorEnd' => '#e35d5b'],
                    ['title' => 'Đặt Vé Trong Tuần', 'value' => $recent, 'growth' => $growth_recent, 'show_growth' => false, 'class' => 'recent', 'icon' => 'dashicons-analytics', 'colorStart' => '#27ae60', 'colorEnd' => '#2ecc71'],
                ];

                foreach ($boxes as $box): ?>
                    <div class="mbs-stat-box <?php echo $box['class']; ?>" style="background: linear-gradient(135deg, <?php echo $box['colorStart']; ?>, <?php echo $box['colorEnd']; ?>);">
                        <div class="mbs-box-header">
                            <i class="dashicons <?php echo $box['icon']; ?>"></i>
                            <h3><?php echo $box['title']; ?></h3>
                            <?php if ($box['show_growth']): ?>
                                <span class="mbs-growth <?php echo $box['growth'] >= 0 ? 'up' : 'down'; ?>" title="Growth">
                                    <?php echo $box['growth'] >= 0 ? "+{$box['growth']}%" : "{$box['growth']}%"; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <p class="mbs-stat-number" data-target="<?php echo $box['value']; ?>">0</p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Biểu đồ doanh thu 30 ngày -->
            <h2>Biểu Đồ</h2>
            <canvas id="revenueChart" width="100%" height="40" style="margin-bottom:40px;"></canvas>

            <!-- Bảng doanh thu 30 ngày -->
            <h2>Bảng Doanh Thu Tháng Này</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Số Đặt Vé</th>
                        <th>Doanh Thu (VNĐ)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats_by_date as $stat): ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($stat->date)); ?></td>
                            <td><?php echo number_format($stat->total_bookings); ?></td>
                            <td><?php echo number_format($stat->total_revenue, 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>

        <style>
            /* Container 5 box thống kê */
            .mbs-stats-container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                margin-bottom: 40px;
            }

            /* Box thống kê */
            .mbs-stat-box {
                flex: 1 1 180px;
                border-radius: 16px;
                padding: 25px 20px;
                text-align: center;
                font-weight: 600;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
                position: relative;
                overflow: hidden;
                transition: transform 0.3s, box-shadow 0.3s;
                color: #fff;
            }

            .mbs-stat-box:hover {
                transform: translateY(-5px) scale(1.03);
                box-shadow: 0 12px 28px rgba(0, 0, 0, 0.3);
            }

            /* Header box */
            .mbs-box-header {
                position: relative;
                margin-bottom: 15px;
            }

            .mbs-box-header i {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 40px;
                opacity: 0.2;
                pointer-events: none;
            }

            /* Box title và số liệu */
            .mbs-stat-box h3 {
                font-size: 18px;
                margin-bottom: 8px;
            }

            .mbs-stat-number {
                font-size: 28px;
                font-weight: 700;
            }

            /* Growth */
            .mbs-growth {
                cursor: pointer;
                font-size: 13px;
                font-weight: 500;
            }

            .mbs-growth.up {
                color: #00ff99;
            }

            .mbs-growth.down {
                color: #ff4d4d;
            }

            /* Biểu đồ */
            #revenueChart {
                background: #fff;
                border-radius: 16px;
                padding: 20px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
                margin-bottom: 40px;
            }

            /* Bảng doanh thu */
            /* Bảng doanh thu đồng bộ với box */
            .wp-list-table {
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 40px;
                background: #fff;
                font-weight: 500;
            }

            .wp-list-table thead th {
                color: #fff;
                font-weight: 600;
                text-align: center;
                padding: 12px 8px;
                font-size: 14px;
            }

            /* Gradient header giống box tương ứng (dùng màu primary) */
            .wp-list-table thead th:nth-child(1) {
                background: linear-gradient(135deg, #4e54c8, #8f94fb);
            }

            .wp-list-table thead th:nth-child(2) {
                background: linear-gradient(135deg, #00c6ff, #0072ff);
            }

            .wp-list-table thead th:nth-child(3) {
                background: linear-gradient(135deg, #f7971e, #ffd200);
            }

            /* Các cột khác nếu muốn đồng màu */
            .wp-list-table thead th:nth-child(4) {
                background: linear-gradient(135deg, #e53935, #e35d5b);
            }

            .wp-list-table thead th:nth-child(5) {
                background: linear-gradient(135deg, #27ae60, #2ecc71);
            }

            /* Icon nhỏ trên header (tùy chọn) */
            .wp-list-table thead th::before {
                font-family: 'Dashicons';
                display: inline-block;
                margin-right: 5px;
                font-size: 16px;
                vertical-align: middle;
                content: "\f109";
                /* ticket icon mặc định */
            }

            /* Thay icon riêng cho từng cột nếu muốn */
            .wp-list-table thead th:nth-child(1)::before {
                content: "\f183";
            }

            /* ticket-alt */
            .wp-list-table thead th:nth-child(2)::before {
                content: "\f145";
            }

            /* calendar */
            .wp-list-table thead th:nth-child(3)::before {
                content: "\f183";
            }

            /* chart-line */
            .wp-list-table thead th:nth-child(4)::before {
                content: "\f110";
            }

            /* clock */
            .wp-list-table thead th:nth-child(5)::before {
                content: "\f179";
            }

            /* analytics */

            /* Body table */
            .wp-list-table tbody td {
                text-align: center;
                padding: 10px 6px;
                font-size: 14px;
            }

            .wp-list-table tbody tr:nth-child(even) {
                background: rgba(0, 0, 0, 0.03);
            }

            .wp-list-table tbody tr:hover {
                background: rgba(0, 0, 0, 0.05);
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Animation số liệu từ 0 → target
            document.querySelectorAll('.mbs-stat-number').forEach(el => {
                let target = parseInt(el.getAttribute('data-target'));
                let count = 0;
                let step = Math.ceil(target / 100);
                let interval = setInterval(() => {
                    count += step;
                    if (count >= target) {
                        count = target;
                        clearInterval(interval);
                    }
                    el.innerText = count.toLocaleString();
                }, 15);
            });

            // Chart.js biểu đồ doanh thu
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(54,162,235,0.6)');
            gradient.addColorStop(1, 'rgba(54,162,235,0)');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($chart_labels); ?>,
                    datasets: [{
                        label: 'Doanh Thu (VNĐ)',
                        data: <?php echo json_encode($chart_data); ?>,
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: 'rgba(54,162,235,1)',
                        tension: 0.3,
                        pointBackgroundColor: '#36a2eb',
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: '#333'
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#333'
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#333'
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        }
                    }
                }
            });
        </script>
    <?php
    }
    /**
     * Settings page
     */
    public function settings_page()
    {
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
    private function recent_bookings_table()
    {
        global $wpdb;
        $table_bookings = $wpdb->prefix . 'mbs_bookings';

        $bookings = $wpdb->get_results("SELECT * FROM $table_bookings ORDER BY booking_date DESC LIMIT 10");

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
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Đặt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><strong><?php echo esc_html($booking->booking_code); ?></strong></td>
                        <td><?php echo esc_html($booking->customer_name); ?></td>
                        <td><?php echo $booking->total_seats; ?></td>
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
    public function checkin_page()
    {
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
