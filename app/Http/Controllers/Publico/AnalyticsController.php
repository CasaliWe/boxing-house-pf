<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvento;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function registrar(Request $request)
    {
        $dados = $request->validate([
            'tipo' => ['required', 'string', 'in:visita,clique_whatsapp,clique_login'],
            'nome' => ['required', 'string', 'max:100'],
        ]);

        $sessaoId = $request->cookie('bh_sessao');

        if (!$sessaoId) {
            $sessaoId = bin2hex(random_bytes(16));
        }

        AnalyticsEvento::create([
            'tipo'      => $dados['tipo'],
            'nome'      => $dados['nome'],
            'sessao_id' => $sessaoId,
        ]);

        return response()
            ->json(['ok' => true])
            ->cookie('bh_sessao', $sessaoId, 60 * 24 * 30); // 30 dias
    }
}
