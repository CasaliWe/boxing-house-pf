@extends('layouts.app')

@section('title', 'Cadastro - Etapa 3')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-blue-400">✅ Cadastro - Etapa 3</h1>
        <p class="text-gray-400">Leia e aceite todas as regras para concluir.</p>
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        <form method="POST" action="{{ route('cadastro.step3.post') }}" class="space-y-6">
            @csrf

            <div class="space-y-4">
                @forelse($regras as $regra)
                    <label class="flex items-start gap-3 border border-gray-600 rounded-lg p-4 bg-gray-800/40 cursor-pointer hover:border-blue-500">
                        <input type="checkbox" name="regras[{{ $regra->id }}]" value="1" class="mt-1 rounded bg-gray-800 border-gray-600 text-blue-500" required>
                        <div>
                            <div class="text-white font-semibold">{{ $regra->titulo }}</div>
                            <div class="text-gray-300 whitespace-pre-line">{{ $regra->conteudo }}</div>
                        </div>
                    </label>
                @empty
                    <div class="text-gray-300">Nenhuma regra cadastrada. Volte depois.</div>
                @endforelse
            </div>

            <div class="flex justify-between">
                <a href="{{ route('cadastro.step2') }}" class="px-5 py-3 rounded-md border border-gray-600 text-gray-200 hover:bg-gray-700">Voltar</a>
                <button type="submit" class="px-5 py-3 rounded-md bg-blue-600 hover:bg-blue-700 text-white">Concluir</button>
            </div>
        </form>
    </div>
</div>
@endsection
