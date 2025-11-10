# 🔍 DEBUG - TẠI SAO PHIM KHÔNG HIỂN THỊ?

## 🚨 VẤN ĐỀ:

Đã thêm phim vào backend nhưng không hiển thị ở frontend!

---

## ✅ CÁCH KIỂM TRA:

### BƯỚC 1: Thêm Shortcode Debug

1. Tạo page mới hoặc edit page Home
2. Thêm shortcode này **VÀO ĐẦU** page:

```
[debug_movies]
```

3. Save và xem trang
4. Sẽ thấy bảng debug màu trắng viền đỏ với tất cả thông tin!

---

## 🎯 NGUYÊN NHÂN THƯỜNG GẶP:

### ❌ 1. TAXONOMY SLUG KHÔNG ĐÚNG

**VÍ DỤ SAI:**
- Slug: `Đang chiếu` (có dấu, viết hoa) ❌
- Slug: `dang_chieu` (gạch dưới) ❌
- Slug: `dangchieu` (viết liền) ❌

**ĐÚNG:**
- Slug: `dang-chieu` (không dấu, gạch ngang, viết thường) ✅
- Slug: `sap-chieu` (không dấu, gạch ngang, viết thường) ✅

### ❌ 2. PHIM CHƯA CHỌN TRẠNG THÁI

- Đã tạo phim nhưng CHƯA tick chọn "Đang chiếu" hoặc "Sắp chiếu"
- Hoặc chọn nhầm taxonomy khác

### ❌ 3. TAXONOMY CHƯA TẠO

- Chưa tạo terms "Đang chiếu" và "Sắp chiếu" trong menu "Phim → Trạng Thái"

---

## 🔧 CÁCH SỬA:

### FIX 1: Tạo lại Taxonomy đúng cách

1. Vào **Phim → Trạng Thái**

2. Xóa tất cả terms cũ (nếu có)

3. Thêm term mới:
   - **Name:** Đang chiếu
   - **Slug:** `dang-chieu` (gõ CHÍNH XÁC như thế này)
   - Nhấn **Add New Movie Status**

4. Thêm term thứ 2:
   - **Name:** Sắp chiếu
   - **Slug:** `sap-chieu`
   - Nhấn **Add New Movie Status**

### FIX 2: Cập nhật lại Slug (nếu đã tạo sai)

1. Vào **Phim → Trạng Thái**

2. Click vào term "Đang chiếu"

3. Sửa **Slug** thành: `dang-chieu` (không dấu, gạch ngang)

4. **Update**

5. Làm tương tự cho "Sắp chiếu" → Slug: `sap-chieu`

### FIX 3: Gán lại Trạng thái cho Phim

1. Vào **Phim → Tất Cả Phim**

2. Click **Quick Edit** từng phim

3. Chọn đúng taxonomy:
   - ✅ Tick vào "Đang chiếu" cho phim đang chiếu
   - ✅ Tick vào "Sắp chiếu" cho phim sắp chiếu

4. **Update**

### FIX 4: Kiểm tra Plugin đã Activate

1. Vào **Plugins**
2. Đảm bảo 2 plugins đã activate:
   - ✅ **Movies CPT**
   - ✅ **Site Layout - Header & Footer**

---

## 📋 CHECKLIST:

- [ ] Plugin **Movies CPT** đã activate
- [ ] Plugin **Site Layout** đã activate
- [ ] Đã tạo taxonomy "Trạng Thái" với 2 terms:
  - [ ] Đang chiếu (slug: `dang-chieu`)
  - [ ] Sắp chiếu (slug: `sap-chieu`)
- [ ] Đã thêm ít nhất 1 phim
- [ ] Phim đã chọn Trạng thái
- [ ] Phim đã có Featured Image (poster)
- [ ] Đã refresh trang Home (Ctrl + F5)

---

## 🧪 TEST NHANH:

Sau khi fix xong:

1. Dùng shortcode `[debug_movies]` để xem:
   - Tổng số phim
   - Số phim "Đang chiếu"
   - Số phim "Sắp chiếu"
   - Slug của các taxonomy

2. Nếu thấy số phim > 0 → OK!

3. Xóa shortcode `[debug_movies]` đi

4. Vào trang Home → Phim sẽ hiển thị!

---

## 💡 MẸO:

### Tạo Slug tự động đúng:

Khi tạo term mới:
1. **Name:** Gõ tiếng Việt có dấu bình thường (VD: "Đang chiếu")
2. **Slug:** Để trống, WordPress sẽ tự tạo
3. **Sau khi tạo xong:** Vào edit lại và SỬA Slug thành `dang-chieu`

### Copy/Paste Slug để chắc chắn:

```
dang-chieu
sap-chieu
```

Copy 2 slug trên và paste trực tiếp vào!

---

## 📸 SCREENSHOT MẪU:

### Taxonomy đúng:

```
Name: Đang chiếu
Slug: dang-chieu  ← Phải chính xác như thế này!
```

### Phim có Trạng thái:

```
Title: Phá Đảm: Sinh Nhật Mẹ
☑ Đang chiếu  ← Đã tick
☐ Sắp chiếu
```

---

## 🆘 VẪN KHÔNG ĐƯỢC?

Gửi cho tôi kết quả của shortcode `[debug_movies]`:
- Tổng số phim
- Slug của taxonomy
- Số phim "Đang chiếu"
- Số phim "Sắp chiếu"

Để tôi giúp debug tiếp!

---

**✨ Chúc fix thành công!**

