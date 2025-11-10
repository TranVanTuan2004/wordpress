@echo off
chcp 65001 >nul
echo ====================================
echo DỪNG WORDPRESS SERVER
echo ====================================
echo.
echo Đang dừng tất cả PHP processes...

taskkill /F /IM php.exe

echo.
echo ====================================
echo ✅ Đã dừng server!
echo ====================================
echo.
pause

