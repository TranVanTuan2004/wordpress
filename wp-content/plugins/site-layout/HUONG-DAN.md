# Site Layout - Header & Footer Dùng Chung

Plugin tạo header và footer chung cho toàn bộ website.

## Cài đặt

1. Kích hoạt plugin "Site Layout - Header & Footer"
2. Header và Footer sẽ tự động load CSS/JS

## Cách sử dụng

### Cách 1: Dùng Shortcode (Đơn giản nhất)

Tạo trang mới, paste shortcode này:

```
[site_header]

NỘI DUNG TRANG CỦA BẠN Ở ĐÂY

[site_footer]
```

### Cách 2: Dùng trong PHP Template

```php
<?php
// Header
echo do_shortcode('[site_header]');

// Nội dung
?>
<div class="my-content">
    <h1>Nội dung của bạn</h1>
</div>
<?php

// Footer
echo do_shortcode('[site_footer]');
?>
```

### Cách 3: Dùng Function Helper

```php
<?php
$content = '<h1>Nội dung</h1><p>Đây là trang của bạn</p>';
echo site_render_full_layout($content);
?>
```

## Tùy chỉnh Menu

Sửa file: `templates/header.php`

Tìm phần:
```php
<ul class="nav-menu">
    <li><a href="#">Menu Item</a></li>
</ul>
```

Thêm/sửa/xóa menu items tại đây.

## Tùy chỉnh Footer

Sửa file: `templates/footer.php`

Có 4 cột footer, mỗi cột trong `<div class="footer-col">`

## Tùy chỉnh CSS

File: `assets/layout.css`

Các class chính:
- `.site-header` - Header
- `.site-nav` - Menu
- `.site-footer` - Footer
- `.footer-columns` - Cột footer

## Responsive

- Desktop: Full menu
- Tablet (< 968px): Hamburger menu
- Mobile (< 640px): Stack layout

## Features

✅ Header cố định khi scroll
✅ Dropdown menu user
✅ Mobile responsive
✅ Hamburger menu animation
✅ Social links
✅ Footer 4 columns

## Ví dụ sử dụng

### Trang đơn giản

```
[site_header]

<div style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
    <h1>Chào mừng đến với website</h1>
    <p>Nội dung trang của bạn...</p>
</div>

[site_footer]
```

### Kết hợp với form đăng nhập

```
[site_header]

<div style="padding: 60px 20px;">
    [uas_login]  <!-- Form đăng nhập -->
</div>

[site_footer]
```

## Lưu ý

- Logo mặc định lấy từ Site Icon WordPress
- User menu tự động hiện khi đã đăng nhập
- Mobile menu tự động ẩn/hiện

## Support

Sửa các file trong thư mục `templates/` và `assets/` để tùy chỉnh.

