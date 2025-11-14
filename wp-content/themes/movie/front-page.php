<?php get_header(); ?>
      <!-- navbar -->
      <nav class="navbar">
        <ul class="menu">
          <!-- menu-left -->
          <div class="menu-left">
            <li class="menu-item">
              <a href="#">
                <i class="fas fa-map-marker-alt location-icon"></i> Chọn rạp
              </a>
              <div class="dropdown">
                <div class="dropdown-column">
                  <a href="#">Cinestar Quốc Thanh (TP.HCM)</a>
                  <a href="#">Cinestar Huế (TP. Huế)</a>
                  <a href="#">Cinestar Mỹ Tho (Đồng Tháp)</a>
                </div>
                <div class="dropdown-column">
                  <a href="#">Cinestar Hai Bà Trưng (TP.HCM)</a>
                  <a href="#">Cinestar Đà Lạt (Lâm Đồng)</a>
                  <a href="#">Cinestar Kiên Giang (An Giang)</a>
                </div>
                <div class="dropdown-column">
                  <a href="#">Cinestar Sinh Viên (TP.HCM)</a>
                  <a href="#">Cinestar Lâm Đồng (Đức Trọng)</a>
                  <a href="#">Cinestar Satra Quận 6 (TP.HCM)</a>
                </div>
              </div>
            </li>
            <li class="menu-item">
              <a href="#">
                <i class="fas fa-map-marker-alt location-icon"></i>
                Lịch chiếu</a
              >
            </li>
          </div>
          <!-- menu-right -->
          <div class="menu-right">
            <li class="menu-item"><a href="#">Khuyến mãi</a></li>
            <li class="menu-item"><a href="#">Tổ chức sự kiện</a></li>
            <li class="menu-item"><a href="#">Dịch vụ giải trí khác</a></li>
            <li class="menu-item"><a href="#">Giới thiệu</a></li>
          </div>
        </ul>
      </nav>

      <!-- slider -->
      <div class="slider">
        <div class="slides">
          <a href="#" class="active">
            <img
              src="https://api-website.cinestar.com.vn/media/MageINIC/bannerslider/chaching2.jpg"
              class="slide"
            />
            <button class="book-ticker" onclick="window.location.href=''">
              ĐẶT VÉ NGAY
            </button>
          </a>
          <a href="#">
            <img
              src="https://api-website.cinestar.com.vn/media/MageINIC/bannerslider/hoarac.jpg"
              class="slide"
            />
            <button class="book-ticker" onclick="window.location.href=''">
              ĐẶT VÉ NGAY
            </button>
          </a>
          <a href="#">
            <img
              src="https://api-website.cinestar.com.vn/media/MageINIC/bannerslider/banner-web.jpg"
              class="slide"
            />
            <button class="book-ticker" onclick="window.location.href=''">
              ĐẶT VÉ NGAY
            </button>
          </a>
          <a href="#">
            <img
              src="https://api-website.cinestar.com.vn/media/MageINIC/bannerslider/1215wx365h.jpg"
              class="slide"
            />
            <button class="book-ticker" onclick="window.location.href=''">
              ĐẶT VÉ NGAY
            </button>
          </a>
          <a href="#">
            <img
              src="https://api-website.cinestar.com.vn/media/MageINIC/bannerslider/2400wx720h_1_.jpg"
              class="slide"
            />
            <button class="book-ticker" onclick="window.location.href=''">
              ĐẶT VÉ NGAY
            </button>
          </a>
        </div>
        <button class="prev">&#10094;</button>
        <button class="next">&#10095;</button>
      </div>

      <!-- booking -->
      <div class="booking">
        <h2 class="booking-title">ĐẶT VÉ NHANH</h2>
        <!-- from-group -->
        <div class="form-group">
          <select id="cinema" class="form-select">
            <option value="">1. Chọn rạp</option>
            <option value="qt">Cinestar Quốc Thanh</option>
            <option value="hbt">Cinestar Hai Bà Trưng</option>
            <option value="hue">Cinestar Huế</option>
          </select>
        </div>

        <div class="form-group">
          <select id="cinema" class="form-select">
            <option value="">2. Chọn phim</option>
            <option value="nui-te-vong">NÚI TẾ VONG (T16)</option>
            <option value="long-dien-huong">
              TRUY TÌM LONG DIÊN HƯƠNG (T16)
            </option>
            <option value="duyen-ma">TÌNH NGƯỜI DUYÊN MA 2025 (T13) LT</option>
            <option value="lo-lem">LỌ LEM CHƠI NGẢI (T18)</option>
            <option value="thai-chieu-tai">
              QUỶ THA MA BẮT: THAI CHIÊU TÀI (T18)
            </option>
            <option value="godzilla">GODZILLA MINUS ONE (T13)</option>
            <option value="trai-tim-que">TRÁI TIM QUÊ QUẶT (T18)</option>
            <option value="quai-thu">
              QUÁI THÚ VÔ HÌNH: VÙNG ĐẤT CHẾT CHÓC (T16)
            </option>
          </select>
        </div>

        <div class="form-group">
          <select id="cinema" class="form-select">
            <option value="">3. Chọn ngày</option>
            <option value="qt">Thứ năm, 13/11</option>
            <option value="hbt">Thứ sáu, 14/11</option>
            <option value="hue">Thứ bảy, 15/11</option>
          </select>
        </div>

        <div class="form-group">
          <select id="cinema" class="form-select">
            <option value="">3. Chọn suất</option>
            <option value="1340">13:40 - 2D Standard</option>
            <option value="1550">15:50 - 2D Standard</option>
            <option value="1800">18:00 - 2D Standard</option>
            <option value="1900">19:00 - 2D Standard</option>
            <option value="2005">20:05 - 2D Standard</option>
            <option value="2040">20:40 - 2D Standard</option>
            <option value="2110">21:10 - 2D Standard</option>
            <option value="2210">22:10 - 2D Standard</option>
          </select>
        </div>

        <button class="btn-booking">ĐẶT NGAY</button>
      </div>

      <!-- movie is showing-->
      <div class="movie">
        <div class="movie-section">
          <h2 class="section-title">PHIM ĐANG CHIẾU</h2>
          <button class="nav-btn left" onclick="scrollMovies1(-1)">
            &#10094;
          </button>
          <div class="movie-carousel">
            <div class="movie-list" id="movieList1">
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Fnui-te-vong.jpg&w=1920&q=75"
                    alt="NÚI TẾ VONG"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book"><span>Đặt vé</span></button>
                    </div>
                  </div>
                </div>
              </a>
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Ftruy-tien-long-dien-huong-poster.jpg&w=1920&q=75"
                    alt="TRUY TÌM LONG DIÊN HƯƠNG"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book"><span>Đặt vé</span></button>
                    </div>
                  </div>
                </div>
              </a>
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Fkhong-bong-tuyet-nao-trong-sach-poster.jpg&w=1920&q=75"
                    alt="KHÔNG BÔNG TUYẾT NÀO TRONG SẠCH"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book"><span>Đặt vé</span></button>
                    </div>
                  </div>
                </div>
              </a>
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Ftinh-nguoi-duyen-ma-2025.png&w=1920&q=75"
                    alt="TÌNH NGƯỜI DUYÊN MA 2025"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book"><span>Đặt vé</span></button>
                    </div>
                  </div>
                </div>
              </a>

              <!-- 4 -->
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Ftinh-nguoi-duyen-ma-2025.png&w=1920&q=75"
                    alt="TÌNH NGƯỜI DUYÊN MA 2025"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book"><span>Đặt vé</span></button>
                    </div>
                  </div>
                </div>
              </a>
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Ftinh-nguoi-duyen-ma-2025.png&w=1920&q=75"
                    alt="TÌNH NGƯỜI DUYÊN MA 2025"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book"><span>Đặt vé</span></button>
                    </div>
                  </div>
                </div>
              </a>
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Ftinh-nguoi-duyen-ma-2025.png&w=1920&q=75"
                    alt="TÌNH NGƯỜI DUYÊN MA 2025"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book"><span>Đặt vé</span></button>
                    </div>
                  </div>
                </div>
              </a>
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Ftinh-nguoi-duyen-ma-2025.png&w=1920&q=75"
                    alt="TÌNH NGƯỜI DUYÊN MA 2025"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book"><span>Đặt vé</span></button>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <button class="nav-btn right" onclick="scrollMovies1(1)">
            &#10095;
          </button>

          <button class="btn-viewmore">Xem thêm</button>
        </div>
      </div>

      <!-- movie coming soon -->
      <div class="movie coming">
        <div class="movie-section">
          <h2 class="section-title">PHIM SẮP CHIẾU</h2>
          <button class="nav-btn left" onclick="scrollMovies2(-1)">
            &#10094;
          </button>
          <div class="movie-carousel">
            <div class="movie-list" id="movieList2">
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Ftafiti.jpg&w=1920&q=75"
                    alt="NÚI TẾ VONG"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book">
                        <span>Tìm hiểu thêm</span>
                      </button>
                    </div>
                  </div>
                </div>
              </a>
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Fcuoi-vo-cho-cha-poster.png&w=1920&q=75"
                    alt="TRUY TÌM LONG DIÊN HƯƠNG"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book">
                        <span>Tìm hiểu thêm</span>
                      </button>
                    </div>
                  </div>
                </div>
              </a>
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Fanh-trai-say-xe.jpg&w=1920&q=75"
                    alt="KHÔNG BÔNG TUYẾT NÀO TRONG SẠCH"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book">
                        <span>Tìm hiểu thêm</span>
                      </button>
                    </div>
                  </div>
                </div>
              </a>
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Fanh-trai-say-xe.jpg&w=1920&q=75"
                    alt="TÌNH NGƯỜI DUYÊN MA 2025"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book">
                        <span>Tìm hiểu thêm</span>
                      </button>
                    </div>
                  </div>
                </div>
              </a>

              <!-- 4 -->
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Ftinh-nguoi-duyen-ma-2025.png&w=1920&q=75"
                    alt="TÌNH NGƯỜI DUYÊN MA 2025"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book">
                        <span>Tìm hiểu thêm</span>
                      </button>
                    </div>
                  </div>
                </div>
              </a>
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Ftinh-nguoi-duyen-ma-2025.png&w=1920&q=75"
                    alt="TÌNH NGƯỜI DUYÊN MA 2025"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book">
                        <span>Tìm hiểu thêm</span>
                      </button>
                    </div>
                  </div>
                </div>
              </a>
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Ftinh-nguoi-duyen-ma-2025.png&w=1920&q=75"
                    alt="TÌNH NGƯỜI DUYÊN MA 2025"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book">
                        <span>Tìm hiểu thêm</span>
                      </button>
                    </div>
                  </div>
                </div>
              </a>
              <a href="#" class="movie-link">
                <div class="movie-card">
                  <img
                    src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2Fwysiwyg%2FPosters%2F11-2025%2Ftinh-nguoi-duyen-ma-2025.png&w=1920&q=75"
                    alt="TÌNH NGƯỜI DUYÊN MA 2025"
                  />
                  <div class="movie-overlay">
                    <h3>NÚI TẾ VONG (T16)</h3>
                    <p><i class="bx bx-purchase-tag-alt"></i> Kinh Dị</p>
                    <p><i class="bx bx-time"></i> 89 phút</p>
                    <p><i class="bx bx-world"></i> khác</p>
                    <p><i class="bx bx-message-square-dots"></i> Phụ đề</p>
                    <div class="movie-actions">
                      <button class="btn trailer">
                        <span>Xem trailer</span>
                      </button>
                      <button class="btn book">
                        <span>Tìm hiểu thêm</span>
                      </button>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <button class="nav-btn right" onclick="scrollMovies2(1)">
            &#10095;
          </button>

          <button class="btn-viewmore">Xem thêm</button>
        </div>
      </div>

      <!-- promotion -->
      <div class="promotion">
        <h1>KHUYẾN MÃI</h1>
        <div class="promotion-slider">
          <button class="promotion-nav promotion-prev">&#10094;</button>
          <div class="promotion-slides">
            <div class="promotion-slide promotion-active">
              <a href="#">
                <img
                  src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2FMageINIC%2Fbannerslider%2FTHU4.jpg&w=1920&q=75"
                  alt="Happy Day"
                />
              </a>
            </div>
            <div class="promotion-slide">
              <a href="#">
                <img
                  src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2FMageINIC%2Fbannerslider%2FHSSV-2.jpg&w=1920&q=75"
                  alt="C'School"
                />
              </a>
            </div>
            <div class="promotion-slide">
              <a href="#">
                <img
                  src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2FMageINIC%2Fbannerslider%2FCTEN.jpg&w=1920&q=75"
                  alt="Happy Hour"
                />
              </a>
            </div>
            <div class="promotion-slide">
              <a href="#">
                <img
                  src="https://cinestar.com.vn/_next/image/?url=https%3A%2F%2Fapi-website.cinestar.com.vn%2Fmedia%2FMageINIC%2Fbannerslider%2FMONDAY_1.jpg&w=1920&q=75"
                  alt="Monday Deal"
                />
              </a>
            </div>
          </div>
          <button class="promotion-nav promotion-next">&#10095;</button>
        </div>
        <button class="btn-viewmore">Tất cả khuyến mãi</button>
      </div>
    </div>

    <!-- membership -->
    <div class="membership">
      <div class="overlay">
        <h2>CHƯƠNG TRÌNH THÀNH VIÊN</h2>
        <div class="cards">
          <div class="card">
            <a href="#">
              <img
                src="https://api-website.cinestar.com.vn/media/wysiwyg/CMSPage/Member/Desktop519x282_CMember.webp"
                alt="C'Friend"
              />
            </a>
            <a href="#" class="name_member">THÀNH VIÊN C'FRIEND</a>
            <p>Thẻ C'Friend mang đến nhiều ưu đãi cho thành viên mới</p>
            <button class="btn-viewmore">Tìm hiểu ngay</button>
          </div>
          <div class="card">
            <a href="#">
              <img
                src="https://api-website.cinestar.com.vn/media/wysiwyg/CMSPage/Member/c-vip.webp"
                alt="C'VIP"
              />
            </a>
            <a class="name_member" href="#">THÀNH VIÊN C'VIP</a>
            <p>
              Thẻ VIP Cinestar dành riêng cho bạn những đặc quyền chất riêng.
            </p>
            <button class="btn-viewmore">Tìm hiểu ngay</button>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <!-- entertaiment -->
      <section class="entertainment">
        <h2>DỊCH VỤ GIẢI TRÍ KHÁC</h2>
        <p>
          Cinestar không chỉ chiếu phim – chúng tôi còn mang đến nhiều mô hình
          giải trí đặc sắc khác, giúp bạn tận hưởng từng giây phút bên ngoài màn
          ảnh rộng.
        </p>
        <div class="service-grid">
          <div class="service-card">
            <a href="#">
              <img
                src="https://cinestar.com.vn/assets/images/img-service0.webp"
                alt="Kidzone"
              />
            </a>
          </div>
          <div class="service-card">
            <a href="#">
              <img
                src="https://cinestar.com.vn/assets/images/img-service1.webp"
                alt="Bowling"
              />
            </a>
          </div>
          <div class="service-card">
            <a href="#">
              <img
                src="https://cinestar.com.vn/assets/images/img-service2.webp"
                alt="Billiards"
              />
            </a>
          </div>
          <div class="service-card">
            <a href="#">
              <img
                src="https://cinestar.com.vn/assets/images/img-service3.webp"
                alt="Món ngon"
              />
            </a>
          </div>
          <div class="service-card">
            <a href="#">
              <img
                src="https://cinestar.com.vn/assets/images/img-service4.webp"
                alt="Gym"
              />
            </a>
          </div>
          <div class="service-card">
            <a href="#">
              <img
                src="https://cinestar.com.vn/assets/images/img-service5.webp"
                alt="Dalat Opera House"
              />
            </a>
          </div>
        </div>
      </section>

    </div>
    
    <!-- contact -->
    <div class="contact">
      <div class="contact-left">
        <h2>LIÊN HỆ VỚI CHÚNG TÔI</h2>
        <a href="#" class="social-button facebook">
          <img src="https://cinestar.com.vn/assets/images/ct-1.webp" alt="" />
          FACEBOOK
        </a>
        <a href="#" class="social-button zalo">
          <img src="https://cinestar.com.vn/assets/images/ct-2.webp" alt="" />
          ZALO CHAT
        </a>
      </div>

      <div class="contact-right">
        <h2>THÔNG TIN LIÊN HỆ</h2>
        <p>
          📧 <a href="mailto:cskh@cinestar.com.vn">cskh@cinestar.com.vn</a>
        </p>
        <p>📞 <a href="tel:19000085">1900 0085</a></p>
        <p>📍 <a href="#">135 Hai Bà Trưng, phường Sài Gòn, TP.HCM</a></p>

        <form>
          <input type="text" placeholder="Họ và tên" required />
          <input type="email" placeholder="Điền email" required />
          <textarea
            placeholder="Thông tin liên hệ hoặc phản ánh"
            required
          ></textarea>
          <button type="submit">Gửi</button>
        </form>
      </div>
    </div>
    <?php get_footer(); ?>
