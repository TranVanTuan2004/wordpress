# 🎨 USER AUTH SYSTEM - HƯỚNG DẪN SỬ DỤNG

## ✨ TÍNH NĂNG

- ✅ **Đăng ký tài khoản** với validation đầy đủ
- ✅ **Đăng nhập** với ghi nhớ đăng nhập
- ✅ **Trang profile** hiển thị thông tin user
- ✅ **Giao diện đẹp** với gradient và animations
- ✅ **AJAX** không reload trang
- ✅ **Responsive** hoàn toàn
- ✅ **Bypass theme** - header/footer tùy chỉnh

---

## 📝 CÁCH SỬ DỤNG

### Bước 1: Kích Hoạt Plugin

1. Vào **WordPress Admin** → **Plugins**
2. Tìm **"User Auth System"**
3. Nhấn **Activate**

### Bước 2: Tạo 3 Trang

#### Trang 1: Login (Đăng Nhập)

1. **Pages** → **Add New**
2. **Title:** Login
3. **Permalink:** /login
4. **Content:** `[uas_login]`
5. **Template:** Mẫu mặc định (hoặc bất kỳ)
6. **Publish!**

#### Trang 2: Register (Đăng Ký)

1. **Pages** → **Add New**
2. **Title:** Register
3. **Permalink:** /register
4. **Content:** `[uas_register]`
5. **Template:** Mẫu mặc định
6. **Publish!**

#### Trang 3: Profile (Hồ Sơ)

1. **Pages** → **Add New**
2. **Title:** Profile
3. **Permalink:** /profile
4. **Content:** `[uas_profile]`
5. **Template:** Mẫu mặc định
6. **Publish!**

---

## 🎯 SHORTCODES

| Shortcode | Mô tả | Link |
|-----------|-------|------|
| `[uas_login]` | Form đăng nhập | /login |
| `[uas_register]` | Form đăng ký | /register |
| `[uas_profile]` | Trang profile | /profile |

---

## 🚀 FLOW HOẠT ĐỘNG

```
1. User vào /register → Điền form → Submit
   → AJAX đăng ký → Thành công → Tự động login
   → Redirect về /profile

2. User vào /login → Điền form → Submit
   → AJAX đăng nhập → Thành công → Redirect về /profile

3. User ở /profile → Xem thông tin
   → Có thể Edit hoặc Logout
   → Logout → Redirect về /login

4. Nếu chưa login mà vào /profile → Auto redirect về /login
5. Nếu đã login mà vào /login hoặc /register → Auto redirect về /profile
```

---

## 🎨 TÍNH NĂNG GIAO DIỆN

### Form Đăng Nhập
- ✅ Input username/email và password
- ✅ Checkbox "Ghi nhớ đăng nhập"
- ✅ Link "Quên mật khẩu?"
- ✅ Loading spinner khi submit
- ✅ Thông báo success/error đẹp

### Form Đăng Ký
- ✅ Input username, email, password, confirm password
- ✅ Checkbox đồng ý điều khoản
- ✅ Validation:
  - Password phải >= 6 ký tự
  - Password và confirm password phải khớp
  - Username không được trùng
  - Email không được trùng
- ✅ Tự động login sau khi đăng ký thành công

### Trang Profile
- ✅ Avatar user
- ✅ Thông tin: username, email, ngày tham gia, vai trò
- ✅ Card hiển thị chi tiết
- ✅ Button "Chỉnh sửa hồ sơ" → WordPress admin profile
- ✅ Button "Đăng xuất" với confirm

---

## 🔧 TROUBLESHOOTING

### ❌ Shortcode hiển thị dạng text

**Nguyên nhân:** Plugin chưa được kích hoạt

**Giải pháp:**
1. Vào **Plugins**
2. Activate plugin **"User Auth System"**
3. Refresh lại trang

### ❌ Giao diện không đẹp / CSS không load

**Nguyên nhân:** Cache hoặc CSS chưa load

**Giải pháp:**
1. Hard refresh: `Ctrl + F5` (Windows) hoặc `Cmd + Shift + R` (Mac)
2. Clear cache WordPress
3. Kiểm tra plugin đã activate

### ❌ AJAX không hoạt động

**Nguyên nhân:** jQuery chưa load hoặc conflict

**Giải pháp:**
1. Kiểm tra Console (F12) xem có lỗi không
2. Đảm bảo jQuery đã load
3. Check file `script.js` đã load chưa

### ❌ Không redirect sau khi login/register

**Nguyên nhân:** Trang /profile chưa tồn tại

**Giải pháp:**
1. Tạo trang Profile với permalink là `/profile`
2. Thêm shortcode `[uas_profile]`

---

## 📂 CẤU TRÚC FILES

```
wp-content/plugins/user-auth-system/
├── user-auth-system.php       (File chính)
├── includes/
│   ├── login.php              (Xử lý login)
│   ├── register.php           (Xử lý register)
│   └── profile.php            (Xử lý profile)
├── assets/
│   ├── style.css              (CSS đẹp)
│   └── script.js              (AJAX logic)
└── templates/
    └── page-wrapper.php       (Bypass theme)
```

---

## 🎯 CUSTOMIZATION

### Thay đổi màu sắc

Mở file `assets/style.css` và tìm:

```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

Thay đổi `#667eea` và `#764ba2` thành màu bạn thích!

### Thay đổi văn bản

Mở file `includes/login.php`, `register.php`, `profile.php` và sửa các text tương ứng.

### Thêm field vào form đăng ký

1. Mở `includes/register.php`
2. Thêm HTML input mới
3. Thêm xử lý trong AJAX handler

---

## 🌐 QUICK LINKS

- 🔗 Login: `http://localhost:8000/login`
- 🔗 Register: `http://localhost:8000/register`
- 🔗 Profile: `http://localhost:8000/profile`
- 🔗 Admin: `http://localhost:8000/wp-admin`

---

## 📞 HỖ TRỢ

Nếu gặp vấn đề, kiểm tra:
- ✅ Plugin đã activate chưa?
- ✅ Đã tạo 3 trang với shortcode đúng chưa?
- ✅ Permalink có đúng không?
- ✅ WordPress version >= 5.0
- ✅ PHP version >= 7.0

---

**✨ Chúc bạn sử dụng thành công!**

