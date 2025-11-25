# RIOT Cinema Complete Data Seeder

## 🎬 Plugin hoàn chỉnh để seed dữ liệu test

Plugin này sẽ tạo đầy đủ dữ liệu mẫu để test tất cả các tính năng của RIOT Cinema theme.

## 📦 Dữ liệu được tạo

### 1. **10 Phim** (Movies)
- The Dark Knight (Action, 9.0 IMDb)
- Inception (Sci-Fi, 8.8 IMDb)
- Interstellar (Sci-Fi, 8.7 IMDb)
- Parasite (Thriller, 8.5 IMDb)
- Avengers: Endgame (Action, 8.4 IMDb)
- Joker (Drama, 8.4 IMDb)
- Spider-Man: No Way Home (Action, 8.2 IMDb)
- The Shawshank Redemption (Drama, 9.3 IMDb)
- Pulp Fiction (Crime, 8.9 IMDb)
- The Matrix (Sci-Fi, 8.7 IMDb)

**Mỗi phim bao gồm:**
- Tiêu đề và mô tả chi tiết
- Thể loại (Genre taxonomy)
- Trạng thái (Đang chiếu/Sắp chiếu)
- Độ tuổi (13+, 16+, 18+)
- Thời lượng (phút)
- Ngày khởi chiếu
- Link trailer YouTube
- Điểm IMDb

### 2. **8 Rạp Chiếu Phim** (Cinemas)
- RIOT Cinema Hà Nội (8 phòng, 1200 ghế)
- RIOT Cinema Sài Gòn (10 phòng, 1500 ghế)
- RIOT Cinema Đà Nẵng (6 phòng, 900 ghế)
- RIOT Cinema Cần Thơ (5 phòng, 750 ghế)
- RIOT Cinema Hải Phòng (7 phòng, 1050 ghế)
- RIOT Cinema Nha Trang (5 phòng, 800 ghế)
- RIOT Cinema Huế (4 phòng, 600 ghế)
- RIOT Cinema Vũng Tàu (4 phòng, 650 ghế)

**Mỗi rạp bao gồm:**
- Tên và mô tả
- Địa chỉ đầy đủ
- Số điện thoại
- Số phòng chiếu
- Tổng số ghế

### 3. **15 Bài Viết Blog** (Blog Posts)
Các bài viết về:
- Review phim
- Tin tức điện ảnh
- Hướng dẫn đặt vé
- Công nghệ rạp chiếu
- Xu hướng điện ảnh
- Tips xem phim

### 4. **30 Lịch Chiếu** (Showtimes)
- Tự động tạo lịch chiếu cho các phim
- Phân bổ ngẫu nhiên qua các rạp
- Nhiều khung giờ: 10:00, 13:00, 16:00, 19:00, 22:00
- Giá vé và số ghế trống

### 5. **5 Tài Khoản Test** (Users)
- `testuser1` / Test@123 (Subscriber) - Nguyễn Văn A
- `testuser2` / Test@123 (Subscriber) - Trần Thị B
- `testuser3` / Test@123 (Subscriber) - Lê Văn C
- `testeditor` / Test@123 (Editor)
- `testauthor` / Test@123 (Author)

## 🚀 Cách sử dụng

### Bước 1: Kích hoạt plugin
1. Vào **WordPress Admin → Plugins**
2. Tìm **"RIOT Cinema Complete Data Seeder"**
3. Click **Activate**

### Bước 2: Seed dữ liệu
1. Vào **WordPress Admin → RIOT Seeder** (menu bên trái)
2. Click nút **"🚀 Seed All Data Now"**
3. Đợi vài giây để plugin tạo tất cả dữ liệu

### Bước 3: Kiểm tra
- **Phim**: Admin → Phim
- **Rạp**: Admin → Rạp Phim
- **Blog**: Admin → Posts
- **Trang chủ**: Xem phim và rạp hiển thị
- **Tìm kiếm**: Test chức năng search
- **Đăng nhập**: Dùng các tài khoản test

## ✅ Lợi ích

- ✅ **Tiết kiệm thời gian**: Không cần tạo dữ liệu thủ công
- ✅ **Dữ liệu đầy đủ**: Test được tất cả tính năng
- ✅ **Dữ liệu thực tế**: Phim và rạp có thông tin chi tiết
- ✅ **Dễ dàng reset**: Xóa và seed lại bất cứ lúc nào
- ✅ **Đa dạng**: Nhiều thể loại, trạng thái, rạp khác nhau

## 🔄 Reset dữ liệu

Nếu muốn reset và seed lại:
1. Xóa tất cả Movies, Cinemas, Posts cũ
2. Chạy lại seeder từ **RIOT Seeder** menu

## 📝 Ghi chú

- Plugin an toàn, không ghi đè dữ liệu có sẵn
- Có thể chạy nhiều lần (sẽ tạo thêm dữ liệu mới)
- Tất cả dữ liệu đều ở trạng thái "publish"
- Showtimes được lưu dưới dạng post meta

## 🎯 Test Cases

Sau khi seed, bạn có thể test:
- ✅ Trang chủ hiển thị danh sách phim
- ✅ Trang chi tiết phim với đầy đủ thông tin
- ✅ Trang chi tiết rạp
- ✅ Chức năng tìm kiếm phim/rạp
- ✅ Menu "Chọn rạp" hiển thị danh sách
- ✅ Blog posts và archive
- ✅ Đăng nhập với user test
- ✅ Favorites (yêu thích phim)
- ✅ Comments (bình luận)

---

**Tác giả**: RIOT Cinema Development Team  
**Version**: 1.0  
**Yêu cầu**: WordPress 5.0+, RIOT Cinema Theme
