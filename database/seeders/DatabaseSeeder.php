<?php

namespace Database\Seeders;

use App\Models\condicao_pgto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            MenuSeeder::class,
            LicitacaoTipoSeeder::class,
            // MenuUsuarioSeeder::class,
        ]);
    }
}
