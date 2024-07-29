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

use App\Traits\ConfigId;
use Illuminate\Support\Str;

defined('BASEPATH') || exit('No direct script access allowed');

class Pembangunan extends BaseModel
{
    use ConfigId;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pembangunan';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'id_lokasi',
        'sumber_dana',
        'judul',
        'slug',
        'keterangan',
        'lokasi',
        'lat',
        'lng',
        'volume',
        'tahun_anggaran',
        'pelaksana_kegiatan',
        'status',
        'created_at',
        'updated_at',
        'foto',
        'anggaran',
        'perubahan_anggaran',
        'sumber_biaya_pemerintah',
        'sumber_biaya_provinsi',
        'sumber_biaya_kab_kota',
        'sumber_biaya_swadaya',
        'sumber_biaya_jumlah',
        'manfaat',
    ];

    public function pembangunanDokumentasi()
    {
        return $this->hasMany(PembangunanDokumentasi::class, 'id_pembangunan');
    }

    public function wilayah()
    {
        return $this->hasOne(Wilayah::class, 'id', 'id_lokasi');
    }

    /**
     * Get the lokasi.
     *
     * @return string
     */
    public function getlokasiPembAttribute()
    {
        if ($this->lokasi == null) {
            return 'Dusun ' . $this->wilayah->dusun . (($this->wilayah->rw != 0) ? " - Rw {$this->wilayah->rw}" : '') . (($this->wilayah->rt != 0) ? "/RT {$this->wilayah->rw}" : '');
        }

        return $this->lokasi;
    }

    public static function activePembangunanMap()
    {
        return self::with(['wilayah'])->get()->map(static function ($item) {
            $item->alamat = '=== Lokasi Tidak Ditemukan ===';
            if ($item->wilayah) {
                $alamat = $item->wilayah->rt != '0' ? 'RT ' . $item->wilayah->rt . '/' : '';
                $alamat .= $item->wilayah->rw != '0' ? 'RW ' . $item->wilayah->rw . '-' : '';
                $alamat .= $item->wilayah->dusun ?? '';

                $item->alamat = $alamat;
            }
            $item->anggaran = (string) ($item->anggaran);

            return $item;
        })->toArray();
    }

    public function getMaxPersentaseAttribute()
    {
        if (count($this->pembangunanDokumentasi) <= 0) {
            return 'belum ada progres';
        }

        $max = $this->pembangunanDokumentasi->max('persentase') + 0;

        if (Str::endsWith($max, '%') == false) {
            $max .= '%';
        }

        return $max;
    }

    public function scopeStatus($query, $value = 1)
    {
        return $query->where('status', $value);
    }

    public static function boot(): void
    {
        parent::boot();

        static::updating(static function ($model): void {
            static::deleteFile($model, 'foto');
        });

        static::deleting(static function ($model): void {
            static::deleteFile($model, 'foto', true);
        });
    }

    public static function deleteFile($model, ?string $file, $deleting = false): void
    {
        if ($model->isDirty($file) || $deleting) {
            $gambar = LOKASI_GALERI . $model->getOriginal($file);
            if (file_exists($gambar)) {
                unlink($gambar);
            }
        }
    }
}
