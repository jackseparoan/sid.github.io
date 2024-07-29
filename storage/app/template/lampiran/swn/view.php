<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<style type="text/css">
    <?php include FCPATH . '/assets/css/lampiran-surat.css'; ?>
</style>

<page orientation="portrait" format="210x330" style="font-size: 10pt">

    <!-- Judul Lampiran -->
    <table align="right">
        <tr>
            <td colspan="10">Lampiran IX</td>
        </tr>
        <tr>
            <td colspan="10">Kepdirjen Bimas Islam Nomor 473 Tahun 2020</td>
        </tr>
        <tr>
            <td colspan="10">Tentang</td>
        </tr>
        <tr>
            <td colspan="10">Petunjuk Teknis Pelaksanaan Pencatatan Nikah</td>
        </tr>
        <tr>
            <?php for ($i = 0; $i < 48; $i++) : ?>
                <td>&nbsp;</td>
            <?php endfor; ?>
        </tr>
    </table>

    <!-- Wilayah -->
    <table id="kop" class="disdukcapil">
        <col span="48" style="width: 2.0833%;">
        <tr>
            <td colspan="48">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="17">KANTOR DESA/KELURAHAN</td>
            <td>: </td>
            <td colspan="30">[NAma_desa]</td>
        </tr>
        <tr>
            <td colspan="17">KECAMATAN</td>
            <td>: </td>
            <td colspan="30">[NAma_kecamatan]</td>
        </tr>
        <tr>
            <td colspan="17">KABUPATEN/KOTA</td>
            <td>:</td>
            <td colspan="30">[NAma_kabupaten]</td>
        </tr>
        <tr>
            <?php for ($i = 0; $i < 48; $i++) : ?>
                <td>&nbsp;</td>
            <?php endfor; ?>
        </tr>
    </table>

    <br>
    <p class="title">SURAT KETERANGAN WALI NIKAH</p>
    <table align="center">
        <tr>
            <td><span>Nomor : [FOrmat_nomor_surat]</span></td>
        </tr>
    </table>


    <p>Yang bertanda tangan dibawah ini, [SeButan_kepala_desa] [SeButan_desa] [NAma_desa], Kecamatan [NAma_kecamatan], Kabupaten [NAma_kabupaten], menerangkan dengan sesungguhnya bahwa :</p>
    <table id="kop" class="disdukcapil">
        <col span="48" style="width: 2.0833%;">
        <tr>
            <td colspan="48">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="20">Nama lengkap dan alias</td>
            <td>: </td>
            <td colspan="27"><strong>[NAma_dwN]</strong></td>
        </tr>
        <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="20">Bin</td>
            <td>: </td>
            <td colspan="27">[Form_bin_wali_nikaH]</td>
        </tr>
        <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="20">Nomor Induk Kependudukan</td>
            <td>: </td>
            <td colspan="27">[NiK_dwN]</td>
        </tr>
        <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="20">Tempat dan Tanggal Lahir</td>
            <td>: </td>
            <td colspan="27">[TtL_dwN]</td>
        </tr>
        <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="20">Agama</td>
            <td>: </td>
            <td colspan="27">[AgAma_dwN]</td>
        </tr>
        <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="20">Pekerjaan</td>
            <td>: </td>
            <td colspan="27">[PeKerjaan_dwN]</td>
        </tr>
        <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="20">Tempat tinggal terakhir </td>
            <td>: </td>
            <td colspan="27">[AlAmat_dwN]</td>
        </tr>
        <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="20">Keperluan </td>
            <td>: </td>
            <td colspan="27">Menjadi Wali Nikah</td>
        </tr>
    </table>

    <table align="center">
        <col span="48" style="width: 2.0833%;">
        <tr>
            <td colspan="48">&nbsp;</td>
        </tr>
        <tr class="">
            <td colspan="1">&nbsp;</td>
            <td colspan="10">Pernikahan</td>
            <td>: </td>
            <td colspan="27"><strong>[NAma_dcpw]</strong></td>
        </tr>
        <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="10">Dengan</td>
            <td>: </td>
            <td colspan="27"><strong>[NAma]</strong></td>
        </tr>
        <tr>
            <td colspan="1">&nbsp;</td>
            <td colspan="10">Sebagai</td>
            <td>: </td>
            <td colspan="27">[Form_hubungan_dengan_walI]</td>
        </tr>
    </table>

    <p>Demikianlah, surat keterangan ini dibuat dengan mengingat sumpah jabatan dan untuk dipergunakan seperlunya.</p>

    <!-- Penandatangan -->
    <br><br><br>
    <table class="disdukcapil" style="margin-top: -5px; border: 0px;">
        <col span="48" style="width: 2.0833%;">
        <tr>
            <td colspan="32">&nbsp;</td>
            <td colspan="20" class="tengah">[NAma_desa], [TgL_surat]</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="37">&nbsp;</td>
            <td colspan="10" class="tengah">[Atas_namA]</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="10">[qr_code]</td>
            <td colspan="37" class="tengah"><br><br><br><br></td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="37">&nbsp;</td>
            <td colspan="10" class="tengah"><strong>[NAma_pamonG]</strong></td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
    <!-- Akhir  -->
</page>