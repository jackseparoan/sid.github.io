{!! form_open_multipart(ci_route('setting.new_update'), 'class="form-group" id="main_setting"') !!}
<div class="modal-body">
    @foreach ($list_setting as $key => $pengaturan)
        @if ($pengaturan->jenis != 'upload' && $pengaturan->kategori == $kategori)
            <div class="form-group" id="form_{{ $pengaturan->key }}">
                <label>{{ $pengaturan->judul }}</label>
                @if ($pengaturan->jenis == 'option' || $pengaturan->jenis == 'boolean')
                    <select {!! $pengaturan->attribute ? str_replace('class="', 'class="form-control input-sm select2 required ', $pengaturan->attribute) : 'class="form-control input-sm select2 required"' !!} id="{{ $pengaturan->key }}" name="{{ $pengaturan->key }}">
                        @foreach ($pengaturan->option as $key => $value)
                            <option value="{{ $key }}" @selected($pengaturan->value == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                @elseif ($pengaturan->jenis == 'multiple-option')
                    <select class="form-control input-sm select2 required" name="{{ $pengaturan->key }}[]" multiple="multiple">
                        @foreach ($pengaturan->option as $val)
                            <option value="{{ $val }}" {{ in_array($val, json_decode($pengaturan->value)) ? 'selected' : '' }}>
                                {{ $val }}</option>
                        @endforeach
                    </select>
                @elseif ($pengaturan->jenis == 'datetime')
                    <div class="input-group input-group-sm date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input {!! $pengaturan->attribute ? str_replace('class="', 'class="form-control input-sm pull-right tgl_1 ', $pengaturan->attribute) : 'class="form-control input-sm pull-right tgl_1"' !!} id="{{ $pengaturan->key }}" name="{{ $pengaturan->key }}" type="text" value="{{ $pengaturan->value }}">
                    </div>
                @elseif ($pengaturan->jenis == 'unggah')
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" id="file_path" name="{{ $pengaturan->key }}">
                        <input type="file" class="hidden" id="file" name="{{ $pengaturan->key }}">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-info btn-sm" id="file_browser"><i class="fa fa-search"></i>&nbsp;</button>
                            <a href="{{ file_exists(FCPATH . $pengaturan->value) ? asset($pengaturan->value, false) : asset('images/kehadiran/bg.jpg') }}" class="btn btn-danger btn-sm" title="Lihat Gambar" target="_blank"><i class="fa fa-eye"></i>&nbsp;</a>
                        </span>
                    </div>
                @elseif ($pengaturan->jenis == 'textarea')
                    <textarea {!! $pengaturan->attribute ? str_replace('class="', 'class="form-control input-sm ', $pengaturan->attribute) : 'class="form-control input-sm"' !!} name="{{ $pengaturan->key }}" placeholder="{{ $pengaturan->keterangan }}" rows="5">{{ $pengaturan->value }}</textarea>
                @elseif ($pengaturan->jenis == 'referensi')
                    {{-- prettier-ignore-start --}}
                    <select class="form-control input-sm select2 required" name="{{ $pengaturan->key }}[]" multiple="multiple">
                        @php
                            $modelData = $pengaturan->option;
                            $referensiData = (new $modelData['model']())
                                ->select([$modelData['value'], $modelData['label']])
                                ->get()
                                ->toArray();
                            $selectedValue = json_decode($pengaturan->value, 1);
                        @endphp
                        <option value="-" @selected(empty($selectedValue))>Tanpa Referensi (kosong)</option>
                        @foreach ($referensiData as $val)
                            <option value="{{ $val[$modelData['value']] }}" @selected(in_array($val[$modelData['value']], $selectedValue))>{{ $val[$modelData['label']] }}</option>
                        @endforeach
                    </select>
                    {{-- prettier-ignore-end --}}
                @else
                    <input {!! $pengaturan->attribute ? str_replace('class="', 'class="form-control input-sm ', $pengaturan->attribute) : 'class="form-control input-sm"' !!} id="{{ $pengaturan->key }}" name="{{ $pengaturan->key }}" {{ strpos($pengaturan->attribute, 'type=') ? '' : 'type="text"' }} value="{{ $pengaturan->value }}" />
                @endif
                <label><code>{!! $pengaturan->keterangan !!}</code></label>
            </div>
        @endif
    @endforeach

</div>
<div class="modal-footer">
    {!! batal() !!}
    <button type="submit" class="btn btn-social btn-info btn-sm"><i class="fa fa-check"></i> Simpan</button>
</div>
</form>

@push('scripts')
    <script src="{{ asset('js/validasi.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#main_setting").validate();
        })
    </script>
@endpush
