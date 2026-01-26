@echo off
echo ========================================
echo   SETUP DATABASE GROSIR
echo ========================================
echo.

echo [1/4] Membuat database...
"C:\laragon\bin\mysql\mysql-8.0.30\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS grosir;"
if %errorlevel% neq 0 (
    echo ERROR: Gagal membuat database!
    echo Pastikan MySQL sudah running di Laragon
    pause
    exit /b 1
)
echo Database 'grosir' berhasil dibuat!
echo.

echo [2/4] Clear cache Laravel...
php artisan config:clear
php artisan cache:clear
echo.

echo [3/4] Menjalankan migration...
php artisan migrate:fresh --seed
if %errorlevel% neq 0 (
    echo ERROR: Migration gagal!
    pause
    exit /b 1
)
echo.

echo [4/4] Migration selesai!
echo.
echo ========================================
echo   SETUP SELESAI!
echo ========================================
echo.
echo Sekarang jalankan: php artisan serve
echo Lalu buka: http://localhost:8000
echo.
pause
