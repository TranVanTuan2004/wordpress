# HƯỚNG DẪN SỬ DỤNG PAGE TEMPLATE

## 📋 Tổng Quan

Plugin này cung cấp **4 Page Templates** để bạn chọn khi tạo trang mới trong WordPress.

Không cần dùng shortcode, chỉ cần chọn template từ dropdown **"Mẫu mặc định"** khi tạo/sửa trang!

---

## 🎨 Các Template Có Sẵn

### 1. **Full Width - Có Header Footer**
- ✅ Có Header và Footer tùy chỉnh
- ✅ Nội dung full width (max 1400px)
- ✅ Phù hợp cho: Landing page, trang giới thiệu

### 2. **Container - Có Header Footer**
- ✅ Có Header và Footer tùy chỉnh
- ✅ Nội dung trong container 1200px
- ✅ Background trắng, có box shadow
- ✅ Phù hợp cho: Trang tin tức, bài viết, giới thiệu

### 3. **Blank - Không Header Footer**
- ❌ Không có Header và Footer
- ✅ Trang trắng hoàn toàn
- ✅ Phù hợp cho: Trang cần tùy chỉnh 100%, popup, iframe

### 4. **Centered Box - Hộp Giữa Màn Hình**
- ✅ Có Header và Footer tùy chỉnh
- ✅ Nội dung trong box giữa màn hình (600px)
- ✅ Background gradient đẹp
- ✅ Phù hợp cho: Form đăng ký, đăng nhập, liên hệ

---

## 📝 CÁCH SỬ DỤNG

### Bước 1: Kích hoạt Plugin
1. Vào **WordPress Admin** → **Plugins**
2. Tìm plugin **"Site Layout - Header & Footer"**
3. Nhấn **Activate**

### Bước 2: Tạo Trang Mới
1. Vào **Pages** → **Add New**
2. Nhập tiêu đề trang
3. Thêm nội dung vào trang

### Bước 3: Chọn Template
1. Ở bên phải, tìm phần **"Page Attributes"** hoặc **"Thuộc tính trang"**
2. Tìm dropdown **"Template"** hoặc **"Mẫu"**
3. Chọn một trong 4 templates:
   - Full Width - Có Header Footer
   - Container - Có Header Footer
   - Blank - Không Header Footer
   - Centered Box - Hộp Giữa Màn Hình

### Bước 4: Publish
1. Nhấn **Publish** để xuất bản trang
2. Nhấn **View Page** để xem kết quả

---

## 💡 VÍ DỤ SỬ DỤNG

### Ví Dụ 1: Trang Đăng Ký
```
Template: Centered Box - Hộp Giữa Màn Hình
Shortcode: [uas_register]
→ Form đăng ký nằm giữa màn hình, background đẹp
```

### Ví Dụ 2: Trang Giới Thiệu
```
Template: Container - Có Header Footer
Nội dung: Viết giới thiệu về công ty
→ Hiển thị trong box trắng đẹp mắt
```

### Ví Dụ 3: Trang Landing Page
```
Template: Full Width - Có Header Footer
Nội dung: Thêm banner, features, CTA
→ Sử dụng toàn bộ chiều rộng màn hình
```

### Ví Dụ 4: Trang Popup/Iframe
```
Template: Blank - Không Header Footer
Nội dung: Form hoặc nội dung tùy chỉnh
→ Không có header/footer, hoàn toàn trống
```

---

## 🔧 TROUBLESHOOTING

### ❌ Không thấy templates trong dropdown?
**Giải pháp:**
1. Vào **Plugins** → Deactivate plugin "Site Layout"
2. Activate lại
3. Refresh lại trang edit

### ❌ Template hiển thị không đúng?
**Giải pháp:**
1. Clear cache của WordPress và browser
2. Kiểm tra file template có tồn tại:
   - `/wp-content/plugins/site-layout/page-templates/`

### ❌ CSS không load?
**Giải pháp:**
1. Vào **Plugins** → Kiểm tra plugin đã activate
2. Hard refresh: `Ctrl + F5` (Windows) hoặc `Cmd + Shift + R` (Mac)

---

## 📂 CẤU TRÚC FILES

```
wp-content/plugins/site-layout/
├── site-layout.php                 (File chính)
├── templates/
│   ├── header.php                  (Header chung)
│   └── footer.php                  (Footer chung)
├── page-templates/                 (Templates để chọn)
│   ├── full-width-with-header-footer.php
│   ├── container-with-header-footer.php
│   ├── blank-no-header-footer.php
│   └── centered-box.php
└── assets/
    ├── layout.css                  (CSS chung)
    └── layout.js                   (JS chung)
```

---

## 🎯 LƯU Ý

1. **Header/Footer tự động load CSS/JS** của plugin
2. Có thể **chỉnh sửa CSS** trong file `assets/layout.css`
3. Có thể **tùy chỉnh header/footer** trong folder `templates/`
4. Mỗi template có **inline CSS riêng** để styling đúng layout

---

## 📞 HỖ TRỢ

Nếu gặp vấn đề, kiểm tra:
1. Plugin đã activate chưa
2. WordPress version >= 5.0
3. PHP version >= 7.0

---

**✨ Chúc bạn sử dụng thành công!**

