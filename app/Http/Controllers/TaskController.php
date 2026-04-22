<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService
    ) {}

    /**
     * GET /api/projects/{project}/tasks
     */
    public function index(Project $project): JsonResponse
    {
        $tasks = $this->taskService->listByProject($project);

        return response()->json([
            'data'    => $tasks,
            'message' => 'Tarefas listadas com sucesso!'
        ], 200);
    }

    /**
     * POST /api/projects/{project}/tasks
     */
    public function store(StoreTaskRequest $request, Project $project): JsonResponse
    {
        $task = $this->taskService->create($project, $request->validated());

        return response()->json([
            'data'    => $task,
            'message' => 'Tarefa criada com sucesso!',
        ], 201);
    }

    /**
     * GET /api/projects/{project}/tasks/{task}
     */
    public function show(Project $project, Task $task): JsonResponse
    {
        $this->verifyTaskBelongsToProject($task, $project);

        $task = $this->taskService->findWithTags($task);

        return response()->json([
            'data'    => $task,
            'message' => 'Tarefa encontrada com sucesso!'
        ], 200);
    }

    /**
     * PUT /api/projects/{project}/tasks/{task}
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task): JsonResponse
    {
        $this->verifyTaskBelongsToProject($task, $project);

        $task = $this->taskService->update($task, $request->validated());

        return response()->json([
            'data'    => $task,
            'message' => 'Tarefa atualizada com sucesso!',
        ], 200);
    }

    /**
     * PATCH /api/projects/{project}/tasks/{task}/status
     */
    public function updateStatus(UpdateTaskStatusRequest $request, Project $project, Task $task): JsonResponse
    {
        $this->verifyTaskBelongsToProject($task, $project);

        $task = $this->taskService->updateStatus($task, $request->validated('status'));

        return response()->json([
            'data'    => $task,
            'message' => 'Status atualizado com sucesso!',
        ], 200);
    }

    /**
     * DELETE /api/projects/{project}/tasks/{task}
     */
    public function destroy(Project $project, Task $task): JsonResponse
    {
        $this->verifyTaskBelongsToProject($task, $project);

        $this->taskService->delete($task);

        return response()->json([
            'message' => 'Tarefa removida com sucesso!'
        ], 200);
    }

    /**
     * POST /api/tasks/{task}/tags/{tag}
     */
    public function attachTag(Task $task, Tag $tag): JsonResponse
    {
        $task = $this->taskService->attachTag($task, $tag);

        return response()->json([
            'data'    => $task,
            'message' => 'Tag associada com sucesso!',
        ], 200);
    }

    /**
     * DELETE /api/tasks/{task}/tags/{tag}
     */
    public function detachTag(Task $task, Tag $tag): JsonResponse
    {
        $task = $this->taskService->detachTag($task, $tag);

        return response()->json([
            'data'    => $task,
            'message' => 'Tag removida com sucesso!',
        ], 200);
    }

    /**
     * Garante que a tarefa pertence ao projeto da rota.
     */
    private function verifyTaskBelongsToProject(Task $task, Project $project): void
    {
        if ($task->project_id !== $project->id) {
            abort(404, 'Tarefa não encontrada neste projeto.');
        }
    }
}
