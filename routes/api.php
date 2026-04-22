<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Flow Task API — Rotas
|--------------------------------------------------------------------------
*/

// -------------------------------------------------------------------------
// Projects — CRUD completo
// GET    /api/projects
// POST   /api/projects
// GET    /api/projects/{project}
// PUT    /api/projects/{project}
// DELETE /api/projects/{project}
// -------------------------------------------------------------------------
Route::apiResource('projects', ProjectController::class);

// -------------------------------------------------------------------------
// Tasks — aninhadas em Projects (sem shallow)
// GET    /api/projects/{project}/tasks
// POST   /api/projects/{project}/tasks
// GET    /api/projects/{project}/tasks/{task}
// PUT    /api/projects/{project}/tasks/{task}
// DELETE /api/projects/{project}/tasks/{task}
// -------------------------------------------------------------------------
Route::apiResource('projects.tasks', TaskController::class);

// -------------------------------------------------------------------------
// Task status — rota extra para atualizar apenas o status
// PATCH  /api/projects/{project}/tasks/{task}/status
// -------------------------------------------------------------------------
Route::patch(
    'projects/{project}/tasks/{task}/status',
    [TaskController::class, 'updateStatus']
)->name('projects.tasks.updateStatus');

// -------------------------------------------------------------------------
// Associação Task <-> Tag
// POST   /api/tasks/{task}/tags/{tag}
// DELETE /api/tasks/{task}/tags/{tag}
// -------------------------------------------------------------------------
Route::post(
    'tasks/{task}/tags/{tag}',
    [TaskController::class, 'attachTag']
)->name('tasks.tags.attach');

Route::delete(
    'tasks/{task}/tags/{tag}',
    [TaskController::class, 'detachTag']
)->name('tasks.tags.detach');

// -------------------------------------------------------------------------
// Tags — apenas listagem e criação conforme documento
// GET    /api/tags
// POST   /api/tags
// -------------------------------------------------------------------------
Route::get('tags',  [TagController::class, 'index'])->name('tags.index');
Route::post('tags', [TagController::class, 'store'])->name('tags.store');

// -------------------------------------------------------------------------
// Profile — via users/{user}/profile
// GET    /api/users/{user}/profile
// PUT    /api/users/{user}/profile
// -------------------------------------------------------------------------
Route::get('users/{user}/profile', [ProfileController::class, 'show'])->name('users.profile.show');
Route::put('users/{user}/profile', [ProfileController::class, 'upsert'])->name('users.profile.upsert');
