<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('/template/plugins/daterangepicker/daterangepicker.css') }}">
 <link rel="stylesheet" href="{{ asset('/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
 <link rel="stylesheet" href="{{ asset('/template/plugins/select2/css/select2.min.css') }}">
 <link rel="stylesheet" href="{{ asset('/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<form id="insert_form" action="/isu/simpan" method="POST" id="insert_form">
    <div class="modal-body">
        @csrf
        <input type="hidden" name="tanah_id" value="{{ $tanahID }}">
        <input type="hidden" name="isue_id" value="{{ $isu->isue_id }}">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Jenis</label>
                    {{ Form::select('isue_type_id',$jenisIsu, $isu->isue_type_id, ['class'=>'form-control', 'id'=>'isue_type_id']) }}
                </div> 
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tarikh Mula</label>
                    <div class="input-group date" id="isue_sdate" data-target-input="nearest">
                        <input type="text" name="isue_sdate" class="form-control datetimepicker-input" data-target="#isue_sdate" value="{{ $isu->isue_sdate ? date('d/m/Y', strtotime($isu->isue_sdate)) : date('d/m/Y') }}" />
                        <div class="input-group-append" data-target="#isue_sdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tarikh Tamat</label>
                    <div class="input-group date" id="isue_edate" data-target-input="nearest">
                        <input type="text" name="isue_edate" class="form-control datetimepicker-input" data-target="#isue_edate" value="{{ $isu->isue_edate ? date('d/m/Y', strtotime($isu->isue_edate)) : '31/12/9999' }}" />
                        <div class="input-group-append" data-target="#isue_edate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="col-md-12">
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea class="form-control" name="isue_desc" id="isue_desc" rows="5">{{ $isu->isue_desc }}</textarea>
                </div>
            </div>
            @if (isset($isu->isue_status))
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        {{ Form::select('isue_status',['1'=>'Aktif', '2'=>'Selesai'], $isu->isue_status, ['class'=>'form-control', 'id'=>'isue_status']) }}
                    </div>
                </div>
            @endif            
        </div>        
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<!-- date-range-picker -->
<script src="{{ asset('/template/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('/template/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/template/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('/template/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<script src="{{ asset('/template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/template/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script>
    // $(function () {
    $(function () {
        //Date picker
        $('#isue_sdate').datetimepicker({
            format: 'L',
            format: 'DD/MM/YYYY'
        });
        //Date picker
        $('#isue_edate').datetimepicker({
            format: 'L',
            format: 'DD/MM/YYYY'
        }); 
        
    });

    $('#insert_form').validate({
        rules: {
            isue_type_id: {
                required: true
            },
            isue_desc: {
                required: true
            },
            isue_sdate: {
                required: true
            },
            isue_edate: {
                required: true
            }
        },
        messages: {
            isue_type_id: {
                required: "Sila pilih Jenis Isu",
            },
            isue_desc: {
                required: "Sila masukkan Keterangan Isu",
            },
            isue_sdate: {
                required: "Sila pilih tarikh mula",
            },
            isue_edate: {
                required: "Sila pilih tarikh akhir",
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
<script>
    
</script>