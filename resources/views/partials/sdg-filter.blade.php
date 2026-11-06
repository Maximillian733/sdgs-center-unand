{{-- $base: route name, $sdg: terpilih. Ikon SDG berupa kotak bernomor (bukan logo resmi PBB). --}}
<div class="sdgs" role="list">
 @foreach ($sdgList as $s)
  <a class="sdg" role="listitem" style="--c:{{ $s->color }}" aria-current="{{ ($sdg ?? null) == $s->id ? 'true' : 'false' }}"
     href="{{ route($base, array_filter(['sdg' => $s->id] + request()->except(['sdg','page']))) }}{{ $anchor ?? '' }}">
   <b>{{ $s->id }}</b><span>{{ app()->getLocale()=='en' ? $s->name_en : $s->name_id }}</span>
  </a>
 @endforeach
</div>
@if (!empty($sdg))<p><a href="{{ route($base, request()->except(['sdg','page'])) }}">{{ __('Hapus filter SDGs') }}</a></p>@endif
