@php
    /** @var \App\Models\Acesso $acesso */
@endphp

<div class="bg-gray-900/60 border border-gray-800 rounded-lg overflow-hidden">
    <div class="p-6 space-y-5">
        <div>
            <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Nome da plataforma</label>
            <input type="text" name="plataforma" value="{{ old('plataforma', $acesso->plataforma) }}" required maxlength="255"
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('plataforma')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">URL</label>
            <input type="text" name="url" value="{{ old('url', $acesso->url) }}" maxlength="255" placeholder="https://..."
                   class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('url')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Login</label>
                <input type="text" name="login" value="{{ old('login', $acesso->login) }}" maxlength="255"
                       class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('login')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wider font-semibold mb-1.5">Senha</label>
                <input type="text" name="senha" value="{{ old('senha', $acesso->senha) }}"
                       class="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('senha')<p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-2 px-6 py-4 border-t border-gray-800">
        <a href="{{ route('professor.acessos.index') }}"
           class="text-center text-sm font-medium px-4 py-2 rounded-md border border-gray-700 text-gray-300 hover:bg-gray-800 transition-colors">
            Cancelar
        </a>
        <button type="submit"
                style="background-color: #2563eb; color: #ffffff;"
                onmouseover="this.style.backgroundColor='#1d4ed8'"
                onmouseout="this.style.backgroundColor='#2563eb'"
                class="text-sm font-medium px-4 py-2 rounded-md transition-colors">
            Salvar
        </button>
    </div>
</div>
