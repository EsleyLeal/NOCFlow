<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('troubleshootings', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->nullable();       // Código do chamado
            $table->string('client_name')->nullable();       // Nome do cliente
            $table->string('troubleshoot_type')->nullable(); // Tipo de troubleshooting
            $table->string('description')->nullable();       // Breve descrição

            // === Novos campos fixos ===
            $table->string('endereco')->nullable();
            $table->string('bairro')->nullable();
            $table->string('complemento')->nullable();
            $table->string('cidade')->nullable();
            $table->string('grupo')->nullable();   // Governo, Matriz, Corporativo
            $table->string('uf', 2)->nullable();   // Ex: CE, SP, RJ

            // Dinâmicos e passos
            $table->json('details')->nullable();  // JSON dos detalhes adicionais
            $table->text('steps')->nullable();    // Passos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('troubleshootings');
    }
};
