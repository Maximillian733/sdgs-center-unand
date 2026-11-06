@extends('layouts.app')
@section('title', __('Kontak'))
@section('hdr', 'solid')
@section('content')
<div class="pagehead"><div class="wrap"><h1>{{ __('Kontak dan Lokasi') }}</h1></div></div>
<section><div class="wrap">
 <div class="box"><table class="table"><tbody>
  <tr><th scope="row">{{ __('Alamat') }}</th><td>{{ $org->address }}</td></tr>
  <tr><th scope="row">{{ __('Telepon') }}</th><td><a href="tel:{{ preg_replace('/\s+/', '', $org->phone ?? '') }}">{{ $org->phone }}</a></td></tr>
  <tr><th scope="row">{{ __('Faks') }}</th><td>{{ $org->fax }}</td></tr>
  <tr><th scope="row">{{ __('Surel') }}</th><td><a href="mailto:{{ $org->email }}">{{ $org->email }}</a></td></tr>
 </tbody></table></div>
 <p><a class="btn dark" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query={{ urlencode('SDGs Center Universitas Andalas, Limau Manih, Padang') }}">{{ __('Buka di Google Maps') }}</a></p>
</div></section>
@endsection
