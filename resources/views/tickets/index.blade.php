@extends('layouts.main')

@section('title', 'TicketFlow — SELENIUM')

@section('hero')
<div class="hero">
    <div class="hero-inner">
        @if(Auth::user()->role === 'agente')
        <div>
            <h1>Painel de Gestão — Selenium</h1>
            <p>Todos os tickets dos clientes · Camunda Cloud · Zeebe 8.9</p>
        </div>
        {{-- Agente não cria tickets --}}
        @else
        <div>
            <h1>Portal de Suporte Técnico</h1>
            <p>Submete um ticket e a nossa equipa trata do resto · Processo BPM automático</p>
        </div>
        <a href="{{ route('tickets.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Novo Ticket
        </a>
        @endif
    </div>
</div>
@endsection

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ── STATS ── --}}
    @if(Auth::user()->role === 'agente')
    <div class="stats">
        <div class="stat-card">
            <div class="stat-icon total"><i class="fas fa-layer-group"></i></div>
            <div>
                <div class="stat-number">{{ $tickets->count() }}</div>
                <div class="stat-label">Total de Tickets</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon complexo"><i class="fas fa-clock"></i></div>
            <div>
                <div class="stat-number">{{ $tickets->where('status','aberto')->count() }}</div>
                <div class="stat-label">Aguardam Resolução</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon simples"><i class="fas fa-circle-check"></i></div>
            <div>
                <div class="stat-number">{{ $tickets->where('status','resolvido')->count() }}</div>
                <div class="stat-label">Resolvidos</div>
            </div>
        </div>
    </div>
    @else
    <div class="stats">
        <div class="stat-card">
            <div class="stat-icon total"><i class="fas fa-ticket"></i></div>
            <div>
                <div class="stat-number">{{ $tickets->count() }}</div>
                <div class="stat-label">Os Meus Tickets</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon complexo"><i class="fas fa-spinner"></i></div>
            <div>
                <div class="stat-number">{{ $tickets->where('status','aberto')->count() }}</div>
                <div class="stat-label">Em Análise</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon simples"><i class="fas fa-circle-check"></i></div>
            <div>
                <div class="stat-number">{{ $tickets->where('status','resolvido')->count() }}</div>
                <div class="stat-label">Resolvidos</div>
            </div>
        </div>
    </div>
    @endif

    {{-- ── TABELA ── --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                @if(Auth::user()->role === 'agente')
                    <i class="fas fa-headset"></i> Fila de Suporte
                @else
                    <i class="fas fa-list-check"></i> Os Meus Tickets
                @endif
            </div>
            @if(Auth::user()->role === 'cliente')
            <a href="{{ route('tickets.create') }}" class="btn-sm">
                <i class="fas fa-plus"></i> Novo Ticket
            </a>
            @endif
        </div>

        @if($tickets->isEmpty())
            <div class="empty">
                <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                @if(Auth::user()->role === 'agente')
                    <p>Nenhum ticket pendente. Sistema operacional.</p>
                @else
                    <p>Nenhum ticket ainda. <a href="{{ route('tickets.create') }}">Submete o primeiro!</a></p>
                @endif
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
                        @if(Auth::user()->role === 'agente')
                            <th>Cliente</th>
                            <th>Responsável</th>
                            <th>Instância Camunda</th>
                        @endif
                        <th>Data</th>
                        @if(Auth::user()->role === 'agente')
                            <th>Acção</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr>
                        <td><span class="ticket-id">{{ $ticket->ticket_id }}</span></td>
                        <td><strong>{{ $ticket->titulo }}</strong></td>
                        <td><span class="badge badge-{{ $ticket->prioridade }}">{{ ucfirst($ticket->prioridade) }}</span></td>
                        <td><span class="badge badge-{{ $ticket->status }}">{{ str_replace('_',' ', $ticket->status) }}</span></td>

                        @if(Auth::user()->role === 'agente')
                        <td class="responsavel-cell">
                            @if($ticket->cliente)
                                <i class="fas fa-building" style="color:#c4b5fd;margin-right:4px"></i>{{ $ticket->cliente->name }}
                            @else
                                <span style="color:#d1d5db">—</span>
                            @endif
                        </td>
                        <td class="responsavel-cell">
                            @if($ticket->responsavel)
                                <i class="fas fa-user-shield" style="color:#86efac;margin-right:4px"></i>{{ $ticket->responsavel }}
                            @else
                                <span style="color:#fbbf24;font-size:0.78rem"><i class="fas fa-clock"></i> Pendente</span>
                            @endif
                        </td>
                        <td><span class="instance-id">{{ $ticket->camunda_instance_id ?? 'N/A' }}</span></td>
                        @endif

                        <td class="date-cell">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>

                        @if(Auth::user()->role === 'agente')
                        <td>
                            @if($ticket->status !== 'resolvido')
                                <button class="btn-sm success"
                                    onclick="abrirModal('{{ $ticket->id }}', '{{ addslashes($ticket->ticket_id) }}', '{{ addslashes($ticket->titulo) }}')">
                                    <i class="fas fa-check"></i> Resolver
                                </button>
                            @else
                                <span style="font-size:0.78rem;color:#16a34a;font-weight:600">
                                    <i class="fas fa-circle-check"></i> Resolvido
                                </span>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

{{-- MODAL RESOLVER (apenas agente) --}}
@if(Auth::user()->role === 'agente')
<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <h3><i class="fas fa-check-circle" style="color:#16a34a;margin-right:6px"></i> Resolver Ticket</h3>
        <p id="modalSubtitle">Descreve a solução aplicada para fechar o processo BPM.</p>
        <form id="modalForm" method="POST">
            @csrf
            <textarea name="solucao" placeholder="Descreve o que foi feito para resolver o problema..." required></textarea>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="fecharModal()">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="submit" class="btn-sm success">
                    <i class="fas fa-check"></i> Confirmar Resolução
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection

@push('scripts')
@if(Auth::user()->role === 'agente')
<script>
function abrirModal(id, ticketId, titulo) {
    document.getElementById('modalSubtitle').textContent = ticketId + ' · ' + titulo;
    document.getElementById('modalForm').action = '/tickets/' + id + '/resolver';
    document.getElementById('modalOverlay').classList.add('open');
}
function fecharModal() {
    document.getElementById('modalOverlay').classList.remove('open');
}
document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) fecharModal();
});
</script>
@endif
@endpush
