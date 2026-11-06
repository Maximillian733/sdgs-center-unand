<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'SDGs Center Unand') | SDGs Center Unand</title>
<meta name="description" content="{{ __('Pusat kajian dan pelatihan SDGs Universitas Andalas.') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<a class="skip" href="#main">{{ __('Lewati ke konten utama') }}</a>
<header class="hdr @yield('hdr')">
 <div class="wrap">
  <a class="logo" href="{{ route('home') }}" aria-label="SDGs Center Unand">
   <img src="{{ asset('images/logo-sdgs-unand.png') }}" alt="" width="50" height="50">
   <span>SDGs CENTER<small>UNIVERSITAS ANDALAS</small></span>
  </a>
  <button class="burger" aria-controls="nav" aria-expanded="false" type="button">{{ __('Menu') }}</button>
  <nav class="nav" id="nav" aria-label="{{ __('Navigasi utama') }}">
   @php $cur = fn($r) => request()->routeIs($r) ? 'page' : 'false'; @endphp
   <a href="{{ route('home') }}" aria-current="{{ $cur('home') }}">{{ __('Beranda') }}</a>
   <a href="{{ route('profil') }}" aria-current="{{ $cur('profil') }}">{{ __('Profil dan Kepengurusan') }}</a>
   <a href="{{ route('berita') }}" aria-current="{{ $cur('berita*') }}">{{ __('Berita dan Kegiatan') }}</a>
   <a href="{{ route('portofolio') }}" aria-current="{{ $cur('portofolio*') }}">{{ __('Portofolio dan Kerja Sama') }}</a>
   <a href="{{ route('galeri') }}" aria-current="{{ $cur('galeri') }}">{{ __('Galeri') }}</a>
   <a class="btn-line" href="{{ route('kontak') }}" aria-current="{{ $cur('kontak') }}">{{ __('Kontak') }}</a>
   <form class="srch" action="{{ route('cari') }}" method="get" role="search">
     <label class="sr" for="q" style="position:absolute;left:-999px">{{ __('Cari') }}</label>
     <input id="q" type="search" name="q" maxlength="100" placeholder="{{ __('Cari informasi…') }}" value="{{ request('q') }}">
     <button type="submit">{{ __('Cari') }}</button>
   </form>
   <div class="lang" aria-label="{{ __('Pilih bahasa') }}">
     <a href="{{ route('bahasa','id') }}" hreflang="id" lang="id" aria-current="{{ app()->getLocale()=='id' ? 'true':'false' }}">ID</a>
     <a href="{{ route('bahasa','en') }}" hreflang="en" lang="en" aria-current="{{ app()->getLocale()=='en' ? 'true':'false' }}">EN</a>
   </div>
  </nav>
 </div>
</header>
<main id="main">
 @yield('content')
</main>
@include('partials.footer')
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
