@extends('layouts.app')
@section('title', __('Profil dan Kepengurusan'))
@section('hdr', 'solid')
@section('content')
<div class="pagehead"><div class="wrap"><h1>{{ __('Profil dan Kepengurusan') }}</h1></div></div>
<section><div class="wrap prose">
 <h2>{{ __('Visi') }}</h2><p>{{ $loc($org, 'vision') }}</p>
 <h2>{{ __('Misi') }}</h2>
 <ol>@foreach (preg_split('/\R/', trim($loc($org, 'mission')), -1, PREG_SPLIT_NO_EMPTY) as $m)<li>{{ $m }}</li>@endforeach</ol>
</div></section>
<section style="background:#fff"><div class="wrap">
 <h2>{{ __('Struktur Kepengurusan') }}</h2>
 <div class="people">
  @foreach ($members as $m)
   <div class="person">
    @if ($m->photo_media_id)<img src="{{ route('media', $m->photo_media_id) }}" alt="{{ __('Foto') }} {{ $m->name }}" loading="lazy">
    @else <div class="av" aria-hidden="true">{{ mb_substr($m->name, 0, 1) }}</div>@endif
    <strong>{{ $m->name }}</strong><br><span class="meta">{{ $m->position }}</span>
   </div>
  @endforeach
 </div>
</div></section>
@endsection
