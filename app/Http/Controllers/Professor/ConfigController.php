<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Configuracao;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Exibe o formulário de edição das configurações (registro único).
     */
    public function edit()
    {
        $config = Configuracao::first();
        if (!$config) {
            $config = Configuracao::create([
                'pix' => '',
                'whatsapp' => '',
                'maps_src' => '',
                'email' => '',
            ]);
        }

        return view('professor.config.edit', compact('config'));
    }

    /**
     * Atualiza as configurações.
     */
    public function update(Request $request)
    {
        $dados = $request->validate([
            'pix' => ['nullable', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'maps_src' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
        ], [
            'email.email' => 'Informe um e-mail válido.',
        ]);

        $config = Configuracao::firstOrCreate(['id' => 1], [
            'pix' => '',
            'whatsapp' => '',
            'maps_src' => '',
            'email' => '',
        ]);

        $config->update($dados);

        return redirect()->route('professor.config.edit')->with('success', 'Configurações atualizadas com sucesso.');
    }
}
