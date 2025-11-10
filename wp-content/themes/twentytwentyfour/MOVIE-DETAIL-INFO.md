# 🎬 Trang Chi Tiết Phim - Hướng Dẫn

## ✅ Đã Tạo Xong!

File template: `single-movie.php` đã được tạo trong theme `twentytwentyfour`.

---

## 🎨 Tính Năng

### 1. **Hero Section**
- ✅ Backdrop blur effect (ảnh nền mờ)
- ✅ Poster phim lớn với rating badge
- ✅ Nút "Xem Trailer" (nếu có trailer link)
- ✅ Sticky poster khi scroll

### 2. **Thông Tin Phim**
- ✅ Breadcrumb navigation
- ✅ Tiêu đề phim (h1)
- ✅ Meta info: IMDb rating, thời lượng, ngày phát hành
- ✅ Thể loại (genre tags)
- ✅ Mô tả phim
- ✅ Đạo diễn, diễn viên
- ✅ Trạng thái (Đang chiếu/Sắp chiếu)

### 3. **Action Buttons**
- ✅ Nút "Đặt vé ngay" (primary)
- ✅ Nút "Yêu thích" (secondary)

### 4. **Phim Liên Quan**
- ✅ Hiển thị 6 phim cùng thể loại
- ✅ Grid layout responsive
- ✅ Hover effects đẹp

---

## 📊 Dữ Liệu Hiển Thị

Template tự động lấy các meta fields từ phim:

| Meta Key | Mô tả | Mặc định |
|----------|-------|---------|
| `movie_rating` | Phân loại độ tuổi | P |
| `movie_duration` | Thời lượng (phút) | 120 |
| `movie_release_date` | Ngày phát hành | Đang cập nhật |
| `movie_trailer_link` | Link trailer | - |
| `movie_imdb_rating` | Điểm IMDb | 0.0 |
| `movie_director` | Đạo diễn | Đang cập nhật |
| `movie_cast` | Diễn viên | Đang cập nhật |

**Taxonomies:**
- `movie_genre` - Thể loại phim
- `movie_status` - Trạng thái (Đang chiếu/Sắp chiếu)

---

## 🎯 Cách Sử Dụng

### Bước 1: Vào trang phim bất kỳ
```
http://localhost:8000/phim/ten-phim/
```

### Bước 2: Template tự động hiển thị
WordPress sẽ tự động sử dụng `single-movie.php` cho tất cả post type `movie`.

---

## 🎨 Màu Sắc

**Theme màu chính:**
- Primary: Cam-Đỏ gradient (#f59e0b → #ef4444)
- Background: Đen-Xám (#0f0f0f → #1a1a1a)
- Text: Trắng/Xám (#f3f4f6 / #9ca3af)
- Accent: Vàng (#fbbf24)

---

## 📱 Responsive

✅ Desktop (> 1024px)  
✅ Tablet (768px - 1024px)  
✅ Mobile (< 768px)

---

## 🔗 URL Mẫu

Ví dụ các URL phim:
- `http://localhost:8000/phim/phim-hanh-dong/`
- `http://localhost:8000/phim/phim-sap-ra-mat/`
- `http://localhost:8000/phim/ten-phim-bat-ky/`

---

## ✨ Effects

- 🎭 Backdrop blur cho hero section
- 🎯 Sticky poster khi scroll
- ✨ Hover animations trên cards
- 💫 Smooth transitions
- 🎨 Gradient overlays

---

## 🛠️ Tùy Chỉnh

Muốn thay đổi design? Edit file:
```
wp-content/themes/twentytwentyfour/single-movie.php
```

CSS nằm trong thẻ `<style>` cuối file.

---

## 📝 Lưu Ý

1. **Header & Footer**: Template sử dụng `get_header()` và `get_footer()` của theme
2. **Placeholder Images**: Nếu không có poster, sẽ dùng ảnh placeholder
3. **Related Movies**: Tự động lấy phim cùng thể loại
4. **Meta Fields**: Đảm bảo các custom fields đã được thêm khi tạo phim

---

## 🚀 Nâng Cao

Muốn thêm tính năng:
- 🎟️ Tích hợp booking system
- 💬 Phần bình luận
- ⭐ Rating system
- 📹 Embedded trailer player
- 📊 Lịch chiếu cụ thể

Chỉ cần thêm code vào file `single-movie.php`!

---

Trang đã sẵn sàng! Vào bất kỳ phim nào để xem! 🎉

