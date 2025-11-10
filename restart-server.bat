@echo off
echo ====================================
echo RESTART WORDPRESS SERVER
echo ====================================
echo.
echo Dang dung server cu...
echo Neu co loi, ban tu nhan Ctrl+C o cua so server cu
echo.
timeout /t 3
echo.
echo ====================================
echo Starting server voi router.php...
echo ====================================
echo.
echo Server URL: http://localhost:8000
echo.
echo URL dep khong co index.php:
echo   - http://localhost:8000/dangky/
echo   - http://localhost:8000/dang-nhap/
echo   - http://localhost:8000/profile/
echo.
echo Nhan Ctrl+C de dung server
echo ====================================
echo.

php -S localhost:8000 router.php

pause

