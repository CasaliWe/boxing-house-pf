@extends('layouts.app')

@section('title', 'Novo Post')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Novo post</h1>
            <p class="text-sm text-gray-400 mt-1">Planeje o conteudo que vai para o Instagram</p>
        </div>
    </div>

    <form method="POST" action="{{ route('professor.posts.store') }}" enctype="multipart/form-data">
        @csrf
        @include('professor.posts._form')
    </form>
</div>
@endsection
