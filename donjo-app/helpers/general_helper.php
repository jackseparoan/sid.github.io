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

use App\Models\Config;
use App\Models\GrupAkses;
use App\Models\JamKerja;
use App\Models\Kehadiran;
use App\Models\Modul;
use App\Models\UserGrup;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;

if (!function_exists('asset')) {
    function asset($uri = '', $default = true)
    {
        if ($default) {
            $uri = 'assets/' . $uri;
        }
        $path = FCPATH . $uri;

        return base_url($uri . '?v' . md5_file($path));
    }
}

if (!function_exists('set_session')) {
    function set_session($key = 'success', $value = '')
    {
        return get_instance()->session->set_flashdata($key, $value);
    }
}

if (!function_exists('session')) {
    function session($nama = '')
    {
        return get_instance()->session->flashdata($nama);
    }
}

if (!function_exists('can')) {
    /**
     * Cek akses user
     *
     * @param string|null $akses
     * @param string|null $slugModul
     * @param bool        $adminOnly
     *
     * @return array|bool
     */
    function can($akses = null, $slugModul = null, $adminOnly = false)
    {
        $idGrup   = auth()->id_grup;
        $slugGrup = UserGrup::find($idGrup)->slug;
        $data     = cache()->remember('akses_grup_' . $idGrup, 604800, static function () use ($idGrup, $slugGrup) {
            if (in_array($idGrup, UserGrup::getGrupSistem())) {
                $grup = UserGrup::getAksesGrupBawaan()[$slugGrup];

                if (count($grup) === 1 && array_keys($grup)[0] == '*') {
                    $grupAkses = Modul::get();
                    $rbac      = array_values($grup)[0];
                } else {
                    $grupAkses = Modul::whereIn('slug', array_keys($grup))->get();
                }

                return $grupAkses->mapWithKeys(static function ($item) use ($idGrup, $rbac, $grup) {
                    $rbac ??= $grup[$item->slug];
                    $rbac = $rbac === 0 ? 1 : $rbac;

                    return [
                        $item->slug => [
                            'id_modul' => $item->id,
                            'id_grup'  => $idGrup,
                            'akses'    => $rbac,
                            'baca'     => $rbac >= 1,
                            'ubah'     => $rbac >= 3,
                            'hapus'    => $rbac >= 7,
                        ],
                    ];
                })->toArray();
            }
            $grupAkses = GrupAkses::leftJoin('setting_modul', 'grup_akses.id_modul', '=', 'setting_modul.id')
                ->where('id_grup', $idGrup)
                ->select('grup_akses.*')
                ->selectRaw('setting_modul.slug as slug')
                ->get();

            return $grupAkses->mapWithKeys(static fn ($item) => [
                $item->slug => [
                    'id_modul' => $item->id_modul,
                    'id_grup'  => $item->id_grup,
                    'akses'    => $item->akses,
                    'baca'     => $item->akses >= 1,
                    'ubah'     => $item->akses >= 3,
                    'hapus'    => $item->akses >= 7,
                ],
            ])->toArray();
        });

        if (null === $akses) {
            return $data;
        }

        if (null === $slugModul) {
            $slugModul = get_instance()->akses_modul ?? get_instance()->sub_modul_ini ?? get_instance()->modul_ini;
        }

        $alias = [
            'b' => 'baca',
            'u' => 'ubah',
            'h' => 'hapus',
        ];

        if (!array_key_exists($akses, $alias)) {
            return false;
        }

        if ($adminOnly) {
            return (bool) super_admin();
        }

        // dd($data);

        return $data[$slugModul][$alias[$akses]];
    }
}

if (!function_exists('isCan')) {
    /**
     * Cek akses user
     *
     * @param string|null $akses
     * @param string|null $slugModul
     * @param bool        $adminOnly
     */
    function isCan($akses = null, $slugModul = null, $adminOnly = false): void
    {
        $pesan = 'Anda tidak memiliki akses untuk halaman tersebut!';
        if (!can('b', $slugModul, $adminOnly)) {
            set_session('error', $pesan);
            session_error($pesan);

            redirect('beranda');
        } elseif (!can($akses, $slugModul, $adminOnly)) {
            set_session('error', $pesan);
            session_error($pesan);

            redirect(get_instance()->controller);
        }
    }
}

// response()->json(array_data);
if (!function_exists('json')) {
    function json($content = [], $header = 200): void
    {
        get_instance()->output
            ->set_status_header($header)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($content, JSON_THROW_ON_ERROR))
            ->_display();

        exit();
    }
}

// redirect()->route('example')->with('success', 'information');
if (!function_exists('redirect_with')) {
    function redirect_with($key = 'success', $value = '', $to = '', $autodismis = null)
    {
        set_session($key, $value);

        if ($autodismis) {
            set_session('autodismiss', true);
        }

        if (empty($to)) {
            $to = get_instance()->controller;
        }

        return redirect($to);
    }
}

// ci_route('example');
if (!function_exists('ci_route')) {
    function ci_route($to = null, $params = null)
    {
        if (in_array($to, [null, '', '/'])) {
            return site_url();
        }

        $to = str_replace('.', '/', $to);

        if (null !== $params) {
            if (is_array($params)) {
                $params = implode('/', $params);
            }
            $to .= '/' . $params;
        }

        return site_url($to);
    }
}

// setting('sebutan_desa');
if (!function_exists('setting')) {
    function setting($params = null)
    {
        $getSetting = get_instance()->setting;

        if ($params && !empty($getSetting)) {
            if (property_exists($getSetting, $params)) {
                return $getSetting->{$params};
            }

            return null;
        }

        return $getSetting;
    }
}

// identitas('nama_desa');
if (!function_exists('identitas')) {
    /**
     * Get identitas desa.
     *
     * @return object|string
     */
    function identitas(?string $params = null)
    {
        $identitas = cache()->remember('identitas_desa', 604800, static fn () => Config::appKey()->first());

        if ($params) {
            return $identitas->{$params};
        }

        return $identitas;
    }
}

// hapus_cache('cache_id');
if (!function_exists('hapus_cache')) {
    function hapus_cache($params = null)
    {
        if ($params) {
            return get_instance()->cache->hapus_cache_untuk_semua($params);
        }

        return false;
    }
}

if (!function_exists('calculate_days')) {
    /**
     * Calculate minute between 2 date.
     *
     * @return int
     */
    function calculate_days(string $dateStart, string $format = 'Y-m-d')
    {
        return abs(Carbon::createFromFormat($format, $dateStart)->getTimestamp() - Carbon::now()->getTimestamp()) / (60 * 60 * 24);
    }
}

if (!function_exists('calculate_date_intervals')) {
    /**
     * Calculate list dates interval to minutes.
     *
     * @return int
     */
    function calculate_date_intervals(array $date)
    {
        $reference = Carbon::now();
        $endTime   = clone $reference;

        foreach ($date as $dateInterval) {
            $endTime = $endTime->add(DateInterval::createFromDateString(calculate_days($dateInterval) . 'days'));
        }

        return $reference->diff($endTime)->days;
    }
}

// Parsedown
if (!function_exists('parsedown')) {
    /**
     * Parsedown.
     *
     * @param string|null $params
     *
     * @return Parsedown|string
     */
    function parsedown($params = null)
    {
        $parsedown = new Parsedown();

        if (null !== $params) {
            return $parsedown->text(file_get_contents(FCPATH . $params));
        }

        return $parsedown;
    }
}

// SebutanDesa('Surat [Desa]');
if (!function_exists('SebutanDesa')) {
    function SebutanDesa($params = null)
    {
        return str_replace(
            ['[Desa]', '[desa]', '[Pemerintah Desa]'],
            [ucwords(setting('sebutan_desa')), ucwords(setting('sebutan_desa')), ucwords(setting('sebutan_pemerintah_desa'))],
            $params
        );
    }
}

if (!function_exists('underscore')) {
    /**
     * Membuat spasi menjadi underscore atau sebaliknya
     *
     * @param string $str           string yang akan dibuat spasi
     * @param bool   $to_underscore true jika ingin membuat spasi menjadi underscore, false jika sebaliknya
     * @param bool   $lowercase     true jika ingin mengubah huruf menjadi kecil semua
     *
     * @return string string yang sudah dibuat spasi
     */
    function underscore($str, $to_underscore = true, $lowercase = false): string
    {
        // membersihkan string di akhir dan di awal
        $str = trim($str);

        // membuat text lowercase jika diperlukan
        if ($lowercase) {
            $str = MB_ENABLED ? mb_strtolower($str) : strtolower($str);
        }

        // menyajikan hasil akhir
        return $to_underscore ? str_replace(' ', '_', $str) : str_replace('_', ' ', $str);
    }
}

if (!function_exists('akun_demo')) {
    /**
     * Membuat batasan agar akun demo tidak dapat dihapus pada demo_mode
     *
     * @param int   $id
     * @param mixed $redirect
     */
    function akun_demo($id, $redirect = true)
    {
        if (config_item('demo_mode') && in_array($id, array_keys(config_item('demo_akun')))) {
            if ($redirect) {
                session_error(', tidak dapat mengubah / menghapus akun demo');
                redirect($_SERVER['HTTP_REFERER']);
            }

            return true;
        }
    }
}

if (!function_exists('folder')) {
    /**
     * Membuat folder jika tidak tersedia
     *
     * @param string     $folder
     * @param string     $permissions
     * @param mixed|null $htaccess
     * @param array|null $extra
     */
    function folder($folder = null, $permissions = 0755, $htaccess = null, array $extra = []): bool
    {
        $hasil = true;

        get_instance()->load->helper('file');

        $folder = FCPATH . $folder;

        // Buat folder
        $hasil = is_dir($folder) || mkdir($folder, $permissions, true);

        if ($hasil) {
            if ($htaccess !== null) {
                write_file($folder . '.htaccess', config_item($htaccess), 'x');
            }

            // File index.html
            write_file($folder . 'index.html', config_item('index_html'), 'x');

            foreach ($extra as $value) {
                $file    = realpath($value);
                $newfile = realpath($folder) . DIRECTORY_SEPARATOR . basename($value);

                copy($file, $newfile);
            }

            return true;
        }

        return false;
    }
}

if (!function_exists('folder_desa')) {
    /**
     * Membuat folder desa dan isinya
     */
    function folder_desa(): bool
    {
        get_instance()->load->config('installer');
        $list_folder = array_merge(config_item('desa'), config_item('lainnya'));

        // Buat folder dan subfolder desa
        foreach ($list_folder as $folder => $lainnya) {
            folder($folder, $lainnya[0], $lainnya[1], $lainnya[2] ?? []);
        }

        write_file(LOKASI_CONFIG_DESA . 'config.php', config_item('config'), 'x');
        write_file(LOKASI_CONFIG_DESA . 'database.php', config_item('database'), 'x');
        write_file(DESAPATH . 'pengaturan/siteman/siteman.css', config_item('siteman_css'), 'x');
        write_file(DESAPATH . 'pengaturan/siteman/siteman_mandiri.css', config_item('siteman_mandiri_css'), 'x');
        write_file(DESAPATH . 'app_key', set_app_key(), 'x');

        config()->set('app.key', get_app_key());

        // set config app.key untuk proses intall
        config()->set('app.key', get_app_key());

        return true;
    }
}

if (!function_exists('auth')) {
    /**
     * Ambil data user login
     *
     * @param mixed|null $params
     */
    function auth($params = null)
    {
        $CI = &get_instance();

        if (null !== $params) {
            return $CI->session->isAdmin->{$params};
        }

        return $CI->session->isAdmin;
    }
}

if (!function_exists('ci_db')) {
    function ci_db()
    {
        return get_instance()->db;
    }
}

if (!function_exists('cek_kehadiran')) {
    /**
     * Cek perangkat lupa absen
     */
    function cek_kehadiran(): void
    {
        if (!empty(setting('rentang_waktu_kehadiran')) || setting('rentang_waktu_kehadiran')) {
            $cek_libur = JamKerja::libur()->first();
            $cek_jam   = JamKerja::jamKerja()->first();
            $kehadiran = Kehadiran::where('status_kehadiran', 'hadir')->where('jam_keluar', null)->get();
            if ($kehadiran->count() > 0 && ($cek_jam != null || $cek_libur != null)) {
                foreach ($kehadiran as $data) {
                    Kehadiran::lupaAbsen($data->tanggal);
                }
            }
        }
    }
}

/**
 * Dipanggil untuk setiap kode isian ditemukan,
 * dan diganti dengan kata pengganti yang huruf besar/kecil mengikuti huruf kode isian.
 * Berdasarkan contoh di http://stackoverflow.com/questions/19317493/php-preg-replace-case-insensitive-match-with-case-sensitive-replacement
 *
 * @param string $dari
 * @param string $ke
 * @param string $str
 *
 * @return void
 */
if (!function_exists('case_replace')) {
    function case_replace($dari, $ke, $str)
    {
        $replacer = static function (array $matches) use ($ke) {
            $matches = array_map(static fn ($match) => preg_replace('/[\\[\\]]/', '', $match), $matches);

            return caseWord($matches[0], $ke);
        };

        $dari = str_replace('[', '\\[', $dari);

        $result = preg_replace_callback('/(' . $dari . ')/i', $replacer, $str);

        if (preg_match('/pendidikan/i', strtolower($dari))) {
            $result = kasus_lain('pendidikan', $result);
        } elseif (preg_match('/pekerjaan/i', strtolower($dari))) {
            $result = kasus_lain('pekerjaan', $result);
        }

        return $result;
    }
}

if (!function_exists('kirim_versi_opensid')) {
    function kirim_versi_opensid(): void
    {
        if (!config_item('demo_mode')) {
            $ci = get_instance();
            if (empty($ci->header['desa']['kode_desa'])) {
                return;
            }

            $ci->load->driver('cache');

            $versi = AmbilVersi();

            if ($versi != $ci->cache->file->get('versi_app_cache')) {
                try {
                    $client = new GuzzleHttp\Client();
                    $client->post(config_item('server_layanan') . '/api/v1/pelanggan/catat-versi', [
                        'headers'     => ['X-Requested-With' => 'XMLHttpRequest'],
                        'form_params' => [
                            'kode_desa' => kode_wilayah($ci->header['desa']['kode_desa']),
                            'versi'     => $versi,
                        ],
                    ])
                        ->getBody();
                    $ci->cache->file->save('versi_app_cache', $versi);
                } catch (Exception $e) {
                    log_message('error', $e);
                }
            }
        }
    }
}

if (!function_exists('kotak')) {
    function kotak(?string $data_kolom, int $max_kolom = 26): string
    {
        $view = '';

        for ($i = 0; $i < $max_kolom; $i++) {
            $view .= '<td class="kotak padat tengah">';
            if (isset($data_kolom[$i])) {
                $view .= strtoupper($data_kolom[$i]);
            } else {
                $view .= '&nbsp;';
            }
            $view .= '</td>';
        }

        return $view;
    }
}

if (!function_exists('checklist')) {
    function checklist($kondisi_1, $kondisi_2): string
    {
        $view = '<td class="kotak padat tengah">';
        if ($kondisi_1 == $kondisi_2) {
            $view .= '<img src="' . FCPATH . 'assets/images/check.png' . '" height="10" width="10"/>';
        }

        return $view . '</td>';
    }
}

if (!function_exists('create_tree_folder')) {
    function create_tree_folder($arr, string $baseDir)
    {
        if (!empty($arr)) {
            $tmp = '<ul class="tree-folder">';

            foreach ($arr as $i => $val) {
                if (is_array($val)) {
                    $permission     = decoct(fileperms($baseDir . DIRECTORY_SEPARATOR . $i) & 0777);
                    $iconPermission = $permission === decoct(DESAPATHPERMISSION) ? '<i class="fa fa-check-circle-o fa-lg pull-right" style="color:green"></i>' : '<i class="fa fa-times-circle-o fa-lg pull-right" style="color:red"></i>';
                    $liClass        = $permission === decoct(DESAPATHPERMISSION) ? 'text-green' : 'text-red';
                    $tmp .= '<li class="' . $liClass . '"  data-path="' . preg_replace('/\/+/', '/', $baseDir . DIRECTORY_SEPARATOR . $i) . '">' . $i . '(' . $permission . ') ' . $iconPermission;
                    $tmp .= create_tree_folder($val, $baseDir . $i);
                    $tmp .= '</li>';
                }
            }

            return $tmp . '</ul>';
        }
    }
}

if (!function_exists('generatePengikut')) {
    function generatePengikut($pengikut, $keterangan): string
    {
        $html = '
                <table width="100%" border=1 style="font-size:8pt;text-align:center; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">NO</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">NIK</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">Nama Lengkap</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">Jenis Kelamin</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">Tempat Lahir</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">Tanggal Lahir</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">SHDK</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">Keterangan</th>
                        </tr>
                        <tr>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">1</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">2</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">3</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">4</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">5</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">6</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">7</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">8</th>
                        </tr>
                    </thead>
                    <tbody>';
        $no = 1;

        foreach ($pengikut as $data) {
            $html .= '
                            <tr>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:3%">' . $no++ . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:18%">' . $data->nik . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:15%" nowrap>' . $data->nama . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:7%" nowrap>' . $data->jenisKelamin->nama . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:10%" nowrap>' . $data->tempatlahir . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:5%" nowrap>' . tgl_indo_out($data->tanggallahir) . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:8%" nowrap>' . $data->pendudukHubungan->nama . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:20%">' . ($keterangan[$data->id] ?? '') . '</td>
                            </tr>
                            ';
        }

        return $html . '
                    </tbody>
                </table>
            ';
    }
}

if (!function_exists('generatePengikutSuratKIS')) {
    function generatePengikutSuratKIS($pengikut): string
    {
        $html = '
                <table width="100%" border=1 style="font-size:8pt;text-align:center; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">NO</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">NAMA</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">NIK</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">JENIS <br/>KELAMIN</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">TEMPAT <br/>TANGGAL LAHIR</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">PEKERJAAN</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">ALAMAT</th>
                        </tr>
                    </thead>
                    <tbody>';
        $no = 1;

        foreach ($pengikut as $data) {
            $html .= '
                            <tr>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:3%">' . $no++ . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:18%">' . $data->nama . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:16%" nowrap>' . $data->nik . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:11%" nowrap>' . $data->jenisKelamin->nama . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:11%" nowrap>' . $data->tempatlahir . ', ' . tgl_indo_out($data->tanggallahir) . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:15%" nowrap>' . $data->pekerjaan->nama . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:20%">' . $data->alamat_sekarang . '</td>
                            </tr>
                            ';
        }

        return $html . '
                    </tbody>
                </table>
            ';
    }
}

if (!function_exists('generatePengikutKartuKIS')) {
    function generatePengikutKartuKIS($kis): string
    {
        $html = '
                <table width="100%" border=1 style="font-size:8pt;text-align:center; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">NO</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">NO. KARTU</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">NAMA DI KARTU</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">NIK</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">ALAMAT DI KARTU</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">TANGGAL LAHIR</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">FASKES <br/>TINGKAT I</th>
                        </tr>
                    </thead>
                    <tbody>';
        $no = 1;

        foreach ($kis as $data) {
            $html .= '
                            <tr>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:3%">' . $no++ . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:18%">' . $data['kartu'] . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:15%" nowrap>' . $data['nama'] . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:17%" nowrap>' . $data['nik'] . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:16%" nowrap>' . $data['alamat'] . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:15%" nowrap>' . $data['tanggallahir'] . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:13%">' . $data['faskes'] . '</td>
                            </tr>
                            ';
        }

        return $html . '
                    </tbody>
                </table>
            ';
    }
}

if (!function_exists('generatePengikutPindah')) {
    function generatePengikutPindah($pengikut): string
    {
        $html = '
                <table width="100%" border=1 style="font-size:8pt;text-align:center; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">NO</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">NIK</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">NAMA</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">MASA BERLAKU <br/>KTP S/D</th>
                            <th style="border-color: #000000; border-style: solid; border-collapse: collapse">SHDK</th>
                        </tr>
                    </thead>
                    <tbody>';
        $no = 1;

        foreach ($pengikut as $data) {
            $html .= '
                            <tr>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:3%">' . $no++ . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:25%" nowrap>' . $data->nik . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:25%">' . $data->nama . '</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:22%" nowrap> Seumur Hidup</td>
                                <td style="border-color: #000000; border-style: solid; border-collapse: collapse; width:25%">' . $data->pendudukHubungan->nama . '</td>
                            </tr>
                            ';
        }

        return $html . '
                    </tbody>
                </table>
            ';
    }
}
function tidak_ada_data($col = 12, string $message = 'Data Tidak Tersedia'): void
{
    $html = '
        <tr>
            <td class="text-center" colspan="' . $col . '">' . $message . '</td>
        </tr>';
    echo $html;
}

if (!function_exists('data_lengkap')) {
    function data_lengkap(): bool
    {
        $CI = &get_instance();

        return (bool) $CI->setting->tgl_data_lengkap_aktif;
    }
}

if (!function_exists('buat_class')) {
    function buat_class($class1 = '', $class2 = '', $required = false): string
    {
        $onlyClass = '';
        preg_match('/class="([^"]+)"/', $class1, $match);
        if ($match) {
            $onlyClass = $match[1];
        }

        $onlyAttributes = preg_replace('/class="[^"]+"/', '', $class1);

        if (empty($class2) || $class2 === null) {
            $class2 = 'form-control input-sm';
        }

        if ($required) {
            $onlyClass .= ' required';
        }

        return 'class="' . $class2 . ' ' . $onlyClass . '" ' . $onlyAttributes;
    }
}

if (!function_exists('cek_lokasi_peta')) {
    function cek_lokasi_peta(array $wilayah): bool
    {
        if ($wilayah['dusun'] == '-') {
            $wilayah = identitas();
        }

        return $wilayah['path'] && ($wilayah['lat'] && !empty($wilayah['lng']));
    }
}

if (!function_exists('config_email')) {
    function config_email()
    {
        return [
            'active'    => (int) setting('email_notifikasi'),
            'protocol'  => setting('email_protocol'),
            'smtp_host' => setting('email_smtp_host'),
            'smtp_user' => setting('email_smtp_user'),
            'smtp_pass' => setting('email_smtp_pass'),
            'smtp_port' => (int) setting('email_smtp_port'),
        ];
    }
}

// source: https://stackoverflow.com/questions/12553160/getting-visitors-country-from-their-ip
if (!function_exists('geoip_info')) {
    function geoip_info($ip = null, $purpose = 'location', $deep_detect = true)
    {
        $output = null;
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = $_SERVER['REMOTE_ADDR'];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                }
            }
        }
        $purpose    = str_replace(['name', "\n", "\t", ' ', '-', '_'], null, strtolower(trim($purpose)));
        $support    = ['country', 'countrycode', 'state', 'region', 'city', 'location', 'address'];
        $continents = [
            'AF' => 'Africa',
            'AN' => 'Antarctica',
            'AS' => 'Asia',
            'EU' => 'Europe',
            'OC' => 'Australia (Oceania)',
            'NA' => 'North America',
            'SA' => 'South America',
        ];
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip=' . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case 'location':
                        $output = [
                            'city'           => @$ipdat->geoplugin_city,
                            'state'          => @$ipdat->geoplugin_regionName,
                            'country'        => @$ipdat->geoplugin_countryName,
                            'country_code'   => @$ipdat->geoplugin_countryCode,
                            'continent'      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            'continent_code' => @$ipdat->geoplugin_continentCode,
                        ];
                        break;

                    case 'address':
                        $address = [$ipdat->geoplugin_countryName];
                        if (@$ipdat->geoplugin_regionName !== '') {
                            $address[] = $ipdat->geoplugin_regionName;
                        }
                        if (@$ipdat->geoplugin_city !== '') {
                            $address[] = $ipdat->geoplugin_city;
                        }
                        $output = implode(', ', array_reverse($address));
                        break;

                    case 'city':
                        $output = @$ipdat->geoplugin_city;
                        break;

                    case 'state':

                    case 'region':
                        $output = @$ipdat->geoplugin_regionName;
                        break;

                    case 'country':
                        $output = @$ipdat->geoplugin_countryName;
                        break;

                    case 'countrycode':
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }

        return $output;
    }
}

if (!function_exists('batal')) {
    function batal(): string
    {
        return '<button type="reset" class="btn btn-social btn-danger btn-sm pull-left"><i class="fa fa-times"></i> Batal</button>';
    }
}

if (!function_exists('sensorEmail')) {
    function sensorEmail($email): string
    {
        if (!$email || null === $email) {
            return '';
        }
        $atPosition = strpos($email, '@');

        $firstPart  = substr($email, 0, 2);
        $secondPart = substr($email, 1, $atPosition - 2);
        $lastPart   = substr($email, $atPosition);

        return $firstPart . str_repeat('*', strlen($secondPart)) . $lastPart;
    }
}

if (!function_exists('gis_simbols')) {
    function gis_simbols()
    {
        $simbols = DB::table('gis_simbol')->get('simbol');

        return $simbols->map(static fn ($item): array => (array) $item)->toArray();
    }
}
