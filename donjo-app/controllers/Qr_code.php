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

class Qr_code extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->modul_ini     = 'pengaturan';
        $this->sub_modul_ini = 'qr-code';
    }

    public function index(): void
    {
        $this->set_hak_akses_rfm();
        $data['qrcode']        = ['changeqr' => '1', 'sizeqr' => '6', 'foreqr' => '#000000']; // Default
        $data['list_changeqr'] = ['Otomatis (Logo Desa)', 'Manual'];
        $data['list_sizeqr']   = ['25', '50', '75', '100', '125', '150', '175', '200', '225', '250'];

        $this->render('qrcode/setting_qr', $data);
    }

    public function clear(): void
    {
        $this->session->unset_userdata(['cari', 'filter', 'tipe', 'kategori']);

        redirect($this->controller);
    }

    public function qrcode_generate(): void
    {
        $this->redirect_hak_akses('u');
        $post     = $this->input->post();
        $changeqr = $post['changeqr'];

        // $logoqr = yg akan ditampilkan, url
        // $logoqr1 = yg akan disimpan, directory
        if ($changeqr == '1') {
            // Ambil absolute path, bukan url
            $logoqr1 = gambar_desa($this->header['desa']['logo'], false, true);
        } else {
            $logoqr = $post['logoqr'];
            // Ubah url (http) menjadi absolute path ke file di lokasi media
            $lokasi_media = preg_quote(LOKASI_MEDIA, '/');
            $file_logoqr  = preg_split('/' . $lokasi_media . '/', $logoqr)[1];
            $logoqr1      = FCPATH . LOKASI_MEDIA . $file_logoqr;
        }

        $qrCode = [
            'isiqr'    => $post['isiqr'], // Isi / arti dr qrcode
            'changeqr' => $changeqr, // Pilihan jenis sisipkan logo
            'logoqr'   => $logoqr1,
            'sizeqr'   => bilangan($post['sizeqr']), // Ukuran qrcode
            'foreqr'   => $post['foreqr'],
        ];

        json(qrcode_generate($qrCode, true));
    }
}
