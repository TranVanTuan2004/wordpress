# 🔧 FIX PERMALINK - XÓA INDEX.PHP KHỎI URL

## ❌ VẤN ĐỀ

URL đang có dạng: `http://localhost:8000/index.php/dang-nhap/`

Cần fix thành: `http://localhost:8000/dang-nhap/`

---

## ✅ GIẢI PHÁP NHANH

### Bước 1: Cấu hình Permalink trong WordPress

1. Vào: **http://localhost:8000/wp-admin/options-permalink.php**
2. Chọn: **"Post name"** (Radio button thứ 4)
3. Nhấn: **"Save Changes"**

### Bước 2: Stop server hiện tại

Trong terminal đang chạy server:
- Nhấn **Ctrl + C** để dừng server

### Bước 3: Start lại server với router

```bash
php -S localhost:8000 router.php
```

Hoặc đơn giản hơn, double click file:
```
START-SERVER.bat
```

---

## 🎯 KẾT QUẢ

Sau khi làm xong, URL sẽ đẹp:
- ✅ `http://localhost:8000/dang-nhap/`
- ✅ `http://localhost:8000/dang-ky/`
- ✅ `http://localhost:8000/profile/`
- ✅ `http://localhost:8000/home/`

---

## 🔥 ALTERNATIVE: Dùng XAMPP

Nếu muốn ổn định hơn, dùng XAMPP thay vì PHP built-in server:

### Cài XAMPP:
1. Download: https://www.apachefriends.org/
2. Install XAMPP
3. Copy folder WordPress vào `C:\xampp\htdocs\`
4. Start Apache trong XAMPP Control Panel
5. Truy cập: `http://localhost/wordpress/`

### Ưu điểm XAMPP:
- ✅ Pretty permalinks hoạt động mượt mà
- ✅ Có .htaccess tự động
- ✅ Mod_rewrite có sẵn
- ✅ Gần với môi trường production hơn

---

## 📝 LƯU Ý

- File `router.php` đã được tạo tự động
- File `START-SERVER.bat` giúp start server nhanh hơn
- Nếu vẫn không được, xóa cache browser: **Ctrl + Shift + Delete**

---

**✨ Chúc thành công!**

