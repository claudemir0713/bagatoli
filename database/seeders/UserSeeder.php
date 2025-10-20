<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::truncate();
        $User=[
            [
                'name' => 'Claudemir Ivanio Conzatti',
                'email' => 'claudemir@plannersolucoes.com.br',
                'password' => bcrypt('zz5cic')
            ],

        ];
        User::insert($User);
    }
}
