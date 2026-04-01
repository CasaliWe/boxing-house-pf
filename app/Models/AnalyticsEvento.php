<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsEvento extends Model
{
    protected $table = 'analytics_eventos';

    protected $fillable = [
        'tipo',
        'nome',
        'sessao_id',
    ];
}
