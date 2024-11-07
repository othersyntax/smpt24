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
                <h1>Senarai Mukim</h1>
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
                    <form method="POST" action="/utiliti/mukim/senarai">
                        @csrf
                        <div class="card card-purple card-outline">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Negeri</label>
                                            {{ Form::select('neg_kod_negeri', negeri(), session('neg_kod_negeri'), ['class'=>'form-control', 'id'=>'neg_kod_negeri']) }}
                                        </div>                                    
                                    </div>
                                    <div class="col-md-4">                                
                                        <div class="form-group">
                                            <label>Daerah</label>
                                            <span id="list-daerah">
                                                {{ Form::select('dae_kod_daerah', [''=>'--Sila pilih--'], session('dae_kod_daerah'), ['class'=>'form-control', 'id'=>'dae_kod_daerah']) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">                                
                                        <div class="form-group">
                                            <label>Nama Mukim</label>
                                            <span id="list-daerah">
                                                {{ Form::text('namamukim', session('namamukim'),['class'=>'form-control']) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="margin" style="float:right;">
                                            <div class="btn-group">
                                                <a href="/utiliti/mukim/senarai" class="btn bg-purple">Reset</a>
                                            </div>
                                            <div class="btn-group">
                                                <input type="submit" class="btn btn-primary" value="Carian">
                                            </div>                                            
                                        </div>
                                        <!-- <input type="submit" class="btn btn-success" value="Carian" style="float:right;">
                                        <a href="/utiliti/mukim/senarai" class="btn bg-purple" style="float:right;">Reset Carian</a> -->
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
                                        <th width="10%">Kod</th>
                                        <th width="40%">Bandar</th>
                                        <th width="30%">Daerah</th>
                                        <th class="text-center" width="15%">Tindakan</th>
                                    </thead>
                                    <tbody>
                                        @if ($mukim->count() > 0)
                                            @php $no = $mukim->firstItem() @endphp
                                            @foreach ($mukim as $mkm)                                      
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td>{{ $mkm->ban_kod_bandar }}</td>
                                                    <td>{{ $mkm->ban_nama_bandar }}</td>
                                                    <td>{{ $mkm->dae_nama_daerah?  $mkm->dae_nama_daerah : "Tiada rekod" }}</td>                                
                                                    <td class="text-center">
                                                        <a href="#" id="{{ $mkm->ban_bandar_id }}" class="btn btn-xs btn-default edit_mukim" title="Kemaskini">
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
                                            <td class="text-center" colspan="5"><i>Tiada Rekod</i></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-1">
                            {{ $mukim->links() }}
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_mukim">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" action="" method="post" id="insert_form">
                    @csrf
                    <input type="hidden" name="ban_bandar_id" id="ban_bandar_id">
                    <div class="modal-header">
                        <h4 class="modal-title">Maklumat Mukim</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_nama" class="form-label">Kod Mukim</label>
                                    {{ Form::text('ban_kod_bandar',null,['class'=>'form-control', 'id'=>'ban_kod_bandar']) }}
                                </div>                                                           
                            </div>                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_nokp" class="form-label">Mukim</label>
                                    {{ Form::text('ban_nama_bandar',null,['class'=>'form-control', 'id'=>'ban_nama_bandar']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label for="user_email" class="form-label">Negeri</label>
                                    {{ Form::select('ban_kod_negeri', negeri(), null, ['class'=>'form-control', 'id'=>'ban_kod_negeri']) }}
                                                            
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label for="user_email" class="form-label">Daerah</label>
                                    <span id="list-daerah1">
                                        {{ Form::select('ban_kod_daerah',daerah(), null, ['class'=>'form-control', 'id'=>'ban_kod_daerah']) }}
                                    </span>   
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
        let neg_kod_negeri = $('[name=neg_kod_negeri]').val();
        getDaerah(neg_kod_negeri, 'dae_kod_daerah', '#list-daerah');

        // $('#ban_kod_negeri').change(function() {
        //     let ban_kod_negeri = $(this).val();
        //     // alert('AA');
        //     // getDaerah(ban_kod_negeri, 'ban_kod_daerah', '#list-daerah1');
        // });

        $('#add').click(function(){  
            $('#insert').html("Tambah");  
            $('#insert_form')[0].reset(); 
            $('#add_mukim').modal('show');  
        });

        $('.edit_mukim').click(function(){  
            let ban_bandar_id = $(this).attr("id");  
            // alert(ban_bandar_id);
            $.ajax({  
                url:"/utiliti/mukim/ubah",  
                method:"POST",  
                data:{
                    _token: "{{ csrf_token() }}",
                    ban_bandar_id:ban_bandar_id
                },  
                dataType: "json",  
                success:function(data){ 
                    $('#ban_bandar_id').val(data.ban_bandar_id); 
                    $('#ban_kod_bandar').val(data.ban_kod_bandar);  
                    $('#ban_nama_bandar').val(data.ban_nama_bandar);
                    $('#ban_kod_negeri').val(data.ban_kod_negeri);  
                    // getDaerah(data.ban_kod_negeri, 'ban_kod_daerah', '#list-daerah1');        
                    
                    $('#ban_kod_daerah').val(data.ban_kod_daerah);
                    // alert(data.ban_kod_daerah); 
                    $('#insert').html("Kemaskini");  
                    $('#add_mukim').modal('show');  
                }  
            });  
        });

        $.validator.setDefaults({
            submitHandler: function () {
                $.ajax({  
                    url:"/utiliti/mukim/simpan",  
                    method:"POST",  
                    data:$('#insert_form').serialize(),
                    beforeSend:function(data){ 
                        if(data.ban_bandar_id==''){
                            mesej = 'Rekod berjaya ditambah';
                        }
                        else{
                            mesej = 'Rekod berjaya dikemaskini';
                        } 
                    },  
                    success:function(data){
                        $('#insert_form')[0].reset();  
                        $('#add_mukim').modal('hide');  
                        $('#mukim_table').html(data);
                        toastr.success(mesej);
                    } 
                });    
            }
        });

        $('#insert_form').validate({
            rules: {
                ban_kod_bandar: {
                    required: true
                },
                ban_nama_bandar: {
                    required: true
                },
                ban_kod_negeri: {
                    required: true
                },
                ban_kod_daerah: {
                    required: true
                }
            },
            messages: {
                ban_kod_bandar: {
                    required: "Sila masukkan Kod Mukim",
                },
                ban_nama_bandar: {
                    required: "Sila masukkan Nama Mukim",
                },
                ban_kod_negeri: {
                    required: "Sila pilih Negeri",
                },
                ban_kod_daerah: {
                    required: "Sila pilih Daerah"
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

        function getDaerah(neg_kod_negeri, inputname, list) {
            let url = '/ajax/ajax-daerah?neg_kod_negeri=' + neg_kod_negeri + '&inputname=' + inputname;
            $.get(url, function(data) {
                $(list).html(data);
            });
        }
    });

    
    // $('#insert_form').on("submit", function(event){  
    //     event.preventDefault();
        
    // }); 

    $('#neg_kod_negeri').change(function() {
        let neg_kod_negeri = $(this).val();
        // alert('AA');
        getDaerah(neg_kod_negeri, 'neg_kod_negeri', '#list-daerah');
    });

    $('#ban_kod_negeri').change(function() {
        let ban_kod_negeri = $(this).val();
        // alert('AA');
        getDaerah(ban_kod_negeri, 'ban_kod_daerah', '#list-daerah1');
    });

    //AJAX function. get list of PPD
    function getDaerah(neg_kod_negeri, inputname, list) {
        //GET PPD LIST
        let url = '/ajax/ajax-daerah?neg_kod_negeri=' + neg_kod_negeri + '&inputname=' + inputname;
        $.get(url, function(data) {
            $(list).html(data);
        });
    }
</script>
@endsection