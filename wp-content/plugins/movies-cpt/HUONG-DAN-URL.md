# 🔗 Hướng Dẫn: Tạo URL Cho Phim

## 📖 Giới Thiệu

WordPress **TỰ ĐỘNG TẠO URL** cho mỗi phim bạn tạo!

---

## 🎯 Cấu Trúc URL Mặc Định

```
http://localhost:8000/phim/[slug-phim]/
```

**Ví dụ:**
- Phim: "Avengers Endgame"
- Slug: `avengers-endgame`
- URL: `http://localhost:8000/phim/avengers-endgame/`

---

## ✅ Cách Tạo URL Cho Phim Mới

### **Bước 1: Tạo Phim Mới**

1. Vào **WordPress Admin** → **Phim** → **Thêm mới**
2. Điền **Tiêu đề phim**: "Avengers Endgame"
3. WordPress sẽ **TỰ ĐỘNG** tạo slug: `avengers-endgame`

### **Bước 2: Xem/Chỉnh Slug**

Bên phải màn hình, tìm phần **Permalink**:

```
┌─────────────────────────────────┐
│ Đường dẫn tĩnh                   │
│ http://localhost:8000/phim/     │
│ avengers-endgame/    [Chỉnh sửa]│
└─────────────────────────────────┘
```

**Muốn đổi slug?**
1. Click **[Chỉnh sửa]**
2. Đổi thành: `avengers` hoặc `phim-hay`
3. Click **OK**

### **Bước 3: Xuất Bản**

1. Click **Xuất bản**
2. URL sẵn sàng! ✅

**URL cuối cùng:**
```
http://localhost:8000/phim/avengers-endgame/
```

---

## 🔧 Thay Đổi Cấu Trúc URL

### **Muốn đổi từ `/phim/` sang `/movie/` hoặc slug khác?**

#### **Bước 1: Edit File Plugin**

Mở file:
```
wp-content/plugins/movies-cpt/movies-cpt.php
```

Tìm dòng 35:
```php
'rewrite' => array('slug' => 'phim')
```

Đổi thành:
```php
'rewrite' => array('slug' => 'movie')
// Hoặc bất kỳ slug nào bạn muốn: 'cinema', 'films', 'shows', v.v.
```

#### **Bước 2: Flush Permalinks**

**⚠️ QUAN TRỌNG:** Sau khi thay đổi, BẮT BUỘC phải flush permalinks!

**Cách 1: Qua WordPress Admin (Khuyên dùng)**
1. Vào **Cài đặt** → **Đường dẫn tĩnh (Permalinks)**
2. Click **Lưu thay đổi** (không cần đổi gì, chỉ cần click)
3. Xong! ✅

**Cách 2: Deactivate/Activate Plugin**
1. Vào **Plugins**
2. Deactivate plugin "Movies CPT"
3. Activate lại
4. Xong! ✅

#### **Bước 3: Kiểm Tra**

Thử truy cập:
```
http://localhost:8000/movie/ten-phim/
```

---

## 📋 Các Ví Dụ Slug

| Slug trong code | URL kết quả |
|----------------|-------------|
| `'phim'` | `/phim/ten-phim/` |
| `'movie'` | `/movie/ten-phim/` |
| `'cinema'` | `/cinema/ten-phim/` |
| `'films'` | `/films/ten-phim/` |
| `'xem-phim'` | `/xem-phim/ten-phim/` |
| `''` (rỗng) | `/ten-phim/` (trực tiếp) |

---

## 🎨 Tùy Chỉnh Slug Từng Phim

### **Khi tạo/edit phim:**

1. **Slug mặc định:** WordPress tự tạo từ tiêu đề
   - Tiêu đề: "Spider Man No Way Home"
   - Slug: `spider-man-no-way-home`

2. **Slug tùy chỉnh:** Bạn có thể đổi
   - Slug mới: `spider-man-3`
   - URL: `http://localhost:8000/phim/spider-man-3/`

3. **Slug tiếng Việt:** WordPress hỗ trợ!
   - Tiêu đề: "Người Nhện Không Còn Nhà"
   - Slug tự động: `nguoi-nhen-khong-con-nha`
   - URL: `http://localhost:8000/phim/nguoi-nhen-khong-con-nha/`

---

## ⚠️ Lưu Ý Quan Trọng

### **1. Slug phải UNIQUE (duy nhất)**
- ❌ Không được có 2 phim cùng slug
- ✅ WordPress sẽ tự thêm số: `avengers`, `avengers-2`, `avengers-3`

### **2. Slug nên ngắn gọn, dễ đọc**
- ❌ Xấu: `phim-hanh-dong-sieu-kinh-dien-khong-nen-bo-lo-2024`
- ✅ Tốt: `avengers-endgame`

### **3. Không dùng ký tự đặc biệt**
- ❌ Tránh: `phim!@#$%`
- ✅ Chỉ dùng: chữ, số, gạch ngang `-`

### **4. Slug không thay đổi URL cũ**
- Nếu phim đã publish, đổi slug = URL cũ **404**
- Người đã share link cũ sẽ không vào được
- **Khuyên:** Đặt slug đúng ngay từ đầu!

---

## 🔗 URL Cho Taxonomy (Thể Loại)

### **Thể loại phim:**
```
http://localhost:8000/the-loai/hanh-dong/
```

Muốn đổi?
```php
// File: movies-cpt.php, dòng 58
'rewrite' => array('slug' => 'the-loai')
// Đổi thành: 'genre', 'category', v.v.
```

### **Trạng thái phim:**
```
http://localhost:8000/trang-thai/dang-chieu/
```

Muốn đổi?
```php
// File: movies-cpt.php, dòng 73
'rewrite' => array('slug' => 'trang-thai')
// Đổi thành: 'status', v.v.
```

---

## 🎯 Permalink Settings (Cài Đặt Chung)

### **Kiểm tra cấu hình permalinks:**

1. Vào **Cài đặt** → **Đường dẫn tĩnh**
2. Chọn: **Tên bài viết** (Post name)
3. Cấu trúc: `/%postname%/`

**⚠️ Nếu chọn "Plain" (mặc định):**
```
❌ http://localhost:8000/?p=123
```

**✅ Nếu chọn "Post name":**
```
✅ http://localhost:8000/phim/avengers/
```

---

## 💡 Mẹo Hay

### **Mẹo 1: SEO-friendly URLs**
```
✅ TÔT: /phim/avengers-endgame/
❌ XẤU: /phim/phim-sieu-anh-hung-marvel-avengers-endgame-2019-full-hd/
```

### **Mẹo 2: Dùng số năm nếu có nhiều phần**
```
/phim/spider-man-2002/
/phim/spider-man-2004/
/phim/spider-man-2007/
```

### **Mẹo 3: Dùng slug ngắn cho phim nổi tiếng**
```
/phim/titanic/
/phim/avatar/
/phim/inception/
```

### **Mẹo 4: Dùng slug Tiếng Việt cho phim Việt**
```
/phim/co-ba-sai-gon/
/phim/mat-biec/
/phim/nha-ba-nu/
```

---

## 🚨 Xử Lý Lỗi

### **Lỗi 1: URL trả về 404**
**Nguyên nhân:** Chưa flush permalinks  
**Fix:**
1. Vào **Cài đặt** → **Đường dẫn tĩnh**
2. Click **Lưu thay đổi**

### **Lỗi 2: URL có `index.php`**
```
❌ http://localhost:8000/index.php/phim/avengers/
```

**Fix:** 
- Xem file `FIX-PERMALINK.md` trong thư mục root
- Hoặc chạy: `php -S localhost:8000 router.php`

### **Lỗi 3: Slug bị trùng**
```
⚠️ WordPress sẽ tự thêm số: avengers-2, avengers-3
```

**Fix:** Đặt slug khác thủ công

---

## 📊 Tóm Tắt

| Yếu tố | Giá trị mặc định | Có thể thay đổi? |
|--------|------------------|------------------|
| **Base slug** | `/phim/` | ✅ Có |
| **Movie slug** | Tự động từ tiêu đề | ✅ Có |
| **Genre slug** | `/the-loai/` | ✅ Có |
| **Status slug** | `/trang-thai/` | ✅ Có |

---

## 🎬 Ví Dụ Thực Tế

### **Phim 1: "Avengers Endgame"**
```
Tiêu đề: Avengers Endgame
Slug: avengers-endgame
URL: http://localhost:8000/phim/avengers-endgame/
Template: single-movie.php (tự động load)
```

### **Phim 2: "Cô Ba Sài Gòn"**
```
Tiêu đề: Cô Ba Sài Gòn
Slug: co-ba-sai-gon
URL: http://localhost:8000/phim/co-ba-sai-gon/
Template: single-movie.php (tự động load)
```

### **Thể loại: "Hành Động"**
```
Tên: Hành Động
Slug: hanh-dong
URL: http://localhost:8000/the-loai/hanh-dong/
Hiển thị: Tất cả phim hành động
```

---

## ✨ Kết Luận

✅ **URL tự động tạo** - Không cần config gì thêm  
✅ **Có thể tùy chỉnh** - Đổi slug theo ý muốn  
✅ **SEO-friendly** - URL ngắn gọn, dễ đọc  
✅ **Hỗ trợ Tiếng Việt** - Slug tiếng Việt không dấu  

**Chỉ cần tạo phim → URL tự có! 🎉**

---

**Cần hỗ trợ? Đọc thêm:**
- `HUONG-DAN.md` - Hướng dẫn plugin
- `FIX-PERMALINK.md` - Fix lỗi permalink
- `MOVIE-DETAIL-INFO.md` - Chi tiết về template

