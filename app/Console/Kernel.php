<?php

namespace App\Console;

use App\Jobs\job_departamentos_produtos;
use App\Jobs\job_importaMp;
use App\Jobs\job_importaPrazo;
use App\Jobs\job_produto;
use App\Jobs\job_produtos;
use App\Jobs\job_subgrupos_produtos;
use App\Jobs\job_vendas;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function(){
        //     job_importaMp::dispatch();
        //     job_produto::dispatch();
        // })->everyMinute();

        $schedule->job(new job_importaPrazo)->everyMinute()->between('00:00', '23:00');
        $schedule->job(new job_produto)->everyMinute()->between('00:00', '07:00');
        $schedule->job(new job_importaMp)->everyMinute()->between('00:00', '07:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
