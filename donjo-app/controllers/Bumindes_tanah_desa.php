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

class Bumindes_tanah_desa extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['tanah_desa_model', 'pamong_model']);
        $this->modul_ini     = 'buku-administrasi-desa';
        $this->sub_modul_ini = 'administrasi-umum';
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $start  = $this->input->post('start');
            $length = $this->input->post('length');
            $search = $this->input->post('search[value]');
            $order  = $this->tanah_desa_model::ORDER_ABLE[$this->input->post('order[0][column]')];
            $dir    = $this->input->post('order[0][dir]');

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'draw'            => $this->input->post('draw'),
                    'recordsTotal'    => $this->tanah_desa_model->get_data()->count_all_results(),
                    'recordsFiltered' => $this->tanah_desa_model->get_data($search)->count_all_results(),
                    'data'            => $this->tanah_desa_model->get_data($search)->order_by($order, $dir)->limit($length, $start)->get()->result(),
                ], JSON_THROW_ON_ERROR));
        }

        $this->render('bumindes/umum/main', [
            'subtitle'     => 'Buku Tanah di ' . ucwords($this->setting->sebutan_desa),
            'selected_nav' => 'tanah',
            'main_content' => 'bumindes/pembangunan/tanah_di_desa/content_tanah_di_desa',
        ]);
    }

    public function clear(): void
    {
        $this->session->filter_tahun = date('Y');
        $this->session->filter_bulan = date('m');

        redirect('bumindes_tanah_desa');
    }

    public function view_tanah_desa($id): void
    {
        $data = [
            'main'         => $this->tanah_desa_model->view_tanah_desa_by_id($id) ?? show_404(),
            'main_content' => 'bumindes/pembangunan/tanah_di_desa/form_tanah_di_desa',
            'subtitle'     => 'Buku Tanah di Desa',
            'selected_nav' => 'tanah',
            'view_mark'    => 1,
        ];

        $this->render('bumindes/umum/main', $data);
    }

    public function form($id = ''): void
    {
        $this->redirect_hak_akses('u');
        if ($id) {
            $data = [
                'main'        => $this->tanah_desa_model->view_tanah_desa_by_id($id) ?? show_404(),
                'form_action' => site_url("bumindes_tanah_desa/update_tanah_desa/{$id}"),
            ];
        } else {
            $data = [
                'main'        => null,
                'form_action' => site_url('bumindes_tanah_desa/add_tanah_desa'),
            ];
        }

        $data['main_content'] = 'bumindes/pembangunan/tanah_di_desa/form_tanah_di_desa';
        $data['penduduk']     = $this->tanah_desa_model->list_penduduk();
        $data['subtitle']     = 'Buku Tanah di Desa';
        $data['selected_nav'] = 'tanah';
        $data['view_mark']    = 0;

        $this->render('bumindes/umum/main', $data);
    }

    public function add_tanah_desa(): void
    {
        $this->redirect_hak_akses('u');
        $this->tanah_desa_model->add_tanah_desa();
        if ($this->session->success == -1) {
            $this->session->dari_internal = true;
            redirect('bumindes_tanah_desa/form');
        } else {
            redirect('bumindes_tanah_desa/clear');
        }
    }

    public function update_tanah_desa($id): void
    {
        $this->redirect_hak_akses('u');
        $this->tanah_desa_model->update_tanah_desa();
        if ($this->session->success == -1) {
            $this->session->dari_internal = true;
            redirect("bumindes_tanah_desa/form/{$id}");
        } else {
            redirect('bumindes_tanah_desa/clear');
        }
    }

    public function delete_tanah_desa($id): void
    {
        $this->redirect_hak_akses('h');
        $this->tanah_desa_model->delete_tanah_desa($id);

        redirect('bumindes_tanah_desa');
    }

    public function cetak_tanah_desa($aksi = ''): void
    {
        $data              = $this->modal_penandatangan();
        $data['aksi']      = $aksi;
        $data['main']      = $this->tanah_desa_model->cetak_tanah_desa();
        $data['config']    = $this->header['desa'];
        $data['bulan']     = $this->session->filter_bulan ?: date('m');
        $data['tahun']     = $this->session->filter_tahun ?: date('Y');
        $data['tgl_cetak'] = $this->input->post('tgl_cetak');
        $data['file']      = 'Buku Tanah di Desa';
        $data['isi']       = 'bumindes/pembangunan/tanah_di_desa/tanah_di_desa_cetak';
        $data['letak_ttd'] = ['1', '1', '23'];

        $this->load->view('global/format_cetak', $data);
    }
}
