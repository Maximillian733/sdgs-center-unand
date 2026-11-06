<fieldset style="border:0;padding:0;margin:14px 0"><legend style="font-weight:600;font-size:.9rem">Kategori SDGs</legend>
 <div class="sdgchk">
  @foreach ($sdgList as $s)
   <label><input type="checkbox" name="sdgs[]" value="{{ $s->id }}" @checked(in_array($s->id, old('sdgs', $selected ?? [])))> {{ $s->id }}. {{ $s->name_id }}</label>
  @endforeach
 </div>
</fieldset>
