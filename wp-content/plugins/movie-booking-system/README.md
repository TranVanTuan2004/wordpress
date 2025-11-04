# Movie Booking System - Hệ Thống Đặt Vé Xem Phim WordPress

Plugin đặt vé xem phim hoàn chỉnh cho WordPress với giao diện đẹp mắt, chức năng chọn ghế realtime và quản lý toàn diện.

## Tính Năng

### Chức Năng Người Dùng
- ✅ Trang chủ hiển thị danh sách phim đang chiếu
- ✅ Lọc phim theo thể loại
- ✅ Trang chi tiết phim với thông tin đầy đủ
- ✅ Lịch chiếu theo rạp và ngày
- ✅ Chọn ghế ngồi trực quan (ghế thường, VIP, Sweetbox)
- ✅ Kiểm tra ghế đã đặt realtime
- ✅ Form đặt vé với thông tin khách hàng
- ✅ Gửi email xác nhận đặt vé
- ✅ Mã đặt vé unique cho mỗi booking

### Chức Năng Admin
- ✅ Dashboard với thống kê tổng quan
- ✅ Quản lý phim (thêm, sửa, xóa)
- ✅ Quản lý rạp chiếu
- ✅ Quản lý lịch chiếu
- ✅ Quản lý đặt vé (xem, duyệt, hủy)
- ✅ Thống kê doanh thu theo ngày
- ✅ Cài đặt giá vé và cấu hình ghế ngồi

## Cài Đặt

### Yêu Cầu
- WordPress 5.0 trở lên
- PHP 7.2 trở lên
- MySQL 5.6 trở lên

### Hướng Dẫn Cài Đặt

1. **Upload Plugin**
   - Upload thư mục `movie-booking-system` vào `/wp-content/plugins/`
   - Hoặc upload file zip qua WordPress Admin

2. **Kích Hoạt Plugin**
   - Vào `Plugins > Installed Plugins`
   - Tìm "Movie Booking System" và click "Activate"

3. **Tạo Các Trang**

   Tạo các trang sau trong WordPress với shortcode tương ứng:

   **Trang Chủ - Danh Sách Phim**
   ```
   [mbs_movies_list per_page="12"]
   ```

   **Trang Chi Tiết Phim**
   ```
   [mbs_movie_detail]
   ```

   **Trang Đặt Vé**
   ```
   [mbs_booking_form]
   ```

   **Trang Danh Sách Rạp**
   ```
   [mbs_cinema_list]
   ```

4. **Cấu Hình**
   - Vào `Đặt Vé Phim > Cài Đặt`
   - Thiết lập số hàng ghế, số ghế mỗi hàng
   - Cài đặt giá vé cho từng loại ghế

## Sử Dụng

### Thêm Phim Mới

1. Vào `Phim > Thêm Phim`
2. Nhập thông tin:
   - Tên phim
   - Nội dung mô tả
   - Ảnh poster
   - Thời lượng
   - Đạo diễn, diễn viên
   - Độ tuổi (P, C13, C16, C18)
   - Thể loại
   - Link trailer

### Thêm Rạp Chiếu

1. Vào `Rạp Phim > Thêm Rạp`
2. Nhập thông tin:
   - Tên rạp
   - Địa chỉ
   - Số điện thoại
   - Số phòng chiếu
   - Mô tả

### Tạo Lịch Chiếu

1. Vào `Suất Chiếu > Thêm Suất Chiếu`
2. Chọn:
   - Phim
   - Rạp chiếu
   - Thời gian chiếu
   - Phòng chiếu
   - Định dạng (2D, 3D, IMAX, 4DX)
   - Giá vé

### Quản Lý Đặt Vé

1. Vào `Đặt Vé Phim > Đặt Vé`
2. Xem danh sách tất cả đặt vé
3. Các hành động:
   - **Hoàn thành**: Xác nhận khách đã thanh toán
   - **Hủy**: Hủy đặt vé và giải phóng ghế

## Shortcodes

### [mbs_movies_list]
Hiển thị danh sách phim

**Tham số:**
- `per_page`: Số phim hiển thị (mặc định: 12)
- `genre`: Lọc theo thể loại (slug)

**Ví dụ:**
```
[mbs_movies_list per_page="20"]
[mbs_movies_list genre="hanh-dong"]
```

### [mbs_movie_detail]
Hiển thị chi tiết phim và lịch chiếu

**Tham số:**
- `id`: ID phim (tự động lấy từ URL nếu không có)

**Ví dụ:**
```
[mbs_movie_detail]
[mbs_movie_detail id="123"]
```

### [mbs_booking_form]
Form đặt vé với chọn ghế

**Tham số:**
- `showtime_id`: ID suất chiếu (tự động lấy từ URL)

**Ví dụ:**
```
[mbs_booking_form]
```

### [mbs_cinema_list]
Danh sách rạp chiếu

**Tham số:**
- `per_page`: Số rạp hiển thị (mặc định: tất cả)

**Ví dụ:**
```
[mbs_cinema_list]
```

## Cấu Trúc Database

Plugin tạo 3 bảng tùy chỉnh:

### wp_mbs_bookings
Lưu thông tin đặt vé
- id, showtime_id, customer_name, customer_email
- customer_phone, total_seats, total_price
- booking_code, payment_status, booking_date

### wp_mbs_seats
Lưu thông tin ghế đã đặt
- id, booking_id, showtime_id, seat_number
- seat_type, seat_price, status

### wp_mbs_cinema_rooms
Lưu cấu hình phòng chiếu (dành cho tương lai)
- id, cinema_id, room_name, total_rows
- seats_per_row, seat_layout

## API AJAX

### mbs_get_booked_seats
Lấy danh sách ghế đã đặt cho một suất chiếu

**Parameters:**
- `showtime_id`: ID suất chiếu

### mbs_create_booking
Tạo đặt vé mới

**Parameters:**
- `showtime_id`: ID suất chiếu
- `customer_name`: Tên khách hàng
- `customer_email`: Email
- `customer_phone`: Số điện thoại
- `seats`: JSON array của ghế đã chọn

### mbs_check_seats
Kiểm tra ghế còn trống

**Parameters:**
- `showtime_id`: ID suất chiếu
- `seat_numbers`: JSON array số ghế cần check

## Tùy Chỉnh

### Thay Đổi Màu Sắc
Chỉnh sửa file `assets/css/style.css`, tìm `:root` và thay đổi các biến:

```css
:root {
    --mbs-primary: #c71585;  /* Màu chính */
    --mbs-secondary: #ff6b9d; /* Màu phụ */
    /* ... */
}
```

### Thay Đổi Layout Ghế
Vào `Đặt Vé Phim > Cài Đặt` để thay đổi:
- Số hàng ghế
- Số ghế mỗi hàng
- Giá ghế cho từng loại

### Custom Template
Copy file từ `templates/` vào theme của bạn:
```
your-theme/
  movie-booking-system/
    movies-list.php
    movie-detail.php
    booking-form.php
```

## Hỗ Trợ

Nếu có vấn đề hoặc câu hỏi, vui lòng liên hệ.

## Changelog

### Version 1.0.0
- Phát hành lần đầu
- Tính năng đặt vé hoàn chỉnh
- Quản lý phim, rạp, lịch chiếu
- Chọn ghế realtime
- Admin panel đầy đủ

## License
GPL v2 or later

