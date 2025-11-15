<?php get_header(); ?>

      <!-- movie detail -->
      <div class="movie-detail">
        <div class="movie-poster">
          <img
            src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Fnui-te-vong.jpg&w=1920&q=75"
            alt="Núi Tế Vong Poster"
          />
        </div>

        <div class="movie-info">
          <h1>NÚI TẾ VONG (T16)</h1>
          <ul class="movie-meta">
            <li><strong>Thể loại:</strong> Kinh Dị</li>
            <li><strong>Thời lượng:</strong> 89'</li>
            <li><strong>Định dạng:</strong> 2D, Phụ Đề</li>
            <li>
              <strong>Phân loại:</strong> T16 - Phim dành cho khán giả từ đủ 16
              tuổi trở lên
            </li>
            <li><strong>Khởi chiếu:</strong> Thứ Sáu, 14/11/2025</li>
            <li>
              <strong>Diễn viên:</strong> Tào Hựu Ninh, Lưu Dĩ Hào, Viên Lễ Lâm
            </li>
          </ul>

          <div class="movie-description">
            <h2>Nội dung phim</h2>
            <p>
              Ở Đài Loan có một câu nói truyền miệng nổi tiếng về khu rừng dưới
              Núi Ngọc Sơn, rằng: “Nếu chẳng may lạc trong rừng mà thấy bóng
              người mặc áo mưa màu vàng thì tuyệt đối đừng đi theo.” Gia Minh,
              Ngọc Hân và An Vĩ là những người bạn thân trong câu lạc bộ leo núi
              ở trường đại học. Trong một chuyến leo núi, thay vì đi theo lộ
              trình ban đầu thì cả 3 lại liều lĩnh bước vào khu vực cấm đã được
              cảnh báo trong rừng và bị lạc...
            </p>
            <a href="#" class="trailer-button">🎬 Xem Trailer</a>
          </div>
        </div>
      </div>

      <!-- showtime -->
      <div class="showtime-section">
        <h2 class="section-title">LỊCH CHIẾU</h2>

        <div class="showtime-dates">
          <button class="date active">14/11 Thứ Sáu</button>
          <button class="date">15/11 Thứ Bảy</button>
          <button class="date">16/11 Chủ Nhật</button>
        </div>

        <div class="cinema">
          <h3>DANH SÁCH RẠP</h3>
          <select class="location-selector">
            <option>HỒ CHÍ MINH</option>
            <option>HÀ NỘI</option>
            <option>ĐÀ NẴNG</option>
            <option>CẦN THƠ</option>
          </select>
        </div>
      <!-- cinema-list -->
      <div class="cinema-list">
        <!-- Rạp 1 -->
        <div class="cinema-item" onclick="toggleCinema(this)">
          <div class="cinema-header">
            <span>Cinestar Quốc Thanh (TP.HCM)</span>
            <span class="arrow">▶</span>
          </div>
          <div class="cinema-detail">
            <p>📍 271 Nguyễn Trãi, Phường Nguyễn Cư Trinh, Quận 1, TP.HCM</p>
            <p><strong>Deluxe:</strong></p>
            <div class="showtimes">
              <span class="disabled">10:00</span>
              <span>16:20</span>
              <span>22:15</span>
              <span>23:59</span>
            </div>
          </div>
        </div>

        <!-- Rạp 2 -->
        <div class="cinema-item" onclick="toggleCinema(this)">
          <div class="cinema-header">
            <span>Cinestar Satra Quận 6 (TP.HCM)</span>
            <span class="arrow">▶</span>
          </div>
          <div class="cinema-detail">
            <p>📍 TTTM Satra, Đường 3/2, Quận 6, TP.HCM</p>
            <p><strong>Standard:</strong></p>
            <div class="showtimes">
              <span>11:00</span>
              <span>17:30</span>
              <span>20:00</span>
            </div>
          </div>
        </div>

        <!-- Rạp 3 -->
        <div class="cinema-item" onclick="toggleCinema(this)">
          <div class="cinema-header">
            <span>Cinestar Hai Bà Trưng (TP.HCM)</span>
            <span class="arrow">▶</span>
          </div>
          <div class="cinema-detail">
            <p>📍 135 Hai Bà Trưng, Quận 1, TP.HCM</p>
            <p><strong>VIP:</strong></p>
            <div class="showtimes">
              <span>12:00</span>
              <span>18:45</span>
              <span>21:30</span>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<?php get_footer(); ?>