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

// TODO: OpenKAB - Sesuaikan jika Modul Admin sudah disesuaikan
class Shortcode_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('keuangan_grafik_model');
        $this->load->model('keuangan_grafik_manual_model');
        $this->load->model('laporan_penduduk_model');
        $this->load->model('pamong_model');
        $this->load->model('keuangan_grafik_dd_model');
    }

    // Shortcode untuk isi artikel
    public function shortcode($str = '')
    {
        $regex = '/\\[\\[(.*?)\\]\\]/';

        return preg_replace_callback($regex, function (array $matches) {
            $params_explode = explode(',', $matches[1]);

            return $this->extract_shortcode($params_explode[0], $params_explode[1]);
        }, $str);
    }

    private function extract_shortcode(?string $type = '', ?string $thn = '')
    {
        if ($type == 'grafik-RP-APBD') {
            return $this->grafik_rp_apbd($thn);
        }
        if ($type == 'lap-RP-APBD-sm1') {
            return $this->tabel_rp_apbd($thn, $smt1 = true);
        }
        if ($type == 'lap-RP-APBD-sm2') {
            return $this->tabel_rp_apbd($thn, $smt1 = false);
        }
        if ($type == 'lap-RP-APBD-Bidang-sm1') {
            return $this->tabel_rp_apbd_bidang($thn, $smt1 = true);
        }
        if ($type == 'lap-RP-APBD-Bidang-sm2') {
            return $this->tabel_rp_apbd_bidang($thn, $smt1 = false);
        }
        if ($type == 'penerima_bantuan_penduduk_grafik') {
            return $this->penerima_bantuan_penduduk_grafik($stat = 0);
        }
        if ($type == 'penerima_bantuan_penduduk_daftar') {
            return $this->penerima_bantuan_penduduk_daftar($stat = 0);
        }
        if ($type == 'penerima_bantuan_keluarga_grafik') {
            return $this->penerima_bantuan_keluarga_grafik($stat = 0);
        }
        if ($type == 'penerima_bantuan_keluarga_daftar') {
            return $this->penerima_bantuan_keluarga_daftar($stat = 0);
        }
        if ($type == 'grafik-RP-APBD-manual') {
            return $this->grafik_rp_apbd_manual($thn);
        }
        if ($type == 'lap-RP-APBD-Bidang-manual') {
            return $this->tabel_rp_apbd_bidang_manual($thn);
        }
        if ($type == 'sotk_w_bpd') {
            return $this->sotk_w_bpd();
        }
        if ($type == 'sotk_wo_bpd') {
            return $this->sotk_wo_bpd();
        }
        if ($type == 'grafik-RP-APBD-DD') {
            return $this->grafik_rp_apbd_dd($thn);
        }
        if ($type == 'lap-RP-APBD-dd-sm1') {
            return $this->tabel_rp_apbd_dd($thn, $smt1 = true);
        }
        if ($type == 'lap-RP-APBD-dd-sm2') {
            return $this->tabel_rp_apbd_dd($thn, $smt1 = false);
        }
        if ($type == 'lap-RP-APBD-Bidang-dd-sm1') {
            return $this->tabel_rp_apbd_bidang_dd($thn, $smt1 = true);
        }
        if ($type == 'lap-RP-APBD-Bidang-dd-sm2') {
            return $this->tabel_rp_apbd_bidang_dd($thn, $smt1 = false);
        }
    }

    private function grafik_rp_apbd(string $thn)
    {
        $data        = $this->keuangan_grafik_model->grafik_keuangan_tema($thn);
        $data_widget = $data['data_widget'];

        ob_start();
        include 'donjo-app/views/keuangan/grafik_rp_apbd_chart.php';

        return ob_get_clean();
    }

    private function tabel_rp_apbd(string $thn, bool $smt1)
    {
        $data              = $this->keuangan_grafik_model->lap_rp_apbd($thn, $smt1);
        $desa              = identitas();
        $pendapatan        = $data['pendapatan'];
        $belanja           = $data['belanja'];
        $belanja_bidang    = $data['belanja_bidang'];
        $pembiayaan        = $data['pembiayaan'];
        $pembiayaan_keluar = $data['pembiayaan_keluar'];
        $ta                = $thn;
        $sm                = $smt1 ? '1' : '2';

        ob_start();
        include 'donjo-app/views/keuangan/tabel_laporan_rp_apbd_artikel.php';

        return ob_get_clean();
    }

    private function tabel_rp_apbd_bidang(string $thn, bool $smt1)
    {
        $data              = $this->keuangan_grafik_model->lap_rp_apbd($thn, $smt1);
        $desa              = identitas();
        $pendapatan        = $data['pendapatan'];
        $belanja           = $data['belanja'];
        $belanja_bidang    = $data['belanja_bidang'];
        $pembiayaan        = $data['pembiayaan'];
        $pembiayaan_keluar = $data['pembiayaan_keluar'];
        $ta                = $thn;
        $sm                = $smt1 ? '1' : '2';
        $jenis             = 'bidang';

        ob_start();
        include 'donjo-app/views/keuangan/tabel_laporan_rp_apbd_artikel.php';

        return ob_get_clean();
    }

    private function grafik_rp_apbd_manual(string $thn)
    {
        $data        = $this->keuangan_grafik_manual_model->grafik_keuangan_tema($thn);
        $data_widget = $data['data_widget'];

        ob_start();
        include 'donjo-app/views/keuangan/grafik_rp_apbd_chart.php';

        return ob_get_clean();
    }

    private function tabel_rp_apbd_bidang_manual(string $thn)
    {
        $data              = $this->keuangan_grafik_manual_model->lap_rp_apbd($thn);
        $desa              = identitas();
        $pendapatan        = $data['pendapatan'];
        $belanja           = $data['belanja'];
        $belanja_bidang    = $data['belanja_bidang'];
        $pembiayaan        = $data['pembiayaan'];
        $pembiayaan_keluar = $data['pembiayaan_keluar'];
        $ta                = $thn;
        $jenis             = 'bidang';

        ob_start();
        include 'donjo-app/views/keuangan/tabel_laporan_rp_apbd_artikel.php';

        return ob_get_clean();
    }

    private function penerima_bantuan_penduduk_grafik(int $stat = 0)
    {
        $heading = 'Penerima Bantuan (Penduduk)';
        $stat    = $this->laporan_penduduk_model->list_data('bantuan_penduduk', 0);
        $st      = $stat;
        $lap     = 'bantuan_penduduk';

        ob_start();
        include 'donjo-app/views/statistik/penduduk_grafik_web.php';

        return ob_get_clean();
    }

    private function penerima_bantuan_penduduk_daftar(int $stat = 0)
    {
        $heading = 'Penerima Bantuan (Penduduk)';
        $stat    = $this->laporan_penduduk_model->list_data('bantuan_penduduk', 0);
        $st      = $stat;
        $lap     = 'bantuan_penduduk';

        ob_start();
        include 'donjo-app/views/statistik/peserta_bantuan.php';

        return ob_get_clean();
    }

    private function penerima_bantuan_keluarga_grafik(int $stat = 0)
    {
        $heading = 'Penerima Bantuan (Keluarga)';
        $stat    = $this->laporan_penduduk_model->list_data('bantuan_keluarga', 0);
        $st      = $stat;
        $lap     = 'bantuan_keluarga';

        ob_start();
        include 'donjo-app/views/statistik/penduduk_grafik_web.php';

        return ob_get_clean();
    }

    private function penerima_bantuan_keluarga_daftar(int $stat = 0)
    {
        $heading = 'Penerima Bantuan (Keluarga)';
        $stat    = $this->laporan_penduduk_model->list_data('bantuan_keluarga', 0);
        $st      = $stat;
        $lap     = 'bantuan_keluarga';

        ob_start();
        include 'donjo-app/views/statistik/peserta_bantuan.php';

        return ob_get_clean();
    }

    private function grafik_rp_apbd_dd(string $thn)
    {
        $data        = $this->keuangan_grafik_dd_model->grafik_keuangan_tema($thn);
        $data_widget = $data['data_widget'];

        ob_start();
        include 'donjo-app/views/keuangan/grafik_rp_apbd_chart.php';

        return ob_get_clean();
    }

    private function tabel_rp_apbd_dd(string $thn, bool $smt1)
    {
        $data              = $this->keuangan_grafik_dd_model->lap_rp_apbd($thn, $smt1);
        $desa              = identitas();
        $pendapatan        = $data['pendapatan'];
        $belanja           = $data['belanja'];
        $belanja_bidang    = $data['belanja_bidang'];
        $pembiayaan        = $data['pembiayaan'];
        $pembiayaan_keluar = $data['pembiayaan_keluar'];
        $ta                = $thn;
        $sm                = $smt1 ? '1' : '2';

        ob_start();
        include 'donjo-app/views/keuangan/tabel_laporan_rp_apbd_artikel_dd.php';

        return ob_get_clean();
    }

    private function tabel_rp_apbd_bidang_dd(string $thn, bool $smt1)
    {
        $data              = $this->keuangan_grafik_dd_model->lap_rp_apbd($thn, $smt1);
        $desa              = identitas();
        $pendapatan        = $data['pendapatan'];
        $belanja           = $data['belanja'];
        $belanja_bidang    = $data['belanja_bidang'];
        $pembiayaan        = $data['pembiayaan'];
        $pembiayaan_keluar = $data['pembiayaan_keluar'];
        $ta                = $thn;
        $sm                = $smt1 ? '1' : '2';
        $jenis             = 'bidang';

        ob_start();
        include 'donjo-app/views/keuangan/tabel_laporan_rp_apbd_artikel_dd.php';

        return ob_get_clean();
    }

    private function sotk_w_bpd()
    {
        $desa    = identitas();
        $bagan   = $this->pamong_model->list_bagan();
        $ada_bpd = true;

        ob_start();
        include APPPATH . 'views/bagan/bagan_sisip.php';

        return ob_get_clean();
    }

    private function sotk_wo_bpd()
    {
        $desa    = identitas();
        $bagan   = $this->pamong_model->list_bagan();
        $ada_bpd = false;

        ob_start();
        include APPPATH . 'views/bagan/bagan_sisip.php';

        return ob_get_clean();
    }

    // Shortcode untuk list artikel
    public function convert_sc_list($str = '')
    {
        $regex = '/\\[\\[(.*?)\\]\\]/';

        return preg_replace_callback($regex, function (array $matches) {
            $params_explode = explode(',', $matches[1]);

            return $this->converted_sc_list($params_explode[0] ?? '', $params_explode[1] ?? '');
        }, $str);
    }

    private function converted_sc_list(?string $type = '', ?string $thn = '')
    {
        if ($type == 'lap-RP-APBD-sm1') {
            return "<i class='fa fa-table'></i> Tabel Laporan APBDes Smt. 1 TA. " . $thn . ', ';
        }
        if ($type == 'lap-RP-APBD-sm2') {
            return "<i class='fa fa-table'></i> Tabel Laporan APBDes Smt. 2 TA. " . $thn . ', ';
        }
        if ($type == 'lap-RP-APBD-Bidang-sm1') {
            return "<i class='fa fa-table'></i> Tabel Laporan APBDes Smt. 1 TA. " . $thn . ', ';
        }
        if ($type == 'lap-RP-APBD-Bidang-sm2') {
            return "<i class='fa fa-table'></i> Tabel Laporan APBDes Smt. 2 TA. " . $thn . ', ';
        }
        if ($type == 'grafik-RP-APBD') {
            return "<i class='fa fa-bar-chart'></i> Grafik APBDes TA. " . $thn . ', ';
        }
        if ($type == 'lap-RP-APBD-Bidang-manual') {
            return "<i class='fa fa-table'></i> Tabel Laporan APBDes TA. " . $thn . ', ';
        }
        if ($type == 'grafik-RP-APBD-manual') {
            return "<i class='fa fa-bar-chart'></i> Grafik APBDes TA. " . $thn . ', ';
        }
        if ($type == 'penerima_bantuan_penduduk_grafik') {
            return "<i class='fa fa-bar-chart'></i> Penerima Bantuan (Penduduk)";
        }
        if ($type == 'penerima_bantuan_penduduk_daftar') {
            return "<i class='fa fa-table'></i> Penerima Bantuan (Penduduk)";
        }
        if ($type == 'penerima_bantuan_keluarga_grafik') {
            return "<i class='fa fa-bar-chart'></i> Penerima Bantuan (Keluarga)";
        }
        if ($type == 'penerima_bantuan_keluarga_daftar') {
            return "<i class='fa fa-table'></i> Penerima Bantuan (Keluarga)";
        }
        if ($type == 'sotk_w_bpd') {
            return "<i class='fa fa-table'></i> Struktur Organisasi (BPD)";
        }
        if ($type == 'sotk_wo_bpd') {
            return "<i class='fa fa-table'></i> Struktur Organisasi";
        }
        if ($type == 'lap-RP-APBD-sm1-dd') {
            return "<i class='fa fa-table'></i> Tabel Laporan Dana Desa Smt. 1 TA. " . $thn . ', ';
        }
        if ($type == 'lap-RP-APBD-sm2-dd') {
            return "<i class='fa fa-table'></i> Tabel Laporan Dana Desa Smt. 2 TA. " . $thn . ', ';
        }
        if ($type == 'lap-RP-APBD-Bidang-sm1-dd') {
            return "<i class='fa fa-table'></i> Tabel Laporan Dana Desa Smt. 1 TA. " . $thn . ', ';
        }
        if ($type == 'lap-RP-APBD-Bidang-sm2-dd') {
            return "<i class='fa fa-table'></i> Tabel Laporan Dana Desa Smt. 2 TA. " . $thn . ', ';
        }
        if ($type == 'grafik-RP-APBD-DD') {
            return "<i class='fa fa-bar-chart'></i> Grafik Dana Desa TA. " . $thn . ', ';
        }
    }
}
