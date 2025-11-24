<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Troubleshooting extends Model
{
    use HasFactory;

   protected $fillable = [
    'LAST_EDIT_USER',
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
        'details' => 'array', // 👈 transforma JSON em array automaticamente
    ];

    /**
     * Relacionamento: cada troubleshooting pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
