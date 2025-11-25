<!-- footer -->
<footer class="cinestar-footer">
  <div class="container">
    <div class="footer-top">
      <div class="brand">
       <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-footer">
         <img
           src="<?php echo get_template_directory_uri(); ?>/assets/images/riot-logo.png"
           alt="RIOT Cinema"
         />
       </a>
        <p>BE HAPPY, BE A STAR</p>
        <div class="book-brand">
          <button class="btn-ticker" onclick="window.location.href='<?php echo home_url('/datve'); ?>'">ĐẶT VÉ</button>
          <button class="btn-corn" onclick="window.location.href='<?php echo home_url('/bapnuoc'); ?>'">ĐẶT BẮP NƯỚC</button>
        </div>
        <div class="social-icons">
          <a href="#"><i class="bx bxl-facebook-circle"></i></a>
          <a href="#"><i class="bx bxl-youtube"></i></a>
          <a href="#"><i class="bx bxl-tiktok"></i></a>
          <a href="#"><img
              id="zalo"
              width="24"
              height="24"
              loading="lazy"
              sizes="(max-width: 768px) 24px, 24px"
              src="https://cinestar.com.vn/assets/images/ic-zl-white.svg"
              alt="" /></a>
        </div>
        <p class="language">
          Ngôn ngữ:
          <img
            src="https://upload.wikimedia.org/wikipedia/commons/2/21/Flag_of_Vietnam.svg"
            alt="icon language" />
          VN
        </p>
      </div>

      <div class="footer-columns">
        <div class="column">
          <h4>TÀI KHOẢN</h4>
          <ul>
            <li><a href="<?php echo home_url('/dangnhap'); ?>">Đăng nhập</a></li>
            <li><a href="<?php echo home_url('/dangky'); ?>">Đăng ký</a></li>
            <li><a href="<?php echo home_url('/'); ?>">Membership</a></li>
          </ul>
        </div>

        <div class="column">
          <h4>THUÊ SỰ KIỆN</h4>
          <ul>
            <li><a href="<?php echo home_url('/tochucsukien'); ?>">Thuê rạp</a></li>
            <li><a href="<?php echo home_url('/tochucsukien'); ?>">Các loại hình cho thuê khác</a></li>
          </ul>
        </div>

        <div class="column">
          <h4>DỊCH VỤ KHÁC</h4>
          <ul>
            <li><a href="<?php echo home_url('/'); ?>">Nhà hàng</a></li>
            <li><a href="<?php echo home_url('/'); ?>">Kidzone</a></li>
            <li><a href="<?php echo home_url('/'); ?>">Bowling</a></li>
            <li><a href="<?php echo home_url('/'); ?>">Billiards</a></li>
            <li><a href="<?php echo home_url('/'); ?>">Gym</a></li>
            <li><a href="<?php echo home_url('/'); ?>">Nhà hát Opera</a></li>
            <li><a href="#">Coffee</a></li>
          </ul>
        </div>

        <div class="column">
          <h4>XEM PHIM</h4>
          <ul>
            <li><a href="<?php echo home_url('/phim-dang-chieu'); ?>">Phim đang chiếu</a></li>
            <li><a href="<?php echo home_url('/phim-sap-chieu'); ?>">Phim sắp chiếu</a></li>
            <li><a href="<?php echo home_url('/suat-chieu-dac-biet'); ?>">Suất chiếu đặc biệt</a></li>
          </ul>
        </div>

        <div class="column">
          <h4>RIOT CINEMA</h4>
          <ul>
            <li><a href="<?php echo home_url('/gioithieu'); ?>">Giới thiệu</a></li>
            <li><a href="<?php echo home_url('/lien-he'); ?>">Liên hệ</a></li>
            <li><a href="<?php echo home_url('/tuyen-dung'); ?>">Tuyển dụng</a></li>
            <li><a href="<?php echo home_url('/blog'); ?>">Blog</a></li>
          </ul>
        </div>

        <div class="column">
          <h4>HỆ THỐNG RẠP RIOT</h4>
          <ul>
            <li><a href="<?php echo home_url('/he-thong-rap'); ?>">Tất cả hệ thống rạp</a></li>
            <?php
               $candidates = array('mbs_cinema','rap_phim','rap-phim','cinema','theater','rap','rapfilm','rap_phim_cpt');
               $cinema_pt  = null;
               foreach ($candidates as $cpt) {
                 if (post_type_exists($cpt)) { $cinema_pt = $cpt; break; }
               }
               if ($cinema_pt) {
                 $cinemas = new WP_Query(array(
                   'post_type'      => $cinema_pt,
                   'posts_per_page' => -1,
                   'orderby'        => 'title',
                   'order'          => 'ASC',
                 ));
                 if ($cinemas->have_posts()) {
                   while ($cinemas->have_posts()) {
                     $cinemas->the_post();
                     echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                   }
                   wp_reset_postdata();
                 }
               }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
<!-- <script src="script.js"></script> -->
</body>
</html>

<style>
  /* footer */
  html,
  body {
    overflow-x: hidden !important;
    width: 100% !important;
    max-width: 100% !important;
  }

  /* footer */
  .cinestar-footer {
    background: linear-gradient(to right, #8e2de2, #4a00e0, #00c6ff);
    color: white;
    padding: 40px 0;
    /* full-bleed */
    width: 100vw;
    margin-left: calc(50% - 50vw);
    margin-right: calc(50% - 50vw);
    position: relative;
  }

  .cinestar-footer .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px
  }

  .footer-top {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
  }

  .brand {
    flex: 1 1 250px;
  }

  .brand .logo-footer {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .brand .logo-footer img {
    width: 200px;
    height: 200px;
  }

  .brand .book-brand {
    display: flex;
    gap: 30px;
    margin-bottom: 20px;
  }

  #zalo {
    transform: translateY(5px);
  }

  /*  */
  .brand .book-brand .btn-ticker {
    position: relative;
    width: 140px;
    padding: 10px 10px;
    color: #000;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-weight: bold;
    overflow: hidden;
    z-index: 1;
    transition: color 0.3s ease;
    background-color: yellow;
  }

  .brand .book-brand .btn-ticker::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, rgb(51, 138, 238), rgb(14, 35, 155));
    transition: left 0.4s ease;
    z-index: -1;
  }

  .brand .book-brand .btn-ticker:hover::before {
    left: 0;
  }

  .brand .book-brand .btn-ticker:hover {
    color: #fff;
  }

  /*  */

  .brand .book-brand .btn-corn {
    position: relative;
    width: 140px;
    padding: 10px 10px;
    color: yellow;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-weight: bold;
    overflow: hidden;
    z-index: 1;
    transition: color 0.3s ease;
    background-color: transparent;
    border: 1px solid yellow;
  }

  .brand .book-brand .btn-corn::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, rgb(230, 157, 89), rgb(202, 116, 18));
    transition: left 0.4s ease;
    z-index: -1;
  }

  .brand .book-brand .btn-corn:hover::before {
    left: 0;
  }

  .brand .book-brand .btn-corn:hover {
    color: #fff;
  }

  .brand h3 {
    font-size: 24px;
    margin-bottom: 10px;
  }

  .brand p {
    margin-bottom: 10px;
  }

  .brand ul {
    list-style: none;
    padding: 0;
    margin-bottom: 10px;
  }

  .brand ul li {
    margin-bottom: 5px;
  }

  .brand ul li a {
    color: white;
    text-decoration: none;
  }

  .social-icons a {
    margin-right: 10px;
  }

  .social-icons img {
    width: 24px;
    height: 24px;
  }

  .language {
    margin-top: 10px;
    font-size: 14px;
  }

  .language img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 5px;
    transform: translateY(5px);
  }

  .footer-columns {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    flex: 3;
  }

  .column {
    flex: 1 1 180px;
  }

  .column h4 {
    font-size: 16px;
    margin-bottom: 10px;
  }

  .column ul {
    list-style: none;
    padding: 0;
  }

  .column ul li {
    margin-bottom: 6px;
  }

  .column ul li a {
    color: white;
    text-decoration: none;
    font-size: 14px;
  }

  .column ul li a:hover {
    text-decoration: underline;
  }
</style>