@extends('layouts.app')

@section('title', 'Valores')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-blue-400">💰 Valores</h1>
            <p class="text-gray-400">Cadastre os valores por quantidade de treinos semanais.</p>
        </div>
        <a href="{{ route('professor.valores.create') }}" class="bg-gradient-blue text-white px-5 py-3 rounded-lg font-medium hover:opacity-95 transition">+ Novo Valor</a>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($valores->isEmpty())
            <div class="text-center py-12 text-gray-300">Nenhum valor cadastrado ainda.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($valores as $valor)
                    <div class="border border-gray-600 rounded-lg p-5 bg-gray-800/40">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-sm text-gray-400">{{ $valor->vezes_label }}</div>
                                <div class="text-2xl font-semibold text-white">R$ {{ number_format($valor->valor, 2, ',', '.') }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('professor.valores.edit', $valor) }}" class="px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm">Editar</a>
                                <form method="POST" action="{{ route('professor.valores.destroy', $valor) }}" onsubmit="return confirm('Tem certeza que deseja excluir este valor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
