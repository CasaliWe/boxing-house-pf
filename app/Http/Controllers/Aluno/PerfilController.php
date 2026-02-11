<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('aluno.perfil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'contato_emergencia_nome' => ['nullable', 'string', 'max:255'],
            'contato_emergencia_whatsapp' => ['nullable', 'string', 'max:255'],
            'data_nascimento' => ['nullable', 'date'],
            'idade' => ['nullable', 'integer', 'min:1', 'max:120'],
            'peso' => ['nullable', 'numeric', 'min:0'],
            'objetivos' => ['nullable', 'array'],
            'objetivos.*' => ['string', 'in:Perder peso,Condicionamento físico,Parte técnica,Diversão,Competir'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        // Atualiza campos principais
        $user->name = $data['name'];
        $user->whatsapp = $data['whatsapp'] ?? $user->whatsapp;
        $user->instagram = $data['instagram'] ?? $user->instagram;
        $user->endereco = $data['endereco'] ?? $user->endereco;
        $user->contato_emergencia_nome = $data['contato_emergencia_nome'] ?? $user->contato_emergencia_nome;
        $user->contato_emergencia_whatsapp = $data['contato_emergencia_whatsapp'] ?? $user->contato_emergencia_whatsapp;
        $user->data_nascimento = $data['data_nascimento'] ?? $user->data_nascimento;
        $user->idade = $data['idade'] ?? $user->idade;
        $user->peso = isset($data['peso']) ? number_format((float)$data['peso'], 2, '.', '') : $user->peso;
        $user->objetivos = array_values(array_unique($data['objetivos'] ?? []));

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('success', 'Perfil atualizado com sucesso.');
    }
}
