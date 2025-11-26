<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{


    protected function schedule(Schedule $schedule)
    {
        // Backup do banco de dados com logs
        $schedule->command('backup:database')
            ->everyMinute() // Para teste, rode a cada minuto
            ->between('00:00', '23:59') // Intervalo permitido
            ->appendOutputTo(storage_path('logs/backup.log')) // Salva saída do comando
            ->before(function () {
                Log::info('⏳ Iniciando backup agendado...');
            })
            ->after(function () {
                Log::info('✅ Backup agendado concluído.');
            });
    }

    /**
     * Registra os comandos do console.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
