# 🎬 HƯỚNG DẪN TẠO TRANG HOME - MUA VÉ XEM PHIM

## ✨ ĐÃ TẠO XONG CÁC SECTION:

1. ✅ **Hero Banner** - Banner chính với nút "Đặt vé ngay"
2. ✅ **Phim đang chiếu** - Slider các phim hot
3. ✅ **Phim sắp chiếu** - Slider phim sắp ra mắt
4. ✅ **Lịch chiếu phim** - Filter rạp và lịch chiếu

---

## 🚀 CÁCH 1: DÙNG SHORTCODE TỪNG PHẦN

### Bước 1: Tạo Trang Home

1. Vào **Pages → Add New**
2. **Title:** Home (hoặc "Trang chủ")
3. **Permalink:** /home
4. **Content:** Thêm các shortcode theo thứ tự:

```
[hero_banner]

[movies_now_showing]

[movies_coming_soon]

[movie_schedule]
```

5. **Template:** Chọn "Full Width - Có Header Footer"
6. **Publish!**

---

## 🎯 CÁCH 2: DÙNG SHORTCODE TỔNG HỢP (NHANH HƠN)

### Chỉ cần 1 shortcode:

```
[full_home_page]
```

Shortcode này sẽ tự động hiển thị:
- Hero Banner
- Phim đang chiếu
- Phim sắp chiếu
- Lịch chiếu phim

---

## 📝 TẤT CẢ SHORTCODE CÓ SẴN:

| Shortcode | Mô tả | Sử dụng |
|-----------|-------|---------|
| `[hero_banner]` | Banner chính | Trang chủ |
| `[movies_now_showing]` | Section phim đang chiếu | Trang chủ |
| `[movies_coming_soon]` | Section phim sắp chiếu | Trang chủ |
| `[movie_schedule]` | Lịch chiếu có filter rạp | Trang chủ |
| `[full_home_page]` | Tất cả sections ở trên | Trang chủ |

---

## 🎨 TÍNH NĂNG ĐÃ CÓ:

### ✅ Hero Banner:
- Gradient đẹp mắt
- Illustration vé phim và người
- Animation float cho vé
- Button "Đặt vé ngay" nổi bật
- Responsive

### ✅ Phim Đang Chiếu:
- Slider ngang với prev/next buttons
- Movie card có:
  - Số thứ tự (1, 2, 3...)
  - Rating badge (13+, 16+, 18+)
  - Play button khi hover
  - Tên phim và thể loại
  - Rating sao
- Background đen rạp chiếu
- Smooth scroll

### ✅ Phim Sắp Chiếu:
- Layout giống "Phim đang chiếu"
- Background gradient khác (tím)
- Button "Tìm phim chiếu rạp"
- Animation hover đẹp

### ✅ Lịch Chiếu Phim:
- Filter theo vị trí (dropdown)
- Filter "Tìm rạp gần bạn"
- Chọn rạp theo brand (CGV, Lotte, Galaxy...)
- Danh sách rạp chiếu
- Calendar chọn ngày
- Thông tin suất chiếu
- Hiển thị giờ chiếu
- Responsive grid layout

---

## 🔧 TÙY CHỈNH

### Đổi màu chủ đạo:

Tìm trong các file CSS và đổi `#E91E63` (màu hồng) thành màu bạn muốn:

```css
/* Màu chính */
#E91E63 → #YOUR_COLOR

/* Màu gradient */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Thay ảnh phim:

Trong từng file `.php`, tìm:
```php
'image' => 'https://via.placeholder.com/...'
```

Đổi thành URL ảnh thật.

### Thêm/bớt phim:

Trong array `$movies`, thêm hoặc xóa item:
```php
array(
    'title' => 'Tên phim',
    'rating' => '13+',
    'genre' => 'Hành động',
    'image' => 'url-anh.jpg',
    'number' => '1'
)
```

---

## 📂 CẤU TRÚC FILES:

```
wp-content/plugins/site-layout/
├── site-layout.php (File chính - đăng ký shortcode)
├── templates/
│   ├── header.php (Header chung)
│   ├── footer.php (Footer chung)
│   ├── hero-banner.php (Section 1)
│   ├── movies-now-showing.php (Section 2)
│   ├── movies-coming-soon.php (Section 3)
│   └── movie-schedule.php (Section 4)
└── assets/
    ├── layout.css
    └── layout.js
```

---

## 🌐 QUICK TEST:

Sau khi tạo trang, truy cập:
```
http://localhost:8000/home/
```

Hoặc đặt làm trang chủ:
1. Vào **Settings → Reading**
2. Chọn "A static page"
3. Chọn page "Home" làm homepage

---

## 💡 LƯU Ý:

1. **Plugin phải được activate** trước
2. **Permalink** phải là "Post name"
3. **Template** nên chọn "Full Width"
4. Các slider có **prev/next buttons** để scroll
5. **Responsive** hoàn toàn cho mobile
6. **CSS inline** trong từng file để dễ customize

---

## 🎯 TIẾP THEO:

Tôi sẽ tiếp tục code 2 sections còn lại:
- Bình luận nổi bật
- Top phim hay

Bạn test các section đã có trước nhé!

---

**✨ Chúc code vui vẻ!**

