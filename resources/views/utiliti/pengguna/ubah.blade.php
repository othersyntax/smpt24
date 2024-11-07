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
                <h1>Maklumat Pengguna</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
                <li class="breadcrumb-item active">Ubah</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-purple card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('storage/profile/'.$user->user_image) }}"
                                alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{ strtoupper($user->user_name) }}</h3>
                        <p class="text-muted text-center">{{ aliasPeranan($user->user_role) }}</p>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
                <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#profil" data-toggle="tab">Profil</a></li>
                            <li class="nav-item"><a class="nav-link" href="#modul" data-toggle="tab">Modul</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="profil">
                                <form class="form-horizontal" id="insert_form" action="/utiliti/pengguna/simpan" method="post">
                                    @csrf
                                    {!! Form::hidden('user_id', $user->user_id) !!}
                                    <div class="form-group row">
                                        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-9 err-msg">
                                            {{ Form::text('user_name',$user->user_name,['class'=>'form-control', 'id'=>'user_name']) }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nokp" class="col-sm-3 col-form-label">No Kad Pengenalan</label>
                                        <div class="col-sm-4 err-msg">
                                            {{ Form::text('user_nokp',$user->user_nokp,['readonly', 'class'=>'form-control', 'id'=>'user_nokp']) }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="emel" class="col-sm-3 col-form-label">Emel</label>
                                        <div class="col-sm-9 err-msg">
                                            {{ Form::email('user_email', $user->user_email, ['class'=>'form-control', 'id'=>'user_email']) }} 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nokp" class="col-sm-3 col-form-label">Katalaluan</label>
                                        <div class="col-sm-4 err-msg">
                                            {{ Form::password('user_pass1', ['class'=>'form-control', 'id'=>'user_pass1']) }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nokp" class="col-sm-3 col-form-label">Sah Katalaluan</label>
                                        <div class="col-sm-4 err-msg">
                                            {{ Form::password('user_pass2', ['class'=>'form-control', 'id'=>'user_pass2']) }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <label for="ptj" class="col-sm-3 col-form-label">JKN / PTJ / PK</label>
                                        <div class="col-sm-9 err-msg">
                                            {{ Form::select('user_jkn', pusatTjwb(), $user->user_jkn, ['class'=>'form-control', 'id'=>'user_jkn']) }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="hadcapaian" class="col-sm-3 col-form-label">Had Capaian</label>
                                        <div class="col-sm-4 err-msg">
                                        {{ Form::select('user_role', [''=>'--Sila pilih--','1'=>'Pentadbir','2'=>'Pusat Tanggungjawab','3'=>'Pusat Kos'], $user->user_role, ['class'=>'form-control', 'id'=>'user_role']) }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="hadcapaian" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-4 err-msg">
                                        {{ Form::select('user_status', ['1'=>'Aktif','2'=>'Tidak Aktif'], $user->user_status, ['class'=>'form-control', 'id'=>'user_status']) }}
                                    </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-3 col-sm-9">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="modul">
                                @php
                                $modul =  \App\Models\UserModul::where('um_user_id', $user->user_id)->get();
                                @endphp
                                <div class="col-sm-12 mb-2"> 
                                    <div class="text-right">  
                                        <button type="button" id="{{ $user->user_id }}" class="btn btn-primary add_module">Tambah</button>  
                                    </div>
                                </div>
                                <table class="table">                                    
                                    <thead>
                                    <tr>
                                        <th>Bil.</th>
                                        <th>Modul</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if ($modul->count() > 0)
                                        @php $no = 1 @endphp
                                        @foreach ($modul as $m)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ aliasModul($m->um_modul_id) }}</td>
                                            <td>{{ statusAktif($m->um_status) }}</td>
                                            <td class="text-right py-0 align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <a href="#" id="{{ $m->user_module_id }}" class="btn btn-primary edit_modul" title="Kemaskini"><i class="fas fa-edit"></i></a>
                                                <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                            </div>
                                            </td>
                                        </tr>                                            
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center"><i>Tiada Rekod</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>                                
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                    <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<div class="modal fade" id="mod_add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="insert_form2" class="form-horizontal" action="/utiliti/pengguna/modul" method="post">
                @csrf
                <input type="hidden" name="user_id" id="user_id" value="">
                <input type="hidden" name="user_module_id" id="user_module_id" value="">
                <div class="modal-header">
                    <h4 class="modal-title">Maklumat Modul</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">                           
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="user_nokp" class="form-label">Modul</label>
                                {{ Form::select('um_modul_id', [''=>'--Sila pilih--','1'=>'Tanah', '2'=>'Premis Demis', '3'=>'Utiliti'], null, ['class'=>'form-control', 'id'=>'um_modul_id']) }}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group ">
                                <label for="JKM" class="form-label">Status</label>
                                {{ Form::select('um_status', ['1'=>'Aktif','2'=>'Tidak Aktif'], null, ['class'=>'form-control', 'id'=>'um_status']) }}
                                                        
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
<!-- /.modal-dialog -->
</div>
@endsection
@section('js')
    <script src="{{ asset('/template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>

    $(function() {

        $('#neg_kod_negeri').change(function() {
            let neg_kod_negeri = $(this).val();
            getDaerah(neg_kod_negeri, 'dae_kod_daerah','#list-daerah');
        });

        //add module
        $('.add_module').click(function(){  
            let user_id = $(this).attr("id");
            $('#user_id').val(user_id);
            $('#mod_add').modal('show'); 
        });

        $('#insert_form2').validate({
            rules: {
                um_modul_id: {
                    required: true
                }
            },
            messages: {
                um_modul_id: {
                    required: "Sila Pilih Modul"
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

        $('.edit_modul').click(function(){  
            let user_module_id = $(this).attr("id");
            // alert(user_module_id);
            $.ajax({  
                url:"/utiliti/pengguna/getmodul",  
                method:"POST",  
                data:{
                    _token: "{{ csrf_token() }}",
                    user_module_id:user_module_id
                },  
                dataType: "json",  
                success:function(data){ 
                    $('#user_module_id').val(data.user_module_id); 
                    $('#user_id').val(data.um_user_id); 
                    $('#um_modul_id').val(data.um_modul_id);  
                    $('#um_status').val(data.um_status);
                    $('#insert').html("Kemaskini");  
                    $('#mod_add').modal('show');  
                }  
            });  
        });

        $('#insert_form').validate({
            rules: {
                user_name: {
                    required: true
                },
                user_email: {
                    required: true
                },
                user_jkn: {
                    required: true
                },
                user_role: {
                    required: true
                },
                user_pass1: {
                    minlength: 6
                },
                user_pass2: {
                    minlength: 6,
                    equalTo: "#user_pass1"
                }
            },
            messages: {
                user_name: {
                    required: "Sila masukkan Nama"
                },
                user_email: {
                    required: "Sila masukkan Emel"
                },
                user_jkn: {
                    required: "Sila pilih JKN/PTJ/PK"
                },
                user_role: {
                    required: "Sila pilih Peranan"
                },
                user_pass1: {
                    minlength: "Katalaluan sekurang-kurangnya 6 aksara"
                },
                user_pass2: {
                    minlength: "Katalaluan sekurang-kurangnya 6 aksara",
                    equalTo: "Katalaluan tidak sama"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.err-msg').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
         
    
    </script>
@endsection