@extends('layouts.app')
@section('title', __('Hasil pencarian'))
@section('hdr', 'solid')
@section('content')
@php $sdgList = app(\App\Services\SdgService::class)->all(); @endphp
<div class="pagehead"><div class="wrap"><h1>{{ __('Hasil pencarian') }}: “{{ $q }}”</h1></div></div>
<section><div class="wrap">
 @if (mb_strlen($q) < 2)
  <p class="empty">{{ __('Masukkan minimal 2 karakter.') }}</p>
 @elseif ($news->isEmpty() && $projects->isEmpty())
  <p class="empty">{{ __('Tidak ditemukan hasil untuk kata kunci tersebut.') }}</p>
 @else
  @if ($news->isNotEmpty())<h2>{{ __('Berita dan Kegiatan') }}</h2><div class="grid">@foreach ($news as $n) @include('partials.news-card') @endforeach</div>@endif
  @if ($projects->isNotEmpty())<h2 style="margin-top:32px">{{ __('Portofolio dan Kerja Sama') }}</h2>
   <div class="scroll"><table class="table"><thead><tr><th>{{ __('Tahun') }}</th><th>{{ __('Proyek') }}</th><th>{{ __('Jenis') }}</th><th>{{ __('Mitra') }}</th><th></th></tr></thead>
   <tbody>@foreach ($projects as $p) @include('partials.project-card') @endforeach</tbody></table></div>@endif
 @endif
</div></section>
@endsection
