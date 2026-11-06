@extends('layouts.admin')
@section('title', 'Galeri')
@section('content')
<h1>Galeri dan Dokumentasi</h1>
<form class="box f" method="post" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data">
 @csrf
 <h2>Album baru</h2>
 <div class="row">
  <div><label for="title">Judul kegiatan *</label><input id="title" type="text" name="title" maxlength="200" required></div>
  <div><label for="event_date">Tanggal</label><input id="event_date" type="date" name="event_date"></div>
 </div>
 <label for="description">Deskripsi</label><input id="description" type="text" name="description" maxlength="2000">
 <label for="files">Foto/video (JPG, PNG, WebP, GIF, MP4, WebM; foto maks. 5 MB, video maks. 100 MB)</label>
 <input id="files" type="file" name="files[]" multiple accept="image/*,video/mp4,video/webm">
 <label for="alt_text">Teks alternatif (deskripsi singkat foto, untuk pembaca layar)</label><input id="alt_text" type="text" name="alt_text" maxlength="255">
 <p><button class="btn dark" type="submit">Buat album</button></p>
</form>
@foreach ($albums as $a)
 <div class="box f">
  <div class="sec-h" style="margin-bottom:10px"><h2 style="margin:0;font-size:1.2rem">{{ $a->title }} <small class="meta">{{ $a->event_date }}</small></h2>
   <form method="post" action="{{ route('admin.galeri.destroy', $a->id) }}" data-confirm="Hapus album &quot;{{ $a->title }}&quot; beserta semua berkasnya?">@csrf @method('DELETE')<button class="btn sm red" type="submit">Hapus album</button></form></div>
  <div class="thumbs">
   @foreach ($a->media as $m)
    <div>
     @if ($m->type === 'image')<img src="{{ route('media', $m->id) }}" alt="{{ $m->alt_text ?: $a->title }}" style="aspect-ratio:1;object-fit:cover;width:100%;border-radius:8px">
     @else<video src="{{ route('media', $m->id) }}" style="aspect-ratio:1;width:100%;border-radius:8px" controls preload="metadata"></video>@endif
     <form method="post" action="{{ route('admin.media.destroy', $m->id) }}" data-confirm="Hapus berkas ini?">@csrf @method('DELETE')<button class="btn sm red" type="submit" style="width:100%;margin-top:4px">Hapus</button></form>
    </div>
   @endforeach
  </div>
  <form method="post" action="{{ route('admin.galeri.upload', $a->id) }}" enctype="multipart/form-data" style="margin-top:14px">
   @csrf
   <label for="f{{ $a->id }}">Tambah berkas</label><input id="f{{ $a->id }}" type="file" name="files[]" multiple required accept="image/*,video/mp4,video/webm">
   <label for="a{{ $a->id }}">Teks alternatif</label><input id="a{{ $a->id }}" type="text" name="alt_text" maxlength="255">
   <p><button class="btn dark sm" type="submit">Unggah</button></p>
  </form>
 </div>
@endforeach
@endsection
