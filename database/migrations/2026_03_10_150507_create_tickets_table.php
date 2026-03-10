<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id')->unique();
            $table->string('titulo');
            $table->text('descricao');
            $table->string('prioridade')->default('simples'); // simples | complexo
            $table->string('status')->default('aberto');
            $table->string('camunda_instance_id')->nullable();
            $table->string('responsavel')->nullable();
            $table->text('solucao')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('tickets');
    }
};
