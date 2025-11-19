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
<!--  -->


    <div class="container">
      <!-- header -->
      <div class="header">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-header">
          <img
            src="https://cinestar.com.vn/_next/image/?url=%2Fassets%2Fimages%2Fheader-logo.png&w=1920&q=75"
            alt="header-logo"
          />
        </a>
        <div class="actions" id="actions">
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
            <!-- <button type="submit">
              <img
                src="https://cdn-icons-png.flaticon.com/512/149/149852.png"
                alt="search"
              />
            </button> -->
          </div>
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
                <a class="user-dropdown__item" href="<?php echo esc_url( $profile_url ); ?>">Hồ sơ cá nhân</a>
                <a class="user-dropdown__item" href="<?php echo esc_url( $logout_url ); ?>">Đăng xuất</a>
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
            <li class="menu-item">
              <a href="#">
                <i class="fas fa-map-marker-alt location-icon"></i> Chọn rạp
              </a>
              <div class="dropdown">
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
                        echo '<a href="'.esc_url($it['link']).'">'.esc_html($it['title']).'</a>';
                      }
                    }
                    echo '</div>';
                  }
                ?>
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
            <li class="menu-item"><a href="<?php echo get_post_type_archive_link('blog'); ?>">Xem tất cả bài viết</a>
</li>
            <li class="menu-item"><a href="#">Giới thiệu</a></li>
          </div>
        </ul>
      </nav>

<!-- 
<style>
  /* container */

body {
    min-height: 100vh;
    background: linear-gradient(to bottom, #8e2de2, #4a00e0, #00c6ff);
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size: cover;
    color: white;
    font-family: 'Poppins', sans-serif;
  }
  ul, li, a{
    text-decoration: none;
    list-style: none;
    color: #fff;
}
  .container {
    width: 1200px;
    margin: 0 auto;
  }
  
.header{
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding: 20px 0px;
    border-bottom: 1px solid rgba(211, 211, 211, .4);
}
/* logo */
.header .logo-header img{
    width: 120px;
}

/* actions */
.header .actions{
    display: flex;
    justify-content: space-around;
    align-items: center;
    gap: 40px;
}



.header .actions .action-ticker,
.header .actions .action-popcorn{
    color: #fff;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    font-weight: bold;
    border-radius: 5px;
    background-size: 200% 100%; /* để gradient di chuyển */
    background-repeat: no-repeat;
    transition: color 0.6s;
    font-size: 18px;
}


/* action-ticker: gradient vàng -> tím */
.header .actions .action-ticker {
    background-image: linear-gradient(270deg, yellow, orange, #fff);
    color: black;
    animation: move-bg 4s linear infinite alternate;
    transition: color 1s, background-image 1s;
}

.header .actions .action-ticker:hover {
    background-image: linear-gradient(270deg, purple, blue, purple);
    color: #fff;
    animation: move-bg 1s linear infinite alternate;
    transition: color .6s, background-image 1s;
}

/* action-popcorn: gradient tím -> cam */
.header .actions .action-popcorn {
    background-image: linear-gradient(270deg, purple, blue, #fff);
    animation: move-bg 4s linear infinite alternate;
    transition: color 1s, background-image 1s;
}

.header .actions .action-popcorn:hover {
    background-image: linear-gradient(270deg, purple, orange, #fff);
    animation: move-bg 1s linear infinite alternate;
    transition: background-image 1s;
}

/* animation di chuyển gradient */
@keyframes move-bg {
    0% {
        background-position: 0% 0%;
    }
    100% {
        background-position: 100% 0%;
    }
}

/* search */
.header .action-search {
  position: relative;
  display: inline-block;
}

.header .action-search input {
  width: 250px;
  font-size: 14px;
  padding: 8px 30px 8px 10px;
  border: none;
  border-radius: 12px;
  background-color: #fff;
  color: #000;
}

.header .action-search button {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
}

.header .action-search button img {
  width: 18px;
  height: 18px;
  background-color: #fff;
}

/* Ẩn nút xóa mặc định trên Chrome, Edge, Safari */
input[type="search"]::-webkit-search-cancel-button {
    -webkit-appearance: none;
    appearance: none;
}

/* login */
.header .action-login a{
    display: flex;
    align-items: center;
    gap: 8px;
}

.header .action-login a img{
    width: 30px;
}

.header .action-login a p{
    font-size: 16px;
}
.header .action-login a p:hover{
    color: yellow;
}

/* ensure same style when not logged in but using .action-user wrapper */
.header .action-user a{
    display: flex;
    align-items: center;
    gap: 8px;
}
.header .action-user a img{
    width: 30px;
}
.header .action-user a p{
    font-size: 16px;
}
.header .action-user a p:hover{
    color: yellow;
}

/* language */
.header .action-language{
    display: flex;
    align-items: center;
    gap: 4px;
}

.header .action-language img{
    width: 25px;
    height: 25px;
    border-radius: 50%;
    object-fit: cover;
}

.header .action-language p{
    font-size: 16px;
}

/* user dropdown - scoped trong header */
.action-user{position:relative}
.action-user .user-btn{display:flex;align-items:center;gap:8px;background:transparent;border:none;color:#fff;cursor:pointer;font-size:16px}
.action-user .user-dropdown{position:absolute;right:0;top:calc(100% + 10px);min-width:190px;background:#071e3d;border:1px solid rgba(255,255,255,.15);border-radius:12px;box-shadow:0 12px 30px rgba(0,0,0,.35);padding:8px 0;display:none;z-index:100}
.action-user .user-dropdown__item{display:block;padding:10px 14px;color:#fff;text-decoration:none}
.action-user .user-dropdown__item:hover{background:rgba(255,255,255,.06)}
.action-user.is-open .user-dropdown{display:block}
/* navbar */
.navbar{
    padding: 10px 0px;
}

.navbar .menu{
    display: flex;
    justify-content: space-between;
}

.navbar .menu .menu-item{
    padding: 10px 0px;
}

.navbar .menu .menu-item a{
    font-size: 16px;
}

.navbar .menu .menu-left{
    display: flex;
    gap: 20px;
}
.navbar .menu .menu-left a:hover{
    color: yellow;
}

.navbar .menu .menu-left a .location-icon{
    color: white;
    font-size: 18px;
    padding: 0px 4px;
}
.navbar .menu .menu-left a:hover .location-icon{
    color: yellow;
}

.navbar .menu .menu-right{
    display: flex;
    gap: 20px;
}
.navbar .menu .menu-right a:hover{
    color: yellow;
    border-bottom: 1px solid yellow;
}

.navbar .menu .menu-left .menu-item:first-child:hover > .dropdown{
    display: flex;
}

/* làm dropdown */
.navbar .menu .menu-left {
    position: relative;
}

.navbar .menu .menu-left .menu-item{
    position: relative;
}

.navbar .menu .dropdown{
    display: none;
    position: absolute;
    top: calc(100% + 0px);
    left: 0;
    justify-content: space-around;
    gap: 80px;
    width: 1200px;
    border: 1px solid gray;
    z-index: 99;
    padding: 20px 0px;
    border-radius: 12px;
    background-color: #071e3d;
}

.navbar .menu .dropdown .dropdown-column a{
    display: block;
    padding: 10px 0px;
    font-size: 16px;
}
</style>
<script>
  (function(){
    var root = document.querySelector('.action-user');
    if(!root) return;
    var btn = root.querySelector('.user-btn');
    if(btn){
      btn.addEventListener('click', function(e){
        e.stopPropagation();
        var isOpen = root.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });
      document.addEventListener('click', function(){
        root.classList.remove('is-open');
        if(btn) btn.setAttribute('aria-expanded', 'false');
      });
    }
  })();
</script> -->