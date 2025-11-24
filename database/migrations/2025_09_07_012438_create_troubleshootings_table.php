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

            // Usuário que editou por último (FK)
            $table->foreignId('LAST_EDIT_USER_ID')
                ->constrained('users')
                ->onDelete('cascade');

            // Campos gerais
            $table->timestamp('LAST_EDIT_TIME')->nullable();

            $table->string('SNMP')->nullable();
            $table->string('ICMP')->nullable();

            $table->boolean('COMPLETO')->nullable();
            $table->boolean('RELATORIO')->nullable();
            $table->boolean('MAPA')->nullable();

            $table->string('CATEGORIA')->nullable();
            $table->string('GRUPO')->nullable();

            // Identificação
            $table->string('IP')->nullable();
            $table->string('NOME')->nullable();
            $table->string('SIGLA')->nullable();

            // Infraestrutura relacionada
            $table->string('PE_RELACIONADO')->nullable();
            $table->string('SW_RELACIONADO')->nullable();

            $table->string('VLAN_GER')->nullable();
            $table->string('VLAN_TRANS')->nullable();

            $table->text('NOTAS')->nullable();

            // Equipamentos e links
            $table->string('DESIGNADOR')->nullable();
            $table->string('CIRCUITO')->nullable();
            $table->string('ONU')->nullable();
            $table->string('LINK_PRTG')->nullable();
            $table->string('PORTA')->nullable();

            // Parceiros
            $table->string('PARCEIRO')->nullable();
            $table->string('CONTATO_PARCEIRO')->nullable();

            // Contratos
            $table->string('CONTRATO_ANTIGO')->nullable();
            $table->string('CONTRATO_NOVO')->nullable();

            // SNMP extra
            $table->string('COMUNIDADE_SNMP')->nullable();

            // Fabricante
            $table->string('FABRICANTE')->nullable();
            $table->string('FABRICANTE_INFO')->nullable();

            // Cliente
            $table->string('CODIGO_CLIENTE')->nullable();

            // Endereço
            $table->string('ENDERECO_ANTIGO')->nullable();
            $table->string('ENDERECO_NOVO')->nullable();
            $table->string('ENDERECO_NUM')->nullable();
            $table->string('ENDERECO_BAIRRO')->nullable();
            $table->string('ENDERECO_COMPLEMENTO')->nullable();
            $table->string('ENDERECO_CIDADE')->nullable();
            $table->string('ENDERECO_UF', 2)->nullable();
            $table->string('CEP')->nullable();

            // Comercial
            $table->string('VENDEDOR')->nullable();
            $table->string('COD_PLANO')->nullable();
            $table->string('PLANO')->nullable();

            $table->date('ASSINATURA_DO_CONTRATO')->nullable();
            $table->date('INICIO_DO_CONTRATO')->nullable();

            $table->decimal('VALOR_DESCONTO', 10, 2)->nullable();
            $table->decimal('VALOR_TOTAL', 10, 2)->nullable();
            $table->decimal('TOTAL_PROMO', 10, 2)->nullable();

            // Extras herdados do modelo anterior
            $table->json('DETAILS')->nullable();
            $table->text('STEPS')->nullable();

            $table->timestamps(); // created_at / updated_at
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
