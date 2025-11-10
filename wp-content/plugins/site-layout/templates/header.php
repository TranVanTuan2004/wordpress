<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo is_home() ? get_bloginfo('name') : wp_title('|', false, 'right') . get_bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php echo SITE_LAYOUT_URL; ?>assets/layout.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    
<!-- Header -->
<header class="site-header">
    <div class="header-container">
        <!-- Logo -->
        <div class="site-logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_site_icon_url(); ?>" alt="Logo" style="height: 40px;">
                <span class="site-name"><?php bloginfo('name'); ?></span>
            </a>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="site-nav">
            <ul class="nav-menu">
                <li><a href="<?php echo home_url(); ?>">Trang chủ</a></li>
                <li><a href="<?php echo home_url('/phim'); ?>">Phim</a></li>
                <li><a href="<?php echo home_url('/lich-chieu'); ?>">Lịch chiếu</a></li>
                <li><a href="<?php echo home_url('/rap'); ?>">Rạp chiếu</a></li>
                <li><a href="<?php echo home_url('/tin-tuc'); ?>">Tin tức</a></li>
            </ul>
        </nav>
        
        <!-- User Menu -->
        <div class="user-menu">
            <?php if (is_user_logged_in()): 
                $current_user = wp_get_current_user();
            ?>
                <div class="user-dropdown">
                    <button class="user-btn">
                        <?php echo get_avatar($current_user->ID, 32); ?>
                        <span><?php echo $current_user->display_name; ?></span>
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                            <path d="M6 9L1 4h10L6 9z"/>
                        </svg>
                    </button>
                    <div class="dropdown-menu">
                        <a href="<?php echo home_url('/tai-khoan'); ?>">Tài khoản</a>
                        <a href="<?php echo home_url('/lich-su-dat-ve'); ?>">Lịch sử đặt vé</a>
                        <a href="<?php echo wp_logout_url(home_url()); ?>">Đăng xuất</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo home_url('/dang-nhap'); ?>" class="btn-login">Đăng nhập</a>
                <a href="<?php echo home_url('/dang-ky'); ?>" class="btn-register">Đăng ký</a>
            <?php endif; ?>
        </div>
        
        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <ul>
            <li><a href="<?php echo home_url(); ?>">Trang chủ</a></li>
            <li><a href="<?php echo home_url('/phim'); ?>">Phim</a></li>
            <li><a href="<?php echo home_url('/lich-chieu'); ?>">Lịch chiếu</a></li>
            <li><a href="<?php echo home_url('/rap'); ?>">Rạp chiếu</a></li>
            <li><a href="<?php echo home_url('/tin-tuc'); ?>">Tin tức</a></li>
            <?php if (is_user_logged_in()): ?>
                <li><a href="<?php echo home_url('/tai-khoan'); ?>">Tài khoản</a></li>
                <li><a href="<?php echo wp_logout_url(home_url()); ?>">Đăng xuất</a></li>
            <?php else: ?>
                <li><a href="<?php echo home_url('/dang-nhap'); ?>">Đăng nhập</a></li>
                <li><a href="<?php echo home_url('/dang-ky'); ?>">Đăng ký</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>

