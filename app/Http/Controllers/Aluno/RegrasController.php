<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use App\Models\Regra;

class RegrasController extends Controller
{
    public function index()
    {
        $regras = Regra::where('titulo', 'Regras')
            ->where('ativo', true)
            ->orderByRaw('COALESCE(ordem, 99999) ASC')
            ->get();

        return view('aluno.regras', compact('regras'));
    }
}
