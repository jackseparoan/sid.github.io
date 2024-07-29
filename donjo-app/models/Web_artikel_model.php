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

use App\Models\Artikel;
use App\Models\UserGrup;

defined('BASEPATH') || exit('No direct script access allowed');

class Web_artikel_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('agenda_model');
    }

    public function autocomplete($cat)
    {
        $this->group_akses();

        $this->list_data_sql($cat);

        $data = $this->db->select('a.judul')->get()->result_array();

        return autocomplete_data_ke_str($data);
    }

    private function search_sql(): void
    {
        $cari = $this->session->cari;

        if (isset($cari)) {
            $this->db->like('a.judul', $cari);
        }
    }

    private function filter_sql(): void
    {
        $status = $this->session->status;

        if (isset($status)) {
            $this->db->where('a.enabled', $status);
        }
    }

    // TODO : Gunakan $this->group_akses(); jika sudah menggunakan query builder
    private function grup_sql(): void
    {
        // Kontributor dan lainnya (group yg dibuat sendiri) hanya dapat melihat artikel yg dibuatnya sendiri
        if (! in_array($this->session->grup, (new UserGrup())->getGrupSistem())) {
            $this->db->where('a.id_user', $this->session->user);
        }
    }

    public function paging($cat = -1, $p = 1, $o = 0)
    {
        $this->db->select('COUNT(a.id) as jml');
        $this->list_data_sql($cat);
        $row      = $this->db->get()->row_array();
        $jml_data = $row['jml'];

        $this->load->library('paging');
        $cfg['page']     = $p;
        $cfg['per_page'] = $_SESSION['per_page'];
        $cfg['num_rows'] = $jml_data;
        $this->paging->init($cfg);

        return $this->paging;
    }

    private function list_data_sql($cat): void
    {
        $this->config_id('a')
            ->from('artikel a')
            ->join('kategori k', 'a.id_kategori = k.id', 'left');
        if ($cat == '-1') {
            $this->db->where('a.tipe', 'dinamis');
        } elseif (in_array($cat, Artikel::TIPE_NOT_IN_ARTIKEL)) {
            $this->db->where('id_kategori')->where('a.tipe', $cat);
        } elseif ($cat > 0) {
            // Semua artikel dinamis (tidak termasuk artikel statis)
            $this->db->where('a.tipe', 'dinamis')->where('k.id', $cat);
        } else {
            // Artikel dinamis tidak berkategori
            $this->db->where('a.tipe', 'dinamis')->where('k.id', null);
        }
        $this->search_sql();
        $this->filter_sql();
        $this->grup_sql();
    }

    public function list_data($cat = -1, $o = 0, $offset = 0, $limit = 500)
    {
        switch ($o) {
            case 1: $this->db->order_by('judul');
                break;

            case 2: $this->db->order_by('judul', 'DESC');
                break;

            case 3: $this->db->order_by('hit');
                break;

            case 4: $this->db->order_by('hit', 'DESC');
                break;

            case 5: $this->db->order_by('tgl_upload');
                break;

            case 6: $this->db->order_by('tgl_upload', 'DESC');
                break;

            default: $this->db->order_by('id', 'DESC');
        }

        $this->db->select('a.*, k.kategori AS kategori, YEAR(tgl_upload) as thn, MONTH(tgl_upload) as bln, DAY(tgl_upload) as hri');
        $this->db->limit($limit, $offset);
        $this->list_data_sql($cat);

        $data = $this->db->get()->result_array();

        $j       = $offset;
        $counter = count($data);

        for ($i = 0; $i < $counter; $i++) {
            $data[$i]['no']         = $j + 1;
            $data[$i]['boleh_ubah'] = $this->boleh_ubah($data[$i]['id'], $this->session->user);
            $data[$i]['judul']      = e($data[$i]['judul']);
            $j++;
        }

        return $data;
    }

    // TODO: pindahkan dan gunakan web_kategori_model
    private function kategori($id)
    {
        return $this->config_id(null, true)
            ->where('parrent', $id)
            ->order_by('urut')
            ->get('kategori')
            ->result_array();
    }

    // TODO: pindahkan dan gunakan web_kategori_model
    public function list_kategori()
    {
        $data    = $this->kategori(0);
        $counter = count($data);

        for ($i = 0; $i < $counter; $i++) {
            $data[$i]['submenu'] = $this->kategori($data[$i]['id']);
        }

        $data[] = [
            'id'       => '0',
            'kategori' => '[Tidak Berkategori]',
        ];

        return $data;
    }

    // TODO: pindahkan dan gunakan web_kategori_model
    public function get_kategori_artikel($id)
    {
        return $this->config_id()->select('id_kategori')->where('id', $id)->get('artikel')->row_array();
    }

    // TODO: pindahkan dan gunakan web_kategori_model
    public function get_kategori($cat = -1)
    {
        return $this->config_id()
            ->select('kategori')
            ->where('id', $cat)
            ->get('kategori')
            ->row_array();
    }

    public function insert($cat = 1): void
    {
        session_error_clear();
        $data = $this->input->post();
        if (empty($data['judul']) || empty($data['isi'])) {
            $_SESSION['error_msg'] .= ' -> Data harus diisi';
            $_SESSION['success'] = -1;

            return;
        }

        // Batasi judul menggunakan teks polos
        $data['judul'] = judul($data['judul']);

        $fp          = time();
        $list_gambar = ['gambar', 'gambar1', 'gambar2', 'gambar3'];

        foreach ($list_gambar as $gambar) {
            $lokasi_file = $_FILES[$gambar]['tmp_name'];
            $nama_file   = $fp . '_' . $_FILES[$gambar]['name'];
            if (! empty($lokasi_file)) {
                $tipe_file = TipeFile($_FILES[$gambar]);
                $hasil     = UploadArtikel($nama_file, $gambar);
                if ($hasil) {
                    $data[$gambar] = $nama_file;
                } else {
                    redirect('web');
                }
            }
        }
        $data['id_kategori'] = in_array($cat, Artikel::TIPE_NOT_IN_ARTIKEL) ? null : $cat;
        $data['tipe']        = in_array($cat, Artikel::TIPE_NOT_IN_ARTIKEL) ? $cat : 'dinamis';
        $data['id_user']     = $_SESSION['user'];

        // Kontributor tidak dapat mengaktifkan artikel
        if ($_SESSION['grup'] == 4) {
            $data['enabled'] = 2;
        }

        // Upload dokumen lampiran
        // TODO: Sederhanakan cara unggah ini
        $lokasi_file = $_FILES['dokumen']['tmp_name'];
        $tipe_file   = TipeFile($_FILES['dokumen']);
        $nama_file   = $_FILES['dokumen']['name'];
        $ext         = get_extension($nama_file);
        $nama_file   = time() . random_int(10000, 999999) . $ext;

        if ($nama_file && ! empty($lokasi_file)) {
            if (! in_array($tipe_file, unserialize(MIME_TYPE_DOKUMEN), true) || ! in_array($ext, unserialize(EXT_DOKUMEN))) {
                unset($data['link_dokumen']);
                $_SESSION['error_msg'] .= ' -> Jenis file salah: ' . $tipe_file;
                $_SESSION['success'] = -1;
            } else {
                $data['dokumen'] = $nama_file;
                if ($data['link_dokumen'] == '') {
                    $data['link_dokumen'] = $data['judul'];
                }
                UploadDocument2($nama_file);
            }
        }

        foreach ($list_gambar as $gambar) {
            unset($data['old_' . $gambar]);
        }
        if ($data['tgl_upload'] == '') {
            $data['tgl_upload'] = date('Y-m-d H:i:s');
        } else {
            $tempTgl            = date_create_from_format('d-m-Y H:i:s', $data['tgl_upload']);
            $data['tgl_upload'] = $tempTgl->format('Y-m-d H:i:s');
        }
        if ($data['tgl_agenda'] == '') {
            unset($data['tgl_agenda']);
        } else {
            $tempTgl            = date_create_from_format('d-m-Y H:i:s', $data['tgl_agenda']);
            $data['tgl_agenda'] = $tempTgl->format('Y-m-d H:i:s');
        }

        $data['slug']      = unique_slug('artikel', $data['judul']);
        $data['config_id'] = identitas('id');

        $outp = $cat == AGENDA ? $this->insert_agenda($data) : $this->db->insert('artikel', $data);
        status_sukses($outp);
    }

    private function ambil_data_agenda(&$data)
    {
        $agenda               = [];
        $agenda['tgl_agenda'] = $data['tgl_agenda'];
        unset($data['tgl_agenda']);
        $agenda['koordinator_kegiatan'] = $data['koordinator_kegiatan'];
        unset($data['koordinator_kegiatan']);
        $agenda['lokasi_kegiatan'] = $data['lokasi_kegiatan'];
        unset($data['lokasi_kegiatan']);

        return $agenda;
    }

    private function insert_agenda($data)
    {
        $agenda = $this->ambil_data_agenda($data);
        unset($data['id_agenda']);
        $outp = $this->db->insert('artikel', $data);
        if ($outp) {
            $insert_id            = $this->db->insert_id();
            $agenda['id_artikel'] = $insert_id;
            $this->agenda_model->insert($agenda);
        }

        return $outp;
    }

    public function update($cat, $id = 0): void
    {
        session_error_clear();

        $data = $_POST;

        $hapus_lampiran = $data['hapus_lampiran'];
        unset($data['hapus_lampiran']);

        if (empty($data['judul']) || empty($data['isi'])) {
            $_SESSION['error_msg'] .= ' -> Data harus diisi';
            $_SESSION['success'] = -1;

            return;
        }

        // Batasi judul menggunakan teks polos
        $data['judul'] = judul($data['judul']);

        $fp          = time();
        $list_gambar = ['gambar', 'gambar1', 'gambar2', 'gambar3'];

        foreach ($list_gambar as $gambar) {
            $lokasi_file = $_FILES[$gambar]['tmp_name'];
            $nama_file   = $fp . '_' . $_FILES[$gambar]['name'];

            if (! empty($lokasi_file)) {
                $tipe_file = TipeFile($_FILES[$gambar]);
                $hasil     = UploadArtikel($nama_file, $gambar);
                if ($hasil) {
                    $data[$gambar] = $nama_file;
                    HapusArtikel($data['old_' . $gambar]);
                } else {
                    unset($data[$gambar]);
                }
            } else {
                unset($data[$gambar]);
            }
        }

        foreach ($list_gambar as $gambar) {
            if (isset($data[$gambar . '_hapus'])) {
                HapusArtikel($data[$gambar . '_hapus']);
                $data[$gambar] = '';
                unset($data[$gambar . '_hapus']);
            }
        }

        // Upload dokumen lampiran
        // TODO: Sederhanakan cara unggah ini
        $lokasi_file = $_FILES['dokumen']['tmp_name'];
        $tipe_file   = TipeFile($_FILES['dokumen']);
        $nama_file   = $_FILES['dokumen']['name'];
        $ext         = get_extension($nama_file);
        $nama_file   = time() . random_int(10000, 999999) . $ext;

        if ($nama_file && ! empty($lokasi_file)) {
            if (! in_array($tipe_file, unserialize(MIME_TYPE_DOKUMEN)) || ! in_array($ext, unserialize(EXT_DOKUMEN))) {
                unset($data['link_dokumen']);
                $_SESSION['error_msg'] .= ' -> Jenis file salah: ' . $tipe_file;
                $_SESSION['success'] = -1;
            } else {
                $data['dokumen'] = $nama_file;
                if ($data['link_dokumen'] == '') {
                    $data['link_dokumen'] = $data['judul'];
                }
                UploadDocument2($nama_file);
            }
        }

        foreach ($list_gambar as $gambar) {
            unset($data['old_' . $gambar]);
        }
        if ($data['tgl_upload'] == '') {
            $data['tgl_upload'] = date('Y-m-d H:i:s');
        } else {
            $tempTgl            = date_create_from_format('d-m-Y H:i:s', $data['tgl_upload']);
            $data['tgl_upload'] = $tempTgl->format('Y-m-d H:i:s');
        }
        if ($data['tgl_agenda'] == '') {
            unset($data['tgl_agenda']);
        } else {
            $tempTgl            = date_create_from_format('d-m-Y H:i:s', $data['tgl_agenda']);
            $data['tgl_agenda'] = $tempTgl->format('Y-m-d H:i:s');
        }

        $data['slug'] = unique_slug('artikel', $data['judul'], $id);

        $this->group_akses();

        if ($cat == AGENDA) {
            $outp = $this->update_agenda($id, $data);
        } else {
            $outp                    = $this->config_id()->where('a.id', $id)->update('artikel a', $data);
            $this->session->kategori = $cat;
        }

        if ($hapus_lampiran == 'true') {
            $this->config_id()->where('id', $id)->update('artikel', ['dokumen' => null, 'link_dokumen' => '']);
        }

        status_sukses($outp);
    }

    private function update_agenda($id_artikel, $data)
    {
        $agenda = $this->ambil_data_agenda($data);
        $id     = $data['id_agenda'];
        unset($data['id_agenda']);
        $outp = $this->config_id()->where('a.id', $id_artikel)->update('artikel a', $data);
        if ($outp) {
            if (empty($id)) {
                $agenda['id_artikel'] = $id_artikel;
                $this->agenda_model->insert($agenda);
            } else {
                $this->agenda_model->update($id, $agenda);
            }
        }

        $this->session->kategori = AGENDA;

        return $outp;
    }

    public function update_kategori($id, $id_kategori): void
    {
        $this->config_id()->where('id', $id)->update('artikel', ['id_kategori' => $id_kategori]);
    }

    public function delete($id = 0, $semua = false): void
    {
        if (! $semua) {
            $this->session->success = 1;
        }

        $this->group_akses();

        $list_gambar = $this->config_id()
            ->select('a.gambar, a.gambar1, a.gambar2, a.gambar3')
            ->from('artikel a')
            ->where('a.id', $id)
            ->get()
            ->row_array();

        if ($list_gambar) {
            foreach ($list_gambar as $gambar) {
                HapusArtikel($gambar);
            }
        }

        if (! in_array($this->session->grup, (new UserGrup())->getGrupSistem())) {
            $this->db->where('id_user', $this->session->user);
        }

        $this->config_id()->from('artikel')->where('id', $id)->delete();
        $outp = $this->db->affected_rows();

        status_sukses($outp, $gagal_saja = true); //Tampilkan Pesan
    }

    public function delete_all(): void
    {
        $this->session->success = 1;

        $id_cb = $this->input->post('id_cb');

        foreach ($id_cb as $id) {
            if ($this->boleh_ubah($id, $this->session->user)) {
                $this->delete($id, true);
            }
        }
    }

    // TODO: pindahkan dan gunakan web_kategori_model
    public function hapus($id = 0, $semua = false): void
    {
        if (! $semua) {
            $this->session->success = 1;
        }
        $outp = $this->config_id()->where('id', $id)->delete('kategori');

        status_sukses($outp, $gagal_saja = true); //Tampilkan Pesan
    }

    public function artikel_lock($id = 0, $val = 1): void
    {
        $this->group_akses();

        $outp = $this->config_id()->where('id', $id)->update('artikel a', ['a.enabled' => $val]);

        status_sukses($outp); //Tampilkan Pesan
    }

    public function komentar_lock($id = 0, $val = 1): void
    {
        $outp = $this->config_id()->where('id', $id)->update('artikel', ['boleh_komentar' => $val]);

        status_sukses($outp); //Tampilkan Pesan
    }

    public function get_artikel($id = 0)
    {
        $this->group_akses();

        $data = $this->config_id('a')
            ->select('a.*, g.*, g.id as id_agenda, u.nama AS owner')
            ->select('YEAR(tgl_upload) as thn, MONTH(tgl_upload) as bln, DAY(tgl_upload) as hri')
            ->from('artikel a')
            ->join('user u', 'a.id_user = u.id', 'LEFT')
            ->join('agenda g', 'g.id_artikel = a.id', 'LEFT')
            ->where('a.id', $id)
            ->get()
            ->row_array();

        // Jika artikel tdk ditemukan
        if (! $data) {
            return false;
        }

        $data['judul'] = e($data['judul']);

        // Digunakan untuk timepicker
        $tempTgl            = date_create_from_format('Y-m-d H:i:s', $data['tgl_upload']);
        $data['tgl_upload'] = $tempTgl->format('d-m-Y H:i:s');
        // Data artikel terkait agenda
        if (! empty($data['tgl_agenda'])) {
            $tempTgl            = date_create_from_format('Y-m-d H:i:s', $data['tgl_agenda']);
            $data['tgl_agenda'] = $tempTgl->format('d-m-Y H:i:s');
        } else {
            $data['tgl_agenda'] = date('d-m-Y H:i:s');
        }

        return $data;
    }

    public function get_headline()
    {
        $data = $this->config_id('a')
            ->select('a.*, u.nama AS owner')
            ->from('artikel a')
            ->join('user u', 'a.id_user = u.id', 'LEFT')
            ->where('headline', 1)
            ->order_by('tgl_upload', 'DESC')
            ->limit(1)
            ->get()
            ->row_array();

        if (empty($data)) {
            $data = null;
        } else {
            $id          = $data['id'];
            $panjang     = str_split($data['isi'], 300);
            $data['isi'] = '<label>' . $panjang[0] . "...</label><a href='" . site_url("artikel/{$id}") . "'>Baca Selengkapnya</a>";
        }

        return $data;
    }

    // TODO: pindahkan dan gunakan web_kategori_model
    public function insert_kategori(): void
    {
        $data['kategori']  = $_POST['kategori'];
        $data['tipe']      = '2';
        $data['config_id'] = $this->config_id;

        $outp = $this->db->insert('kategori', $data);

        status_sukses($outp); //Tampilkan Pesan
    }

    public function list_komentar($id = 0)
    {
        return $this->config_id()
            ->where('id_artikel', $id)
            ->order_by('tgl_upload', 'DESC')
            ->get('komentar')
            ->result_array();
    }

    public function headline($id = 0): void
    {
        $outp = $this->config_id()->update('artikel', ['headline' => 0]);
        $outp = $this->config_id()->where('id', $id)->update('artikel', ['headline' => 1]);

        status_sukses($outp); //Tampilkan Pesan
    }

    public function slide($id = 0): void
    {
        $data = $this->config_id()->get_where('artikel', ['id' => $id])->row_array();

        $slider = $data['slider'] == '1' ? 0 : 1;

        $outp = $this->config_id()->where('id', $id)->update('artikel', ['slider' => $slider]);

        status_sukses($outp); //Tampilkan Pesan
    }

    public function boleh_ubah($id, $user)
    {
        // Kontributor hanya boleh mengubah artikel yg ditulisnya sendiri
        $id_user = $this->config_id()->select('id_user')->where('id', $id)->get('artikel')->row()->id_user;

        return $user == $id_user || $this->session->grup != 4;
    }

    public function reset($cat): void
    {
        // Normalkan kembali hit artikel kategori 999 (yg ditampilkan di menu) akibat robot (crawler)
        $persen    = $this->input->post('hit');
        $list_menu = $this->config_id()
            ->distinct()
            ->select('link')
            ->like('link', 'artikel/')
            ->where('enabled', 1)
            ->get('menu')
            ->result_array();

        foreach ($list_menu as $list) {
            $id      = str_replace('artikel/', '', $list['link']);
            $artikel = $this->config_id()->where('id', $id)->get('artikel')->row_array();
            $hit     = $artikel['hit'] * ($persen / 100);
            if ($artikel) {
                $this->config_id()->where('id', $id)->update('artikel', ['hit' => $hit]);
            }
        }
    }

    public function list_artikel_statis()
    {
        // '999' adalah id_kategori untuk artikel statis
        $this->group_akses();

        return $this->config_id()
            ->select('a.id, judul')
            ->where('a.tipe', 'statis')
            ->get('artikel a')
            ->result_array();
    }

    private function group_akses(): void
    {
        // Kontributor dan lainnya (group yg dibuat sendiri) hanya dapat melihat artikel yg dibuatnya sendiri
        if (! in_array($this->session->grup, (new UserGrup())->getGrupSistem())) {
            $this->db->where('a.id_user', $this->session->user);
        }
    }
}
