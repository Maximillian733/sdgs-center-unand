@extends('layouts.app')
@section('title', $loc($item,'title'))
@section('hdr', 'solid')
@section('content')
<div class="pagehead"><div class="wrap"><p class="meta" style="color:#c8d0e0"><span class="tag">{{ __($item->type) }}</span>
 {{ \Carbon\Carbon::parse($item->event_date ?? $item->published_at)->translatedFormat('d F Y') }}</p><h1>{{ $loc($item,'title') }}</h1></div></div>
<section><div class="wrap prose">
 @if ($item->cover_media_id)<img src="{{ route('media', $item->cover_media_id) }}" alt="{{ $loc($item,'title') }}" style="border-radius:10px;margin-bottom:22px">@endif
 {{-- body sudah disanitasi saat disimpan (App\Support\Html::clean) --}}
 {!! $loc($item,'body') !!}
 <p>@foreach ($item->sdg_ids as $id)<a class="pill" style="--c:{{ $sdgs[$id]->color }}" href="{{ route('berita',['sdg'=>$id]) }}">SDG {{ $id }}</a>@endforeach</p>
 @if ($hasAttachment)<p><a class="btn" href="{{ route('berita.lampiran', $item->slug) }}" download>{{ __('Unduh lampiran') }}</a></p>@endif
 <p><a href="{{ route('berita') }}">← {{ __('Kembali ke daftar') }}</a></p>
</div></section>
@endsection
