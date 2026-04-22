<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
// use Illuminate\Http\Response; // Você pode até remover essa linha se não for mais usar as constantes

class ProfileController extends Controller
{
    /**
     * GET /api/users/{user}/profile
     */
    public function show(User $user): JsonResponse
    {
        $profile = $user->profile;

        if (!$profile) {
            return response()->json([
                'message' => 'Perfil não encontrado.'
            ], 404);
        }

        return response()->json([
            'data'    => $profile,
            'message' => 'Perfil encontrado com sucesso!'
        ], 200);
    }

    /**
     * PUT /api/users/{user}/profile
     * Cria ou atualiza o perfil do usuário (upsert).
     */
    public function upsert(StoreProfileRequest $request, User $user): JsonResponse
    {
        $profile = $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->validated()
        );

        $statusCode = $profile->wasRecentlyCreated ? 201 : 200;

        $message = $profile->wasRecentlyCreated
            ? 'Perfil criado com sucesso!'
            : 'Perfil atualizado com sucesso!';

        return response()->json([
            'data'    => $profile,
            'message' => $message,
        ], $statusCode);
    }
}
