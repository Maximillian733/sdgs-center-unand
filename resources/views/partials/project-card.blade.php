<tr>
 <td>{{ $p->year }}</td>
 <td><strong>{{ $p->title }}</strong>
  @if ($p->description)<br><span class="meta">{{ $p->description }}</span>@endif
  <br>@foreach (($p->sdg_ids ?? []) as $id)<a class="pill" style="--c:{{ $sdgList[$id-1]->color ?? '#555' }}" href="{{ route('portofolio',['sdg'=>$id]) }}">SDG {{ $id }}</a>@endforeach</td>
 <td><span class="tag">{{ __($p->type) }}</span></td>
 <td>{{ implode(', ', $p->partners ?? []) ?: '-' }}</td>
 <td>@if ($p->report_media_id)<a class="btn sm" href="{{ route('portofolio.unduh', $p->id) }}" download>{{ __('Unduh laporan') }}</a>@else <span class="meta">-</span>@endif</td>
</tr>
