@echo off
echo ========================================================
echo        AUTO DEPLOY & BACKUP SCRIPT - PESTASIAGA
echo ========================================================
echo.

:: 1. Input Commit Message
:InputMsg
set /p commit_msg="Masukkan pesan commit: "
if "%commit_msg%"=="" goto InputMsg

echo.
echo ==========================================
echo KONFIRMASI TINDAKAN
echo ==========================================
echo Pesan Commit : %commit_msg%
echo Repository   : https://github.com/dewecorp/pestasiaga.git
echo File Backup  : backup_pestasiaga.zip (Update Mode)
echo.
set /p confirm="Lanjutkan eksekusi? (y/n): "
if /i not "%confirm%"=="y" goto End

echo.
echo [1/3] Menyiapkan Git...
echo -----------------------

:: Cek apakah folder .git ada, jika tidak inisialisasi
if not exist .git (
    echo Inisialisasi Git Repository...
    git init
    git branch -M main
    git remote add origin https://github.com/dewecorp/pestasiaga.git
) else (
    :: Pastikan remote origin sesuai
    git remote remove origin 2>nul
    git remote add origin https://github.com/dewecorp/pestasiaga.git
)

:: 2. Git Process
echo.
echo [2/3] Eksekusi Git Commit & Push...
echo -----------------------------------
git add .
git commit -m "%commit_msg%"
git push -u origin main

echo.
echo [3/3] Update Backup ZIP...
echo --------------------------
:: Menggunakan PowerShell untuk update zip (exclude folder .git dan file zip itu sendiri untuk mencegah loop/error)
powershell -Command "Get-ChildItem -Exclude '*.zip','.git' | Compress-Archive -DestinationPath 'backup_pestasiaga.zip' -Update"

echo.
echo ========================================================
echo        PROSES SELESAI
echo ========================================================
echo.

:End
echo Script dibatalkan atau selesai.
pause
