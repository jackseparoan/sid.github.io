<div class="penduduk_luar_desa penduduk_luar_{{ $index }} {{ count($opsiSumberPenduduk) > 1 ? 'hide' : '' }}">
    <div class="form-group">
        <label class="col-sm-3 control-label"><strong>Nama Lengkap / NIK KTP</strong></label>
        <div class="col-sm-5 col-lg-6">
            <input {{ $kategori == 'individu' ? 'data-visible-required="1"' : '' }} name="{{ $kategori }}[nama]" class="form-control input-sm isi-penduduk-luar" type="text" placeholder="Nama Lengkap" />
        </div>
        <div class="col-sm-3 col-lg-2">
            <input {{ $kategori == 'individu' ? 'data-visible-required="1"' : '' }} name="{{ $kategori }}[nik]" class="form-control input-sm isi-penduduk-luar nik" type="text" placeholder="Nomor KTP" />
        </div>
    </div>
    @if (in_array('tempat_lahir', $input) && in_array('tanggal_lahir', $input))
        <div class="form-group">
            <label for="tempatlahir" class="col-sm-3 control-label">Tempat Tanggal Lahir</label>
            <div class="col-sm-5 col-lg-6">
                <input class="form-control input-sm" type="text" name="{{ $kategori }}[tempatlahir]" id="tempatlahir" placeholder="Tempat Lahir" />
            </div>
            <div class="col-sm-3 col-lg-2">
                <div class="input-group input-group-sm date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input title="Pilih Tanggal" class="form-control datepicker input-sm" name="{{ $kategori }}[tanggallahir]" type="text" placeholder="Tgl. Lahir" />
                </div>
            </div>
        </div>
    @elseif (in_array('tempat_lahir', $input))
        <div class="form-group">
            <label for="tempatlahir" class="col-sm-3 control-label">Tempat Lahir</label>
            <div class="col-sm-5 col-lg-6">
                <input class="form-control input-sm" type="text" name="{{ $kategori }}[tempatlahir]" id="tempatlahir" placeholder="Tempat Lahir" />
            </div>
        </div>
    @elseif (in_array('tanggal_lahir', $input))
        <div class="form-group">
            <label for="tempatlahir" class="col-sm-3 control-label">Tanggal Lahir</label>
            <div class="col-sm-3 col-lg-2">
                <div class="input-group input-group-sm date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input title="Pilih Tanggal" class="form-control datepicker input-sm" name="{{ $kategori }}[tanggallahir]" type="text" placeholder="Tgl. Lahir" />
                </div>
            </div>
        </div>
    @endif
    @if (in_array('jenis_kelamin', $input))
        <div class="form-group">
            <label for="tempatlahir" class="col-sm-3 control-label">Jenis Kelamin</label>
            <div class="col-sm-3">
                <select class="form-control input-sm select2" name="{{ $kategori }}[jenis_kelamin]">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    @foreach (\App\Models\Sex::get() as $data)
                        <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    @if (in_array('agama', $input))
        <div class="form-group">
            <label for="tempatlahir" class="col-sm-3 control-label">Agama</label>
            <div class="col-sm-3">
                <select class="form-control input-sm select2" name="{{ $kategori }}[agama]">
                    <option value="">-- Pilih Agama --</option>
                    @foreach (\App\Models\Agama::get() as $data)
                        <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    @if (in_array('pekerjaan', $input))
        <div class="form-group">
            <label for="tempatlahir" class="col-sm-3 control-label">Pekerjaan</label>
            <div class="col-sm-3">
                <select class="form-control input-sm select2" name="{{ $kategori }}[pekerjaan]">
                    <option value="">-- Pilih Pekerjaan --</option>
                    @foreach (\App\Models\Pekerjaan::get() as $data)
                        <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    @if (in_array('warga_negara', $input))
        <div class="form-group">
            <label for="tempatlahir" class="col-sm-3 control-label">Warga Negara</label>
            <div class="col-sm-3">
                <select class="form-control input-sm select2" name="{{ $kategori }}[warga_negara]">
                    <option value="">-- Pilih Warga Negara --</option>
                    @foreach (\App\Models\WargaNegara::get() as $data)
                        <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    @if (in_array('pendidikan_kk', $input))
        <div class="form-group">
            <label class="col-sm-3 control-label"><strong>Pendidikan Terakhir</strong></label>
            <div class="col-sm-3">
                <select class="form-control input-sm select2" name="{{ $kategori }}[pendidikan_kk]">
                    <option value="">-- Pilih Pendidikan Terakhir --</option>
                    @foreach (\App\Models\PendidikanKK::get() as $data)
                        <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    @if (in_array('alamat', $input))
        <div class="form-group">
            <label class="col-sm-3 control-label"><strong>Alamat</strong></label>
            <div class="col-sm-9 row">
                <div class="col-sm-12">
                    <input name="{{ $kategori }}[alamat_jalan]" class="form-control input-sm" type="text" placeholder="Alamat" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"><strong>Dusun / RT / RW</strong></label>
            <div class="col-sm-9 row">
                <div class="col-sm-6">
                    <input name="{{ $kategori }}[nama_dusun]" class="form-control input-sm" type="text" placeholder="Dusun" />
                </div>
                <div class="col-sm-3">
                    <input name="{{ $kategori }}[nama_rw]" class="form-control input-sm" type="text" placeholder="RW" />
                </div>
                <div class="col-sm-3">
                    <input name="{{ $kategori }}[nama_rt]" class="form-control input-sm" type="text" placeholder="RT" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"><strong>Desa / Kecamatan</strong></label>
            <div class="col-sm-9 row">
                <div class="col-sm-6">
                    <input name="{{ $kategori }}[pend_desa]" class="form-control input-sm" type="text" placeholder="Desa" />
                </div>
                <div class="col-sm-6">
                    <input name="{{ $kategori }}[pend_kecamatan]" class="form-control input-sm" type="text" placeholder="Kecamatan" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label"><strong>Kabupaten / Provinsi</strong></label>
            <div class="col-sm-9 row">
                <div class="col-sm-6">
                    <input name="{{ $kategori }}[pend_kabupaten]" class="form-control input-sm" type="text" placeholder="Kabupaten" />
                </div>
                <div class="col-sm-6">
                    <input name="{{ $kategori }}[pend_provinsi]" class="form-control input-sm" type="text" placeholder="Provinsi" />
                </div>
            </div>
        </div>
    @endif
</div>
