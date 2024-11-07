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
                <h1>Senarai Jenis Isu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Utiliti</a></li>
                <li class="breadcrumb-item active">Jenis Isu</li>
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
                                            {{ Form::select('carian_type', [''=>'--Sila pilih--', 'Jenis'=>'Jenis Isu', 'Satus'=>'Status'], session('carian_type'), ['class'=>'form-control', 'id'=>'carian_type']) }}
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
                                                <a href="/utiliti/jenis/isu/senarai" class="btn bg-purple">Reset</a>
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
                                        <th width="50%">Jenis Isu</th>
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

    <div class="modal fade" id="add_jnsisu">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" action="" method="post" id="insert_form">
                    @csrf
                    <input type="hidden" name="isuetype_id" id="isuetype_id">
                    <div class="modal-header">
                        <h4 class="modal-title">Maklumat Jenis Isu</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">                            
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="user_nokp" class="form-label">Jenis Isu</label>
                                    {{ Form::text('isuet_name',null,['class'=>'form-control', 'id'=>'isuet_name']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_nokp" class="form-label">Susunan</label>
                                    {{ Form::number('isuet_sort',null,['class'=>'form-control', 'id'=>'isuet_sort']) }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label for="Capaian" class="form-label">Status</label>
                                    {{ Form::select('isuet_status', ['1'=>'Aktif','2'=>'Tidak Aktif'], null, ['class'=>'form-control', 'id'=>'isuet_status']) }}
                                                            
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
                url: "/utiliti/jenis/isu/data",
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
                    $.each(response.jnsisu, function (key, item) {
                        $('tbody').append('<tr>\
                            <td class="text-center">' + nobil + '</td>\
                            <td>' + item.isuet_name + '</td>\
                            <td class="text-center">' + item.isuet_sort + '</td>\
                            <td class="text-center">' + aliasStatus(item.isuet_status) + '</td>\
                            <td class="text-center">\
                                <a href="#" id="' + item.isuetype_id + '" class="btn btn-xs btn-default edit_jnsisu" title="Kemaskini">\
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
            $('#add_jnsisu').modal('show');  
        });

        $(document).on('click', '.edit_jnsisu', function (e) {
            e.preventDefault();
            var isuetype_id = $(this).attr('id');
            // console.log(isuetype_id);
            $.ajax({  
                url:"/utiliti/jenis/isu/ubah",  
                method:"POST",  
                data:{
                    _token: "{{ csrf_token() }}",
                    isuetype_id:isuetype_id
                },  
                dataType: "json",  
                success:function(data){ 
                    $('#isuetype_id').val(data.isuetype_id);
                    $('#isuet_name').val(data.isuet_name);
                    $('#isuet_sort').val(data.isuet_sort);
                    $('#isuet_status').val(data.isuet_status);
                    $('#insert').html("Kemaskini");  
                    $('#add_jnsisu').modal('show');  
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
                    url:"/utiliti/jenis/isu/simpan",  
                    method:"POST",  
                    data:$('#insert_form').serialize(),
                    dataType: "json", 
                    success:function(response){
                        if (response.status == 400) {
                            $('#insert_form')[0].reset();  
                            $('#add_jnsisu').modal('hide');
                            toastr.error(response.message);
                        }
                        else{
                            $('#insert_form')[0].reset();  
                            $('#add_jnsisu').modal('hide');
                            fetchstudent();
                            toastr.success(response.message);
                        }
                    } 
                });    
            }
        });

        $('#insert_form').validate({
            rules: {
                isuet_name: {
                    required: true
                },
                isuet_sort: {
                    required: true
                },
                isuet_status:{
                    required: true
                }
            },
            messages: {
                isuet_name: {
                    required: "Sila masukkan Jenis Isu"
                },
                isuet_sort: {
                    required: "Sila masukkan nombor susunan"
                },
                isuet_status: {
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