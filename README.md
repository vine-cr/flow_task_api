# Flow Task API

API RESTful construída com **Laravel 12** seguindo a arquitetura **MSC (Model-Service-Controller)**. Retorna exclusivamente JSON — sem nenhuma view Blade.

---

## Stack

- PHP 8.2+
- Laravel 12
- MySQL / PostgreSQL / SQLite

> Autenticação **não** é necessária neste projeto.

---

## Instalação

```bash
git clone <repo>
cd flow-task-api

composer install
cp .env.example .env
php artisan key:generate

# Configure DB_* no .env, depois:
php artisan migrate:fresh --seed
php artisan serve
```

---

## Arquitetura MSC

```
Requisição HTTP
     ↓
Controller        → recebe a requisição, valida via FormRequest, retorna JSON
     ↓
Service           → contém toda a lógica de negócio
     ↓
Model / Eloquent  → acessa o banco de dados
```

- `app/Services/ProjectService.php` — lógica de projetos
- `app/Services/TaskService.php`    — lógica de tarefas, associação de tags

---

## Estrutura de arquivos

```
app/
├── Http/
│   ├── Controllers/Api/
│   │   ├── ProfileController.php
│   │   ├── ProjectController.php
│   │   ├── TaskController.php
│   │   └── TagController.php
│   └── Requests/
│       ├── StoreProfileRequest.php
│       ├── StoreProjectRequest.php
│       ├── StoreTaskRequest.php
│       └── StoreTagRequest.php
│       ├── UpdateProjectRequest.php
│       ├── UpdateTaskRequest.php
│       ├── UpdateTaskStatusRequest.php
├── Models/
│   ├── User.php
│   ├── Profile.php
│   ├── Project.php
│   ├── Task.php
│   └── Tag.php
└── Services/
    ├── ProjectService.php
    └── TaskService.php
routes/
└── api.php
database/
├── factories/
│   ├── UserFactory.php
│   ├── ProfileFactory.php
│   ├── ProjectFactory.php
│   ├── TaskFactory.php
│   └── TagFactory.php
├── migrations/
│   ├── ..._create_users_table.php
│   ├── ..._create_profiles_table.php
│   ├── ..._create_projects_table.php
│   ├── ..._create_tasks_table.php
│   ├── ..._create_tags_table.php
│   └── ..._create_tag_task_table.php
└── seeders/
    ├── DatabaseSeeder.php
    ├── UserSeeder.php
    ├── TagSeeder.php
    ├── ProjectSeeder.php
    └── TaskSeeder.php
```

---

## Mapa de Rotas

### Projects

| Método | Endpoint | Ação |
|--------|----------|------|
| GET | `/api/projects` | Listar projetos (com tasks_count) |
| POST | `/api/projects` | Criar projeto |
| GET | `/api/projects/{id}` | Exibir projeto (com tarefas e tags) |
| PUT | `/api/projects/{id}` | Atualizar projeto |
| DELETE | `/api/projects/{id}` | Remover projeto (cascata nas tarefas) |

### Tasks

| Método | Endpoint | Ação |
|--------|----------|------|
| GET | `/api/projects/{id}/tasks` | Listar tarefas do projeto |
| POST | `/api/projects/{id}/tasks` | Criar tarefa no projeto |
| GET | `/api/projects/{id}/tasks/{taskId}` | Exibir tarefa |
| PUT | `/api/projects/{id}/tasks/{taskId}` | Atualizar tarefa |
| DELETE | `/api/projects/{id}/tasks/{taskId}` | Remover tarefa |
| PATCH | `/api/projects/{id}/tasks/{taskId}/status` | Atualizar apenas o status |

### Tags

| Método | Endpoint | Ação |
|--------|----------|------|
| GET | `/api/tags` | Listar todas as tags |
| POST | `/api/tags` | Criar nova tag |

### Associação Task-Tag

| Método | Endpoint | Ação |
|--------|----------|------|
| POST | `/api/tasks/{taskId}/tags/{tagId}` | Associar tag a uma tarefa |
| DELETE | `/api/tasks/{taskId}/tags/{tagId}` | Remover tag de uma tarefa |

### Profile

| Método | Endpoint | Ação |
|--------|----------|------|
| GET | `/api/users/{id}/profile` | Exibir perfil do usuário |
| PUT | `/api/users/{id}/profile` | Criar ou atualizar perfil |

---

## Valores aceitos nos campos

| Campo | Entidade | Valores |
|-------|----------|---------|
| `status` | Project | `open`, `in_progress`, `completed` |
| `status` | Task | `pending`, `in_progress`, `done` |
| `priority` | Task | `low`, `medium`, `high` |
| `color` | Tag | Hexadecimal (ex: `#FF5733`) |

---

## Formato das respostas

### Sucesso — Listar recursos (Ex: Projetos)
```json
{
  "data": [
    { "id": 1, "name": "Meu Projeto", "tasks_count": 5 }
  ],
  "message": "Projetos listados com sucesso!"
}
```

### Sucesso — criar projeto
```json
{
  "data": { "id": 1, "name": "Novo Projeto" },
  "message": "Projeto criado com sucesso."
}
```

### Erro — não encontrado
```json
{
  "message": "Recurso não encontrado.",
  "status": 404
}
```

### Erro — validação
```json
{
  "message": "Dados inválidos.",
  "errors": {
    "name": ["O nome do projeto é obrigatório."]
  }
}
```

---

## Regras de negócio implementadas

1. Ao excluir um projeto, **todas as suas tarefas são removidas em cascata** (configurado na migration com `cascadeOnDelete`).
2. `status` de Project só aceita: `open`, `in_progress`, `completed`.
3. `status` de Task só aceita: `pending`, `in_progress`, `done`.
4. `priority` de Task só aceita: `low`, `medium`, `high`.
5. **Não é possível associar a mesma tag a uma tarefa mais de uma vez** (chave primária composta na tabela `tag_task` + `syncWithoutDetaching` no Service).
6. Ao listar projetos, a **contagem de tarefas** é retornada via `withCount('tasks')`.

---

## Comandos úteis

```bash
# Criar e popular o banco do zero
php artisan migrate:fresh --seed

# Listar todas as rotas da API
php artisan route:list --path=api

# Criar um Form Request
php artisan make:request NomeDoRequest

# Criar um Seeder
php artisan make:seeder NomeDoSeeder
```
