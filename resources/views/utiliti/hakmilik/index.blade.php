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
                <h1>Senarai Hak Milik</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Utiliti</a></li>
                <li class="breadcrumb-item active">Hak Milik</li>
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
                    <form method="POST" action="/utiliti/pengguna/senarai">
                        @csrf
                        <div class="card card-purple card-outline">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jenis Carian</label>
                                            {{ Form::select('carian_type', [''=>'--Sila pilih--', 'Jenis'=>'Jenis Hak Milik', 'Satus'=>'Status'], session('carian_type'), ['class'=>'form-control', 'id'=>'carian_type']) }}
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
                                                <a href="/utiliti/hakmilik/senarai" class="btn bg-purple">Reset</a>
                                            </div>
                                            <div class="btn-group">
                                                <input type="button" class="btn btn-primary" id="carian" value="Carian">
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
                                <button type="button" name="add" id="add" class="btn btn-primary">Tambah</button>  
                            </div>
                        </div>
                        <div class="col-sm-12 mt-2">
                            <div>
                                <table id="example1" class="table table-striped">
                                    <thead>
                                        <th class="text-center" width="5%">No.</th>
                                        <th width="50%">Hak Milik</th>
                                        <th class="text-center" width="15%">Susunan</th>
                                        <th class="text-center" width="15%">Status</th>
                                        <th class="text-center" width="15%">#</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_hakmilik">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" action="" method="post" id="insert_form">
                    @csrf
                    <input type="hidden" name="jenishm_id" id="jenishm_id">
                    <div class="modal-header">
                        <h4 class="modal-title">Maklumat Hak Milik</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">                            
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="user_nokp" class="form-label">Hak Milik</label>
                                    {{ Form::text('jenishm_desc',null,['class'=>'form-control', 'id'=>'jenishm_desc']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_nokp" class="form-label">Susunan</label>
                                    {{ Form::number('jenishm_sort',null,['class'=>'form-control', 'id'=>'jenishm_sort']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label for="Capaian" class="form-label">Status</label>
                                    {{ Form::select('jenishm_status', ['1'=>'Aktif','2'=>'Tidak Aktif'], null, ['class'=>'form-control', 'id'=>'jenishm_status']) }}
                                                            
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

<!-- jquery-validation -->
<script src="{{ asset('/template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/template/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="{{ asset('/template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('/template/plugins/toastr/toastr.min.js') }}"></script>

<script>
    $(document).ready(function () {
        fetchstudent();

        function fetchstudent(carian_type='', carian_text='') {
            $.ajax({
                type: "post",
                url: "/utiliti/hakmilik/data",
                data:{
                    _token: "{{ csrf_token() }}",
                    carian_type:carian_type,
                    carian_text:carian_text
                },
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('tbody').html("");
                    nobil = 1;
                    $.each(response.hakmilik, function (key, item) {
                        $('tbody').append('<tr>\
                            <td class="text-center">' + nobil + '</td>\
                            <td>' + item.jenishm_desc + '</td>\
                            <td class="text-center">' + item.jenishm_sort + '</td>\
                            <td class="text-center">' + aliasStatus(item.jenishm_status) + '</td>\
                            <td class="text-center">\
                                <a href="#" id="' + item.jenishm_id + '" class="btn btn-xs btn-default edit_jnsisu" title="Kemaskini">\
                                <i class="text-purple fas fa-edit"></i></a>\
                            </td>\
                        \</tr>');
                        nobil++;
                    });
                }
            });        
        }

        function aliasStatus(code){
            if(code==1)
                return 'Aktif';
            else   
                return 'Tidak Aktif';
        }
        
        $('#add').click(function(e){ 
            e.preventDefault();
            $('#insert').html("Tambah");  
            $('#insert_form')[0].reset(); 
            $('#add_hakmilik').modal('show');  
        });

        $(document).on('click', '.edit_jnsisu', function (e) {
            e.preventDefault();
            var jenishm_id = $(this).attr('id');
            // console.log(jenishm_id);
            $.ajax({  
                url:"/utiliti/hakmilik/ubah",  
                method:"POST",  
                data:{
                    _token: "{{ csrf_token() }}",
                    jenishm_id:jenishm_id
                },  
                dataType: "json",  
                success:function(data){ 
                    $('#jenishm_id').val(data.jenishm_id);
                    $('#jenishm_desc').val(data.jenishm_desc);
                    $('#jenishm_sort').val(data.jenishm_sort);
                    $('#jenishm_status').val(data.jenishm_status);
                    $('#insert').html("Kemaskini");  
                    $('#add_hakmilik').modal('show');  
                } 
            });  
        });

        $(document).on('click', '#carian', function (e) {
            e.preventDefault();
            $carian_type = $('#carian_type').val();
            $carian_text = $('#carian_text').val();
            fetchstudent($carian_type, $carian_text);
        });

        $.validator.setDefaults({
            submitHandler: function () {
                $.ajax({  
                    url:"/utiliti/hakmilik/simpan",  
                    method:"POST",  
                    data:$('#insert_form').serialize(),
                    dataType: "json", 
                    success:function(response){
                        if (response.status == 400) {
                            $('#insert_form')[0].reset();  
                            $('#add_hakmilik').modal('hide');
                            toastr.error(response.message);
                        }
                        else{
                            $('#insert_form')[0].reset();  
                            $('#add_hakmilik').modal('hide');
                            fetchstudent();
                            toastr.success(response.message);
                        }
                    } 
                });    
            }
        });

        $('#insert_form').validate({
            rules: {
                jenishm_desc: {
                    required: true
                },
                jenishm_sort: {
                    required: true
                },
                jenishm_status:{
                    required: true
                }
            },
            messages: {
                jenishm_desc: {
                    required: "Sila masukkan Hak Milik"
                },
                jenishm_sort: {
                    required: "Sila masukkan nombor susunan"
                },
                jenishm_status: {
                    required: "Sila pilih Status"
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
    });

</script>
@endsection