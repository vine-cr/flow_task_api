<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Project;
use App\Models\Tag;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $tags     = Tag::all();

        $projects->each(function (Project $project) use ($tags) {
            // Cada projeto recebe entre 3 e 6 tarefas
            Task::factory(rand(3, 6))->create([
                'project_id' => $project->id,
            ])->each(function (Task $task) use ($tags) {
                // Cada tarefa recebe entre 1 e 3 tags aleatórias
                $task->tags()->sync(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );
            });
        });
    }
}
