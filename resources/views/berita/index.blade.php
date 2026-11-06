@extends('layouts.app')
@section('title', __('Berita dan Kegiatan'))
@section('hdr', 'solid')
@section('content')
@php $sdgList = $sdgs; @endphp
<div class="pagehead"><div class="wrap"><h1>{{ __('Berita dan Kegiatan') }}</h1></div></div>
<section><div class="wrap">
 <form class="filters" method="get" action="{{ route('berita') }}">
  <label for="type" class="sr" style="position:absolute;left:-999px">{{ __('Jenis') }}</label>
  <select id="type" name="type" aria-label="{{ __('Jenis') }}">
   <option value="">{{ __('Semua jenis') }}</option>
   @foreach ($types as $t)<option value="{{ $t }}" @selected($type==$t)>{{ __($t) }}</option>@endforeach
  </select>
  <button class="btn dark sm" type="submit">{{ __('Terapkan') }}</button>
  @if ($sdg)<input type="hidden" name="sdg" value="{{ $sdg }}">@endif
 </form>
 @include('partials.sdg-filter', ['base' => 'berita'])
 <div style="margin-top:28px">
 @if ($items->isEmpty()) <p class="empty">{{ __('Belum ada konten.') }}</p>
 @else <div class="grid">@foreach ($items as $n) @include('partials.news-card') @endforeach</div>{{ $items->links() }} @endif
 </div>
</div></section>
@endsection
