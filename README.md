# UserHub

Olá, esse projeto foi feito pra fins de estudo de Laravel. A ideia é simples: um sistema de gerenciamento de usuários com dois tipos de acesso — **admin** e **user** cada um com suas regras e restrições.

---

## O que o projeto faz

O UserHub é basicamente um CRUD de usuários com controle de acesso baseado em roles. Nada de complexo demais, mas suficiente pra cobrir bastante coisa importante do Laravel no dia a dia.

**Admin pode:**
- Ver a lista com todos os usuários do sistema
- Acessar, editar e deletar usuários com role `user`
- Ver outros admins na lista, mas sem poder mexer neles
- Criar usuários novos (tanto `user` quanto `admin`)
- Promover um usuário comum pra administrador

**Usuário comum pode:**
- Ver e editar só o próprio perfil
- Não enxerga nenhum outro usuário do sistema

O registro público cria apenas contas com role `user`. Pra criar um admin, precisa estar logado como admin e usar o painel.

---

## Stack

- **Laravel 13** com **Breeze** pra autenticação
- **Blade** nos templates
- **Tailwind CSS** no estilo
- **MySQL** no banco (SQLite também funciona se você tiver a extensão instalada)

---


## Como rodar

**1. Instale as dependências**
```bash
composer install
npm install
```

**2. Configure o ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

**3. Configure o banco no `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=userhub
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

**4. Rode as migrations e o seeder**
```bash
php artisan migrate:fresh --seed
```

**5. Compile os assets e suba o servidor**
```bash
npm run build
php artisan serve
```

Acesse `http://localhost:8000` — vai cair direto no login.

---

## Usuário admin inicial

O seeder já cria um admin pra você começar a testar:

| Campo | Valor |
|-------|-------|
| E-mail | `admin@userhub.com` |
| Senha | `password` |


---

## O que dá pra aprender com esse projeto

- Autenticação com Breeze
- Controle de acesso com middleware customizado
- Separação entre Controller, Service e Request
- Route model binding
- Redirecionamento condicional baseado em role
- Tradução de mensagens de validação
- Paginação com Eloquent

---

Projeto simples.
