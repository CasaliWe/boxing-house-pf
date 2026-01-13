@extends('layouts.app')

@section('title', 'Meus Treinos')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-blue-400">🥊 Meus Treinos</h1>
            <p class="text-gray-400">Acompanhe suas aulas com foto, data e sequência aprendida.</p>
        </div>
        @if($proximaSequencia)
            <div class="px-4 py-3 rounded-lg border border-blue-600 bg-blue-800/30 text-blue-100">
                <span class="font-semibold">Próxima aula {{ $proximaNumero }}:</span>
                <span>{{ $proximaSequencia->descricao }}</span>
            </div>
        @endif
    </div>

    <div class="bg-gradient-card border border-gray-600 rounded-xl p-6">
        @if($treinos->isEmpty())
            <div class="text-center py-12 text-gray-300">Você ainda não possui treinos registrados.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl-grid-cols-3 xl:grid-cols-3 gap-6">
                @php $contadorPadrao = 0; @endphp
                @foreach($treinos as $treino)
                    <div class="border border-gray-600 rounded-lg p-5 bg-gray-800/40">
                        <div class="aspect-video mb-3 overflow-hidden rounded">
                            <img src="{{ asset('storage/'.$treino->foto_path) }}" alt="Foto do treino" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-400">Data</div>
                                <div class="text-white font-semibold">{{ $treino->data->format('d/m/Y') }}</div>
                            </div>
                            <div class="text-right">
                                @if($treino->especial)
                                    <span class="inline-block px-2 py-1 text-xs rounded bg-purple-700 text-purple-100">Aula especial</span>
                                @else
                                    @php $contadorPadrao++; @endphp
                                    <span class="inline-block px-2 py-1 text-xs rounded bg-green-700 text-green-100">Aula {{ $contadorPadrao }}</span>
                                @endif
                            </div>
                        </div>
                        @if(!$treino->especial)
                            @php $seq = \App\Models\AulaSequencia::where('numero', $contadorPadrao)->where('ativo', true)->first(); @endphp
                            <div class="mt-3">
                                <div class="text-sm text-gray-400">Sequência aprendida</div>
                                <div class="text-gray-200">{{ $seq?->descricao ?? 'Sequência não configurada' }}</div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
