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
                <h1>Senarai JKN / PTJ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Utiliti</a></li>
                <li class="breadcrumb-item active">Mukim</li>
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
                    <form method="POST" action="/utiliti/ptj/senarai">
                        @csrf
                        <div class="card card-purple card-outline">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Negeri</label>
                                            {{ Form::select('kod_negeri', negeri(), session('kod_negeri'), ['class'=>'form-control', 'id'=>'kod_negeri']) }}
                                        </div>                                    
                                    </div>
                                    <div class="col-md-4">                                
                                        <div class="form-group">
                                            <label>Daerah</label>
                                            <span id="list-daerah-s">
                                                {{ Form::select('kod_daerah', [''=>'--Sila pilih--'], session('kod_daerah'), ['class'=>'form-control', 'id'=>'kod_daerah']) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">                                
                                        <div class="form-group">
                                            <label>Mukim</label>
                                            <span id="list-mukim-s">
                                                {{ Form::select('kod_mukim', [''=>'--Sila pilih--'], session('kod_mukim'), ['class'=>'form-control', 'id'=>'kod_mukim']) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">                                
                                        <div class="form-group">
                                            <label>Kod PTJ</label>
                                            {{ Form::text('ptj_code', session('ptj_code'),['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-8">                                
                                        <div class="form-group">
                                            <label>Nama PTJ / PK</label>
                                            {{ Form::text('ptj_nama', session('ptj_nama'),['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="margin" style="float:right;">
                                            <div class="btn-group">
                                                <a href="/utiliti/ptj/senarai" class="btn bg-purple">Reset</a>
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
                            <div id="ptj_table">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <th class="text-center" width="5%">No.</th>
                                        <th width="10%">Kod PTJ / PK</th>
                                        <th width="40%">Nama PTJ / PK</th>
                                        <th width="25%">Mukim / Bandar</th>
                                        <th width="10%">Status</th>
                                        <th class="text-center" width="10%">Tindakan</th>
                                    </thead>
                                    <tbody>
                                        @if ($ptj->count() > 0)
                                            @php $no = $ptj->firstItem() @endphp
                                            @foreach ($ptj as $p)                                      
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td>{{ $p->ptj_code }}</td>
                                                    <td>{{ $p->ptj_nama }}</td>
                                                    <td>{{ $p->ban_nama_bandar }}</td>
                                                    <td>{{ statusAktif($p->ptj_status) }}</td>                                
                                                    <td class="text-center">
                                                        <a href="#" id="{{ $p->ptj_id }}" class="btn btn-xs btn-default edit_ptj" title="Kemaskini">
                                                            <i class="text-purple fas fa-edit"></i>
                                                        </a>
                                                        <!-- <a href="#" onclick=" return confirm('Anda pasti untuk padam')" title="Hapus Aktiviti">
                                                            <i class="fas fa-trash text-danger"></i>
                                                        </a> -->
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
                            {{ $ptj->links() }}
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_ptj">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" action="" method="post" id="insert_form">
                    @csrf
                    <input type="hidden" name="ptj_id" id="ptj_id">
                    <div class="modal-header">
                        <h4 class="modal-title">Maklumat PTJ/PK</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="user_nama" class="form-label">Kod PTJ/PK</label>
                                    {{ Form::text('ptj_code',null,['class'=>'form-control', 'id'=>'ptj_code']) }}
                                </div>                                                           
                            </div>                            
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="ptj_nama" class="form-label">Nama PTJ/PK</label>
                                    {{ Form::text('ptj_nama',null,['class'=>'form-control', 'id'=>'ptj_nama']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <label for="negeri" class="form-label">Negeri</label>
                                    {{ Form::select('kod_negeri1', negeri(), 0, ['class'=>'form-control', 'id'=>'kod_negeri1']) }}
                                                            
                                </div>  
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <label for="daerah" class="form-label">Daerah</label>
                                    <span id="list-daerah-a">
                                        {{ Form::select('kod_daerah1',daerah(), 0, ['class'=>'form-control', 'id'=>'kod_daerah1']) }}
                                    </span>   
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <label for="bandarmukim" class="form-label">Bandar / Mukim</label>
                                    <span id="list-mukim-a">
                                        {{ Form::select('ptj_kod_bandar', bandar(), 0, ['class'=>'form-control', 'id'=>'ptj_kod_bandar']) }}
                                    </span>   
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    {{ Form::select('ptj_status',['1'=>'Aktif', '2'=>'Tidak Aktif'], null, ['class'=>'form-control', 'id'=>'ptj_status']) }}
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
        //Masa open by default
        //Search Form
        let kod_negeri = $('[name=kod_negeri]').val();
        getDaerah(kod_negeri, 'kod_daerah', '#list-daerah-s');

        // Modal Form
        // let kod_negeri1 = $('[name=kod_negeri1]').val();
        // getDaerah(kod_negeri1, 'kod_daerah1', '#list-daerah-a');

        // $('#kod_negeri1').change(function() {
        //     let kod_negeri1 = $(this).val();
        //     getDaerah(kod_negeri1, 'kod_daerah1', '#list-daerah-a');
        // });
    });

    //Setelah dipilih
    $('#kod_negeri').change(function() {
        let kod_negeri = $(this).val();
        getDaerah(kod_negeri, 'kod_daerah', '#list-daerah-s');
    });

    $('#kod_negeri1').change(function() {
        let kod_negeri1 = $(this).val();
        getDaerah(kod_negeri1, 'kod_daerah1', '#list-daerah-a');
    });

    $('#add').click(function(){  
        $('#insert').html("Tambah");  
        $('#insert_form')[0].reset(); 
        $('#add_ptj').modal('show');  
    });

    $('.edit_ptj').click(function(){  
        let ptj_id = $(this).attr("id");  
        // alert(ptj_id);
        $.ajax({  
            url:"/utiliti/ptj/ubah",  
            method:"POST",  
            data:{
                _token: "{{ csrf_token() }}",
                ptj_id:ptj_id
            },  
            dataType: "json",  
            success:function(data){ 
                $('#ptj_id').val(data.ptj_id); 
                $('#ptj_code').val(data.ptj_code);  
                $('#ptj_nama').val(data.ptj_nama);
                $('#kod_negeri1').val(data.neg_kod_negeri);
                $('#kod_daerah1').val(data.dae_kod_daerah);
                $('#ptj_kod_bandar').val(data.ptj_kod_bandar);
                $('#ptj_status').val(data.ptj_status);
                $('#insert').html("Kemaskini");  
                $('#add_ptj').modal('show');
            }  
        });  
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({  
                url:"/utiliti/ptj/simpan",  
                method:"POST",  
                data:$('#insert_form').serialize(),
                beforeSend:function(data){ 
                    if(data.ptj_id==''){
                        mesej = 'Rekod berjaya ditambah';
                    }
                    else{
                        mesej = 'Rekod berjaya dikemaskini';
                    } 
                },  
                success:function(data){
                    $('#insert_form')[0].reset();  
                    $('#add_ptj').modal('hide');  
                    $('#ptj_table').html(data);
                    toastr.success(mesej);
                } 
            });    
        }
    });

    $('#insert_form').validate({
        rules: {
            ptj_code: {
                required: true
            },
            ptj_nama: {
                required: true
            },
            ptj_kod_bandar: {
                required: true
            }
        },
        messages: {
            ptj_code: {
                required: "Sila masukkan Kod Mukim",
            },
            ptj_nama: {
                required: "Sila masukkan Nama Mukim",
            },
            ptj_kod_bandar: {
                required: "Sila pilih Bandar",
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


    //AJAX function. get list of PPD
    function getDaerah(kod_negeri, inputname, list) {
        //GET PPD LIST
        let url = '/ajax/ajax-daerah?neg_kod_negeri=' + kod_negeri + '&inputname=' + inputname;
        $.get(url, function(data) {
            $(list).html(data);
            $('[name=kod_daerah]').change(function() {
                let kod_daerah = $(this).val();
                getMukim(kod_daerah, 'kod_mukim', '#list-mukim-s');
            });
            $('[name=kod_daerah1]').change(function() {
                let kod_daerah1 = $(this).val();
                getMukim(kod_daerah1, 'ptj_kod_bandar', '#list-mukim-a');
            });

            //Edit
            
            //defaultvalue
            let kod_daerah = $('[name=kod_daerah]').val();
            // let kod_daerah1 = $('[name=kod_daerah1]').val();
            getMukim(kod_daerah, 'kod_mukim', '#list-mukim-s');
            // getMukim(kod_daerah1, 'ptj_kod_bandar', '#list-mukim-a');
        });
    }

    function getMukim(kod_daerah, inputname, list) {
        //GET MUKIM/BANDAR LIST
        let url = '/ajax/ajax-mukim?dae_kod_daerah=' + kod_daerah + '&inputname=' + inputname;
        $.get(url, function(data) {
            $(list).html(data);
        });
    }
</script>
@endsection