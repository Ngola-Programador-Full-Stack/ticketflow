<?php
namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\CamundaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    private CamundaService $camunda;

    public function __construct(CamundaService $camunda)
    {
        $this->camunda = $camunda;
    }

    public function index()
    {
        $user = Auth::user();
        $tickets = $user->role === 'agente'
            ? Ticket::latest()->get()
            : Ticket::where('cliente_id', $user->id)->latest()->get();

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'     => 'required|string|max:255',
            'descricao'  => 'required|string',
            'prioridade' => 'required|in:simples,complexo',
        ]);

        $ticketId = 'TK-' . strtoupper(uniqid());

        try {
            $resultado = $this->camunda->iniciarProcesso([
                'ticketId'   => $ticketId,
                'titulo'     => $request->titulo,
                'descricao'  => $request->descricao,
                'simples'    => $request->prioridade === 'simples',
                'cliente'    => Auth::user()->name,
            ]);
        } catch (\Exception $e) {
            error_log('Camunda EXCEPTION: ' . $e->getMessage());
            $resultado = [];
        }

        Ticket::create([
            'ticket_id'           => $ticketId,
            'titulo'              => $request->titulo,
            'descricao'           => $request->descricao,
            'prioridade'          => $request->prioridade,
            'status'              => 'aberto',
            'cliente_id'          => Auth::id(),
            'camunda_instance_id' => $resultado['processInstanceKey'] ?? $resultado['key'] ?? null,
        ]);

        return redirect()->route('tickets.index')
            ->with('success', "Ticket {$ticketId} submetido! A equipa Selenium irá analisar em breve.");
    }

    public function resolver(Request $request, Ticket $ticket)
    {
        if (Auth::user()->role !== 'agente') {
            abort(403, 'Apenas agentes podem resolver tickets.');
        }

        $request->validate(['solucao' => 'required|string']);

        $ticket->update([
            'status'       => 'resolvido',
            'solucao'      => $request->solucao,
            'responsavel'  => Auth::user()->name,
        ]);

        return redirect()->route('tickets.index')
            ->with('success', "Ticket {$ticket->ticket_id} resolvido com sucesso!");
    }
}
