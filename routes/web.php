<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

// Página inicial manda direto pro login
Route::get('/', fn() => redirect()->route('login'));

// Tudo que começa com /admin é exclusivo pra quem tem role=admin
// O middleware 'admin' barra qualquer um que não seja admin antes mesmo de chegar no controller
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Painel principal — lista todos os usuários do sistema
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Formulário pra criar um usuário novo (pode ser user ou admin)
    Route::get('/users/create', [AdminController::class, 'create'])->name('create');
    Route::post('/users',       [AdminController::class, 'store'])->name('store');

    // Ver, editar e deletar — só funciona pra usuários com role=user
    // Tentar acessar o perfil de outro admin dá 403
    Route::get('/users/{user}',      [AdminController::class, 'show'])->name('show');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/users/{user}',      [AdminController::class, 'update'])->name('update');

    // Promove um user comum pra admin
    Route::patch('/users/{user}/promote', [AdminController::class, 'promote'])->name('promote');

    // Remove o usuário do sistema
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('destroy');
});

// Área do usuário comum — só quem tem role=user entra aqui
// Admin tentando acessar /profile leva um 403 na cara
Route::middleware(['auth', 'user'])->name('profile.')->group(function () {
    Route::get('/profile',      [UserProfileController::class, 'show'])->name('show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('edit');
    Route::put('/profile',      [UserProfileController::class, 'update'])->name('update');
});

// Rotas de autenticação geradas pelo Breeze (login, registro, logout, etc.)
require __DIR__.'/auth.php';
