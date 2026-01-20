@extends('layouts.app')

@section('title', $video->titulo)

@section('content')
<div class="aprendizado-modulo">
    <header class="mod-header">
        <a href="{{ route('aluno.aprendizado.show', $modulo->id) }}" class="back-btn">← Voltar ao módulo</a>

        <div class="title-row">
            <h1 class="mod-title">{{ $video->titulo }}</h1>
            <div class="meta">
                <span class="badge">{{ $modulo->categoria->nome ?? 'Módulo' }}</span>
                <span class="divider">•</span>
                <span class="videos-count">{{ $modulo->videos->count() }} vídeo{{ $modulo->videos->count() != 1 ? 's' : '' }}</span>
            </div>
        </div>

        @if(!empty($video->descricao))
            <p class="mod-desc">{{ $video->descricao }}</p>
        @endif
    </header>

    @php
        $poster = $video->thumbnail_url ?? $video->capa_url ?? $video->poster ?? null;
        $posterUrl = null;
        if ($poster) {
            $posterUrl = \Illuminate\Support\Str::startsWith($poster, ['http://', 'https://', 'data:'])
                ? $poster
                : \Illuminate\Support\Facades\Storage::url($poster);
        }
        $placeholderSvg = 'data:image/svg+xml;utf8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="640" height="360"><rect width="100%" height="100%" fill="%2312161e"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="%239aa4af" font-family="Arial" font-size="18">Carregando vídeo</text></svg>');
    @endphp

    <section class="player-wrap">
        @if(!empty($video->arquivo_path))
            <video controls playsinline poster="{{ $posterUrl ?? $placeholderSvg }}">
                <source src="{{ asset('storage/' . $video->arquivo_path) }}" type="video/mp4">
                Seu navegador não suporta vídeo.
            </video>
        @else
            <div class="no-video">
                <p>Vídeo não disponível</p>
            </div>
        @endif
    </section>

    @php
        $videosRelacionados = $modulo->videos->where('id', '!=', $video->id);
    @endphp

    @if($videosRelacionados->count() > 0)
        <section class="relacionados-section">
            <h2 class="relacionados-title">Outros vídeos deste módulo</h2>
            <div class="relacionados-grid">
                @foreach($videosRelacionados as $videoRelacionado)
                    @php
                        $thumbUrl = null;
                        if (!empty($videoRelacionado->arquivo_path)) {
                            $thumbUrl = asset('storage/' . $videoRelacionado->arquivo_path);
                        } elseif (!empty($videoRelacionado->thumbnail_url)) {
                            $thumbUrl = $videoRelacionado->thumbnail_url;
                        } elseif (!empty($videoRelacionado->capa)) {
                            $thumbUrl = \Illuminate\Support\Facades\Storage::url($videoRelacionado->capa);
                        }
                    @endphp

                    <article class="video-relacionado">
                        <a href="{{ route('aluno.aprendizado.video', [$modulo->id, $videoRelacionado->id]) }}" class="thumb-relacionado">
                            @if($thumbUrl && !empty($videoRelacionado->arquivo_path))
                                <video preload="metadata" muted>
                                    <source src="{{ asset('storage/' . $videoRelacionado->arquivo_path) }}" type="video/mp4">
                                </video>
                            @elseif($thumbUrl)
                                <img src="{{ $thumbUrl }}" alt="{{ $videoRelacionado->titulo }}" loading="lazy">
                            @else
                                <div class="placeholder-relacionado">
                                    <span class="placeholder-text-small">{{ $videoRelacionado->titulo }}</span>
                                </div>
                            @endif
                            <span class="play-small">▶</span>
                        </a>
                        <div class="info-relacionado">
                            <h3 class="titulo-relacionado">{{ $videoRelacionado->titulo }}</h3>
                            @if(!empty($videoRelacionado->descricao))
                                <p class="desc-relacionado">{{ \Illuminate\Support\Str::limit($videoRelacionado->descricao, 80) }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</div>

<style>
/* Escopo igual ao da página de módulo */
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

/* Player responsivo para vídeos verticais */
.player-wrap { 
    margin-top: 20px; 
    background: #0e1218; 
    border: 1px solid #1f2530; 
    border-radius: 10px; 
    overflow: hidden; 
    display: flex; 
    justify-content: center; 
    align-items: center;
}
.player-wrap video { 
    width: auto; 
    height: 70vh; 
    max-width: 100%; 
    background: #0e1218; 
    object-fit: contain;
}
.no-video { padding: 60px 20px; text-align: center; color: #9aa4af; background: #0e1218; }

/* Vídeos relacionados - 2 por linha exato */
.relacionados-section { margin-top: 40px; }
.relacionados-title { color: #ffffff; font-size: 18px; font-weight: 500; margin-bottom: 12px; }
.relacionados-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.video-relacionado { background: #12161e; border: 1px solid #1f2530; border-radius: 6px; overflow: hidden; transition: transform 0.2s; }
.video-relacionado:hover { transform: translateY(-1px); }
.thumb-relacionado { position: relative; aspect-ratio: 9/16; background: #0e1218; display: block; }
.thumb-relacionado img, .thumb-relacionado video { width: 100%; height: 100%; object-fit: cover; }
.placeholder-relacionado { width: 100%; height: 100%; background: #0e1218; display: flex; align-items: center; justify-content: center; }
.placeholder-text-small { color: #9aa4af; font-size: 10px; text-align: center; padding: 8px; }
.play-small { position: absolute; right: 6px; bottom: 6px; background: #e11d48; color: #fff; padding: 2px 6px; border-radius: 999px; font-size: 8px; }
.info-relacionado { padding: 8px; }
.titulo-relacionado { 
    margin: 0 0 2px; 
    font-size: 12px; 
    color: #ffffff; 
    line-height: 1.2; 
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.desc-relacionado { 
    margin: 0; 
    color: #98a2b3; 
    font-size: 10px; 
    line-height: 1.2; 
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    white-space: normal;
}

@media (max-width: 640px) {
    .aprendizado-modulo { padding: 16px; }
    .mod-title { font-size: 22px; }
    .player-wrap { 
        margin-top: 16px;
    }
    .player-wrap video { 
        width: 100%; 
        height: auto; 
        max-height: 75vh;
        aspect-ratio: 9/16;
    }
    .relacionados-section { margin-top: 24px; }
    .relacionados-title { font-size: 16px; }
    .relacionados-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
    .titulo-relacionado { font-size: 11px; }
    .desc-relacionado { font-size: 9px; -webkit-line-clamp: 2; }
    .info-relacionado { padding: 6px; }
}

@media (min-width: 641px) {
    .player-wrap video {
        aspect-ratio: 9/16;
        height: auto;
        width: 400px;
        max-width: 100%;
    }
}
</style>
@endsection