<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;

// Tudo que o admin pode fazer com os usuários passa por aqui
// O middleware 'admin' já garante que só admin chega nesse controller
class AdminController extends Controller
{
    public function __construct(private UserService $userService) {}

    // Painel principal — lista todos os usuários do sistema
    public function index()
    {
        $users = $this->userService->getAllUsers();

        return view('admin.index', compact('users'));
    }

    // Ver o perfil detalhado de um usuário comum
    public function show(User $user)
    {
        // Admin não pode olhar o perfil de outro admin
        if ($user->isAdmin()) {
            abort(403, 'Não é permitido acessar o perfil de outro administrador.');
        }

        return view('admin.show', compact('user'));
    }

    // Criar um usuário novo
    public function create()
    {
        return view('admin.create');
    }

    // Salva o usuário novo no banco
    public function store(StoreUserRequest $request)
    {
        $this->userService->createUser($request->validated());

        return redirect()->route('admin.index')
            ->with('success', 'Usuário criado com sucesso.');
    }

    // Formulário de edição — só funciona pra usuários comuns
    public function edit(User $user)
    {
        if ($user->isAdmin()) {
            abort(403, 'Não é permitido editar outro administrador.');
        }

        return view('admin.edit', compact('user'));
    }

    // Salva as alterações do usuário editado
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($user->isAdmin()) {
            abort(403, 'Não é permitido editar outro administrador.');
        }

        $this->userService->updateUser($user, $request->validated());

        return redirect()->route('admin.index')
            ->with('success', 'Usuário atualizado com sucesso.');
    }

    // Promove um usuário comum pra administrador
    public function promote(User $user)
    {
        if ($user->isAdmin()) {
            abort(422, 'Usuário já é administrador.');
        }

        $this->userService->promoteToAdmin($user);

        return redirect()->route('admin.index')
            ->with('success', "{$user->name} foi promovido a administrador.");
    }

    // Remove o usuário do sistema — o service já tá impedindo deletar outro admin
    public function destroy(User $user)
    {
        $this->userService->deleteUser($user);

        return redirect()->route('admin.index')
            ->with('success', 'Usuário removido com sucesso.');
    }
}
