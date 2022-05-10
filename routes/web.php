<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CollaboratorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return redirect('/tarefas');
});


Route::get('/tarefas', [TaskController::class, 'index'])->name('tasks');
Route::get('/tarefas/nova', [TaskController::class, 'create'])->name('forms.task');
Route::post('/tarefas/nova', [TaskController::class, 'store'])->name('forms.task.store');
Route::get('/tarefas/{id}/editar', [TaskController::class, 'edit'])->name('forms.task.edit');
Route::put('/tarefas/{id}/editar', [TaskController::class, 'update'])->name('forms.task.update');
Route::delete('/tarefas/{id}/excluir', [TaskController::class, 'destroy'])->name('forms.task.destroy');

Route::get('/colaboradores', [CollaboratorController::class, 'index'])->name('collaborators');
Route::get('/colaboradores/novo', [CollaboratorController::class, 'create'])->name('forms.collaborator');
Route::post('/colaboradores/novo', [CollaboratorController::class, 'store'])->name('forms.collaborator.store');
Route::get('/colaboradores/{id}/editar', [CollaboratorController::class, 'edit'])->name('forms.collaborator.edit');
Route::put('/colaboradores/{id}/editar', [CollaboratorController::class, 'update'])->name('forms.collaborator.update');
Route::delete('/colaboradores/{id}/excluir', [CollaboratorController::class, 'destroy'])->name('forms.collaborator.destroy');


