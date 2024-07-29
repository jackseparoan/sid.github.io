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

namespace App\Models;

use App\Casts\Path;
use App\Casts\Zoom;
use App\Enums\JenisKelaminEnum;
use App\Enums\SHDKEnum;
use App\Traits\ConfigId;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\EloquentSortable\SortableTrait;

defined('BASEPATH') || exit('No direct script access allowed');

class Wilayah extends BaseModel
{
    use ConfigId;
    use SortableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tweb_wil_clusterdesa';

    /**
     * The timestamps for the model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The guarded with the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The casts with the model.
     *
     * @var array
     */
    protected $casts = [
        'path' => Path::class,
        'zoom' => Zoom::class,
    ];

    public $sortable = [
        'order_column_name'  => 'urut',
        'sort_when_creating' => false,
    ];

    /**
     * Scope query untuk dusun
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeDusun($query)
    {
        return $query->where('rt', '=', '0')->where('rw', '=', '0');
    }

    /**
     * Scope query untuk rw.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeRw($query)
    {
        return $query->where('rt', '=', '0')->where('rw', '!=', '0');
    }

    /**
     * Scope query untuk rt
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeRt($query)
    {
        return $query->where('rt', '!=', '0');
    }

    /**
     * Define a one-to-many relationship.
     */
    public function kepala(): HasOne
    {
        return $this->hasOne(Penduduk::class, 'id', 'id_kepala')->select('nik', 'nama', 'id');
    }

    /**
     * Get all of the rw for the Wilayah
     */
    public function rws(): HasMany
    {
        return $this->hasMany(Wilayah::class, 'dusun', 'dusun')->where('rw', '!=', '-')->where('rt', '=', '-');
    }

    public function rts(): HasMany
    {
        return $this->hasMany(Wilayah::class, 'dusun', 'dusun')->where('rt', '!=', '0')->where('rt', '!=', '-');
    }

    public function pendudukPria(): HasManyThrough
    {
        return $this->hasManyThrough(PendudukHidup::class, Wilayah::class, 'dusun', 'id_cluster', 'dusun')->where('sex', JenisKelaminEnum::LAKI_LAKI);
    }

    public function pendudukWanita(): HasManyThrough
    {
        return $this->hasManyThrough(PendudukHidup::class, Wilayah::class, 'dusun', 'id_cluster', 'dusun')->where('sex', JenisKelaminEnum::PEREMPUAN);
    }

    public function keluargaAktif(): HasManyThrough
    {
        return $this->hasManyThrough(PendudukHidup::class, Wilayah::class, 'dusun', 'id_cluster', 'dusun')
            ->where('kk_level', SHDKEnum::KEPALA_KELUARGA)
            ->join('keluarga_aktif', 'keluarga_aktif.nik_kepala', '=', 'penduduk_hidup.id');
    }

    public static function updateUrutan(): void
    {
        $all  = Wilayah::dusun()->with(['rws' => static fn ($q) => $q->with('rts')])->orderBy('urut')->get();
        $urut = 1;

        foreach ($all as $dusun) {
            $dusun->update(['urut' => $urut, 'urut_cetak' => $urut++]);

            foreach ($dusun->rws as $rw) {
                $rw->update(['urut' => $urut, 'urut_cetak' => $urut++]);

                foreach ($rw->rts as $rt) {
                    $rt->update(['urut' => $urut, 'urut_cetak' => $urut++]);
                }
            }
        }
    }

    public function isDusun()
    {
        return $this->attributes['rt'] == '0' && $this->attributes['rw'] == '0';
    }

    public function isRw()
    {
        return $this->attributes['rt'] == '0' && $this->attributes['rw'] != '0';
    }

    public function isRt()
    {
        return $this->attributes['rt'] != '0';
    }
}
