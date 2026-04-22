<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectService $projectService
    ) {}

    /**
     * GET /api/projects
     */
    public function index(): JsonResponse
    {
        $projects = $this->projectService->listAll();

        return response()->json([
            'data'    => $projects,
            'message' => 'Projetos listados com sucesso!'
        ], 200);
    }

    /**
     * POST /api/projects
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->create($request->validated());

        return response()->json([
            'data'    => $project,
            'message' => 'Projeto criado com sucesso.',
        ], 201);
    }

    /**
     * GET /api/projects/{project}
     */
    public function show(Project $project): JsonResponse
    {
        $project = $this->projectService->findWithTasks($project);

        return response()->json([
            'data' => $project,
            'message' => 'Projeto encontrado com sucesso!'
        ], 200);
    }

    /**
     * PUT /api/projects/{project}
     */
    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $project = $this->projectService->update($project, $request->validated());

        return response()->json([
            'data'    => $project,
            'message' => 'Projeto atualizado com sucesso.',
        ], 200);
    }

    /**
     * DELETE /api/projects/{project}
     */
    public function destroy(Project $project): JsonResponse
    {
        $project = $this->projectService->delete($project);

        return response()->json([
            'data'    => $project,
            'message' => 'Projeto removido com sucesso!'
        ], 200);
    }
}
