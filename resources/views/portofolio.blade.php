@extends('layouts.app')
@section('title', __('Portofolio dan Kerja Sama'))
@section('hdr', 'solid')
@section('content')
@php $sdgList = $sdgs->values(); @endphp
<div class="pagehead"><div class="wrap"><h1>{{ __('Portofolio dan Kerja Sama') }}</h1></div></div>
<section><div class="wrap">
 <form class="filters" method="get" action="{{ route('portofolio') }}">
  <select name="type" aria-label="{{ __('Jenis') }}"><option value="">{{ __('Semua jenis') }}</option>
   @foreach ($types as $t)<option value="{{ $t }}" @selected(($f['type'] ?? '')==$t)>{{ __($t) }}</option>@endforeach</select>
  <select name="sdg" aria-label="SDGs"><option value="">{{ __('Semua SDGs') }}</option>
   @foreach ($sdgs as $s)<option value="{{ $s->id }}" @selected(($f['sdg'] ?? '')==$s->id)>SDG {{ $s->id }} – {{ app()->getLocale()=='en' ? $s->name_en : $s->name_id }}</option>@endforeach</select>
  <select name="year" aria-label="{{ __('Tahun') }}"><option value="">{{ __('Semua tahun') }}</option>
   @foreach ($years as $y)<option value="{{ $y }}" @selected(($f['year'] ?? '')==$y)>{{ $y }}</option>@endforeach</select>
  <button class="btn dark sm" type="submit">{{ __('Terapkan') }}</button>
 </form>
 @if ($items->isEmpty()) <p class="empty">{{ __('Belum ada konten.') }}</p>
 @else
  <div class="scroll"><table class="table"><thead><tr><th>{{ __('Tahun') }}</th><th>{{ __('Proyek') }}</th><th>{{ __('Jenis') }}</th><th>{{ __('Mitra') }}</th><th>{{ __('Laporan') }}</th></tr></thead>
  <tbody>@foreach ($items as $p) @include('partials.project-card') @endforeach</tbody></table></div>
  {{ $items->links() }}
 @endif
</div></section>
@endsection
