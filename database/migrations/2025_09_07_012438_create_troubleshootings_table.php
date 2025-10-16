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

            // Relacionamento com o usuário que criou
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Campos principais
            $table->string('nome')->nullable();       // SIGLA
            $table->string('cpe')->nullable();       // cpe
            $table->string('pe')->nullable(); // Tipo de troubleshooting
            $table->string('designador')->nullable();       // Breve descrição
            $table->string('vlans')->nullable();
            $table->string('publico')->nullable();
            $table->string('parceiro')->nullable();
            $table->string('porta')->nullable();   // Governo, Matriz, Corporativo
            $table->string('prtg')->nullable();
            $table->string('avenida')->nullable();
            $table->string('bairro')->nullable();
            $table->string('complemento')->nullable();
            $table->string('uf', 2)->nullable();   // Ex: CE, SP, RJ
            $table->string('cidade')->nullable();

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
