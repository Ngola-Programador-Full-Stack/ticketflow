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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #7c3aed 0%, #9d4edd 55%, #f97316 100%);
            padding: 1.5rem;
        }

        .auth-card {
            background: #fff;
            border-radius: 16px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 24px 64px rgba(0,0,0,0.25);
            overflow: hidden;
        }

        .auth-stripe {
            height: 4px;
            background: linear-gradient(90deg, #7c3aed, #9d4edd, #f97316);
        }

        .auth-body { padding: 2.5rem; }

        /* ── LOGO ── */
        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-logo img {
            height: 34px;
            display: block;
            margin: 0 auto 1rem;
        }
        .auth-logo-divider {
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, #7c3aed, #f97316);
            margin: 0.75rem auto;
            border-radius: 2px;
        }
        .auth-logo h1 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.3px;
        }
        .auth-logo p {
            font-size: 0.78rem;
            color: #9ca3af;
            margin-top: 0.25rem;
            font-weight: 500;
        }

        /* ── FORM ── */
        .form-group { margin-bottom: 1.25rem; }

        label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
        }

        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #c4b5fd;
            font-size: 0.8rem;
            pointer-events: none;
        }

        input[type=email],
        input[type=password],
        input[type=text] {
            width: 100%;
            padding: 0.75rem 0.9rem 0.75rem 2.4rem;
            border: 1.5px solid #e5e5e5;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: #111;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        input:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
        }
        input::placeholder { color: #d1d5db; }

        /* ── ERROR ── */
        .alert-error {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            color: #dc2626;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ── BUTTON ── */
        .btn-submit {
            width: 100%;
            padding: 0.85rem;
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
            gap: 0.5rem;
            margin-top: 0.5rem;
            transition: background-position 0.4s, transform 0.15s, box-shadow 0.15s;
        }
        .btn-submit:hover {
            background-position: right center;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(124,58,237,0.3);
        }

        /* ── LINK ── */
        .auth-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.82rem;
            color: #9ca3af;
        }
        .auth-link a {
            color: #7c3aed;
            font-weight: 700;
            text-decoration: none;
        }
        .auth-link a:hover { text-decoration: underline; }

        /* ── CAMUNDA BADGE ── */
        .camunda-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-top: 1.75rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f3f4f6;
            font-size: 0.72rem;
            color: #9ca3af;
            font-weight: 500;
        }
        .camunda-dot {
            width: 6px; height: 6px;
            background: #22c55e;
            border-radius: 50%;
            animation: blink 2s infinite;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="auth-stripe"></div>
    <div class="auth-body">

        <div class="auth-logo">
            <img src="{{ asset('images/selenium-logo.png') }}" alt="Selenium">
            <div class="auth-logo-divider"></div>
            <h1>TicketFlow</h1>
            <p>@yield('subtitle', 'Sistema de Suporte BPM · Selenium')</p>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-circle-exclamation"></i>
                {{ $errors->first() }}
            </div>
        @endif

        @yield('form')

        <div class="camunda-badge">
            <span class="camunda-dot"></span>
            Camunda Cloud · Zeebe 8.9 · Online
        </div>

    </div>
</div>

</body>
</html>
