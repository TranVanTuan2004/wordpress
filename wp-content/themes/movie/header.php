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