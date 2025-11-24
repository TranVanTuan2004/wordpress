# Hướng Dẫn Cấu Hình Gmail SMTP

## Cách 1: Cấu hình trong wp-config.php (KHUYÊN DÙNG - An toàn nhất)

1. Mở file `wp-config.php` (ở thư mục gốc WordPress)
2. Thêm các dòng sau TRƯỚC dòng `/* That's all, stop editing! Happy publishing. */`:

```php
// Cấu hình SMTP Gmail
define('MOVIE_SMTP_ENABLED', true);
define('MOVIE_SMTP_HOST', 'smtp.gmail.com');
define('MOVIE_SMTP_USER', 'your-email@gmail.com'); // Email Gmail của bạn
define('MOVIE_SMTP_PASS', 'your-app-password'); // App Password (xem hướng dẫn bên dưới)
```

3. Lưu file

## Cách 2: Tạo App Password cho Gmail

Gmail không cho phép dùng mật khẩu thường, cần tạo App Password:

1. Vào Google Account: https://myaccount.google.com/
2. Chọn **Bảo mật** (Security)
3. Bật **Xác minh 2 bước** (2-Step Verification) nếu chưa bật
4. Tìm **Mật khẩu ứng dụng** (App passwords)
5. Chọn **Ứng dụng**: Mail
6. Chọn **Thiết bị**: Windows Computer (hoặc Other)
7. Click **Tạo** (Generate)
8. Copy mật khẩu 16 ký tự (không có khoảng trắng)
9. Dán vào `MOVIE_SMTP_PASS` trong wp-config.php

## Cách 3: Test Email

Sau khi cấu hình xong, test bằng cách:
1. Đặt vé thành công
2. Kiểm tra email trong Gmail
3. Nếu không nhận được, kiểm tra:
   - App Password đã đúng chưa
   - Xác minh 2 bước đã bật chưa
   - Firewall có chặn port 587 không

## Lưu ý:

- **KHÔNG** commit file `wp-config.php` lên Git (file này đã có trong .gitignore)
- App Password chỉ hiển thị 1 lần, hãy lưu lại
- Nếu dùng email khác (Outlook, Yahoo), thay đổi `MOVIE_SMTP_HOST` tương ứng

