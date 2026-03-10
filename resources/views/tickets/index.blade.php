<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>TicketFlow — SELENIUM</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f5f7;
            color: #111;
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: #fff;
            border-bottom: 2px solid #e5e5e5;
            padding: 0 2rem;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-brand img { height: 32px; display: block; }

        .navbar-divider { width: 1px; height: 28px; background: #ddd; }

        .navbar-app {
            font-size: 0.95rem;
            font-weight: 700;
            color: #111;
        }

        .live-badge {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            background: #f0fdf4;
            border: 1.5px solid #86efac;
            border-radius: 99px;
            padding: 0.3rem 0.85rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #15803d;
        }
        .live-dot {
            width: 7px; height: 7px;
            background: #22c55e;
            border-radius: 50%;
            animation: blink 2s infinite;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        /* ── HERO ── */
        .hero {
            background: linear-gradient(135deg, #7c3aed 0%, #9d4edd 55%, #f97316 100%);
            padding: 2.5rem 2rem;
        }
        .hero-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .hero h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.4px;
        }
        .hero p {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.85);
            margin-top: 0.3rem;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #fff;
            color: #7c3aed;
            padding: 0.75rem 1.6rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
            transition: opacity 0.15s, transform 0.15s;
        }
        .btn-primary:hover { opacity: 0.92; transform: translateY(-1px); }

        /* ── CONTAINER ── */
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem 2rem 4rem;
        }

        /* ── ALERT ── */
        .alert-success {
            background: #f0fdf4;
            border: 1.5px solid #86efac;
            color: #15803d;
            padding: 0.9rem 1.2rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ── STATS ── */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background: #fff;
            border: 1.5px solid #e5e5e5;
            border-radius: 10px;
            padding: 1.4rem 1.6rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .stat-icon.total    { background: #ede9fe; color: #7c3aed; }
        .stat-icon.simples  { background: #dcfce7; color: #16a34a; }
        .stat-icon.complexo { background: #ffedd5; color: #ea580c; }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #111;
            line-height: 1;
            letter-spacing: -1px;
        }
        .stat-label {
            font-size: 0.78rem;
            color: #6b7280;
            margin-top: 0.2rem;
            font-weight: 500;
        }

        /* ── CARD / TABLE ── */
        .card {
            background: #fff;
            border: 1.5px solid #e5e5e5;
            border-radius: 12px;
            overflow: hidden;
        }
        .card-header {
            padding: 1.2rem 1.6rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1.5px solid #e5e5e5;
            background: #fafafa;
        }
        .card-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #111;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .card-title i { color: #7c3aed; }

        .btn-sm {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #7c3aed;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 7px;
            font-weight: 600;
            font-size: 0.82rem;
            text-decoration: none;
            transition: background 0.15s;
        }
        .btn-sm:hover { background: #6d28d9; }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 580px;
        }
        th {
            background: #fafafa;
            padding: 0.8rem 1.4rem;
            text-align: left;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #9ca3af;
            font-weight: 600;
            border-bottom: 1.5px solid #e5e5e5;
        }
        td {
            padding: 0.95rem 1.4rem;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.875rem;
            vertical-align: middle;
            color: #111;
        }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #fafafa; }

        .ticket-id {
            font-weight: 700;
            color: #7c3aed;
            font-size: 0.8rem;
            font-family: 'Courier New', monospace;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.28rem 0.7rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-simples  { background: #dcfce7; color: #15803d; }
        .badge-complexo { background: #ffedd5; color: #c2410c; }
        .badge-status   { background: #ede9fe; color: #6d28d9; }

        .instance-id {
            font-size: 0.72rem;
            color: #9ca3af;
            font-family: 'Courier New', monospace;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }
        .date-cell { color: #6b7280; font-size: 0.8rem; }

        /* ── EMPTY ── */
        .empty {
            text-align: center;
            padding: 3.5rem 2rem;
            color: #6b7280;
        }
        .empty-icon { font-size: 2rem; color: #d1d5db; margin-bottom: 0.75rem; }
        .empty p { font-size: 0.9rem; }
        .empty a { color: #7c3aed; font-weight: 600; text-decoration: none; }
        .empty a:hover { text-decoration: underline; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .hero-inner { flex-direction: column; align-items: flex-start; }
            .btn-primary { width: 100%; justify-content: center; }
            .stats { grid-template-columns: 1fr; }
            .card-header { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
            .container { padding: 1.25rem 1rem 3rem; }
            .hero { padding: 1.75rem 1rem; }
            .navbar { padding: 0 1rem; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-brand">
        <img src="{{ asset('images/selenium-logo.png') }}" alt="Selenium">
        <div class="navbar-divider"></div>
        <span class="navbar-app">
            <i class="fas fa-ticket-alt" style="color:#7c3aed;margin-right:6px"></i>TicketFlow
        </span>
    </div>
    <div class="live-badge">
        <span class="live-dot"></span> Camunda Cloud · Online
    </div>
</nav>

<div class="hero">
    <div class="hero-inner">
        <div>
            <h1>Sistema de Suporte BPM</h1>
            <p>Processos automáticos via Camunda Cloud · Zeebe 8.9 · Gateway por prioridade</p>
        </div>
        <a href="{{ route('tickets.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Novo Ticket
        </a>
    </div>
</div>

<div class="container">

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="stats">
        <div class="stat-card">
            <div class="stat-icon total"><i class="fas fa-layer-group"></i></div>
            <div>
                <div class="stat-number">{{ $tickets->count() }}</div>
                <div class="stat-label">Total de Tickets</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon simples"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-number">{{ $tickets->where('prioridade','simples')->count() }}</div>
                <div class="stat-label">Tickets Simples</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon complexo"><i class="fas fa-fire"></i></div>
            <div>
                <div class="stat-number">{{ $tickets->where('prioridade','complexo')->count() }}</div>
                <div class="stat-label">Tickets Complexos</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-list-check"></i> Tickets Registados
            </div>
            <a href="{{ route('tickets.create') }}" class="btn-sm">
                <i class="fas fa-plus"></i> Novo Ticket
            </a>
        </div>

        @if($tickets->isEmpty())
            <div class="empty">
                <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                <p>Nenhum ticket ainda. <a href="{{ route('tickets.create') }}">Cria o primeiro!</a></p>
            </div>
        @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Prioridade</th>
                        <th>Status</th>
                        <th>Instância Camunda</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr>
                        <td><span class="ticket-id">{{ $ticket->ticket_id }}</span></td>
                        <td><strong>{{ $ticket->titulo }}</strong></td>
                        <td><span class="badge badge-{{ $ticket->prioridade }}">{{ ucfirst($ticket->prioridade) }}</span></td>
                        <td><span class="badge badge-status">{{ $ticket->status }}</span></td>
                        <td><span class="instance-id">{{ $ticket->camunda_instance_id ?? 'N/A' }}</span></td>
                        <td class="date-cell">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
</body>
</html>
