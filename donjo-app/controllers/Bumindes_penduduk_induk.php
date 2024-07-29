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

use App\Models\Pamong;

defined('BASEPATH') || exit('No direct script access allowed');

class Bumindes_penduduk_induk extends Admin_Controller
{
    private array $_set_page     = ['10', '20', '50', '100', [0, 'Semua']];
    private array $_list_session = ['filter_tahun', 'filter_bulan', 'status_hanya_tetap', 'jenis_peristiwa', 'filter', 'status_dasar', 'sex', 'agama', 'dusun', 'rw', 'rt', 'cari', 'umur_min', 'umur_max', 'umurx', 'pekerjaan_id', 'status', 'pendidikan_sedang_id', 'pendidikan_kk_id', 'status_penduduk', 'judul_statistik', 'cacat', 'cara_kb_id', 'akta_kelahiran', 'status_ktp', 'id_asuransi', 'status_covid', 'bantuan_penduduk', 'log', 'warganegara', 'menahun', 'hubungan', 'golongan_darah', 'hamil', 'kumpulan_nik'];

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['pamong_model', 'penduduk_model']);

        $this->modul_ini     = 'buku-administrasi-desa';
        $this->sub_modul_ini = 'administrasi-penduduk';
    }

    public function index($page_number = 1, $order_by = 0): void
    {
        $per_page = $this->input->post('per_page');
        if (isset($per_page)) {
            $this->session->per_page = $per_page;
        }

        // Hanya menampilkan data status_dasar HIDUP, HILANG
        $this->session->status_dasar = [1, 4];

        // Menampilkan hanya status penduduk TETAP
        $this->session->status_penduduk = 1;

        $list_data = $this->penduduk_model->list_data($order_by, $page_number);
        $data      = [
            'main_content' => 'bumindes/penduduk/induk/content_induk',
            'subtitle'     => 'Buku Induk Penduduk',
            'selected_nav' => 'induk',
            'page'         => $page_number,
            'order_by'     => $order_by,
            'cari'         => $this->session->cari ?: '',
            'filter'       => $this->session->filter ?: '',
            'bulan'        => $this->session->filter_bulan,
            'tahun'        => $this->session->filter_tahun,
            'func'         => 'index',
            'set_page'     => $this->_set_page,
            'main'         => $list_data['main'],
            'paging'       => $list_data['paging'],
            'list_tahun'   => $this->penduduk_log_model->list_tahun(),
        ];

        $this->render('bumindes/penduduk/main', $data);
    }

    private function clear_session(): void
    {
        $this->session->unset_userdata($this->_list_session);
        $this->session->per_page = $this->_set_page[0];
    }

    public function clear(): void
    {
        $this->clear_session();
        // Set default filter ke tahun dan bulan sekarang
        $this->session->filter_tahun = date('Y');
        $this->session->filter_bulan = date('m');
        redirect('bumindes_penduduk_induk');
    }

    public function ajax_cetak($page = 1, $o = 0, $aksi = ''): void
    {
        // pengaturan data untuk dialog cetak/unduh
        $data = [
            'o'                   => $o,
            'aksi'                => $aksi,
            'form_action'         => site_url("bumindes_penduduk_induk/cetak/{$page}/{$o}/{$aksi}"),
            'form_action_privasi' => site_url("bumindes_penduduk_induk/cetak/{$page}/{$o}/{$aksi}/1"),
            'isi'                 => 'bumindes/penduduk/induk/ajax_dialog_induk',
        ];

        $this->load->view('global/dialog_cetak', $data);
    }

    public function cetak($page = 1, $o = 0, $aksi = '', $privasi_nik = 0): void
    {
        $data = [
            'aksi'           => $aksi,
            'config'         => $this->header['desa'],
            'pamong_ttd'     => Pamong::sekretarisDesa()->first(),
            'pamong_ketahui' => Pamong::kepalaDesa()->first(),
            'main'           => $this->penduduk_model->list_data($o, $page)['main'],
            'bulan'          => $this->session->filter_bulan,
            'tahun'          => $this->session->filter_tahun,
            'tgl_cetak'      => $_POST['tgl_cetak'],
            'privasi_nik'    => $privasi_nik == 1,
            'file'           => 'Buku Induk Kependudukan',
            'isi'            => 'bumindes/penduduk/induk/content_induk_cetak',
            'letak_ttd'      => ['2', '2', '9'],
        ];
        $this->load->view('global/format_cetak', $data);
    }

    public function autocomplete(): void
    {
        $data = $this->penduduk_model->autocomplete($this->input->post('cari'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data, JSON_THROW_ON_ERROR));
    }

    public function filter($filter): void
    {
        $value = $this->input->post($filter);
        if ($value != '') {
            $this->session->{$filter} = $value;
        } else {
            $this->session->unset_userdata($filter);
        }
        redirect('bumindes_penduduk_induk');
    }
}
