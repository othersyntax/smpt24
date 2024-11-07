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
                <h1>Senarai Daerah</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Utiliti</a></li>
                <li class="breadcrumb-item active">Daerah</li>
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
                    <form method="POST" action="/utiliti/daerah/senarai">
                        @csrf
                        <div class="card card-purple card-outline">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Negeri</label>
                                            {{ Form::select('dae_kod_negeri1', negeri(), session('dae_kod_negeri'), ['class'=>'form-control', 'id'=>'dae_kod_negeri1']) }}
                                        </div>                                    
                                    </div>
                                    <div class="col-md-8">                                
                                        <div class="form-group">
                                            <label>Daerah</label>
                                            {{ Form::text('dae_nama_daerah', session('dae_nama_daerah'),['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="margin" style="float:right;">
                                            <div class="btn-group">
                                                <a href="/utiliti/daerah/senarai" class="btn bg-purple">Reset</a>
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
                                <button type="button" name="add" id="add" class="btn btn-primary">Tambah</button>  
                            </div>
                        </div>
                        <div class="col-sm-12 mt-2">
                            <div id="daerah_table">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th class="text-center" width="5%">No.</th>
                                        <th class="text-center" width="10%">Kod</th>
                                        <th width="30%">Daerah</th>
                                        <th width="25%">Negeri</th>
                                        <th width="15%">Status</th>
                                        <th class="text-center" width="15%">#</th>
                                    </thead>
                                    <tbody>
                                        @if ($daerah->count() > 0)
                                            @php $no = $daerah->firstItem() @endphp
                                            @foreach ($daerah as $dae)                                      
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td class="text-center">{{ $dae->dae_kod_daerah }}</td>
                                                    <td>{{ $dae->dae_nama_daerah }}</td>
                                                    <td>{{ $dae->neg_nama_negeri?  $dae->neg_nama_negeri : "Tiada rekod" }}</td> 
                                                    <td>{{ statusAktif($dae->dae_status) }}</td>                               
                                                    <td class="text-center">
                                                        <a href="#" id="{{ $dae->dae_daerah_id }}" class="btn btn-xs btn-default edit_daerah" title="Kemaskini">
                                                            <i class="text-purple fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="6"><i>Tiada Rekod</i></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-1">
                            {{ $daerah->links() }}
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_daerah">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" action="" method="post" id="insert_form">
                    @csrf
                    <input type="hidden" name="dae_daerah_id" id="dae_daerah_id">
                    <div class="modal-header">
                        <h4 class="modal-title">Maklumat Daerah</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_nama" class="form-label">Kod Daerah</label>
                                    <span style="color: red">*</span>
                                    {{ Form::text('dae_kod_daerah',null,['class'=>'form-control', 'id'=>'dae_kod_daerah']) }}
                                </div>                                                           
                            </div>                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_nokp" class="form-label">Daerah</label>
                                    <span style="color: red">*</span>
                                    {{ Form::text('dae_nama_daerah',null,['class'=>'form-control', 'id'=>'dae_nama_daerah']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label for="user_email" class="form-label">Negeri</label>
                                    <span style="color: red">*</span>
                                    {{ Form::select('dae_kod_negeri', negeri(), null, ['class'=>'form-control', 'id'=>'dae_kod_negeri']) }}
                                                            
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <span style="color: red">*</span>
                                    {{ Form::select('dae_status',['1'=>'Aktif', '2'=>'Tidak Aktif'], null, ['class'=>'form-control', 'id'=>'dae_status']) }}
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
    // $(function() {
        
    // });

    $('#add').click(function(){  
        $('#insert').html("Tambah");  
        $('#insert_form')[0].reset(); 
        $('#add_daerah').modal('show');  
    });

    $('.edit_daerah').click(function(){  
        let dae_daerah_id = $(this).attr("id");  
        // alert(dae_daerah_id);
        $.ajax({  
            url:"/utiliti/daerah/ubah",  
            method:"POST",  
            data:{
                _token: "{{ csrf_token() }}",
                dae_daerah_id:dae_daerah_id
            },  
            dataType: "json",  
            success:function(data){ 
                $('#dae_daerah_id').val(data.dae_daerah_id); 
                $('#dae_kod_daerah').val(data.dae_kod_daerah);  
                $('#dae_nama_daerah').val(data.dae_nama_daerah);
                $('#dae_kod_negeri').val(data.dae_kod_negeri);
                $('#dae_status').val(data.dae_status);
                $('#insert').html("Kemaskini");  
                $('#add_daerah').modal('show');  
            }  
        });  
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({  
                url:"/utiliti/daerah/simpan",  
                method:"POST",  
                data:$('#insert_form').serialize(),
                beforeSend:function(data){ 
                    if(data.dae_daerah_id==''){
                        mesej = 'Rekod berjaya ditambah';
                    }
                    else{
                        mesej = 'Rekod berjaya dikemaskini';
                    } 
                },  
                success:function(data){
                    $('#insert_form')[0].reset();  
                    $('#add_daerah').modal('hide');  
                    $('#daerah_table').html(data);
                    toastr.success(mesej);
                } 
            });    
        }
    });

    $('#insert_form').validate({
        rules: {
            dae_kod_daerah: {
                required: true
            },
            dae_nama_daerah: {
                required: true
            },
            dae_kod_negeri: {
                required: true
            },
            dae_status: {
                required: true
            }
        },
        messages: {
            dae_kod_daerah: {
                required: "Sila masukkan Kod Daerah",
            },
            dae_nama_daerah: {
                required: "Sila masukkan Nama Daerah",
            },
            dae_kod_negeri: {
                required: "Sila pilih Negeri",
            },
            dae_status: {
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

</script>
@endsection