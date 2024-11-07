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
                <h1>Senarai Negeri</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Utiliti</a></li>
                <li class="breadcrumb-item active">Negeri</li>
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
                    <form method="POST" action="/utiliti/negeri/senarai">
                        @csrf
                        <div class="card card-purple card-outline">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Jenis Carian</label>
                                            {{ Form::select('carian_type', ['Kod'=>'Kod', 'Negeri'=>'Negeri'], session('carian_type'), ['class'=>'form-control', 'id'=>'carian_type']) }}
                                        </div>                                    
                                    </div>
                                    <div class="col-md-9">                                
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
                                                <a href="/utiliti/negeri/senarai" class="btn bg-purple">Reset</a>
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
                            <div id="mukim_table">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th class="text-center" width="5%">No.</th>
                                        <th class="text-center" width="10%">Kod</th>
                                        <th width="40%">Negeri</th>
                                        <th width="10%">Zon</th>
                                        <th class="text-center" width="10%">Kod Peta</th>
                                        <th width="10%">Status</th>
                                        <th class="text-center" width="15%">#</th>
                                    </thead>
                                    <tbody>
                                        @if ($negeri->count() > 0)
                                            @php $no = $negeri->firstItem() @endphp
                                            @foreach ($negeri as $neg)                                      
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td class="text-center">{{ str_pad($neg->neg_kod_negeri,2,'0',STR_PAD_LEFT) }}</td>
                                                    <td>{{ $neg->neg_nama_negeri }}</td>
                                                    <td>{{ $neg->neg_nama_zone }}</td>
                                                    <td class="text-center">{{ $neg->neg_maps_code }}</td>
                                                    <td>{{ statusAktif($neg->neg_status) }}</td>                          
                                                    <td class="text-center">
                                                        <a href="#" id="{{ $neg->neg_negeri_id }}" class="btn btn-xs btn-default edit_negeri" title="Kemaskini">
                                                            <i class="text-purple fas fa-edit"></i>
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
                            {{ $negeri->links() }}
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_negeri">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" action="" method="post" id="insert_form">
                    @csrf
                    <input type="hidden" name="neg_negeri_id" id="neg_negeri_id">
                    <div class="modal-header">
                        <h4 class="modal-title">Maklumat Negeri</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="user_nama" class="form-label">Kod Negeri</label>
                                    <span style="color: red">*</span>
                                    {{ Form::text('neg_kod_negeri',null,['class'=>'form-control', 'id'=>'neg_kod_negeri']) }}
                                </div>                                                           
                            </div>                            
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="user_nokp" class="form-label">Negeri</label>
                                    <span style="color: red">*</span>
                                    {{ Form::text('neg_nama_negeri',null,['class'=>'form-control', 'id'=>'neg_nama_negeri']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <label for="user_email" class="form-label">Zon</label>
                                    <span style="color: red">*</span>
                                    {{ Form::text('neg_nama_zone',null,['class'=>'form-control', 'id'=>'neg_nama_zone']) }}
                                                            
                                </div>  
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <label for="user_email" class="form-label">Kod Peta</label>
                                    <span style="color: red">*</span>
                                    <span id="list-daerah1">
                                        {{ Form::text('neg_maps_code',null,['class'=>'form-control', 'id'=>'neg_maps_code']) }}
                                    </span>   
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <span style="color: red">*</span>
                                    {{ Form::select('neg_status',['1'=>'Aktif', '2'=>'Tidak Aktif'], null, ['class'=>'form-control', 'id'=>'neg_status']) }}
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
    $(function() {
        
        $('#add').click(function(){  
            $('#insert').html("Tambah");  
            $('#insert_form')[0].reset(); 
            $('#add_negeri').modal('show');  
        });

        $('.edit_negeri').click(function(){  
            let neg_negeri_id = $(this).attr("id");  
            // alert(neg_negeri_id);
            $.ajax({  
                url:"/utiliti/negeri/ubah",  
                method:"POST",  
                data:{
                    _token: "{{ csrf_token() }}",
                    neg_negeri_id:neg_negeri_id
                },  
                dataType: "json",  
                success:function(data){ 
                    $('#neg_negeri_id').val(data.neg_negeri_id); 
                    $('#neg_kod_negeri').val(data.neg_kod_negeri);  
                    $('#neg_nama_negeri').val(data.neg_nama_negeri);
                    $('#neg_nama_zone').val(data.neg_nama_zone);                   
                    $('#neg_maps_code').val(data.neg_maps_code);
                    $('#neg_status').val(data.neg_status);
                    $('#insert').html("Kemaskini");  
                    $('#add_negeri').modal('show');  
                }  
            });  
        });

        $.validator.setDefaults({
            submitHandler: function () {
                $.ajax({  
                    url:"/utiliti/negeri/simpan",  
                    method:"POST",  
                    data:$('#insert_form').serialize(),
                    beforeSend:function(data){ 
                        if(data.neg_negeri_id==''){
                            mesej = 'Rekod berjaya ditambah';
                        }
                        else{
                            mesej = 'Rekod berjaya dikemaskini';
                        } 
                    },  
                    success:function(data){
                        $('#insert_form')[0].reset();  
                        $('#add_negeri').modal('hide');  
                        $('#mukim_table').html(data);
                        toastr.success(mesej);
                    } 
                });    
            }
        });

        $('#insert_form').validate({
            rules: {
                neg_kod_negeri: {
                    required: true
                },
                neg_nama_negeri: {
                    required: true
                },
                neg_nama_zone: {
                    required: true
                },
                neg_maps_code: {
                    required: true
                },
                neg_status: {
                    required: true
                }
            },
            messages: {
                neg_kod_negeri: {
                    required: "Sila masukkan Kod Negeri",
                },
                neg_nama_negeri: {
                    required: "Sila masukkan Nama Negeri",
                },
                neg_nama_zone: {
                    required: "Sila masukkan Zon",
                },
                neg_maps_code: {
                    required: "Sila masukkan Kod Peta"
                },
                neg_status: {
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