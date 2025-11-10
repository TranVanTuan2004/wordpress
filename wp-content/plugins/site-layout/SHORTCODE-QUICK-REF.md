# 🎬 Quick Reference: Shortcode [movie_detail]

## ⚡ Sử Dụng Nhanh

```
[movie_detail id="123"]
```

---

## 📋 Tất Cả Shortcodes Có Sẵn

| Shortcode | Mô tả | Cần tham số? |
|-----------|-------|--------------|
| `[site_header]` | Header chung | ❌ |
| `[site_footer]` | Footer chung | ❌ |
| `[hero_banner]` | Banner trang chủ | ❌ |
| `[movies_now_showing]` | Phim đang chiếu | ❌ |
| `[movies_coming_soon]` | Phim sắp chiếu | ❌ |
| `[movie_schedule]` | Lịch chiếu phim | ❌ |
| `[movie_detail id="XX"]` | Chi tiết 1 phim | ✅ Cần `id` |
| `[full_home_page]` | Trang home đầy đủ | ❌ |
| `[debug_movies]` | Debug movie data | ❌ |

---

## 🎯 Cách Lấy ID Phim

1. Vào **WordPress Admin** → **Phim** → **Tất cả phim**
2. Di chuột qua tên phim
3. Xem URL ở góc dưới:
   ```
   post.php?post=123&action=edit
                ^^^
                ID này
   ```

---

## 💡 Ví Dụ Nhanh

### 1 phim:
```
[movie_detail id="1"]
```

### Nhiều phim:
```
[movie_detail id="1"]
[movie_detail id="2"]
[movie_detail id="3"]
```

### Kết hợp nội dung:
```
# Top Phim Hot

Đây là phim hay nhất tuần này:

[movie_detail id="5"]

## Review

Phim này rất đáng xem vì...
```

---

## ⚠️ Lỗi & Fix

| Lỗi | Fix |
|-----|-----|
| Shortcode hiển thị text | Kích hoạt plugin "Site Layout" |
| "Vui lòng cung cấp ID" | Thêm `id="XX"` vào shortcode |
| "Không tìm thấy phim" | Check ID có đúng không |

---

## 🚀 Test Nhanh

1. Tạo trang mới
2. Paste: `[movie_detail id="1"]`
3. Publish
4. Xem kết quả!

---

**Xem chi tiết:** `HUONG-DAN-SHORTCODE-MOVIE-DETAIL.md`  
**Demo:** Mở file `DEMO-SHORTCODE.html`

