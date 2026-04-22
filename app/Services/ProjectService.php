<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectService
{

    // Lista todos os projetos com contagem de tarefas.
    public function listAll(): LengthAwarePaginator
    {
        return Project::withCount('tasks')
            ->with('user:id,name,email')
            ->latest()
            ->paginate(15);
    }

    // Busca um projeto específico com suas tarefas e tags.
    public function findWithTasks(Project $project): Project
    {
        return $project->load(['tasks.tags', 'user:id,name,email']);
    }

    // Cria um novo projeto.
    public function create(array $data): Project
    {
        $project = Project::create($data);

        return $project->loadCount('tasks');
    }

    // Atualiza um projeto existente.
    public function update(Project $project, array $data): Project
    {
        $project->update($data);

        return $project->fresh(['tasks']);
    }

    //Remove um projeto (as tarefas são removidas em cascata pela migration).
    public function delete(Project $project): Project
    {
        $project->delete();

        return $project;
    }
}
