<form action="/penilaian/simpan" method="POST" id="insert_form">
    <div class="modal-body">
        @csrf
        <input type="hidden" name="tanah_id" value="{{ $tanahID }}">
        <input type="hidden" name="penilaian_id" value="{{ $penilaian->penilaian_id }}">

        {{-- {{ Form::hidden('fas_tanah_id', $tanah->tanah_desc )}} --}}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Jenis</label>
                    {{ Form::select('pen_jenis',[''=>'--Sila pilih--', 'Bangunan'=>'Bangunan', 'Tanah'=>'Tanah'], $penilaian->pen_jenis, ['class'=>'form-control', 'id'=>'pen_jenis']) }}
                </div> 
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tahun Penilaian</label>
                    {{ Form::text('pen_tahun', $penilaian->pen_tahun, ['class'=>'form-control', 'id'=>'pen_tahun']) }}
                </div>
            </div>                          
            <div class="col-md-6" > 
                <div class="form-group">
                    <label>Nilai (RM)</label>
                    {{ Form::text('pen_nilai', $penilaian->pen_nilai, ['class'=>'form-control', 'id'=>'pen_nilai']) }}
                </div>
            </div>
            {{-- <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputFile">Dokumen Sokongan</label>
                    <div class="input-group">
                      <div class="custom-file">
                        {{ Form::file('pen_doc', $penilaian->pen_doc, ['class'=>'custom-file-input', 'id'=>'pen_doc']) }}
                        <input type="file" class="custom-file-input" name="pen_doc" id="pen_doc">
                        <label class="custom-file-label" for="exampleInputFile">Pilih dokumen</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Muat naik</span>
                      </div>
                    </div>
                  </div>
            </div> --}}
        </div>
        
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
<script src="{{ asset('/template/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/template/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script>
    $('#insert_form').validate({
            rules: {
                pen_jenis: {
                    required: true
                },
                pen_tahun: {
                    required: true
                },
                pen_nilai: {
                    required: true
                }
            },
            messages: {
                pen_jenis: {
                    required: "Sila pilih Jenis Penilaian",
                },
                pen_tahun: {
                    required: "Sila masukkan Tahun Penilaian",
                },
                pen_nilai: {
                    required: "Sila masukkan nilai (RM)",
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