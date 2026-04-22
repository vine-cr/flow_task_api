<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    /**
     * GET /api/tags
     */
    public function index(): JsonResponse
    {
        $tags = Tag::withCount('tasks')->orderBy('name')->get();

        return response()->json([
            'data'    => $tags,
            'message' => 'Tags listadas com sucesso!'
        ], 200);
    }

    /**
     * POST /api/tags
     */
    public function store(StoreTagRequest $request): JsonResponse
    {
        $tag = Tag::create($request->validated());

        return response()->json([
            'data'    => $tag,
            'message' => 'Tag criada com sucesso!'
        ], 201);
    }
}
