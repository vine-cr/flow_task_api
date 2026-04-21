<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('projects', 'ProjectController@index');
Route::post('projects', 'ProjectController@store');
Route::get('projects/{id}', 'ProjectController@show');
Route::put('projects/{id}', 'ProjectController@update');
Route::delete('projects/{id}', 'ProjectController@destroy');

Route::get('projects/{id}/tasks', 'ProjectTaskController@index');
Route::post('projects/{id}/tasks', 'ProjectTaskController@store');
Route::get('projects/{id}/tasks/{id}', 'ProjectTaskController@show');
Route::put('projects/{id}/tasks/{id}', 'ProjectTaskController@update');
Route::delete('projects/{id}/tasks/{id}', 'ProjectTaskController@destroy');
Route::patch('projects/{id}/tasks/{id}/complete', 'ProjectTaskController@complete');

Route::get('tags', 'TagController@index');
Route::post('tags', 'TagController@store');

Route::post('tasks/{taskid}/tags/{tagid}', 'TaskTagController@store');
Route::delete('tasks/{taskid}/tags/{tagid}', 'TaskTagController@destroy');

Route::get('tasks/{taskid}/tags/{tagid}', 'TaskTagController@show');
Route::put('tasks/{taskid}/tags/{tagid}', 'TaskTagController@update');
