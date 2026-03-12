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
    <title>@yield('title', 'TicketFlow — SELENIUM')</title>
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
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
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
        .user-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f5f3ff;
            border: 1.5px solid #ddd6fe;
            border-radius: 99px;
            padding: 0.3rem 0.85rem 0.3rem 0.5rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: #5b21b6;
        }
        .user-avatar {
            width: 26px; height: 26px;
            background: linear-gradient(135deg, #7c3aed, #ea580c);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.68rem;
            font-weight: 700;
            flex-shrink: 0;
        }
        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #fff1f2;
            border: 1.5px solid #fecdd3;
            color: #be123c;
            padding: 0.35rem 0.85rem;
            border-radius: 7px;
            font-weight: 600;
            font-size: 0.78rem;
            cursor: pointer;
            transition: background 0.15s;
            text-decoration: none;
        }
        .btn-logout:hover { background: #ffe4e6; }

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

        /* ── BACK LINK ── */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #7c3aed;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.4rem 0.85rem;
            border-radius: 7px;
            background: #ede9fe;
            transition: background 0.15s;
        }
        .back-link:hover { background: #ddd6fe; }

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
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .stat-icon.total    { background: #ede9fe; color: #7c3aed; }
        .stat-icon.simples  { background: #dcfce7; color: #16a34a; }
        .stat-icon.complexo { background: #ffedd5; color: #ea580c; }
        .stat-number { font-size: 2rem; font-weight: 800; color: #111; line-height: 1; letter-spacing: -1px; }
        .stat-label  { font-size: 0.78rem; color: #6b7280; margin-top: 0.2rem; font-weight: 500; }

        /* ── CARD ── */
        .card {
            background: #fff;
            border: 1.5px solid #e5e5e5;
            border-radius: 12px;
            overflow: hidden;
        }
        .card-stripe { height: 4px; background: linear-gradient(90deg, #7c3aed, #9d4edd, #f97316); }
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
        .card-body { padding: 2rem; }

        /* ── BUTTONS ── */
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
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-sm:hover { background: #6d28d9; }
        .btn-sm.success { background: #16a34a; }
        .btn-sm.success:hover { background: #15803d; }

        /* ── TABLE ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 700px; }
        th {
            background: #fafafa;
            padding: 0.8rem 1.2rem;
            text-align: left;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #9ca3af;
            font-weight: 600;
            border-bottom: 1.5px solid #e5e5e5;
        }
        td {
            padding: 0.9rem 1.2rem;
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
            font-size: 0.78rem;
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
        .badge-simples   { background: #dcfce7; color: #15803d; }
        .badge-complexo  { background: #ffedd5; color: #c2410c; }
        .badge-em_processo { background: #ede9fe; color: #6d28d9; }
        .badge-resolvido { background: #dcfce7; color: #15803d; }

        .instance-id {
            font-size: 0.72rem;
            color: #9ca3af;
            font-family: 'Courier New', monospace;
            max-width: 160px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }
        .date-cell { color: #6b7280; font-size: 0.8rem; }
        .responsavel-cell { font-size: 0.8rem; color: #374151; font-weight: 500; }

        /* ── MODAL RESOLVER ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: #fff;
            border-radius: 14px;
            padding: 2rem;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 24px 64px rgba(0,0,0,0.2);
        }
        .modal h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.4rem; }
        .modal p  { font-size: 0.82rem; color: #6b7280; margin-bottom: 1.2rem; }
        .modal textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1.5px solid #e5e5e5;
            border-radius: 8px;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            resize: vertical;
            height: 110px;
            outline: none;
        }
        .modal textarea:focus { border-color: #7c3aed; }
        .modal-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
            justify-content: flex-end;
        }
        .btn-cancel {
            background: #f3f4f6;
            color: #374151;
            border: none;
            padding: 0.6rem 1.1rem;
            border-radius: 7px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
        }

        /* ── FORM (create) ── */
        .page-wrap { max-width: 640px; margin: 0 auto; padding: 2.5rem 1.5rem 4rem; }
        .page-header { margin-bottom: 1.75rem; }
        .page-header h1 { font-size: 1.5rem; font-weight: 800; color: #111; letter-spacing: -0.4px; }
        .page-header p  { font-size: 0.875rem; color: #6b7280; margin-top: 0.35rem; }

        .info-box {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            background: #f5f3ff;
            border: 1.5px solid #ddd6fe;
            border-radius: 8px;
            padding: 0.9rem 1rem;
            margin-bottom: 1.75rem;
        }
        .info-box i { color: #7c3aed; margin-top: 2px; flex-shrink: 0; }
        .info-box-text strong { display: block; font-size: 0.82rem; font-weight: 700; color: #5b21b6; margin-bottom: 0.1rem; }
        .info-box-text span   { font-size: 0.78rem; color: #6b7280; line-height: 1.45; }

        .form-group { margin-bottom: 1.4rem; }
        label { display: block; font-weight: 600; font-size: 0.85rem; color: #111; margin-bottom: 0.45rem; }
        label .req { color: #f97316; margin-left: 2px; }

        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 0.9rem; top: 50%;
            transform: translateY(-50%);
            color: #c4b5fd; font-size: 0.8rem; pointer-events: none;
        }
        .textarea-wrap .input-icon { top: 0.9rem; transform: none; }

        input[type="text"], textarea, select {
            width: 100%;
            padding: 0.8rem 0.9rem 0.8rem 2.5rem;
            border: 1.5px solid #e5e5e5;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: #111;
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
            -webkit-appearance: none;
        }
        input[type="text"]:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
        }
        input::placeholder, textarea::placeholder { color: #c0b8d8; }
        textarea { height: 120px; resize: vertical; padding-top: 0.8rem; }

        .divider { display: flex; align-items: center; gap: 0.75rem; margin: 1.5rem 0; }
        .divider-line { flex: 1; height: 1px; background: #e5e5e5; }
        .divider-label { font-size: 0.72rem; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }

        .priority-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
        .p-card { position: relative; cursor: pointer; }
        .p-card input[type="radio"] { position: absolute; opacity: 0; width: 0; }
        .p-label {
            display: block;
            border: 2px solid #e5e5e5;
            border-radius: 10px;
            padding: 1rem;
            cursor: pointer;
            background: #fafafa;
            transition: border-color 0.15s, background 0.15s;
        }
        .p-label:hover { border-color: #c4b5fd; background: #faf5ff; }
        .p-card input[value="simples"]:checked  + .p-label { border-color: #16a34a; background: #f0fdf4; }
        .p-card input[value="complexo"]:checked + .p-label { border-color: #ea580c; background: #fff7ed; }
        .p-icon  { font-size: 1.1rem; margin-bottom: 0.4rem; display: block; }
        .p-icon.green  { color: #16a34a; }
        .p-icon.red    { color: #ea580c; }
        .p-title { font-size: 0.88rem; font-weight: 700; color: #111; display: block; }
        .p-desc  { font-size: 0.73rem; color: #6b7280; margin-top: 0.15rem; display: block; line-height: 1.4; }

        .btn-submit {
            width: 100%;
            padding: 0.95rem;
            background: linear-gradient(135deg, #7c3aed, #9d4edd 50%, #f97316);
            background-size: 200% auto;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            margin-top: 0.25rem;
            transition: background-position 0.4s, transform 0.15s, box-shadow 0.15s;
        }
        .btn-submit:hover {
            background-position: right center;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(124,58,237,0.28);
        }

        /* ── EMPTY ── */
        .empty { text-align: center; padding: 3.5rem 2rem; color: #6b7280; }
        .empty-icon { font-size: 2rem; color: #d1d5db; margin-bottom: 0.75rem; }
        .empty p { font-size: 0.9rem; }
        .empty a { color: #7c3aed; font-weight: 600; text-decoration: none; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .hero-inner { flex-direction: column; align-items: flex-start; }
            .btn-primary { width: 100%; justify-content: center; }
            .stats { grid-template-columns: 1fr; }
            .card-header { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
            .container { padding: 1.25rem 1rem 3rem; }
            .hero { padding: 1.75rem 1rem; }
            .navbar { padding: 0 1rem; height: auto; min-height: 68px; flex-wrap: wrap; gap: 0.5rem; padding: 0.75rem 1rem; }
            .navbar-right { flex-wrap: wrap; gap: 0.5rem; }
            .page-wrap { padding: 1.5rem 1rem 3rem; }
            .card-body { padding: 1.5rem; }
            .priority-grid { grid-template-columns: 1fr; }
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
    <div class="navbar-right">
        <div class="live-badge">
            <span class="live-dot"></span> Camunda Cloud · Online
        </div>
        @auth
        <div class="user-pill">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            {{ auth()->user()->name }}
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-right-from-bracket"></i> Sair
            </button>
        </form>
        @endauth
        @yield('navbar-action')
    </div>
</nav>

@yield('hero')

@yield('content')

@stack('scripts')

</body>
</html>
