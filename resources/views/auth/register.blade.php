@extends('layouts.auth')

@section('title', 'Criar Conta — TicketFlow · Selenium')
@section('subtitle', 'Registo no Sistema de Suporte BPM')

@section('form')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group">
        <label>Nome completo</label>
        <div class="input-wrap">
            <span class="input-icon"><i class="fas fa-user"></i></span>
            <input type="text" name="name" value="{{ old('name') }}"
                placeholder="António Ambrósio" required autofocus>
        </div>
    </div>

    <div class="form-group">
        <label>Endereço de email</label>
        <div class="input-wrap">
            <span class="input-icon"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" value="{{ old('email') }}"
                placeholder="exemplo@selenium.ao" required>
        </div>
    </div>

    <div class="form-group">
        <label>Password</label>
        <div class="input-wrap">
            <span class="input-icon"><i class="fas fa-lock"></i></span>
            <input type="password" name="password"
                placeholder="Mínimo 6 caracteres" required>
        </div>
    </div>

    <div class="form-group">
        <label>Confirmar password</label>
        <div class="input-wrap">
            <span class="input-icon"><i class="fas fa-lock-open"></i></span>
            <input type="password" name="password_confirmation"
                placeholder="Repete a password" required>
        </div>
    </div>

    <div class="form-group">
        <label style="color:#9ca3af;font-weight:500">
            Código de acesso
            <span style="font-size:0.75rem;font-weight:400"> — opcional, apenas para agentes</span>
        </label>
        <div class="input-wrap">
            <span class="input-icon"><i class="fas fa-key"></i></span>
            <input type="password" name="invite_code"
                placeholder="Deixa em branco se és cliente">
        </div>
    </div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-user-plus"></i>
        Criar conta
    </button>
</form>

<div class="auth-link">
    Já tem conta? <a href="{{ route('login') }}">Entrar</a>
</div>
@endsection
