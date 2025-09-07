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
        Schema::create('commands', function (Blueprint $table) {
            $table->id();
            $table->string('vendor');             // Cisco, Huawei, Datacom...
            $table->string('protocol')->nullable(); // BGP, OSPF, MPLS...
            $table->string('task')->nullable();     // "Verificar BGP" etc.
            $table->text('command');                // "show ip bgp"
            $table->text('description')->nullable();
            $table->boolean('pinned')->default(false);
            $table->boolean('favorite')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commands');
    }
};
