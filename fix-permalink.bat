@echo off
chcp 65001 >nul
echo ====================================
echo TỰ ĐỘNG FIX PERMALINK
echo ====================================
echo.
echo [1/4] Dừng tất cả PHP processes...

REM Kill all PHP processes
taskkill /F /IM php.exe >nul 2>&1
timeout /t 2 >nul

echo [2/4] Đã dừng server cũ ✓
echo.
echo [3/4] Starting server mới với router.php...
echo.

REM Start PHP server in background
start /B php -S localhost:8000 router.php

timeout /t 2 >nul

echo [4/4] Server đã khởi động ✓
echo.
echo ====================================
echo ✅ HOÀN TẤT!
echo ====================================
echo.
echo 🌐 Mở WordPress tại:
echo    http://localhost:8000
echo.
echo 📝 URL sẽ đẹp (không có index.php):
echo    http://localhost:8000/dangky/
echo    http://localhost:8000/dang-nhap/
echo    http://localhost:8000/profile/
echo.
echo ⚠️  Đừng tắt cửa sổ này!
echo     Server đang chạy ở background
echo.
echo 🛑 Để dừng server, chạy file: stop-server.bat
echo ====================================
echo.

REM Open browser
timeout /t 2 >nul
start http://localhost:8000/dangky/

echo Nhấn phím bất kỳ để xem log server...
pause >nul

REM Show server log
php -S localhost:8000 router.php

