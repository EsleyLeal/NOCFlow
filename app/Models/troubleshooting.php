<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class troubleshooting extends Model
{
    protected $fillable = [
        'ticket_code',
        'client_name',
        'troubleshoot_type',
        'description',
        'endereco',
        'bairro',
        'complemento',
        'cidade',
        'grupo',
        'uf',
        'details',
        'steps',
    ];


}
