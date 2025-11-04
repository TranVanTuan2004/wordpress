# Hướng Dẫn Sử Dụng - Movie Booking System

## Dành Cho Người Quản Trị

### 1. Quản Lý Phim

#### Thêm Phim Mới

1. **Truy cập**: Admin Dashboard > Phim > Thêm Phim

2. **Điền Thông Tin Cơ Bản**:
   - **Tên phim**: Nhập tên phim (bắt buộc)
   - **Nội dung**: Mô tả chi tiết về phim
   - **Excerpt**: Tóm tắt ngắn (tự động tạo nếu để trống)

3. **Upload Poster**:
   - Click "Set featured image"
   - Upload ảnh poster (khuyến nghị: 600x900px, tỷ lệ 2:3)
   - Set as featured image

4. **Thông Tin Chi Tiết**:
   - **Thời lượng**: Nhập số phút (VD: 120)
   - **Đạo diễn**: Tên đạo diễn
   - **Diễn viên**: Danh sách diễn viên (cách nhau bằng dấu phẩy)
   - **Độ tuổi**: Chọn P, C13, C16, hoặc C18
   - **Ngôn ngữ**: VD: Phụ đề, Lồng tiếng
   - **Link Trailer**: URL YouTube

5. **Chọn Thể Loại**:
   - Tick vào các thể loại phù hợp
   - Có thể chọn nhiều thể loại

6. Click **"Publish"**

#### Sửa Phim

1. Vào **Phim > All Phim**
2. Hover vào phim cần sửa
3. Click **"Edit"**
4. Chỉnh sửa thông tin
5. Click **"Update"**

#### Xóa Phim

1. Vào **Phim > All Phim**
2. Hover vào phim cần xóa
3. Click **"Trash"**

**Lưu ý**: Khi xóa phim, các suất chiếu liên quan sẽ bị ảnh hưởng.

---

### 2. Quản Lý Rạp

#### Thêm Rạp Mới

1. **Truy cập**: Admin Dashboard > Rạp Phim > Thêm Rạp

2. **Điền Thông Tin**:
   - **Tên rạp**: VD: CGV Vincom Mega Mall
   - **Địa chỉ**: Địa chỉ đầy đủ
   - **Số điện thoại**: VD: 1900 6017
   - **Số phòng chiếu**: VD: 8

3. **Upload Ảnh Rạp** (Optional):
   - Set featured image

4. Click **"Publish"**

---

### 3. Quản Lý Lịch Chiếu

#### Tạo Suất Chiếu

1. **Truy cập**: Admin Dashboard > Suất Chiếu > Thêm Suất Chiếu

2. **Chọn Phim và Rạp**:
   - **Phim**: Chọn phim từ dropdown
   - **Rạp**: Chọn rạp từ dropdown

3. **Thông Tin Suất Chiếu**:
   - **Thời gian chiếu**: Chọn ngày và giờ (format: dd/mm/yyyy hh:mm)
   - **Phòng chiếu**: VD: Phòng 3
   - **Định dạng**: Chọn 2D, 3D, IMAX, hoặc 4DX
   - **Giá vé**: Nhập giá (VD: 70000)

4. Click **"Publish"**

#### Tips Tạo Lịch Chiếu:

**Cho mỗi phim, nên tạo nhiều suất chiếu**:
- Buổi sáng: 10:00, 10:30
- Buổi trưa: 13:00, 13:30, 14:00
- Buổi chiều: 16:00, 16:30, 17:00
- Buổi tối: 18:30, 19:00, 21:00, 22:00
- Buổi khuya: 23:00, 23:30

**Tạo cho nhiều ngày**:
- Ít nhất 7 ngày tiếp theo
- Update hàng tuần

---

### 4. Quản Lý Đặt Vé

#### Xem Danh Sách Đặt Vé

1. **Truy cập**: Admin Dashboard > Đặt Vé Phim > Đặt Vé

2. **Thông tin hiển thị**:
   - Mã đặt vé
   - Tên khách hàng
   - Email, điện thoại
   - Số ghế, tổng tiền
   - Trạng thái
   - Ngày đặt

#### Duyệt Đặt Vé (Xác Nhận Thanh Toán)

1. Tìm booking có trạng thái **"Chờ thanh toán"**
2. Click nút **"Hoàn thành"**
3. Trạng thái sẽ chuyển sang **"Đã thanh toán"**

#### Hủy Đặt Vé

1. Tìm booking cần hủy
2. Click nút **"Hủy"**
3. Confirm trong popup
4. Ghế sẽ được giải phóng và khách khác có thể đặt

**Lưu ý**: Chỉ hủy khi:
- Khách hàng yêu cầu
- Thanh toán không thành công
- Phát hiện booking spam

---

### 5. Dashboard & Thống Kê

#### Dashboard Overview

**Truy cập**: Admin Dashboard > Đặt Vé Phim > Dashboard

**Các chỉ số hiển thị**:
1. **Tổng Đặt Vé**: Tổng số booking từ trước đến nay
2. **Đặt Vé Hôm Nay**: Số booking trong ngày
3. **Tổng Doanh Thu**: Doanh thu từ các booking đã hoàn thành
4. **Đang Chờ Thanh Toán**: Số booking pending

**Đặt Vé Gần Đây**: Bảng 10 booking mới nhất

#### Thống Kê Chi Tiết

**Truy cập**: Admin Dashboard > Đặt Vé Phim > Thống Kê

**Báo cáo 30 ngày**:
- Số đặt vé theo ngày
- Doanh thu theo ngày
- Xu hướng tăng/giảm

**Cách sử dụng**:
- Theo dõi hiệu suất kinh doanh
- Phát hiện ngày cao điểm
- Lên kế hoạch marketing

---

### 6. Cài Đặt

**Truy cập**: Admin Dashboard > Đặt Vé Phim > Cài Đặt

#### Cấu Hình Ghế Ngồi

**Số Hàng Ghế**:
- Mặc định: 10
- Khuyến nghị: 8-15 hàng
- Tùy theo kích thước phòng thực tế

**Số Ghế Mỗi Hàng**:
- Mặc định: 17
- Khuyến nghị: 12-20 ghế
- Số lẻ để có ghế giữa

#### Cấu Hình Giá

**Giá Ghế Thường**:
- Mặc định: 70,000 VNĐ
- Hàng A-C

**Giá Ghế VIP**:
- Mặc định: 100,000 VNĐ
- Hàng D-I
- Giá cao hơn 30-50%

**Giá Ghế Sweetbox**:
- Mặc định: 150,000 VNĐ
- Hàng J trở đi
- Ghế đôi, giá gấp đôi ghế thường

**Lưu ý**: Giá này là giá cơ bản. Mỗi suất chiếu có thể set giá riêng.

---

## Dành Cho Khách Hàng

### 1. Xem Phim Đang Chiếu

1. Vào trang **"Phim Đang Chiếu"**
2. Duyệt danh sách phim
3. Click vào poster hoặc tên phim để xem chi tiết

**Tính năng**:
- Lọc theo thể loại
- Xem thông tin: thời lượng, thể loại, diễn viên
- Xem trailer

---

### 2. Xem Chi Tiết Phim

**Thông tin hiển thị**:
- Poster phim
- Tên phim
- Độ tuổi
- Thời lượng
- Đạo diễn, diễn viên
- Ngôn ngữ
- Nội dung phim
- Link trailer

**Lịch Chiếu**:
- Nhóm theo rạp
- Hiển thị theo ngày
- Các suất chiếu trong ngày
- Giá vé
- Định dạng (2D, 3D, IMAX)

---

### 3. Đặt Vé

#### Bước 1: Chọn Suất Chiếu

1. Từ trang chi tiết phim
2. Tìm rạp gần nhất
3. Chọn ngày phù hợp
4. Click vào giờ chiếu muốn đặt

#### Bước 2: Chọn Ghế

**Hiểu sơ đồ ghế**:
- **Màu xanh nhạt**: Ghế thường (rẻ nhất)
- **Màu đỏ nhạt**: Ghế VIP (giá trung bình)
- **Màu vàng**: Ghế Sweetbox (đắt nhất, ghế đôi)
- **Màu xám**: Đã được đặt (không chọn được)
- **Màu hồng đậm**: Ghế bạn đang chọn

**Cách chọn ghế**:
1. Click vào ghế trống để chọn
2. Click lại để bỏ chọn
3. Có thể chọn nhiều ghế
4. Xem tổng tiền ở dưới màn hình

**Tips chọn ghế tốt**:
- Ghế giữa (cột 8-10) có góc nhìn đẹp nhất
- Hàng F-H là vị trí vàng
- Tránh hàng đầu (quá gần màn hình)
- Tránh hàng cuối (góc nhìn không tốt)

#### Bước 3: Điền Thông Tin

1. Click nút **"Tiếp tục"**
2. Điền form:
   - **Họ và tên**: Tên đầy đủ
   - **Email**: Email hợp lệ (nhận xác nhận)
   - **Số điện thoại**: 10 số

3. Kiểm tra lại:
   - Số ghế đã chọn
   - Ghế nào
   - Tổng tiền

4. Click **"Xác nhận đặt vé"**

#### Bước 4: Hoàn Tất

**Sau khi đặt thành công**:
- Hiển thị mã đặt vé (VD: MBS12ABC34D)
- Email xác nhận được gửi
- Lưu lại mã đặt vé

**Đến rạp**:
- Mang theo mã đặt vé
- Đến trước giờ chiếu 15-20 phút
- Thanh toán tại quầy (nếu chưa thanh toán online)
- Nhận vé và vào phòng

---

## Xử Lý Vấn Đề

### Lỗi Thường Gặp

#### "Ghế đã được đặt"

**Nguyên nhân**: Người khác vừa đặt ghế đó

**Giải pháp**:
1. Chọn ghế khác
2. Refresh trang để xem ghế mới nhất
3. Đặt nhanh để tránh mất ghế

#### "Có lỗi xảy ra"

**Giải pháp**:
1. Kiểm tra kết nối internet
2. Refresh trang
3. Thử lại sau vài phút
4. Liên hệ support nếu vẫn lỗi

#### Không nhận được email

**Giải pháp**:
1. Kiểm tra spam folder
2. Kiểm tra email đã nhập đúng chưa
3. Chờ 5-10 phút
4. Liên hệ support với mã đặt vé

---

## FAQ

### Q: Tôi có thể hủy vé đã đặt không?

**A**: Liên hệ hotline hoặc email support với mã đặt vé. Chính sách hủy tùy theo từng rạp.

### Q: Tôi đặt nhầm suất chiếu, làm sao?

**A**: Liên hệ support ngay để được hỗ trợ đổi suất (nếu còn ghế trống).

### Q: Ghế tôi chọn có được giữ trong bao lâu?

**A**: Không có giữ ghế tự động. Vui lòng hoàn tất đặt vé ngay.

### Q: Tôi có thể đặt bao nhiêu ghế một lúc?

**A**: Không giới hạn, nhưng khuyến nghị tối đa 10 ghế/booking.

### Q: Thanh toán khi nào?

**A**: Có thể thanh toán online (nếu tích hợp) hoặc tại quầy khi đến rạp.

### Q: Giá vé có bao gồm VAT chưa?

**A**: Có, giá đã bao gồm VAT và các loại phí.

### Q: Trẻ em có phải mua vé không?

**A**: Trẻ em trên 0.9m cần mua vé riêng. Quy định chi tiết tùy rạp.

---

## Liên Hệ Hỗ Trợ

- **Email**: support@example.com
- **Hotline**: 1900-xxxx
- **Giờ làm việc**: 8:00 - 22:00 hàng ngày

---

**Chúc bạn có trải nghiệm xem phim tuyệt vời!** 🎬🍿

