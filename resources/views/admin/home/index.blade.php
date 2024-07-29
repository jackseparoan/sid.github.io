@extends('admin.layouts.index')

@push('css')
    <style>
        .catatan-scroll {
            height: 400px;
            overflow-y: scroll;
        }

        @media (max-width: 576px) {
            .komunikasi-opendk {
                display: none !important;
            }
        }
    </style>
@endpush

@section('title')
    <h1>
        Tentang <?= config_item('nama_aplikasi') ?>
    </h1>
@endsection

@section('breadcrumb')
    <li class="active">Tentang <?= config_item('nama_aplikasi') ?></li>
@endsection

@section('content')
    @include('admin.layouts.components.notifikasi')

    @include('admin.home.saas')

    @include('admin.home.premium')

    @include('admin.home.rilis')

    @include('admin.home.bantuan')

    <div class="row">
        @if (can('b', 'wilayah-administratif'))
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ $dusun }}</h3>
                        <p>{{ SebutanDesa('Wilayah [Desa]') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-location"></i>
                    </div>
                    <a href="{{ ci_route('wilayah') }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endif

        @if (can('b', 'penduduk'))
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $penduduk }}</h3>
                        <p>Penduduk</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="{{ ci_route('penduduk.clear') }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endif

        @if (can('b', 'keluarga'))
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $keluarga }}</h3>
                        <p>Keluarga</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-people"></i>
                    </div>
                    <a href="{{ ci_route('keluarga.clear') }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endif

        @if (can('b', 'arsip-layanan'))
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>{{ $surat }}</h3>
                        <p>Surat Tercetak</p>
                    </div>
                    <div class="icon">
                        <i class="ion-ios-paper"></i>
                    </div>
                    <a href="{{ ci_route('keluar') }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endif

        @if (can('b', 'kelompok'))
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $kelompok }}</h3>
                        <p>Kelompok</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-people"></i>
                    </div>
                    <a href="{{ ci_route('kelompok.clear') }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endif

        @if (can('b', 'rumah-tangga'))
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-gray">
                    <div class="inner">
                        <h3>{{ $rtm }}</h3>
                        <p>Rumah Tangga</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-home"></i>
                    </div>
                    <a href="{{ ci_route('rtm.clear') }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endif

        @if (can('b', 'bantuan'))
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $bantuan['jumlah'] }}</h3>
                        <p>{{ $bantuan['nama'] }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pie"></i>
                    </div>
                    <div class="small-box-footer">
                        <a href="#" class="inner text-white rilis_pengaturan" data-remote="false" data-toggle="modal" data-target="#pengaturan-bantuan"><i class="fa fa-gear"></i></a>
                        @if (can('b', 'statistik'))
                            <a href="{{ ci_route($bantuan['link_detail']) }}" class="inner text-white">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                        @else
                            &nbsp;
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if (can('b', 'pendaftar-layanan-mandiri'))
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="small-box" style="background-color: #39CCCC;">
                    <div class="inner">
                        <h3>{{ $pendaftaran }}</h3>
                        <p>Verifikasi Layanan Mandiri</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="{{ ci_route('mandiri') }}" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endif
    </div>
@endsection
