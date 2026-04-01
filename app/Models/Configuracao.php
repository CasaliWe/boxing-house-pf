<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    use HasFactory;

    protected $table = 'configuracoes';

    protected $fillable = [
        'pix',
        'whatsapp',
        'instagram',
        'cidade',
        'bairro',
        'rua',
        'numero',
        'maps_src',
        'email',
        'whatsapp_api_url',
        'whatsapp_api_token',
        'video_apresentacao',
    ];
}
