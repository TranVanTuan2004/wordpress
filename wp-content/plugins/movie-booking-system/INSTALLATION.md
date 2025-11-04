# Hướng Dẫn Cài Đặt Chi Tiết - Movie Booking System

## Mục Lục
1. [Yêu Cầu Hệ Thống](#yêu-cầu-hệ-thống)
2. [Cài Đặt Plugin](#cài-đặt-plugin)
3. [Cấu Hình Cơ Bản](#cấu-hình-cơ-bản)
4. [Tạo Nội Dung](#tạo-nội-dung)
5. [Tùy Chỉnh Giao Diện](#tùy-chỉnh-giao-diện)
6. [Troubleshooting](#troubleshooting)

## Yêu Cầu Hệ Thống

### Tối Thiểu
- WordPress 5.0+
- PHP 7.2+
- MySQL 5.6+
- 128MB RAM
- 20MB Disk Space

### Khuyến Nghị
- WordPress 6.0+
- PHP 8.0+
- MySQL 5.7+ hoặc MariaDB 10.2+
- 256MB+ RAM
- HTTPS enabled
- Pretty Permalinks enabled

## Cài Đặt Plugin

### Phương Pháp 1: Upload qua WordPress Admin (Khuyên Dùng)

1. Download file `movie-booking-system.zip`
2. Đăng nhập WordPress Admin
3. Vào `Plugins > Add New`
4. Click `Upload Plugin`
5. Chọn file zip vừa download
6. Click `Install Now`
7. Click `Activate Plugin`

### Phương Pháp 2: Upload qua FTP

1. Giải nén file `movie-booking-system.zip`
2. Upload thư mục `movie-booking-system` vào `/wp-content/plugins/`
3. Đăng nhập WordPress Admin
4. Vào `Plugins > Installed Plugins`
5. Tìm "Movie Booking System"
6. Click `Activate`

### Phương Pháp 3: Clone từ Git (Cho Developers)

```bash
cd wp-content/plugins
git clone [repository-url] movie-booking-system
```

## Cấu Hình Cơ Bản

### 1. Cài Đặt Permalinks

Để plugin hoạt động tốt, bạn cần enable Pretty Permalinks:

1. Vào `Settings > Permalinks`
2. Chọn một trong các option:
   - Post name (Khuyên dùng)
   - Day and name
   - Month and name
   - Custom Structure
3. Click `Save Changes`

### 2. Cài Đặt Email

Để gửi email xác nhận booking:

#### Option 1: Dùng SMTP Plugin
1. Cài đặt plugin `WP Mail SMTP`
2. Cấu hình Gmail/Outlook SMTP
3. Test gửi email

#### Option 2: Dùng SendGrid/Mailgun
1. Đăng ký tài khoản SendGrid/Mailgun
2. Cài plugin tương ứng
3. Cấu hình API key

### 3. Cấu Hình Plugin

Vào `Đặt Vé Phim > Cài Đặt`:

#### Cấu Hình Ghế Ngồi
```
Số Hàng Ghế: 10
Số Ghế Mỗi Hàng: 17
```

**Lưu ý**: Layout mặc định:
- Hàng A-C: Ghế thường
- Hàng D-I: Ghế VIP  
- Hàng J-Q: Ghế Sweetbox

#### Cấu Hình Giá Vé
```
Giá Ghế Thường: 70,000 VNĐ
Giá Ghế VIP: 100,000 VNĐ
Giá Ghế Sweetbox: 150,000 VNĐ
```

## Tạo Nội Dung

### A. Tạo Các Trang (Pages)

#### 1. Trang Danh Sách Phim

**Thông tin trang:**
- Title: `Phim Đang Chiếu`
- Slug: `phim`
- Template: Default

**Nội dung:**
```
[mbs_movies_list per_page="12"]
```

**Tùy chọn nâng cao:**
```
[mbs_movies_list per_page="20" genre="hanh-dong"]
```

#### 2. Trang Chi Tiết Phim

**Thông tin trang:**
- Title: `Chi Tiết Phim`
- Slug: `chi-tiet-phim`
- Template: Default

**Nội dung:**
```
[mbs_movie_detail]
```

#### 3. Trang Đặt Vé

**Thông tin trang:**
- Title: `Đặt Vé`
- Slug: `dat-ve`
- Template: Default

**Nội dung:**
```
[mbs_booking_form]
```

#### 4. Trang Hệ Thống Rạp (Optional)

**Thông tin trang:**
- Title: `Hệ Thống Rạp`
- Slug: `he-thong-rap`
- Template: Default

**Nội dung:**
```
[mbs_cinema_list]
```

### B. Thêm Menu Navigation

1. Vào `Appearance > Menus`
2. Tạo menu mới hoặc chỉnh menu hiện tại
3. Thêm các trang:
   - Phim Đang Chiếu
   - Hệ Thống Rạp
4. Assign menu to location (ví dụ: Primary Menu)

### C. Thêm Thể Loại Phim

Vào `Phim > Thể Loại` và thêm:

```
- Hành Động
- Tình Cảm
- Hài Hước
- Kinh Dị
- Khoa Học Viễn Tưởng
- Phiêu Lưu
- Hoạt Hình
- Tâm Lý
- Gia Đình
- Chiến Tranh
```

### D. Thêm Rạp Chiếu

#### Rạp 1: CGV Vincom Mega Mall
1. Vào `Rạp Phim > Thêm Rạp`
2. Điền thông tin:

```
Tên: CGV Vincom Mega Mall Grand Park
Địa chỉ: Lô L5-01, Tầng L5, Trung Tâm Thương Mại Vincom Mega Mall Grand Park
Điện thoại: 1900 6017
Số phòng chiếu: 8
```

3. Upload ảnh rạp (optional)
4. Click `Publish`

#### Thêm Nhiều Rạp
Lặp lại quy trình trên cho các rạp khác.

### E. Thêm Phim

#### Phim Mẫu
1. Vào `Phim > Thêm Phim`
2. Điền thông tin:

```
Tên phim: Phá Đảm: Sinh Nhật Mẹ
Nội dung: 
[Viết mô tả phim ở đây, tối thiểu 100 từ]

Thông tin chi tiết:
- Thời lượng: 120 phút
- Đạo diễn: [Tên đạo diễn]
- Diễn viên: Trấn Thành, Hari Won, Lê Giang
- Độ tuổi: C13
- Ngôn ngữ: Phụ đề
- Link Trailer: https://youtube.com/...
```

3. Upload poster (ảnh đứng, tỷ lệ 2:3)
4. Chọn thể loại
5. Click `Publish`

### F. Tạo Lịch Chiếu

Cho mỗi phim, tạo nhiều suất chiếu:

1. Vào `Suất Chiếu > Thêm Suất Chiếu`
2. Chọn:
   - **Phim**: Phim vừa tạo
   - **Rạp**: Rạp đã có
   - **Thời gian**: [Chọn ngày giờ]
   - **Phòng**: Phòng 3
   - **Định dạng**: 2D
   - **Giá vé**: 70,000 VNĐ
3. Click `Publish`

**Tips**: Tạo nhiều suất chiếu cho mỗi phim:
- Buổi sáng: 10:00, 10:30
- Buổi trưa: 13:00, 13:30
- Buổi chiều: 16:00, 16:30
- Buổi tối: 18:30, 21:00, 23:35

## Tùy Chỉnh Giao Diện

### 1. Thay Đổi Màu Sắc

Chỉnh file `assets/css/style.css`:

```css
:root {
    --mbs-primary: #c71585;        /* Màu chính */
    --mbs-primary-dark: #a01070;   /* Màu chính đậm */
    --mbs-secondary: #ff6b9d;      /* Màu phụ */
    --mbs-success: #10b981;        /* Màu thành công */
    --mbs-danger: #ef4444;         /* Màu lỗi */
}
```

### 2. Override Templates

Copy template từ plugin vào theme:

```
your-theme/
  movie-booking-system/
    movies-list.php
    movie-detail.php
    booking-form.php
    cinema-list.php
```

### 3. Custom CSS

Thêm CSS vào `Appearance > Customize > Additional CSS`:

```css
/* Ví dụ: Thay đổi font */
.mbs-movies-container {
    font-family: 'Your Custom Font', sans-serif;
}

/* Ví dụ: Bo tròn card nhiều hơn */
.mbs-movie-card {
    border-radius: 16px;
}
```

## Troubleshooting

### 1. Lỗi 404 Not Found

**Nguyên nhân**: Permalinks chưa được flush

**Giải pháp**:
1. Vào `Settings > Permalinks`
2. Không cần thay đổi gì
3. Chỉ cần click `Save Changes`

### 2. CSS Không Load

**Nguyên nhân**: Cache plugin hoặc browser cache

**Giải pháp**:
1. Clear cache plugin (nếu có)
2. Clear browser cache (Ctrl + Shift + Del)
3. Hard refresh (Ctrl + F5)

### 3. Không Thấy Menu Admin

**Nguyên nhân**: Plugin chưa activate hoặc thiếu quyền

**Giải pháp**:
1. Kiểm tra plugin đã activate
2. Đảm bảo user có role Administrator
3. Deactivate rồi activate lại plugin

### 4. Email Không Gửi

**Nguyên nhân**: Hosting không support mail() function

**Giải pháp**:
1. Cài plugin WP Mail SMTP
2. Cấu hình với Gmail:
   - SMTP Host: smtp.gmail.com
   - SMTP Port: 587
   - Encryption: TLS
   - Username: your-email@gmail.com
   - Password: [App Password]

### 5. Ghế Không Hiển Thị

**Nguyên nhân**: JavaScript bị block

**Giải pháp**:
1. Check console log (F12)
2. Tắt các plugin conflict
3. Thử theme mặc định

### 6. Database Error

**Nguyên nhân**: Tables chưa được tạo

**Giải pháp**:
```php
// Chạy code này qua plugin Code Snippets hoặc functions.php
MBS_Database::create_tables();
flush_rewrite_rules();
```

### 7. Slow Loading

**Giải pháp**:
1. Cài plugin caching (WP Super Cache, W3 Total Cache)
2. Optimize images
3. Enable CDN
4. Minify CSS/JS

## Best Practices

### 1. Backup Định Kỳ
- Backup database hàng ngày
- Backup files hàng tuần
- Dùng plugin: UpdraftPlus, BackupBuddy

### 2. Update Thường Xuyên
- Update WordPress core
- Update theme
- Update plugins

### 3. Security
- Dùng strong passwords
- Enable 2FA
- Cài security plugin: Wordfence, Sucuri

### 4. Performance
- Optimize images (max 500KB)
- Use CDN for assets
- Enable object caching
- Limit post revisions

### 5. SEO
- Install Yoast SEO
- Optimize movie titles
- Add alt text to images
- Create XML sitemap

## Advanced Configuration

### Custom Seat Layout

Để tùy chỉnh layout ghế, chỉnh file `templates/booking-form.php`:

```php
// Thay đổi rows
$rows = array('A', 'B', 'C', 'D', 'E'); // Chỉ 5 hàng

// Thay đổi số ghế
$seats_per_row = 12; // 12 ghế mỗi hàng
```

### Integration với Payment Gateway

Coming soon: PayPal, Stripe, VNPay integration

### Hooks & Filters

```php
// Hook after booking created
add_action('mbs_booking_created', function($booking_id) {
    // Your custom code
});

// Filter seat price
add_filter('mbs_seat_price', function($price, $seat_type) {
    // Modify price based on conditions
    return $price;
}, 10, 2);
```

## Support

Nếu gặp vấn đề không giải quyết được:

1. Check documentation
2. Search trong GitHub Issues
3. Liên hệ support

---

**Cập nhật lần cuối**: November 2025  
**Phiên bản**: 1.0.0

