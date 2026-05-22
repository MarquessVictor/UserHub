<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

// Validação usada quando o admin cria um usuário novo pelo painel
class StoreUserRequest extends FormRequest
{
    // Só admin pode criar usuário por aqui — o middleware já garante isso,
    // mas a gente deixa aqui também por segurança
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role'     => ['required', 'in:admin,user'], // só esses dois valores são válidos
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'O nome é obrigatório.',
            'email.required'    => 'O e-mail é obrigatório.',
            'email.unique'      => 'Este e-mail já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'role.required'     => 'O perfil é obrigatório.',
            'role.in'           => 'O perfil deve ser "admin" ou "user".',
        ];
    }
}
