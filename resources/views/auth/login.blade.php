@extends('layouts.auth')

@section('title', 'Entrar — TicketFlow · Selenium')
@section('subtitle', 'Acesso ao Sistema de Suporte BPM')

@section('form')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label>Endereço de email</label>
        <div class="input-wrap">
            <span class="input-icon"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email"
                value="{{ old('email') }}"
                placeholder="exemplo@selenium.ao"
                required autofocus>
        </div>
    </div>

    <div class="form-group">
        <label>Password</label>
        <div class="input-wrap">
            <span class="input-icon"><i class="fas fa-lock"></i></span>
            <input type="password" name="password"
                placeholder="••••••••"
                required>
        </div>
    </div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-right-to-bracket"></i>
        Entrar
    </button>
</form>

<div class="auth-link">
    Não tem conta? <a href="{{ route('register') }}">Criar conta</a>
</div>
@endsection
