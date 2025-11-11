<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo is_home() ? get_bloginfo('name') : wp_title('|', false, 'right') . get_bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php echo SITE_LAYOUT_URL; ?>assets/layout.css">
    <?php wp_head(); // Quan trọng: Inject CSS/JS của WordPress và plugins ?>
    <style>
        /* Ẩn WordPress Admin Bar */
        #wpadminbar {
            display: none !important;
        }
        html {
            margin-top: 0 !important;
        }
        * html body {
            margin-top: 0 !important;
        }
    </style>
</head>
<body <?php body_class(); ?>>
    
<!-- Header -->
<header class="slp-header">
    <div class="slp-header-container" style="display: flex; justify-content: space-between; align-items: center;">
        <!-- Logo -->
        <div class="slp-logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3pdEdV4w4UdgSAjuKeTdUqqS8ltRa8YLCVg&s"; ?>" alt="Logo" style="height: 40px;">
                <span class="slp-site-name"><?php bloginfo('name'); ?></span>
            </a>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="slp-nav">
            <ul class="slp-nav-menu">
                <li><a href="<?php echo home_url(); ?>">Trang chủ</a></li>
                <li><a href="<?php echo home_url('/phim'); ?>">Phim</a></li>
                <li><a href="<?php echo home_url('/lich-chieu'); ?>">Lịch chiếu</a></li>
                <li><a href="<?php echo home_url('/rap'); ?>">Rạp chiếu</a></li>
                <li><a href="<?php echo home_url('/tin-tuc'); ?>">Tin tức</a></li>
            </ul>
        </nav>
        
        <!-- User Menu -->
        <div class="slp-user-menu">
            <?php if (is_user_logged_in()): 
                $current_user = wp_get_current_user();
            ?>
                <div class="slp-user-dropdown">
                    <button class="slp-user-btn">
                        <?php echo get_avatar($current_user->ID, 32); ?>
                        <span><?php echo $current_user->display_name; ?></span>
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                            <path d="M6 9L1 4h10L6 9z"/>
                        </svg>
                    </button>
                    <div class="slp-dropdown-menu">
                        <a href="<?php echo home_url('/tai-khoan'); ?>">Tài khoản</a>
                        <a href="<?php echo home_url('/lich-su-dat-ve'); ?>">Lịch sử đặt vé</a>
                        <a href="<?php echo wp_logout_url(home_url()); ?>">Đăng xuất</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo home_url('/dang-nhap'); ?>" class="slp-btn-login">Đăng nhập</a>
                <a href="<?php echo home_url('/dang-ky'); ?>" class="slp-btn-register">Đăng ký</a>
            <?php endif; ?>
        </div>
        
        <!-- Mobile Menu Toggle -->
        <button class="slp-mobile-menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    
    <!-- Mobile Menu -->
    <div class="slp-mobile-menu">
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

<style>
    ul {
        margin: 0px !important;
    }
</style>