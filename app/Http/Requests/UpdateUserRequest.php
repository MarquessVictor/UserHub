<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

// Validação compartilhada entre admin editando um user e o próprio user editando seu perfil
class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        // Pega o ID do usuário sendo editado — pode vir da rota (admin editando outro)
        // ou do usuário logado (user editando a si mesmo)
        $userId = $this->route('user')?->id ?? auth()->id();

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,{$userId}"],
        ];

        // Senha é opcional na edição — só valida se o campo vier preenchido
        if ($this->filled('password')) {
            $rules['password'] = ['confirmed', Password::defaults()];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique'   => 'Este e-mail já está em uso.',
        ];
    }
}
