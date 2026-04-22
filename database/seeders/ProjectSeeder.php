<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Busca os usuários já criados
        $users = User::all();

        // Cada usuário recebe entre 2 e 4 projetos
        $users->each(function (User $user) {
            Project::factory(rand(2, 4))->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
