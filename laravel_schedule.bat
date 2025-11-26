
@echo off
REM Caminho do PHP e do projeto Laravel
cd /d "C:\Planner\web\bagatoli"

REM Executa o schedule
php artisan schedule:run

REM Pausa para ver a saída (opcional)
pause
