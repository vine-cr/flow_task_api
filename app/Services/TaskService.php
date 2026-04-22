<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{

    // Lista todas as tarefas de um projeto com suas tags.
    public function listByProject(Project $project): LengthAwarePaginator
    {
        return $project->tasks()
            ->with('tags')
            ->latest()
            ->paginate(20);
    }

    // Busca uma tarefa com suas tags e projeto.
    public function findWithTags(Task $task): Task
    {
        return $task->load(['tags', 'project:id,name,status']);
    }

    // Cria uma nova tarefa dentro de um projeto.
    public function create(Project $project, array $data): Task
    {
        $task = $project->tasks()->create(
            collect($data)->except('tag_ids')->toArray()
        );

        if (!empty($data['tag_ids'])) {
            $task->tags()->sync($data['tag_ids']);
        }

        return $task->load('tags');
    }

    // Atualiza uma tarefa.
    public function update(Task $task, array $data): Task
    {
        $task->update(
            collect($data)->except('tag_ids')->toArray()
        );

        if (array_key_exists('tag_ids', $data)) {
            $task->tags()->sync($data['tag_ids'] ?? []);
        }

        return $task->fresh(['tags']);
    }

    // Atualiza apenas o status de uma tarefa.
    public function updateStatus(Task $task, string $status): Task
    {
        $task->update(['status' => $status]);

        return $task->fresh(['tags']);
    }
    // Remove uma tarefa.
    public function delete(Task $task): void
    {
        $task->tags()->detach();
        $task->delete();
    }

    // Associa uma tag a uma tarefa (sem duplicar).
    public function attachTag(Task $task, Tag $tag): Task
    {
        // syncWithoutDetaching evita duplicata na tabela pivô (regra de negócio 5)
        $task->tags()->syncWithoutDetaching([$tag->id]);

        return $task->load('tags');
    }

    // Remove a associação entre uma tag e uma tarefa.
    public function detachTag(Task $task, Tag $tag): Task
    {
        $task->tags()->detach($tag->id);

        return $task->load('tags');
    }
}
