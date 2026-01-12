<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValorPlano extends Model
{
    use HasFactory;

    protected $table = 'valores';

    protected $fillable = [
        'vezes_semana',
        'valor',
    ];

    /**
     * Label amigável: "1x por semana".
     */
    public function getVezesLabelAttribute(): string
    {
        return $this->vezes_semana . 'x por semana';
    }
}
