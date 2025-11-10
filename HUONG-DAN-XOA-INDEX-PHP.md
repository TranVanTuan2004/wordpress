# 🔧 XÓA INDEX.PHP KHỎI URL WORDPRESS

## ❌ VẤN ĐỀ

URL hiện tại: `http://localhost:8000/index.php/dangky/`

Mục tiêu: `http://localhost:8000/dangky/`

---

## ✅ GIẢI PHÁP (3 BƯỚC)

### BƯỚC 1: Cấu hình Permalink

1. Vào: **http://localhost:8000/wp-admin/options-permalink.php**
   
2. Trong phần **"Common Settings"**, bạn sẽ thấy 5 lựa chọn:
   ```
   ⚪ Plain
      http://localhost:8000/?p=123
   
   ⚪ Day and name
      http://localhost:8000/2025/11/10/sample-post/
   
   ⚪ Month and name
      http://localhost:8000/2025/11/sample-post/
   
   🔵 Post name  ← CHỌN CÁI NÀY
      http://localhost:8000/sample-post/
   
   ⚪ Custom Structure
      http://localhost:8000/...
   ```

3. **CHỌN: Post name** (Radio button thứ 4)

4. **Scroll xuống cuối trang**

5. **Nhấn nút màu xanh: "Save Changes"**

✅ Xong bước 1!

---

### BƯỚC 2: Dừng Server Hiện Tại

1. Tìm cửa sổ terminal/CMD đang chạy server
2. Nhìn thấy dòng chữ: `PHP 8.x Development Server (http://localhost:8000) started`
3. **Nhấn Ctrl + C** trên bàn phím
4. Server sẽ dừng lại

✅ Xong bước 2!

---

### BƯỚC 3: Start Lại Server Với Router

Có 2 cách:

#### Cách 1: Dùng file BAT (ĐƠN GIẢN NHẤT)

1. Mở folder WordPress trong File Explorer
2. Tìm file: **START-SERVER.bat**
3. **Double click** vào file đó
4. Terminal sẽ tự mở và start server

#### Cách 2: Dùng Command Line

1. Mở terminal/CMD
2. `cd` vào folder WordPress
3. Chạy lệnh:
   ```bash
   php -S localhost:8000 router.php
   ```

✅ Xong bước 3!

---

## 🎉 KIỂM TRA KẾT QUẢ

Mở trình duyệt và vào:
- ✅ `http://localhost:8000/dangky/` (KHÔNG CÒN index.php)
- ✅ `http://localhost:8000/dang-nhap/`
- ✅ `http://localhost:8000/profile/`

---

## 🔍 TẠI SAO PHẢI LÀM NHƯ VẬY?

### Vấn đề:
- PHP built-in server (`php -S`) **KHÔNG hỗ trợ URL rewriting** mặc định
- WordPress cần URL rewriting để có Pretty Permalinks

### Giải pháp:
- File `router.php` giúp PHP server xử lý URL rewrites
- Khi start server với `php -S localhost:8000 router.php`, mọi request đều đi qua router trước
- Router sẽ chuyển request về `index.php` của WordPress

---

## 🚨 NẾU VẪN KHÔNG ĐƯỢC

### Vấn đề 1: Vẫn thấy index.php trong URL

**Giải pháp:**
1. Kiểm tra đã Save Permalink Settings chưa
2. Kiểm tra đã start server với `router.php` chưa
3. Clear cache browser: **Ctrl + Shift + Delete**
4. Hard refresh: **Ctrl + F5**

### Vấn đề 2: Lỗi 404 Not Found

**Giải pháp:**
1. Đảm bảo file `router.php` tồn tại ở root folder WordPress
2. Check terminal xem có lỗi không
3. Restart server

### Vấn đề 3: Page không load được

**Giải pháp:**
1. Kiểm tra tên permalink của page có đúng không
2. Vào **Pages → All Pages** xem permalink
3. Có thể cần tạo lại page với permalink mới

---

## 💡 GỢI Ý: DÙNG XAMPP

Nếu muốn ổn định hơn và không phải config gì nhiều:

### Cài XAMPP:
1. Download: https://www.apachefriends.org/download.html
2. Install XAMPP
3. Copy folder WordPress vào: `C:\xampp\htdocs\`
4. Đổi tên folder thành `cms` (hoặc tên khác)
5. Start Apache trong XAMPP Control Panel
6. Vào: `http://localhost/cms/`

### Ưu điểm XAMPP:
- ✅ Pretty permalinks hoạt động ngay không cần config
- ✅ Có Apache với mod_rewrite
- ✅ Có .htaccess tự động
- ✅ Gần với môi trường production
- ✅ Stable hơn PHP built-in server

---

## 📋 CHECKLIST

Trước khi hỏi hỗ trợ, kiểm tra:

- [ ] Đã vào Permalink Settings
- [ ] Đã chọn "Post name"
- [ ] Đã nhấn "Save Changes"
- [ ] File `router.php` tồn tại trong folder WordPress
- [ ] Đã stop server cũ (Ctrl + C)
- [ ] Đã start server mới với `php -S localhost:8000 router.php`
- [ ] Đã clear cache và hard refresh browser

---

## 🎯 FILE QUAN TRỌNG

### router.php
```php
<?php
// Router for PHP Built-in Server
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = urldecode($uri);

if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false; // Serve static files
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
include __DIR__ . '/index.php';
```

File này đã được tạo tự động trong folder WordPress của bạn!

---

## ✨ KẾT LUẬN

Sau khi làm đúng 3 bước:
1. ✅ Cấu hình Permalink = "Post name"
2. ✅ Stop server
3. ✅ Start với router: `php -S localhost:8000 router.php`

→ URL sẽ đẹp không còn `index.php` nữa! 🎉

---

**Chúc bạn thành công!** 🚀

