<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home page</title>
    <!-- links -->
     <?php wp_head(); ?>
    <!-- <link rel="stylesheet" href="front-page.css" /> -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <?php if (is_front_page()) : ?>
  <?php
  $args = array(
      'post_type' => 'mbs_movie',
      'posts_per_page' => 5,
      'orderby' => 'date',
      'order' => 'DESC',
  );
  $movie_query = new WP_Query($args);
  if ($movie_query->have_posts()) :
      $movie_links = array();
      while ($movie_query->have_posts()) : $movie_query->the_post();
          $movie_links[] = '<a href="' . get_permalink() . '" class="movie-notice-link">' . get_the_title() . '</a>';
      endwhile;
      wp_reset_postdata();
  ?>
  <div id="movie-notice-bar">
      🎬 <strong>Phim mới:</strong> <?php echo implode(' • ', $movie_links); ?> – 
      <a href="<?php echo get_post_type_archive_link('mbs_movie'); ?>" class="movie-notice-link">
        Xem tất cả 🔥
      </a>
  </div>

  <script>
document.addEventListener("DOMContentLoaded", function () {
    const bar = document.getElementById("movie-notice-bar");

    function showNotice() {
        // Trượt xuống
        bar.style.transform = "translateY(0)";

        // Ẩn sau 12s
        setTimeout(() => {
            bar.style.transform = "translateY(-100%)";
        }, 12000);
    }

    // Hiển thị lần đầu sau 1.5s
    setTimeout(showNotice, 1500);

    // Lặp lại mỗi 17s (12s hiện + 5s tạm nghỉ)
    setInterval(showNotice, 17000);
});
</script>
  <?php endif; ?>
<?php endif; ?>

    <div class="container">
      <!-- header -->
      <div class="header">
        <a href="#" class="logo-header">
          <img
            src="https://cinestar.com.vn/_next/image/?url=%2Fassets%2Fimages%2Fheader-logo.png&w=1920&q=75"
            alt="header-logo"
          />
        </a>
        <div class="actions">
          <!--  -->
          <div class="book">
            <a href="#" class="action-ticker">ĐẶT VÉ NGAY</a>
            <a href="#" class="action-popcorn">ĐẶT BẮP NƯỚC</a>
          </div>
          <!--  -->
          <div class="action-search">
            <input
              type="search"
              name="search"
              id="search"
              placeholder="Tìm phim, rạp"
            />
            <button type="submit">
              <img
                src="https://cdn-icons-png.flaticon.com/512/149/149852.png"
                alt="search"
              />
            </button>
          </div>
          <!--  -->
          <div class="action-login">
            <a href="#">
              <img
                src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                alt=""
              />
              <p>Đăng nhập</p>
            </a>
          </div>
          <!--  -->
          <a href="#" class="action-language">
            <img
              src="https://upload.wikimedia.org/wikipedia/commons/2/21/Flag_of_Vietnam.svg"
              alt="icon language"
            />
            <p>VN</p>
            <span class="arrow-down">&#9662;</span>
            <!-- ▼ -->
          </a>
        </div>
      </div>

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
