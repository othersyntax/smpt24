<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('/template/plugins/daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/template/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<form action="/bayaran/simpan" method="POST" id="insert_form">
    <div class="modal-body">
        @csrf
        <input type="hidden" name="tanah_id" value="{{ $tanahID }}">
        <input type="hidden" name="bayaran_id" value="{{ $bayaran->bayaran_id }}">

        {{-- {{ Form::hidden('fas_tanah_id', $tanah->tanah_desc )}} --}}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tahun</label>
                    {{ Form::text('bayar_year', $bayaran->bayar_year, ['class'=>'form-control', 'id'=>'bayar_year']) }}
                </div>
            </div>                                    
            <div class="col-md-4" > 
                <div class="form-group">
                    <label>Amaun (RM)</label>
                    {{ Form::text('bayar_amaun', $bayaran->bayar_amaun, ['class'=>'form-control', 'id'=>'bayar_amaun']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tarikh Bayaran</label>
                    <div class="input-group date" id="bayar_date" data-target-input="nearest">
                        <input name="bayar_date" type="text" class="form-control datetimepicker-input" data-target="#bayar_date" value="{{ $bayaran->bayar_date ? date('d/m/Y', strtotime($bayaran->bayar_date)) : date('d/m/Y') }}" />
                        <div class="input-group-append" data-target="#bayar_date" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Keterangan</label>
                    {{ Form::text('bayar_desc', $bayaran->bayar_desc, ['class'=>'form-control', 'id'=>'bayar_desc']) }}
                </div>
            </div> 
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
        $('#bayar_date').datetimepicker({
            format: 'L',
            format: 'DD/MM/YYYY'
        });
        
    });

    $('#insert_form').validate({
        rules: {
            bayar_year: {
                required: true
            },
            bayar_amaun: {
                required: true
            },
            bayar_desc: {
                required: true
            }
        },
        messages: {
            bayar_year: {
                required: "Sila masukkan tahun bayaran",
            },
            bayar_amaun: {
                required: "Sila masukkan amaun bayaran (RM)",
            },
            bayar_desc: {
                required: "Sila masukkan keterangan bayaran",
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