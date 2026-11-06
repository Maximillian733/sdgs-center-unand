@extends('layouts.app')
@section('title', __('Beranda'))
@section('content')
@php $sdgList = $sdgs; @endphp
<section class="hero" style="padding-bottom:130px">
 <div class="wrap">
  <h1>{{ __('Bersama Mewujudkan SDGs 2030.') }}</h1>
  <p>{{ __('Pusat kajian dan pelatihan Universitas Andalas: penelitian, pendampingan, dan kerja sama untuk masyarakat yang berkualitas dan sejahtera.') }}</p>
  <p><a class="btn" href="{{ route('portofolio') }}">{{ __('Lihat Portofolio') }}</a> <a class="btn line" href="{{ route('kontak') }}">{{ __('Hubungi Kami') }}</a></p>
 </div>
</section>
<div class="wrap">
 <div class="cards3">
  <a class="card" href="{{ route('portofolio',['type'=>'studi']) }}"><div class="ic" aria-hidden="true">◈</div><h3>{{ __('Studi dan Penelitian') }}</h3><p>{{ __('Kajian yang responsif terhadap dinamika lingkungan.') }}</p></a>
  <a class="card" href="{{ route('portofolio',['type'=>'pendampingan']) }}"><div class="ic" aria-hidden="true">◇</div><h3>{{ __('Pendampingan') }}</h3><p>{{ __('Pendampingan nagari/desa dan pemangku kepentingan.') }}</p></a>
  <a class="card" href="{{ route('portofolio',['type'=>'workshop']) }}"><div class="ic" aria-hidden="true">◎</div><h3>{{ __('Workshop dan Forum') }}</h3><p>{{ __('Pelatihan, forum, dan kerja sama dalam dan luar negeri.') }}</p></a>
 </div>
</div>

<section id="sdg">
 <div class="wrap">
  <div class="sec-h"><h2>{{ __('Telusuri berdasarkan 17 SDGs') }}</h2></div>
  @include('partials.sdg-filter', ['base' => 'home', 'anchor' => '#hasil'])
  @if ($filtered)
   <div id="hasil" style="margin-top:34px" tabindex="-1">
    <h3>{{ __('Konten untuk SDG') }} {{ $sdg }}</h3>
    @if ($filtered['news']->isEmpty() && $filtered['projects']->isEmpty())
     <p class="empty">{{ __('Belum ada konten untuk SDG ini.') }}</p>
    @else
     <div class="grid">@foreach ($filtered['news'] as $n) @include('partials.news-card') @endforeach</div>
     @if ($filtered['projects']->isNotEmpty())
      <h3 style="margin-top:28px">{{ __('Portofolio') }}</h3>
      <div class="scroll"><table class="table"><thead><tr><th>{{ __('Tahun') }}</th><th>{{ __('Proyek') }}</th><th>{{ __('Jenis') }}</th><th>{{ __('Mitra') }}</th><th></th></tr></thead>
       <tbody>@foreach ($filtered['projects'] as $p) @include('partials.project-card') @endforeach</tbody></table></div>
     @endif
    @endif
   </div>
  @endif
 </div>
</section>

<section style="background:#fff">
 <div class="wrap about">
  <div>
   <h2>{{ __('Tentang SDGs Center') }}</h2>
   <p>{{ __('SDGs Center UNAND adalah pusat kajian dan pelatihan di lingkungan Universitas Andalas yang berperan nyata dalam pencapaian tujuan pembangunan berkelanjutan melalui penelitian, pendampingan, dan kerja sama.') }}</p>
   <p><a class="btn" href="{{ route('profil') }}">{{ __('Selengkapnya') }}</a></p>
  </div>
  <div class="panel" role="img" aria-label="{{ __('Ilustrasi 17 tujuan SDGs') }}">
   @foreach ($sdgs as $s)<i style="--c:{{ $s->color }}"></i>@endforeach
  </div>
 </div>
</section>

<section>
 <div class="wrap">
  @if ($featured->isNotEmpty())
   <div class="sec-h"><h2>{{ __('Berita Unggulan') }}</h2></div>
   <div class="grid">@foreach ($featured as $n) @include('partials.news-card') @endforeach</div>
  @endif
  <div class="sec-h" style="margin-top:48px"><h2>{{ __('Berita Terbaru') }}</h2><a class="btn-o" href="{{ route('berita') }}">{{ __('Lihat semua') }}</a></div>
  @if ($latest->isEmpty()) <p class="empty">{{ __('Belum ada berita.') }}</p>
  @else <div class="grid">@foreach ($latest as $n) @include('partials.news-card') @endforeach</div> @endif
 </div>
</section>
@endsection
