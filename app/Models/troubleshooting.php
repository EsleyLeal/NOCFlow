<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Troubleshooting extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpe',
        'pe',
        'designador',
        'vlans',
        'publico',
        'parceiro',
        'porta',
        'prtg',
        'avenida',
        'bairro',
        'complemento',
        'uf',
        'cidade',
        'steps',
        'user_id', // adiciona o vínculo com o dono
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
