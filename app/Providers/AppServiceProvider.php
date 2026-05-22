<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Quando um usuário já logado tenta acessar /login ou /register,
        // o Laravel precisa saber pra onde redirecionar sem isso dá loop infinito
        // Admin vai pro painel, user comum vai pro próprio perfil
        RedirectIfAuthenticated::redirectUsing(function () {
            /** @var \App\Models\User|null $user */
            $user = auth()->user();

            return $user?->isAdmin()
                ? route('admin.index')
                : route('profile.show');
        });
    }
}
