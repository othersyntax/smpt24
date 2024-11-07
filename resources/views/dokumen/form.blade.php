<form action="/dokumen/simpan" method="POST" enctype="multipart/form-data" id="insert_form">
    <div class="modal-body">
        @csrf
        <input type="hidden" name="tanah_id" value="{{ $tanahID }}">
        <input type="hidden" name="document_id" value="{{ $dokumen->document_id }}">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Nama Dokumen</label>
                    {{ Form::text('doc_desc', $dokumen->doc_desc, ['class'=>'form-control', 'id'=>'doc_desc']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Jenis</label>
                    {{ Form::select('doc_type',[''=>'--Sila pilih--', 'Geran'=>'Geran', 'Surat'=>'Surat', 'Gambar'=>'Gambar', 'Lain'=>'Lain-lain'], $dokumen->doc_type, ['class'=>'form-control', 'id'=>'doc_type']) }}
                </div> 
            </div>            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">Dokumen</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="doc_location" class="custom-file-input" id="doc_location">
                            <label class="custom-file-label" for="customFile">Pilih Dokumen</label>
                        </div>
                    </div>
                  </div>
            </div>
        </div>        
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
<script src="{{ asset('/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('/template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/template/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script>
    $(function () {
      bsCustomFileInput.init();
    });

    $('#insert_form').validate({
            rules: {
                doc_desc: {
                    required: true
                },
                doc_type: {
                    required: true
                },
                doc_location: {
                    required: true
                }
            },
            messages: {
                doc_desc: {
                    required: "Sila masukkan nama Dokumen",
                },
                doc_type: {
                    required: "Sila pilih Jenis Dokumen",
                },
                doc_location: {
                    required: "Sila pilih dokumen",
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
