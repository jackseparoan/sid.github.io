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

use App\Models\LogPenduduk;

defined('BASEPATH') || exit('No direct script access allowed');

class Bumindes_penduduk_rekapitulasi extends Admin_Controller
{
    private array $_set_page     = ['10', '20', '50', '100'];
    private array $_list_session = ['filter', 'status_dasar', 'sex', 'agama', 'dusun', 'rw', 'rt', 'cari', 'umur_min', 'umur_max', 'umurx', 'pekerjaan_id', 'status', 'pendidikan_sedang_id', 'pendidikan_kk_id', 'status_penduduk', 'judul_statistik', 'cacat', 'cara_kb_id', 'akta_kelahiran', 'status_ktp', 'id_asuransi', 'status_covid', 'bantuan_penduduk', 'log', 'warganegara', 'menahun', 'hubungan', 'golongan_darah', 'hamil', 'kumpulan_nik'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['pamong_model', 'penduduk_model', 'laporan_bulanan_model', 'laporan_sinkronisasi_model', 'wilayah_model']);
        $this->modul_ini          = 'buku-administrasi-desa';
        $this->sub_modul_ini      = 'administrasi-penduduk';
        $this->header['kategori'] = 'data_lengkap';
        $this->logpenduduk        = new LogPenduduk();
    }

    public function index($page_number = 1): void
    {
        $per_page = $this->input->post('per_page');
        if (isset($per_page)) {
            $this->session->per_page = $per_page;
        }

        $tanggal_lengkap = $this->logpenduduk::min('tgl_lapor');
        $data            = [
            'main_content'  => 'bumindes/penduduk/rekapitulasi/content_rekapitulasi',
            'subtitle'      => 'Buku Rekapitulasi Jumlah Penduduk',
            'selected_nav'  => 'rekapitulasi',
            'p'             => $page_number,
            'cari'          => $this->session->cari ?: '',
            'filter'        => $this->session->filter ?: '',
            'per_page'      => $this->session->per_page,
            'bulan'         => $this->session->filter_bulan ?: null,
            'tahun'         => $this->session->filter_tahun ?: null,
            'func'          => 'index',
            'set_page'      => $this->_set_page,
            'tgl_lengkap'   => $tanggal_lengkap,
            'paging'        => $this->laporan_bulanan_model->rekapitulasi_paging($page_number),
            'tahun_lengkap' => (new DateTime($tanggal_lengkap))->format('Y'),
        ];

        $data['main'] = $this->laporan_bulanan_model->rekapitulasi_list($data['paging']->offset, $data['paging']->per_page);

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
        redirect('bumindes_penduduk_rekapitulasi');
    }

    public function ajax_cetak($aksi = ''): void
    {
        $data = [
            'aksi'        => $aksi,
            'list_tahun'  => $this->penduduk_log_model->list_tahun(),
            'form_action' => site_url("bumindes_penduduk_rekapitulasi/cetak/{$aksi}"),
            'isi'         => 'bumindes/penduduk/rekapitulasi/ajax_dialog_rekapitulasi',
        ];

        $this->load->view('global/dialog_cetak', $data);
    }

    public function cetak($aksi = ''): void
    {
        $data                  = $this->modal_penandatangan();
        $data['aksi']          = $aksi;
        $data['main']          = $this->laporan_bulanan_model->rekapitulasi_list(null, null);
        $data['config']        = $this->header['desa'];
        $data['bulan']         = $this->session->filter_bulan ?: date('m');
        $data['tahun']         = $this->session->filter_tahun ?: date('Y');
        $data['tgl_cetak']     = $this->input->post('tgl_cetak');
        $data['tampil_jumlah'] = $this->input->post('tampil_jumlah');
        $data['file']          = 'Buku Rekapitulasi Jumlah Penduduk';
        $data['isi']           = 'bumindes/penduduk/rekapitulasi/content_rekapitulasi_cetak';
        $data['letak_ttd']     = ['1', '2', '28'];

        if ($aksi == 'pdf') {
            $this->laporan_pdf($data);
        } else {
            $this->load->view('global/format_cetak', $data);
        }
    }

    private function laporan_pdf($data): void
    {
        $nama_file = 'rekap_jumlah_penduduk_' . date('Y_m_d');
        $file      = FCPATH . LOKASI_DOKUMEN . $nama_file;
        $data      = array_merge($data, ['width' => 400]); // lebar dalam mm
        $laporan   = $this->load->view('global/format_cetak', $data, true);
        buat_pdf($laporan, $file, null, 'L', [200, 400]); // perlu berikan dimensi eksplisit dalam mm

        $where = [
            'semester' => $this->session->filter_bulan,
            'tahun'    => $this->session->filter_tahun,
        ];

        $lap_sinkron = [
            'judul'     => 'Rekap Jumlah Penduduk',
            'semester'  => $this->session->filter_bulan,
            'tahun'     => $this->session->filter_tahun,
            'nama_file' => $nama_file . '.pdf',
            'tipe'      => 'laporan_penduduk',
        ];
        $this->laporan_sinkronisasi_model->insert_or_update($where, $lap_sinkron);
    }

    public function autocomplete(): void
    {
        $data = $this->wilayah_model->autocomplete($this->input->post('cari'));
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
        redirect('bumindes_penduduk_rekapitulasi');
    }
}
