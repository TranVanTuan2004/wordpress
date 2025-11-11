<?php
/**
 * Template: Lịch sử đặt vé của user (phiên bản đơn giản)
 */

if (!defined('ABSPATH')) {
    exit;
}

$current_user = wp_get_current_user();
if (!$current_user || 0 === $current_user->ID) {
    echo '<div class="slp-history-auth">Vui lòng <a href="' . esc_url(wp_login_url()) . '">đăng nhập</a> để xem lịch sử đặt vé.</div>';
    return;
}

$history = get_user_meta($current_user->ID, 'slp_booking_history', true);
if (!is_array($history) || empty($history)) {
    $history = array(
        array(
            'movie'      => 'Cục Vàng Của Ngoại',
            'cinema'     => 'CGV Aeon Bình Tân',
            'room'       => 'CINE Suite',
            'seats'      => array('G08', 'G09'),
            'date'       => '2024-11-10',
            'time'       => '20:40 - 22:39',
            'status'     => 'upcoming',
            'booking_id' => 'CB20241110-4521',
            'total'      => 320000,
        ),
        array(
            'movie'      => 'Cô Dâu Đại Chiến 5',
            'cinema'     => 'BHD Star Thảo Điền',
            'room'       => 'Phòng 04',
            'seats'      => array('C05', 'C06'),
            'date'       => '2024-10-05',
            'time'       => '18:30 - 20:20',
            'status'     => 'finished',
            'booking_id' => 'CB20241005-1187',
            'total'      => 260000,
        ),
        array(
            'movie'      => 'Biệt đội giải cứu',
            'cinema'     => 'Beta Thủ Đức',
            'room'       => 'Beta Plus',
            'seats'      => array('B03'),
            'date'       => '2024-09-12',
            'time'       => '21:15 - 23:00',
            'status'     => 'cancelled',
            'booking_id' => 'CB20240912-7632',
            'total'      => 120000,
        ),
    );
}

usort($history, function($a, $b) {
    $timeA = isset($a['date']) ? strtotime($a['date']) : 0;
    $timeB = isset($b['date']) ? strtotime($b['date']) : 0;
    return $timeB <=> $timeA;
});

$status_map = array(
    'upcoming'  => array('label' => 'Sắp chiếu',    'class' => 'upcoming'),
    'finished'  => array('label' => 'Đã xem',       'class' => 'finished'),
    'cancelled' => array('label' => 'Đã hủy',       'class' => 'cancelled'),
);

$status_counts = array(
    'upcoming'  => 0,
    'finished'  => 0,
    'cancelled' => 0,
);

foreach ($history as $booking_item) {
    $normalized_status = isset($booking_item['status'], $status_map[$booking_item['status']]) ? $booking_item['status'] : 'finished';
    if (isset($status_counts[$normalized_status])) {
        $status_counts[$normalized_status]++;
    }
}

$total_count = count($history);

?>
<section class="slp-history-simple">
    <div class="slp-history-simple__container">
    <header class="slp-history-simple__header">
        <h1>Lịch sử đặt vé</h1>
        <p>Theo dõi vé đã đặt và trạng thái xử lý của bạn.</p>
    </header>

    <div class="slp-history-simple__summary">
        <div class="summary-item">
            <span>Tổng vé</span>
            <strong data-slp-count-total><?php echo esc_html($total_count); ?></strong>
        </div>
        <div class="summary-item upcoming">
            <span>Sắp chiếu</span>
            <strong data-slp-count-upcoming><?php echo esc_html($status_counts['upcoming']); ?></strong>
        </div>
        <div class="summary-item finished">
            <span>Đã xem</span>
            <strong data-slp-count-finished><?php echo esc_html($status_counts['finished']); ?></strong>
        </div>
        <div class="summary-item cancelled">
            <span>Đã hủy</span>
            <strong data-slp-count-cancelled><?php echo esc_html($status_counts['cancelled']); ?></strong>
        </div>
    </div>

    <div class="slp-history-simple__filters">
        <label class="filter">
            <span>Trạng thái</span>
            <select data-slp-status>
                <option value="all">Tất cả</option>
                <?php foreach ($status_map as $key => $info) : ?>
                    <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($info['label']); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="filter filter--search">
            <span>Từ khóa</span>
            <input type="search" placeholder="Tìm phim, rạp hoặc mã đặt vé..." data-slp-search>
        </label>
    </div>

    <div class="slp-history-simple__list" data-slp-list>
        <?php foreach ($history as $booking) :
            $status = isset($booking['status'], $status_map[$booking['status']]) ? $booking['status'] : 'finished';
            $status_info = $status_map[$status];
            $date_display = !empty($booking['date']) ? date_i18n('d/m/Y', strtotime($booking['date'])) : '';
            $seats_array = isset($booking['seats']) ? (array) $booking['seats'] : array();
            $seats = !empty($seats_array) ? implode(', ', $seats_array) : '';
            $booking_id = isset($booking['booking_id']) ? $booking['booking_id'] : '';
            $total_raw = isset($booking['total']) ? (float) $booking['total'] : 0;
            $total_html = '—';
            if ($total_raw > 0) {
                if (function_exists('wc_price')) {
                    $total_html = call_user_func('wc_price', $total_raw);
                } else {
                    $total_html = number_format_i18n($total_raw) . '₫';
                }
            }
            $keywords = strtolower(sanitize_text_field(implode(' ', array_filter(array(
                isset($booking['movie']) ? $booking['movie'] : '',
                isset($booking['cinema']) ? $booking['cinema'] : '',
                isset($booking['room']) ? $booking['room'] : '',
                $seats,
                $booking_id,
                isset($booking['time']) ? $booking['time'] : '',
            )))));
        ?>
        <article class="history-card" data-status="<?php echo esc_attr($status); ?>" data-keywords="<?php echo esc_attr($keywords); ?>">
            <header class="history-card__header">
                <h3><?php echo esc_html(isset($booking['movie']) ? $booking['movie'] : ''); ?></h3>
                <span class="badge <?php echo esc_attr($status_info['class']); ?>"><?php echo esc_html($status_info['label']); ?></span>
            </header>
            <dl class="history-card__meta">
                <?php if ($booking_id) : ?>
                    <div>
                        <dt>Mã đặt vé</dt>
                        <dd>#<?php echo esc_html($booking_id); ?></dd>
                    </div>
                <?php endif; ?>
                <?php if (!empty($booking['cinema'])) : ?>
                    <div>
                        <dt>Rạp</dt>
                        <dd><?php echo esc_html($booking['cinema']); ?></dd>
                    </div>
                <?php endif; ?>
                <?php if (!empty($booking['room'])) : ?>
                    <div>
                        <dt>Phòng</dt>
                        <dd><?php echo esc_html($booking['room']); ?></dd>
                    </div>
                <?php endif; ?>
                <?php if ($seats) : ?>
                    <div>
                        <dt>Ghế</dt>
                        <dd><?php echo esc_html($seats); ?></dd>
                    </div>
                <?php endif; ?>
                <?php if ($date_display) : ?>
                    <div>
                        <dt>Ngày</dt>
                        <dd><?php echo esc_html($date_display); ?></dd>
                    </div>
                <?php endif; ?>
                <?php if (!empty($booking['time'])) : ?>
                    <div>
                        <dt>Giờ</dt>
                        <dd><?php echo esc_html($booking['time']); ?></dd>
                    </div>
                <?php endif; ?>
                <div>
                    <dt>Tổng tiền</dt>
                    <dd><?php echo wp_kses_post($total_html); ?></dd>
                </div>
            </dl>
            <?php if (!empty($booking['notes'])) : ?>
                <p class="history-card__notes"><?php echo esc_html($booking['notes']); ?></p>
            <?php endif; ?>
        </article>
        <?php endforeach; ?>
    </div>

    <div class="slp-history-simple__empty" data-slp-empty>Không tìm thấy vé phù hợp.</div>
    </div>
</section>

<script>
(function(){
    const container = document.querySelector('.slp-history-simple');
    if (!container) {
        return;
    }

    const list = container.querySelector('[data-slp-list]');
    const statusSelect = container.querySelector('[data-slp-status]');
    const searchInput = container.querySelector('[data-slp-search]');
    const emptyState = container.querySelector('[data-slp-empty]');
    const items = list ? Array.from(list.querySelectorAll('.history-card')) : [];

    const counters = {
        total: container.querySelector('[data-slp-count-total]'),
        upcoming: container.querySelector('[data-slp-count-upcoming]'),
        finished: container.querySelector('[data-slp-count-finished]'),
        cancelled: container.querySelector('[data-slp-count-cancelled]'),
    };

    function updateCounters(visibleItems) {
        if (counters.total) {
            counters.total.textContent = visibleItems.length;
        }

        const grouped = { upcoming: 0, finished: 0, cancelled: 0 };
        visibleItems.forEach(item => {
            const status = item.dataset.status;
            if (grouped.hasOwnProperty(status)) {
                grouped[status]++;
            }
        });

        Object.keys(grouped).forEach(key => {
            if (counters[key]) {
                counters[key].textContent = grouped[key];
            }
        });
    }

    function applyFilters() {
        const filterStatus = statusSelect ? statusSelect.value : 'all';
        const keyword = searchInput ? searchInput.value.trim().toLowerCase() : '';
        const visibleItems = [];

        items.forEach(item => {
            const matchStatus = filterStatus === 'all' || item.dataset.status === filterStatus;
            const keywords = item.dataset.keywords || '';
            const matchKeyword = keyword === '' || keywords.indexOf(keyword) !== -1;
            const isVisible = matchStatus && matchKeyword;
            item.style.display = isVisible ? '' : 'none';
            if (isVisible) {
                visibleItems.push(item);
            }
        });

        if (emptyState) {
            emptyState.style.display = visibleItems.length === 0 ? 'block' : 'none';
        }

        updateCounters(visibleItems);
    }

    if (statusSelect) {
        statusSelect.addEventListener('change', applyFilters);
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    applyFilters();
})();
</script>

<style>
.slp-history-simple {
    padding: 64px 0 80px;
    background: radial-gradient(circle at top, rgba(99, 102, 241, 0.12), transparent 55%), #f1f3ff;
    color: #1f2937;
    font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
}

.slp-history-simple__container {
    max-width: 1120px;
    margin: 0 auto;
    padding: 40px 32px 44px;
    background: rgba(255, 255, 255, 0.88);
    border-radius: 28px;
    box-shadow: 0 28px 64px rgba(79, 70, 229, 0.12);
    border: 1px solid rgba(203, 213, 225, 0.45);
    backdrop-filter: blur(4px);
}

.slp-history-simple__header h1 {
    margin: 0 0 10px;
    font-size: 28px;
    font-weight: 700;
}

.slp-history-simple__header p {
    margin: 0;
    color: #6b7280;
    font-size: 14px;
}

.slp-history-simple__summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 12px;
    margin: 28px 0;
}

.summary-item {
    background: #ffffff;
    border-radius: 12px;
    padding: 16px;
    border: 1px solid rgba(203, 213, 225, 0.6);
    box-shadow: 0 10px 18px rgba(15, 23, 42, 0.08);
}

.summary-item span {
    display: block;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #94a3b8;
}

.summary-item strong {
    display: block;
    margin-top: 6px;
    font-size: 22px;
    font-weight: 700;
}

.summary-item.upcoming strong { color: #4f46e5; }
.summary-item.finished strong { color: #059669; }
.summary-item.cancelled strong { color: #dc2626; }

.slp-history-simple__filters {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 28px;
}

.filter {
    display: flex;
    flex-direction: column;
    gap: 6px;
    min-width: 180px;
}

.filter span {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #6b7280;
}

.filter select,
.filter input {
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid rgba(203, 213, 225, 0.9);
    font-size: 14px;
    line-height: 1;
    color: #1f2937;
    background: #ffffff;
}

.filter--search {
    flex: 1;
    min-width: 220px;
}

.slp-history-simple__list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 16px;
}

.history-card {
    display: flex;
    flex-direction: column;
    gap: 14px;
    background: #ffffff;
    border-radius: 14px;
    padding: 18px;
    border: 1px solid rgba(203, 213, 225, 0.6);
    box-shadow: 0 14px 24px rgba(15, 23, 42, 0.08);
}

.history-card__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
}

.history-card__header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #0f172a;
}

.badge {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 8px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}

.badge.upcoming {
    background: rgba(79, 70, 229, 0.16);
    color: #4338ca;
}

.badge.finished {
    background: rgba(16, 185, 129, 0.16);
    color: #047857;
}

.badge.cancelled {
    background: rgba(239, 68, 68, 0.16);
    color: #dc2626;
}

.history-card__meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 12px;
    margin: 0;
}

.history-card__meta div {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.history-card__meta dt {
    margin: 0;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #94a3b8;
}

.history-card__meta dd {
    margin: 0;
    font-size: 14px;
    font-weight: 500;
    color: #1f2937;
    word-break: break-word;
}

.history-card__notes {
    margin: 0;
    padding: 10px 12px;
    border-radius: 10px;
    background: rgba(191, 219, 254, 0.6);
    color: #1d4ed8;
    font-size: 13px;
}

.slp-history-simple__empty {
    margin-top: 20px;
    text-align: center;
    font-size: 14px;
    color: #6b7280;
    display: none;
}

.slp-history-auth {
    padding: 40px;
    max-width: 540px;
    margin: 60px auto;
    text-align: center;
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 18px 32px rgba(15, 23, 42, 0.08);
    border: 1px solid rgba(203, 213, 225, 0.6);
    font-size: 14px;
}

.slp-history-auth a {
    color: #1f2937;
    font-weight: 600;
}

@media (max-width: 640px) {
    .slp-history-simple {
        padding: 32px 0 48px;
    }

    .slp-history-simple__container {
        padding: 28px 20px 36px;
        border-radius: 22px;
    }

    .slp-history-simple__header h1 {
        font-size: 24px;
    }

    .slp-history-simple__list {
        grid-template-columns: 1fr;
    }
}
</style>

