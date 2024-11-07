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
                                src="{{ asset('storage/'.$user->user_image) }}"
                                alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{ strtoupper($user->user_name) }}</h3>
                        <p class="text-center">
                            <br>{{ aliasPeranan($user->user_role) }}
                            <br><b>{{ $user->namaPTJ->ptj_nama }}</b>
                        </p>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
                <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#profil" data-toggle="tab">Kemaskini Profil</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="profil">
                                <form class="form-horizontal" id="insert_form" action="/profile/ubah" method="post" enctype="multipart/form-data">
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
                                        <label for="gambar" class="col-sm-3 col-form-label">Gambar Profil</label>
                                        <div class="col-sm-4 err-msg">
                                            <div class="custom-file">
                                                <input type="file" name="user_image" class="custom-file-input" id="user_image">
                                                <label class="custom-file-label" for="customFile">Pilih Gambar</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-3 col-sm-9">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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

</div>
@endsection
@section('js')
    <script src="{{ asset('/template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script>

    $(function() {
        bsCustomFileInput.init();

        $('#neg_kod_negeri').change(function() {
            let neg_kod_negeri = $(this).val();
            getDaerah(neg_kod_negeri, 'dae_kod_daerah','#list-daerah');
        });

        $('#insert_form').validate({
            rules: {
                user_name: {
                    required: true
                },
                user_email: {
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