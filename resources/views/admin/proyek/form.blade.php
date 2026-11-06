@extends('layouts.admin')
@section('title', $item ? 'Ubah proyek' : 'Proyek baru')
@section('content')
@php $v = fn($k) => old($k, $item->$k ?? ''); @endphp
<h1>{{ $item ? 'Ubah proyek' : 'Proyek baru' }}</h1>
<form class="box f" method="post" enctype="multipart/form-data" action="{{ $item ? route('admin.proyek.update', $item->id) : route('admin.proyek.store') }}">
 @csrf @if ($item) @method('PUT') @endif
 <label for="title">Judul proyek *</label><input id="title" type="text" name="title" value="{{ $v('title') }}" maxlength="255" required>
 <div class="row">
  <div><label for="type">Jenis *</label><select id="type" name="type">@foreach ($types as $t)<option value="{{ $t }}" @selected($v('type') == $t)>{{ ucfirst($t) }}</option>@endforeach</select></div>
  <div><label for="year">Tahun *</label><input id="year" type="number" name="year" value="{{ $v('year') ?: date('Y') }}" min="1990" max="2100" required></div>
 </div>
 <label for="description">Deskripsi</label><textarea id="description" name="description">{{ $v('description') }}</textarea>
 <label for="partners">Mitra kerja sama (pisahkan dengan koma)</label>
 <input id="partners" type="text" name="partners" value="{{ old('partners', isset($item) ? implode(', ', $item->partners) : '') }}" placeholder="GIZ Jerman, BRIN">
 <label for="report">Laporan PDF (maks. 10 MB)</label><input id="report" type="file" name="report" accept="application/pdf">
 @if ($item && $item->report_media_id)<span class="meta">Laporan sudah ada. Unggah baru untuk mengganti: <a href="{{ route('portofolio.unduh', $item->id) }}">unduh</a></span>@endif
 @include('admin.partials.sdg-checks', ['selected' => $item->sdg_ids ?? []])
 <p class="acts"><button class="btn dark" type="submit">Simpan</button><a class="btn-o" href="{{ route('admin.proyek') }}">Kembali</a></p>
</form>
@endsection
