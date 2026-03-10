<?php
namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\CamundaService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    private CamundaService $camunda;

    public function __construct(CamundaService $camunda)
    {
        $this->camunda = $camunda;
    }

    public function index()
    {
        $tickets = Ticket::latest()->get();
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'    => 'required|string|max:255',
            'descricao' => 'required|string',
            'prioridade'=> 'required|in:simples,complexo',
        ]);

        $ticketId = 'TK-' . strtoupper(uniqid());

        // Iniciar processo no Camunda
        $resultado = $this->camunda->iniciarProcesso([
            'ticketId'  => $ticketId,
            'titulo'    => $request->titulo,
            'descricao' => $request->descricao,
            'simples'   => $request->prioridade === 'simples',
        ]);

        // Guardar na base de dados
        Ticket::create([
            'ticket_id'           => $ticketId,
            'titulo'              => $request->titulo,
            'descricao'           => $request->descricao,
            'prioridade'          => $request->prioridade,
            'status'              => 'em_processo',
            'camunda_instance_id' => $resultado['processInstanceKey']
                      ?? $resultado['key']
                      ?? null,
        ]);

        return redirect()->route('tickets.index')
            ->with('success', "Ticket {$ticketId} criado e processo BPM iniciado!");
    }
}
