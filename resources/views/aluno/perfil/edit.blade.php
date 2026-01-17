@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-semibold text-blue-400 mb-4">👤 Meu Perfil</h1>
    @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-700 text-white rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
        <form method="POST" action="{{ route('aluno.perfil.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-300 text-sm">Nome</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white" required>
                </div>
                <div>
                    <label class="text-gray-300 text-sm">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Instagram</label>
                    <input type="text" name="instagram" value="{{ old('instagram', $user->instagram) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Endereço</label>
                    <input type="text" name="endereco" value="{{ old('endereco', $user->endereco) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Contato de Emergência (Nome)</label>
                    <input type="text" name="contato_emergencia_nome" value="{{ old('contato_emergencia_nome', $user->contato_emergencia_nome) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Contato de Emergência (WhatsApp)</label>
                    <input type="text" name="contato_emergencia_whatsapp" value="{{ old('contato_emergencia_whatsapp', $user->contato_emergencia_whatsapp) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" value="{{ old('data_nascimento', $user->data_nascimento) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Idade</label>
                    <input type="number" name="idade" value="{{ old('idade', $user->idade) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Peso</label>
                    <input type="number" step="0.01" name="peso" value="{{ old('peso', $user->peso) }}" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-gray-300 text-sm">Nova senha</label>
                    <input type="password" name="password" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
                <div>
                    <label class="text-gray-300 text-sm">Confirmar senha</label>
                    <input type="password" name="password_confirmation" class="mt-1 w-full bg-gray-900 border border-gray-700 rounded p-2 text-white">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Salvar alterações</button>
            </div>
        </form>
    </div>
</div>
@endsection
