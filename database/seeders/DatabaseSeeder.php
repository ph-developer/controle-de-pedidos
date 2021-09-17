<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Semeia o banco de dados com entidades para testes.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'nome' => 'Admin',
            'email' => 'admin@admin.dev',
            'senha' => bcrypt('@135790_#adm!'),
        ]);
    }
}
