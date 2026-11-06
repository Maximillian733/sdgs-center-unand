<footer class="ftr">
 <div class="wrap">
  <div>
   <h3>SDGs Center Universitas Andalas</h3>
   <p>{{ __('Pusat kajian dan pelatihan untuk mewujudkan tujuan pembangunan berkelanjutan (SDGs).') }}</p>
  </div>
  <div>
   <h3>{{ __('Kontak') }}</h3>
   <address style="font-style:normal">
    {{ $org->address ?? '' }}<br>
    {{ __('Telepon') }}: {{ $org->phone ?? '-' }}<br>
    {{ __('Faks') }}: {{ $org->fax ?? '-' }}<br>
    {{ __('Surel') }}: <a href="mailto:{{ $org->email ?? '' }}">{{ $org->email ?? '' }}</a>
   </address>
  </div>
  <div>
   <h3>{{ __('Tautan') }}</h3>
   <a href="{{ route('berita') }}">{{ __('Berita dan Kegiatan') }}</a><br>
   <a href="{{ route('portofolio') }}">{{ __('Portofolio dan Kerja Sama') }}</a><br>
   <a href="{{ route('galeri') }}">{{ __('Galeri') }}</a>
  </div>
  <p class="copy">© {{ date('Y') }} SDGs Center Universitas Andalas.<br>
   Foto gedung Rektorat UNAND: <a href="https://commons.wikimedia.org/wiki/File:Andalas_University_rectorate.JPG" target="_blank" rel="noopener noreferrer">SpartacksCompatriot</a>,
   <a href="https://creativecommons.org/licenses/by/3.0/" target="_blank" rel="noopener noreferrer">CC BY 3.0</a>. Dipakai sebagai latar dan diberi lapisan warna.
  </p>
 </div>
</footer>
