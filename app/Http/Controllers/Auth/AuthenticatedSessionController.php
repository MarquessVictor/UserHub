<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    // Exibe a tela de login
    public function create(): View
    {
        return view('auth.login');
    }

    // Processa o login e redireciona cada um pro seu lugar:
    // admin vai pro painel, user comum vai pro próprio perfil
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        return $user->isAdmin()
            ? redirect()->route('admin.index')
            : redirect()->route('profile.show');
    }

    // Logout — encerra a sessão e manda de volta pra home
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
