<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $role
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Campos que podem ser preenchidos em massa
    // 'role' precisa estar aqui pra o admin conseguir criar usuários pelo painel
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Esses campos nunca aparecem em respostas JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed', // o Laravel fez hash automaticamente
        ];
    }

    // Atalhos pra checar o papel do usuário sem ficar comparando string por todo o código
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
