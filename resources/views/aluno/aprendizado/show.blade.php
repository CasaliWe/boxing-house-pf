@extends('layouts.app')

@section('title', $modulo->titulo)

@section('content')
<div class="aprendizado-modulo">
    <header class="mod-header">
        <a href="{{ route('aluno.aprendizado.index') }}" class="back-btn">← Voltar</a>

        <div class="title-row">
            <h1 class="mod-title">{{ $modulo->titulo }}</h1>
            <div class="meta">
                <span class="badge">{{ $modulo->categoria->nome ?? 'Módulo' }}</span>
                <span class="divider">•</span>
                <span class="videos-count">{{ $modulo->videos->count() }} vídeo{{ $modulo->videos->count() != 1 ? 's' : '' }}</span>
            </div>
        </div>

        @if(!empty($modulo->descricao))
            <p class="mod-desc">{{ $modulo->descricao }}</p>
        @endif
    </header>

    <section class="videos-grid">
        @foreach($modulo->videos as $video)
            @php
                // Usar mesma lógica da área professor para thumbnail
                $thumbnailUrl = null;
                
                // Se tem arquivo de vídeo, gera thumbnail do próprio vídeo
                if (!empty($video->arquivo_path)) {
                    $videoPath = asset($video->arquivo_path);
                    $thumbnailUrl = $videoPath; // Usaremos o próprio vídeo como preview
                }
                // Fallback para capa/thumbnail
                elseif (!empty($video->thumbnail_url)) {
                    $thumbnailUrl = $video->thumbnail_url;
                } elseif (!empty($video->capa)) {
                    $thumbnailUrl = \Illuminate\Support\Facades\Storage::url($video->capa);
                }
            @endphp

            <article class="video-card">
                <a href="{{ route('aluno.aprendizado.video', [$modulo->id, $video->id]) }}" class="thumb-wrap">
                    @if($thumbnailUrl && !empty($video->arquivo_path))
                        {{-- Preview do vídeo igual área professor --}}
                        <video preload="metadata" muted>
                            <source src="{{ asset($video->arquivo_path) }}" type="video/mp4">
                        </video>
                    @elseif($thumbnailUrl)
                        <img src="{{ $thumbnailUrl }}" alt="{{ $video->titulo }}" loading="lazy">
                    @else
                        <div class="video-placeholder">
                            <span class="placeholder-text">{{ $video->titulo }}</span>
                        </div>
                    @endif
                    <span class="play">▶ Assistir</span>
                </a>
                <div class="video-info">
                    <h3 class="video-title">{{ $video->titulo }}</h3>
                    @if(!empty($video->descricao))
                        <p class="video-desc">{{ \Illuminate\Support\Str::limit($video->descricao, 120) }}</p>
                    @endif
                </div>
            </article>
        @endforeach
    </section>
</div>

<style>
/* Escopo apenas desta página */
.aprendizado-modulo { max-width: 1100px; margin: 0 auto; padding: 24px; }
.mod-header { display: flex; flex-direction: column; gap: 12px; }
.back-btn { display: inline-flex; align-items: center; gap: 6px; color: #9aa4af; text-decoration: none; font-weight: 600; }
.back-btn:hover { color: #ffffff; }

.title-row { display: flex; align-items: flex-end; gap: 16px; flex-wrap: wrap; }
.mod-title { margin: 0; font-size: 28px; font-weight: 700; color: #ffffff; }
.meta { display: flex; align-items: center; gap: 8px; color: #cbd5e1; }
.badge { background: #1f2733; border: 1px solid #2b3442; color: #cbd5e1; padding: 4px 10px; border-radius: 999px; font-size: 13px; }
.divider { opacity: 0.6; }
.mod-desc { color: #cbd5e1; line-height: 1.5; margin: 6px 0 0; }

.videos-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-top: 20px; }
.video-card { background: #12161e; border: 1px solid #1f2530; border-radius: 10px; overflow: hidden; display: flex; flex-direction: column; }
.thumb-wrap { position: relative; aspect-ratio: 9/16; background: #0e1218; }
.thumb-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
.thumb-wrap video { width: 100%; height: 100%; object-fit: cover; display: block; }
.play { position: absolute; right: 10px; bottom: 10px; background: #e11d48; color: #fff; padding: 6px 10px; border-radius: 999px; font-size: 12px; box-shadow: 0 6px 18px rgba(225, 29, 72, .45); }
.video-info { padding: 12px; }
.video-title { margin: 0 0 6px; font-size: 16px; color: #ffffff; }
.video-desc { margin: 0; color: #98a2b3; font-size: 13px; }
.video-placeholder { width: 100%; height: 100%; background: #0e1218; display: flex; align-items: center; justify-content: center; }
.placeholder-text { color: #9aa4af; font-size: 14px; text-align: center; padding: 20px; }

@media (max-width: 640px) {
    .aprendizado-modulo { padding: 16px; }
    .mod-title { font-size: 22px; }
    .videos-grid { grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; }
    .play { font-size: 11px; padding: 5px 8px; }
    .video-title { font-size: 14px; }
    .video-desc { font-size: 12px; }
}
</style>
@endsection