# 🚀 CHUYỂN SANG XAMPP - CÁCH TỐT NHẤT

## ✨ TẠI SAO DÙNG XAMPP?

- ✅ **TỰ ĐỘNG** xử lý Pretty Permalinks
- ✅ **KHÔNG CẦN** config router.php
- ✅ **ỔN ĐỊNH** hơn PHP built-in server
- ✅ Có Apache với mod_rewrite
- ✅ Có .htaccess tự động
- ✅ Giống môi trường production

---

## 📋 HƯỚNG DẪN CHI TIẾT

### BƯỚC 1: Download XAMPP

1. Trang download đã được mở: https://www.apachefriends.org/download.html
2. Chọn **XAMPP for Windows**
3. Chọn phiên bản **PHP 8.2** hoặc **8.1**
4. Download file installer (khoảng 150MB)

### BƯỚC 2: Cài Đặt XAMPP

1. **Chạy file installer** vừa download
2. Nếu có cảnh báo UAC → Nhấn **Yes**
3. Trong màn hình "Select Components":
   - ✅ Chọn: **Apache**
   - ✅ Chọn: **MySQL** 
   - ✅ Chọn: **PHP**
   - ✅ Chọn: **phpMyAdmin**
   - ❌ Bỏ các thứ khác (Perl, Tomcat...)
4. Chọn thư mục cài đặt: **C:\xampp** (mặc định)
5. Nhấn **Next** → **Next** → **Install**
6. Đợi cài đặt xong (2-3 phút)
7. Nhấn **Finish**

### BƯỚC 3: Copy WordPress vào XAMPP

1. **Mở File Explorer**
2. Vào folder: **C:\xampp\htdocs\**
3. **Copy toàn bộ folder WordPress** của bạn vào đây
4. Đổi tên folder thành: **wordpress** (hoặc **cms**)

**VÍ DỤ:**
```
C:\hk5\cms-pj2\wordpress\  (folder cũ)
    → Copy toàn bộ vào →
C:\xampp\htdocs\wordpress\  (folder mới)
```

### BƯỚC 4: Start Apache trong XAMPP

1. **Mở XAMPP Control Panel** (tìm trong Start Menu)
2. Nhấn nút **Start** bên cạnh **Apache**
3. Đợi cho đến khi chữ Apache chuyển sang màu xanh
4. Nếu có lỗi Port 80 đang được dùng:
   - Nhấn **Config** → **Apache (httpd.conf)**
   - Tìm dòng: `Listen 80`
   - Đổi thành: `Listen 8080`
   - Save và restart Apache

### BƯỚC 5: Cập Nhật wp-config.php

1. Mở file: **C:\xampp\htdocs\wordpress\wp-config.php**
2. Tìm các dòng này:

```php
define( 'DB_NAME', 'database_name_here' );
define( 'DB_USER', 'username_here' );
define( 'DB_PASSWORD', 'password_here' );
define( 'DB_HOST', 'localhost' );
```

3. **KHÔNG CẦN** sửa gì nếu database của bạn đã đúng
4. Nếu chưa có database, vào **http://localhost/phpmyadmin** tạo database mới

### BƯỚC 6: Cập Nhật URL trong Database

**Nếu database cũ có URL là localhost:8000, bạn cần đổi:**

#### Cách 1: Dùng phpMyAdmin

1. Vào: **http://localhost/phpmyadmin**
2. Chọn database WordPress của bạn
3. Click tab **SQL**
4. Chạy câu lệnh này:

```sql
UPDATE wp_options 
SET option_value = 'http://localhost/wordpress' 
WHERE option_name = 'siteurl' OR option_name = 'home';
```

**LƯU Ý:** Đổi `/wordpress` thành tên folder của bạn

#### Cách 2: Thêm vào wp-config.php

Thêm 2 dòng này vào đầu file **wp-config.php**:

```php
define('WP_HOME','http://localhost/wordpress');
define('WP_SITEURL','http://localhost/wordpress');
```

### BƯỚC 7: Cấu Hình Permalink

1. Vào: **http://localhost/wordpress/wp-admin**
2. Đăng nhập WordPress
3. Vào: **Settings → Permalinks**
4. Chọn: **Post name**
5. Nhấn: **Save Changes**

**XONG!** XAMPP sẽ tự động tạo file .htaccess và xử lý permalink!

### BƯỚC 8: Test Kết Quả

Thử các URL sau:
- ✅ http://localhost/wordpress/dangky/
- ✅ http://localhost/wordpress/dang-nhap/
- ✅ http://localhost/wordpress/profile/

**URL sẽ đẹp, KHÔNG CÓ index.php!**

---

## 🎯 SO SÁNH

| Tính năng | PHP Built-in Server | XAMPP |
|-----------|---------------------|-------|
| Pretty Permalinks | Cần config router.php | Tự động ✅ |
| Ổn định | Trung bình | Tốt ✅ |
| Dễ setup | Dễ | Trung bình |
| Giống production | Không | Có ✅ |
| .htaccess | Không dùng | Dùng được ✅ |

---

## 🔧 TROUBLESHOOTING

### Vấn đề 1: Port 80 bị chiếm

**Lỗi:** Apache không start được, báo port 80 đang dùng

**Giải pháp:**
1. Mở XAMPP Control Panel
2. Nhấn **Config** → **Apache (httpd.conf)**
3. Tìm: `Listen 80`
4. Đổi thành: `Listen 8080`
5. Tìm: `ServerName localhost:80`
6. Đổi thành: `ServerName localhost:8080`
7. Save và restart Apache
8. Truy cập: **http://localhost:8080/wordpress/**

### Vấn đề 2: CSS/JS bị mất

**Nguyên nhân:** URL trong database vẫn là `localhost:8000`

**Giải pháp:** Làm BƯỚC 6 ở trên (Cập nhật URL)

### Vấn đề 3: Database connection error

**Lỗi:** "Error establishing a database connection"

**Giải pháp:**
1. Start MySQL trong XAMPP Control Panel
2. Kiểm tra thông tin database trong wp-config.php
3. Vào phpMyAdmin import lại database

### Vấn đề 4: Vẫn thấy index.php trong URL

**Giải pháp:**
1. Kiểm tra file .htaccess có tồn tại không (trong folder wordpress)
2. Nếu không có, tạo file .htaccess với nội dung:

```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /wordpress/
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /wordpress/index.php [L]
</IfModule>
# END WordPress
```

3. Save Permalink Settings lại

---

## 📝 CHECKLIST SAU KHI CÀI XAMPP

- [ ] Download và cài XAMPP
- [ ] Copy WordPress vào C:\xampp\htdocs\
- [ ] Start Apache trong XAMPP Control Panel
- [ ] Cập nhật wp-config.php (nếu cần)
- [ ] Cập nhật URL trong database
- [ ] Cấu hình Permalink = "Post name"
- [ ] Test URL không có index.php
- [ ] CSS/JS load đúng

---

## 🎉 KẾT LUẬN

Sau khi chuyển sang XAMPP:
- ✅ URL đẹp tự động
- ✅ Không cần lo router.php
- ✅ Ổn định hơn nhiều
- ✅ Dễ quản lý database với phpMyAdmin

**XAMPP là giải pháp tốt nhất cho WordPress development!**

---

**✨ Chúc bạn thành công!**

