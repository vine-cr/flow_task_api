<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuário fixo para facilitar testes
        $fixedUser = User::factory()->create([
            'name'  => 'Admin Teste',
            'email' => 'admin@flowtask.com',
        ]);

        // Cria perfil para o usuário fixo
        $fixedUser->profile()->create([
            'bio'        => 'Usuário administrador para testes da API.',
            'phone'      => '(11) 99999-0000',
            'avatar_url' => 'https://i.pravatar.cc/200?u=admin',
        ]);

        // Mais 4 usuários aleatórios com perfil
        User::factory(4)->create()->each(function (User $user) {
            $user->profile()->create([
                'bio'        => fake()->paragraph(),
                'phone'      => fake()->phoneNumber(),
                'avatar_url' => fake()->imageUrl(200, 200, 'people'),
            ]);
        });
    }
}
