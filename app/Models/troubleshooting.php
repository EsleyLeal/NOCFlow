<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Troubleshooting extends Model
{
    use HasFactory;

    protected $table = 'troubleshootings';

    protected $fillable = [
        'LAST_EDIT_USER_ID',
        'CONTRATO_NOVO',
        'NOME',
        'IP',
        'PE_RELACIONADO',
        'SW_RELACIONADO',
        'VLAN_GER',
        'VLAN_TRANS',
        'DESIGNADOR',
        'CIRCUITO',
        'PORTA',
        'ONU',
        'LINK_PRTG',
        'PARCEIRO',
        'CONTATO_PARCEIRO',
        'ENDERECO_NOVO',
        'ENDERECO_BAIRRO',
        'ENDERECO_COMPLEMENTO',
        'ENDERECO_CIDADE',
        'ENDERECO_UF',
        'CEP',
        'DETAILS',
        'STEPS',
        'COMPLETO',
        'RELATORIO',
        'MAPA',
        'CATEGORIA',
        'GRUPO',
        'NOTAS',
        'CONTRATO_ANTIGO',
        'COMUNIDADE_SNMP',
        'FABRICANTE',
        'FABRICANTE_INFO',
        'CODIGO_CLIENTE',
        'ENDERECO_ANTIGO',
        'VENDEDOR',
        'COD_PLANO',
        'PLANO',
        'ASSINATURA_DO_CONTRATO',
        'INICIO_DO_CONTRATO',
        'VALOR_DESCONTO',
        'VALOR_TOTAL',
        'TOTAL_PROMO',
        'LAST_EDIT_TIME',
    ];

    protected $casts = [
        'DETAILS' => 'array',
    ];

    /** RELACIONAMENTOS **/
    public function user()
    {
        return $this->belongsTo(User::class, 'LAST_EDIT_USER_ID');
    }

    /** ================
     *  ACCESSORS
     *  Permitem acessar os campos maiúsculos com nomes minúsculos
     *  ================ */

    public function getNomeAttribute()
    {
        return $this->attributes['NOME'] ?? null;
    }

    public function getEnderecoNovoAttribute()
    {
        return $this->attributes['ENDERECO_NOVO'] ?? null;
    }

    public function getEnderecoComplementoAttribute()
    {
        return $this->attributes['ENDERECO_COMPLEMENTO'] ?? null;
    }

    public function getEnderecoCidadeAttribute()
    {
        return $this->attributes['ENDERECO_CIDADE'] ?? null;
    }

    

    public function getEnderecoBairroAttribute()
    {
        return $this->attributes['ENDERECO_BAIRRO'] ?? null;
    }

    public function getEnderecoUfAttribute()
    {
        return $this->attributes['ENDERECO_UF'] ?? null;
    }
}
