@echo off 
cd C:\laragon\www\pengajuan-cuti 
php artisan schedule:run >> "storage/logs/scheduler.log" 2>&1 
