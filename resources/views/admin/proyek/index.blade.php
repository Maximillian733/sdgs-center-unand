@extends('layouts.admin')
@section('title', 'Portofolio')
@section('content')
<div class="sec-h"><h1 style="margin:0">Portofolio Proyek dan Kerja Sama</h1><a class="btn dark" href="{{ route('admin.proyek.create') }}">+ Proyek baru</a></div>
<div class="scroll"><table class="table"><thead><tr><th>Tahun</th><th>Proyek</th><th>Jenis</th><th>Mitra</th><th>PDF</th><th>Aksi</th></tr></thead><tbody>
@forelse ($items as $p)
 <tr><td>{{ $p->year }}</td><td>{{ $p->title }}</td><td>{{ $p->type }}</td><td>{{ implode(', ', $p->partners) ?: '-' }}</td><td>{{ $p->report_media_id ? 'Ada' : '-' }}</td>
  <td class="acts"><a class="btn sm dark" href="{{ route('admin.proyek.edit', $p->id) }}">Ubah</a>
   <form method="post" action="{{ route('admin.proyek.destroy', $p->id) }}" data-confirm="Hapus proyek ini beserta laporannya?">@csrf @method('DELETE')<button class="btn sm red" type="submit">Hapus</button></form></td></tr>
@empty <tr><td colspan="6">Belum ada proyek.</td></tr>
@endforelse
</tbody></table></div>
@endsection
