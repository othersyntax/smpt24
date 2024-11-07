@extends('layout.main')
@section('custom-css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('/template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('/template/plugins/toastr/toastr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/template/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/template/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('breadcrumb')
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sewaan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Premis</a></li>
                <li class="breadcrumb-item active">Sewaan</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/tanah/senarai">
                        @csrf
                        <div class="card card-purple card-outline">
                            <div class="card-body">
                                <div class="row">
                                    <div class="row invoice-info">
                                        <div class="col-sm-3 invoice-col">
                                            <p class="lead">PENYEWA</p>
                                            <address>
                                                <strong>{{ Str::upper($sewaan->syarikat->sya_desc) }}</strong><br>
                                                <i>
                                                {{ $sewaan->syarikat->sya_alamat ? $sewaan->syarikat->sya_alamat : 'Tiada Rekod' }}<br>
                                                {{ $sewaan->syarikat->negeri->neg_nama_negeri }}<br>
                                                </i>
                                            </address>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-5 invoice-col">
                                            <p class="lead">MAKLUMAT SEWAAN</p>
                                            <dl class="row">
                                                <dt class="col-sm-4">No Perjanjian</dt>
                                                <dd class="col-sm-8">{{ $sewaan->peny_no_perjanjian }}</dd>
                                                <dt class="col-sm-4">Tapak</dt>
                                                <dd class="col-sm-8">{{ $sewaan->fasiliti->fas_desc }}</dd>
                                                <dt class="col-sm-4">Keluasan</dt>
                                                <dd class="col-sm-8">{{ $sewaan->fasiliti->fas_size }} {{ $sewaan->fasiliti->fas_size_unit }}</dd>
                                                <dt class="col-sm-4">Tujuan</dt>
                                                <dd class="col-sm-8">{{ $sewaan->peny_tujuan }}</dd>
                                                <dt class="col-sm-4">Amaun Sewaan</dt>
                                                <dd class="col-sm-8">RM @duit($sewaan->peny_kadar_sewa)</dd>
                                                <dt class="col-sm-4">Tempoh Kontrak</dt>
                                                <dd class="col-sm-8">@tarikh($sewaan->peny_mula) - @tarikh($sewaan->peny_tamat)</dd>
                                            </dl>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-4 invoice-col">
                                            <p class="lead">MAKLUMAT PENYELENGGARAAN</p>
                                            <dl class="row">
                                                <dt class="col-sm-4">Cipta Oleh</dt>
                                                <dd class="col-sm-8">{{ aliasPengguna($sewaan->peny_created_by) }}</dd>
                                                <dt class="col-sm-4">Cipta Pada</dt>
                                                <dd class="col-sm-8">@tarikhmasa($sewaan->peny_created_at)</dd>
                                                <dt class="col-sm-4">Ubah Oleh</dt>
                                                <dd class="col-sm-8">{{ aliasPengguna($sewaan->peny_updated_by) }}</dd>
                                                <dt class="col-sm-4">Ubah Pada</dt>
                                                <dd class="col-sm-8">@tarikhmasa($sewaan->peny_updated_at)</dd>
                                            </dl>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <div class="col-12">
                                        <p class="lead">RINGKASAN BAYARAN</p>
                                        <table class="table">
                                            <tr class="text-center">
                                                <td>JAN</td>
                                                <td>FEB</td>
                                                <td>MAC</td>
                                                <td>APR</td>
                                                <td>MEI</td>
                                                <td>JUN</td>
                                                <td>JUL</td>
                                                <td>OGO</td>
                                                <td>SEP</td>
                                                <td>OKT</td>
                                                <td>NOV</td>
                                                <td>DIS</td>
                                            </tr>
                                            <tr class="text-center">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    @php $flag = 0; @endphp
                                                    @foreach ($bayaran as $bayar)
                                                        @if ($bayar->byr_bulan == $i)
                                                            <td><i class="fa fa-circle text-green"></i></td>
                                                            @php $flag = 1; @endphp
                                                            @break
                                                        @endif
                                                    @endforeach
                                                     @if ($flag == 0)
                                                        <td><i class="fa fa-circle text-red"></i></td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-12">
                            <p class="lead">BAYARAN</p>
                            <div class="row no-print mb-2">
                                <div class="col-12">
                                    <a href="/tanah/tambah" class="btn btn-success float-right ml-1" id="add"><i class="fas fa-plus"></i> Tambah</a>
                                </div>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <th class="text-center">Bil</th>
                                    <th>Tarikh</th>
                                    <th>No Resit</th>
                                    <th class="text-right">Amaun (RM)</th>
                                    <th class="text-right">Tunggakan (RM)</th>
                                    <th class="text-center">Tindakan</th>
                                </thead>
                                <tbody>
                                    @php $jumlah=0; @endphp
                                    @for ($i = 1; $i <= 12; $i++)
                                        @php $flag = 0; @endphp
                                        @foreach ($bayaran as $bayar)
                                            @if ($bayar->byr_bulan == $i)
                                                <tr>
                                                    <td class="text-center">{{ $i }}</td>
                                                    <td>@tarikh($bayar->byr_tarikh)</td>
                                                    <td>{{ $bayar->byr_no_resit }}</td>
                                                    <td class="text-right">@duit($bayar->byr_amaun)</td>
                                                    <td class="text-right">0.00</td>
                                                    <td class="text-center">
                                                        <a href="#" title="Kemaskini">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @php
                                                $jumlah +=$bayar->byr_amaun;
                                                $flag = 1;
                                                @endphp
                                                @break
                                            @endif
                                        @endforeach
                                        @if ($flag == 0)
                                            <tr>
                                                <td class="text-center">{{ $i }}</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td class="text-right">0.00</td>
                                                <td class="text-right">0.00</td>
                                                <td class="text-center">
                                                </td>
                                            </tr>
                                        @endif
                                    @endfor
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right">Jumlah (RM)</td>
                                        <td class="text-right"><b>@duit($jumlah)</b></td>
                                        <td class="text-right"><b>0.00</b></td>
                                        <td class="text-right"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_sewaan">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" action="/premis/sewa/bayar" method="post" id="insert_form">
                    @csrf
                    <input type="hidden" name="byr_penyewaan_id" id="byr_penyewaan_id" value="{{ $sewaan->penyewaan_id }}">
                    <div class="modal-header">
                        <h4 class="modal-title">Maklumat Bayaran Sewa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="user_nokp" class="form-label">No Resit</label>
                                    {{ Form::text('byr_no_resit',null,['class'=>'form-control', 'id'=>'byr_no_resit']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tarikh Bayaran</label>
                                    <div class="input-group date" id="byr_tarikh" data-target-input="nearest">
                                        <input name="byr_tarikh" type="text" class="form-control datetimepicker-input" data-target="#byr_tarikh" value="{{ date('d/m/Y') }}" />
                                        <div class="input-group-append" data-target="#byr_tarikh" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Amaun (RM)</label>
                                    {{ Form::text('byr_amaun', null, ['class'=>'form-control', 'id'=>'byr_amaun']) }}
                                </div>
                            </div>
                        </div>
			<div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputFile">Muat Naik Resit Bayaran</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="doc_location" class="custom-file-input" id="doc_location">
                                            <label class="custom-file-label" for="customFile">Pilih Dokumen</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" id="insert">Simpan</button>
                    </div>
                </form>
            </div>
        <!-- /.modal-content -->
        </div>
    </div>

@endsection
@section('js')
<script src="{{ asset('/template/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('/template/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/template/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('/template/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<script>
    $(document).ready(function () {

        //Date picker
        $('#byr_tarikh').datetimepicker({
            format: 'L',
            format: 'DD/MM/YYYY'
        });

        $('#add').click(function(e){
            e.preventDefault();
            $('#insert').html("Tambah");
            $('#insert_form')[0].reset();
            $('#add_sewaan').modal('show');
        });
    });

</script>
@endsection
