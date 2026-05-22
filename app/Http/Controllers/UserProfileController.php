<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

// Controller do usuário comum — ele só pode ver e editar o próprio perfil
// O middleware 'user' já barra qualquer admin que tentar acessar essas rotas
class UserProfileController extends Controller
{
    public function __construct(private UserService $userService) {}

    // Exibe o perfil do usuário logado
    public function show(Request $request)
    {
        return view('profile.show', ['user' => $request->user()]);
    }

    // Formulário de edição do próprio perfil
    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    // Salva as alterações e volta pro perfil
    public function update(UpdateUserRequest $request)
    {
        $this->userService->updateUser($request->user(), $request->validated());

        return redirect()->route('profile.show')
            ->with('success', 'Perfil atualizado com sucesso.');
    }
}
