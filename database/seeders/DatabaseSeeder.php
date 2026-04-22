<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            UserSeeder::class,    // 1º: cria usuários e perfis
            TagSeeder::class,     // 2º: cria tags globais
            ProjectSeeder::class, // 3º: cria projetos vinculados a usuários
            TaskSeeder::class,    // 4º: cria tarefas e associa tags
        ]);
    }
}
