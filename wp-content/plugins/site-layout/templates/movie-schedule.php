<?php
/**
 * Template: Lịch chiếu phim (UI mẫu)
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<section class="slp-schedule">
    <div class="slp-schedule-container">
        <header class="slp-schedule-heading">
            <div class="slp-schedule-heading-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="4" width="18" height="18" rx="4" ry="4"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                </svg>
            </div>
            <div>
                <h2 class="slp-schedule-title">Lịch chiếu phim</h2>
                <p class="slp-schedule-subtitle">Tìm rạp gần bạn và chọn suất chiếu phù hợp chỉ trong vài bước</p>
            </div>
        </header>

        <div class="slp-schedule-filters">
            <div class="slp-schedule-filter">
                <span class="slp-schedule-filter-label">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/>
                    </svg>
                    Vị trí
                </span>
                <select class="slp-schedule-select">
                    <option>Hồ Chí Minh</option>
                    <option>Hà Nội</option>
                    <option>Đà Nẵng</option>
                    <option>Cần Thơ</option>
                </select>
            </div>

            <div class="slp-schedule-filter">
                <span class="slp-schedule-filter-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="18" rx="3" ry="3"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Gần bạn
                </span>
                <button class="slp-schedule-button" type="button">
                    <span>Tìm rạp gần bạn</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div>

        <div class="slp-schedule-brands">
            <button class="slp-schedule-brand is-active">
                <span class="slp-schedule-brand-icon">⭐</span>
                <span>Tất cả</span>
            </button>
            <button class="slp-schedule-brand">
                <span class="slp-schedule-brand-icon slp-is-cgv">CGV</span>
            </button>
            <button class="slp-schedule-brand">
                <span class="slp-schedule-brand-icon slp-is-lotte">Lotte</span>
            </button>
            <button class="slp-schedule-brand">
                <span class="slp-schedule-brand-icon slp-is-galaxy">Galaxy</span>
            </button>
            <button class="slp-schedule-brand">
                <span class="slp-schedule-brand-icon slp-is-bhd">BHD</span>
            </button>
            <button class="slp-schedule-brand">
                <span class="slp-schedule-brand-icon slp-is-beta">Beta</span>
            </button>
            <button class="slp-schedule-brand">
                <span class="slp-schedule-brand-icon slp-is-cinestar">Cinestar</span>
            </button>
            <button class="slp-schedule-brand">
                <span class="slp-schedule-brand-icon slp-is-mega">Mega GS</span>
            </button>
        </div>

        <div class="slp-schedule-content">
            <aside class="slp-schedule-cinema">
                <button class="slp-schedule-cinema-item is-active">
                    <span class="slp-schedule-cinema-icon slp-is-cgv">CGV</span>
                    <span class="slp-schedule-cinema-name">CGV Aeon Bình Tân</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
                <button class="slp-schedule-cinema-item">
                    <span class="slp-schedule-cinema-icon slp-is-cgv">CGV</span>
                    <span class="slp-schedule-cinema-name">CGV Giga Mall Thủ Đức</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
                <button class="slp-schedule-cinema-item">
                    <span class="slp-schedule-cinema-icon slp-is-cgv">CGV</span>
                    <span class="slp-schedule-cinema-name">CGV Vincom Gò Vấp</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </aside>

            <div class="slp-schedule-detail">
                <div class="slp-schedule-cinema-info">
                    <h3>CGV Aeon Bình Tân</h3>
                    <p>Tầng 3, Trung tâm thương mại Aeon Mall Bình Tân, Số 1 đường số 17A, khu phố 11, phường Bình Trị Đông B...</p>
                    <a href="#" class="slp-schedule-map" aria-label="Xem bản đồ">Xem bản đồ</a>
                </div>

                <div class="slp-schedule-date">
                    <button class="slp-schedule-date-item is-active">
                        <span class="slp-schedule-date-number">10</span>
                        <span class="slp-schedule-date-label">Hôm nay</span>
                    </button>
                    <button class="slp-schedule-date-item">
                        <span class="slp-schedule-date-number">11</span>
                        <span class="slp-schedule-date-label">Thứ 3</span>
                    </button>
                    <button class="slp-schedule-date-item">
                        <span class="slp-schedule-date-number">12</span>
                        <span class="slp-schedule-date-label">Thứ 4</span>
                    </button>
                    <button class="slp-schedule-date-item">
                        <span class="slp-schedule-date-number">13</span>
                        <span class="slp-schedule-date-label">Thứ 5</span>
                    </button>
                    <button class="slp-schedule-date-item">
                        <span class="slp-schedule-date-number">14</span>
                        <span class="slp-schedule-date-label">Thứ 6</span>
                    </button>
                    <button class="slp-schedule-date-item">
                        <span class="slp-schedule-date-number">15</span>
                        <span class="slp-schedule-date-label">Thứ 7</span>
                    </button>
                    <button class="slp-schedule-date-item">
                        <span class="slp-schedule-date-number">16</span>
                        <span class="slp-schedule-date-label">Chủ nhật</span>
                    </button>
                </div>

                <div class="slp-schedule-movie">
                    <img src="https://via.placeholder.com/120x180/E91E63/fff?text=Movie" alt="Phá Đảm: Sinh Nhật Mẹ" class="slp-schedule-movie-poster">
                    <div class="slp-schedule-movie-info">
                        <span class="slp-schedule-movie-badge">16+</span>
                        <h4>Phá Đảm: Sinh Nhật Mẹ</h4>
                        <p class="slp-schedule-movie-genre">Chính Kịch, Gia Đình, Gay Cấn</p>
                        <span class="slp-schedule-movie-format">2D Phụ đề</span>
                        <div class="slp-schedule-showtimes">
                            <button class="slp-schedule-showtime">23:10 - 00:43</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Tổng thể */
.slp-schedule {
    padding: 36px 0;
    background: linear-gradient(180deg, #faf4ff 0%, #ffffff 100%);
}

.slp-schedule-container {
    max-width: 1160px;
    margin: 0 auto;
    padding: 26px 32px;
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 18px 40px rgba(145, 85, 164, 0.08);
    border: 1px solid rgba(228, 231, 236, 0.55);
}

.slp-schedule-heading {
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: center;
    text-align: center;
    margin-bottom: 18px;
}

.slp-schedule-heading-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #ff79c6, #ff4470);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    box-shadow: 0 14px 28px rgba(255, 71, 131, 0.25);
}

.slp-schedule-heading-icon svg {
    width: 16px;
    height: 16px;
}

.slp-schedule-title {
    margin: 0;
    font-size: 22px;
    font-weight: 800;
    color: #b2277f;
    letter-spacing: -0.4px;
}

.slp-schedule-subtitle {
    margin: 4px 0 0;
    font-size: 10px;
    color: #5a6473;
}

/* Bộ lọc */
.slp-schedule-filters {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 16px;
}

.slp-schedule-filter {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.slp-schedule-filter-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
    font-size: 10px;
    text-transform: uppercase;
    color: #8a93a0;
    letter-spacing: 0.08em;
}

.slp-schedule-filter-label svg {
    width: 18px;
    height: 18px;
    color: #ff579a;
}

.slp-schedule-select,
.slp-schedule-button {
    width: 100%;
    background: #ffffff;
    border: 1px solid rgba(210, 214, 223, 0.9);
    border-radius: 16px;
    padding: 8px 12px;
    font-size: 12px;
    font-weight: 600;
    color: #3d4452;
    box-shadow: 0 8px 18px rgba(163, 132, 160, 0.08);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.slp-schedule-select:focus,
.slp-schedule-button:hover {
    outline: none;
    border-color: #ff579a;
    box-shadow: 0 14px 30px rgba(255, 87, 154, 0.18);
}

.slp-schedule-button {
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
}

.slp-schedule-button svg {
    width: 18px;
    height: 18px;
}

/* Chips thương hiệu */
.slp-schedule-brands {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}

.slp-schedule-brand {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    border-radius: 999px;
    background: #ffffff;
    border: 1px solid rgba(233, 233, 240, 1);
    font-weight: 600;
    font-size: 11px;
    color: #4a4f59;
    box-shadow: 0 8px 18px rgba(175, 140, 190, 0.12);
    cursor: pointer;
    transition: all 0.2s ease;
}

.slp-schedule-brand.is-active,
.slp-schedule-brand:hover {
    border-color: rgba(255, 87, 154, 0.4);
    color: #ff579a;
    background: linear-gradient(135deg, rgba(255, 87, 154, 0.16), rgba(255, 221, 238, 0.6));
}

.slp-schedule-brand-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 26px;
    border-radius: 9px;
    font-size: 9px;
    font-weight: 700;
    color: #fff;
}

/* Layout nội dung */
.slp-schedule-content {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 18px;
}

.slp-schedule-cinema {
    background: #fef9ff;
    border: 1px solid rgba(255, 200, 230, 0.6);
    border-radius: 16px;
    padding: 10px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    max-height: 560px;
    overflow-y: auto;
}

.slp-schedule-cinema-item {
    display: grid;
    grid-template-columns: auto 1fr auto;
    align-items: center;
    gap: 8px;
    padding: 7px 10px;
    border-radius: 14px;
    border: 1px solid transparent;
    background: #ffffff;
    color: #433d47;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 5px 12px rgba(175, 140, 190, 0.08);
}

.slp-schedule-cinema-item.is-active {
    background: linear-gradient(135deg, rgba(255, 87, 154, 0.2), rgba(255, 87, 154, 0));
    border-color: rgba(255, 87, 154, 0.35);
    color: #ff2d84;
}

.slp-schedule-cinema-item svg {
    width: 14px;
    height: 14px;
    color: rgba(125, 98, 145, 0.6);
}

.slp-schedule-cinema-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 9px;
    color: #fff;
}

/* Detail pane */
.slp-schedule-detail {
    background: linear-gradient(135deg, #ffffff 0%, #f6f9ff 100%);
    border: 1px solid rgba(229, 231, 235, 0.7);
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 18px 38px rgba(175, 140, 190, 0.12);
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.slp-schedule-cinema-info h3 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: #312f35;
}

.slp-schedule-cinema-info p {
    margin: 6px 0 0;
    color: #6b7380;
    font-size: 10.5px;
}

.slp-schedule-map {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    font-weight: 600;
    font-size: 11px;
    color: #ff579a;
    text-decoration: none;
}

/* Ngày */
.slp-schedule-date {
    display: flex;
    gap: 6px;
    overflow-x: auto;
    padding-bottom: 6px;
}

.slp-schedule-date-item {
    flex: 0 0 auto;
    border-radius: 14px;
    border: 1px solid rgba(228, 229, 235, 0.9);
    background: #ffffff;
    padding: 9px 12px;
    text-align: center;
    font-weight: 600;
    font-size: 10px;
    color: #3a3f4b;
    transition: all 0.2s ease;
    min-width: 60px;
}

.slp-schedule-date-item.is-active,
.slp-schedule-date-item:hover {
    background: linear-gradient(135deg, #ff7ab8, #ff4470);
    color: #ffffff;
    border-color: transparent;
    box-shadow: 0 12px 24px rgba(255, 87, 154, 0.25);
}

.slp-schedule-date-number {
    font-size: 12px;
    display: block;
}

.slp-schedule-date-label {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Thẻ phim */
.slp-schedule-movie {
    display: grid;
    grid-template-columns: 90px 1fr;
    gap: 12px;
    padding: 12px;
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid rgba(233, 235, 240, 0.9);
    box-shadow: 0 12px 24px rgba(175, 140, 190, 0.08);
}

.slp-schedule-movie-poster {
    width: 100%;
    border-radius: 12px;
    object-fit: cover;
    background: #f4f5f8;
}

.slp-schedule-movie-info {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.slp-schedule-movie-badge {
    align-self: flex-start;
    padding: 3px 6px;
    font-size: 10px;
    font-weight: 700;
    border-radius: 999px;
    background: #2f2b36;
    color: #fff;
}

.slp-schedule-movie-info h4 {
    margin: 0;
    font-size: 12px;
    font-weight: 700;
    color: #312f35;
}

.slp-schedule-movie-genre {
    margin: 0;
    font-size: 10px;
    color: #6f7580;
}

.slp-schedule-movie-format {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 10px;
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 999px;
    background: rgba(255, 87, 154, 0.12);
    color: #ff579a;
}

.slp-schedule-showtimes {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.slp-schedule-showtime {
    padding: 5px 10px;
    border-radius: 12px;
    border: 1px solid rgba(228, 229, 235, 0.9);
    background: #ffffff;
    font-weight: 600;
    font-size: 11px;
    color: #3a3f4b;
    transition: all 0.2s ease;
}

.slp-schedule-showtime:hover {
    background: #2f2b36;
    color: #fff;
    border-color: transparent;
}
.slp-schedule-cinema-name {
    font-size: 12px !important;
}

/* Brand icon colors */
.slp-is-cgv { background: #ff4564; }
.slp-is-lotte { background: #f53b42; }
.slp-is-galaxy { background: #ffaa1d; }
.slp-is-bhd { background: #ffdd3d; color: #404040; }
.slp-is-beta { background: #558dff; }
.slp-is-cinestar { background: #ff60b1; }
.slp-is-mega { background: #ff9c3f; }

@media (max-width: 1024px) {
    .slp-schedule-container {
        padding: 22px;
    }
    .slp-schedule-content {
        grid-template-columns: 1fr;
    }
    .slp-schedule-cinema {
        flex-direction: row;
        overflow-x: auto;
    }
    .slp-schedule-cinema-item {
        min-width: 200px;
    }
}

@media (max-width: 768px) {
    .slp-schedule-container {
        padding: 20px;
    }
    .slp-schedule-filters {
        grid-template-columns: 1fr;
    }
    .slp-schedule-heading {
        flex-direction: column;
    }
}

@media (max-width: 520px) {
    .slp-schedule-container {
        padding: 16px;
    }
    .slp-schedule-title {
        font-size: 19px;
    }
    .slp-schedule-movie {
        grid-template-columns: 1fr;
    }
    .slp-schedule-movie-poster {
        max-width: 120px;
        justify-self: center;
    }
}
</style>
