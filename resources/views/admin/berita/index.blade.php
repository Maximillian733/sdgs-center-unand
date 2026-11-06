@extends('layouts.admin')
@section('title', 'Berita')
@section('content')
<div class="sec-h"><h1 style="margin:0">Berita dan Informasi Kegiatan</h1><a class="btn dark" href="{{ route('admin.berita.create') }}">+ Berita baru</a></div>
<div class="scroll"><table class="table"><thead><tr><th>Judul</th><th>Jenis</th><th>Status</th><th>Unggulan</th><th>Diubah</th><th>Aksi</th></tr></thead><tbody>
@forelse ($items as $n)
 <tr><td>{{ $n->title_id }}</td><td>{{ $n->type }}</td><td>{{ $n->status === 'published' ? 'Terbit' : 'Draf' }}</td><td>{{ $n->is_featured ? 'Ya' : '-' }}</td>
  <td>{{ \Carbon\Carbon::parse($n->updated_at)->format('d/m/Y H:i') }}</td>
  <td class="acts">
   <a class="btn sm dark" href="{{ route('admin.berita.edit', $n->id) }}">Ubah</a>
   @if ($n->status === 'published')
    <a class="btn sm line" style="color:var(--ink);border-color:var(--line)" href="{{ route('berita.show', $n->slug) }}" target="_blank" rel="noopener">Lihat</a>
    <form method="post" action="{{ route('admin.berita.unpublish', $n->id) }}">@csrf<button class="btn sm line" style="color:var(--ink);border-color:var(--line)" type="submit">Batal terbit</button></form>
   @endif
   <form method="post" action="{{ route('admin.berita.destroy', $n->id) }}" data-confirm="Hapus berita ini?">@csrf @method('DELETE')<button class="btn sm red" type="submit">Hapus</button></form>
  </td></tr>
@empty <tr><td colspan="6">Belum ada berita.</td></tr>
@endforelse
</tbody></table></div>
@endsection
