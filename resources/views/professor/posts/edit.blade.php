@extends('layouts.app')

@section('title', 'Editar Post')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-end justify-between flex-wrap gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-bold text-white">Editar post</h1>
            <p class="text-sm text-gray-400 mt-1">{{ $post->titulo }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('professor.posts.update', $post) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('professor.posts._form')
    </form>
</div>
@endsection
