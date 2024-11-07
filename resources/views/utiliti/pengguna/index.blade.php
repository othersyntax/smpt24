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
                <h1>Senarai Pengguna</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Utiliti</a></li>
                <li class="breadcrumb-item active">Pengguna</li>
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
                    <form method="POST" action="{{ route('pengguna-senarai') }}">
                        @csrf
                        <div class="card card-purple card-outline">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jenis Carian</label>
                                            {{ Form::select('carian_type', ['Nama'=>'Nama' , 'NoKP'=>'No. Kad Pengenalan', 'PTJ'=>'JKN / PTJ / PK', 'Role'=>'Peranan'], session('carian_type'), ['class'=>'form-control', 'id'=>'carian_type']) }}
                                        </div>                                    
                                    </div>
                                    <div class="col-md-8">                                
                                        <div class="form-group">
                                            <label>Carian</label>
                                            {{ Form::text('carian_text', session('carian_text'),['class'=>'form-control', 'id'=>'carian_text']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="margin" style="float:right;">
                                            <div class="btn-group">
                                                <a href="/utiliti/pengguna/senarai" class="btn bg-purple">Reset</a>
                                            </div>
                                            <div class="btn-group">
                                                <input type="submit" class="btn btn-primary" value="Carian">
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12"> 
                            <div class="text-right">  
                                <a href="/utiliti/pengguna/tambah" class="btn btn-primary">Tambah</a>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-2">
                            <div id="mukim_table">
                                <table id="example1" class="table table-striped">
                                    <thead>
                                        <th class="text-center" width="5%">No.</th>
                                        <th width="15%">No. Kad Pengenalan</th>
                                        <th width="25%">Nama</th>
                                        <th width="20%">E-Mel</th>
                                        <th width="15%">JKN / PTJ / PK</th>
                                        <th width="8%">Peranan</th>
                                        <th width="7%">Status</th>
                                        <th class="text-center" width="5%">Tindakan</th>
                                    </thead>
                                    <tbody>
                                        @if ($user->count() > 0)
                                            @php $no = $user->firstItem() @endphp
                                            @foreach ($user as $usr)                                      
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td>{{ $usr->user_nokp }}</td>
                                                    <td>{{ $usr->user_name }}</td>
                                                    <td>{{ $usr->user_email }}</td>
                                                    <td>{{ $usr->ptj_nama ? $usr->ptj_nama : 'Tiada Rekod' }}</td>
                                                    <td>{{ aliasPeranan($usr->user_role) }}</td>
                                                    <td>{{ statusAktif($usr->user_status) }}</td>                              
                                                    <td class="text-center">
                                                        <a href="/utiliti/pengguna/ubah/{{ $usr->user_id }}" class="btn btn-xs btn-default edit_user" title="Kemaskini">
                                                            <i class="text-purple fas fa-edit"></i>
                                                        </a>
                                                        <a href="#" id="{{ $usr->user_id }}" class="btn btn-xs btn-default set_pass" title="Padam">
                                                            <i class="text-danger fas fa-key"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="7"><i>Tiada Rekod</i></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-1">
                            {{ $user->links() }}
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_user">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" action="" method="post" id="insert_form">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="modal-header">
                        <h4 class="modal-title">Maklumat Pengguna</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="user_name" class="form-label">No. Kad Pengenalan</label>                                    
                                    
                                </div>                                                           
                            </div>                            
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="user_nokp" class="form-label">Nama</label>
                                    {{ Form::text('user_name',null,['class'=>'form-control', 'id'=>'user_name']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label for="user_email" class="form-label">E-Mel</label>
                                    {{ Form::email('user_email', null, ['class'=>'form-control', 'id'=>'user_email']) }}
                                                            
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label for="JKM" class="form-label">JKN / PTJ / PK</label>
                                    {{ Form::select('user_jkn', pusatTjwb(), null, ['class'=>'form-control', 'id'=>'user_jkn']) }}
                                                            
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label for="Capaian" class="form-label">Had Capaian</label>
                                    {{ Form::select('user_role', [''=>'--Sila pilih--','1'=>'[1] - Pentadbir','2'=>'[2] - Pegawai','3'=>'[3] - Kakitangan'], null, ['class'=>'form-control', 'id'=>'user_role']) }}
                                                            
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label for="Modul" class="form-label">Modul</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="user_modul[]" value="1"
                                        
                                        >
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

    <div class="modal fade" id="set_password">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form class="form-horizontal" id="setpass_form">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Set Katalaluan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Adakah anda pasti?</h5>
                        <p>
                            Katalaluan akan di setkan kepada No Kad Pengenalan.
                        </p>
                        <input type="hidden" name="user_id_setpass" id="user_id_setpass">
                        <input type="hidden" name="set_katalaluan" value="Reset Password">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                        <button type="button" id="btn_setpass" class="btn btn-danger">Ya</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('js')

<!-- jquery-validation -->
<script src="{{ asset('/template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/template/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="{{ asset('/template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('/template/plugins/toastr/toastr.min.js') }}"></script>

<script>
    $(function() {
        $('#add').click(function(){  
            $('#insert').html("Tambah");  
            $('#insert_form')[0].reset(); 
            $('#add_user').modal('show');  
        });

        // $('.edit_user').click(function(){  
        //     let user_id = $(this).attr("id");
        //     $.ajax({  
        //         url:"/utiliti/pengguna/ubah",  
        //         method:"POST",  
        //         data:{
        //             _token: "{{ csrf_token() }}",
        //             user_id:user_id
        //         },  
        //         dataType: "json",  
        //         success:function(data){ 
        //             $('#user_id').val(data.user_id); 
        //             $('#user_nokp').val(data.user_nokp);  
        //             $('#user_name').val(data.user_name);
        //             $('#user_email').val(data.user_email);
        //             $('#user_role').val(data.user_role);
        //             $('#user_jkn').val(data.user_jkn);
        //             $('#user_modul').val(data.user_modul);
        //             $('#insert').html("Kemaskini");  
        //             $('#add_user').modal('show');  
        //         }  
        //     });  
        // });

        // $.validator.setDefaults({
        //     submitHandler: function () {
        //         $.ajax({  
        //             url:"/utiliti/pengguna/simpan",  
        //             method:"POST",  
        //             data:$('#insert_form').serialize(),
        //             beforeSend:function(data){ 
        //                 if(data.user_id==''){
        //                     mesej = 'Rekod berjaya ditambah';
        //                 }
        //                 else{
        //                     mesej = 'Rekod berjaya dikemaskini';
        //                 } 
        //             },  
        //             success:function(data){
        //                 $('#insert_form')[0].reset();  
        //                 $('#add_user').modal('hide');  
        //                 $('#mukim_table').html(data);
        //                 toastr.success(mesej);
        //             } 
        //         });    
        //     }
        // });

        // $('#insert_form').validate({
        //     rules: {
        //         user_nokp: {
        //             required: true,
        //             minlength: 12,
        //             maxlength: 12
        //         },
        //         user_name: {
        //             required: true
        //         },
        //         user_email: {
        //             required: true,
        //             email: true
        //         },
        //         user_role: {
        //             required: true
        //         },
        //         user_jkn: {
        //             required: true
        //         },
        //         user_modul:{
        //             required: true
        //         }
        //     },
        //     messages: {
        //         user_nokp: {
        //             required: "Sila masukkan No. Kad Pengenalan",
        //             minlength: "Sila masukkan 12 digit No. Kad Pengenalan",
        //             maxlength: "Sila masukkan 12 digit No. Kad Pengenalan tanpa tanda -",
        //         },
        //         user_name: {
        //             required: "Sila masukkan e-mel"
        //         },
        //         user_email: {
        //             required: "Sila pilih Peranan",
        //             email: "Sila masukkan e-mel yang tepat"
        //         },
        //         user_role: {
        //             required: "Sila pilih Peranan"
        //         },
        //         user_jkn: {
        //             required: "Sila pilih JKN / Pusat Kos"
        //         },
        //         user_modul:{
        //             required: "Sila pilih sekurang-kuranganya 1 modul"
        //         }
        //     },
        //     errorElement: 'span',
        //     errorPlacement: function (error, element) {
        //         error.addClass('invalid-feedback');
        //         element.closest('.form-group').append(error);
        //     },
        //     highlight: function (element, errorClass, validClass) {
        //         $(element).addClass('is-invalid');
        //     },
        //     unhighlight: function (element, errorClass, validClass) {
        //         $(element).removeClass('is-invalid');
        //     }
        // });

        function getDaerah(neg_kod_negeri, inputname, list) {
            let url = '/ajax/ajax-daerah?neg_kod_negeri=' + neg_kod_negeri + '&inputname=' + inputname;
            $.get(url, function(data) {
                $(list).html(data);
            });
        }
    });

    // SET KATALALUAN
    $('.set_pass').click(function(){  
        let user_id = $(this).attr("id");
        $('#setpass_form')[0].reset();    
        $('#user_id_setpass').val(user_id);
        $('#set_password').modal('show');  
    });

    $('.tambah_modul').click(function(){  
        let user_id = $(this).attr("id");
        $('#setpass_form')[0].reset();    
        $('#user_id_setpass').val(user_id);
        $('#set_password').modal('show');  
    });

    $('#btn_setpass').click(function(){ 
        $.ajax({  
            url:"/utiliti/pengguna/katalaluan",  
            method:"POST", 
            data:$('#setpass_form').serialize(),   
            success:function(data){  
                $('#setpass_form')[0].reset();  
                $('#set_password').modal('hide');
                toastr.error('Katalaluan berjaya di set');
            }  
        });
        
    });

    $('.edit_user').click(function(){  
        let user_id = $(this).attr("id");
        $.ajax({  
            url:"/utiliti/pengguna/ubah",  
            method:"POST",  
            data:{
                _token: "{{ csrf_token() }}",
                user_id:user_id
            },  
            dataType: "json",  
            success:function(data){ 
                $('#user_id').val(data.user_id); 
                $('#user_nokp').val(data.user_nokp);  
                $('#user_name').val(data.user_name);
                $('#user_email').val(data.user_email);
                $('#user_role').val(data.user_role);
                $('#user_jkn').val(data.user_jkn);
                $('#user_modul').val(data.user_modul);
                $('#insert').html("Kemaskini");  
                $('#add_user').modal('show');  
            }  
        });  
    });  

</script>
@endsection