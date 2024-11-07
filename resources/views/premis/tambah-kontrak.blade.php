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
                    <h3 class="card-title">Maklumat Kontrak</h3>

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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nama Syarikat</label>
                                {{ Form::select('peny_syarikat_id', namaSyarikat(), '', ['class'=>'form-control', 'id'=>'peny_syarikat_id']) }}
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Cagaran (RM)</label>
                                {{ Form::text('peny_cagaran', '', ['class'=>'form-control', 'id'=>'peny_cagaran', 'placeholder' => '000.00']) }}
                            </div>
                            <div class="form-group">
                                <label>Tarikh Mula</label>
                                <div class="input-group date" id="peny_mula" data-target-input="nearest">
                                    <input type="text" name="peny_mula" class="form-control datetimepicker-input" data-target="#peny_mula" />
                                    <div class="input-group-append" data-target="#peny_mula" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pegawai Bertangungjawab</label>
                                {{ Form::text('peny_pgw_incharge', '', ['class'=>'form-control', 'id'=>'peny_pgw_incharge']) }}
                            </div>
			    <div class="form-group">
                                <label for="exampleInputFile">Muat Naik Dokumen Kontrak</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="doc_location" class="custom-file-input" id="doc_location">
                                        <label class="custom-file-label" for="customFile">Pilih Dokumen</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="NoLotTanah">No. Perjanjian</label>
                                {{ Form::text('peny_no_perjanjian', '', ['class'=>'form-control', 'id'=>'peny_no_perjanjian', 'placeholder' => 'No perjanjian']) }}
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Kadar Sewaan Sebulan (RM)</label>
                                {{ Form::text('peny_kadar_sewa', '', ['class'=>'form-control', 'id'=>'peny_kadar_sewa', 'placeholder' => '000.00']) }}
                            </div>
                            <div class="form-group">
                                <label>Tarikh Tamat</label>
                                <div class="input-group date" id="peny_tamat" data-target-input="nearest">
                                    <input type="text" name="peny_tamat" class="form-control datetimepicker-input" data-target="#peny_tamat" />
                                    <div class="input-group-append" data-target="#peny_tamat" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pengarah Kesihatan Negeri</label>
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
                    <h3 class="card-title">Maklumat Fasiliti</h3>

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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Fasiliti</label>
                                <span id="list-fasiliti">
                                    {{ Form::select('tanah_id', [''=>'--Sila pilih--'], '', ['class'=>'form-control', 'id'=>'tanah_id']) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ruang Sewaan</label>
                                <span id="list-ruang">
                                    {{ Form::select('peny_fasilti_id', [''=>'--Sila pilih--'], '', ['class'=>'form-control', 'id'=>'peny_fasilti_id']) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
        <a href="/tanah/senarai" class="btn btn-secondary">Batal</a>
        <input type="submit" value="Simpan" class="btn btn-primary float-right">
        </div>
    </div>
</form>
@endsection
@section('js')
<!-- date-range-picker -->
    <script src="{{ asset('/template/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script   script src="{{ asset('/template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/jquery-validation/additional-methods.min.js') }}"></script>


    <script>
        $(function () {
            //Date picker
            $('#peny_mula').datetimepicker({
                format: 'L',
                format: 'DD/MM/YYYY'
            });
            //Date picker
            $('#peny_tamat').datetimepicker({
                format: 'L',
                format: 'DD/MM/YYYY'
            });

        });
        $('#neg_kod_negeri').change(function() {
            let neg_kod_negeri = $(this).val();
            getDaerah(neg_kod_negeri, 'dae_kod_daerah','#list-daerah');
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
                        $('#ban_kod_bandar').change(function() {
                            // alert('aaa');
                            let ban_kod_bandar = $(this).val();
                            let url2 = '/ajax/ajax-fasiliti?ban_kod_bandar=' + ban_kod_bandar + '&inputname=tanah_id';
                            // alert(ban_kod_bandar);
                            $.get(url2, function(data2) {
                                $('#list-fasiliti').html(data2);
                                $('#tanah_id').change(function() {
                                    let tanah_id = $(this).val();
                                    // alert(tanah_id)
                                    let url3 = '/ajax/ajax-ruang?tanah_id=' + tanah_id + '&inputname=peny_fasilti_id';
                                    $.get(url3, function(data3){
                                        $('#list-ruang').html(data3);
                                    });
                                });
                            });
                        });
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
                peny_kadar_sewa: {
                    required: true
                },
                peny_cagaran: {
                    required: true
                },
                peny_fasilti_id: {
                    required: true
                }
            },
            messages: {
                peny_tujuan: {
                    required: "Sila masukkan Nama Kontrak",
                },
                peny_no_perjanjian: {
                    required: "Sila masukkan No Perjanjian",
                },
                peny_mula: {
                    required: "Sila masukkan tarikh Mula Kontrak",
                },
                peny_tamat: {
                    required: "Sila masukkan tarikh Tamat Kontrak"
                },
                peny_syarikat_id: {
                    required: "Sila pilih Syarikat"
                },
                peny_kadar_sewa: {
                    required: "Sila masukkan kadar sewa sebulan"
                },
                peny_cagaran: {
                    required: "Sila masukkan amaun cagaran"
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

        // $.validator.setDefaults({
        //     submitHandler: function () {
        //         $.ajax({
        //             url:"/utiliti/ptj/simpan",
        //             method:"POST",
        //             data:$('#insert_form').serialize(),
        //             success:function(data){
        //                 $('#insert_form')[0].reset();
        //                 $('#add_ptj').modal('hide');
        //                 $('#ptj_table').html(data);
        //                 toastr.success(mesej);
        //             }
        //         });
        //     }
        // });
    </script>
@endsection
