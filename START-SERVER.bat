@echo off
echo ====================================
echo Starting WordPress Server
echo ====================================
echo.
echo Server URL: http://localhost:8000
echo Press Ctrl+C to stop server
echo.
echo ====================================

php -S localhost:8000 router.php

