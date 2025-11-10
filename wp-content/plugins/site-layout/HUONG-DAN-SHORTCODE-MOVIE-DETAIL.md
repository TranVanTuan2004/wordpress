# 🎬 Shortcode `[movie_detail]` - Chi Tiết Phim

## ✅ Shortcode Mới Đã Tạo!

Bây giờ bạn có thể hiển thị chi tiết phim **ở bất kỳ trang nào** bằng shortcode!

---

## 🎯 Cách Sử Dụng

### **Cú pháp cơ bản:**

```
[movie_detail id="123"]
```

**Trong đó:**
- `id` = ID của phim (bắt buộc)

---

## 📝 Hướng Dẫn Chi Tiết

### **Bước 1: Tìm ID của phim**

#### **Cách 1: Từ danh sách phim**
1. Vào **WordPress Admin** → **Phim** → **Tất cả phim**
2. Di chuột qua tên phim
3. Xem URL ở dưới cùng trình duyệt:
   ```
   http://localhost:8000/wp-admin/post.php?post=123&action=edit
                                               ^^^
                                               ID phim
   ```

#### **Cách 2: Từ trang edit phim**
1. Mở phim để chỉnh sửa
2. Xem URL trên thanh địa chỉ:
   ```
   http://localhost:8000/wp-admin/post.php?post=456&action=edit
                                               ^^^
                                               ID là 456
   ```

---

### **Bước 2: Tạo trang mới hoặc edit trang có sẵn**

1. Vào **Trang** → **Thêm mới** (hoặc Edit trang có sẵn)
2. Thêm nội dung bình thường của bạn
3. Chèn shortcode vào vị trí muốn hiển thị:

```
# Giới thiệu phim mới

Lorem ipsum dolor sit amet...

[movie_detail id="123"]

## Đánh giá của khán giả

Lorem ipsum dolor sit amet...

[movie_detail id="456"]
```

---

## 💡 Ví Dụ Thực Tế

### **Ví dụ 1: Trang giới thiệu phim hot**

```
# Top 5 Phim Hot Tháng Này

## 1. Phim hành động siêu đỉnh
[movie_detail id="101"]

## 2. Phim tình cảm lãng mạn
[movie_detail id="102"]

## 3. Phim kinh dị gay cấn
[movie_detail id="103"]
```

### **Ví dụ 2: Trang so sánh 2 phim**

```
# So Sánh Hai Bom Tấn

## Phim A
[movie_detail id="201"]

## Phim B
[movie_detail id="202"]

Bạn thích phim nào hơn? Vote ngay!
```

### **Ví dụ 3: Nhúng trong widget hoặc sidebar**

Nếu theme hỗ trợ, bạn có thể thêm vào **Widget Text**:

```
[movie_detail id="301"]
```

---

## 🎨 Tính Năng Shortcode

Shortcode `[movie_detail]` hiển thị:

✅ **Poster phim lớn** với rating badge  
✅ **Nút "Xem Trailer"** (nếu có)  
✅ **Thông tin meta**: IMDb, thời lượng, ngày phát hành  
✅ **Thể loại phim** (genre tags)  
✅ **Mô tả chi tiết**  
✅ **Đạo diễn & diễn viên**  
✅ **Trạng thái** (Đang chiếu/Sắp chiếu)  
✅ **Nút "Xem chi tiết đầy đủ"** → Link đến trang single-movie.php  
✅ **Nút "Đặt vé ngay"**  

---

## 🎯 Phân Biệt với `single-movie.php`

| Tính năng | `single-movie.php` | `[movie_detail]` shortcode |
|-----------|-------------------|---------------------------|
| **Khi nào dùng** | Tự động khi vào `/phim/slug/` | Nhúng vào bất kỳ trang nào |
| **URL riêng** | ✅ Có | ❌ Không |
| **Phim liên quan** | ✅ Có | ❌ Không |
| **Hero backdrop** | ✅ Có | ❌ Không |
| **Sticky poster** | ✅ Có | ❌ Không |
| **Hiển thị nhiều phim** | ❌ Mỗi URL 1 phim | ✅ Có thể nhiều phim/trang |
| **Linh hoạt** | ❌ Template cố định | ✅ Nhúng ở đâu cũng được |

---

## 🚀 Demo Nhanh

### **Test ngay:**

1. Tạo trang mới: **"Phim Nổi Bật"**
2. Paste vào:
   ```
   [movie_detail id="1"]
   [movie_detail id="2"]
   ```
3. **Publish** → Xem trang!

---

## ⚠️ Lỗi Thường Gặp

### **1. Hiển thị: "⚠️ Vui lòng cung cấp ID phim"**
**Nguyên nhân:** Thiếu `id` hoặc `id="0"`  
**Cách fix:**
```
❌ SAI: [movie_detail]
✅ ĐÚNG: [movie_detail id="123"]
```

### **2. Hiển thị: "⚠️ Không tìm thấy phim"**
**Nguyên nhân:** ID không tồn tại hoặc không phải post type `movie`  
**Cách fix:**
- Check lại ID phim trong WordPress Admin
- Đảm bảo phim đã được publish

### **3. Shortcode hiển thị dạng text thuần**
**Nguyên nhân:** Plugin "Site Layout" chưa active  
**Cách fix:**
- Vào **Plugins** → Kích hoạt **"Site Layout - Header & Footer"**

---

## 🎨 Tùy Chỉnh CSS

Muốn thay đổi màu sắc hoặc layout?  
Edit file:
```
wp-content/plugins/site-layout/templates/movie-detail-shortcode.php
```

CSS nằm trong thẻ `<style>` cuối file.

**Các class chính:**
- `.movie-detail-shortcode` - Container chính
- `.movie-poster-wrapper` - Khung poster
- `.movie-detail-title` - Tiêu đề phim
- `.btn-watch-trailer` - Nút xem trailer
- `.btn-book-ticket` - Nút đặt vé

---

## 🔗 Shortcodes Khác

Plugin **Site Layout** cung cấp các shortcode:

- `[site_header]` - Header
- `[site_footer]` - Footer
- `[hero_banner]` - Banner chính
- `[movies_now_showing]` - Phim đang chiếu
- `[movies_coming_soon]` - Phim sắp chiếu
- `[movie_schedule]` - Lịch chiếu phim
- `[movie_detail id="XX"]` - Chi tiết 1 phim ⭐ MỚI
- `[full_home_page]` - Trang home đầy đủ
- `[debug_movies]` - Debug data

---

## 💡 Mẹo Hay

### **Mẹo 1: Tạo trang "Featured Movies"**
```
# Top Phim Tuần Này

[movie_detail id="101"]
[movie_detail id="102"]
[movie_detail id="103"]
```

### **Mẹo 2: Tạo landing page cho từng thể loại**
**Trang "Phim Hành Động":**
```
# Phim Hành Động Hay Nhất

[movie_detail id="201"]
[movie_detail id="202"]
```

**Trang "Phim Kinh Dị":**
```
# Phim Kinh Dị Rợn Gai Ốc

[movie_detail id="301"]
[movie_detail id="302"]
```

### **Mẹo 3: Kết hợp với nội dung khác**
```
# Review Chi Tiết

Hôm nay chúng tôi sẽ review siêu phẩm:

[movie_detail id="401"]

## Điểm mạnh
- Kịch bản chặt chẽ
- Diễn xuất xuất sắc
- Hiệu ứng đỉnh cao

## Điểm yếu
- Hơi dài
- Phần cuối hơi chậm
```

---

## 📊 Responsive

Shortcode tự động responsive:
- ✅ Desktop: 2 cột (poster + info)
- ✅ Tablet: 2 cột thu nhỏ
- ✅ Mobile: 1 cột xếp dọc

---

## ✨ Kết Luận

Bây giờ bạn có thể:
1. ✅ Hiển thị chi tiết phim ở **bất kỳ đâu**
2. ✅ Tạo trang **giới thiệu nhiều phim**
3. ✅ **Linh hoạt** hơn với content

**Happy coding!** 🎬✨

---

Cần hỗ trợ? Check file này hoặc hỏi ngay! 🚀

