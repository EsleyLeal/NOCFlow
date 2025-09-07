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
            $table->string('title');                 // "Interface down", "Routing loop"
            $table->string('description')->nullable();
            $table->text('steps')->nullable();       // um passo por linha ou markdown
            // (opcional) relacionar a fabricante/protocolo se quiser depois
            // $table->string('vendor')->nullable();
            // $table->string('protocol')->nullable();
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
