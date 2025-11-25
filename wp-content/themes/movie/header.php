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
    <!-- may lam -->
       <?php if (is_front_page()) : ?>
  <?php
  $args = array(
      'post_type' => 'mbs_movie',
      'posts_per_page' => 3,
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
      🎬 <strong>Phim mới: &bull;  </strong> <?php echo implode('&nbsp;&bull;&nbsp; ', $movie_links); ?>
      <!-- <a href="<?php echo get_post_type_archive_link('mbs_movie'); ?>" class="movie-notice-link">
        Xem tất cả 🔥
      </a> -->
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
        }, 3000);
    }

    // Hiển thị lần đầu sau 1.5s
    setTimeout(showNotice, 1500);

    // Lặp lại mỗi 17s (12s hiện + 5s tạm nghỉ)
    setInterval(showNotice, 8000);
});
</script>
  <?php endif; ?>
<?php endif; ?>
<!--  -->


    <div class="container">
      <!-- header -->
      <div class="header">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-header">
          <img
            src="<?php echo get_template_directory_uri(); ?>/assets/images/riot-logo.png"
            alt="RIOT Cinema"
          />
        </a>
        <div class="actions" id="actions">
          <!--  -->
          <div class="book">
            <a href="<?php echo esc_url(home_url('/datve')); ?>" class="action-ticker">ĐẶT VÉ NGAY</a>
            <a href="<?php echo esc_url(home_url('/bapnuoc')); ?>" class="action-popcorn">ĐẶT BẮP NƯỚC</a>
          </div>
          <!--  -->
          <form class="action-search form-search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input
              type="search"
              name="s"
              id="search"
              placeholder="Tìm phim, rạp"
              value="<?php echo get_search_query(); ?>"
            />
            <input type="hidden" name="post_type" value="mbs_movie,mbs_cinema" />
          </form>
          <!--  -->
          <div class="action-user">
            <?php if ( is_user_logged_in() ) : ?>
              <?php
                $current_user = wp_get_current_user();
                $display_name = $current_user->display_name ? $current_user->display_name : $current_user->user_login;
                $avatar_url   = get_avatar_url( $current_user->ID, array( 'size' => 64 ) );
                $profile_page = get_page_by_path( 'profile' );
                $profile_url  = $profile_page ? get_permalink( $profile_page ) : admin_url( 'profile.php' );
                $logout_url   = wp_logout_url( home_url( '/' ) );
              ?>
              <button class="user-btn" type="button" aria-haspopup="true" aria-expanded="false">
                <img src="<?php echo esc_url( $avatar_url ); ?>" alt="avatar" width="30" height="30" style="border-radius:50%;object-fit:cover">
                <span class="user-name"><?php echo esc_html( $display_name ); ?></span>
                <span class="arrow-down">&#9662;</span>
              </button>
              <div class="user-dropdown" role="menu">
                <a class="user-dropdown__item" href="<?php echo esc_url( $profile_url ); ?>">
                  <i class="bx bx-user"></i>
                  <span>Hồ sơ cá nhân</span>
                </a>
                <a class="user-dropdown__item" href="<?php echo esc_url( home_url('/favorites') ); ?>">
                  <i class="bx bx-heart"></i>
                  <span>Phim yêu thích</span>
                </a>
                <a class="user-dropdown__item" href="<?php echo esc_url( home_url('/profile?tab=history') ); ?>">
                  <i class="bx bx-history"></i>
                  <span>Lịch sử mua hàng</span>
                </a>
                <div class="user-dropdown__divider"></div>
                <a class="user-dropdown__item" href="<?php echo esc_url( $logout_url ); ?>">
                  <i class="bx bx-log-out"></i>
                  <span>Đăng xuất</span>
                </a>
              </div>
            <?php else : ?>
              <a href="<?php echo esc_url( home_url( '/dangnhap/' ) ); ?>">
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="">
                <p>Đăng nhập</p>
              </a>
            <?php endif; ?>
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
        <!-- nút toggle menu cho mobile -->
        <div class="menu-toggle" onclick="toggleMenu()">☰</div>
      </div>

            <!-- navbar -->
      <nav class="navbar">
        <ul class="menu">
          <!-- menu-left -->
          <div class="menu-left">
            <li class="menu-item cinema-dropdown-item">
              <a href="#">
                <i class="fas fa-map-marker-alt location-icon"></i> Chọn rạp
              </a>
              <div class="dropdown cinema-dropdown">
                <div class="dropdown-header">
                  <i class="fas fa-film"></i>
                  <span>Hệ thống rạp RIOT Cinema</span>
                </div>
                <?php
                  // Lấy danh sách rạp từ CPT (thử các slug phổ biến)
                  $candidates = array('rap_phim','rap-phim','cinema','theater','mbs_cinema','rap','rapfilm','rap_phim_cpt');
                  $cinema_pt  = null;
                  foreach ($candidates as $cpt) {
                    $probe = new WP_Query(array('post_type'=>$cpt, 'posts_per_page'=>1));
                    if ($probe->have_posts()) { $cinema_pt = $cpt; wp_reset_postdata(); break; }
                    wp_reset_postdata();
                  }

                  $items = array();
                  if ($cinema_pt) {
                    $cinemas = new WP_Query(array(
                      'post_type'      => $cinema_pt,
                      'posts_per_page' => -1,
                      'orderby'        => 'title',
                      'order'          => 'ASC',
                    ));
                    while ($cinemas->have_posts()) { $cinemas->the_post();
                      $items[] = array('title'=>get_the_title(), 'link'=>get_permalink());
                    }
                    wp_reset_postdata();
                  }
                  // Chia thành 3 cột
                  $cols = array(array(), array(), array());
                  foreach ($items as $i => $it) {
                    $cols[$i % 3][] = $it;
                  }
                  for ($c = 0; $c < 3; $c++) {
                    echo '<div class="dropdown-column">';
                    if (!empty($cols[$c])) {
                      foreach ($cols[$c] as $it) {
                        echo '<a href="'.esc_url($it['link']).'" class="cinema-link">';
                        echo '<i class="fas fa-building"></i>';
                        echo '<span>'.esc_html($it['title']).'</span>';
                        echo '</a>';
                      }
                    }
                    echo '</div>';
                  }
                ?>
              </div>
            </li>
            <li class="menu-item">
              <a href="<?php echo home_url('/lich-chieu/'); ?>">
                <i class="fas fa-map-marker-alt location-icon"></i> Lịch chiếu
              </a>
            </li>
          </div>
          <!-- menu-right -->
          <div class="menu-right">
            <li class="menu-item"><a href="<?php echo esc_url(home_url('/khuyenmai')); ?>">Khuyến mãi</a></li>
            <li class="menu-item"><a href="<?php echo esc_url(home_url('/tochucsukien')); ?>">Tổ chức sự kiện</a></li>
            <li class="menu-item"><a href="<?php echo get_post_type_archive_link('blog'); ?>">Xem tất cả bài viết</a></li>
            <li class="menu-item"><a href="<?php echo esc_url(home_url('/gioithieu')); ?>">Giới thiệu</a></li>
          </div>
        </ul>
      </nav>














