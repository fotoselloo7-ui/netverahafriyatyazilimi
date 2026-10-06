@echo off
REM Ersan Hafriyat - Yerel Geliştirme Sunucusu (8020)
set PHP="C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe"
echo Ersan Hafriyat baslatiliyor: http://127.0.0.1:8020
%PHP% -S 127.0.0.1:8020 -t public public\router.php
