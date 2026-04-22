<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tags fixas com significado semântico
        $tags = [
            ['name' => 'bug',        'color' => '#FF5733'],
            ['name' => 'feature',    'color' => '#33FF57'],
            ['name' => 'melhoria',   'color' => '#3357FF'],
            ['name' => 'urgente',    'color' => '#FFD700'],
            ['name' => 'frontend',   'color' => '#FF33A8'],
            ['name' => 'backend',    'color' => '#00CED1'],
            ['name' => 'banco',      'color' => '#8A2BE2'],
            ['name' => 'revisão',    'color' => '#FF6347'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag['name']], $tag);
        }
    }
}
