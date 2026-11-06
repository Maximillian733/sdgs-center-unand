@if (session('ok'))<div class="flash ok" role="status">{{ session('ok') }}</div>@endif
@if (session('error'))<div class="flash err" role="alert">{{ session('error') }}</div>@endif
@if ($errors->any())
 <div class="flash err" role="alert"><strong>Data belum dapat disimpan:</strong>
  <ul style="margin:6px 0 0 18px;padding:0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif
