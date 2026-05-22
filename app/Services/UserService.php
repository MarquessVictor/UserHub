<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

// Toda a lógica de negócio relacionada a usuários fica aqui
// Os controllers só chamam esses métodos — sem SQL ou regra de negócio espalhada por aí
class UserService
{
    // Retorna todos os usuários paginados — admins primeiro, depois users, ambos em ordem alfabética
    public function getAllUsers(): LengthAwarePaginator
    {
        return User::orderBy('role')->orderBy('name')->paginate(15);
    }

    // Busca um usuário pelo ID — lança 404 automaticamente se não encontrar
    public function findUser(int $id): User
    {
        return User::findOrFail($id);
    }

    public function createUser(array $data): User
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);
    }

    public function updateUser(User $user, array $data): User
    {
        $user->name  = $data['name'];
        $user->email = $data['email'];

        // Só atualiza a senha se o campo vier preenchido no formulário
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return $user;
    }

    // Sobe um usuário common pra admin
    public function promoteToAdmin(User $user): User
    {
        if ($user->isAdmin()) {
            abort(422, 'Usuário já é administrador.');
        }

        $user->role = 'admin';
        $user->save();

        return $user;
    }

    public function deleteUser(User $user): void
    {
        // Admin não pode deletar outro admin — essa regra existe só no service,
        // não precisa repetir em todo lugar que chama esse método
        if ($user->isAdmin()) {
            abort(403, 'Não é possível deletar um usuário admin.');
        }

        $user->delete();
    }
}
