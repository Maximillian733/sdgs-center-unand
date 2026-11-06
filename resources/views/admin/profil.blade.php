@extends('layouts.admin')
@section('title', 'Profil dan Pengurus')
@section('content')
<h1>Profil dan Pengurus</h1>
<form class="box f" method="post" action="{{ route('admin.profil.update') }}">
 @csrf @method('PUT')
 <h2>Visi, misi, dan kontak</h2>
 <div class="row">
  <div><label for="vision_id">Visi (Indonesia)</label><textarea id="vision_id" name="vision_id" required>{{ old('vision_id', $org->vision_id ?? '') }}</textarea></div>
  <div><label for="vision_en">Visi (English)</label><textarea id="vision_en" name="vision_en">{{ old('vision_en', $org->vision_en ?? '') }}</textarea></div>
  <div><label for="mission_id">Misi (Indonesia) – satu misi per baris</label><textarea id="mission_id" name="mission_id" required>{{ old('mission_id', $org->mission_id ?? '') }}</textarea></div>
  <div><label for="mission_en">Misi (English) – one mission per line</label><textarea id="mission_en" name="mission_en">{{ old('mission_en', $org->mission_en ?? '') }}</textarea></div>
 </div>
 <label for="address">Alamat</label><input id="address" type="text" name="address" value="{{ old('address', $org->address ?? '') }}" required>
 <div class="row">
  <div><label for="phone">Telepon</label><input id="phone" type="text" name="phone" value="{{ old('phone', $org->phone ?? '') }}"></div>
  <div><label for="fax">Faks</label><input id="fax" type="text" name="fax" value="{{ old('fax', $org->fax ?? '') }}"></div>
 </div>
 <label for="email">Surel</label><input id="email" type="email" name="email" value="{{ old('email', $org->email ?? '') }}" required>
 <p><button class="btn dark" type="submit">Simpan profil</button></p>
</form>

<div class="box f">
 <h2>Pengurus</h2>
 <div class="scroll"><table class="table"><thead><tr><th>Urutan</th><th>Jabatan</th><th>Nama</th><th>Foto</th><th>Aksi</th></tr></thead><tbody>
 @foreach ($members as $m)
  <tr>
   <td colspan="5">
    <form method="post" action="{{ route('admin.pengurus.update', $m->id) }}" enctype="multipart/form-data" class="row" style="grid-template-columns:70px 1fr 1fr 1fr auto;align-items:end">
     @csrf @method('PUT')
     <div><label for="o{{ $m->id }}">Urutan</label><input id="o{{ $m->id }}" type="number" name="sort_order" value="{{ $m->sort_order }}" min="0" max="999"></div>
     <div><label for="p{{ $m->id }}">Jabatan</label><input id="p{{ $m->id }}" type="text" name="position" value="{{ $m->position }}" required></div>
     <div><label for="n{{ $m->id }}">Nama</label><input id="n{{ $m->id }}" type="text" name="name" value="{{ $m->name }}" required></div>
     <div><label for="f{{ $m->id }}">Ganti foto</label><input id="f{{ $m->id }}" type="file" name="photo" accept="image/*"></div>
     <div class="acts"><button class="btn sm dark" type="submit">Simpan</button></div>
    </form>
    <form method="post" action="{{ route('admin.pengurus.destroy', $m->id) }}" data-confirm="Hapus pengurus {{ $m->name }}?" style="margin-top:6px">
     @csrf @method('DELETE')<button class="btn sm red" type="submit">Hapus</button></form>
   </td>
  </tr>
 @endforeach
 </tbody></table></div>
 <h3 style="margin-top:22px">Tambah pengurus</h3>
 <form method="post" action="{{ route('admin.pengurus.store') }}" enctype="multipart/form-data">
  @csrf
  <div class="row">
   <div><label for="np">Jabatan</label><input id="np" type="text" name="position" required></div>
   <div><label for="nn">Nama</label><input id="nn" type="text" name="name" required></div>
   <div><label for="ns">Urutan</label><input id="ns" type="number" name="sort_order" value="0" min="0" max="999"></div>
   <div><label for="nf">Foto (maks. 5 MB)</label><input id="nf" type="file" name="photo" accept="image/*"></div>
  </div>
  <p><button class="btn dark" type="submit">Tambah</button></p>
 </form>
</div>
@endsection
