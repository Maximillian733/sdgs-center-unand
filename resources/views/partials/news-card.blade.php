<article class="item">
 @if ($n->cover_media_id)
  <img class="cov" src="{{ route('media', $n->cover_media_id) }}" alt="{{ $loc($n,'title') }}" loading="lazy">
 @else
  <div class="ph" aria-hidden="true">SDGs</div>
 @endif
 <div class="bd">
  <p class="meta"><span class="tag">{{ __($n->type) }}</span>
   {{ \Carbon\Carbon::parse($n->event_date ?? $n->published_at)->translatedFormat('d F Y') }}</p>
  <h3><a href="{{ route('berita.show', $n->slug) }}">{{ $loc($n,'title') }}</a></h3>
  @foreach (($n->sdg_ids ?? []) as $id)
   <a class="pill" style="--c:{{ $sdgList[$id-1]->color ?? '#555' }}" href="{{ route('berita', ['sdg'=>$id]) }}" title="SDG {{ $id }}">SDG {{ $id }}</a>
  @endforeach
 </div>
</article>
