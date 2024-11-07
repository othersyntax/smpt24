@extends('layout.main')
@section('breadcrumb')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Penyewaan Premis</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Premis</a></li>
                <li class="breadcrumb-item active">Papar</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <div class="row">
    <div class="col-12">
        <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h4 class="text-primary">
                        <i class="fas fa-globe"></i> {{ $tanah->tanah_desc }}
                        <small class="float-right">Tarikh : {{ date('d-m-Y') }}</small>
                    </h4>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                <p class="lead">LOKASI</p>
                <address>
                    <strong>{{ Str::upper($tanah->tanah_desc) }}</strong><br>
                    <i>
                    {{ $tanah->negeri->daerah->bandar->ban_nama_bandar }}<br>
                    {{ $tanah->negeri->neg_nama_negeri }}<br>
                    </i>
                </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <p class="lead">MAKLUMAT TANAH</p>
                    <dl class="row">
                        <dt class="col-sm-4">No Lot</dt>
                        <dd class="col-sm-8">{{ $tanah->tanah_no_lot? $tanah->tanah_no_lot: 'Tiada rekod' }}</dd>
                        <dt class="col-sm-4">No Hak Milik</dt>
                        <dd class="col-sm-8">{{ $tanah->tanah_no_hakmilik ? $tanah->tanah_no_hakmilik: 'Tiada rekod' }}</dd>
                        <dt class="col-sm-4">No JKPTG</dt>
                        <dd class="col-sm-8">{{ $tanah->tanah_no_jkptg ? $tanah->tanah_no_jkptg: 'Tiada rekod' }}</dd>
                        <dt class="col-sm-4">Keluasan</dt>
                        <dd class="col-sm-8">{{ $tanah->tanah_luas }} ekar</dd>
                        <dt class="col-sm-4">Status Tanah</dt>
                        <dd class="col-sm-8">{{ $tanah->statusTanahDB->statt_desc }}</dd>
                    </dl>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <p class="lead">MAKLUMAT PENYELENGGARAAN</p>
                    <dl class="row">
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">{{ statusAktif($tanah->tanah_status) }}</dd>
                        <dt class="col-sm-4">Cipta Oleh</dt>
                        <dd class="col-sm-8">{{ $tanah->tanah_crtby ? aliasPengguna($tanah->tanah_crtby) : 'Tiada Rekod' }}</dd>
                        <dt class="col-sm-4">Cipta Pada</dt>
                        <dd class="col-sm-8">{{ date('d-m-Y H:i', strtotime($tanah->tanah_created)) }}</dd>
                        <dt class="col-sm-4">Ubah Oleh</dt>
                        <dd class="col-sm-8">{{ $tanah->tanah_updby ? aliasPengguna($tanah->tanah_updby) : 'Tiada Rekod' }}</dd>
                        <dt class="col-sm-4">Ubah Pada</dt>
                        <dd class="col-sm-8">{{ date('d-m-Y H:i', strtotime($tanah->tanah_upddate)) }}</dd>
                    </dl>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <thead>
                            <th class="text-center">Bil</th>
                            <th>No Perjanjian</th>
                            <th>Penyewa</th>
                            <th>Tapak</th>
                            <th class="text-right">Kadar (RM)</th>
                            <th class="text-center">Tindakan</th>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $jumlah=0;
                            @endphp
                            @foreach ($sewaan as $sewa)
                                @php $jumlah += $sewa->peny_kadar_sewa; @endphp
                            <tr>
                                <td width="5%" class="text-center">{{$no++}}</td>
                                <td width="25%">{{ $sewa->peny_no_perjanjian ? $sewa->peny_no_perjanjian : 'Tiada Rekod' }}</td>
                                <td width="25%">{{ $sewa->sya_desc }}</td>
                                <td width="25%">{{ $sewa->fas_desc }}<br>( @tarikh($sewa->peny_mula) - @tarikh($sewa->peny_tamat) )</td>
                                <td width="10%"class="text-right">@duit($sewa->peny_kadar_sewa)</td>
                                <td width="10%"class="text-center">
                                    <a href="/premis/sewa/{{ $sewa->penyewaan_id }}" title="Papar Bayaran">
                                        <i class="fas fa-search text-purple"></i>
                                    </a>
                                    {{-- <a href="#" title="Kemaskini tanah">
                                        <i class="fas fa-edit"></i>
                                    </a> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">Jumlah Sebulan (RM)</td>
                                <td class="text-right"><b>@duit($jumlah)</b></td>
                                <td class="text-right"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
    </div><!-- /.row -->
@endsection
@section('js')

@endsection
