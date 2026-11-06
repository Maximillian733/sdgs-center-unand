<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>@yield('title') | Admin SDGs Center</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<a class="skip" href="#main">Lewati ke konten utama</a>
<div class="adm">
 <aside class="side">
  <a class="admin-brand" href="{{ route('admin.dashboard') }}" aria-label="Dashboard Admin SDGs Center UNAND">
   <img src="{{ asset('images/logo-sdgs-unand.png') }}" alt="" width="52" height="52">
   <span><strong>SDGs Center</strong><small>UNAND · ADMIN PANEL</small></span>
  </a>
  <nav aria-label="Menu admin">
   @php $c = fn($r) => request()->routeIs($r) ? 'page' : 'false'; @endphp
   <a href="{{ route('admin.dashboard') }}" aria-current="{{ $c('admin.dashboard') }}">Dashboard</a>
   <a href="{{ route('admin.profil') }}" aria-current="{{ $c('admin.profil*') }}">Profil dan Pengurus</a>
   <a href="{{ route('admin.berita') }}" aria-current="{{ $c('admin.berita*') }}">Berita</a>
   <a href="{{ route('admin.proyek') }}" aria-current="{{ $c('admin.proyek*') }}">Portofolio</a>
   <a href="{{ route('admin.galeri') }}" aria-current="{{ $c('admin.galeri*') }}">Galeri</a>
   <a href="{{ route('home') }}" target="_blank" rel="noopener">Lihat situs ↗</a>
  </nav>
  <form method="post" action="{{ route('admin.logout') }}" style="margin:16px 12px">@csrf<button class="btn sm" type="submit">Keluar ({{ session('admin_name') }})</button></form>
 </aside>
 <main class="main" id="main">
  @include('admin.partials.flash')
  @yield('content')
 </main>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
