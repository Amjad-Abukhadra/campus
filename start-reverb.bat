@echo off
REM Laravel Reverb WebSocket Server Auto-Start Script
REM This script starts the Reverb server for real-time chat messaging

echo Starting Laravel Reverb WebSocket Server...
echo.

REM Change to the project directory
cd /d "d:\laragon\www\campus"

REM Start Reverb server
php artisan reverb:start

REM If Reverb stops, pause to show any error messages
pause
