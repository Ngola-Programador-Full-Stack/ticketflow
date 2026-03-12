<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {
    protected $fillable = [
        'ticket_id', 'titulo', 'descricao', 'prioridade',
        'status', 'camunda_instance_id', 'responsavel', 'solucao',
        'cliente_id',
    ];

    public function cliente() {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
