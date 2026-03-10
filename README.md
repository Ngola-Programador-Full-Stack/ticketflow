# TicketFlow — BPM Support System

> Sistema de suporte técnico com orquestração de processos via **Camunda Cloud (Zeebe 8.9)**, desenvolvido em **Laravel 12** como demonstração prática de integração BPM.

---

## Sobre o Projecto

O TicketFlow é uma aplicação web que demonstra a integração entre uma interface de suporte técnico e um motor de processos BPM na cloud. Ao submeter um ticket, um processo BPMN é automaticamente instanciado no **Camunda Cloud**, com encaminhamento automático por prioridade via gateway de decisão.

Desenvolvido como prova de conceito para demonstrar competências em **BPM, Laravel e integração com APIs REST**.

---

## Arquitectura

```
┌─────────────────┐     REST API      ┌──────────────────────┐
│  Laravel 12     │ ────────────────► │  Camunda Cloud       │
│  (Frontend/API) │                   │  Zeebe 8.9           │
│                 │                   │                      │
│  MySQL          │                   │  BPMN Process        │
│  (Tickets DB)   │                   │  Gateway de Decisão  │
└─────────────────┘                   └──────────────────────┘
                                               │
                                    ┌──────────┴──────────┐
                                    │                     │
                               Ticket Simples      Ticket Complexo
                               (Técnico)           (Eng. Sénior)
```

---

## ✅ Funcionalidades

- **Abertura de tickets** com título, descrição e prioridade
- **Integração automática com Camunda Cloud** via API REST (Zeebe 8.9)
- **Gateway BPMN de decisão** — encaminha por prioridade (Simples / Complexo)
- **Base de dados MySQL** com registo de instâncias Camunda por ticket
- **Monitorização em tempo real** no Camunda Operate
- **Dashboard** com estatísticas de tickets
- Interface **totalmente responsiva** (mobile/tablet/desktop)

---

## Stack Tecnológica

| Camada | Tecnologia |
|---|---|
| Backend | Laravel 12 (PHP 8.3) |
| Frontend | Blade Templates + Inter (Google Fonts) |
| Base de Dados | MySQL 8 |
| BPM Engine | Camunda Cloud — Zeebe 8.9 |
| Processo | BPMN 2.0 com Exclusive Gateway |
| Monitorização | Camunda Operate |
| Túnel Público | ngrok |

---

## Processo BPMN

O processo modelado inclui:

1. **Start Event** — Ticket submetido via Laravel
2. **Exclusive Gateway** — Verifica prioridade do ticket
3. **Caminho Simples** → Atribuído directamente ao técnico de suporte
4. **Caminho Complexo** → Escalado automaticamente para Engenheiro Sénior
5. **End Event** — Processo concluído e registado

---

## Instalação Local

### Pré-requisitos
- PHP 8.3+
- Composer
- MySQL 8+
- Conta no [Camunda Cloud](https://camunda.io)

### Passos

```bash
# 1. Clonar o repositório
git clone https://github.com/SEU_USERNAME/ticketflow.git
cd ticketflow

# 2. Instalar dependências
composer install

# 3. Configurar ambiente
cp .env.example .env
php artisan key:generate

# 4. Configurar .env com as tuas credenciais
# DB_DATABASE, DB_USERNAME, DB_PASSWORD
# CAMUNDA_CLIENT_ID, CAMUNDA_CLIENT_SECRET, CAMUNDA_CLUSTER_ID

# 5. Migrar base de dados
php artisan migrate

# 6. Iniciar servidor
php artisan serve
```

### Variáveis de Ambiente necessárias

```env
DB_CONNECTION=mysql
DB_DATABASE=ticketflow
DB_USERNAME=root
DB_PASSWORD=

CAMUNDA_CLIENT_ID=your_client_id
CAMUNDA_CLIENT_SECRET=your_client_secret
CAMUNDA_CLUSTER_ID=your_cluster_id
CAMUNDA_REGION=bru-2
```

---

## 📁 Estrutura do Projecto

```
ticketflow/
├── app/
│   ├── Http/Controllers/
│   │   └── TicketController.php   # Lógica principal + chamada Camunda API
│   └── Models/
│       └── Ticket.php
├── resources/views/tickets/
│   ├── index.blade.php            # Dashboard de tickets
│   └── create.blade.php          # Formulário de criação
├── routes/
│   └── web.php                   # Rotas da aplicação
├── database/migrations/
│   └── create_tickets_table.php  # Schema da tabela
└── .env.example                  # Template de configuração
```

---

## Autor

**António Ambrósio** — Programador Full Stack
paigrandengola@gmail.com
+244 947 811 549

---

## 📄 Licença

Este projecto foi desenvolvido para fins de demonstração técnica.
