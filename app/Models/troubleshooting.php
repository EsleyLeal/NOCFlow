<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Troubleshooting extends Model
{
    use HasFactory;

   protected $fillable = [
    'contrato',
    'nome',
    'cpe',
    'pe',
    'vlans',
    'designador',
    'onu',
    'prtg',
    'parceiro',
    'contato_parceiro',
    'porta',
    'sw_acesso',
    'publico',
    'avenida',
    'bairro',
    'complemento',
    'uf',
    'cidade',
    'steps',
    'user_id',
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
