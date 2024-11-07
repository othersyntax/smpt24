@extends('layout.main')
@section('custom-css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('/template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('/template/plugins/toastr/toastr.min.css') }}">
@endsection
@section('breadcrumb')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Maklumat Kontrak</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Kontrak</a></li>
                <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('content')
<form action="/premis/kontrak/simpan" id="insert_form" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card card-purple">
                <div class="card-header">
                    <h3 class="card-title">Maklumat Kotrak</h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Keterangan">Tujuan Kontrak</label>
                                {{ Form::text('peny_tujuan', null,['class'=>'form-control', 'id'=>'peny_tujuan', 'placeholder' => 'Nama kontrak']) }}
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Nama Syarikat</label>
                                {{ Form::select('peny_syarikat_id', namaSyarikat(), '', ['class'=>'form-control', 'id'=>'peny_syarikat_id']) }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="NoLotTanah">No. Perjanjian</label>
                                {{ Form::text('peny_no_perjanjian', '', ['class'=>'form-control', 'id'=>'peny_no_perjanjian', 'placeholder' => 'No perjanjian']) }}
                            </div>

                            <div class="form-group">
                                <label>Tarikh Tamah</label>
                                {{ Form::text('peny_tamat', '', ['class'=>'form-control', 'id'=>'peny_tamat']) }}
                            </div>
                            <div class="form-group">
                                <label>Pegawai Bertangungjawab</label>
                                {{ Form::text('peny_pgw_incharge', '', ['class'=>'form-control', 'id'=>'peny_pgw_incharge']) }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Kadar Sewaan Sebulan</label>
                                {{ Form::text('peny_kadar_sewa', '', ['class'=>'form-control', 'id'=>'peny_kadar_sewa', 'placeholder' => 'No hak milik (jika ada)']) }}
                            </div>
                            <div class="form-group">
                                <label>Tarikh Mula</label>
                                {{ Form::text('peny_mula', '',['class'=>'form-control', 'id'=>'peny_mula']) }}
                            </div>
                            <div class="form-group">
                                <label>Pengarah Kesihtan Negeri</label>
                                {{ Form::text('peny_ketua_ptj', '', ['class'=>'form-control', 'id'=>'peny_ketua_ptj']) }}
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card card-purple">
                <div class="card-header">
                    <h3 class="card-title">Maklumat Fasiiti</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Negeri</label>
                                {{ Form::select('neg_kod_negeri', negeri(), '', ['class'=>'form-control', 'id'=>'neg_kod_negeri']) }}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Daerah</label>
                                <span id="list-daerah">
                                    {{ Form::select('dae_kod_daerah', [''=>'--Sila pilih--'], '', ['class'=>'form-control', 'id'=>'dae_kod_daerah']) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Mukim / Bandar</label>
                                <span id="list-mukim">
                                    {{ Form::select('ban_kod_bandar', [''=>'--Sila pilih--'], '', ['class'=>'form-control', 'id'=>'ban_kod_bandar']) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Fasiliti</label>
                                {{ Form::text('peny_fasilti_id', null, ['class'=>'form-control', 'id'=>'peny_fasilti_id', 'placeholder' => 'Latitude (N)']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-12">

        </div>
    </div>
    <div class="row">
        <div class="col-12">
        <a href="/premis/senarai" class="btn btn-secondary">Batal</a>
        <input type="submit" value="Simpan" class="btn btn-primary float-right">
        </div>
    </div>
</form>
@endsection
@section('js')
    <script src="{{ asset('/template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>

        $('#neg_kod_negeri').change(function() {
            alert("aaa");
            // let neg_kod_negeri = $(this).val();
            // getDaerah(neg_kod_negeri, 'dae_kod_daerah','#list-daerah');
        });

        //AJAX function. get list of daerah
        function getDaerah(kod_negeri, inputname, list) {
            let url = '/ajax/ajax-daerah?neg_kod_negeri=' + kod_negeri + '&inputname=' + inputname;
            $.get(url, function(data) {
                // bg event pd dropdwon yg baru
                // alert(list);
                $(list).html(data);
                $('#dae_kod_daerah').change(function() {
                    let dae_kod_daerah = $(this).val();
                    let url1 = '/ajax/ajax-mukim?dae_kod_daerah=' + dae_kod_daerah + '&inputname=ban_kod_bandar';
                    $.get(url1, function(data1) {
                        $('#list-mukim').html(data1);
                    });
                });
            });
        }


        $('#insert_form').validate({
            rules: {
                peny_tujuan: {
                    required: true
                },
                peny_no_perjanjian: {
                    required: true
                },
                peny_mula: {
                    required: true
                },
                peny_tamat: {
                    required: true
                },
                peny_syarikat_id: {
                    required: true
                },
                peny_fasilti_id: {
                    required: true
                }
            },
            messages: {
                peny_tujuan: {
                    required: "Sila masukkan Nama Kontrak"
                },
                peny_no_perjanjian: {
                    required: "Sila masukkan No Perjanjian"
                },
                peny_mula: {
                    required: "Sila masukkan tarikh Mula Kontrak"
                },
                peny_tamat: {
                    required: "Sila masukkan tarikh Tamat Kontrak"
                },
                peny_syarikat_id: {
                    required: "Sila pilih Syarikat"
                },
                peny_fasilti_id: {
                    required: "Sila pilih Fasiliti"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    </script>
@endsection
