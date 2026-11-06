@extends('layouts.admin')
@section('title', $item ? 'Ubah berita' : 'Berita baru')
@section('content')
@php $v = fn($k) => old($k, $item->$k ?? ''); @endphp
<h1>{{ $item ? 'Ubah berita' : 'Berita baru' }} @if ($item)<small class="meta">({{ $item->status === 'published' ? 'Terbit' : 'Draf' }})</small>@endif</h1>
<form class="box f" method="post" enctype="multipart/form-data" action="{{ $item ? route('admin.berita.update', $item->id) : route('admin.berita.store') }}">
 @csrf @if ($item) @method('PUT') @endif
 <div class="row">
  <div><label for="title_id">Judul (Indonesia) *</label><input id="title_id" type="text" name="title_id" value="{{ $v('title_id') }}" maxlength="200" required></div>
  <div><label for="title_en">Judul (English)</label><input id="title_en" type="text" name="title_en" value="{{ $v('title_en') }}" maxlength="200"></div>
  <div><label for="body_id">Isi (Indonesia) *</label><textarea id="body_id" name="body_id" rows="10" required>{{ $v('body_id') }}</textarea></div>
  <div><label for="body_en">Isi (English)</label><textarea id="body_en" name="body_en" rows="10">{{ $v('body_en') }}</textarea></div>
 </div>
 <p class="meta">Tulis teks biasa (paragraf dipisah baris kosong) atau HTML dasar: p, br, strong, em, ul, ol, li, a, h2–h4. Tag lain dibuang otomatis.</p>
 <div class="row">
  <div><label for="type">Jenis *</label><select id="type" name="type">@foreach ($types as $t)<option value="{{ $t }}" @selected($v('type') == $t || (!$item && $t=='berita' && !old('type')))>{{ ucfirst($t) }}</option>@endforeach</select></div>
  <div><label for="event_date">Tanggal kegiatan</label><input id="event_date" type="date" name="event_date" value="{{ $v('event_date') }}"></div>
  <div><label for="cover">Gambar cover (JPG/PNG/WebP, maks. 5 MB)</label><input id="cover" type="file" name="cover" accept="image/*">@if ($item && $item->cover_media_id)<span class="meta">Sudah ada cover. Unggah baru untuk mengganti.</span>@endif</div>
  <div><label for="attachment">Lampiran PDF (maks. 10 MB)</label><input id="attachment" type="file" name="attachment" accept="application/pdf">@if ($item && $item->attachment_media_id)<span class="meta">Sudah ada lampiran.</span>@endif</div>
 </div>
 <label class="chk"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $item->is_featured ?? false))> Tampilkan sebagai berita unggulan di beranda</label>
 @include('admin.partials.sdg-checks', ['selected' => $item->sdg_ids ?? []])
 <p class="acts">
  <button class="btn line" style="color:var(--ink);border-color:#b7bfce" type="submit" name="action" value="draft">Simpan Draf</button>
  <button class="btn dark" type="submit" name="action" value="publish">Publish</button>
  <a class="btn-o" href="{{ route('admin.berita') }}">Kembali</a>
 </p>
</form>
@endsection
