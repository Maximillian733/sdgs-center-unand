@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<section class="dashboard-campus" aria-label="Sambutan dashboard SDGs Center UNAND">
 <div class="dashboard-campus-content">
  <p class="dashboard-kicker">SDGs CENTER · UNIVERSITAS ANDALAS</p>
  <h1>Selamat datang, {{ session('admin_name', 'Administrator') }}</h1>
  <p>Kelola profil, berita, proyek, kerja sama, dan dokumentasi kegiatan dari satu dashboard.</p>
  <a class="dashboard-campus-link" href="{{ route('home') }}" target="_blank" rel="noopener">Lihat website <span aria-hidden="true">↗</span></a>
 </div>
</section>
<h2 class="dashboard-section-title">Ringkasan konten</h2>
<div class="stat">
 <div class="card"><b>{{ $s['published'] }}</b>Berita terbit</div>
 <div class="card"><b>{{ $s['draft'] }}</b>Berita draf</div>
 <div class="card"><b>{{ $s['projects'] }}</b>Proyek</div>
 <div class="card"><b>{{ $s['albums'] }}</b>Album</div>
 <div class="card"><b>{{ $s['media'] }}</b>Berkas media</div>
 <div class="card"><b>{{ $s['members'] }}</b>Pengurus</div>
</div>
<p style="margin-top:24px"><a class="btn dark" href="{{ route('admin.berita.create') }}">+ Berita baru</a>
 <a class="btn dark" href="{{ route('admin.proyek.create') }}">+ Proyek baru</a></p>
@endsection
