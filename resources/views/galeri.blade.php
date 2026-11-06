@extends('layouts.app')
@section('title', __('Galeri'))
@section('hdr', 'solid')
@section('content')
<div class="pagehead"><div class="wrap"><h1>{{ __('Galeri Dokumentasi') }}</h1></div></div>
<section><div class="wrap">
 @forelse ($albums as $a)
  <div class="box">
   <h2>{{ $a->title }}</h2>
   <p class="meta">{{ $a->event_date ? \Carbon\Carbon::parse($a->event_date)->translatedFormat('d F Y') : '' }} {{ $a->description }}</p>
   @if ($a->media->isEmpty()) <p class="meta">{{ __('Belum ada berkas.') }}</p> @else
   <div class="thumbs">
    @foreach ($a->media as $m)
     <button type="button" class="thumb" data-type="{{ $m->type }}" data-src="{{ route('media', $m->id) }}" data-alt="{{ $m->alt_text ?: $a->title }}"
             aria-label="{{ __('Pratinjau') }}: {{ $m->alt_text ?: $a->title }}">
      @if ($m->type === 'image')<img src="{{ route('media', $m->id) }}" alt="{{ $m->alt_text ?: $a->title }}" loading="lazy">
      @else<video src="{{ route('media', $m->id) }}#t=0.5" preload="metadata" muted aria-hidden="true"></video><span class="pl">▶</span>@endif
     </button>
    @endforeach
   </div>@endif
  </div>
 @empty <p class="empty">{{ __('Belum ada dokumentasi.') }}</p>
 @endforelse
</div></section>
<dialog id="lb" aria-label="{{ __('Pratinjau') }}"><button type="button" class="close">{{ __('Tutup') }}</button><div class="box2"></div><div class="cap"></div></dialog>
@endsection
