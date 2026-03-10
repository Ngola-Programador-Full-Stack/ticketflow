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
    <title>Novo Ticket — TicketFlow · Selenium</title>
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
        .navbar-app { font-size: 0.95rem; font-weight: 700; color: #111; }

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

        /* ── PAGE LAYOUT ── */
        .page-wrap {
            max-width: 640px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 4rem;
        }

        .page-header {
            margin-bottom: 1.75rem;
        }
        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.4px;
        }
        .page-header p {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.35rem;
        }

        /* ── CARD ── */
        .card {
            background: #fff;
            border: 1.5px solid #e5e5e5;
            border-radius: 12px;
            overflow: hidden;
        }

        /* Barra de destaque no topo */
        .card-stripe {
            height: 4px;
            background: linear-gradient(90deg, #7c3aed, #9d4edd, #f97316);
        }

        .card-body { padding: 2rem; }

        /* ── INFO BOX ── */
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
        .info-box-text strong {
            display: block;
            font-size: 0.82rem;
            font-weight: 700;
            color: #5b21b6;
            margin-bottom: 0.1rem;
        }
        .info-box-text span {
            font-size: 0.78rem;
            color: #6b7280;
            line-height: 1.45;
        }

        /* ── FORM ── */
        .form-group { margin-bottom: 1.4rem; }

        label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            color: #111;
            margin-bottom: 0.45rem;
        }
        label .req { color: #f97316; margin-left: 2px; }

        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: #c4b5fd;
            font-size: 0.8rem;
            pointer-events: none;
        }
        .textarea-wrap .input-icon { top: 0.9rem; transform: none; }

        input[type="text"],
        textarea,
        select {
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
        input[type="text"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
        }
        input::placeholder, textarea::placeholder { color: #c0b8d8; }

        textarea { height: 120px; resize: vertical; padding-top: 0.8rem; }

        .select-wrap { position: relative; }
        .select-wrap::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: #c4b5fd;
            font-size: 0.65rem;
            pointer-events: none;
        }
        select { cursor: pointer; }

        /* Priority cards */
        .priority-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }
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
        .p-card input[value="simples"]:checked + .p-label {
            border-color: #16a34a;
            background: #f0fdf4;
        }
        .p-card input[value="complexo"]:checked + .p-label {
            border-color: #ea580c;
            background: #fff7ed;
        }
        .p-emoji { font-size: 1.3rem; margin-bottom: 0.4rem; display: block; }
        .p-title { font-size: 0.88rem; font-weight: 700; color: #111; display: block; }
        .p-desc { font-size: 0.73rem; color: #6b7280; margin-top: 0.15rem; display: block; line-height: 1.4; }

        /* ── DIVIDER ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.5rem 0;
        }
        .divider-line { flex: 1; height: 1px; background: #e5e5e5; }
        .divider-label { font-size: 0.72rem; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }

        /* ── SUBMIT ── */
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
        .btn-submit:active { transform: translateY(0); }

        /* ── RESPONSIVE ── */
        @media (max-width: 600px) {
            .page-wrap { padding: 1.5rem 1rem 3rem; }
            .card-body { padding: 1.5rem; }
            .priority-grid { grid-template-columns: 1fr; }
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
    <a href="{{ route('tickets.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Ver Tickets
    </a>
</nav>

<div class="page-wrap">

    <div class="page-header">
        <h1>Abrir Novo Ticket</h1>
        <p>O processo BPMN inicia automaticamente no Camunda Cloud após submissão.</p>
    </div>

    <div class="card">
        <div class="card-stripe"></div>
        <div class="card-body">

            <div class="info-box">
                <i class="fas fa-diagram-project"></i>
                <div class="info-box-text">
                    <strong>Integração Camunda Cloud activa</strong>
                    <span>Gateway BPMN encaminha por prioridade · Zeebe 8.9 · Monitorização no Camunda Operate</span>
                </div>
            </div>

            <form method="POST" action="{{ route('tickets.store') }}">
                @csrf

                <div class="form-group">
                    <label>Título do Problema <span class="req">*</span></label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="fas fa-heading"></i></span>
                        <input type="text" name="titulo"
                            placeholder="Ex: Sistema de pagamentos com erro"
                            value="{{ old('titulo') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Descrição Detalhada <span class="req">*</span></label>
                    <div class="input-wrap textarea-wrap">
                        <span class="input-icon"><i class="fas fa-align-left"></i></span>
                        <textarea name="descricao"
                            placeholder="Descreve o problema com o máximo de detalhe..."
                            required>{{ old('descricao') }}</textarea>
                    </div>
                </div>

                <div class="divider">
                    <div class="divider-line"></div>
                    <span class="divider-label">Prioridade</span>
                    <div class="divider-line"></div>
                </div>

                <div class="form-group">
                    <div class="priority-grid">
                        <div class="p-card">
                            <input type="radio" name="prioridade" id="p-simples" value="simples" checked>
                            <label class="p-label" for="p-simples">
                                <span class="p-emoji">🟢</span>
                                <span class="p-title">Simples</span>
                                <span class="p-desc">Resolução directa pelo técnico de suporte</span>
                            </label>
                        </div>
                        <div class="p-card">
                            <input type="radio" name="prioridade" id="p-complexo" value="complexo">
                            <label class="p-label" for="p-complexo">
                                <span class="p-emoji">🔴</span>
                                <span class="p-title">Complexo</span>
                                <span class="p-desc">Escalado para Engenheiro Sénior</span>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i>
                    Criar Ticket e Iniciar Processo BPM
                </button>

            </form>
        </div>
    </div>
</div>

</body>
</html>
