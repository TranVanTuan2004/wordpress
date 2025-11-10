# 🎬 HƯỚNG DẪN QUẢN LÝ PHIM TỪ BACKEND

## ✅ ĐÃ CẬP NHẬT:

Plugin **Movies CPT** + Templates đã được update để lấy data từ backend thay vì hardcode!

---

## 📝 BƯỚC 1: KÍCH HOẠT PLUGIN

1. Vào **Plugins**
2. Tìm **"Movies CPT"**
3. Nhấn **Activate**

Sau khi activate, bạn sẽ thấy menu **"Phim"** ở sidebar admin!

---

## 🎬 BƯỚC 2: THÊM PHIM MỚI

### 1. Vào **Phim → Thêm Phim**

### 2. Nhập thông tin cơ bản:
- **Title:** Tên phim (VD: "Phá Đảm: Sinh Nhật Mẹ")
- **Content:** Mô tả phim, synopsis
- **Featured Image:** Upload poster phim (QUAN TRỌNG!)

### 3. Điền **Thông Tin Phim** (Meta Box):
- **Độ Tuổi:** P, 13+, 16+, hoặc 18+
- **Thời Lượng:** Số phút (VD: 120)
- **Ngày Khởi Chiếu:** Chọn ngày (VD: 2025-11-10)
- **Link Trailer:** URL YouTube trailer
- **Điểm IMDb:** 0-10 (VD: 8.5)

### 4. Chọn **Thể Loại** (bên phải):
- Tích chọn: Hành Động, Kinh Dị, Hài, Chính Kịch, etc.
- Nếu chưa có, nhấn **"+ Add New Movie Genre"**

### 5. Chọn **Trạng Thái** (bên phải):
- **Đang chiếu** → Hiển thị ở section "Phim đang chiếu"
- **Sắp chiếu** → Hiển thị ở section "Phim sắp chiếu"

### 6. Nhấn **Publish!**

---

## 🏷️ BƯỚC 3: TẠO TAXONOMY (LẦN ĐẦU)

### A. Tạo Trạng Thái (Movie Status):

1. Vào **Phim → Trạng Thái**
2. Thêm 2 terms:
   - **Name:** Đang chiếu, **Slug:** `dang-chieu`
   - **Name:** Sắp chiếu, **Slug:** `sap-chieu`

### B. Tạo Thể Loại (Movie Genre):

1. Vào **Phim → Thể Loại**
2. Thêm các thể loại:
   - Hành Động
   - Kinh Dị
   - Hài
   - Chính Kịch
   - Khoa Học Viễn Tưởng
   - Lãng Mạn
   - Tài Liệu
   - Hoạt Hình
   - etc.

---

## 🎯 CÁCH HOẠT ĐỘNG:

### Section "Phim Đang Chiếu":
```
Query:
- post_type: 'movie'
- taxonomy: 'movie_status'
- term: 'dang-chieu'
- orderby: release_date DESC (mới nhất trước)
- limit: 10 phim
```

### Section "Phim Sắp Chiếu":
```
Query:
- post_type: 'movie'
- taxonomy: 'movie_status'
- term: 'sap-chieu'
- orderby: release_date ASC (sắp chiếu sớm nhất trước)
- limit: 10 phim
```

---

## 💡 VÍ DỤ THÊM PHIM:

### Phim 1: "Phá Đảm: Sinh Nhật Mẹ"
```
Title: Phá Đảm: Sinh Nhật Mẹ
Độ tuổi: 16+
Thời lượng: 98 phút
Ngày khởi chiếu: 2025-11-10
IMDb: 8.6
Thể loại: Chính Kịch, Gia Đình, Gay Cấn
Trạng thái: Đang chiếu
Featured Image: Upload poster phim
```

### Phim 2: "Godzilla Minus One"
```
Title: Godzilla Minus One
Độ tuổi: 13+
Thời lượng: 124 phút
Ngày khởi chiếu: 2025-11-15
IMDb: 9.4
Thể loại: Khoa Học Viễn Tưởng, Hành Động
Trạng thái: Đang chiếu
Featured Image: Upload poster
```

---

## 📸 FEATURED IMAGE QUAN TRỌNG!

**Kích thước khuyến nghị:**
- Chiều rộng: 300-500px
- Chiều cao: 400-700px
- Tỷ lệ: 2:3 (Portrait)
- Format: JPG hoặc PNG

**Nếu không upload:**
→ Sẽ hiển thị placeholder màu hồng

---

## 🔄 UPDATE DATA:

Sau khi thêm/sửa phim:
1. Vào trang Home: `http://localhost:8000/home/`
2. Refresh (hoặc Ctrl + F5)
3. Data sẽ tự động update!

**Không cần** sửa code hay config gì thêm!

---

## 🎨 HIỂN THỊ:

### Phim Đang Chiếu:
- Có số thứ tự (1, 2, 3...)
- Badge rating (13+, 16+...)
- Tên phim + Thể loại
- Rating sao (IMDb)
- Slider ngang

### Phim Sắp Chiếu:
- Badge rating
- Tên phim + Thể loại
- Ngày khởi chiếu
- Layout đẹp với gradient

---

## 🔧 TROUBLESHOOTING:

### ❌ Không thấy menu "Phim"?
→ Plugin chưa activate. Vào Plugins → Activate "Movies CPT"

### ❌ Không hiển thị phim?
→ Kiểm tra:
1. Đã thêm phim chưa?
2. Đã chọn Trạng Thái chưa? (Đang chiếu / Sắp chiếu)
3. Slug taxonomy đúng chưa? (`dang-chieu`, `sap-chieu`)

### ❌ Poster không hiển thị?
→ Kiểm tra Featured Image đã upload chưa

### ❌ Thể loại trống?
→ Chọn ít nhất 1 thể loại cho phim

---

## 📂 CẤU TRÚC DATABASE:

```
wp_posts (post_type = 'movie')
├── post_title (Tên phim)
├── post_content (Mô tả)
├── post_thumbnail (Poster)
└── post_meta:
    ├── movie_rating (P, 13+, 16+, 18+)
    ├── movie_duration (phút)
    ├── movie_release_date (YYYY-MM-DD)
    ├── movie_trailer_url (YouTube URL)
    └── movie_imdb_rating (0-10)

wp_terms (taxonomies)
├── movie_genre (Thể loại)
└── movie_status (Trạng thái: đang chiếu/sắp chiếu)
```

---

## 🚀 BONUS: NÂNG CAO

### Thêm field mới:

1. Mở file: `wp-content/plugins/movies-cpt/movies-cpt.php`
2. Tìm function `movie_details_callback`
3. Thêm HTML input mới
4. Update function `save_movie_details` để lưu data
5. Update templates để hiển thị

### Tạo single page cho phim:

Tạo file: `wp-content/themes/[theme]/single-movie.php`

---

**✨ Chúc quản lý phim vui vẻ!**

