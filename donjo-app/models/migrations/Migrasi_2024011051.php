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

use Illuminate\Support\Facades\DB;

defined('BASEPATH') || exit('No direct script access allowed');

class Migrasi_2024011051 extends MY_model
{
    public function up()
    {
        $hasil = true;

        $hasil = $hasil && $this->migrasi_tabel($hasil);

        return $hasil && $this->migrasi_data($hasil);
    }

    protected function migrasi_tabel($hasil)
    {
        return $hasil;
    }

    // Migrasi perubahan data
    protected function migrasi_data($hasil)
    {
        // Migrasi berdasarkan config_id
        $config_id = DB::table('config')->pluck('id')->toArray();

        foreach ($config_id as $id) {
            $hasil = $hasil && $this->migrasi_2024010452($hasil, $id);
        }

        // Migrasi tanpa config_id
        $hasil = $hasil && $this->migrasi_2024010451($hasil);

        return $hasil && $this->migrasi_2024010851($hasil);
    }

    protected function migrasi_2024010452($hasil, $id)
    {
        $hasil = $hasil && $this->tambah_setting([
            'judul'      => 'Status Penduduk Lahir',
            'key'        => 'surat_kelahiran_terkait_penduduk',
            'value'      => '[]',
            'keterangan' => 'Status Penduduk Lahir',
            'jenis'      => 'referensi',
            'option'     => json_encode(['model' => 'App\\Models\\FormatSurat', 'value' => 'url_surat', 'label' => 'nama']),
            'attribute'  => null,
            'kategori'   => 'log_penduduk',
        ], $id);

        $hasil = $hasil && $this->tambah_setting([
            'judul'      => 'Status Penduduk Mati',
            'key'        => 'surat_kematian_terkait_penduduk',
            'value'      => '[]',
            'keterangan' => 'Status Penduduk Mati',
            'jenis'      => 'referensi',
            'option'     => json_encode(['model' => 'App\\Models\\FormatSurat', 'value' => 'url_surat', 'label' => 'nama']),
            'attribute'  => null,
            'kategori'   => 'log_penduduk',
        ], $id);

        $hasil = $hasil && $this->tambah_setting([
            'judul'      => 'Status Penduduk Pindah Keluar',
            'key'        => 'surat_pindah_keluar_terkait_penduduk',
            'value'      => '[]',
            'keterangan' => 'Status Penduduk Pindah Keluar',
            'jenis'      => 'referensi',
            'option'     => json_encode(['model' => 'App\\Models\\FormatSurat', 'value' => 'url_surat', 'label' => 'nama']),
            'attribute'  => null,
            'kategori'   => 'log_penduduk',
        ], $id);

        $hasil = $hasil && $this->tambah_setting([
            'judul'      => 'Status Penduduk Hilang',
            'key'        => 'surat_hilang_terkait_penduduk',
            'value'      => '[]',
            'keterangan' => 'Status Penduduk Hilang',
            'jenis'      => 'referensi',
            'option'     => json_encode(['model' => 'App\\Models\\FormatSurat', 'value' => 'url_surat', 'label' => 'nama']),
            'attribute'  => null,
            'kategori'   => 'log_penduduk',
        ], $id);

        $hasil = $hasil && $this->tambah_setting([
            'judul'      => 'Status Penduduk Pindah Masuk',
            'key'        => 'surat_pindah_masuk_terkait_penduduk',
            'value'      => '[]',
            'keterangan' => 'Status Penduduk Pindah Masuk',
            'jenis'      => 'referensi',
            'option'     => json_encode(['model' => 'App\\Models\\FormatSurat', 'value' => 'url_surat', 'label' => 'nama']),
            'attribute'  => null,
            'kategori'   => 'log_penduduk',
        ], $id);

        return $hasil && $this->tambah_setting([
            'judul'      => 'Status Penduduk Pergi',
            'key'        => 'surat_pergi_terkait_penduduk',
            'value'      => '[]',
            'keterangan' => 'Status Penduduk Pergi',
            'jenis'      => 'referensi',
            'option'     => json_encode(['model' => 'App\\Models\\FormatSurat', 'value' => 'url_surat', 'label' => 'nama']),
            'attribute'  => null,
            'kategori'   => 'log_penduduk',
        ], $id);
    }

    protected function migrasi_2024010451($hasil)
    {
        $hasil = $hasil && $this->ubah_modul(
            ['slug' => 'komentar', 'url' => 'komentar/clear'],
            ['url' => 'komentar']
        );

        return $hasil && $this->ubah_modul(
            ['slug' => 'menu', 'url' => 'menu/clear'],
            ['url' => 'menu']
        );
    }

    protected function migrasi_2024010851($hasil)
    {
        return $hasil = $hasil && $this->ubah_modul(
            ['slug' => 'log-penduduk'],
            ['url' => 'penduduk_log/clear', 'hidden' => 0, 'ikon' => 'fa-archive', 'modul' => 'Catatan Peristiwa', 'slug' => 'catatan-peristiwa', 'level' => 2]
        );
    }
}
