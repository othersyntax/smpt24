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
                <h1>Maklumat Tanah</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Tanah</a></li>
                <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('content')
<form action="/tanah/simpan" id="insert_form" method="post">
    @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="card card-purple">
                <div class="card-header">
                    <h3 class="card-title">Maklumat AM</h3>

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
                                <label for="Keterangan">Keterangan</label>
                                {{ Form::text('tanah_desc', null,['class'=>'form-control', 'id'=>'tanah_desc', 'placeholder' => 'Keterangan']) }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="NoLotTanah">No. Lot Tanah</label>
                                {{ Form::text('tanah_no_lot', '', ['class'=>'form-control', 'id'=>'tanah_no_lot', 'placeholder' => 'No lot tanah']) }}
                            </div>
                            <div class="form-group">
                                <label>JenisHakMilik</label>
                                {{ Form::select('tanah_jenis_hakmilik', jenisHakMilik(), '',['class'=>'form-control']) }}
                            </div>
                            <div class="form-group">
                                <label>Ada Fasiliti?</label>
                                {{ Form::select('tanah_facilities', [''=>'--Sila pilih--', '1'=>'Ya', '2'=>'Tidak'], '', ['class'=>'form-control', 'id'=>'tanah_facilities']) }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">No. JKPTG</label>
                                {{ Form::text('tanah_no_jkptg', '',['class'=>'form-control', 'id'=>'tanah_no_jkptg', 'placeholder' => 'No JKPTG (jika ada)']) }}
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">No. Hak Milik</label>
                                {{ Form::text('tanah_no_hakmilik', '', ['class'=>'form-control', 'id'=>'tanah_no_hakmilik', 'placeholder' => 'No hak milik (jika ada)']) }}
                            </div>
                            <div class="form-group">
                                <label>Pusat Tanggungjawab</label>
                                {{ Form::select('tanah_pk_id', pusatTjwb(), '', ['class'=>'form-control', 'id'=>'tanah_pk_id']) }}
                            </div>
                        </div>
                    </div>                
                </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card card-purple">
                <div class="card-header">
                    <h3 class="card-title">Maklumat Lokasi</h3>
        
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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Latitude (N)</label>
                                {{ Form::text('tanah_latitud', null, ['class'=>'form-control', 'id'=>'tanah_latitud', 'placeholder' => 'Latitude (N)']) }}
                            </div>
                        </div>                       
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Longitude (E) </label>
                                {{ Form::text('tanah_longitud', null, ['class'=>'form-control', 'id'=>'tanah_longitud', 'placeholder' => 'Longitude (E)']) }}
                            </div>                                
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card card-purple">
                <div class="card-header">
                    <h3 class="card-title">Catatan</h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">                    
                    <div class="form-group">
                        {!!  Form::textarea('tanah_memo', null, ['class'=> 'form-control', 'rows'=> 4, 'id'=> 'tanah_memo']) !!}

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- /.card -->
            <div class="card card-purple">
                <div class="card-header">
                    <h3 class="card-title">Ukuran</h3>
                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Keluasan </label>
                        {{ Form::number('tanah_luas', '',['class'=>'form-control', 'id'=>'tanah_luas', 'placeholder' => 'Keluasan tanah']) }}
                    </div>
                    <div class="form-group">
                        <label>Unit Ukuran</label>
                        {{ Form::select('tanah_luas_unit', ['Ekar'=>'Ekar', 'Hektar'=>'Hektar', 'Meter'=>'Meter'], '', ['class'=>'form-control', 'id'=>'tanah_luas_unit']) }}
                    </div>           
                </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card card-purple">
                <div class="card-header">
                    <h3 class="card-title">Status</h3>
                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Tanah</label>
                        {{ Form::select('tanah_status_tanah', statusTanah(), null, ['class'=>'form-control', 'id'=>'tanah_status_tanah']) }}
                    </div>
                    <div class="form-group">
                        <label>Rekod</label>
                        {{ Form::select('tanah_status', ['1'=>'Aktif', '2'=>'Tidak Aktif'], null, ['class'=>'form-control', 'id'=>'tanah_status']) }}
                    </div>           
                </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-12">
            
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
    <script src="{{ asset('/template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>

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
                    });
                });
            });
        }


        $('#insert_form').validate({
            rules: {
                tanah_desc: {
                    required: true
                },
                tanah_no_lot: {
                    required: true
                },
                tanah_jenis_hakmilik: {
                    required: true
                },
                tanah_facilities: {
                    required: true
                },
                tanah_pk_id: {
                    required: true
                },
                neg_kod_negeri: {
                    required: true
                },
                dae_kod_daerah: {
                    required: true
                },
                ban_kod_bandar: {
                    required: true
                },
                tanah_longitud: {
                    required: true
                },
                tanah_latitud: {
                    required: true
                },
                tanah_luas: {
                    required: true
                },
                tanah_status_tanah: {
                    required: true
                }
            },
            messages: {
                tanah_desc: {
                    required: "Sila masukkan Keterangan Lot Tanah",
                },
                tanah_no_lot: {
                    required: "Sila masukkan No Lot Tanah",
                },
                tanah_jenis_hakmilik: {
                    required: "Sila pilih Jenis Hak Milik",
                },
                tanah_pk_id: {
                    required: "Sila pilih Pusat Tanggungjawab"
                },
                tanah_facilities: {
                    required: "Sila pilih Ada Fasiliti?"
                },
                neg_kod_negeri: {
                    required: "Sila pilih Negeri"
                },
                dae_kod_daerah: {
                    required: "Sila pilih Daerah"
                },
                ban_kod_bandar: {
                    required: "Sila pilih Mukim/Bandar"
                },
                tanah_longitud: {
                    required: "Sila masukkan Longitud"
                },
                tanah_latitud: {
                    required: "Sila masukkan Latitud"
                },
                tanah_luas: {
                    required: "Sila masukkan Keluasan Tanah"
                },
                tanah_status_tanah: {
                    required: "Sila masukkan Status Tanah"
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