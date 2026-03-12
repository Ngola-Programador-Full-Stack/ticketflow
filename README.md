# TicketFlow — BPM Support System

> Sistema de suporte técnico com orquestração de processos via **Camunda Cloud (Zeebe 8.9)**, desenvolvido em **Laravel 12** como demonstração prática de integração BPM.

---

## Sobre o Projecto

O TicketFlow é uma aplicação web que demonstra a integração entre uma interface de suporte técnico e um motor de processos BPM na cloud. Ao submeter um ticket, um processo BPMN é automaticamente instanciado no **Camunda Cloud**, com encaminhamento automático por prioridade via gateway de decisão.

Desenvolvido como prova de conceito para demonstrar competências em **BPM, Laravel, RBAC e integração com APIs REST**.

**Deploy em produção:** [ticketflow-selenium.up.railway.app](https://ticketflow-selenium.up.railway.app)

---

## Arquitectura

```
┌─────────────────┐     REST API      ┌──────────────────────┐
│  Laravel 12     │ ────────────────► │  Camunda Cloud       │
│  (Frontend/API) │                   │  Zeebe 8.9           │
│                 │                   │                      │
│  MySQL          │                   │  BPMN Process v2.0   │
│  (Tickets DB)   │                   │  Gateway de Decisão  │
│                 │                   │  Timer SLA (4h)      │
└─────────────────┘                   └──────────────────────┘
                                               │
                                    ┌──────────┴──────────┐
                                    │                     │
                               Ticket Simples      Ticket Complexo
                               (Técnico Suporte)   (Eng. Sénior)
                                    │                     │
                                    └──────────┬──────────┘
                                               │
                                     Confirmar Solução
                                               │
                                       Ticket Encerrado
```

---

## Funcionalidades

- **Sistema de autenticação completo** — login, registo, logout com sessões seguras
- **RBAC (Role-Based Access Control)** — dois papéis distintos: `cliente` e `agente`
- **Portal do Cliente** — submissão e acompanhamento dos próprios tickets
- **Painel do Agente** — fila de suporte global com resolução de tickets
- **Integração automática com Camunda Cloud** via API REST (Zeebe 8.9)
- **Gateway BPMN de decisão** — encaminha por prioridade (Simples / Complexo)
- **Timer SLA automático** — escalonamento após 4h sem resolução
- **Base de dados MySQL** com registo de instâncias Camunda por ticket
- **Monitorização em tempo real** no Camunda Operate
- **Interface totalmente responsiva** (mobile/tablet/desktop)

---

## Stack Tecnológica

| Camada        | Tecnologia                             |
|---------------|----------------------------------------|
| Backend       | Laravel 12 (PHP 8.3)                   |
| Frontend      | Blade Templates + Inter (Google Fonts) |
| Base de Dados | MySQL 8                                |
| BPM Engine    | Camunda Cloud — Zeebe 8.9              |
| Processo      | BPMN 2.0 v2.0 com Timer e Merge GW    |
| Monitorização | Camunda Operate                        |
| Hosting       | Railway.app                            |

---

## Processo BPMN v2.0

O processo melhorado inclui:

1. **Start Event** — Ticket submetido via Laravel com variáveis (`ticketId`, `simples`, `titulo`, `descricao`, `cliente`)
2. **Exclusive Gateway** — Decisão imediata pela variável `simples` (enviada pelo Laravel)
3. **Caminho Simples** → `UserTask: Resolver Ticket (Técnico de Suporte)`
   - **Timer Boundary Event (PT4H)** — se não resolvido em 4h, escala automaticamente
4. **Caminho Complexo** → `UserTask: Escalar para Engenheiro Sénior`
5. **Merge Gateway** — une os dois caminhos num único fluxo
6. **UserTask: Confirmar Solução Aplicada** — agente documenta a resolução
7. **End Event** — único, processo encerrado

> As UserTasks ficam visíveis no **Camunda Operate** com o token parado — permite monitorização em tempo real do estado de cada ticket.

---

## Papéis de Utilizador

### Cliente (`role = 'cliente'`)

- Regista conta deixando o campo "Código de acesso" em branco
- Acede ao **Portal de Suporte Técnico**
- Cria tickets com título, descrição e prioridade
- Vê **apenas os seus próprios tickets**
- Acompanha status: `aberto` → `resolvido`

### Agente (`role = 'agente'`)

- Regista conta com **código de convite secreto** (`AGENTE_INVITE_CODE`)
- **OU** é o primeiro utilizador a registar (torna-se agente automaticamente)
- Acede ao **Painel de Gestão — Selenium**
- Vê **todos os tickets** de todos os clientes
- Resolve tickets via modal (preenche solução)
- Visualiza instâncias Camunda e monitoriza no Operate

---

## Fluxo Completo de um Ticket

```
1. Cliente submete ticket
   ├─ Título, Descrição, Prioridade (Simples | Complexo)
   └─ Sistema gera ID único: TK-XXXXXXXXXXXXXXXX

2. Laravel regista ticket na BD
   ├─ cliente_id  = ID do utilizador autenticado
   ├─ status      = 'aberto'
   └─ responsavel = null (preenchido só quando resolvido)

3. CamundaService inicia processo BPMN
   ├─ OAuth2 → obtém token (cachado 3500s)
   ├─ POST /v2/process-instances
   └─ Guarda processInstanceKey na BD

4. Gateway decide caminho
   ├─ simples=true  → Resolver Ticket (Técnico)
   └─ simples=false → Escalar para Engenheiro Sénior

5. Token visível no Camunda Operate
   └─ UserTask fica activa até resolução manual

6. Agente resolve ticket no painel Laravel
   ├─ Clica "Resolver" → modal com campo solução
   ├─ status      = 'resolvido'
   ├─ responsavel = nome do agente
   └─ solucao     = descrição da resolução

7. Cliente vê ticket como 'resolvido' no seu portal
```

---

## Instalação Local

### Pré-requisitos

- PHP 8.3+
- Composer
- MySQL 8+
- Node.js 18+
- Conta no [Camunda Cloud](https://camunda.io)

### Passos

```bash
# 1. Clonar o repositório
git clone https://github.com/Ngola-Programador-Full-Stack/ticketflow.git
cd ticketflow

# 2. Instalar dependências PHP
composer install

# 3. Instalar dependências Node.js
npm install

# 4. Configurar ambiente
cp .env.example .env
php artisan key:generate

# 5. Configurar .env (ver secção abaixo)

# 6. Migrar base de dados
php artisan migrate

# 7. Build assets
npm run build

# 8. Iniciar servidor
php artisan serve
```

### Variáveis de Ambiente

> ⚠️ O ficheiro `.env` contém credenciais sensíveis. **Nunca faça commit** para o repositório.

```env
# Aplicação
APP_NAME=TicketFlow
APP_ENV=local
APP_URL=http://localhost:8000

# Base de Dados
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticketflow
DB_USERNAME=root
DB_PASSWORD=

# Camunda Cloud
CAMUNDA_CLIENT_ID=your_client_id
CAMUNDA_CLIENT_SECRET=your_client_secret
CAMUNDA_ZEEBE_ADDRESS=https://CLUSTER_ID.zeebe.camunda.io
CAMUNDA_OAUTH_URL=https://login.cloud.camunda.io/oauth/token

# Autenticação de Agentes
# ⚠️ NUNCA expor este valor publicamente
AGENTE_INVITE_CODE=seu_codigo_secreto

# Sessões
SESSION_DRIVER=database
CACHE_STORE=database
```

---

## Deployment (Railway)

A aplicação está deployada em [Railway.app](https://railway.app) com MySQL dedicado.

### Configuração

```
Procfile:
web: php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

### Variáveis necessárias no Railway

Todas as variáveis do `.env` devem ser configuradas em **Settings → Variables** no painel Railway. Nunca commitar credenciais.

### Acesso em produção

```
URL: https://ticketflow-selenium.up.railway.app
```

---

## Estrutura do Projecto

```
ticketflow/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php        # Login, register, logout
│   │   └── TicketController.php      # CRUD tickets + Camunda API
│   ├── Models/
│   │   ├── User.php                  # Autenticação + roles (cliente|agente)
│   │   └── Ticket.php                # Modelo tickets + relação cliente
│   ├── Services/
│   │   └── CamundaService.php        # OAuth2 + integração Zeebe API
│   └── Providers/
│       └── AppServiceProvider.php    # HTTPS forçado em produção
├── database/
│   └── migrations/
│       ├── create_users_table.php
│       ├── create_tickets_table.php
│       ├── add_role_to_users_table.php
│       └── add_cliente_id_to_tickets_table.php
├── resources/views/
│   ├── layouts/
│   │   ├── main.blade.php            # Layout principal (navbar, hero, user pill)
│   │   └── auth.blade.php            # Layout auth (logo Selenium, gradiente)
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php        # Campo opcional de código de convite
│   └── tickets/
│       ├── index.blade.php           # Dashboard diferenciado cliente/agente
│       └── create.blade.php          # Formulário novo ticket
├── routes/
│   └── web.php                       # Rotas protegidas por middleware auth
├── .env.example                      # Template de variáveis (sem credenciais)
├── Procfile                          # Deploy Railway
└── README.md
```

---

## Estrutura da Base de Dados

### Tabela: `users`

| Campo             | Tipo      | Descrição                        |
|-------------------|-----------|----------------------------------|
| id                | PK        |                                  |
| name              | string    |                                  |
| email             | unique    |                                  |
| password          | hashed    | Bcrypt                           |
| role              | string    | `'cliente'` \| `'agente'`        |
| email_verified_at | timestamp | nullable                         |
| created_at        | timestamp |                                  |
| updated_at        | timestamp |                                  |

### Tabela: `tickets`

| Campo               | Tipo   | Descrição                              |
|---------------------|--------|----------------------------------------|
| id                  | PK     |                                        |
| ticket_id           | unique | Formato: `TK-XXXXXXXXXXXXXXXX`         |
| cliente_id          | FK     | → users.id (quem criou o ticket)       |
| titulo              | string |                                        |
| descricao           | text   |                                        |
| prioridade          | string | `'simples'` \| `'complexo'`            |
| status              | string | `'aberto'` \| `'resolvido'`            |
| camunda_instance_id | string | processInstanceKey do Zeebe (nullable) |
| responsavel         | string | Nome do agente que resolveu (nullable) |
| solucao             | text   | Descrição da resolução (nullable)      |
| created_at          | timestamp |                                     |
| updated_at          | timestamp |                                     |

---

## Integração Camunda Cloud

### Autenticação OAuth2

```php
POST https://login.cloud.camunda.io/oauth/token
{
    "grant_type":    "client_credentials",
    "client_id":     "...",
    "client_secret": "...",
    "audience":      "zeebe.camunda.io"
}
// Token cachado por 3500 segundos
```

### Criar Instância de Processo

```php
POST {CAMUNDA_ZEEBE_ADDRESS}/v2/process-instances
Authorization: Bearer {token}
{
    "processDefinitionId": "Process_0dv1u4g",
    "variables": {
        "ticketId":  "TK-69B27D883ECC9",
        "titulo":    "Sistema de pagamentos com erro",
        "descricao": "...",
        "simples":   true,
        "cliente":   "Nome do Cliente"
    }
}
// Resposta: { "processInstanceKey": "2251799813685251" }
```

### Monitorização

Acede ao [Camunda Operate](https://operate.camunda.io) para visualizar:
- Instâncias activas por processo
- Estado do token em cada UserTask
- Variáveis de cada instância
- Histórico de execução

---

## Segurança

- CSRF tokens em todos os formulários
- Middleware `auth` protege todas as rotas de tickets
- `abort(403)` no `resolver()` para não-agentes
- Passwords com Bcrypt
- Credenciais Camunda apenas em `.env` (nunca no código)
- Token OAuth cachado (evita chamadas desnecessárias)
- HTTPS forçado em produção via `AppServiceProvider`
- `.env` no `.gitignore` — nunca versionado

---

## Troubleshooting

**"Camunda: token nulo"**
→ Verificar `CAMUNDA_CLIENT_ID` e `CAMUNDA_CLIENT_SECRET`

**"tickets table does not exist"**
→ Executar `php artisan migrate`

**Tickets não aparecem para agente**
→ Verificar se `role = 'agente'` na tabela `users`

**Instância Camunda aparece como N/A**
→ Cluster pausado — retomar em [console.cloud.camunda.io](https://console.cloud.camunda.io)

---

## Autor

**António Ambrósio** — Programador Full Stack
[paigrandengola@gmail.com](mailto:paigrandengola@gmail.com) · +244 947 811 549

---

## Licença

Desenvolvido para fins de demonstração técnica — BPM + Laravel + RBAC.
