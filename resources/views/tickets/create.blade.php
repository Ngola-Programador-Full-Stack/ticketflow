@extends('layouts.main')

@section('title', 'Novo Ticket — TicketFlow · Selenium')

@section('navbar-action')
    <a href="{{ route('tickets.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Ver Tickets
    </a>
@endsection

@section('content')
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
                                <span class="p-icon green"><i class="fas fa-circle-check"></i></span>
                                <span class="p-title">Simples</span>
                                <span class="p-desc">Resolução directa pelo técnico de suporte</span>
                            </label>
                        </div>
                        <div class="p-card">
                            <input type="radio" name="prioridade" id="p-complexo" value="complexo">
                            <label class="p-label" for="p-complexo">
                                <span class="p-icon red"><i class="fas fa-triangle-exclamation"></i></span>
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
@endsection
