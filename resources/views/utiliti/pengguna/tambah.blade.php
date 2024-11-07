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
                <li class="breadcrumb-item active">Tambah</li>
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
                  src="{{ asset('/template/dist/img/unknown_user.png') }}"
                  alt="User profile picture">
            </div>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
      <!-- /.col -->
      <div class="col-md-9">                
        <div class="card card-purple card-outline">               
          <div class="card-body">
            <form id="insert_form" class="form-horizontal" action="/utiliti/pengguna/simpan" method="post">
              @csrf
              <div class="form-group row">
                  <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                  <div class="col-sm-9 err-msg">
                        {{ Form::text('user_name',null,['class'=>'form-control', 'id'=>'user_name']) }}
                  </div>
              </div>
              <div class="form-group row">
                  <label for="nokp" class="col-sm-3 col-form-label">No Kad Pengenalan</label>
                  <div class="col-sm-4 err-msg">
                      {{ Form::text('user_nokp',null,['class'=>'form-control', 'id'=>'user_nokp']) }}
                  </div>
              </div>
              <div class="form-group row">
                  <label for="emel" class="col-sm-3 col-form-label">Emel</label>
                  <div class="col-sm-9 err-msg">
                      {{ Form::email('user_email', null, ['class'=>'form-control', 'id'=>'user_email']) }} 
                  </div>
              </div>
              <div class="form-group row">
                <label for="ptj" class="col-sm-3 col-form-label">JKN / PTJ / PK</label>
                <div class="col-sm-4 err-msg">
                    {{ Form::select('user_jkn', pusatTjwb(), null, ['class'=>'form-control', 'id'=>'user_jkn']) }}
                </div>
              </div>
              <div class="form-group row">
                  <label for="hadcapaian" class="col-sm-3 col-form-label">Had Capaian</label>
                  <div class="col-sm-4 err-msg">
                  {{ Form::select('user_role', [''=>'--Sila pilih--','1'=>'Pentadbir','2'=>'Pusat Tanggungjawab','3'=>'Pusat Kos'], null, ['class'=>'form-control', 'id'=>'user_role']) }}
                  </div>
              </div>
              <div class="form-group row">
                <label for="hadcapaian" class="col-sm-3 col-form-label">Modul</label>
                <div class="form-group col-sm-9 err-msg">
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="user_modul[]" value="1">
                      <label for="Tanah" class="form-check-label">Tanah</label>
                  </div>
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="user_modul[]" value="2">
                      <label for="Premis" class="form-check-label">Premis Demis</label>
                  </div>
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="user_modul[]" value="3">
                      <label for="Utiliti" class="form-check-label">Utiliti</label>
                  </div>                                                                                        
                </div>
              </div>
              <div class="form-group row">
                  <div class="offset-sm-3 col-sm-9">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
              </div>
            </form>
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
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
                user_name: {
                    required: true
                },
                user_nokp: {
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
                }
            },
            messages: {
                user_name: {
                    required: "Sila masukkan Nama",
                },
                user_nokp: {
                    required: "Sila masukkan No Kad Pengenalan",
                },
                user_email: {
                    required: "Sila masukkan Emel",
                },
                user_jkn: {
                    required: "Sila pilih JKN/PTJ/PK",
                },
                user_role: {
                    required: "Sila pilih Had Capaian"
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
    </script>
@endsection