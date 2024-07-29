<?php

/*
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package   OpenSID
 * @author    Tim Pengembang OpenDesa
 * @copyright Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */

defined('BASEPATH') || exit('No direct script access allowed');

// SITEMAN
Route::group('siteman', static function (): void {
    Route::get('/', 'Siteman@index');
    Route::post('/auth', 'Siteman@auth');
    Route::get('/logout', 'Siteman@logout');
    Route::get('/lupa_sandi', 'Siteman@lupa_sandi');
    Route::post('/kirim_lupa_sandi', 'Siteman@kirim_lupa_sandi');
    Route::get('/reset_kata_sandi', 'Siteman@reset_kata_sandi');
    Route::post('/verifikasi_sandi', 'Siteman@verifikasi_sandi');
});

// MAIN
Route::get('main', 'Main@index');

// Notif
Route::post('notif/update_pengumuman', 'Notif@update_pengumuman');

Route::group('pengguna', static function (): void {
    Route::post('/update', 'Pengguna@update')->name('pengguna.update');
    Route::post('/update_password', 'Pengguna@update_password')->name('pengguna.update_password');
    Route::match(['GET', 'POST'], '/kirim_verifikasi', 'Pengguna@kirim_verifikasi')->name('pengguna.kirim_verifikasi');
    Route::match(['GET', 'POST'], '/kirim_otp_telegram', 'Pengguna@kirim_otp_telegram')->name('pengguna.kirim_otp_telegram');
    Route::match(['GET', 'POST'], '/verifikasi_telegram', 'Pengguna@verifikasi_telegram')->name('pengguna.verifikasi_telegram');
    Route::match(['GET', 'POST'], '/verifikasi', 'Pengguna@verifikasi')->name('pengguna.verifikasi');
    Route::match(['GET', 'POST'], '/', 'Pengguna@index')->name('pengguna.index');
});

// MODULE
// Beranda
Route::get('beranda', 'Beranda@index');
Route::get('peringatan', 'Pelanggan@peringatan');

Route::group('periksa', static function (): void {
    Route::get('/', 'Periksa@index')->name('periksa.index');
    Route::post('/perbaiki', 'Periksa@perbaiki')->name('periksa.perbaiki');
    Route::match(['GET', 'POST'], '/perbaiki_sebagian/{masalah?}', 'Periksa@perbaiki_sebagian')->name('periksa.perbaiki_sebagian');
    Route::get('/login', 'Periksa@login')->name('periksa.login');
    Route::post('/auth', 'Periksa@auth')->name('periksa.auth');
});
Route::group('periksaKlasifikasiSurat', static function (): void {
    Route::get('/hapus', 'PeriksaKlasifikasiSurat@hapus')->name('periksaKlasifikasiSurat.hapus');
});
Route::group('periksaLogKeluarga', static function (): void {
    Route::get('/', 'PeriksaLogKeluarga@index')->name('periksaLogKeluarga.index');
    Route::post('/hapusLog', 'PeriksaLogKeluarga@hapusLog')->name('periksaLogKeluarga.hapusLog');
});
Route::group('periksaLogPenduduk', static function (): void {
    Route::get('/', 'PeriksaLogPenduduk@index')->name('periksaLogPenduduk.index');
    Route::post('/hapusLog', 'PeriksaLogPenduduk@hapusLog')->name('periksaLogPenduduk.hapusLog');
    Route::post('/updateStatusDasar', 'PeriksaLogPenduduk@updateStatusDasar')->name('periksaLogPenduduk.updateStatusDasar');
});

// Info Desa > Identitas Desa
Route::group('identitas_desa', static function (): void {
    Route::get('/', 'Identitas_desa@index')->name('identitas_desa.index');
    Route::get('/kosongkan', 'Identitas_desa@kosongkan')->name('identitas_desa.kosongkan');
    Route::get('/form', 'Identitas_desa@form')->name('identitas_desa.form');
    Route::post('/insert', 'Identitas_desa@insert')->name('identitas_desa.insert');
    Route::post('/update', 'Identitas_desa@update')->name('identitas_desa.update');
    Route::get('/maps/{tipe}', 'Identitas_desa@maps')->name('identitas_desa.maps');
    Route::post('/update_maps/{tipe}', 'Identitas_desa@update_maps')->name('identitas_desa.update_maps');
    Route::get('/reset', 'Identitas_desa@reset')->name('identitas_desa.reset');
});

// Info Desa > Wilayah Administratif
Route::group('wilayah', static function (): void {
    Route::get('/datatables', 'Wilayah@datatables')->name('wilayah.datatables');
    Route::post('/tukar', 'Wilayah@tukar')->name('wilayah.tukar');
    Route::match(['GET', 'POST'], '/form_dusun/{level?}/{parent?}/{id?}', 'Wilayah@form_dusun')->name('wilayah.form_dusun');
    Route::match(['GET', 'POST'], '/form_rw/{level?}/{parent?}/{id?}', 'Wilayah@form_rw')->name('wilayah.form_rw');
    Route::match(['GET', 'POST'], '/form_rt/{level?}/{parent?}/{id?}', 'Wilayah@form_rt')->name('wilayah.form_rt');
    Route::get('/apipendudukwilayah', 'Wilayah@apipendudukwilayah')->name('wilayah.apipendudukwilayah');
    Route::get('/dialog/{aksi?}', 'Wilayah@dialog')->name('wilayah.dialog');
    Route::post('/daftar/{aksi?}', 'Wilayah@daftar')->name('wilayah.daftar');
    Route::match(['GET', 'POST'], '/index/{parent?}/{level?}', 'Wilayah@index')->name('wilayah.index-page');
    Route::match(['GET', 'POST'], '/', 'Wilayah@index')->name('wilayah.index');
    Route::post('/insert/{level?}/{parent?}', 'Wilayah@insert')->name('wilayah.insert');
    Route::post('/update/{level?}/{id?}/{parent?}', 'Wilayah@update')->name('wilayah.update');
    Route::get('/delete/{level?}/{id?}', 'Wilayah@delete')->name('wilayah.delete');
    Route::get('/cetak_rw/{id?}', 'Wilayah@cetak_rw')->name('wilayah.cetak_rw');
    Route::get('/unduh_rw/{id?}', 'Wilayah@unduh_rw')->name('wilayah.unduh_rw');
    Route::get('/cetak_rt/{id?}', 'Wilayah@cetak_rt')->name('wilayah.cetak_rt');
    Route::get('/unduh_rt/{id?}', 'Wilayah@unduh_rt')->name('wilayah.unduh_rt');
    Route::get('/ajax_kantor_dusun_maps/{id?}', 'Wilayah@ajax_kantor_dusun_maps')->name('wilayah.ajax_kantor_dusun_maps');
    Route::get('/ajax_wilayah_dusun_maps/{id?}', 'Wilayah@ajax_wilayah_dusun_maps')->name('wilayah.ajax_wilayah_dusun_maps');
    Route::get('/ajax_kantor_rw_maps/{id?}/{dusun?}', 'Wilayah@ajax_kantor_rw_maps')->name('wilayah.ajax_kantor_rw_maps');
    Route::get('/ajax_wilayah_rw_maps/{id?}/{dusun?}', 'Wilayah@ajax_wilayah_rw_maps')->name('wilayah.ajax_wilayah_rw_maps');
    Route::get('/ajax_kantor_rt_maps/{id?}/{rw?}', 'Wilayah@ajax_kantor_rt_maps')->name('wilayah.ajax_kantor_rt_maps');
    Route::get('/ajax_wilayah_rt_maps/{id?}/{rw?}', 'Wilayah@ajax_wilayah_rt_maps')->name('wilayah.ajax_wilayah_rt_maps');
    Route::post('/update_kantor_map/{level?}/{id?}/{parent?}', 'Wilayah@update_kantor_map')->name('wilayah.update_kantor_map');
    Route::post('/update_wilayah_map/{level?}/{id?}/{parent?}', 'Wilayah@update_wilayah_map')->name('wilayah.update_wilayah_map');
    Route::get('/kosongkan/{id?}', 'Wilayah@kosongkan')->name('wilayah.kosongkan');
    Route::get('/list_rw/{dusun?}', 'Wilayah@list_rw')->name('wilayah.list_rw');
    Route::get('/list_rt/{dusun?}/{rw?}', 'Wilayah@list_rt')->name('wilayah.list_rt');
    Route::post('/ubah_lokasi_peta/{wilayah?}/{to?}/{msg?}', 'Wilayah@ubah_lokasi_peta')->name('wilayah.ubah_lokasi_peta');
    Route::get('/warga/{id?}', 'Wilayah@warga')->name('wilayah.warga');
    Route::get('/warga_kk/{id?}', 'Wilayah@warga_kk')->name('wilayah.warga_kk');
    Route::get('/warga_l/{id?}', 'Wilayah@warga_l')->name('wilayah.warga_l');
    Route::get('/warga_p/{id?}', 'Wilayah@warga_p')->name('wilayah.warga_p');
});

Route::post('/notif/update_pengumuman', 'Notif@update_pengumuman')->name('notif.update_pengumuman');

// Info Desa > Status Desa
Route::group('status_desa', static function (): void {
    Route::get('/', 'Status_desa@index')->name('status_desa.index');
    Route::post('/', 'Status_desa@index')->name('status_desa.index_post');
    Route::get('/perbarui_idm/{tahun}', 'Status_desa@perbarui_idm')->name('status_desa.perbarui_idm');
    Route::get('/simpan/{tahun}', 'Status_desa@simpan')->name('status_desa.simpan');
    Route::post('/perbarui_bps', 'Status_desa@perbarui_bps')->name('status_desa.perbarui_bps');
    Route::get('/perbarui_sdgs', 'Status_desa@perbarui_sdgs')->name('status_desa.perbarui_sdgs');
    Route::get('/navigasi/{navigasi}', 'Status_desa@navigasi')->name('status_desa.navigasi');
});

// Info Desa > Lembaga Desa
Route::group('lembaga_master', static function (): void {
    Route::get('/', 'Lembaga_master@index')->name('lembaga_master.index');
    Route::get('/clear', 'Lembaga_master@clear')->name('lembaga_master.clear');
    Route::get('/form/{id?}', 'Lembaga_master@form')->name('lembaga_master.form');
    Route::post('/insert', 'Lembaga_master@insert')->name('lembaga_master.insert');
    Route::post('/update/{id}', 'Lembaga_master@update')->name('lembaga_master.update');
    Route::get('/delete/{id?}', 'Lembaga_master@delete')->name('lembaga_master.delete');
    Route::post('/delete_all', 'Lembaga_master@delete_all')->name('lembaga_master.delete_all');
});

Route::group('lembaga', static function (): void {
    Route::get('/to_master/{id?}', 'Lembaga@to_master')->name('lembaga.to_master');
    Route::get('/clear', 'Lembaga@clear')->name('lembaga.clear');
    Route::get('/anggota/{id?}/{p?}/{o?}', 'Lembaga@anggota')->name('lembaga.anggota');
    Route::get('/form/{p?}/{o?}/{id?}', 'Lembaga@form')->name('lembaga.form');
    Route::get('/aksi/{aksi?}/{id?}', 'Lembaga@aksi')->name('lembaga.aksi');
    Route::get('/form_anggota/{id?}/{id_a?}', 'Lembaga@form_anggota')->name('lembaga.form_anggota');
    Route::get('/dialog/{aksi?}', 'Lembaga@dialog')->name('lembaga.dialog');
    Route::post('/daftar/{aksi?}', 'Lembaga@daftar')->name('lembaga.daftar');
    Route::get('/dialog_anggota/{aksi?}/{id?}', 'Lembaga@dialog_anggota')->name('lembaga.dialog_anggota');
    Route::post('/daftar_anggota/{aksi?}/{id?}', 'Lembaga@daftar_anggota')->name('lembaga.daftar_anggota');
    Route::post('/filter/{filter}', 'Lembaga@filter')->name('lembaga.filter');
    Route::post('/insert', 'Lembaga@insert')->name('lembaga.insert');
    Route::post('/update/{p?}/{o?}/{id?}', 'Lembaga@update')->name('lembaga.update');
    Route::get('/delete/{id?}', 'Lembaga@delete')->name('lembaga.delete');
    Route::post('/delete_all', 'Lembaga@delete_all')->name('lembaga.delete_all');
    Route::post('/insert_a/{id?}', 'Lembaga@insert_a')->name('lembaga.insert_a');
    Route::post('/update_a/{id?}/{id_a?}', 'Lembaga@update_a')->name('lembaga.update_a');
    Route::get('/delete_anggota/{id?}/{a?}', 'Lembaga@delete_anggota')->name('lembaga.delete_anggota');
    Route::post('/delete_anggota_all/{id?}', 'Lembaga@delete_anggota_all')->name('lembaga.delete_anggota_all');
    Route::get('/statistik/{tipe?}/{nomor?}/{sex?}', 'Lembaga@statistik')->name('lembaga.statistik');
    Route::match(['GET', 'POST'], '/index', 'Lembaga@index');
    Route::match(['GET', 'POST'], '/index/{p?}/{o?}', 'Lembaga@index');
    Route::match(['GET', 'POST'], '/index/{p?}', 'Lembaga@index');
    Route::match(['GET', 'POST'], '/', 'Lembaga@index');
});

// Info Desa - Pelanggan
Route::group('pelanggan', static function (): void {
    Route::get('/', 'Pelanggan@index')->name('pelanggan.index');
    Route::get('/perbarui', 'Pelanggan@perbarui')->name('pelanggan.perbarui');
    Route::get('/perpanjang_layanan', 'Pelanggan@perpanjang_layanan')->name('pelanggan.perpanjang_layanan');
    Route::post('/perpanjang', 'Pelanggan@perpanjang')->name('pelanggan.perpanjang');
    Route::post('/pemesanan', 'Pelanggan@pemesanan')->name('pelanggan.pemesanan');
});

// Info Desa > Pendaftaran Kerjasama
Route::group('pendaftaran_kerjasama', static function (): void {
    Route::get('/', 'Pendaftaran_kerjasama@index')->name('pendaftaran_kerjasama.index');
    Route::post('/form', 'Pendaftaran_kerjasama@form')->name('pendaftaran_kerjasama.form');
    Route::post('/terdaftar', 'Pendaftaran_kerjasama@terdaftar')->name('pendaftaran_kerjasama.terdaftar');
    Route::post('/register', 'Pendaftaran_kerjasama@register')->name('pendaftaran_kerjasama.register');
    Route::get('/dokumen_template', 'Pendaftaran_kerjasama@dokumen_template')->name('pendaftaran_kerjasama.dokumen_template');
});

// Kependudukan > Penduduk
Route::group('penduduk', static function (): void {
    Route::get('/clear', 'Penduduk@clear')->name('penduduk.clear');
    Route::get('/ambil_foto', 'Penduduk@ambil_foto')->name('penduduk.ambil_foto');
    Route::get('/form_peristiwa/{periswita?}', 'Penduduk@form_peristiwa')->name('penduduk.form_peristiwa');
    Route::get('/form/{p?}/{o?}/{id?}', 'Penduduk@form')->name('penduduk.form');
    Route::get('/detail/{p?}/{o?}/{id?}', 'Penduduk@detail')->name('penduduk.detail');
    Route::get('/dokumen/{id?}', 'Penduduk@dokumen')->name('penduduk.dokumen');
    Route::get('/dokumen_datatables', 'Penduduk@dokumen_datatables')->name('penduduk.dokumen_datatables');
    Route::get('/dokumen_form/{id?}/{id_dokumen?}', 'Penduduk@dokumen_form')->name('penduduk.dokumen_form');
    Route::get('/dokumen_list/{id?}', 'Penduduk@dokumen_list')->name('penduduk.dokumen_list');
    Route::post('/dokumen_insert', 'Penduduk@dokumen_insert')->name('penduduk.dokumen_insert');
    Route::post('/dokumen_update/{id?}', 'Penduduk@dokumen_update')->name('penduduk.dokumen_update');
    Route::match(['GET', 'POST'], '/delete_dokumen/{id_pend?}/{id?}', 'Penduduk@delete_dokumen')->name('penduduk.delete_dokumen');
    Route::get('/cetak_biodata/{id?}', 'Penduduk@cetak_biodata')->name('penduduk.cetak_biodata');
    Route::post('/filter/{filter}', 'Penduduk@filter')->name('penduduk.filter');
    Route::get('/nik_sementara', 'Penduduk@nik_sementara')->name('penduduk.nik_sementara');
    Route::post('/insert', 'Penduduk@insert')->name('penduduk.insert');
    Route::post('/update/{p?}/{o?}/{id?}', 'Penduduk@update')->name('penduduk.update');
    Route::get('/delete/{p?}/{o?}/{id?}', 'Penduduk@delete')->name('penduduk.delete');
    Route::post('/delete_all/{p?}/{o?}', 'Penduduk@delete_all')->name('penduduk.delete_all');
    Route::get('/ajax_adv_search', 'Penduduk@ajax_adv_search')->name('penduduk.ajax_adv_search');
    Route::post('/adv_search_proses', 'Penduduk@adv_search_proses')->name('penduduk.adv_search_proses');
    Route::get('/ajax_penduduk_pindah_rw/{dusun?}', 'Penduduk@ajax_penduduk_pindah_rw')->name('penduduk.ajax_penduduk_pindah_rw');
    Route::get('/ajax_penduduk_pindah_rt/{dusun?}/{rw?}', 'Penduduk@ajax_penduduk_pindah_rt')->name('penduduk.ajax_penduduk_pindah_rt');
    Route::get('/ajax_penduduk_cari_rw/{dusun?}', 'Penduduk@ajax_penduduk_cari_rw')->name('penduduk.ajax_penduduk_cari_rw');
    Route::get('/ajax_penduduk_maps/{p?}/{o?}/{id?}/{edit?}', 'Penduduk@ajax_penduduk_maps')->name('penduduk.ajax_penduduk_maps');
    Route::post('/update_maps/{p?}/{o?}/{id?}/{edit?}', 'Penduduk@update_maps')->name('penduduk.update_maps');
    Route::get('/edit_status_dasar/{p?}/{o?}/{id?}', 'Penduduk@edit_status_dasar')->name('penduduk.edit_status_dasar');
    Route::post('/update_status_dasar/{p?}/{o?}/{id?}', 'Penduduk@update_status_dasar')->name('penduduk.update_status_dasar');
    Route::get('/kembalikan_status/{p?}/{o?}/{id?}', 'Penduduk@kembalikan_status')->name('penduduk.kembalikan_status');
    Route::get('/cetak/{p?}/{o?}/{aksi?}/{privasi_nik?}', 'Penduduk@cetak')->name('penduduk.cetak');
    Route::get('/statistik/{tipe?}/{nomor?}/{sex?}', 'Penduduk@statistik')->name('penduduk.statistik');
    Route::get('/lap_statistik/{id_cluster?}/{tipe?}/{no?}', 'Penduduk@lap_statistik')->name('penduduk.lap_statistik');
    Route::post('/autocomplete', 'Penduduk@autocomplete')->name('penduduk.autocomplete');
    Route::get('/search_kumpulan_nik', 'Penduduk@search_kumpulan_nik')->name('penduduk.search_kumpulan_nik');
    Route::get('/ajax_cetak/{p?}/{o?}/{aksi?}', 'Penduduk@ajax_cetak')->name('penduduk.ajax_cetak');
    Route::get('/program_bantuan', 'Penduduk@program_bantuan')->name('penduduk.program_bantuan');
    Route::post('/program_bantuan_proses', 'Penduduk@program_bantuan_proses')->name('penduduk.program_bantuan_proses');
    Route::get('/unduh_berkas/{id_dokumen?}/{tampil?}', 'Penduduk@unduh_berkas')->name('penduduk.unduh_berkas');
    Route::get('/impor', 'Penduduk@impor')->name('penduduk.impor');
    Route::post('/proses_impor', 'Penduduk@proses_impor')->name('penduduk.proses_impor');
    Route::get('/impor_bip', 'Penduduk@impor_bip')->name('penduduk.impor_bip');
    Route::post('/proses_impor_bip', 'Penduduk@proses_impor_bip')->name('penduduk.proses_impor_bip');
    Route::get('/ekspor/{huruf?}', 'Penduduk@ekspor')->name('penduduk.ekspor');
    Route::get('/foto_bawaan/{id}', 'Penduduk@foto_bawaan')->name('penduduk.foto_bawaan');
    Route::match(['GET', 'POST'], '/index', 'Penduduk@index');
    Route::match(['GET', 'POST'], '/index/{p?}/{o?}', 'Penduduk@index');
    Route::match(['GET', 'POST'], '/index/{p?}', 'Penduduk@index');
    Route::match(['GET', 'POST'], '/', 'Penduduk@index');
});

// Kependudukan > Penduduk > Log Penduduk
Route::group('penduduk_log', static function (): void {
    Route::get('/clear', 'Penduduk_log@clear')->name('penduduk_log.clear');
    Route::match(['GET', 'POST'], '/', 'Penduduk_log@index')->name('penduduk_log.index');
    Route::match(['GET', 'POST'], '/index', 'Penduduk_log@index');
    Route::match(['GET', 'POST'], '/index/{p}', 'Penduduk_log@index');
    Route::match(['GET', 'POST'], '/index/{p}/{o}', 'Penduduk_log@index');
    Route::post('/filter/{kode_peristiwa?}', 'Penduduk_log@filter')->name('penduduk_log.filter');
    Route::post('/dusun', 'Penduduk_log@dusun')->name('penduduk_log.dusun');
    Route::post('/rw', 'Penduduk_log@rw')->name('penduduk_log.rw');
    Route::post('/rt', 'Penduduk_log@rt')->name('penduduk_log.rt');
    Route::post('/tahun_bulan', 'Penduduk_log@tahun_bulan')->name('penduduk_log.tahun_bulan');
    Route::get('/edit/{p}/{o}/{id?}', 'Penduduk_log@edit')->name('penduduk_log.edit');
    Route::post('/update/{p}/{o}/{id?}', 'Penduduk_log@update')->name('penduduk_log.update');
    Route::get('/kembalikan_status/{id}', 'Penduduk_log@kembalikan_status')->name('penduduk_log.kembalikan_status');
    Route::get('/ajax_kembalikan_status_pergi/{id?}', 'Penduduk_log@ajax_kembalikan_status_pergi')->name('penduduk_log.ajax_kembalikan_status_pergi');
    Route::post('/kembalikan_status_pergi/{id?}', 'Penduduk_log@kembalikan_status_pergi')->name('penduduk_log.kembalikan_status_pergi');
    Route::post('/kembalikan_status_all', 'Penduduk_log@kembalikan_status_all')->name('penduduk_log.kembalikan_status_all');
    Route::get('/cetak/{o}/{aksi}/{privasi_nik?}', 'Penduduk_log@cetak')->name('penduduk_log.cetak');
    Route::get('/ajax_cetak/{o}/{aksi}', 'Penduduk_log@ajax_cetak')->name('penduduk_log.ajax_cetak');
});

// Kependudukan > Keluarga
Route::group('keluarga', static function (): void {
    Route::get('/clear_session', 'Keluarga@clear_session')->name('keluarga.clear_session');
    Route::get('/clear', 'Keluarga@clear')->name('keluarga.clear');
    Route::post('/autocomplete', 'Keluarga@autocomplete')->name('keluarga.autocomplete');
    Route::get('/cetak/{p?}/{o?}/{aksi?}/{privasi_kk?}', 'Keluarga@cetak')->name('keluarga.cetak');
    Route::get('/form_peristiwa/{peristiwa?}', 'Keluarga@form_peristiwa')->name('keluarga.form_peristiwa');
    Route::get('/form_peristiwa_a/{peristiwa?}/{p?}/{o?}/{id?}', 'Keluarga@form_peristiwa_a')->name('keluarga.form_peristiwa_a');
    Route::get('/form/{p?}/{o?}', 'Keluarga@form')->name('keluarga.form');
    Route::get('/form_a/{p?}/{o?}/{id?}', 'Keluarga@form_a')->name('keluarga.form_a');
    Route::get('/edit_nokk/{p?}/{o?}/{id?}', 'Keluarga@edit_nokk')->name('keluarga.edit_nokk');
    Route::get('/form_old/{p?}/{o?}/{id?}', 'Keluarga@form_old')->name('keluarga.form_old');
    Route::get('/pindah_kolektif', 'Keluarga@pindah_kolektif')->name('keluarga.pindah_kolektif');
    Route::match(['GET', 'POST'], '/proses_pindah', 'Keluarga@proses_pindah')->name('keluarga.proses_pindah');
    Route::post('/filter/{filter}', 'Keluarga@filter')->name('keluarga.filter');
    Route::match(['GET', 'POST'], '/dusun', 'Keluarga@dusun')->name('keluarga.dusun');
    Route::match(['GET', 'POST'], '/rw', 'Keluarga@rw')->name('keluarga.rw');
    Route::match(['GET', 'POST'], '/rt', 'Keluarga@rt')->name('keluarga.rt');
    Route::post('/insert/{id?}', 'Keluarga@insert')->name('keluarga.insert');
    Route::match(['GET', 'POST'], '/insert_a', 'Keluarga@insert_a')->name('keluarga.insert_a');
    Route::match(['GET', 'POST'], '/insert_new', 'Keluarga@insert_new')->name('keluarga.insert_new');
    Route::post('/update_nokk/{id?}', 'Keluarga@update_nokk')->name('keluarga.update_nokk');
    Route::get('/delete/{p?}/{o?}/{id?}', 'Keluarga@delete')->name('keluarga.delete');
    Route::post('/delete_all', 'Keluarga@delete_all')->name('keluarga.delete_all');
    Route::get('/anggota/{p?}/{o?}/{id?}', 'Keluarga@anggota')->name('keluarga.anggota');
    Route::get('/ajax_add_anggota/{p?}/{o?}/{id?}', 'Keluarga@ajax_add_anggota')->name('keluarga.ajax_add_anggota');
    Route::get('/edit_anggota/{p?}/{o?}/{id_kk?}/{id?}', 'Keluarga@edit_anggota')->name('keluarga.edit_anggota');
    Route::get('/kartu_keluarga/{p?}/{o?}/{id?}', 'Keluarga@kartu_keluarga')->name('keluarga.kartu_keluarga');
    Route::get('/cetak_kk/{id?}', 'Keluarga@cetak_kk')->name('keluarga.cetak_kk');
    Route::post('/cetak_kk_all', 'Keluarga@cetak_kk_all')->name('keluarga.cetak_kk_all');
    Route::get('/doc_kk/{id?}', 'Keluarga@doc_kk')->name('keluarga.doc_kk');
    Route::post('/doc_kk_all/{id?}', 'Keluarga@doc_kk_all')->name('keluarga.doc_kk_all');
    Route::post('/add_anggota/{p?}/{o?}/{id?}', 'Keluarga@add_anggota')->name('keluarga.add_anggota');
    Route::post('/update_anggota/{p?}/{o?}/{id_kk?}/{id?}', 'Keluarga@update_anggota')->name('keluarga.update_anggota');
    Route::get('/delete_anggota/{p?}/{o?}/{kk?}/{id?}', 'Keluarga@delete_anggota')->name('keluarga.delete_anggota');
    Route::get('/keluarkan_anggota/{kk?}/{id?}', 'Keluarga@keluarkan_anggota')->name('keluarga.keluarkan_anggota');
    Route::post('/delete_all_anggota/{p?}/{o?}/{kk?}', 'Keluarga@delete_all_anggota')->name('keluarga.delete_all_anggota');
    Route::get('/statistik/{tipe?}/{nomor?}/{sex?}', 'Keluarga@statistik')->name('keluarga.statistik');
    Route::get('/cetak_statistik/{tipe?}', 'Keluarga@cetak_statistik')->name('keluarga.cetak_statistik');
    Route::get('/search_kumpulan_kk', 'Keluarga@search_kumpulan_kk')->name('keluarga.search_kumpulan_kk');
    Route::get('/ajax_cetak/{p?}/{o?}/{aksi?}', 'Keluarga@ajax_cetak')->name('keluarga.ajax_cetak');
    Route::get('/program_bantuan', 'Keluarga@program_bantuan')->name('keluarga.program_bantuan');
    Route::post('/program_bantuan_proses', 'Keluarga@program_bantuan_proses')->name('keluarga.program_bantuan_proses');
    Route::get('/nokk_sementara', 'Keluarga@nokk_sementara')->name('keluarga.nokk_sementara');
    Route::get('/form_pecah_semua/{id?}', 'Keluarga@form_pecah_semua')->name('keluarga.form_pecah_semua');
    Route::match(['GET', 'POST'], '/pecah_semua/{id?}', 'Keluarga@pecah_semua')->name('keluarga.pecah_semua');
    Route::match(['GET', 'POST'], '/index', 'Keluarga@index');
    Route::match(['GET', 'POST'], '/index/{p?}/{o?}', 'Keluarga@index');
    Route::match(['GET', 'POST'], '/index/{p?}', 'Keluarga@index');
    Route::match(['GET', 'POST'], '/', 'Keluarga@index');
});

// Kependudukan > Rumah Tangga
Route::group('rtm', static function (): void {
    Route::get('/clear', 'Rtm@clear')->name('rtm.clear');
    Route::get('/daftar/{aksi?}/{privasi_nik?}', 'Rtm@daftar')->name('rtm.daftar');
    Route::get('/edit_nokk/{id?}', 'Rtm@edit_nokk')->name('rtm.edit_nokk');
    Route::get('/form_old/{id?}', 'Rtm@form_old')->name('rtm.form_old');
    Route::get('/apipendudukrtm', 'Rtm@apipendudukrtm')->name('rtm.apipendudukrtm');
    Route::post('/filter/{filter?}/{o?}', 'Rtm@filter')->name('rtm.filter');
    Route::post('/dusun', 'Rtm@dusun')->name('rtm.dusun');
    Route::post('/rw', 'Rtm@rw')->name('rtm.rw');
    Route::post('/rt', 'Rtm@rt')->name('rtm.rt');
    Route::post('/insert', 'Rtm@insert')->name('rtm.insert');
    Route::post('/insert_by_kk', 'Rtm@insert_by_kk')->name('rtm.insert_by_kk');
    Route::post('/insert_a', 'Rtm@insert_a')->name('rtm.insert_a');
    Route::match(['GET', 'POST'], '/insert_new', 'Rtm@insert_new')->name('rtm.insert_new');
    Route::post('/update/{id?}', 'Rtm@update')->name('rtm.update');
    Route::post('/update_nokk/{id?}', 'Rtm@update_nokk')->name('rtm.update_nokk');
    Route::get('/delete/{id?}', 'Rtm@delete')->name('rtm.delete');
    Route::post('/delete_all', 'Rtm@delete_all')->name('rtm.delete_all');
    Route::get('/anggota/{id?}', 'Rtm@anggota')->name('rtm.anggota');
    Route::get('/ajax_add_anggota/{id?}', 'Rtm@ajax_add_anggota')->name('rtm.ajax_add_anggota');
    Route::get('/datables_anggota/{id?}', 'Rtm@datables_anggota')->name('rtm.datables_anggota');
    Route::get('/edit_anggota/{id_rtm?}/{id?}', 'Rtm@edit_anggota')->name('rtm.edit_anggota');
    Route::get('/kartu_rtm/{id?}', 'Rtm@kartu_rtm')->name('rtm.kartu_rtm');
    Route::get('/cetak_kk/{id?}', 'Rtm@cetak_kk')->name('rtm.cetak_kk');
    Route::post('/add_anggota/{id?}', 'Rtm@add_anggota')->name('rtm.add_anggota');
    Route::post('/update_anggota/{id_rtm?}/{id?}', 'Rtm@update_anggota')->name('rtm.update_anggota');
    Route::get('/delete_anggota/{kk?}/{id?}', 'Rtm@delete_anggota')->name('rtm.delete_anggota');
    Route::post('/delete_all_anggota/{kk?}', 'Rtm@delete_all_anggota')->name('rtm.delete_all_anggota');
    Route::get('/ajax_cetak/{aksi?}', 'Rtm@ajax_cetak')->name('rtm.ajax_cetak');
    Route::get('/statistik/{tipe?}/{no?}/{sex?}', 'Rtm@statistik')->name('rtm.statistik');
    Route::post('/impor', 'Rtm@impor')->name('rtm.impor');
    Route::match(['GET', 'POST'], '/index', 'Rtm@index');
    Route::match(['GET', 'POST'], '/index/{p?}/{o?}', 'Rtm@index');
    Route::match(['GET', 'POST'], '/index/{p?}', 'Rtm@index');
    Route::match(['GET', 'POST'], '/', 'Rtm@index');
});

Route::group('kelompok_master', static function (): void {
    Route::get('/', 'Kelompok_master@index')->name('kelompok_master.index');
    Route::get('/datatables', 'Kelompok_master@datatables')->name('kelompok_master.datatables');
    Route::get('/form/{id?}', 'Kelompok_master@form')->name('kelompok_master.form');
    Route::post('/insert', 'kelompok_master@insert')->name('kelompok_master.insert');
    Route::post('/update/{id?}', 'kelompok_master@update')->name('kelompok_master.update');
    Route::get('/delete/{id?}', 'kelompok_master@delete')->name('kelompok_master.delete');
    Route::post('/delete_all/{id_kelompok?}', 'kelompok_master@delete_all')->name('kelompok_master.delete_all');
});

Route::group('kelompok_anggota', static function (): void {
    Route::get('/detail/{id?}', 'Kelompok_anggota@detail')->name('kelompok_anggota.detail');
    Route::get('/aksi/{aksi?}/{id?}', 'Kelompok_anggota@aksi')->name('kelompok_anggota.aksi');
    Route::get('/datatables', 'Kelompok_anggota@datatables')->name('kelompok_anggota.datatables');
    Route::get('/form/{id_kelompok?}/{id?}', 'Kelompok_anggota@form')->name('kelompok_anggota.form');
    Route::post('/insert/{id?}', 'kelompok_anggota@insert')->name('kelompok_anggota.insert');
    Route::post('/update/{id_kelompok?}/{id?}', 'kelompok_anggota@update')->name('kelompok_anggota.update');
    Route::get('/delete/{id_kelompok?}/{id?}', 'kelompok_anggota@delete')->name('kelompok_anggota.delete');
    Route::get('/dialog/{aksi?}/{id?}', 'kelompok_anggota@dialog')->name('kelompok_anggota.dialog');
    Route::post('/daftar/{aksi?}/{id?}', 'kelompok_anggota@daftar')->name('kelompok_anggota.daftar');
    Route::post('/delete_all/{id_kelompok?}', 'kelompok_anggota@delete_all')->name('kelompok_anggota.delete_all');
});

Route::group('lembaga_anggota', static function (): void {
    Route::get('/detail/{id?}', 'Lembaga_anggota@detail')->name('lembaga_anggota.detail');
    Route::get('/aksi/{aksi?}/{id?}', 'Lembaga_anggota@aksi')->name('lembaga_anggota.aksi');
    Route::get('/datatables', 'Lembaga_anggota@datatables')->name('lembaga_anggota.datatables');
    Route::get('/form/{id_kelompok?}/{id?}', 'Lembaga_anggota@form')->name('lembaga_anggota.form');
    Route::post('/insert/{id?}', 'Lembaga_anggota@insert')->name('lembaga_anggota.insert');
    Route::post('/update/{id_kelompok?}/{id?}', 'Lembaga_anggota@update')->name('lembaga_anggota.update');
    Route::get('/delete/{id_kelompok?}/{id?}', 'Lembaga_anggota@delete')->name('lembaga_anggota.delete');
    Route::get('/dialog/{aksi?}/{id?}', 'Lembaga_anggota@dialog')->name('lembaga_anggota.dialog');
    Route::post('/daftar/{aksi?}/{id?}', 'Lembaga_anggota@daftar')->name('lembaga_anggota.daftar');
    Route::post('/delete_all/{id_kelompok?}', 'Lembaga_anggota@delete_all')->name('lembaga_anggota.delete_all');
});

// Kependudukan > Kelompok
Route::group('kelompok', static function (): void {
    Route::get('/apipendudukkelompok', 'Kelompok@apipendudukkelompok')->name('kelompok.apipendudukkelompok');
    Route::get('/to_master/{id?}', 'Kelompok@to_master')->name('kelompok.to_master');
    Route::get('/clear', 'Kelompok@clear')->name('kelompok.clear');
    Route::get('/form/{p?}/{o?}/{id?}', 'Kelompok@form')->name('kelompok.form');
    Route::get('/aksi/{aksi?}/{id?}', 'Kelompok@aksi')->name('kelompok.aksi');
    Route::get('/dialog/{aksi?}', 'Kelompok@dialog')->name('kelompok.dialog');
    Route::post('/daftar/{aksi?}', 'Kelompok@daftar')->name('kelompok.daftar');
    Route::post('/filter/{filter}', 'Kelompok@filter')->name('kelompok.filter');
    Route::post('/insert', 'Kelompok@insert')->name('kelompok.insert');
    Route::post('/update/{p?}/{o?}/{id?}', 'Kelompok@update')->name('kelompok.update');
    Route::get('/delete/{id?}', 'Kelompok@delete')->name('kelompok.delete');
    Route::post('/delete_all', 'Kelompok@delete_all')->name('kelompok.delete_all');
    Route::get('/statistik/{tipe?}/{nomor?}/{sex?}', 'Kelompok@statistik')->name('kelompok.statistik');
    Route::match(['GET', 'POST'], '/index', 'Kelompok@index');
    Route::match(['GET', 'POST'], '/index/{p?}/{o?}', 'Kelompok@index');
    Route::match(['GET', 'POST'], '/index/{p?}', 'Kelompok@index');
    Route::match(['GET', 'POST'], '/', 'Kelompok@index');
});

// Kependudukan > Data Suplemen
Route::group('suplemen', static function (): void {
    Route::get('/', 'Suplemen@index')->name('suplemen.index');
    Route::get('/datatables', 'Suplemen@datatables')->name('suplemen.datatables');
    Route::get('/form/{id?}', 'Suplemen@form')->name('suplemen.form');
    Route::post('/create', 'Suplemen@create')->name('suplemen.create');
    Route::post('/update/{id}', 'Suplemen@update')->name('suplemen.update');
    Route::get('/delete/{id}', 'Suplemen@delete')->name('suplemen.delete');
    Route::get('/rincian/{id}', 'Suplemen@rincian')->name('suplemen.rincian');
    Route::get('/datatables_terdata', 'Suplemen@datatables_terdata')->name('suplemen.datatables_terdata');
    Route::match(['GET', 'POST'], '/form_terdata/{suplemen}/{aksi}/{id?}', 'Suplemen@form_terdata')->name('suplemen.form_terdata');
    Route::post('/create_terdata/{aksi}', 'Suplemen@create_terdata')->name('suplemen.create_terdata');
    Route::post('/update_terdata/{id}', 'Suplemen@update_terdata')->name('suplemen.update_terdata');
    Route::get('/delete_terdata/{id}', 'Suplemen@delete_terdata')->name('suplemen.delete_terdata');
    Route::post('/delete_all_terdata', 'Suplemen@delete_all_terdata')->name('suplemen.delete_all_terdata');
    Route::get('/apipenduduksuplemen', 'Suplemen@apipenduduksuplemen')->name('suplemen.apipenduduksuplemen');
    Route::get('/dialog_daftar/{id}/{aksi}', 'Suplemen@dialog_daftar')->name('suplemen.dialog_daftar');
    Route::post('/daftar/{id}/{aksi}', 'Suplemen@daftar')->name('suplemen.daftar');
    Route::get('/impor_data/{id}', 'Suplemen@impor_data')->name('suplemen.impor_data');
    Route::post('/impor', 'Suplemen@impor')->name('suplemen.impor');
    Route::get('/ekspor/{id}', 'Suplemen@ekspor')->name('suplemen.ekspor');
});

// Kependudukan > Calon Pemilih
Route::group('dpt', static function (): void {
    Route::get('/', 'Dpt@index')->name('dpt.index');
    Route::get('/datatables', 'Dpt@datatables')->name('dpt.datatables');
    Route::get('/ajax_cetak/{aksi?}', 'Dpt@ajax_cetak')->name('dpt.ajax_cetak');
    Route::post('/cetak/{aksi?}/{privasi_nik?}', 'Dpt@cetak')->name('dpt.cetak');
});

// Pemilihan
Route::group('pemilihan', static function (): void {
    Route::get('/', 'Pemilihan@index')->name('pemilihan.index');
    Route::get('/datatables', 'Pemilihan@datatables')->name('pemilihan.datatables');
    Route::get('/form/{id?}', 'Pemilihan@form')->name('pemilihan.form');
    Route::post('/insert', 'Pemilihan@insert')->name('pemilihan.insert');
    Route::post('/update/{id}', 'Pemilihan@update')->name('pemilihan.update');
    Route::get('/status/{id?}', 'Pemilihan@status')->name('pemilihan.status');
    Route::get('/delete/{id}', 'Pemilihan@delete')->name('pemilihan.delete');
    Route::post('/delete_all', 'Pemilihan@delete_all')->name('pemilihan.delete_all');
});

// Statistik > Statistik Kependudukan
Route::group('statistik', static function (): void {
    Route::get('/', 'Statistik@index')->name('statistik.index');
    Route::get('/clear/{lap?}/{order_by?}', 'Statistik@clear')->name('statistik.clear');
    Route::get('/order_by/{lap?}/{order_by?}', 'Statistik@order_by')->name('statistik.order_by');
    Route::get('/dialog/{aksi?}', 'Statistik@dialog')->name('statistik.dialog');
    Route::post('/daftar/{aksi?}/{lap?}', 'Statistik@daftar')->name('statistik.daftar');
    Route::get('/rentang_umur', 'Statistik@rentang_umur')->name('statistik.rentang_umur');
    Route::get('/form_rentang/{id?}', 'Statistik@form_rentang')->name('statistik.form_rentang');
    Route::post('/rentang_insert', 'Statistik@rentang_insert')->name('statistik.rentang_insert');
    Route::post('/rentang_update/{id?}', 'Statistik@rentang_update')->name('statistik.rentang_update');
    Route::get('/rentang_delete/{id}', 'Statistik@rentang_delete')->name('statistik.rentang_delete');
    Route::post('/delete_all_rentang', 'Statistik@delete_all_rentang')->name('statistik.delete_all_rentang');
    Route::post('/dusun/{lap?}', 'Statistik@dusun')->name('statistik.dusun');
    Route::post('/rw/{lap?}', 'Statistik@rw')->name('statistik.rw');
    Route::post('/rt/{lap?}', 'Statistik@rt')->name('statistik.rt');
    Route::get('/filter/{key}', 'Statistik@filter')->name('statistik.filter');
    Route::get('/load_chart_gis/{lap?}', 'Statistik@load_chart_gis')->name('statistik.load_chart_gis');
    Route::get('/chart_gis_desa/{lap?}/{desa?}', 'Statistik@chart_gis_desa')->name('statistik.chart_gis_desa');
    Route::get('/chart_gis_dusun/{lap?}/{dusun?}', 'Statistik@chart_gis_dusun')->name('statistik.chart_gis_dusun');
    Route::get('/chart_gis_rw/{lap?}/{dusun?}/{rw?}', 'Statistik@chart_gis_rw')->name('statistik.chart_gis_rw');
    Route::get('/chart_gis_rt/{lap?}/{dusun?}/{rw?}/{rt?}', 'Statistik@chart_gis_rt')->name('statistik.chart_gis_rt');
    Route::match(['GET', 'POST'], '/ajax_peserta_program_bantuan', 'Statistik@ajax_peserta_program_bantuan')->name('statistik.ajax_peserta_program_bantuan');
});

// Statistik > Laporan Bulanan
Route::group('laporan', static function (): void {
    Route::get('/', 'Laporan@index')->name('laporan.index');
    Route::get('/clear', 'Laporan@clear')->name('laporan.clear');
    Route::get('/dialog_cetak', 'Laporan@dialog_cetak')->name('laporan.dialog_cetak');
    Route::get('/dialog_unduh', 'Laporan@dialog_unduh')->name('laporan.dialog_unduh');
    Route::post('/cetak', 'Laporan@cetak')->name('laporan.cetak');
    Route::post('/unduh', 'Laporan@unduh')->name('laporan.unduh');
    Route::post('/bulan', 'Laporan@bulan')->name('laporan.bulan');
    Route::get('/detail_penduduk/{rincian}/{tipe}', 'Laporan@detail_penduduk')->name('laporan.detail_penduduk');
});

// Statistik > Laporan Kelompok Rentan
Route::group('laporan_rentan', static function (): void {
    Route::get('/', 'Laporan_rentan@index')->name('laporan_rentan.index');
    Route::get('/clear', 'Laporan_rentan@clear')->name('laporan_rentan.clear');
    Route::get('/cetak', 'Laporan_rentan@cetak')->name('laporan_rentan.cetak');
    Route::get('/excel', 'Laporan_rentan@excel')->name('laporan_rentan.excel');
    Route::post('/dusun', 'Laporan_rentan@dusun')->name('laporan_rentan.dusun');
});

// Statistik > Laporan Penduduk
Route::group('laporan_penduduk', static function (): void {
    Route::get('/', 'Laporan_penduduk@index')->name('laporan_penduduk.index');
    Route::post('/datatables', 'Laporan_penduduk@datatables')->name('laporan_penduduk.datatables');
    Route::get('/form/{id?}', 'Laporan_penduduk@form')->name('laporan_penduduk.form');
    Route::post('/insert', 'Laporan_penduduk@insert')->name('laporan_penduduk.insert');
    Route::post('/update/{id}', 'Laporan_penduduk@update')->name('laporan_penduduk.update');
    Route::post('/delete_all', 'Laporan_penduduk@delete_all')->name('laporan_penduduk.delete_all');
    Route::get('/unduh/{id?}', 'Laporan_penduduk@unduh')->name('laporan_penduduk.unduh');
    Route::post('/kirim', 'Laporan_penduduk@kirim')->name('laporan_penduduk.kirim');
});

// Kehadiran > Jam Kerja
Route::group('kehadiran_jam_kerja', static function (): void {
    Route::get('/', 'Kehadiran_jam_kerja@index')->name('kehadiran_jam_kerja.index');
    Route::get('/datatables', 'Kehadiran_jam_kerja@datatables')->name('kehadiran_jam_kerja.datatables');
    Route::get('/form/{id}', 'Kehadiran_jam_kerja@form')->name('kehadiran_jam_kerja.form');
    Route::post('/update/{id}', 'Kehadiran_jam_kerja@update')->name('kehadiran_jam_kerja.update');
});

// Kehadiran > Hari Libur
Route::group('kehadiran_hari_libur', static function (): void {
    Route::get('/', 'Kehadiran_hari_libur@index')->name('kehadiran_hari_libur.index');
    Route::get('/datatables', 'Kehadiran_hari_libur@datatables')->name('kehadiran_hari_libur.datatables');
    Route::get('/form/{id?}', 'Kehadiran_hari_libur@form')->name('kehadiran_hari_libur.form');
    Route::post('/create', 'Kehadiran_hari_libur@create')->name('kehadiran_hari_libur.create');
    Route::post('/update/{id}', 'Kehadiran_hari_libur@update')->name('kehadiran_hari_libur.update');
    Route::get('/delete/{id}', 'Kehadiran_hari_libur@delete')->name('kehadiran_hari_libur.delete');
    Route::post('/delete_all', 'Kehadiran_hari_libur@delete_all')->name('kehadiran_hari_libur.delete_all');
    Route::get('/import', 'Kehadiran_hari_libur@import')->name('kehadiran_hari_libur.import');
});

// Kehadiran > Rekapitulasi
Route::group('kehadiran_rekapitulasi', static function (): void {
    Route::get('/', 'Kehadiran_rekapitulasi@index')->name('kehadiran_rekapitulasi.index');
    Route::get('/datatables', 'Kehadiran_rekapitulasi@datatables')->name('kehadiran_rekapitulasi.datatables');
    Route::get('/ekspor', 'Kehadiran_rekapitulasi@ekspor')->name('kehadiran_rekapitulasi.ekspor');
});

// Kehadiran > Pengaduan
Route::group('kehadiran_pengaduan', static function (): void {
    Route::get('/', 'Kehadiran_pengaduan@index')->name('kehadiran_pengaduan.index');
    Route::get('/datatables', 'Kehadiran_pengaduan@datatables')->name('kehadiran_pengaduan.datatables');
    Route::get('/form/{id}', 'Kehadiran_pengaduan@form')->name('kehadiran_pengaduan.form');
    Route::post('/update/{id}', 'Kehadiran_pengaduan@update')->name('kehadiran_pengaduan.update');
});

// Kehadiran > Alasan Keluar
Route::group('kehadiran_keluar', static function (): void {
    Route::get('/', 'Kehadiran_keluar@index')->name('kehadiran_keluar.index');
    Route::get('/datatables', 'Kehadiran_keluar@datatables')->name('kehadiran_keluar.datatables');
    Route::get('/form/{id?}', 'Kehadiran_keluar@form')->name('kehadiran_keluar.form');
    Route::post('/create', 'Kehadiran_keluar@create')->name('kehadiran_keluar.create');
    Route::post('/update/{id}', 'Kehadiran_keluar@update')->name('kehadiran_keluar.update');
    Route::get('/delete/{id}', 'Kehadiran_keluar@delete')->name('kehadiran_keluar.delete');
    Route::post('/delete_all', 'Kehadiran_keluar@delete_all')->name('kehadiran_keluar.delete_all');
});

// Kesehatan > Pendataan & Pemantauan Covid-19
Route::group('covid19', static function (): void {
    // Pendataan
    Route::get('/', 'Covid19@index')->name('covid19.index');
    Route::get('/data_pemudik/{page?}', 'Covid19@data_pemudik')->name('covid19.data_pemudik');
    Route::match(['GET', 'POST'], '/form_pemudik', 'Covid19@form_pemudik')->name('covid19.form_pemudik');
    Route::get('/apipendudukpemudik', 'Covid19@apipendudukpemudik')->name('covid19.apipendudukpemudik');
    Route::post('/insert_penduduk', 'Covid19@insert_penduduk')->name('covid19.insert_penduduk');
    Route::post('/add_pemudik', 'Covid19@add_pemudik')->name('covid19.add_pemudik');
    Route::get('/hapus_pemudik/{id}', 'Covid19@hapus_pemudik')->name('covid19.hapus_pemudik');
    Route::post('/edit_pemudik_form/{id}', 'Covid19@edit_pemudik_form')->name('covid19.edit_pemudik_form');
    Route::post('/edit_pemudik/{id}', 'Covid19@edit_pemudik')->name('covid19.edit_pemudik');
    Route::get('/detil_pemudik/{id}', 'Covid19@detil_pemudik')->name('covid19.detil_pemudik');
    Route::post('/update_penduduk/{id_pend}/{id_pemudik}', 'Covid19@update_penduduk')->name('covid19.update_penduduk');
    // Pemantauan
    Route::get('/pantau/{page?}/{tgl?}/{nik?}', 'Covid19@pantau')->name('covid19.pantau');
    Route::post('/add_pantau', 'Covid19@add_pantau')->name('covid19.add_pantau');
    Route::get('/hapus_pantau/{id?}/{page?}/{plus?}', 'Covid19@hapus_pantau')->name('covid19.hapus_pantau');
    Route::get('/daftar/{aksi?}/{tgl?}/{nik?}', 'Covid19@daftar')->name('covid19.daftar');
});

// Kesehatan > Vaksin
Route::group('vaksin_covid', static function (): void {
    Route::post('/filter/{filter?}/{return?}', 'Vaksin_covid@filter')->name('vaksin_covid.filter');
    Route::post('/search', 'Vaksin_covid@search')->name('vaksin_covid.search');
    Route::get('/clear/{return?}', 'Vaksin_covid@clear')->name('vaksin_covid.clear');
    Route::get('/form', 'Vaksin_covid@form')->name('vaksin_covid.form');
    Route::get('/apipendudukvaksin', 'Vaksin_covid@apipendudukvaksin')->name('vaksin_covid.apipendudukvaksin');
    Route::get('/tampil_sertifikat/{id_penduduk}', 'Vaksin_covid@tampil_sertifikat')->name('vaksin_covid.tampil_sertifikat');
    Route::get('/berkas_vaksin/{id_penduduk}/{vaksin}', 'Vaksin_covid@berkas_vaksin')->name('vaksin_covid.berkas_vaksin');
    Route::post('/update', 'Vaksin_covid@update')->name('vaksin_covid.update');
    Route::match(['GET', 'POST'], '/laporan_penduduk/{p?}', 'Vaksin_covid@laporan_penduduk')->name('vaksin_covid.laporan_penduduk');
    Route::post('/laporan_penduduk_cetak/{aksi}', 'Vaksin_covid@laporan_penduduk_cetak')->name('vaksin_covid.laporan_penduduk_cetak');
    Route::get('/laporan_rekap', 'Vaksin_covid@laporan_rekap')->name('vaksin_covid.laporan_rekap');
    Route::post('/laporan_rekap_cetak/{aksi}', 'Vaksin_covid@laporan_rekap_cetak')->name('vaksin_covid.laporan_rekap_cetak');
    Route::post('/rekap/{penduduk}', 'Vaksin_covid@rekap')->name('vaksin_covid.rekap');
    Route::post('/autocomplete', 'Vaksin_covid@autocomplete')->name('vaksin_covid.autocomplete');
    Route::post('/impor', 'Vaksin_covid@impor')->name('vaksin_covid.impor');
    Route::match(['GET', 'POST'], '/index', 'Vaksin_covid@index');
    Route::match(['GET', 'POST'], '/index/{p?}', 'Vaksin_covid@index');
    Route::match(['GET', 'POST'], '/', 'Vaksin_covid@index');
});

// Kesehatan > Stunting
Route::group('stunting', static function (): void {
    // Posyandu
    Route::get('/', 'Stunting@index')->name('stunting.index');
    Route::get('/datatablesPosyandu', 'Stunting@datatablesPosyandu')->name('stunting.datatablesPosyandu');
    Route::get('/formPosyandu/{id?}', 'Stunting@formPosyandu')->name('stunting.formPosyandu');
    Route::post('/insertPosyandu', 'Stunting@insertPosyandu')->name('stunting.insertPosyandu');
    Route::post('/updatePosyandu/{id?}', 'Stunting@updatePosyandu')->name('stunting.updatePosyandu');
    Route::get('/deletePosyandu/{id}', 'Stunting@deletePosyandu')->name('stunting.deletePosyandu');
    Route::post('/deleteAllPosyandu', 'Stunting@deleteAllPosyandu')->name('stunting.deleteAllPosyandu');
    // KIA
    Route::get('/kia', 'Stunting@kia')->name('stunting.kia');
    Route::get('/datatablesKia', 'Stunting@datatablesKia')->name('stunting.datatablesKia');
    Route::match(['GET', 'POST'], '/formKia/{id?}', 'Stunting@formKia')->name('stunting.formKia');
    Route::get('/getIbu', 'Stunting@getIbu')->name('stunting.getIbu');
    Route::get('/getAnak', 'Stunting@getAnak')->name('stunting.getAnak');
    Route::post('/insertKia', 'Stunting@insertKia')->name('stunting.insertKia');
    Route::post('/updateKia/{id?}', 'Stunting@updateKia')->name('stunting.updateKia');
    Route::get('/deleteKia/{id}', 'Stunting@deleteKia')->name('stunting.deleteKia');
    Route::post('/deleteAllKia', 'Stunting@deleteAllKia')->name('stunting.deleteAllKia');
    // Pemantauan Ibu Hamil
    Route::get('/pemantauan_ibu_hamil', 'Stunting@pemantauan_ibu_hamil')->name('stunting.pemantauan_ibu_hamil');
    Route::get('/datatablesIbuHamil', 'Stunting@datatablesIbuHamil')->name('stunting.datatablesIbuHamil');
    Route::match(['GET', 'POST'], '/formIbuHamil/{id?}', 'Stunting@formIbuHamil')->name('stunting.formIbuHamil');
    Route::post('/insertIbuHamil', 'Stunting@insertIbuHamil')->name('stunting.insertIbuHamil');
    Route::post('/updateIbuHamil/{id?}', 'Stunting@updateIbuHamil')->name('stunting.updateIbuHamil');
    Route::get('/deleteIbuHamil/{id}', 'Stunting@deleteIbuHamil')->name('stunting.deleteIbuHamil');
    Route::post('/deleteAllIbuHamil', 'Stunting@deleteAllIbuHamil')->name('stunting.deleteAllIbuHamil');
    Route::get('/eksporIbuHamil', 'Stunting@eksporIbuHamil')->name('stunting.eksporIbuHamil');
    // Pemantauan Ibu Anak
    Route::get('/pemantauan_anak', 'Stunting@pemantauan_anak')->name('stunting.pemantauan_anak');
    Route::get('/datatablesAnak', 'Stunting@datatablesAnak')->name('stunting.datatablesAnak');
    Route::match(['GET', 'POST'], '/formAnak/{id?}', 'Stunting@formAnak')->name('stunting.formAnak');
    Route::post('/insertAnak', 'Stunting@insertAnak')->name('stunting.insertAnak');
    Route::post('/updateAnak/{id?}', 'Stunting@updateAnak')->name('stunting.updateAnak');
    Route::get('/deleteAnak/{id}', 'Stunting@deleteAnak')->name('stunting.deleteAnak');
    Route::post('/deleteAllAnak', 'Stunting@deleteAllAnak')->name('stunting.deleteAllAnak');
    Route::get('/eksporAnak', 'Stunting@eksporAnak')->name('stunting.eksporAnak');
    // Pemantauan Paud
    Route::get('/pemantauan_paud', 'Stunting@pemantauan_paud')->name('stunting.pemantauan_paud');
    Route::get('/datatablesPaud', 'Stunting@datatablesPaud')->name('stunting.datatablesPaud');
    Route::match(['GET', 'POST'], '/formPaud/{id?}', 'Stunting@formPaud')->name('stunting.formPaud');
    Route::post('/insertPaud', 'Stunting@insertPaud')->name('stunting.insertPaud');
    Route::post('/updatePaud/{id?}', 'Stunting@updatePaud')->name('stunting.updatePaud');
    Route::get('/deletePaud/{id}', 'Stunting@deletePaud')->name('stunting.deletePaud');
    Route::post('/deleteAllPaud', 'Stunting@deleteAllPaud')->name('stunting.deleteAllPaud');
    Route::get('/eksporPaud', 'Stunting@eksporPaud')->name('stunting.eksporPaud');
    // Rekapitulasi
    Route::get('/rekapitulasi_ibu_hamil/{kuartal?}/{tahun?}/{id?}', 'Stunting@rekapitulasi_ibu_hamil')->name('stunting.rekapitulasi_ibu_hamil');
    Route::get('/rekapitulasi_bulanan_anak/{kuartal?}/{tahun?}/{id?}', 'Stunting@rekapitulasi_bulanan_anak')->name('stunting.rekapitulasi_bulanan_anak');
    Route::get('/scorecard_konvergensi/{kuartal?}/{tahun?}/{id?}', 'Stunting@scorecard_konvergensi')->name('stunting.scorecard_konvergensi');
});

// Layanan Surat > Pengaturan Surat
Route::group('surat_master', static function (): void {
    Route::get('/', 'Surat_master@index')->name('surat_master.index');
    Route::get('/datatables', 'Surat_master@datatables')->name('surat_master.datatables');
    Route::get('/form/{id?}', 'Surat_master@form')->name('surat_master.form');
    Route::get('/apisurat', 'Surat_master@apisurat')->name('surat_master.apisurat');
    Route::get('/syaratSuratDatatables/{id?}', 'Surat_master@syaratSuratDatatables')->name('surat_master.syaratSuratDatatables');
    Route::post('/insert', 'Surat_master@insert')->name('surat_master.insert');
    Route::post('/simpan_sementara', 'Surat_master@simpan_sementara')->name('surat_master.simpan_sementara');
    Route::post('/update/{id?}', 'Surat_master@update')->name('surat_master.update');
    Route::post('/kodeIsian/{id?}', 'Surat_master@kodeIsian')->name('surat_master.kodeIsian');
    Route::match(['GET', 'POST'], '/kunci/{id?}/{val?}', 'Surat_master@kunci')->name('surat_master.kunci');
    Route::match(['GET', 'POST'], '/favorit/{id?}/{val?}', 'Surat_master@favorit')->name('surat_master.favorit');
    Route::get('/delete/{id}', 'Surat_master@delete')->name('surat_master.delete');
    Route::post('/delete_all', 'Surat_master@delete_all')->name('surat_master.delete_all');
    Route::get('/restore_surat_bawaan/{surat?}', 'Surat_master@restore_surat_bawaan')->name('surat_master.restore_surat_bawaan');
    Route::get('/pengaturan', 'Surat_master@pengaturan')->name('surat_master.pengaturan');
    Route::post('/edit_pengaturan', 'Surat_master@edit_pengaturan')->name('surat_master.edit_pengaturan');
    Route::match(['GET', 'POST'], '/kode_isian/{jenis?}/{id?}', 'Surat_master@kode_isian')->name('surat_master.kode_isian');
    Route::match(['GET', 'POST'], '/salin_template/{jenis?}', 'Surat_master@salin_template')->name('surat_master.salin_template');
    Route::post('/preview', 'Surat_master@preview')->name('surat_master.preview');
    Route::post('/ekspor', 'Surat_master@ekspor')->name('surat_master.ekspor');
    Route::get('/impor_filter/{data}', 'Surat_master@impor_filter')->name('surat_master.impor_filter');
    Route::post('/impor_store', 'Surat_master@impor_store')->name('surat_master.impor_store');
    Route::post('/impor', 'Surat_master@impor')->name('surat_master.impor');
    Route::get('/templateTinyMCE', 'Surat_master@templateTinyMCE')->name('surat_master.templateTinyMCE');
});

// Layanan Surat > Cetak Surat
Route::group('surat', static function (): void {
    Route::get('/', 'Surat@index')->name('surat.index');
    Route::get('/datatables', 'Surat@datatables')->name('surat.datatables');
    Route::get('/apidaftarsurat', 'Surat@apidaftarsurat')->name('surat.apidaftarsurat');
    Route::match(['GET', 'POST'], '/form/{url?}/{id?}', 'Surat@form')->name('surat.form');
    Route::post('/pratinjau/{url?}/{id?}', 'Surat@pratinjau')->name('surat.pratinjau');
    Route::post('/pdf/{preview?}', 'Surat@pdf')->name('surat.pdf');
    Route::post('/konsep', 'Surat@konsep')->name('surat.konsep');
    Route::match(['GET', 'POST'], '/cetak/{id}', 'Surat@cetak')->name('surat.cetak');
    Route::post('/nomor_surat_duplikat', 'Surat@nomor_surat_duplikat')->name('surat.nomor_surat_duplikat');
    Route::post('/search', 'Surat@search')->name('surat.search');
    Route::match(['GET', 'POST'], '/favorit/{id?}/{val?}', 'Surat@favorit')->name('surat.favorit');
    Route::post('/format_nomor_surat', 'Surat@format_nomor_surat')->name('surat.format_nomor_surat');
    Route::get('/list_penduduk_ajax', 'Surat@list_penduduk_ajax')->name('surat.list_penduduk_ajax');
    Route::get('/list_penduduk_bersurat_ajax', 'Surat@list_penduduk_bersurat_ajax')->name('surat.list_penduduk_bersurat_ajax');
    Route::get('/apipenduduksurat', 'Surat@apipenduduksurat')->name('surat.apipenduduksurat');
});

Route::group('datasuratpenduduk', static function (): void {
    Route::match(['GET', 'POST'], '/', 'DataSuratPenduduk@index');
    Route::match(['GET', 'POST'], '/index/{id_surat?}/{id_penduduk?}/{kategori?}', 'DataSuratPenduduk@index');
});

// Layanan Surat > Permohonan Surat
Route::group('permohonan_surat_admin', static function (): void {
    Route::get('/', 'Permohonan_surat_admin@index')->name('permohonan_surat_admin.index');
    Route::get('/datatables', 'Permohonan_surat_admin@datatables')->name('permohonan_surat_admin.datatables');
    Route::get('/periksa/{id?}', 'Permohonan_surat_admin@periksa')->name('permohonan_surat_admin.periksa');
    Route::get('/proses/{id?}/{status?}', 'Permohonan_surat_admin@proses')->name('permohonan_surat_admin.proses');
    Route::get('/konfirmasi/{id_permohonan?}/{tipe?}', 'Permohonan_surat_admin@konfirmasi')->name('permohonan_surat_admin.konfirmasi');
    Route::get('/kirim_pesan/{id_permohonan?}/{tipe?}', 'Permohonan_surat_admin@kirim_pesan')->name('permohonan_surat_admin.kirim_pesan');
    Route::get('/delete/{id?}', 'Permohonan_surat_admin@delete')->name('permohonan_surat_admin.delete');
    Route::get('/tampilkan/{id_dokumen?}/{id_pend?}', 'Permohonan_surat_admin@tampilkan')->name('permohonan_surat_admin.tampilkan');
    Route::get('/unduh_berkas/{id_dokumen?}/{id_pend?}/{tampil?}', 'Permohonan_surat_admin@unduh_berkas')->name('permohonan_surat_admin.unduh_berkas');
    Route::get('/tampilkan_berkas/{id_dokumen?}/{id_pend?}', 'Permohonan_surat_admin@tampilkan_berkas')->name('permohonan_surat_admin.tampilkan_berkas');
});

// Layanan Surat > Arsip Layanan
Route::group('keluar', static function (): void {
    Route::get('/', 'Keluar@index')->name('keluar.index');
    Route::get('/masuk', 'Keluar@masuk')->name('keluar.masuk');
    Route::get('/ditolak', 'Keluar@ditolak')->name('keluar.ditolak');
    Route::get('/datatables', 'Keluar@datatables')->name('keluar.datatables');
    Route::post('/verifikasi', 'Keluar@verifikasi')->name('keluar.verifikasi');
    Route::get('/tolak', 'Keluar@tolak')->name('keluar.tolak');
    Route::get('/tte', 'Keluar@tte')->name('keluar.tte');
    Route::get('/kembalikan', 'Keluar@kembalikan')->name('keluar.kembalikan');
    Route::get('/periksa/{id}', 'Keluar@periksa')->name('keluar.periksa');
    Route::get('/edit_keterangan/{id}', 'Keluar@edit_keterangan')->name('keluar.edit_keterangan');
    Route::post('/update_keterangan/{id}', 'Keluar@update_keterangan')->name('keluar.update_keterangan');
    Route::get('/delete/{id}', 'Keluar@delete')->name('keluar.delete');
    Route::get('/perorangan', 'Keluar@perorangan')->name('keluar.perorangan');
    Route::get('/perorangan_datatables', 'Keluar@perorangan_datatables')->name('keluar.perorangan_datatables');
    Route::get('/graph', 'Keluar@graph')->name('keluar.graph');
    Route::get('/unduh/{tipe?}/{id?}/{preview?}', 'Keluar@unduh')->name('keluar.unduh');
    Route::get('/dialog_cetak/{aksi?}', 'Keluar@dialog_cetak')->name('keluar.dialog_cetak');
    Route::post('/cetak/{aksi?}', 'Keluar@cetak')->name('keluar.cetak');
    Route::get('/qrcode/{id?}', 'Keluar@qrcode')->name('keluar.qrcode');
    Route::get('/perbaiki', 'Keluar@perbaiki')->name('keluar.perbaiki');
    Route::get('/kecamatan', 'Keluar@kecamatan')->name('keluar.kecamatan');
    Route::get('/data_kecamatan', 'Keluar@data_kecamatan')->name('keluar.data_kecamatan');
    Route::get('/dataPenduduk/{id?}', 'Keluar@dataPenduduk')->name('keluar.dataPenduduk');
    Route::get('/bulanTahun/{tahun?}', 'Keluar@bulanTahun')->name('keluar.bulanTahun');
});

// Layanan Surat > Daftar Persyaratan
Route::group('surat_mohon', static function (): void {
    Route::get('/', 'Surat_mohon@index')->name('surat_mohon.index');
    Route::get('/datatables', 'Surat_mohon@datatables')->name('surat_mohon.datatables');
    Route::get('/form/{id?}', 'Surat_mohon@form')->name('surat_mohon.form');
    Route::post('/insert', 'Surat_mohon@create')->name('surat_mohon.create');
    Route::post('/update/{id?}', 'Surat_mohon@update')->name('surat_mohon.update');
    Route::get('/delete/{id?}', 'Surat_mohon@delete')->name('surat_mohon.delete');
    Route::post('/deleteAll', 'Surat_mohon@delete_all')->name('surat_mohon.delete_all');
});

// Sekretariat > Informasi Publik
Route::group('dokumen', static function (): void {
    Route::get('/clear', 'Dokumen@clear')->name('dokumen.clear');
    Route::get('/form/{kat?}/{p?}/{o?}/{id?}', 'Dokumen@form')->name('dokumen.form');
    Route::post('/search', 'Dokumen@search')->name('dokumen.search');
    Route::post('/filter', 'Dokumen@filter')->name('dokumen.filter');
    Route::post('/insert', 'Dokumen@insert')->name('dokumen.insert');
    Route::post('/update/{kat?}/{id?}/{p?}/{o?} ', 'Dokumen@update')->name('dokumen.update');
    Route::get('/delete/{kat?}/{p?}/{o?}/{id?}', 'Dokumen@delete')->name('dokumen.delete');
    Route::post('/delete_all/{kat?}/{p?}/{o?}', 'Dokumen@delete_all')->name('dokumen.delete_all');
    Route::get('/dokumen_lock/{kat?}/{id?}', 'Dokumen@dokumen_lock')->name('dokumen.dokumen_lock');
    Route::get('/dokumen_unlock/{kat?}/{id?}', 'Dokumen@dokumen_unlock')->name('dokumen.dokumen_unlock');
    Route::get('/dialog_cetak/{kat?}', 'Dokumen@dialog_cetak')->name('dokumen.dialog_cetak');
    Route::post('/cetak/{kat?}', 'Dokumen@cetak')->name('dokumen.cetak');
    Route::get('/dialog_excel/{kat?}', 'Dokumen@dialog_excel')->name('dokumen.dialog_excel');
    Route::post('/excel/{kat?}', 'Dokumen@excel')->name('dokumen.excel');
    Route::get('/unduh_berkas/{id_dokumen?}/{id_pend?}/{tampil?}', 'Dokumen@unduh_berkas')->name('dokumen.unduh_berkas');
    Route::get('/tampilkan_berkas/{id_dokumen?}/{id_pend?}', 'Dokumen@tampilkan_berkas')->name('dokumen.tampilkan_berkas');
    Route::match(['GET', 'POST'], '/index', 'Dokumen@index');
    Route::match(['GET', 'POST'], '/index/{kat?}/{p?}/{o?}', 'Dokumen@index');
    Route::match(['GET', 'POST'], '/index/{kat?}/{p?}', 'Dokumen@index');
    Route::match(['GET', 'POST'], '/', 'Dokumen@index');
});

// Sekretariat > Inventaris
Route::group('inventaris_asset', static function (): void {
    Route::get('/', 'Inventaris_asset@index')->name('inventaris_asset.index');
    Route::get('/view/{id?}', 'Inventaris_asset@view')->name('inventaris_asset.view');
    Route::get('/view_mutasi/{id?}', 'Inventaris_asset@view_mutasi')->name('inventaris_asset.view_mutasi');
    Route::get('/edit/{id?}', 'Inventaris_asset@edit')->name('inventaris_asset.edit');
    Route::get('/edit_mutasi/{id?}', 'Inventaris_asset@edit_mutasi')->name('inventaris_asset.edit_mutasi');
    Route::get('/form', 'Inventaris_asset@form')->name('inventaris_asset.form');
    Route::get('/form_mutasi/{id?}', 'Inventaris_asset@form_mutasi')->name('inventaris_asset.form_mutasi');
    Route::get('/mutasi', 'Inventaris_asset@mutasi')->name('inventaris_asset.mutasi');
    Route::get('/cetak/{tahun}/{penandatangan}', 'Inventaris_asset@cetak')->name('inventaris_asset.cetak');
    Route::get('/download/{tahun}/{penandatangan}', 'Inventaris_asset@download')->name('inventaris_asset.download');
});

Route::group('api_inventaris_asset', static function (): void {
    Route::post('/add', 'Api_inventaris_asset@add')->name('api_inventaris_asset.add');
    Route::post('/add_mutasi', 'Api_inventaris_asset@add_mutasi')->name('api_inventaris_asset.add_mutasi');
    Route::post('/update/{id?}', 'Api_inventaris_asset@update')->name('api_inventaris_asset.update');
    Route::post('/update_mutasi/{id?}', 'Api_inventaris_asset@update_mutasi')->name('api_inventaris_asset.update_mutasi');
    Route::get('/delete/{id?}', 'Api_inventaris_asset@delete')->name('api_inventaris_asset.delete');
    Route::get('/delete_mutasi/{id?}', 'Api_inventaris_asset@delete_mutasi')->name('api_inventaris_asset.delete_mutasi');
});

Route::group('inventaris_gedung', static function (): void {
    Route::get('/', 'Inventaris_gedung@index')->name('inventaris_gedung.index');
    Route::get('/view/{id?}', 'Inventaris_gedung@view')->name('inventaris_gedung.view');
    Route::get('/view_mutasi/{id?}', 'Inventaris_gedung@view_mutasi')->name('inventaris_gedung.view_mutasi');
    Route::get('/edit/{id?}', 'Inventaris_gedung@edit')->name('inventaris_gedung.edit');
    Route::get('/edit_mutasi/{id?}', 'Inventaris_gedung@edit_mutasi')->name('inventaris_gedung.edit_mutasi');
    Route::get('/form', 'Inventaris_gedung@form')->name('inventaris_gedung.form');
    Route::get('/form_mutasi/{id?}', 'Inventaris_gedung@form_mutasi')->name('inventaris_gedung.form_mutasi');
    Route::get('/mutasi', 'Inventaris_gedung@mutasi')->name('inventaris_gedung.mutasi');
    Route::get('/cetak/{tahun}/{penandatangan}', 'Inventaris_gedung@cetak')->name('inventaris_gedung.cetak');
    Route::get('/download/{tahun}/{penandatangan}', 'Inventaris_gedung@download')->name('inventaris_gedung.download');
});

Route::group('api_inventaris_gedung', static function (): void {
    Route::post('/add', 'Api_inventaris_gedung@add')->name('api_inventaris_gedung.add');
    Route::post('/add_mutasi', 'Api_inventaris_gedung@add_mutasi')->name('api_inventaris_gedung.add_mutasi');
    Route::post('/update/{id?}', 'Api_inventaris_gedung@update')->name('api_inventaris_gedung.update');
    Route::post('/update_mutasi/{id?}', 'Api_inventaris_gedung@update_mutasi')->name('api_inventaris_gedung.update_mutasi');
    Route::get('/delete/{id?}', 'Api_inventaris_gedung@delete')->name('api_inventaris_gedung.delete');
    Route::get('/delete_mutasi/{id?}', 'Api_inventaris_gedung@delete_mutasi')->name('api_inventaris_gedung.delete_mutasi');
});

Route::group('inventaris_jalan', static function (): void {
    Route::get('/', 'Inventaris_jalan@index')->name('inventaris_jalan.index');
    Route::get('/view/{id}', 'Inventaris_jalan@view')->name('inventaris_jalan.view');
    Route::get('/view_mutasi/{id}', 'Inventaris_jalan@view_mutasi')->name('inventaris_jalan.view_mutasi');
    Route::get('/edit/{id}', 'Inventaris_jalan@edit')->name('inventaris_jalan.edit');
    Route::get('/edit_mutasi/{id}', 'Inventaris_jalan@edit_mutasi')->name('inventaris_jalan.edit_mutasi');
    Route::get('/form', 'Inventaris_jalan@form')->name('inventaris_jalan.form');
    Route::get('/form_mutasi/{id?}', 'Inventaris_jalan@form_mutasi')->name('inventaris_jalan.form_mutasi');
    Route::get('/mutasi', 'Inventaris_jalan@mutasi')->name('inventaris_jalan.mutasi');
    Route::get('/cetak/{tahun}/{penandatangan}', 'Inventaris_jalan@cetak')->name('inventaris_jalan.cetak');
    Route::get('/download/{tahun}/{penandatangan}', 'Inventaris_jalan@download')->name('inventaris_jalan.download');
});

Route::group('api_inventaris_jalan', static function (): void {
    Route::post('/add', 'Api_inventaris_jalan@add')->name('api_inventaris_jalan.add');
    Route::post('/add_mutasi', 'Api_inventaris_jalan@add_mutasi')->name('api_inventaris_jalan.add_mutasi');
    Route::post('/update/{id?}', 'Api_inventaris_jalan@update')->name('api_inventaris_jalan.update');
    Route::post('/update_mutasi/{id?}', 'Api_inventaris_jalan@update_mutasi')->name('api_inventaris_jalan.update_mutasi');
    Route::get('/delete/{id?}', 'Api_inventaris_jalan@delete')->name('api_inventaris_jalan.delete');
    Route::get('/delete_mutasi/{id?}', 'Api_inventaris_jalan@delete_mutasi')->name('api_inventaris_jalan.delete_mutasi');
});

Route::group('inventaris_kontruksi', static function (): void {
    Route::get('/', 'Inventaris_kontruksi@index')->name('inventaris_kontruksi.index');
    Route::get('/view/{id}', 'Inventaris_kontruksi@view')->name('inventaris_kontruksi.view');
    Route::get('/edit/{id}', 'Inventaris_kontruksi@edit')->name('inventaris_kontruksi.edit');
    Route::get('/form', 'Inventaris_kontruksi@form')->name('inventaris_kontruksi.form');
    Route::get('/cetak/{tahun}/{penandatangan}', 'Inventaris_kontruksi@cetak')->name('inventaris_kontruksi.cetak');
    Route::get('/download/{tahun}/{penandatangan}', 'Inventaris_kontruksi@download')->name('inventaris_kontruksi.download');
});

Route::group('api_inventaris_kontruksi', static function (): void {
    Route::post('/add', 'Api_inventaris_kontruksi@add')->name('api_inventaris_kontruksi.add');
    Route::post('/update/{id?}', 'Api_inventaris_kontruksi@update')->name('api_inventaris_kontruksi.update');
    Route::get('/delete/{id?}', 'Api_inventaris_kontruksi@delete')->name('api_inventaris_kontruksi.delete');
});

Route::group('inventaris_peralatan', static function (): void {
    Route::get('/', 'Inventaris_peralatan@index')->name('inventaris_peralatan.index');
    Route::get('/view/{id}', 'Inventaris_peralatan@view')->name('inventaris_peralatan.view');
    Route::get('/view_mutasi/{id}', 'Inventaris_peralatan@view_mutasi')->name('inventaris_peralatan.view_mutasi');
    Route::get('/edit/{id}', 'Inventaris_peralatan@edit')->name('inventaris_peralatan.edit');
    Route::get('/edit_mutasi/{id}', 'Inventaris_peralatan@edit_mutasi')->name('inventaris_peralatan.edit_mutasi');
    Route::get('/form', 'Inventaris_peralatan@form')->name('inventaris_peralatan.form');
    Route::get('/form_mutasi/{id?}', 'Inventaris_peralatan@form_mutasi')->name('inventaris_peralatan.form_mutasi');
    Route::get('/mutasi', 'Inventaris_peralatan@mutasi')->name('inventaris_peralatan.mutasi');
    Route::get('/cetak/{tahun}/{penandatangan}', 'Inventaris_peralatan@cetak')->name('inventaris_peralatan.cetak');
    Route::get('/download/{tahun}/{penandatangan}', 'Inventaris_peralatan@download')->name('inventaris_peralatan.download');
});

Route::group('api_inventaris_peralatan', static function (): void {
    Route::post('/add', 'Api_inventaris_peralatan@add')->name('api_inventaris_peralatan.add');
    Route::post('/add_mutasi', 'Api_inventaris_peralatan@add_mutasi')->name('api_inventaris_peralatan.add_mutasi');
    Route::post('/update/{id?}', 'Api_inventaris_peralatan@update')->name('api_inventaris_peralatan.update');
    Route::post('/update_mutasi/{id?}', 'Api_inventaris_peralatan@update_mutasi')->name('api_inventaris_peralatan.update_mutasi');
    Route::get('/delete/{id?}', 'Api_inventaris_peralatan@delete')->name('api_inventaris_peralatan.delete');
    Route::get('/delete_mutasi/{id?}', 'Api_inventaris_peralatan@delete_mutasi')->name('api_inventaris_peralatan.delete_mutasi');
});

Route::group('inventaris_tanah', static function (): void {
    Route::get('/', 'Inventaris_tanah@index')->name('inventaris_tanah.index');
    Route::get('/view/{id}', 'Inventaris_tanah@view')->name('inventaris_tanah.view');
    Route::get('/view_mutasi/{id}', 'Inventaris_tanah@view_mutasi')->name('inventaris_tanah.view_mutasi');
    Route::get('/edit/{id}', 'Inventaris_tanah@edit')->name('inventaris_tanah.edit');
    Route::get('/edit_mutasi/{id}', 'Inventaris_tanah@edit_mutasi')->name('inventaris_tanah.edit_mutasi');
    Route::get('/form', 'Inventaris_tanah@form')->name('inventaris_tanah.form');
    Route::get('/form_mutasi/{id?}', 'Inventaris_tanah@form_mutasi')->name('inventaris_tanah.form_mutasi');
    Route::get('/mutasi', 'Inventaris_tanah@mutasi')->name('inventaris_tanah.mutasi');
    Route::get('/cetak/{tahun}/{penandatangan}', 'Inventaris_tanah@cetak')->name('inventaris_tanah.cetak');
    Route::get('/download/{tahun}/{penandatangan}', 'Inventaris_tanah@download')->name('inventaris_tanah.download');
});

Route::group('api_inventaris_tanah', static function (): void {
    Route::post('/add', 'Api_inventaris_tanah@add')->name('api_inventaris_tanah.add');
    Route::post('/add_mutasi', 'Api_inventaris_tanah@add_mutasi')->name('api_inventaris_tanah.add_mutasi');
    Route::post('/update/{id?}', 'Api_inventaris_tanah@update')->name('api_inventaris_tanah.update');
    Route::post('/update_mutasi/{id?}', 'Api_inventaris_tanah@update_mutasi')->name('api_inventaris_tanah.update_mutasi');
    Route::get('/delete/{id?}', 'Api_inventaris_tanah@delete')->name('api_inventaris_tanah.delete');
    Route::get('/delete_mutasi/{id?}', 'Api_inventaris_tanah@delete_mutasi')->name('api_inventaris_tanah.delete_mutasi');
});

// Laporan inventaris
Route::group('laporan_inventaris', static function (): void {
    Route::get('/', 'Laporan_inventaris@index')->name('laporan_inventaris.index');
    Route::get('/cetak/{tahun}/{penandatangan}', 'Laporan_inventaris@cetak')->name('laporan_inventaris.cetak');
    Route::get('/download/{tahun}/{penandatangan}', 'Laporan_inventaris@download')->name('laporan_inventaris.download');
    Route::get('/mutasi', 'Laporan_inventaris@mutasi')->name('laporan_inventaris.mutasi');
    Route::get('/cetak_mutasi/{tahun}/{penandatangan}', 'Laporan_inventaris@cetak_mutasi')->name('laporan_inventaris.cetak_mutasi');
    Route::get('/download_mutasi/{tahun}/{penandatangan}', 'Laporan_inventaris@download_mutasi')->name('laporan_inventaris.download_mutasi');
    Route::get('/permendagri_47/{asset}', 'Laporan_inventaris@permendagri_47')->name('laporan_inventaris.permendagri_47');
    Route::get('/permendagri_47_dialog/{aksi}/{asset?}', 'Laporan_inventaris@permendagri_47_dialog')->name('laporan_inventaris.permendagri_47_dialog');
    Route::post('/filter/{filter}', 'Laporan_inventaris@filter')->name('laporan_inventaris.filter');
});

// Sekretariat > Klasifikasi Surat
Route::group('klasifikasi', static function (): void {
    Route::get('/', 'Klasifikasi@index')->name('klasifikasi.index');
    Route::get('/datatables', 'Klasifikasi@datatables')->name('klasifikasi.datatables');
    Route::get('/form/{id?}', 'Klasifikasi@form')->name('klasifikasi.form');
    Route::post('/insert', 'Klasifikasi@insert')->name('klasifikasi.insert');
    Route::post('/update/{id?}', 'Klasifikasi@update')->name('klasifikasi.update');
    Route::get('/delete/{id?}', 'Klasifikasi@delete')->name('klasifikasi.delete');
    Route::post('/delete_all/{id?}', 'Klasifikasi@delete_all')->name('klasifikasi.delete_all');
    Route::get('/lock/{id?}', 'Klasifikasi@lock')->name('klasifikasi.lock');
    Route::get('/unlock/{id?}', 'Klasifikasi@unlock')->name('klasifikasi.unlock');
    Route::get('/ekspor', 'Klasifikasi@ekspor')->name('klasifikasi.ekspor');
    Route::get('/impor', 'Klasifikasi@impor')->name('klasifikasi.impor');
    Route::post('/proses_impor', 'Klasifikasi@proses_impor')->name('klasifikasi.proses_impor');
});

// Buku Administrasi Desa
// - Buku Administrasi Umum
// -- Buku Peraturan Di Desa
// Route::group('perdes', function() {
//     Route::get('/', 'buku_umum/Dokumen_sekretariat@perdes')->name('perdes.index');
//     Route::get('/clear', 'buku_umum/Dokumen_sekretariat@clear/3')->name('perdes.index');
//     Route::get('/form', 'buku_umum/Dokumen_sekretariat@tambah_perdes')->name('perdes.tambah');
//     Route::get('/form/{id}', 'buku_umum/Dokumen_sekretariat@ubah_perdes')->name('perdes.ubah');
//     Route::get('/{p?}/{o?}', 'buku_umum/Dokumen_sekretariat@perdes');
// });
// -- Buku Keputusan Kepala Desa
// -- Buku Inventaris dan Kekayaan Desa
// -- Buku Pemerintahan Desa
// -- Buku Tanah Kas Desa
// -- Buku Tanah di Desa
// -- Buku Agenda - Surat Keluar
// -- Buku Agenda - Surat Masuk
// -- Buku Ekspedisi
// -- Buku Lembaran Desa dan Berita Desa
// - Buku Administrasi Penduduk
// -- Buku Induk Penduduk
// -- Buku Mutasi Penduduk Desa
// -- Buku Rekapitulasi Jumlah Penduduk
// -- Buku Penduduk Sementara
// -- Buku KTP dan KK
// -- Sinkronisasi Laporan Penduduk

Route::group('', ['namespace' => 'buku_umum'], static function (): void {
    // Bumindes umum
    Route::group('bumindes_umum', static function (): void {
        Route::get('/', 'Bumindes_umum@index')->name('buku-umum.bumindes_umum.index');
        Route::post('/tables/{page?}/{page_number?}/{offset?}', 'Bumindes_umum@tables')->name('buku-umum.bumindes_umum.tables');
        Route::get('/form/{page?}/{page_number?}/{offset?}/{key?}', 'Bumindes_umum@form')->name('buku-umum.bumindes_umum.form');
    });

    // Dokumen Sekretariat
    Route::group('dokumen_sekretariat', static function (): void {
        Route::get('/perdes/{kat?}', 'Dokumen_sekretariat@perdes')->name('buku-umum.dokumen_sekretariat.perdes');
        Route::get('/tambah_perdes', 'Dokumen_sekretariat@tambah_perdes')->name('buku-umum.dokumen_sekretariat.tambah_perdes');
        Route::get('/ubah_perdes/{id}', 'Dokumen_sekretariat@ubah_perdes')->name('buku-umum.dokumen_sekretariat.ubah_perdes');
        Route::get('/peraturan_desa/{kat?}/{p?}/{o?}', 'Dokumen_sekretariat@peraturan_desa')->name('buku-umum.dokumen_sekretariat.peraturan_desa');
        Route::get('/datatables', 'Dokumen_sekretariat@datatables')->name('buku-umum.dokumen_sekretariat.datatables');
        Route::get('/lock/{kat?}/{id?}', 'Dokumen_sekretariat@lock')->name('buku-umum.dokumen_sekretariat.lock');
        Route::post('/daftar/{kat?}/{aksi?}', 'Dokumen_sekretariat@daftar')->name('buku-umum.dokumen_sekretariat.daftar');

        Route::get('/form/{kat?}/{id?}', 'Dokumen_sekretariat@form')->name('buku-umum.dokumen_sekretariat.form');

        Route::post('/insert', 'Dokumen_sekretariat@insert')->name('buku-umum.dokumen_sekretariat.insert');
        Route::post('/update/{kat?}/{id?}/{p?}/{o?} ', 'Dokumen_sekretariat@update')->name('buku-umum.dokumen_sekretariat.update');
        Route::get('/delete/{kat?}/{id?}', 'Dokumen_sekretariat@delete')->name('buku-umum.dokumen_sekretariat.delete');
        Route::post('/delete_all/{kat?}', 'Dokumen_sekretariat@delete_all')->name('buku-umum.dokumen_sekretariat.delete_all');
        Route::get('/dialog_cetak/{kat?}/{aksi?}', 'Dokumen_sekretariat@dialog_cetak')->name('buku-umum.dokumen_sekretariat.dialog_cetak');
        Route::get('/dialog_excel/{kat?}', 'Dokumen_sekretariat@dialog_excel')->name('buku-umum.dokumen_sekretariat.dialog_excel');
        Route::get('/berkas/{id_dokumen?}/{kat?}/{tipe?}', 'Dokumen_sekretariat@berkas')->name('buku-umum.dokumen_sekretariat.berkas');
    });

    // Ekspedisi
    Route::group('ekspedisi', static function (): void {
        Route::get('/clear', 'Ekspedisi@clear')->name('buku-umum.ekspedisi.clear');
        Route::get('/form/{p}/{o}/{id}', 'Ekspedisi@form')->name('buku-umum.ekspedisi.form');
        Route::post('/search', 'Ekspedisi@search')->name('buku-umum.ekspedisi.search');
        Route::post('/filter', 'Ekspedisi@filter')->name('buku-umum.ekspedisi.filter');
        Route::post('/update/{p}/{o}/{id}', 'Ekspedisi@update')->name('buku-umum.ekspedisi.update');
        Route::get('/dialog/{aksi?}/{o?}', 'Ekspedisi@dialog')->name('buku-umum.ekspedisi.dialog');
        Route::match(['GET', 'POST'], '/daftar/{aksi?}/{o?}', 'Ekspedisi@daftar')->name('buku-umum.ekspedisi.daftar');
        Route::get('/unduh_tanda_terima/{id}', 'Ekspedisi@unduh_tanda_terima')->name('buku-umum.ekspedisi.unduh_tanda_terima');
        Route::get('/bukan_ekspedisi/{p}/{o}/{id}', 'Ekspedisi@bukan_ekspedisi')->name('buku-umum.ekspedisi.bukan_ekspedisi');
        Route::match(['GET', 'POST'], '/index/{p?}/{o?}', 'Ekspedisi@index')->name('buku-umum.ekspedisi.index');
        Route::match(['GET', 'POST'], '/{p?}/{o?}', 'Ekspedisi@index')->name('buku-umum.ekspedisi.index-page');
    });

    // Lembaran Desa
    Route::group('lembaran_desa', static function (): void {
        Route::get('/clear', 'Lembaran_desa@clear')->name('buku-umum.lembaran_desa.clear');
        Route::get('/form/{p?}/{o?}/{id?}', 'Lembaran_desa@form')->name('buku-umum.lembaran_desa.form');
        Route::post('/search', 'Lembaran_desa@search')->name('buku-umum.lembaran_desa.search');
        Route::post('/filter/{filter?}', 'Lembaran_desa@filter')->name('buku-umum.lembaran_desa.filter');
        Route::post('/update/{id}/{p?}/{o?}', 'Lembaran_desa@update')->name('buku-umum.lembaran_desa.update');
        Route::get('/lock/{id}/{val?}', 'Lembaran_desa@lock')->name('buku-umum.lembaran_desa.lock');
        Route::get('/dialog_daftar/{aksi?}/{o?}', 'Lembaran_desa@dialog_daftar')->name('buku-umum.lembaran_desa.dialog_daftar');
        Route::match(['GET', 'POST'], '/daftar/{aksi?}/{o?}', 'Lembaran_desa@daftar')->name('buku-umum.lembaran_desa.daftar');
        Route::get('/unduh_berkas/{id_dokumen?}', 'Lembaran_desa@unduh_berkas')->name('buku-umum.lembaran_desa.unduh_berkas');
        Route::match(['GET', 'POST'], '/index/{p?}/{o?}', 'Lembaran_desa@index')->name('buku-umum.lembaran_desa.index');
        Route::match(['GET', 'POST'], '/{p?}/{o?}', 'Lembaran_desa@index')->name('buku-umum.lembaran_desa.index-page');
    });

    // Perangkat/Pengurus Desa
    Route::group('pengurus', static function (): void {
        Route::get('/', 'Pengurus@index')->name('buku-umum.pengurus.index');
        Route::get('/datatables', 'Pengurus@datatables')->name('buku-umum.pengurus.datatables');
        Route::match(['GET', 'POST'], '/form/{id?}', 'Pengurus@form')->name('buku-umum.pengurus.form');
        Route::post('/insert', 'Pengurus@insert')->name('buku-umum.pengurus.insert');
        Route::post('/update/{id?}', 'Pengurus@update')->name('buku-umum.pengurus.update');
        Route::match(['GET', 'POST'], '/delete/{id?}', 'Pengurus@delete')->name('buku-umum.pengurus.delete');
        Route::get('/ttd/{jenis?}/{id?}/{val?}', 'Pengurus@ttd')->name('buku-umum.pengurus.ttd');
        Route::post('/tukar', 'Pengurus@tukar')->name('buku-umum.pengurus.tukar');
        Route::get('/lock/{id?}/{val?}', 'Pengurus@lock')->name('buku-umum.pengurus.lock');
        Route::get('/kehadiran/{id?}/{val?}', 'Pengurus@kehadiran')->name('buku-umum.pengurus.kehadiran');
        Route::get('/daftar/{aksi?}', 'Pengurus@daftar')->name('buku-umum.pengurus.daftar');
        Route::get('/bagan/{ada_bpd?}', 'Pengurus@bagan')->name('buku-umum.pengurus.bagan');
        Route::get('/atur_bagan', 'Pengurus@atur_bagan')->name('buku-umum.pengurus.atur_bagan');
        Route::post('/update_bagan', 'Pengurus@update_bagan')->name('buku-umum.pengurus.update_bagan');
        Route::get('/atur_bagan_layout', 'Pengurus@atur_bagan_layout')->name('buku-umum.pengurus.atur_bagan_layout');
        Route::get('/jabatan', 'Pengurus@jabatan')->name('buku-umum.pengurus.jabatan');
        Route::get('/jabatanform/{id?}', 'Pengurus@jabatanform')->name('buku-umum.pengurus.jabatanform');
        Route::post('/jabataninsert', 'Pengurus@jabataninsert')->name('buku-umum.pengurus.jabataninsert');
        Route::post('/jabatanUpdate/{id?}', 'Pengurus@jabatanUpdate')->name('buku-umum.pengurus.jabatanUpdate');
        Route::match(['GET', 'POST'], '/jabatandelete/{id?}', 'Pengurus@jabatandelete')->name('buku-umum.pengurus.jabatandelete');
        Route::get('/apidaftarpenduduk', 'Pengurus@apidaftarpenduduk')->name('buku-umum.pengurus.apidaftarpenduduk');
    });

    // Surat Keluar
    Route::group('surat_keluar', static function (): void {
        Route::get('/clear/{id?}', 'Surat_keluar@clear')->name('buku-umum.surat_keluar.clear');
        Route::get('/form/{p?}/{o?}/{id?}', 'Surat_keluar@form')->name('buku-umum.surat_keluar.form');
        Route::get('/form_upload/{p?}/{o?}/{url?}', 'Surat_keluar@form_upload')->name('buku-umum.surat_keluar.form_upload');
        Route::get('/search', 'Surat_keluar@search')->name('buku-umum.surat_keluar.search');
        Route::post('/filter', 'Surat_keluar@filter')->name('buku-umum.surat_keluar.filter');
        Route::post('/insert', 'Surat_keluar@insert')->name('buku-umum.surat_keluar.insert');
        Route::post('/update/{p?}/{o?}/{id?}', 'Surat_keluar@update')->name('buku-umum.surat_keluar.update');
        Route::post('/upload/{p?}/{o?}/{url?}', 'Surat_keluar@upload')->name('buku-umum.surat_keluar.upload');
        Route::get('/delete/{p?}/{o?}/{id?}', 'Surat_keluar@delete')->name('buku-umum.surat_keluar.delete');
        Route::post('/delete_all//{p?}/{o?}', 'Surat_keluar@delete_all')->name('buku-umum.surat_keluar.delete_all');
        Route::get('/dialog_cetak/{o?}', 'Surat_keluar@dialog_cetak')->name('buku-umum.surat_keluar.dialog_cetak');
        Route::get('/dialog_unduh/{o?}', 'Surat_keluar@dialog_unduh')->name('buku-umum.surat_keluar.dialog_unduh');
        Route::match(['GET', 'POST'], '/dialog/{aksi?}/{o?}', 'Surat_keluar@dialog')->name('buku-umum.surat_keluar.dialog');
        Route::get('/berkas/{idSuratKeluar?}/{tipe?}', 'Surat_keluar@berkas')->name('buku-umum.surat_keluar.berkas');
        Route::post('/nomor_surat_duplikat', 'Surat_keluar@nomor_surat_duplikat')->name('buku-umum.surat_keluar.nomor_surat_duplikat');
        Route::get('/untuk_ekspedisi/{p?}/{o?}/{id?}', 'Surat_keluar@untuk_ekspedisi')->name('buku-umum.surat_keluar.untuk_ekspedisi');
        Route::match(['GET', 'POST'], '/index/{p?}/{o?}', 'Surat_keluar@index')->name('buku-umum.surat_keluar.index');
        Route::match(['GET', 'POST'], '/{p?}/{o?}', 'Surat_keluar@index')->name('buku-umum.surat_keluar.index-page');
    });

    // Surat Masuk
    Route::group('surat_masuk', static function (): void {
        Route::get('/clear/{id?}', 'Surat_masuk@clear')->name('buku-umum.surat_masuk.clear');
        Route::get('/form/{p?}/{o?}/{id?}', 'Surat_masuk@form')->name('buku-umum.surat_masuk.form');
        Route::get('/form_upload/{p?}/{o?}/{url?}', 'Surat_masuk@form_upload')->name('buku-umum.surat_masuk.form_upload');
        Route::post('/search', 'Surat_masuk@search')->name('buku-umum.surat_masuk.search');
        Route::post('/filter', 'Surat_masuk@filter')->name('buku-umum.surat_masuk.filter');
        Route::post('/insert', 'Surat_masuk@insert')->name('buku-umum.surat_masuk.insert');
        Route::post('/update/{p?}/{o?}/{id?}', 'Surat_masuk@update')->name('buku-umum.surat_masuk.update');
        Route::post('/upload/{p?}/{o?}/{url?}', 'Surat_masuk@upload')->name('buku-umum.surat_masuk.upload');
        Route::get('/delete/{p?}/{o?}/{id?}', 'Surat_masuk@delete')->name('buku-umum.surat_masuk.delete');
        Route::post('/delete_all/{p?}/{o?}', 'Surat_masuk@delete_all')->name('buku-umum.surat_masuk.delete_all');
        Route::get('/dialog_disposisi/{o?}/{id?}', 'Surat_masuk@dialog_disposisi')->name('buku-umum.surat_masuk.dialog_disposisi');
        Route::get('/dialog_cetak/{o?}', 'Surat_masuk@dialog_cetak')->name('buku-umum.surat_masuk.dialog_cetak');
        Route::get('/dialog_unduh/{o?}', 'Surat_masuk@dialog_unduh')->name('buku-umum.surat_masuk.dialog_unduh');
        Route::match(['GET', 'POST'], '/dialog/{aksi?}/{o?}', 'Surat_masuk@dialog')->name('buku-umum.surat_masuk.dialog');
        Route::post('/disposisi/{id?}', 'Surat_masuk@disposisi')->name('buku-umum.surat_masuk.disposisi');
        Route::get('/berkas/{idSuratMasuk?}/{tipe?}', 'Surat_masuk@berkas')->name('buku-umum.surat_masuk.berkas');
        Route::post('/nomor_surat_duplikat', 'Surat_masuk@nomor_surat_duplikat')->name('buku-umum.surat_masuk.nomor_surat_duplikat');
        Route::get('/index/{p?}/{o?}', 'Surat_masuk@index')->name('buku-umum.surat_masuk.index');
        Route::get('/{p?}/{o?}', 'Surat_masuk@index')->name('buku-umum.surat_masuk.index-page');
    });
});

// Buku Tanah Kas Desa
Route::group('bumindes_tanah_kas_desa', static function (): void {
    Route::match(['GET', 'POST'], '/', 'Bumindes_tanah_kas_desa@index')->name('bumindes_tanah_kas_desa.index');
    Route::get('/clear', 'Bumindes_tanah_kas_desa@clear')->name('bumindes_tanah_kas_desa.clear');
    Route::get('/view_tanah_kas_desa/{id}', 'Bumindes_tanah_kas_desa@view_tanah_kas_desa')->name('bumindes_tanah_kas_desa.view_tanah_kas_desa');
    Route::get('/form/{id?}', 'Bumindes_tanah_kas_desa@form')->name('bumindes_tanah_kas_desa.form');
    Route::post('/add_tanah_kas_desa', 'Bumindes_tanah_kas_desa@add_tanah_kas_desa')->name('bumindes_tanah_kas_desa.add_tanah_kas_desa');
    Route::post('/update_tanah_kas_desa/{id?}', 'Bumindes_tanah_kas_desa@update_tanah_kas_desa')->name('bumindes_tanah_kas_desa.update_tanah_kas_desa');
    Route::get('/delete_tanah_kas_desa/{id?}', 'Bumindes_tanah_kas_desa@delete_tanah_kas_desa')->name('bumindes_tanah_kas_desa.delete_tanah_kas_desa');
    Route::post('/cetak_tanah_kas_desa/{aksi?}', 'Bumindes_tanah_kas_desa@cetak_tanah_kas_desa')->name('bumindes_tanah_kas_desa.cetak_tanah_kas_desa');
});

// Buku Tanah Desa
Route::group('bumindes_tanah_desa', static function (): void {
    Route::match(['GET', 'POST'], '/', 'Bumindes_tanah_desa@index')->name('bumindes_tanah_desa.index');
    Route::get('/clear', 'Bumindes_tanah_desa@clear')->name('bumindes_tanah_desa.clear');
    Route::get('/view_tanah_desa/{id}', 'Bumindes_tanah_desa@view_tanah_desa')->name('bumindes_tanah_desa.view_tanah_desa');
    Route::get('/form/{id?}', 'Bumindes_tanah_desa@form')->name('bumindes_tanah_desa.form');
    Route::post('/add_tanah_desa', 'Bumindes_tanah_desa@add_tanah_desa')->name('bumindes_tanah_desa.add_tanah_desa');
    Route::post('/update_tanah_desa/{id?}', 'Bumindes_tanah_desa@update_tanah_desa')->name('bumindes_tanah_desa.update_tanah_desa');
    Route::get('/delete_tanah_desa/{id?}', 'Bumindes_tanah_desa@delete_tanah_desa')->name('bumindes_tanah_desa.delete_tanah_desa');
    Route::post('/cetak_tanah_desa/{aksi?}', 'Bumindes_tanah_desa@cetak_tanah_desa')->name('bumindes_tanah_desa.cetak_tanah_desa');
});

// Buku inventaris dan kekayaan desa
Route::group('bumindes_inventaris_kekayaan', static function (): void {
    Route::get('/', 'Bumindes_inventaris_kekayaan@index')->name('bumindes_inventaris_kekayaan.index');
    Route::post('/filter/{filter}', 'Bumindes_inventaris_kekayaan@filter')->name('bumindes_inventaris_kekayaan.filter');
});

// Administrasi Penduduk
Route::group('bumindes_penduduk_induk', static function (): void {
    Route::match(['GET', 'POST'], '/', 'Bumindes_penduduk_induk@index');
    Route::match(['GET', 'POST'], '/index', 'Bumindes_penduduk_induk@index');
    Route::match(['GET', 'POST'], '/index/{page_number}', 'Bumindes_penduduk_induk@index');
    Route::match(['GET', 'POST'], '/index/{page_number}/{order_by}', 'Bumindes_penduduk_induk@index');
    Route::get('/clear', 'Bumindes_penduduk_induk@clear')->name('bumindes_penduduk_induk.clear');
    Route::get('/ajax_cetak/{page}/{o}/{id?}', 'Bumindes_penduduk_induk@ajax_cetak')->name('bumindes_penduduk_induk.ajax_cetak');
    Route::post('/cetak/{page}/{o}/{id?}', 'Bumindes_penduduk_induk@cetak')->name('bumindes_penduduk_induk.cetak');
    Route::get('/autocomplete', 'Bumindes_penduduk_induk@autocomplete')->name('bumindes_penduduk_induk.autocomplete');
    Route::post('/filter/{filter}', 'Bumindes_penduduk_induk@filter')->name('bumindes_penduduk_induk.filter');
});

Route::group('bumindes_penduduk_mutasi', static function (): void {
    Route::match(['GET', 'POST'], '/', 'Bumindes_penduduk_mutasi@index');
    Route::match(['GET', 'POST'], '/index', 'Bumindes_penduduk_mutasi@index');
    Route::match(['GET', 'POST'], '/index/{page_number}', 'Bumindes_penduduk_mutasi@index');
    Route::match(['GET', 'POST'], '/index/{page_number}/{order_by}', 'Bumindes_penduduk_mutasi@index');
    Route::get('/clear', 'Bumindes_penduduk_mutasi@clear')->name('bumindes_penduduk_mutasi.clear');
    Route::get('/ajax_cetak/{page}/{o}/{id?}', 'Bumindes_penduduk_mutasi@ajax_cetak')->name('bumindes_penduduk_mutasi.ajax_cetak');
    Route::post('/cetak/{page}/{o}/{id?}', 'Bumindes_penduduk_mutasi@cetak')->name('bumindes_penduduk_mutasi.cetak');
    Route::get('/autocomplete', 'Bumindes_penduduk_mutasi@autocomplete')->name('bumindes_penduduk_mutasi.autocomplete');
    Route::post('/filter/{filter}', 'Bumindes_penduduk_mutasi@filter')->name('bumindes_penduduk_mutasi.filter');
});

Route::group('bumindes_penduduk_rekapitulasi', static function (): void {
    Route::match(['GET', 'POST'], '/', 'Bumindes_penduduk_rekapitulasi@index');
    Route::match(['GET', 'POST'], '/index', 'Bumindes_penduduk_rekapitulasi@index');
    Route::match(['GET', 'POST'], '/index/{page_number}', 'Bumindes_penduduk_rekapitulasi@index');
    Route::get('/clear', 'Bumindes_penduduk_rekapitulasi@clear')->name('bumindes_penduduk_rekapitulasi.clear');
    Route::get('/ajax_cetak/{aksi}', 'Bumindes_penduduk_rekapitulasi@ajax_cetak')->name('bumindes_penduduk_rekapitulasi.ajax_cetak');
    Route::post('/cetak/{aksi}', 'Bumindes_penduduk_rekapitulasi@cetak')->name('bumindes_penduduk_rekapitulasi.cetak');
    Route::get('/autocomplete', 'Bumindes_penduduk_rekapitulasi@autocomplete')->name('bumindes_penduduk_rekapitulasi.autocomplete');
    Route::post('/filter/{filter}', 'Bumindes_penduduk_rekapitulasi@filter')->name('bumindes_penduduk_rekapitulasi.filter');
});

Route::group('bumindes_penduduk_sementara', static function (): void {
    Route::match(['GET', 'POST'], '/', 'Bumindes_penduduk_sementara@index');
    Route::match(['GET', 'POST'], '/index', 'Bumindes_penduduk_sementara@index');
    Route::match(['GET', 'POST'], '/index/{page_number}', 'Bumindes_penduduk_sementara@index');
    Route::match(['GET', 'POST'], '/index/{page_number}/{order_by}', 'Bumindes_penduduk_sementara@index');
    Route::get('/clear', 'Bumindes_penduduk_sementara@clear')->name('bumindes_penduduk_sementara.clear');
    Route::get('/ajax_cetak/{o}/{aksi}', 'Bumindes_penduduk_sementara@ajax_cetak')->name('bumindes_penduduk_sementara.ajax_cetak');
    Route::post('/cetak/{o}/{aksi}/{privasi_nik?}', 'Bumindes_penduduk_sementara@cetak')->name('bumindes_penduduk_sementara.cetak');
    Route::get('/autocomplete', 'Bumindes_penduduk_sementara@autocomplete')->name('bumindes_penduduk_sementara.autocomplete');
    Route::post('/filter/{filter}', 'Bumindes_penduduk_sementara@filter')->name('bumindes_penduduk_sementara.filter');
});

Route::group('bumindes_penduduk_ktpkk', static function (): void {
    Route::match(['GET', 'POST'], '/', 'Bumindes_penduduk_ktpkk@index');
    Route::match(['GET', 'POST'], '/index', 'Bumindes_penduduk_ktpkk@index');
    Route::match(['GET', 'POST'], '/index/{page_number}', 'Bumindes_penduduk_ktpkk@index');
    Route::match(['GET', 'POST'], '/index/{page_number}/{order_by}', 'Bumindes_penduduk_ktpkk@index');
    Route::get('/clear', 'Bumindes_penduduk_ktpkk@clear')->name('bumindes_penduduk_ktpkk.clear');
    Route::get('/ajax_cetak/{page}/{o}/{aksi}', 'Bumindes_penduduk_ktpkk@ajax_cetak')->name('bumindes_penduduk_ktpkk.ajax_cetak');
    Route::post('/cetak/{page}/{o}/{aksi}/{privasi_nik?}', 'Bumindes_penduduk_ktpkk@cetak')->name('bumindes_penduduk_ktpkk.cetak');
    Route::get('/autocomplete', 'Bumindes_penduduk_ktpkk@autocomplete')->name('bumindes_penduduk_ktpkk.autocomplete');
    Route::post('/filter/{filter}', 'Bumindes_penduduk_ktpkk@filter')->name('bumindes_penduduk_ktpkk.filter');
});

// - Buku Administrasi Pembangunan
// -- Buku Rencana Kerja Pembangunan
Route::group('bumindes_rencana_pembangunan', static function (): void {
    Route::get('/', 'Bumindes_rencana_pembangunan@index')->name('bumindes_rencana_pembangunan.index');
    Route::post('/', 'Bumindes_rencana_pembangunan@index')->name('bumindes_rencana_pembangunan.datatables');
    Route::get('/dialog/{aksi?}', 'Bumindes_rencana_pembangunan@dialog')->name('bumindes_rencana_pembangunan.dialog');
    Route::post('/cetak/{aksi?}', 'Bumindes_rencana_pembangunan@cetak')->name('bumindes_rencana_pembangunan.cetak');
    Route::get('/lainnya/{submenu}', 'Bumindes_rencana_pembangunan@lainnya')->name('bumindes_rencana_pembangunan.lainnya');
});

// -- Buku Kegiatan Pembangunan
Route::group('bumindes_kegiatan_pembangunan', static function (): void {
    Route::get('/', 'Bumindes_kegiatan_pembangunan@index')->name('bumindes_kegiatan_pembangunan.index');
    Route::post('/', 'Bumindes_kegiatan_pembangunan@index')->name('bumindes_kegiatan_pembangunan.datatables');
    Route::get('/dialog/{aksi?}', 'Bumindes_kegiatan_pembangunan@dialog')->name('bumindes_kegiatan_pembangunan.dialog');
    Route::post('/cetak/{aksi?}', 'Bumindes_kegiatan_pembangunan@cetak')->name('bumindes_kegiatan_pembangunan.cetak');
    Route::get('/lainnya/{submenu}', 'Bumindes_kegiatan_pembangunan@lainnya')->name('bumindes_kegiatan_pembangunan.lainnya');
});

// -- Buku Inventaris Hasil-hasil Pembangunan
Route::group('bumindes_hasil_pembangunan', static function (): void {
    Route::get('/', 'Bumindes_hasil_pembangunan@index')->name('bumindes_hasil_pembangunan.index');
    Route::post('/', 'Bumindes_hasil_pembangunan@index')->name('bumindes_hasil_pembangunan.datatables');
    Route::get('/dialog/{aksi?}', 'Bumindes_hasil_pembangunan@dialog')->name('bumindes_hasil_pembangunan.dialog');
    Route::post('/cetak/{aksi?}', 'Bumindes_hasil_pembangunan@cetak')->name('bumindes_hasil_pembangunan.cetak');
    Route::get('/lainnya/{submenu}', 'Bumindes_hasil_pembangunan@lainnya')->name('bumindes_hasil_pembangunan.lainnya');
});

// -- Buku Kader Pemberdayaan Masyarakat
Route::group('bumindes_kader', static function (): void {
    Route::get('/', 'Bumindes_kader@index')->name('bumindes_kader.index');
    Route::post('/', 'Bumindes_kader@index')->name('bumindes_kader.datatables');
    Route::get('/get_bidang', 'Bumindes_kader@get_bidang')->name('bumindes_kader.get_bidang');
    Route::get('/get_kursus', 'Bumindes_kader@get_kursus')->name('bumindes_kader.get_kursus');
    Route::get('/form/{id?}', 'Bumindes_kader@form')->name('bumindes_kader.form');
    Route::post('/tambah', 'Bumindes_kader@tambah')->name('bumindes_kader.tambah');
    Route::post('/ubah/{id}', 'Bumindes_kader@ubah')->name('bumindes_kader.ubah');
    Route::get('/hapus/{id?}', 'Bumindes_kader@hapus')->name('bumindes_kader.hapus');
    Route::post('/hapus_semua', 'Bumindes_kader@hapus_semua')->name('bumindes_kader.hapus_semua');
    Route::get('/dialog/{aksi?}', 'Bumindes_kader@dialog')->name('bumindes_kader.dialog');
    Route::post('/cetak/{aksi?}', 'Bumindes_kader@cetak')->name('bumindes_kader.cetak');
});

// - Arsip Desa
Route::group('bumindes_arsip', static function (): void {
    Route::get('/index', 'Bumindes_arsip@index')->name('bumindes_arsip.index-first');
    Route::get('/index/{p?}/{o?}', 'Bumindes_arsip@index')->name('bumindes_arsip.index-page');
    Route::get('/tindakan_lihat/{kategori}/{id}/{tindakan}', 'Bumindes_arsip@tindakan_lihat')->name('bumindes_arsip.tindakan_lihat');
    Route::get('/tindakan_ubah/{kategori}/{id}/{p}/{o}', 'Bumindes_arsip@tindakan_ubah')->name('bumindes_arsip.tindakan_ubah');
    Route::get('/tampilkan_berkas/{tabel}/{berkas}/{tampil?}', 'Bumindes_arsip@tampilkan_berkas')->name('bumindes_arsip.tampilkan_berkas');
    Route::get('/unduh_berkas/{tabel}/{berkas}', 'Bumindes_arsip@unduh_berkas')->name('bumindes_arsip.unduh_berkas');
    Route::get('/modal_ubah_arsip/{tabel}/{id}/{p}/{o}', 'Bumindes_arsip@modal_ubah_arsip')->name('bumindes_arsip.modal_ubah_arsip');
    Route::post('/ubah_dokumen/{tabel}/{id}/{p}/{o}', 'Bumindes_arsip@ubah_dokumen')->name('bumindes_arsip.ubah_dokumen');
    Route::get('/clear/{kategori?}', 'Bumindes_arsip@clear')->name('bumindes_arsip.clear');
    Route::match(['GET', 'POST'], '/', 'Bumindes_arsip@index');
    Route::match(['GET', 'POST'], '/{page_number}', 'Bumindes_arsip@index');
    Route::match(['GET', 'POST'], '/{page_number}/{order_by}', 'Bumindes_arsip@index');
    Route::match(['GET', 'POST'], '/index', 'Bumindes_arsip@index');
    Route::match(['GET', 'POST'], '/index/{page_number}', 'Bumindes_arsip@index');
    Route::match(['GET', 'POST'], '/index/{page_number}/{order_by}', 'Bumindes_arsip@index');
});

// Keuangan > Impor Data
// Keuangan > Laporan
Route::group('keuangan', static function (): void {
    Route::get('/setdata_laporan/{tahun}/{semester}', 'Keuangan@setdata_laporan')->name('keuangan.setdata_laporan');
    Route::get('/laporan', 'Keuangan@laporan')->name('keuangan.laporan');
    Route::get('/grafik/{jenis}', 'Keuangan@grafik')->name('keuangan.grafik');
    Route::get('/impor_data', 'Keuangan@impor_data')->name('keuangan.impor_data');
    Route::post('/proses_impor', 'Keuangan@proses_impor')->name('keuangan.proses_impor');
    Route::match(['GET', 'POST'], '/cek_versi_database', 'Keuangan@cek_versi_database')->name('keuangan.cek_versi_database');
    Route::match(['GET', 'POST'], '/cek_tahun', 'Keuangan@cek_tahun')->name('keuangan.cek_tahun');
    Route::get('/delete/{id?}', 'Keuangan@delete')->name('keuangan.delete');
    Route::get('/pilih_desa/{id_master}', 'Keuangan@pilih_desa')->name('keuangan.pilih_desa');
    Route::match(['GET', 'POST'], '/bersihkan_desa/{id_master}', 'Keuangan@bersihkan_desa')->name('keuangan.bersihkan_desa');
});
// Keuangan > Input Data
// Keuangan > Laporan Manual
Route::group('keuangan_manual', static function (): void {
    Route::match(['GET', 'POST'], '/', 'Keuangan_manual@index')->name('keuangan_manual.index');
    Route::get('/setdata_laporan/{tahun}/{semester}', 'Keuangan_manual@setdata_laporan')->name('keuangan_manual.setdata_laporan');
    Route::get('/laporan_manual', 'Keuangan_manual@laporan_manual')->name('keuangan_manual.laporan_manual');
    Route::get('/grafik_manual/{jenis}', 'Keuangan_manual@grafik_manual')->name('keuangan_manual.grafik_manual');
    Route::match(['GET', 'POST'], '/manual_apbdes', 'Keuangan_manual@manual_apbdes')->name('keuangan_manual.manual_apbdes');
    Route::get('/data_anggaran', 'Keuangan_manual@data_anggaran')->name('keuangan_manual.data_anggaran');
    Route::get('/load_data', 'Keuangan_manual@load_data')->name('keuangan_manual.load_data');
    Route::get('/get_anggaran', 'Keuangan_manual@get_anggaran')->name('keuangan_manual.get_anggaran');
    Route::post('/simpan_anggaran', 'Keuangan_manual@simpan_anggaran')->name('keuangan_manual.simpan_anggaran');
    Route::post('/update_anggaran', 'Keuangan_manual@update_anggaran')->name('keuangan_manual.update_anggaran');
    Route::get('/delete_input/{id?}', 'Keuangan_manual@delete_input')->name('keuangan_manual.delete_input');
    Route::post('/delete_all', 'Keuangan_manual@delete_all')->name('keuangan_manual.delete_all');
    Route::post('/salin_anggaran_tpl', 'Keuangan_manual@salin_anggaran_tpl')->name('keuangan_manual.salin_anggaran_tpl');
    Route::get('/cek_tahun_manual', 'Keuangan_manual@cek_tahun_manual')->name('keuangan_manual.cek_tahun_manual');
    Route::post('/set_terpilih', 'Keuangan_manual@set_terpilih')->name('keuangan_manual.set_terpilih');
});
// Keuangan > Laporan APBDes
Route::group('laporan_apbdes', static function (): void {
    Route::get('/', 'Laporan_apbdes@index')->name('laporan_apbdes.index');
    Route::post('/datatables', 'Laporan_apbdes@datatables')->name('laporan_apbdes.datatables');
    Route::get('/form/{id?}', 'Laporan_apbdes@form')->name('laporan_apbdes.form');
    Route::post('/insert', 'Laporan_apbdes@insert')->name('laporan_apbdes.insert');
    Route::post('/update/{id}', 'Laporan_apbdes@update')->name('laporan_apbdes.update');
    Route::post('/delete_all', 'Laporan_apbdes@delete_all')->name('laporan_apbdes.delete_all');
    Route::get('/unduh/{id?}', 'Laporan_apbdes@unduh')->name('laporan_apbdes.unduh');
    Route::post('/kirim', 'Laporan_apbdes@kirim')->name('laporan_apbdes.kirim');
});

// Analisis > Master Analisis
Route::group('analisis_master', static function (): void {
    Route::match(['GET', 'POST'], '/', 'Analisis_master@index')->name('analisis_master.index-default');
    Route::match(['GET', 'POST'], '/index', 'Analisis_master@index')->name('analisis_master.index-1');
    Route::match(['GET', 'POST'], '/index/{p}', 'Analisis_master@index')->name('analisis_master.index-2');
    Route::match(['GET', 'POST'], '/index/{p}/{o}', 'Analisis_master@index')->name('analisis_master.index-3');
    Route::get('/clear', 'Analisis_master@clear')->name('analisis_master.clear');
    Route::get('/leave', 'Analisis_master@leave')->name('analisis_master.leave');
    Route::get('/form', 'Analisis_master@form')->name('analisis_master.form');
    Route::get('/form/{p}', 'Analisis_master@form')->name('analisis_master.form-1');
    Route::get('/form/{p}/{o}', 'Analisis_master@form')->name('analisis_master.form-2');
    Route::get('/form/{p}/{o}/{id}', 'Analisis_master@form')->name('analisis_master.form-3');
    Route::get('/panduan', 'Analisis_master@panduan')->name('analisis_master.panduan');
    Route::get('/import_analisis', 'Analisis_master@import_analisis')->name('analisis_master.import_analisis');
    Route::post('/import', 'Analisis_master@import')->name('analisis_master.import');
    Route::get('/ekspor/{id}', 'Analisis_master@ekspor')->name('analisis_master.ekspor');
    Route::get('/import_gform/{id?}', 'Analisis_master@import_gform')->name('analisis_master.import_gform');
    Route::get('/menu/{id?}', 'Analisis_master@menu')->name('analisis_master.menu');
    Route::post('/search', 'Analisis_master@search')->name('analisis_master.search');
    Route::post('/filter', 'Analisis_master@filter')->name('analisis_master.filter');
    Route::post('/state', 'Analisis_master@state')->name('analisis_master.state');
    Route::post('/insert', 'Analisis_master@insert')->name('analisis_master.insert');
    Route::post('/exec_import_gform', 'Analisis_master@exec_import_gform')->name('analisis_master.exec_import_gform');
    Route::post('/update/{p}/{o}/{id}', 'Analisis_master@update')->name('analisis_master.update');
    Route::get('/delete/{p}/{o}/{id}', 'Analisis_master@delete')->name('analisis_master.delete');
    Route::post('/delete_all/{p}/{o}', 'Analisis_master@delete_all')->name('analisis_master.delete_all');
    Route::post('/save_import_gform/{id?}', 'Analisis_master@save_import_gform')->name('analisis_master.save_import_gform');
    Route::match(['GET', 'POST'], '/update_gform/{id?}', 'Analisis_master@update_gform')->name('analisis_master.update_gform');
});

Route::group('analisis_kategori', static function (): void {
    Route::get('/clear/{id?}', 'Analisis_kategori@clear')->name('analisis_kategori.clear');
    Route::match(['GET', 'POST'], '/', 'Analisis_kategori@index');
    Route::match(['GET', 'POST'], '/index', 'Analisis_kategori@index');
    Route::match(['GET', 'POST'], '/index/{p}', 'Analisis_kategori@index');
    Route::match(['GET', 'POST'], '/index/{p}/{o}', 'Analisis_kategori@index');
    Route::get('/form', 'Analisis_kategori@form');
    Route::get('/form/{p}', 'Analisis_kategori@form');
    Route::get('/form/{p}/{o}', 'Analisis_kategori@form');
    Route::get('/form/{p}/{o}/{id}', 'Analisis_kategori@form');
    Route::post('/search', 'Analisis_kategori@search')->name('analisis_kategori.search');
    Route::post('/insert', 'Analisis_kategori@insert')->name('analisis_kategori.insert');
    Route::post('/update/{p}/{o}/{id?}', 'Analisis_kategori@update')->name('analisis_kategori.update');
    Route::get('/delete/{p}/{o}/{id?}', 'Analisis_kategori@delete')->name('analisis_kategori.delete');
    Route::post('/delete_all/{p}/{o}/', 'Analisis_kategori@delete_all')->name('analisis_kategori.delete_all');
});

Route::group('analisis_indikator', static function (): void {
    Route::get('/clear/{id?}', 'Analisis_indikator@clear')->name('analisis_indikator.clear');
    Route::match(['GET', 'POST'], '/', 'Analisis_indikator@index');
    Route::match(['GET', 'POST'], '/index', 'Analisis_indikator@index');
    Route::match(['GET', 'POST'], '/index/{p}', 'Analisis_indikator@index');
    Route::match(['GET', 'POST'], '/index/{p}/{o}', 'Analisis_indikator@index');
    Route::get('/form', 'Analisis_indikator@form');
    Route::get('/form/{p}', 'Analisis_indikator@form');
    Route::get('/form/{p}/{o}', 'Analisis_indikator@form');
    Route::get('/form/{p}/{o}/{id?}', 'Analisis_indikator@form');
    Route::get('/parameter/{id?}', 'Analisis_indikator@parameter')->name('analisis_indikator.parameter');
    Route::get('/form_parameter/{in?}/{id?}', 'Analisis_indikator@form_parameter')->name('analisis_indikator.form_parameter');
    Route::post('/search', 'Analisis_indikator@search')->name('analisis_indikator.search');
    Route::post('/filter', 'Analisis_indikator@filter')->name('analisis_indikator.filter');
    Route::post('/tipe', 'Analisis_indikator@tipe')->name('analisis_indikator.tipe');
    Route::post('/kategori', 'Analisis_indikator@kategori')->name('analisis_indikator.kategori');
    Route::post('/insert', 'Analisis_indikator@insert')->name('analisis_indikator.insert');
    Route::post('/update/{p}/{o}/{id?}', 'Analisis_indikator@update')->name('analisis_indikator.update');
    Route::get('/delete/{p}/{o}/{id?}', 'Analisis_indikator@delete')->name('analisis_indikator.delete');
    Route::post('/delete_all/{p}/{o}', 'Analisis_indikator@delete_all')->name('analisis_indikator.delete_all');
    Route::post('/p_insert/{in?}', 'Analisis_indikator@p_insert')->name('analisis_indikator.p_insert');
    Route::post('/p_update/{in?}/{id?}', 'Analisis_indikator@p_update')->name('analisis_indikator.p_update');
    Route::get('/p_delete/{in?}/{id?}', 'Analisis_indikator@p_delete')->name('analisis_indikator.p_delete');
    Route::get('/p_delete_all/{in?}', 'Analisis_indikator@p_delete_all')->name('analisis_indikator.p_delete_all');
});

Route::group('analisis_klasifikasi', static function (): void {
    Route::get('/clear/{id?}', 'Analisis_klasifikasi@clear')->name('analisis_klasifikasi.clear');
    Route::match(['GET', 'POST'], '/', 'Analisis_klasifikasi@index');
    Route::match(['GET', 'POST'], '/index', 'Analisis_klasifikasi@index');
    Route::match(['GET', 'POST'], '/index/{p}', 'Analisis_klasifikasi@index');
    Route::match(['GET', 'POST'], '/index/{p}/{o}', 'Analisis_klasifikasi@index');
    Route::get('/form', 'Analisis_klasifikasi@form');
    Route::get('/form/{p?}', 'Analisis_klasifikasi@form');
    Route::get('/form/{p}/{o?}', 'Analisis_klasifikasi@form');
    Route::get('/form/{p}/{o}/{id?}', 'Analisis_klasifikasi@form');
    Route::post('/search', 'Analisis_klasifikasi@search')->name('analisis_klasifikasi.search');
    Route::post('/insert', 'Analisis_klasifikasi@insert')->name('analisis_klasifikasi.insert');
    Route::post('/update/{p}/{o}/{id?}', 'Analisis_klasifikasi@update')->name('analisis_klasifikasi.update');
    Route::get('/delete/{p}/{o}/{id?}', 'Analisis_klasifikasi@delete')->name('analisis_klasifikasi.delete');
    Route::post('/delete_all/{p}/{o}', 'Analisis_klasifikasi@delete_all')->name('analisis_klasifikasi.delete_all');
});

Route::group('analisis_periode', static function (): void {
    Route::get('/clear/{id?}', 'Analisis_periode@clear')->name('analisis_periode.clear');
    Route::match(['GET', 'POST'], '/', 'Analisis_periode@index');
    Route::match(['GET', 'POST'], '/index', 'Analisis_periode@index');
    Route::match(['GET', 'POST'], '/index/{p}', 'Analisis_periode@index');
    Route::match(['GET', 'POST'], '/index/{p}/{o}', 'Analisis_periode@index');
    Route::get('/form', 'Analisis_periode@form');
    Route::get('/form/{p}', 'Analisis_periode@form');
    Route::get('/form/{p}/{o}', 'Analisis_periode@form');
    Route::get('/form/{p}/{o}/{id}', 'Analisis_periode@form');
    Route::post('/search', 'Analisis_periode@search')->name('analisis_periode.search');
    Route::post('/state', 'Analisis_periode@state')->name('analisis_periode.state');
    Route::post('/insert', 'Analisis_periode@insert')->name('analisis_periode.insert');
    Route::post('/update/{p}/{o}/{id?}', 'Analisis_periode@update')->name('analisis_periode.update');
    Route::get('/delete/{p}/{o}/{id?}', 'Analisis_periode@delete')->name('analisis_periode.delete');
    Route::post('/delete_all/{p}/{o}', 'Analisis_periode@delete_all')->name('analisis_periode.delete_all');
    Route::get('/list_state', 'Analisis_periode@list_state')->name('analisis_periode.list_state');
});
Route::group('analisis_respon', static function (): void {
    Route::get('/clear/{id?}', 'Analisis_respon@clear')->name('analisis_respon.clear');
    Route::match(['GET', 'POST'], '/', 'Analisis_respon@index');
    Route::match(['GET', 'POST'], '/index', 'Analisis_respon@index');
    Route::match(['GET', 'POST'], '/index/{p}', 'Analisis_respon@index');
    Route::match(['GET', 'POST'], '/index/{p}/{o}', 'Analisis_respon@index');
    Route::get('/kuisioner/{p}/{o}/{id}/{fs?}', 'Analisis_respon@kuisioner')->name('analisis_respon.kuisioner');
    Route::get('/perbaharui/{p}/{o}/{id_subjek?}', 'Analisis_respon@perbaharui')->name('analisis_respon.perbaharui');
    Route::post('/update_kuisioner/{p}/{o}/{id?}', 'Analisis_respon@update_kuisioner')->name('analisis_respon.update_kuisioner');
    Route::get('/kuisioner_child/{p}/{o}/{id}/{idc?}', 'Analisis_respon@kuisioner_child')->name('analisis_respon.kuisioner_child');
    Route::post('/update_kuisioner_child/{p}/{o}/{id}/{idc?}', 'Analisis_respon@update_kuisioner_child')->name('analisis_respon.update_kuisioner_child');
    Route::get('/aturan_unduh', 'Analisis_respon@aturan_unduh')->name('analisis_respon.aturan_unduh');
    Route::get('/data_ajax', 'Analisis_respon@data_ajax')->name('analisis_respon.data_ajax');
    Route::get('/data_unduh/{tipe?}', 'Analisis_respon@data_unduh')->name('analisis_respon.data_unduh');
    Route::get('/import/{op?}', 'Analisis_respon@import')->name('analisis_respon.import');
    Route::post('/import_proses/{op?}', 'Analisis_respon@import_proses')->name('analisis_respon.import_proses');
    Route::post('/search', 'Analisis_respon@search')->name('analisis_respon.search');
    Route::post('/isi', 'Analisis_respon@isi')->name('analisis_respon.isi');
    Route::post('/dusun', 'Analisis_respon@dusun')->name('analisis_respon.dusun');
    Route::post('/rw', 'Analisis_respon@rw')->name('analisis_respon.rw');
    Route::post('/rt', 'Analisis_respon@rt')->name('analisis_respon.rt');
    Route::get('/form_impor_bdt/{id?}', 'Analisis_respon@form_impor_bdt')->name('analisis_respon.form_impor_bdt');
    Route::post('/impor_bdt', 'Analisis_respon@impor_bdt')->name('analisis_respon.impor_bdt');
    Route::get('/unduh_form_bdt/{id?}', 'Analisis_respon@unduh_form_bdt')->name('analisis_respon.unduh_form_bdt');
});

Route::group('analisis_laporan', static function (): void {
    Route::get('/clear/{id?}', 'Analisis_laporan@clear')->name('analisis_laporan.clear');
    Route::match(['GET', 'POST'], '/', 'Analisis_laporan@index');
    Route::match(['GET', 'POST'], '/index', 'Analisis_laporan@index');
    Route::match(['GET', 'POST'], '/index/{p}', 'Analisis_laporan@index');
    Route::match(['GET', 'POST'], '/index/{p}/{o}', 'Analisis_laporan@index');
    Route::get('/kuisioner/{p}/{o}/{id?}', 'Analisis_laporan@kuisioner')->name('analisis_laporan.kuisioner');
    Route::get('/dialog_kuisioner/{p}/{o}/{id}/{aksi?}', 'Analisis_laporan@dialog_kuisioner')->name('analisis_laporan.dialog_kuisioner');
    Route::post('/daftar/{p}/{o}/{id}/{aksi?}', 'Analisis_laporan@daftar')->name('analisis_laporan.daftar');
    Route::get('/dialog/{o}/{aksi?}', 'Analisis_laporan@dialog')->name('analisis_laporan.dialog');
    Route::post('/cetak/{o}/{aksi?}', 'Analisis_laporan@cetak')->name('analisis_laporan.cetak');
    Route::get('/multi_jawab', 'Analisis_laporan@multi_jawab')->name('analisis_laporan.multi_jawab');
    Route::post('/multi_exec', 'Analisis_laporan@multi_exec')->name('analisis_laporan.multi_exec');
    Route::get('/ajax_multi_jawab', 'Analisis_laporan@ajax_multi_jawab')->name('analisis_laporan.ajax_multi_jawab');
    Route::post('/multi_jawab_proses', 'Analisis_laporan@multi_jawab_proses')->name('analisis_laporan.multi_jawab_proses');
    Route::post('/filter/{filter}', 'Analisis_laporan@filter')->name('analisis_laporan.filter');
});

Route::group('analisis_statistik_jawaban', static function (): void {
    Route::get('/clear/{id?}', 'Analisis_statistik_jawaban@clear')->name('analisis_statistik_jawaban.clear');
    Route::match(['GET', 'POST'], '/', 'Analisis_statistik_jawaban@index');
    Route::match(['GET', 'POST'], '/index', 'Analisis_statistik_jawaban@index');
    Route::match(['GET', 'POST'], '/index/{p}', 'Analisis_statistik_jawaban@index');
    Route::match(['GET', 'POST'], '/index/{p}/{o}', 'Analisis_statistik_jawaban@index');
    Route::get('/grafik_parameter/{id?}', 'Analisis_statistik_jawaban@grafik_parameter')->name('analisis_statistik_jawaban.grafik_parameter');
    Route::get('/subjek_parameter/{id}/{par?}', 'Analisis_statistik_jawaban@subjek_parameter')->name('analisis_statistik_jawaban.subjek_parameter');
    Route::get('/cetak/{o?}', 'Analisis_statistik_jawaban@cetak')->name('analisis_statistik_jawaban.cetak');
    Route::get('/excel/{o?}', 'Analisis_statistik_jawaban@excel')->name('analisis_statistik_jawaban.excel');
    Route::get('/cetak2/{id}/{par?}', 'Analisis_statistik_jawaban@cetak2')->name('analisis_statistik_jawaban.cetak2');
    Route::get('/excel2/{id}/{par?}', 'Analisis_statistik_jawaban@excel2')->name('analisis_statistik_jawaban.excel2');
    Route::post('/search', 'Analisis_statistik_jawaban@search')->name('analisis_statistik_jawaban.search');
    Route::post('/filter', 'Analisis_statistik_jawaban@filter')->name('analisis_statistik_jawaban.filter');
    Route::post('/tipe', 'Analisis_statistik_jawaban@tipe')->name('analisis_statistik_jawaban.tipe');
    Route::post('/kategori', 'Analisis_statistik_jawaban@kategori')->name('analisis_statistik_jawaban.kategori');
    Route::post('/dusun', 'Analisis_statistik_jawaban@dusun')->name('analisis_statistik_jawaban.dusun');
    Route::post('/rw', 'Analisis_statistik_jawaban@rw')->name('analisis_statistik_jawaban.rw');
    Route::post('/rt', 'Analisis_statistik_jawaban@rt')->name('analisis_statistik_jawaban.rt');
    Route::post('/dusun2/{id}/{par?}', 'Analisis_statistik_jawaban@dusun2')->name('analisis_statistik_jawaban.dusun2');
    Route::post('/rw2/{id}/{par?}', 'Analisis_statistik_jawaban@rw2')->name('analisis_statistik_jawaban.rw2');
    Route::post('/rt2/{id}/{par?}', 'Analisis_statistik_jawaban@rt2')->name('analisis_statistik_jawaban.rt2');
    Route::post('/dusun3/{id?}', 'Analisis_statistik_jawaban@dusun3')->name('analisis_statistik_jawaban.dusun3');
    Route::post('/rw3/{id?}', 'Analisis_statistik_jawaban@rw3')->name('analisis_statistik_jawaban.rw3');
    Route::post('/rt3/{id?}', 'Analisis_statistik_jawaban@rt3')->name('analisis_statistik_jawaban.rt3');
    Route::get('/delete/{p}/{o}/{id?}', 'Analisis_statistik_jawaban@delete')->name('analisis_statistik_jawaban.delete');
    Route::post('/delete_all/{p}/{o}', 'Analisis_statistik_jawaban@delete_all')->name('analisis_statistik_jawaban.delete_all');
});

// Analisis > Pengaturan
Route::group('setting', static function (): void {
    Route::get('/analisis', 'Setting@analisis')->name('setting.analisis');
});

// Program Bantuan
Route::group('program_bantuan', static function (): void {
    Route::get('/clear', 'Program_bantuan@clear')->name('program_bantuan.clear');
    Route::post('/filter/{filter}', 'Program_bantuan@filter')->name('program_bantuan.filter');
    Route::match(['GET', 'POST'], '/', 'Program_bantuan@index')->name('program_bantuan.index');
    Route::get('/index/{p?}', 'Program_bantuan@index')->name('program_bantuan.index-page');
    Route::get('/apipendudukbantuan', 'Program_bantuan@apipendudukbantuan')->name('program_bantuan.apipendudukbantuan');
    Route::get('/panduan', 'Program_bantuan@panduan')->name('program_bantuan.panduan');
    Route::match(['GET', 'POST'], '/create', 'Program_bantuan@create')->name('program_bantuan.create');
    Route::match(['GET', 'POST'], '/edit/{id?}', 'Program_bantuan@edit')->name('program_bantuan.edit');
    Route::post('/update/{id}', 'Program_bantuan@update')->name('program_bantuan.update');
    Route::get('/hapus/{id}', 'Program_bantuan@hapus')->name('program_bantuan.hapus');
    Route::post('/search/{program_id?}', 'Program_bantuan@search')->name('program_bantuan.search');
    Route::post('/impor', 'Program_bantuan@impor')->name('program_bantuan.impor');
    Route::get('/expor/{program_id?}', 'Program_bantuan@expor')->name('program_bantuan.expor');
    Route::get('/unduh_kartu_peserta/{id_peserta?}', 'Program_bantuan@unduh_kartu_peserta')->name('program_bantuan.unduh_kartu_peserta');
    Route::get('/bersihkan_data', 'Program_bantuan@bersihkan_data')->name('program_bantuan.bersihkan_data');
    Route::post('/bersihkan_data_peserta', 'Program_bantuan@bersihkan_data_peserta')->name('program_bantuan.bersihkan_data_peserta');
});

// Peserta Bantuan > Peserta
Route::group('peserta_bantuan', static function (): void {
    Route::match(['GET', 'POST'], '/detail/{program_id?}/{p?}', 'Peserta_bantuan@detail')->name('peserta_bantuan.detail');
    Route::match(['GET', 'POST'], '/form/{program_id?}', 'Peserta_bantuan@form')->name('peserta_bantuan.form');
    Route::get('/peserta/{cat?}/{id?}', 'Peserta_bantuan@peserta')->name('peserta_bantuan.peserta');
    Route::get('/data_peserta/{id?}', 'Peserta_bantuan@data_peserta')->name('peserta_bantuan.data_peserta');
    Route::match(['GET', 'POST'], '/add_peserta/{program_id?}', 'Peserta_bantuan@add_peserta')->name('peserta_bantuan.add_peserta');
    Route::post('/edit_peserta/{id?}', 'Peserta_bantuan@edit_peserta')->name('peserta_bantuan.edit_peserta');
    Route::get('/edit_peserta_form/{id?}', 'Peserta_bantuan@edit_peserta_form')->name('peserta_bantuan.edit_peserta_form');
    Route::get('/hapus_peserta/{program_id?}/{peserta_id?}', 'Peserta_bantuan@hapus_peserta')->name('peserta_bantuan.hapus_peserta');
    Route::get('/aksi/{aksi?}/{program_id?}', 'Peserta_bantuan@aksi')->name('peserta_bantuan.aksi');
    Route::post('/delete_all/{program_id?}', 'Peserta_bantuan@delete_all')->name('peserta_bantuan.delete_all');
    Route::get('/daftar/{program_id?}/{aksi?}', 'Peserta_bantuan@daftar')->name('peserta_bantuan.daftar');
    Route::get('/detail_clear/{program_id}', 'Peserta_bantuan@detail_clear')->name('peserta_bantuan.detail_clear');
});

// Pertanahan > Daftar Persil
Route::group('data_persil', static function (): void {
    Route::match(['GET', 'POST'], '/', 'Data_persil@index')->name('data_persil.index');
    Route::match(['GET', 'POST'], '/index', 'Data_persil@index')->name('data_persil.index-1');
    Route::match(['GET', 'POST'], '/index/{p}', 'Data_persil@index')->name('data_persil.index-2');
    Route::match(['GET', 'POST'], '/index/{p}/{o}', 'Data_persil@index')->name('data_persil.index-3');
    Route::get('/clear', 'Data_persil@clear')->name('data_persil.clear');
    Route::post('/autocomplete', 'Data_persil@autocomplete')->name('data_persil.autocomplete');
    Route::post('/search', 'Data_persil@search')->name('data_persil.search');
    Route::get('/rincian/{id}', 'Data_persil@rincian')->name('data_persil.rincian');
    Route::get('/form/{id?}/{c_desa?}', 'Data_persil@form')->name('data_persil.form');
    Route::post('/simpan_persil/{page?}', 'Data_persil@simpan_persil')->name('data_persil.simpan_persil');
    Route::get('/hapus/{id?}', 'Data_persil@hapus')->name('data_persil.hapus');
    Route::get('/import', 'Data_persil@import')->name('data_persil.import');
    Route::post('/import_proses', 'Data_persil@import_proses')->name('data_persil.import_proses');
    Route::post('/kelasid', 'Data_persil@kelasid')->name('data_persil.kelasid');
    Route::post('/filter/{filter}', 'Data_persil@filter')->name('data_persil.filter');
    Route::get('/dialog_cetak/{id?}', 'Data_persil@dialog_cetak')->name('data_persil.dialog_cetak');
    Route::post('/cetak/{id?}', 'Data_persil@cetak')->name('data_persil.cetak');
    Route::get('/area_map', 'Data_persil@area_map')->name('data_persil.area_map');
});
// Pertanahan > C-Desa
Route::group('cdesa', static function (): void {
    Route::match(['GET', 'POST'], '/', 'Cdesa@index')->name('cdesa.index');
    Route::match(['GET', 'POST'], '/index', 'Cdesa@index')->name('cdesa.index-1');
    Route::match(['GET', 'POST'], '/index/{p}', 'Cdesa@index')->name('cdesa.index-2');
    Route::match(['GET', 'POST'], '/index/{p}/{o}', 'Cdesa@index')->name('cdesa.index-3');
    Route::get('/clear', 'Cdesa@clear')->name('cdesa.clear');
    Route::post('/autocomplete', 'Cdesa@autocomplete')->name('cdesa.autocomplete');
    Route::post('/search', 'Cdesa@search')->name('cdesa.search');
    Route::get('/rincian/{id}', 'Cdesa@rincian')->name('cdesa.rincian');
    Route::get('/mutasi/{id_cdesa}/{id_persil}', 'Cdesa@mutasi')->name('cdesa.mutasi');
    Route::match(['GET', 'POST'], '/create/{mode?}/{id?}', 'Cdesa@create')->name('cdesa.create');
    Route::post('/simpan_cdesa/{page?}', 'Cdesa@simpan_cdesa')->name('cdesa.simpan_cdesa');
    Route::match(['GET', 'POST'], '/create_mutasi/{id_cdesa}', 'Cdesa@create_mutasi')->name('cdesa.create_mutasi');
    Route::match(['GET', 'POST'], '/create_mutasi/{id_cdesa}/{id_persil}', 'Cdesa@create_mutasi')->name('cdesa.create_mutasi-2');
    Route::match(['GET', 'POST'], '/create_mutasi/{id_cdesa}/{id_persil}/{id_mutasi}', 'Cdesa@create_mutasi')->name('cdesa.create_mutasi-3');
    Route::post('/simpan_mutasi/{id_cdesa?}/{id_mutasi?}', 'Cdesa@simpan_mutasi')->name('cdesa.simpan_mutasi');
    Route::get('/hapus_mutasi/{cdesa}/{id_mutasi?}', 'Cdesa@hapus_mutasi')->name('cdesa.hapus_mutasi');
    Route::post('/cek_nomor/{nomor}', 'Cdesa@cek_nomor')->name('cdesa.cek_nomor');
    Route::get('/panduan', 'Cdesa@panduan')->name('cdesa.panduan');
    Route::get('/hapus/{id?}', 'Cdesa@hapus')->name('cdesa.hapus');
    Route::get('/import', 'Cdesa@import')->name('cdesa.import');
    Route::post('/import_proses', 'Cdesa@import_proses')->name('cdesa.import_proses');
    Route::get('/cetak/{o?}', 'Cdesa@cetak')->name('cdesa.cetak');
    Route::get('/unduh/{o?}', 'Cdesa@unduh')->name('cdesa.unduh');
    Route::get('/form_c_desa/{id?}', 'Cdesa@form_c_desa')->name('cdesa.form_c_desa');
    Route::get('/awal_persil/{id_cdesa}/{id_persil}/{hapus?}', 'Cdesa@awal_persil')->name('cdesa.awal_persil');
});
// Pembagunan
Route::group('admin_pembangunan', static function (): void {
    Route::get('/', 'Admin_pembangunan@index')->name('admin_pembangunan.index');
    Route::get('/datatables', 'Admin_pembangunan@datatables')->name('admin_pembangunan.datatables');
    Route::get('/form/{id?}', 'Admin_pembangunan@form')->name('admin_pembangunan.form');
    Route::post('/create', 'Admin_pembangunan@create')->name('admin_pembangunan.create');
    Route::post('/update/{id?}', 'Admin_pembangunan@update')->name('admin_pembangunan.update');
    Route::get('/delete/{id?}', 'Admin_pembangunan@delete')->name('admin_pembangunan.delete');
    Route::match(['GET', 'POST'], '/maps/{id}', 'Admin_pembangunan@maps')->name('admin_pembangunan.maps');
    Route::post('/update-maps/{id}', 'Admin_pembangunan@updateMaps')->name('admin_pembangunan.update-maps');
    Route::get('/lock/{id?}', 'Admin_pembangunan@lock')->name('admin_pembangunan.lock');
});
// Pembagunan
Route::group('pembangunan_dokumentasi', static function (): void {
    Route::get('/dokumentasi/{id?}', 'Pembangunan_dokumentasi@dokumentasi')->name('pembangunan_dokumentasi.dokumentasi');
    Route::get('/datatables-dokumentasi/{id?}', 'Pembangunan_dokumentasi@datatablesDokumentasi')->name('pembangunan_dokumentasi.datatables-dokumentasi');
    Route::get('/form-dokumentasi/{id_pembangunan}/{id?}', 'Pembangunan_dokumentasi@formDokumentasi')->name('pembangunan_dokumentasi.form-dokumentasi');
    Route::post('/create-dokumentasi', 'Pembangunan_dokumentasi@createDokumentasi')->name('pembangunan_dokumentasi.create-dokumentasi');
    Route::post('/update-dokumentasi/{id}', 'Pembangunan_dokumentasi@updateDokumentasi')->name('pembangunan_dokumentasi.update-dokumentasi');
    Route::get('/delete-dokumentasi/{id_pembangunan}/{id?}', 'Pembangunan_dokumentasi@deleteDokumentasi')->name('pembangunan_dokumentasi.delete-dokumentasi');
    Route::get('/dialog/{id}/{aksi?}', 'Pembangunan_dokumentasi@dialog')->name('pembangunan_dokumentasi.dialog');
    Route::post('/daftar/{id}/{aksi?}', 'Pembangunan_dokumentasi@daftar')->name('pembangunan_dokumentasi.daftar');

});
// Lapak
Route::group('lapak_admin', static function (): void {
    Route::get('/', 'Lapak_admin@index')->name('lapak_admin.index');
    Route::get('/produk', 'Lapak_admin@produk')->name('lapak_admin.produk');
    Route::post('/produk', 'Lapak_admin@produk')->name('lapak_admin.produk.datatables');
    Route::get('/navigasi', 'Lapak_admin@navigasi')->name('lapak_admin.navigasi');
    Route::get('/produk_form/{id?}', 'Lapak_admin@produk_form')->name('lapak_admin.form');
    Route::post('/produk_insert', 'Lapak_admin@produk_insert')->name('lapak_admin.insert');
    Route::post('/produk_update/{id?}', 'Lapak_admin@produk_update')->name('lapak_admin.update');
    Route::get('/produk_delete/{id}', 'Lapak_admin@produk_delete')->name('lapak_admin.delete');
    Route::post('/produk_delete_all', 'Lapak_admin@produk_delete_all')->name('lapak_admin.delete.all');
    Route::get('/produk_detail/{id?}', 'Lapak_admin@produk_detail')->name('lapak_admin.detail');
    Route::get('/produk_status/{id?}/{status?}', 'Lapak_admin@produk_status')->name('lapak_admin.produk.status');
    Route::get('/pelapak', 'Lapak_admin@pelapak')->name('lapak_admin.pelapak');
    Route::post('/pelapak', 'Lapak_admin@pelapak')->name('lapak_admin.pelapak.datatables');
    Route::get('/pelapak_form/{id?}', 'Lapak_admin@pelapak_form')->name('lapak_admin.pelapak.form');
    Route::get('/pelapak_maps/{id?}', 'Lapak_admin@pelapak_maps')->name('lapak_admin.pelapak.maps');
    Route::post('/pelapak_insert', 'Lapak_admin@pelapak_insert')->name('lapak_admin.pelapak.insert');
    Route::match(['GET', 'POST'], '/pelapak_update_maps/{id?}', 'Lapak_admin@pelapak_update_maps')->name('lapak_admin.pelapak.update.maps');
    Route::match(['GET', 'POST'], '/pelapak_update/{id?}', 'Lapak_admin@pelapak_update')->name('lapak_admin.pelapak.update');
    Route::get('/pelapak_delete/{id?}', 'Lapak_admin@pelapak_delete')->name('lapak_admin.pelapak.delete');
    Route::post('/pelapak_delete_all', 'Lapak_admin@pelapak_delete_all')->name('lapak_admin.pelapak.delete.all');
    Route::get('/pelapak_status/{id?}/{status?}', 'Lapak_admin@pelapak_status')->name('lapak_admin.pelapak.status');
    Route::get('/kategori', 'Lapak_admin@kategori')->name('lapak_admin.kategori');
    Route::post('/kategori', 'Lapak_admin@kategori')->name('lapak_admin.kategori.datatables');
    Route::get('/kategori_form/{id?}', 'Lapak_admin@kategori_form')->name('lapak_admin.kategori.form');
    Route::post('/kategori_insert', 'Lapak_admin@kategori_insert')->name('lapak_admin.kategori.insert');
    Route::match(['GET', 'POST'], '/kategori_update/{id?}', 'Lapak_admin@kategori_update')->name('lapak_admin.kategori.update');
    Route::get('/kategori_delete/{id?}', 'Lapak_admin@kategori_delete')->name('lapak_admin.kategori.delete');
    Route::post('/kategori_delete_all', 'Lapak_admin@kategori_delete_all')->name('lapak_admin.kategori.delete.all');
    Route::get('/kategori_status/{id?}/{status?}', 'Lapak_admin@kategori_status')->name('lapak_admin.kategori.status');
    Route::get('/pengaturan', 'Lapak_admin@pengaturan')->name('lapak_admin.pengaturan');
});

// Pengaduan
Route::group('pengaduan_admin', static function (): void {
    Route::get('/', 'Pengaduan_admin@index')->name('pengaduan_admin.index');
    Route::get('/datatables', 'Pengaduan_admin@datatables')->name('pengaduan_admin.datatables');
    Route::get('/form/{id}', 'Pengaduan_admin@form')->name('pengaduan_admin.form');
    Route::post('/kirim/{id}', 'Pengaduan_admin@kirim')->name('pengaduan_admin.kirim');
    Route::get('/detail/{id}', 'Pengaduan_admin@detail')->name('pengaduan_admin.detail');
    Route::get('/delete/{id}', 'Pengaduan_admin@delete')->name('pengaduan_admin.delete');
    Route::post('/delete', 'Pengaduan_admin@delete')->name('pengaduan_admin.delete-all');
});

// OpenDK > Pesan
Route::group('opendk_pesan', static function (): void {
    Route::get('/', 'Opendk_pesan@index')->name('opendk_pesan.index');
    Route::get('/cek', 'Opendk_pesan@cek')->name('opendk_pesan.cek');
    Route::get('/clear/{return?}', 'Opendk_pesan@clear')->name('opendk_pesan.clear');
    Route::post('/filter/{filter}/{return?}', 'Opendk_pesan@filter')->name('opendk_pesan.filter');
    Route::get('/search/{slash?}', 'Opendk_pesan@search')->name('opendk_pesan.search');
    Route::get('/show/{id}', 'Opendk_pesan@show')->name('opendk_pesan.show');
    Route::get('/form', 'Opendk_pesan@form')->name('opendk_pesan.form');
    Route::post('/insert/{id?}', 'Opendk_pesan@insert')->name('opendk_pesan.insert');
    Route::get('/arsip', 'Opendk_pesan@arsip')->name('opendk_pesan.arsip');
    Route::post('/arsipkan', 'Opendk_pesan@arsipkan')->name('opendk_pesan.arsipkan');
    Route::get('/getPesan', 'Opendk_pesan@getPesan')->name('opendk_pesan.getPesan');
});

// OpenDK > Sinkronisasi
Route::group('sinkronisasi', static function (): void {
    Route::get('/', 'Sinkronisasi@index')->name('sinkronisasi.index');
    Route::get('/sterilkan', 'Sinkronisasi@sterilkan')->name('sinkronisasi.sterilkan');
    Route::get('/kirim/{modul}', 'Sinkronisasi@kirim')->name('sinkronisasi.kirim');
    Route::get('/unduh/{modul}', 'Sinkronisasi@unduh')->name('sinkronisasi.unduh');
    Route::post('/total', 'Sinkronisasi@total')->name('sinkronisasi.total');
    Route::get('/kirim_program_bantuan', 'Sinkronisasi@kirim_program_bantuan')->name('sinkronisasi.kirim_program_bantuan');
    Route::get('/data_program_bantuan', 'Sinkronisasi@data_program_bantuan')->name('sinkronisasi.data_program_bantuan');
    Route::get('/kirim_peserta_program_bantuan', 'Sinkronisasi@kirim_peserta_program_bantuan')->name('sinkronisasi.kirim_peserta_program_bantuan');
    Route::get('/data_peserta_program_bantuan', 'Sinkronisasi@data_peserta_program_bantuan')->name('sinkronisasi.data_peserta_program_bantuan');
    Route::get('/kirim_pembangunan', 'Sinkronisasi@kirim_pembangunan')->name('sinkronisasi.kirim_pembangunan');
    Route::get('/data_pembangunan', 'Sinkronisasi@data_pembangunan')->name('sinkronisasi.data_pembangunan');
    Route::get('/kirim_dokumentasi_pembangunan', 'Sinkronisasi@kirim_dokumentasi_pembangunan')->name('sinkronisasi.kirim_dokumentasi_pembangunan');
    Route::get('/make_dokumentasi_pembangunan', 'Sinkronisasi@make_dokumentasi_pembangunan')->name('sinkronisasi.make_dokumentasi_pembangunan');
});

// Pemetaan > Peta
Route::group('gis', static function (): void {
    Route::get('/clear', 'Gis@clear')->name('gis.clear');
    Route::get('/', 'Gis@index')->name('gis.index');
    Route::post('/search', 'Gis@search')->name('gis.search');
    Route::post('/filter', 'Gis@filter')->name('gis.filter');
    Route::post('/layer_penduduk', 'Gis@layer_penduduk')->name('gis.layer_penduduk');
    Route::post('/layer_wilayah', 'Gis@layer_wilayah')->name('gis.layer_wilayah');
    Route::post('/layer_area', 'Gis@layer_area')->name('gis.layer_area');
    Route::post('/layer_lokasi', 'Gis@layer_lokasi')->name('gis.layer_lokasi');
    Route::post('/layer_keluarga', 'Gis@layer_keluarga')->name('gis.layer_keluarga');
    Route::post('/layer_rtm', 'Gis@layer_rtm')->name('gis.layer_rtm');
    Route::post('/sex', 'Gis@sex')->name('gis.sex');
    Route::post('/dusun', 'Gis@dusun')->name('gis.dusun');
    Route::post('/rw', 'Gis@rw')->name('gis.rw');
    Route::post('/rt', 'Gis@rt')->name('gis.rt');
    Route::post('/agama', 'Gis@agama')->name('gis.agama');
    Route::get('/ajax_adv_search', 'Gis@ajax_adv_search')->name('gis.ajax_adv_search');
    Route::post('/adv_search_proses', 'Gis@adv_search_proses')->name('gis.adv_search_proses');
    Route::post('/layer_garis', 'Gis@layer_garis')->name('gis.layer_garis');
});
// Pemetaan > Pengaturan > Lokasi
Route::group('plan', static function (): void {
    Route::get('/', 'Plan@index')->name('plan.index-default');
    Route::get('/index', 'Plan@index')->name('plan.index');
    Route::get('/index/{parent}', 'Plan@index')->name('plan.index-2');
    Route::get('/datatables', 'Plan@datatables')->name('plan.datatables');
    Route::get('/form/{parent?}/{id?}', 'Plan@form')->name('plan.form');
    Route::get('/ajax_lokasi_maps/{parent?}/{id?}', 'Plan@ajax_lokasi_maps')->name('plan.ajax_lokasi_maps');
    Route::post('/update_maps/{parent}/{id}', 'Plan@update_maps')->name('plan.update_maps');
    Route::post('/insert/{parent}', 'Plan@insert')->name('plan.insert');
    Route::post('/update/{parent}/{id}', 'Plan@update')->name('plan.update');
    Route::match(['GET', 'POST'], '/delete/{id?}', 'Plan@delete')->name('plan.delete');
    Route::get('/lock/{parent}/{id}', 'Plan@lock')->name('plan.lock');
    Route::get('/unlock/{parent}/{id}', 'Plan@unlock')->name('plan.unlock');
});

// Pemetaan > Pengaturan > Tipe Lokasi
Route::group('point', static function (): void {
    Route::get('/', 'Point@index')->name('point.index');
    Route::get('/datatables', 'Point@datatables')->name('point.datatables');
    Route::get('/form/{id?}', 'Point@form')->name('point.form-default');
    Route::get('/form/{id}/{subpoint?}', 'Point@form')->name('point.form');
    Route::get('/sub_point/{point}', 'Point@sub_point')->name('point.sub_point');
    Route::get('/ajax_add_sub_point/{point?}/{id?}', 'Point@ajax_add_sub_point')->name('point.ajax_add_sub_point');
    Route::match(['GET', 'POST'], '/insert', 'Point@insert')->name('point.insert-default');
    Route::match(['GET', 'POST'], '/insert/{subpoint}', 'Point@insert')->name('point.insert');
    Route::post('/update/{id?}/{subpoint?}', 'Point@update')->name('point.update');
    Route::match(['GET', 'POST'], '/delete/{id?}/{subpoint?}', 'Point@delete')->name('point.delete');
    Route::get('/lock/{id}/{val}/{subpoint?}', 'Point@lock')->name('point.lock');
});
// Pemetaan > Pengaturan > Simbol Lokasi
Route::group('simbol', static function (): void {
    Route::get('/', 'Simbol@index')->name('simbol.index');
    Route::post('/tambah_simbol', 'Simbol@tambah_simbol')->name('simbol.tambah_simbol');
    Route::get('/delete_simbol/{id?}', 'Simbol@delete_simbol')->name('simbol.delete_simbol');
    Route::get('/salin_simbol_default', 'Simbol@salin_simbol_default')->name('simbol.salin_simbol_default');
    Route::get('/salin_simbol', 'Simbol@salin_simbol')->name('simbol.salin_simbol');
    Route::post('/upload_simbol', 'Simbol@upload_simbol')->name('simbol.upload_simbol');
});

// Pemetaan > Pengaturan > Garis
Route::group('garis', static function (): void {
    Route::get('/', 'Garis@index')->name('garis.index-default');
    Route::get('/index', 'Garis@index')->name('garis.index');
    Route::get('/index/{parent?}', 'Garis@index')->name('garis.index-2');
    Route::get('/datatables', 'Garis@datatables')->name('garis.datatables');
    Route::get('/form/{parent}/{id?}', 'Garis@form')->name('garis.form');
    Route::get('/ajax_garis_maps/{parent}/{id}', 'Garis@ajax_garis_maps')->name('garis.ajax_garis_maps');
    Route::post('/update_maps/{parent}/{id}', 'Garis@update_maps')->name('garis.update_maps');
    Route::get('/kosongkan/{parent}/{id}', 'Garis@kosongkan')->name('garis.kosongkan');
    Route::post('/insert/{parent}', 'Garis@insert')->name('garis.insert');
    Route::post('/update/{parent}/{id?}', 'Garis@update')->name('garis.update');
    Route::match(['GET', 'POST'], '/delete/{parent}/{id?}', 'Garis@delete')->name('garis.delete');
    Route::get('/lock/{parent}/{id}', 'Garis@lock')->name('garis.lock');
    Route::get('/unlock/{parent}/{id}', 'Garis@unlock')->name('garis.unlock');
});
// Pemetaan > Pengaturan > Tipe Garis
Route::group('line', static function (): void {
    Route::get('/', 'Line@index')->name('line.index-default');
    Route::get('/index', 'Line@index')->name('line.index');
    Route::get('/datatables', 'Line@datatables')->name('line.datatables');
    Route::get('/form/{parent}', 'Line@form')->name('line.form-default');
    Route::get('/form/{parent}/{id?}', 'Line@form')->name('line.form');
    Route::get('/ajax_add_sub_line/{parent}', 'Line@ajax_add_sub_line')->name('line.ajax_add_sub_line');
    Route::post('/insert/{parent}', 'Line@insert')->name('line.insert');
    Route::post('/update/{parent}/{id?}', 'Line@update')->name('line.update');
    Route::match(['GET', 'POST'], '/delete/{parent}/{id?}', 'Line@delete')->name('line.delete');
    Route::get('/lock/{parent}/{id?}', 'Line@lock')->name('line.lock');
    Route::get('/unlock/{parent}/{id?}', 'Line@unlock')->name('line.unlock');
});
// Pemetaan > Pengaturan > Area
Route::group('area', static function (): void {
    Route::get('/', 'Area@index')->name('area.index-default');
    Route::get('/index', 'Area@index')->name('area.index-1');
    Route::get('/index/{parent}', 'Area@index')->name('area.index');
    Route::get('/datatables', 'Area@datatables')->name('area.datatables');
    Route::get('/form', 'Area@form')->name('area.form-default');
    Route::get('/form/{parent}/{id?}', 'Area@form')->name('area.form');
    Route::get('/ajax_area_maps/{parent}/{id}', 'Area@ajax_area_maps')->name('area.ajax_area_maps');
    Route::post('/update_maps/{parent}/{id}', 'Area@update_maps')->name('area.update_maps');
    Route::get('/kosongkan/{parent}/{id}', 'Area@kosongkan')->name('area.kosongkan');
    Route::post('/insert/{parent}', 'Area@insert')->name('area.insert');
    Route::post('/update/{parent}/{id}', 'Area@update')->name('area.update');
    Route::match(['GET', 'POST'], '/delete/{parent}/{id?}', 'Area@delete')->name('area.delete');
    Route::get('/lock/{parent}/{id?}', 'Area@lock')->name('area.lock');
    Route::get('/unlock/{parent}/{id?}', 'Area@unlock')->name('area.unlock');
});
// Pemetaan > Pengaturan > Tipe Area
Route::group('polygon', static function (): void {
    Route::get('/', 'Polygon@index')->name('polygon.index-default');
    Route::get('/index', 'Polygon@index')->name('polygon.index');
    Route::get('/datatables', 'Polygon@datatables')->name('polygon.datatables');
    Route::get('/form', 'Polygon@form')->name('polygon.form-default');
    Route::get('/form/{parent}/{id?}', 'Polygon@form')->name('polygon.form');
    Route::get('/ajax_add_sub_polygon/{parent?}', 'Polygon@ajax_add_sub_polygon')->name('polygon.ajax_add_sub_polygon');
    Route::post('/insert/{parent}', 'Polygon@insert')->name('polygon.insert');
    Route::post('/update/{parent}/{id?}', 'Polygon@update')->name('polygon.update');
    Route::get('/delete/{parent}/{id?}', 'Polygon@delete')->name('polygon.delete');
    Route::post('/delete_all/{parent}', 'Polygon@delete_all')->name('polygon.delete_all');
    Route::get('/polygon_lock/{parent}/{id?}', 'Polygon@polygon_lock')->name('polygon.polygon_lock');
    Route::get('/polygon_unlock/{parent}/{id?}', 'Polygon@polygon_unlock')->name('polygon.polygon_unlock');
});

// Hubung Warga > Kirim Pesan
Route::group('sms', static function (): void {
    Route::get('/clear', 'Sms@clear')->name('sms.clear');
    Route::match(['GET', 'POST'], '/', 'Sms@index')->name('sms.index');
    Route::match(['GET', 'POST'], '/outbox', 'Sms@outbox')->name('sms.outbox');
    Route::match(['GET', 'POST'], '/sentitem', 'Sms@sentitem')->name('sms.sentitem');
    Route::match(['GET', 'POST'], '/pending', 'Sms@pending')->name('sms.pending');
    Route::get('/form/{tipe?}/{id?}', 'Sms@form')->name('sms.form');
    Route::get('/broadcast/{p?}/{s?}/{t?}', 'Sms@broadcast')->name('sms.broadcast');
    Route::post('/broadcast_proses', 'Sms@broadcast_proses')->name('sms.broadcast_proses');
    Route::post('/insert/{tipe}/{id?}', 'Sms@insert')->name('sms.insert');
    Route::post('/update/{id?}', 'Sms@update')->name('sms.update');
    Route::get('/delete/{tipe?}/{id?}', 'Sms@delete')->name('sms.delete');
    Route::post('/deleteAll/{tipe?}', 'Sms@deleteAll')->name('sms.deleteAll');
    Route::get('/arsip', 'Sms@arsip')->name('sms.arsip');
    Route::get('/arsipdatatables', 'Sms@arsipDatatables')->name('sms.arsipDatatables');
    Route::get('/kirim', 'Sms@kirim')->name('sms.kirim');
    Route::post('/proseskirim', 'Sms@prosesKirim')->name('sms.prosesKirim');
    Route::match(['GET', 'POST'], '/hubungDelete/{id?}', 'Sms@hubungDelete')->name('sms.hubungDelete');
});
// Hubung Warga > Daftar Kontak
Route::group('daftar_kontak', static function (): void {
    Route::get('/', 'Daftar_kontak@index')->name('daftar_kontak.index');
    Route::get('/datatables', 'Daftar_kontak@datatables')->name('daftar_kontak.datatables');
    Route::get('/penduduk', 'Daftar_kontak@penduduk')->name('daftar_kontak.penduduk');
    Route::get('/datatablesPenduduk', 'Daftar_kontak@datatablesPenduduk')->name('daftar_kontak.datatablesPenduduk');
    Route::get('/form/{id?}', 'Daftar_kontak@form')->name('daftar_kontak.form');
    Route::get('/form_penduduk/{id?}', 'Daftar_kontak@form_penduduk')->name('daftar_kontak.form_penduduk');
    Route::post('/insert', 'Daftar_kontak@insert')->name('daftar_kontak.insert');
    Route::post('/update/{id?}', 'Daftar_kontak@update')->name('daftar_kontak.update');
    Route::post('/update_penduduk/{id?}', 'Daftar_kontak@update_penduduk')->name('daftar_kontak.update_penduduk');
    Route::get('/delete/{id?}', 'Daftar_kontak@delete')->name('daftar_kontak.delete');
});

Route::group('grup_kontak', static function (): void {
    Route::get('/', 'Grup_kontak@index')->name('grup_kontak.index');
    Route::get('/datatables', 'Grup_kontak@datatables')->name('grup_kontak.datatables');
    Route::get('/form/{id?}', 'Grup_kontak@form')->name('grup_kontak.form');
    Route::post('/insert', 'Grup_kontak@insert')->name('grup_kontak.insert');
    Route::post('/update/{id?}', 'Grup_kontak@update')->name('grup_kontak.update');
    Route::get('/delete/{id?}', 'Grup_kontak@delete')->name('grup_kontak.delete');
    Route::get('/anggota/{id?}', 'Grup_kontak@anggota')->name('grup_kontak.anggota');
    Route::get('/anggotadatatables/{id}', 'Grup_kontak@anggotaDatatables')->name('grup_kontak.anggotaDatatables');
    Route::get('/anggotaform/{id?}', 'Grup_kontak@anggotaForm')->name('grup_kontak.anggotaForm');
    Route::post('/anggotainsert', 'Grup_kontak@anggotaInsert')->name('grup_kontak.anggotaInsert');
    Route::get('/anggotadelete/{id?}', 'Grup_kontak@anggotaDelete')->name('grup_kontak.anggotaDelete');
    Route::get('/penduduk/{id}', 'Grup_kontak@penduduk')->name('grup_kontak.penduduk');
    Route::get('/kontak/{id}', 'Grup_kontak@kontak')->name('grup_kontak.kontak');
});
// Pengaturan > Modul
Route::group('modul', static function (): void {
    Route::get('/datatables', 'Modul@datatables')->name('modul.datatables');
    Route::get('/form/{id}', 'Modul@form')->name('modul.form');
    Route::post('/update/{id}', 'Modul@update')->name('modul.update');
    Route::get('/lock/{id}', 'Modul@lock')->name('modul.lock');
    Route::get('/unlock/{id}', 'Modul@unlock')->name('modul.unlock');
    Route::post('/ubah_server', 'Modul@ubah_server')->name('modul.ubah_server');
    Route::get('/default_server', 'Modul@default_server')->name('modul.default_server');
    Route::get('/{parent?}', 'Modul@index')->name('modul.index');
});
// Pengaturan > Aplikasi
Route::group('setting', static function (): void {
    Route::get('/', 'Setting@index')->name('setting.index');
    Route::post('/update', 'Setting@update')->name('setting.update');
    Route::post('/new_update', 'Setting@new_update')->name('setting.new_update');
});

// Pengaturan > Pengguna > Pengguna
Route::group('man_user', static function (): void {
    Route::get('/', 'Man_user@index')->name('man_user.index-default');
    Route::get('/index', 'Man_user@index')->name('man_user.index');
    Route::get('/form/{id?}', 'Man_user@form')->name('man_user.form');
    Route::post('/insert', 'Man_user@insert')->name('man_user.insert');
    Route::get('/syarat_sandi/{str}', 'Man_user@syarat_sandi')->name('man_user.syarat_sandi');
    Route::post('/update/{id?}', 'Man_user@update')->name('man_user.update');
    Route::get('/delete/{id?}', 'Man_user@delete')->name('man_user.delete');
    Route::post('/delete_all', 'Man_user@delete_all')->name('man_user.delete_all');
    Route::get('/user_lock/{id?}', 'Man_user@user_lock')->name('man_user.user_lock');
    Route::get('/user_unlock/{id?}', 'Man_user@user_unlock')->name('man_user.user_unlock');
});
// Pengaturan > Pengguna > Grup
Route::group('grup', static function (): void {
    Route::get('/', 'Grup@index')->name('grup.index');
    Route::get('/datatables', 'Grup@datatables')->name('grup.datatables');
    Route::get('/form/{id?}', 'Grup@form')->name('grup.form');
    Route::get('/viewForm/{id}', 'Grup@viewForm')->name('grup.viewForm');
    Route::get('/salin/{id}', 'Grup@salin')->name('grup.salin');
    Route::post('/insert', 'Grup@insert')->name('grup.insert');
    Route::get('/syarat_nama', 'Grup@syarat_nama')->name('grup.syarat_nama');
    Route::post('/update/{id}', 'Grup@update')->name('grup.update');
    Route::match(['GET', 'POST'], '/delete/{id?}', 'Grup@delete')->name('grup.delete');
});
// Pengaturan > Database
Route::group('database', static function (): void {
    Route::get('/', 'Database@index')->name('database.index');
    Route::get('/migrasi_cri', 'Database@migrasi_cri')->name('database.migrasi_cri');
    Route::match(['GET', 'POST'], '/migrasi_db_cri', 'Database@migrasi_db_cri')->name('database.migrasi_db_cri');
    Route::get('/exec_backup', 'Database@exec_backup')->name('database.exec_backup');
    Route::get('/desa_backup', 'Database@desa_backup')->name('database.desa_backup');
    Route::get('/desa_inkremental', 'Database@desa_inkremental')->name('database.desa_inkremental');
    Route::post('/inkremental_job', 'Database@inkremental_job')->name('database.inkremental_job');
    Route::get('/inkremental_download', 'Database@inkremental_download')->name('database.inkremental_download');
    Route::post('/restore', 'Database@restore')->name('database.restore');
    Route::get('/acak', 'Database@acak')->name('database.acak');
    Route::get('/mutakhirkan_data_server', 'Database@mutakhirkan_data_server')->name('database.mutakhirkan_data_server');
    Route::post('/proses_sinkronkan', 'Database@proses_sinkronkan')->name('database.proses_sinkronkan');
    Route::get('/batal_backup', 'Database@batal_backup')->name('database.batal_backup');
    Route::post('/kirim_otp', 'Database@kirim_otp')->name('database.kirim_otp');
    Route::post('/verifikasi_otp', 'Database@verifikasi_otp')->name('database.verifikasi_otp');
    Route::post('/upload_restore', 'Database@upload_restore')->name('database.upload_restore');
    Route::get('/batal_restore', 'Database@batal_restore')->name('database.batal_restore');
});

Route::group('multiDB', static function (): void {
    Route::get('/backup', 'MultiDB@backup')->name('multiDB.backup');
    Route::post('/restore', 'MultiDB@restore')->name('multiDB.restore');
});

// Pengaturan > Info Sistem
Route::group('info_sistem', static function (): void {
    Route::get('/', 'Info_sistem@index')->name('info_sistem.index');
    Route::match(['GET', 'POST'], '/remove_log', 'Info_sistem@remove_log')->name('info_sistem.remove_log');
    Route::get('/cache_desa', 'Info_sistem@cache_desa')->name('info_sistem.cache_desa');
    Route::get('/cache_blade', 'Info_sistem@cache_blade')->name('info_sistem.cache_blade');
    Route::post('/set_permission_desa', 'Info_sistem@set_permission_desa')->name('info_sistem.set_permission_desa');
});

// Pengaturan > QR Code
Route::group('qr_code', static function (): void {
    Route::get('/clear', 'Qr_code@clear')->name('qr_code.clear');
    Route::post('/qrcode_generate', 'Qr_code@qrcode_generate')->name('qr_code.qrcode_generate');
    Route::get('/', 'Qr_code@index')->name('qr_code.index');
});

// Pengaturan > Optimasi Gambar
Route::group('optimasi_gambar', static function (): void {
    Route::get('/', 'Optimasi_gambar@index')->name('optimasi_gambar.index');
    Route::get('/get_image/{dir?}', 'Optimasi_gambar@get_image')->name('optimasi_gambar.get_image');
    Route::get('/get_folders/{path?}', 'Optimasi_gambar@get_folders')->name('optimasi_gambar.get_folders');
    Route::post('/resize', 'Optimasi_gambar@resize')->name('optimasi_gambar.resize');
});

// Admin Web > Artikel
// Admin Web > Slider
Route::group('web', static function (): void {
    Route::get('/clear', 'Web@clear')->name('web.clear');
    Route::get('/tab/{cat?}', 'Web@tab')->name('web.tab');
    Route::get('/form/{id?}', 'Web@form')->name('web.form');
    Route::post('/filter/{filter}', 'Web@filter')->name('web.filter');
    Route::post('/insert', 'Web@insert')->name('web.insert');
    Route::post('/update/{id?}', 'Web@update')->name('web.update');
    Route::get('/delete/{id?}', 'Web@delete')->name('web.delete');
    Route::post('/delete_all', 'Web@delete_all')->name('web.delete_all');
    Route::match(['GET', 'POST'], '/hapus', 'Web@hapus')->name('web.hapus');
    Route::get('/ubah_kategori_form/{id?}', 'Web@ubah_kategori_form')->name('web.ubah_kategori_form');
    Route::post('/update_kategori/{id?}', 'Web@update_kategori')->name('web.update_kategori');
    Route::get('/artikel_lock/{id?}/{val?}', 'Web@artikel_lock')->name('web.artikel_lock');
    Route::get('/komentar_lock/{id?}/{val?}', 'Web@komentar_lock')->name('web.komentar_lock');
    Route::get('/ajax_add_kategori/{cat?}/{p?}/{o?}', 'Web@ajax_add_kategori')->name('web.ajax_add_kategori');
    Route::post('/insert_kategori/{cat?}/{p?}/{o?}', 'Web@insert_kategori')->name('web.insert_kategori');
    Route::get('/headline/{id?}', 'Web@headline')->name('web.headline');
    Route::get('/slide/{id?}', 'Web@slide')->name('web.slide');
    Route::get('/slider', 'Web@slider')->name('web.slider');
    Route::post('/update_slider', 'Web@update_slider')->name('web.update_slider');
    Route::get('/teks_berjalan', 'Web@teks_berjalan')->name('web.teks_berjalan');
    Route::post('/update_teks_berjalan', 'Web@update_teks_berjalan')->name('web.update_teks_berjalan');
    Route::get('/reset', 'Web@reset')->name('web.reset');
    Route::match(['GET', 'POST'], '/{p?}/{o?}', 'Web@index')->name('web.index-default');
    Route::match(['GET', 'POST'], '/index/{p?}/{o?}', 'Web@index')->name('web.index');
});

// Admin Web > Widget
Route::group('web_widget', static function (): void {
    Route::get('/', 'Web_widget@index')->name('web_widget.index');
    Route::get('/datatables', 'Web_widget@datatables')->name('web_widget.datatables');
    Route::post('/tukar', 'Web_widget@tukar')->name('web_widget.tukar');
    Route::get('/form/{id?}', 'Web_widget@form')->name('web_widget.form');
    Route::get('/admin/{widget}', 'Web_widget@admin')->name('web_widget.admin');
    Route::post('/update_setting/{widget}', 'Web_widget@update_setting')->name('web_widget.update_setting');
    Route::post('/insert', 'Web_widget@insert')->name('web_widget.insert');
    Route::post('/update/{id?}', 'Web_widget@update')->name('web_widget.update');
    Route::get('/delete/{id?}', 'Web_widget@delete')->name('web_widget.delete');
    Route::post('/delete_all', 'Web_widget@delete_all')->name('web_widget.delete_all');
    Route::get('/lock/{id}', 'Web_widget@lock')->name('web_widget.lock');
});
// Admin Web > Menu
Route::group('menu', static function (): void {
    Route::get('/', 'Menu@index')->name('menu.index');
    Route::get('/index', 'Menu@index')->name('menu.index-default');
    Route::get('/datatables', 'Menu@datatables')->name('menu.datatables');
    Route::get('/ajax_menu/{parent}/{id?}', 'Menu@ajax_menu')->name('menu.ajax_menu');
    Route::post('/insert/{parent}', 'Menu@insert')->name('menu.insert');
    Route::post('/update/{parent}/{id}', 'Menu@update')->name('menu.update');
    Route::match(['GET', 'POST'], '/delete/{parent}/{id?}', 'Menu@delete')->name('menu.delete');
    Route::get('/lock/{parent}/{id}', 'Menu@lock')->name('menu.lock');
    Route::post('/tukar', 'Menu@tukar')->name('menu.tukar');
});
// Admin Web > Menu Kategori
Route::group('kategori', static function (): void {
    Route::get('/', 'Kategori@index')->name('kategori.index');
    Route::get('/index', 'Kategori@index')->name('kategori.index-default');
    Route::get('/datatables', 'Kategori@datatables')->name('kategori.datatables');
    Route::get('/ajax_form/{parent}/{id?}', 'Kategori@ajax_form')->name('kategori.ajax_form');
    Route::post('/insert/{parent}', 'Kategori@insert')->name('kategori.insert');
    Route::post('/update/{parent}/{id}', 'Kategori@update')->name('kategori.update');
    Route::match(['GET', 'POST'], '/delete/{parent}/{id?}', 'Kategori@delete')->name('kategori.delete');
    Route::get('/lock/{parent}/{id}', 'Kategori@lock')->name('kategori.lock');
    Route::get('/unlock/{parent}/{id}', 'Kategori@unlock')->name('kategori.unlock');
    Route::post('/tukar', 'Kategori@tukar')->name('kategori.tukar');
});
// Admin Web > Komentar
Route::group('komentar', static function (): void {
    Route::get('/clear', 'Komentar@clear')->name('komentar.clear');
    Route::get('/form/{id?}', 'Komentar@form')->name('komentar.form');
    Route::get('/datatables', 'Komentar@datatables')->name('komentar.datatables');
    Route::post('/insert', 'Komentar@insert')->name('komentar.insert');
    Route::post('/update/{id?}', 'Komentar@update')->name('komentar.update');
    Route::get('/delete/{id}', 'Komentar@delete')->name('komentar.delete');
    Route::post('/delete_all', 'Komentar@delete_all')->name('komentar.delete_all');
    Route::get('/lock/{id?}', 'Komentar@lock')->name('komentar.lock');
    Route::match(['GET', 'POST'], '/', 'Komentar@index')->name('komentar.index-default');
});
// Admin Web > Galeri
Route::group('gallery', static function (): void {
    Route::get('/', 'Gallery@index')->name('gallery.index');
    Route::get('/index', 'Gallery@index')->name('gallery.index-default');
    Route::get('/datatables', 'Gallery@datatables')->name('gallery.datatables');
    Route::get('/form/{parent}/{id?}', 'Gallery@form')->name('gallery.form');
    Route::post('/insert/{parent}', 'Gallery@insert')->name('gallery.insert');
    Route::post('/update/{parent}/{id}', 'Gallery@update')->name('gallery.update');
    Route::match(['GET', 'POST'], '/delete/{parent}/{id?}', 'Gallery@delete')->name('gallery.delete');
    Route::get('/lock/{parent}/{id}', 'Gallery@lock')->name('gallery.lock');
    Route::get('/slider/{parent}/{id}', 'Gallery@slider')->name('gallery.slider');
    Route::post('/tukar', 'Gallery@tukar')->name('gallery.tukar');
});
// Admin Web > Media Sosial
Route::group('sosmed', static function (): void {
    Route::get('/', 'Sosmed@index')->name('sosmed.index');
    Route::get('/tab/{sosmed}', 'Sosmed@tab')->name('sosmed.tab');
    Route::post('/update/{sosmed}', 'Sosmed@update')->name('sosmed.update');
});
// Admin Web > Teks Berjalan
Route::group('teks_berjalan', static function (): void {
    Route::get('/', 'Teks_berjalan@index')->name('teks_berjalan.index');
    Route::get('/datatables', 'Teks_berjalan@datatables')->name('teks_berjalan.datatables');
    Route::get('/form/{id?}', 'Teks_berjalan@form')->name('teks_berjalan.form');
    Route::post('/insert', 'Teks_berjalan@insert')->name('teks_berjalan.insert');
    Route::post('/update/{id?}', 'Teks_berjalan@update')->name('teks_berjalan.update');
    Route::match(['GET', 'POST'], '/delete/{id?}', 'Teks_berjalan@delete')->name('teks_berjalan.delete');
    Route::get('/urut/{id?}/{arah?}', 'Teks_berjalan@urut')->name('teks_berjalan.urut');
    Route::get('/lock/{id?}/{val?}', 'Teks_berjalan@lock')->name('teks_berjalan.lock');
});
// Admin Web > Pengunjung
Route::group('pengunjung', static function (): void {
    Route::get('/', 'Pengunjung@index')->name('pengunjung.index');
    Route::get('/detail/{id?}', 'Pengunjung@detail')->name('pengunjung.detail');
    Route::get('/cetak/{aksi?}', 'Pengunjung@cetak')->name('pengunjung.cetak');
});

// Admin Web > Pengaturan
Route::group('setting', static function (): void {
    Route::get('/web', 'Setting@web')->name('setting.web');
});

// Layanan Mandiri > Kotak Pesan
Route::group('mailbox', static function (): void {
    Route::get('/datatables', 'Mailbox@datatables')->name('mailbox.datatables');
    Route::post('/kirim_pesan', 'Mailbox@kirim_pesan')->name('mailbox.kirim_pesan');
    Route::get('/read/{kat}/{id}', 'Mailbox@read')->name('mailbox.read');
    Route::match(['GET', 'POST'], '/form/{kat}', 'Mailbox@form')->name('mailbox.form');
    Route::get('/detail/{kat}/{id}', 'Mailbox@detail')->name('mailbox.detail');
    Route::get('/list_pendaftar_mandiri_ajax', 'Mailbox@list_pendaftar_mandiri_ajax')->name('mailbox.list_pendaftar_mandiri_ajax');
    Route::match(['GET', 'POST'], '/delete/{kat}/{id?}', 'Mailbox@delete')->name('mailbox.delete');
    Route::get('/{id?}', 'Mailbox@index')->name('mailbox.index')->param('id', 1);
});
// Layanan Mandiri > Pendaftaran Layanan Mandiri
Route::group('mandiri', static function (): void {
    Route::get('/', 'Mandiri@index')->name('mandiri.index');
    Route::get('/datatables', 'Mandiri@datatables')->name('mandiri.datatables');
    Route::get('/ajax_pin/{id_pend?}', 'Mandiri@ajax_pin')->name('mandiri.ajax_pin');
    Route::get('/ajax_hp/{id_pend}', 'Mandiri@ajax_hp')->name('mandiri.ajax_hp');
    Route::get('/ajax_verifikasi_warga/{id_pend}', 'Mandiri@ajax_verifikasi_warga')->name('mandiri.ajax_verifikasi_warga');
    Route::post('/verifikasi_warga/{id_pend}', 'Mandiri@verifikasi_warga')->name('mandiri.verifikasi_warga');
    Route::post('/ubah_hp/{id_pend}', 'Mandiri@ubah_hp')->name('mandiri.ubah_hp');
    Route::post('/insert', 'Mandiri@insert')->name('mandiri.insert');
    Route::post('/update/{id_pend}', 'Mandiri@update')->name('mandiri.update');
    Route::get('/delete/{id?}', 'Mandiri@delete')->name('mandiri.delete');
    Route::post('/kirim/{id_pend?}', 'Mandiri@kirim')->name('mandiri.kirim');
});

// Layanan Mandiri > Gawai Layanan
Route::group('gawai_layanan', static function (): void {
    Route::get('/', 'Gawai_layanan@index')->name('gawai_layanan.index');
    Route::get('/datatables', 'Gawai_layanan@datatables')->name('gawai_layanan.datatables');
    Route::get('/form/{id?}', 'Gawai_layanan@form')->name('gawai_layanan.form');
    Route::post('/insert', 'Gawai_layanan@insert')->name('gawai_layanan.insert');
    Route::post('/update/{id?}', 'Gawai_layanan@update')->name('gawai_layanan.update');
    Route::get('/delete/{id?}', 'Gawai_layanan@delete')->name('gawai_layanan.delete');
    Route::post('/delete', 'Gawai_layanan@delete')->name('gawai_layanan.delete-all');
    Route::get('/kunci/{id?}/{val?}', 'Gawai_layanan@kunci')->name('gawai_layanan.kunci');
});

// Layanan Mandiri > Pendapat
Route::group('pendapat', static function (): void {
    Route::get('/', 'Pendapat@index')->name('pendapat.index');
    Route::get('/detail/{tipe?}', 'Pendapat@detail')->name('pendapat.detail');
});
// Layanan Mandiri > Pengaturan
Route::group('setting', static function (): void {
    Route::get('/ambil_foto', 'Setting@ambil_foto')->name('setting.ambil_foto');
    Route::post('/aktifkan_tracking', 'Setting@aktifkan_tracking')->name('setting.aktifkan_tracking');
    Route::get('/mandiri', 'Setting@mandiri')->name('setting.mandiri');
});

// Anjungan > Daftar Anjungan
Route::group('anjungan', static function (): void {
    Route::get('/', 'Anjungan@index')->name('anjungan.index');
    Route::get('/datatables', 'Anjungan@datatables')->name('anjungan.datatables');
    Route::get('/form/{id?}', 'Anjungan@form')->name('anjungan.form');
    Route::post('/insert', 'Anjungan@insert')->name('anjungan.insert');
    Route::post('/update/{id?}', 'Anjungan@update')->name('anjungan.update');
    Route::get('/delete/{id?}', 'Anjungan@delete')->name('anjungan.delete');
    Route::post('/delete', 'Anjungan@delete')->name('anjungan.delete-all');
    Route::get('/kunci/{id?}/{val?}', 'Anjungan@kunci')->name('anjungan.kunci');
});

// Anjungan > Menu
Route::group('anjungan_menu', static function (): void {
    Route::get('/', 'Anjungan_menu@index')->name('anjungan_menu.index');
    Route::get('/datatables', 'Anjungan_menu@datatables')->name('anjungan_menu.datatables');
    Route::get('/form/{id?}', 'Anjungan_menu@form')->name('anjungan_menu.form');
    Route::post('/insert', 'Anjungan_menu@insert')->name('anjungan_menu.insert');
    Route::post('/update/{id?}', 'Anjungan_menu@update')->name('anjungan_menu.update');
    Route::get('/delete/{id?}', 'Anjungan_menu@delete')->name('anjungan_menu.delete');
    Route::post('/delete', 'Anjungan_menu@delete')->name('anjungan_menu.delete-all');
    Route::get('/lock/{id?}', 'Anjungan_menu@lock')->name('anjungan_menu.lock');
    Route::post('/tukar', 'Anjungan_menu@tukar')->name('anjungan_menu.tukar');
});

// Anjungan > Pengaturan
Route::group('anjungan_pengaturan', static function (): void {
    Route::get('/', 'Anjungan_pengaturan@index')->name('anjungan_pengaturan.index');
    Route::post('/update', 'Anjungan_pengaturan@update')->name('anjungan_pengaturan.update');
});

// Satu Data > DTKS
Route::group('dtks', static function (): void {
    Route::get('/', 'Dtks@index')->name('dtks.index');
    Route::get('/datatables', 'Dtks@datatables')->name('dtks.datatables');
    Route::get('/listAnggota/{id_dtks}', 'Dtks@listAnggota')->name('dtks.listAnggota');
    Route::get('/loadRecentInfo', 'Dtks@loadRecentInfo')->name('dtks.loadRecentInfo');
    Route::get('/loadRecentImpor', 'Dtks@loadRecentImpor')->name('dtks.loadRecentImpor');
    Route::get('/ekspor', 'Dtks@ekspor')->name('dtks.ekspor');
    Route::get('/cetak2/{id?}', 'Dtks@cetak2')->name('dtks.cetak2');
    Route::get('/new/{id_rtm}', 'Dtks@new')->name('dtks.new');
    Route::get('/latest/{id_rtm}', 'Dtks@latest')->name('dtks.latest');
    Route::get('/form/{id}', 'Dtks@form')->name('dtks.form');
    Route::post('/savePengaturan/{versi_dtks}', 'Dtks@savePengaturan')->name('dtks.savePengaturan');
    Route::post('/save/{id}', 'Dtks@save')->name('dtks.save');
    Route::post('/delete/{id}', 'Dtks@delete')->name('dtks.delete');
    Route::post('/remove/{id}', 'Dtks@remove')->name('dtks.remove');
});

// Buku Tamu > Data Tamu
Route::group('buku_tamu', static function (): void {
    Route::get('/', 'Buku_tamu@index')->name('buku_tamu.index');
    Route::get('/delete/{id?}', 'Buku_tamu@delete')->name('buku_tamu.delete');
    Route::post('/delete', 'Buku_tamu@delete')->name('buku_tamu.delete-all');
    Route::get('/cetak', 'Buku_tamu@cetak')->name('buku_tamu.cetak');
    Route::get('/ekspor', 'Buku_tamu@ekspor')->name('buku_tamu.ekspor');
});

// Buku Tamu > Data Kepuasan
Route::group('buku_kepuasan', static function (): void {
    Route::get('/', 'Buku_kepuasan@index')->name('buku_kepuasan.index');
    Route::get('/delete/{id?}', 'Buku_kepuasan@delete')->name('buku_kepuasan.delete');
    Route::post('/delete', 'Buku_kepuasan@delete')->name('buku_kepuasan.delete-all');
});

// Buku Tamu > Data Pertanyaan
Route::group('buku_pertanyaan', static function (): void {
    Route::get('/', 'Buku_pertanyaan@index')->name('buku_pertanyaan.index');
    Route::get('/form/{id?}', 'Buku_pertanyaan@form')->name('buku_pertanyaan.form');
    Route::post('/insert', 'Buku_pertanyaan@insert')->name('buku_pertanyaan.insert');
    Route::post('/update/{id?}', 'Buku_pertanyaan@update')->name('buku_pertanyaan.update');
    Route::get('/delete/{id?}', 'Buku_pertanyaan@delete')->name('buku_pertanyaan.delete');
    Route::post('/delete', 'Buku_pertanyaan@delete')->name('buku_pertanyaan.delete-all');
});

// Buku Tamu > Data Keperluan
Route::group('buku_keperluan', static function (): void {
    Route::get('/', 'Buku_keperluan@index')->name('buku_keperluan.index');
    Route::get('/form/{id?}', 'Buku_keperluan@form')->name('buku_keperluan.form');
    Route::post('/insert', 'Buku_keperluan@insert')->name('buku_keperluan.insert');
    Route::post('/update/{id?}', 'Buku_keperluan@update')->name('buku_keperluan.update');
    Route::get('/delete/{id?}', 'Buku_keperluan@delete')->name('buku_keperluan.delete');
    Route::post('/delete', 'Buku_keperluan@delete')->name('buku_keperluan.delete-all');
});

Route::group('token', static function (): void {
    Route::get('/', 'Token@index')->name('token.index');
    Route::post('/update', 'Token@update')->name('token.update');
});
