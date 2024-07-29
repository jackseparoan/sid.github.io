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

use App\Models\Polygon as PolygonModel;
use Illuminate\View\View;

defined('BASEPATH') || exit('No direct script access allowed');

class Polygon extends Admin_Controller
{
    public const POLYGON     = 0;
    public const SUB_POLYGON = 2;

    private $tip    = 5;
    private $parent = 1;
    private $tipe   = 0;

    public function __construct()
    {
        parent::__construct();
        $this->modul_ini     = 'pemetaan';
        $this->sub_modul_ini = 'pengaturan-peta';
    }

    public function index()
    {
        $data = ['tip' => $this->tip, 'tipe' => $this->input->get('tipe') ?? $this->tipe,  'parent' => $this->input->get('parent') ?? $this->parent, 'parent_jenis' => ''];
        if ($data['tipe'] == '2') {
            $data['parent_jenis'] = PolygonModel::find($data['parent'])->nama ?? '';
        }
        $data['status'] = [PolygonModel::LOCK => 'Aktif', PolygonModel::UNLOCK => 'Non Aktif'];

        view('admin.peta.polygon.index', $data);
    }

    public function datatables()
    {
        if ($this->input->is_ajax_request()) {
            $parent = $this->input->get('parent') ?? $this->parent;

            $tipe = $this->input->get('tipe') ?? $this->tipe;

            return datatables()->of(PolygonModel::whereParrent($parent)->whereTipe($tipe))
                ->addColumn('ceklist', static function ($row) {
                    if (can('h')) {
                        return '<input type="checkbox" name="id_cb[]" value="' . $row->id . '"/>';
                    }
                })
                ->addIndexColumn()
                ->addColumn('aksi', static function ($row): string {
                    $aksi = '';
                    if (can('u')) {
                        $aksi .= '<a href="' . ci_route('polygon.form', implode('/', [$row->parrent, $row->id])) . '" class="btn btn-warning btn-sm"  title="Ubah"><i class="fa fa-edit"></i></a> ';
                    }

                    if ($row->parrent_id == self::POLYGON) {
                        $aksi .= '<a href="' . ci_route('polygon.index') . '?parent=' . $row->id . '&tipe=2' . '" class="btn bg-purple btn-sm"  title="Rincian ' . $row->nama . '" data-title="Rincian ' . $row->nama . '"><i class="fa fa-bars"></i></a> ';
                    }

                    if (can('u')) {
                        if ($row->parrent_id == self::POLYGON) {
                            $aksi .= '<a href="' . ci_route('polygon.ajax_add_sub_polygon', $row->id) . '" class="btn bg-olive btn-sm"  title="Tambah Kategori  ' . $row->nama . '" data-remote="false" data-toggle="modal" data-target="#modalBox" data-title="Tambah Kategori ' . $row->nama . '"><i class="fa fa-plus"></i></a> ';
                        }

                        if ($row->enabled == PolygonModel::UNLOCK) {
                            $aksi .= '<a href="' . ci_route('polygon.polygon_lock', implode('/', [$row->parrent, $row->id])) . '" class="btn bg-navy btn-sm" title="Aktifkan"><i class="fa fa-lock">&nbsp;</i></a> ';
                        }

                        if ($row->enabled == PolygonModel::LOCK) {
                            $aksi .= '<a href="' . ci_route('polygon.polygon_unlock', implode('/', [$row->parrent, $row->id])) . '" class="btn bg-navy btn-sm" title="Non Aktifkan"><i class="fa fa-unlock"></i></a> ';
                        }
                    }

                    if (can('h')) {
                        $aksi .= '<a href="#" data-href="' . ci_route('polygon.delete', implode('/', [$row->parrent, $row->id])) . '" class="btn bg-maroon btn-sm"  title="Hapus" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a> ';
                    }

                    return $aksi;
                })
                ->editColumn('enabled', static fn ($row) => $row->enabled == '1' ? 'Ya' : 'Tidak')
                ->editColumn('color', static fn ($row) => '<div style="background-color:' . $row->color . '">&nbsp;<div>')
                ->rawColumns(['aksi', 'ceklist', 'color'])
                ->make();
        }

        return show_404();
    }

    public function form($parent = 1, $id = ''): View
    {
        $this->redirect_hak_akses('u');
        $this->parent = $parent;

        if ($id) {
            $data['aksi']        = 'Ubah';
            $data['polygon']     = PolygonModel::find($id)->toArray();
            $data['form_action'] = ci_route('polygon.update', implode('/', [$this->parent, $id]));
        } else {
            $data['aksi']        = 'Tambah';
            $data['polygon']     = null;
            $data['form_action'] = ci_route('polygon.insert', $this->parent);
        }

        $data['tip'] = $this->tip;

        return view('admin.peta.polygon.form', $data);
    }

    public function ajax_add_sub_polygon(int $parent = 0)
    {
        $data['form_action'] = ci_route("polygon.insert.{$parent}");

        return view('admin.peta.polygon.ajax_form', $data);
    }

    public function insert(int $parent): void
    {
        $this->redirect_hak_akses('u');
        $dataInsert            = $this->validasi($this->input->post());
        $dataInsert['parrent'] = $parent;
        $tipe                  = $this->tipe($parent);
        $dataInsert['tipe']    = $tipe;

        try {
            PolygonModel::create($dataInsert);
            redirect_with('success', 'Tipe area berhasil disimpan', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            redirect_with('error', 'Tipe area gagal disimpan', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);
        }
    }

    public function update($parent, $id): void
    {
        $this->redirect_hak_akses('u');
        $dataUpdate            = $this->validasi($this->input->post());
        $dataUpdate['parrent'] = $parent;
        $tipe                  = $this->tipe($parent);
        $dataUpdate['tipe']    = $tipe;

        try {
            PolygonModel::where(['id' => $id, 'parrent' => $parent])->update($dataUpdate);
            redirect_with('success', 'Tipe area berhasil disimpan', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            redirect_with('error', 'Tipe area gagal disimpan', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);
        }
    }

    public function delete($parent, $id): void
    {
        $tipe = $this->tipe($parent);
        $this->redirect_hak_akses('h', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);

        try {
            PolygonModel::whereId($id)->delete();
            redirect_with('success', 'Tipe area berhasil dihapus', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            redirect_with('error', 'Tipe area gagal dihapus', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);
        }
    }

    public function delete_all($parent): void
    {
        $tipe = $this->tipe($parent);
        $this->redirect_hak_akses('h', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);

        try {
            PolygonModel::whereIn('id', $this->input->post('id_cb'))->delete();
            redirect_with('success', 'Tipe area berhasil dihapus', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            redirect_with('error', 'Tipe area gagal dihapus', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);
        }
    }

    public function polygon_lock($parent, $id): void
    {
        $this->redirect_hak_akses('u');
        $tipe = $this->tipe($parent);

        try {
            PolygonModel::where(['id' => $id])->update(['enabled' => PolygonModel::LOCK]);
            redirect_with('success', 'Tipe area berhasil dinonaktifkan', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            redirect_with('error', 'Tipe area gagal dinonaktifkan', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);
        }
    }

    public function polygon_unlock($parent, $id): void
    {
        $this->redirect_hak_akses('u');
        $tipe = $this->tipe($parent);

        try {
            PolygonModel::where(['id' => $id])->update(['enabled' => PolygonModel::UNLOCK]);
            redirect_with('success', 'Tipe area berhasil diaktifkan', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            redirect_with('error', 'Tipe area gagal diaktifkan', ci_route('polygon.index') . '?parent=' . $parent . '&tipe=' . $tipe);
        }
    }

    private function validasi($post)
    {
        $data['nama']  = nomor_surat_keputusan($post['nama']);
        $data['color'] = warna($post['color']);

        return $data;
    }

    private function tipe($parent)
    {
        return ($parent == 1) ? self::POLYGON : (PolygonModel::find($parent)->tipe == 0 ? self::SUB_POLYGON : self::SUB_POLYGON);
    }
}
