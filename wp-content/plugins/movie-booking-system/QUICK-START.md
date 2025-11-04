# Hướng Dẫn Setup Nhanh - Movie Booking System

## Bước 1: Kích Hoạt Plugin

1. Vào `Plugins > Installed Plugins`
2. Tìm "Movie Booking System"
3. Click "Activate"

Plugin sẽ tự động tạo:
- 3 Custom Post Types: Phim, Rạp Phim, Suất Chiếu
- 3 Database tables cho bookings và seats
- Các cài đặt mặc định

## Bước 2: Tạo Các Trang Cần Thiết

Vào `Pages > Add New` và tạo các trang sau:

### Trang 1: Danh Sách Phim (Trang Chủ)
- **Tên trang**: Phim Đang Chiếu
- **URL slug**: phim
- **Nội dung**: 
```
[mbs_movies_list per_page="12"]
```

### Trang 2: Chi Tiết Phim
- **Tên trang**: Chi Tiết Phim
- **URL slug**: chi-tiet-phim
- **Nội dung**: 
```
[mbs_movie_detail]
```

### Trang 3: Đặt Vé
- **Tên trang**: Đặt Vé
- **URL slug**: dat-ve
- **Nội dung**: 
```
[mbs_booking_form]
```

### Trang 4: Danh Sách Rạp (Optional)
- **Tên trang**: Hệ Thống Rạp
- **URL slug**: he-thong-rap
- **Nội dung**: 
```
[mbs_cinema_list]
```

## Bước 3: Cấu Hình Cơ Bản

1. Vào `Đặt Vé Phim > Cài Đặt`
2. Thiết lập:
   - Số hàng ghế: **10** (hoặc tùy chọn)
   - Số ghế mỗi hàng: **17** (hoặc tùy chọn)
   - Giá ghế thường: **70,000 VNĐ**
   - Giá ghế VIP: **100,000 VNĐ**
   - Giá ghế Sweetbox: **150,000 VNĐ**
3. Click "Lưu Cài Đặt"

## Bước 4: Thêm Dữ Liệu

### Cách 1: Thêm Thủ Công

#### Thêm Rạp Phim
1. Vào `Rạp Phim > Thêm Rạp`
2. Nhập thông tin:
   - Tên rạp: CGV Vincom Mega Mall
   - Địa chỉ: Tầng L5, Vincom Mega Mall Grand Park
   - Điện thoại: 1900 6017
   - Số phòng chiếu: 8
3. Click "Publish"

#### Thêm Phim
1. Vào `Phim > Thêm Phim`
2. Nhập thông tin:
   - Tên phim: Phá Đảm: Sinh Nhật Mẹ
   - Nội dung: [Mô tả phim]
   - Thời lượng: 120 phút
   - Đạo diễn: [Tên đạo diễn]
   - Diễn viên: [Danh sách diễn viên]
   - Độ tuổi: C13
   - Thể loại: Hài Hước
   - Upload ảnh poster
3. Click "Publish"

#### Thêm Lịch Chiếu
1. Vào `Suất Chiếu > Thêm Suất Chiếu`
2. Chọn:
   - Phim: [Chọn phim vừa tạo]
   - Rạp: [Chọn rạp vừa tạo]
   - Thời gian chiếu: [Chọn ngày giờ]
   - Phòng chiếu: Phòng 3
   - Định dạng: 2D
   - Giá vé: 70,000 VNĐ
3. Click "Publish"

### Cách 2: Tạo Dữ Liệu Mẫu (Khuyên Dùng)

**Đang phát triển**: Tính năng tạo dữ liệu mẫu tự động sẽ có trong phiên bản tiếp theo.

Hiện tại bạn có thể chạy code sau trong WordPress Admin > Tools > Site Health > Info > (tab) Debug > Copy code sau vào console:

```php
// Uncomment dòng dưới trong file class-mbs-admin.php để thêm nút "Import Sample Data"
// MBS_Sample_Data::install();
```

## Bước 5: Kiểm Tra

1. **Kiểm tra trang danh sách phim**:
   - Vào URL: `your-site.com/phim`
   - Bạn sẽ thấy danh sách phim (nếu đã thêm)

2. **Kiểm tra chi tiết phim**:
   - Click vào một phim bất kỳ
   - Xem thông tin chi tiết và lịch chiếu

3. **Kiểm tra đặt vé**:
   - Click vào một suất chiếu
   - Chọn ghế ngồi
   - Điền thông tin và đặt vé

4. **Kiểm tra admin**:
   - Vào `Đặt Vé Phim > Dashboard`
   - Xem thống kê
   - Vào `Đặt Vé` để xem booking vừa tạo

## Bước 6: Tùy Chỉnh (Optional)

### Thay Đổi Màu Sắc
Chỉnh sửa file `assets/css/style.css` và thay đổi biến CSS:

```css
:root {
    --mbs-primary: #c71585;  /* Màu chính - thay đổi theo ý bạn */
    --mbs-secondary: #ff6b9d; /* Màu phụ */
}
```

### Thêm Vào Menu
1. Vào `Appearance > Menus`
2. Thêm các trang vừa tạo vào menu:
   - Phim Đang Chiếu
   - Hệ Thống Rạp

### Thiết Lập Email
Cấu hình SMTP trong WordPress để email xác nhận được gửi đi:
- Cài plugin WP Mail SMTP
- Cấu hình Gmail/Outlook SMTP

## Xử Lý Lỗi Thường Gặp

### Lỗi 404 khi vào trang phim
**Giải pháp**: Vào `Settings > Permalinks` và click "Save Changes"

### CSS không hiển thị đúng
**Giải pháp**: 
1. Clear cache trình duyệt (Ctrl + Shift + Del)
2. Nếu dùng cache plugin, xóa cache

### Không thấy menu "Đặt Vé Phim" trong admin
**Giải pháp**: Đảm bảo plugin đã được kích hoạt và refresh trang

### Email không gửi được
**Giải pháp**: 
1. Cài plugin WP Mail SMTP
2. Hoặc kiểm tra hosting có hỗ trợ mail() function không

## Hỗ Trợ

Nếu gặp vấn đề:
1. Kiểm tra `Dashboard > Site Health`
2. Enable WP_DEBUG trong wp-config.php
3. Xem error log

## Next Steps

Sau khi setup xong:
- Thêm nhiều phim và rạp hơn
- Tạo lịch chiếu cho tuần
- Tùy chỉnh giao diện theo theme của bạn
- Cấu hình payment gateway (tính năng sắp có)
- Thêm mã giảm giá (tính năng sắp có)

---

**Lưu ý**: Đây là phiên bản 1.0.0, các tính năng nâng cao sẽ được cập nhật trong các phiên bản tiếp theo.

