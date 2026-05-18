<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Acesso;
use Illuminate\Http\Request;

class AcessoController extends Controller
{
    public function index()
    {
        $acessos = Acesso::orderBy('plataforma')->paginate(12);

        return view('professor.acessos.index', compact('acessos'));
    }

    public function create()
    {
        return view('professor.acessos.create', ['acesso' => new Acesso()]);
    }

    public function store(Request $request)
    {
        Acesso::create($this->validar($request));

        return redirect()->route('professor.acessos.index')
            ->with('success', 'Acesso criado com sucesso.');
    }

    public function edit(Acesso $acesso)
    {
        return view('professor.acessos.edit', compact('acesso'));
    }

    public function update(Request $request, Acesso $acesso)
    {
        $acesso->update($this->validar($request));

        return redirect()->route('professor.acessos.index')
            ->with('success', 'Acesso atualizado com sucesso.');
    }

    public function destroy(Acesso $acesso)
    {
        $acesso->delete();

        return redirect()->route('professor.acessos.index')
            ->with('success', 'Acesso excluido com sucesso.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'plataforma' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
            'login' => ['nullable', 'string', 'max:255'],
            'senha' => ['nullable', 'string'],
        ]);
    }
}
