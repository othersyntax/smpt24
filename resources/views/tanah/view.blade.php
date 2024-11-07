@extends('layout.main')
@section('custom-css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('/template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('/template/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    {{-- <link rel="stylesheet" href="{{ asset('/template/css/tanah-maps.css')}}"> --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #map {
            height: 500px;
        }

    </style>
@endsection
@section('breadcrumb')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Maklumat Tanah</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Tanah</a></li>
                <li class="breadcrumb-item active">Utama</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <div class="row">
    <div class="col-12">
        <input type="hidden" name="hide_tanah_id" value="{{ $tanah->tanah_id }}">
        <div class="row">
            <div class="col-12">
            {{-- <h5><i class="fas fa-map-marker"></i> NO. LOT: {{ Str::upper($tanah->tanah_no_lot) }}</h5>
            <i class="fas fa-globe"></i> {{ Str::upper($tanah->tanah_desc) }} --}}
            <div id="map"></div>
            </div>
        </div>
        <!-- Main content -->
        <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
            <div class="col-12">
                <h4 class="text-purple">
                    <i class="fas fa-globe"></i> {{ Str::upper($tanah->tanah_desc) }}
                    <small class="float-right">Tarikh : {{ date('d-m-Y') }}</small>
                </h4>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
            <p class="lead">LOKASI</p>
            <address>
                <strong>{{ Str::upper($tanah->tanah_desc) }}</strong><br>
                <i>
                {{ $tanah->bandar->ban_nama_bandar }}<br>
                {{ $tanah->daerah->dae_nama_daerah }}<br>
                {{ $tanah->negeri->neg_nama_negeri }}<br>
                </i>
                <b>Koordinat:</b> {{ $tanah->tanah_latitud }} , {{ $tanah->tanah_longitud }}
            </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
            <p class="lead">MAKLUMAT TANAH</p>
            <dl class="row">
                <dt class="col-sm-4">No Lot</dt>
                <dd class="col-sm-8">{{ $tanah->tanah_no_lot? $tanah->tanah_no_lot: 'Tiada rekod' }}</dd>
                <dt class="col-sm-4">No Hak Milik</dt>
                <dd class="col-sm-8">{{ $tanah->tanah_no_hakmilik ? $tanah->tanah_no_hakmilik: 'Tiada rekod' }}</dd>
                <dt class="col-sm-4">No JKPTG</dt>
                <dd class="col-sm-8">{{ $tanah->tanah_no_jkptg ? $tanah->tanah_no_jkptg: 'Tiada rekod' }}</dd>
                <dt class="col-sm-4">Keluasan</dt>
                <dd class="col-sm-8">{{ $tanah->tanah_luas }} ekar</dd>
                <dt class="col-sm-4">Status Tanah</dt>
                <dd class="col-sm-8">{{ $tanah->statusTanahDB->statt_desc }}</dd>
            </dl>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
            <p class="lead">MAKLUMAT PENYELENGGARAAN</p>
            <dl class="row">
                <dt class="col-sm-4">Status</dt>
                <dd class="col-sm-8">{{ statusAktif($tanah->tanah_status) }}</dd>
                <dt class="col-sm-4">Cipta Oleh</dt>
                <dd class="col-sm-8">{{ $tanah->tanah_crtby ? aliasPengguna($tanah->tanah_crtby) : 'Tiada Rekod' }}</dd>
                <dt class="col-sm-4">Cipta Pada</dt>
                <dd class="col-sm-8">{{ date('d-m-Y H:i', strtotime($tanah->tanah_created)) }}</dd>
                <dt class="col-sm-4">Ubah Oleh</dt>
                <dd class="col-sm-8">{{ $tanah->tanah_updby ? aliasPengguna($tanah->tanah_updby) : 'Tiada Rekod' }}</dd>
                <dt class="col-sm-4">Ubah Pada</dt>
                <dd class="col-sm-8">{{ date('d-m-Y H:i', strtotime($tanah->tanah_upddate)) }}</dd>
            </dl>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <!-- accepted payments column -->
            <div class="col-4">
                <p class="lead">CATATAN</p>
                <div class="callout">
                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                        @if (isset($tanah->tanah_memo))
                            {!! $tanah->tanah_memo !!}
                        @else
                            Tiada rekod
                        @endif

                    </p>
                </div>
            </div>
            <div class="col-8">
                <p class="lead">MAKLUMAT TANAH</p>
                <div class="col-12">
                    <div class="card card-purple card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Fasiliti</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Penilaian</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Senarai Dokumen</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill" href="#custom-tabs-three-settings" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="false">Perkara Berbangkit</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-premium-tab" data-toggle="pill" href="#custom-tabs-premium-settings" role="tab" aria-controls="custom-tabs-premium-settings" aria-selected="false">Bayaran Premium</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                {{-- FASILIT --}}
                                <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                    <div>
                                        <button id="add-new" class="btn btn-outline-success" style="float:right" data-toggle="modal" data-target="#modal-fas" value="fasiliti">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <table class="table mt-3">
                                        <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th>Fasiliti</th>
                                            <th>Keluasan</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                        </thead>
                                        <tbody id="fasiliti_table">
                                        @php
                                            $bilfas=1;
                                        @endphp
                                        @if ($fasiliti->count() > 0)
                                            @foreach ($fasiliti as $fas)
                                                <tr>
                                                    <td class="text-center">{{ $bilfas++ }}</td>
                                                    <td>{{ $fas->fas_desc }}</td>
                                                    <td>{{ $fas->fas_size }} {{ $fas->fas_size_unit }}</td>
                                                    <td class="text-center">
                                                        <a href="#" class="my-edit" val="{{ $fas->fasiliti_id }}" data-toggle="modal" data-target="#modal-fas">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                        <a href="#" onclick="return confirm('Anda pasti untuk padam')" class="my-del" val="{{ $fas->fasiliti_id }}">
                                                            <i class="fas fa-trash text-danger"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center" colspan="4"><i>Tiada Rekod</i></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{-- PENILAIAN --}}
                                <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                                    <div>
                                        <button id="add-new-pen"  class="btn btn-outline-success" style="float:right" data-toggle="modal" data-target="#modal-fas" value="penilaian">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <table class="table  mt-3">
                                        <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th>Jenis</th>
                                            <th>Tahun</th>
                                            <th class="text-right">Nilai (RM)</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                        </thead>
                                        <tbody id="penilaian_table">
                                        @php
                                            $bilpen=1;
                                        @endphp
                                        @if ($nilai->count() > 0)
                                            @foreach ($nilai as $nil)
                                                <tr>
                                                    <td class="text-center">{{$bilpen++}}</td>
                                                    <td>{{ $nil->pen_jenis }}</td>
                                                    <td>{{ $nil->pen_tahun }}</td>
                                                    <td class="text-right">@duit( $nil->pen_nilai )</td>
                                                    <td class="text-center">
                                                        <a href="#" class="my-edit-pen" val="{{ $nil->penilaian_id }}" data-toggle="modal" data-target="#modal-fas">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                        <a href="#" onclick="return confirm('Anda pasti untuk padam')" class="my-del-pen" val="{{ $nil->penilaian_id }}">
                                                            <i class="fas fa-trash text-danger"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center" colspan="4"><i>Tiada Rekod</i></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{-- DOKUMEN --}}
                                <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                                    <div>
                                        <button id="add-new-doc" class="btn btn-outline-success" style="float:right" data-toggle="modal" data-target="#modal-fas" value="dokumen">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <table class="table mt-3">
                                        <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th>Keterangan</th>
                                            <th>Dokumen</th>
                                            <th class="text-center">Papar</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                        $bildoc=1;
                                        @endphp
                                        @if ($dokumen->count() > 0)
                                            @foreach ($dokumen as $doc)
                                                <tr>
                                                    <td class="text-center">{{ $bildoc++ }}</td>
                                                    <td>{{ $doc->doc_desc }}</td>
                                                    <td>{{ $doc->doc_type }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ asset('storage/files/'.$doc->doc_location) }}" title="Papar Dokumen" target="_blank">
                                                            <i class="fas fa-search text-purple"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center" colspan="4"><i>Tiada Rekod</i></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{-- ISU --}}
                                <div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
                                    <div>
                                        <button id="add-new-isu" class="btn btn-outline-success" style="float:right" data-toggle="modal" data-target="#modal-fas" value="isu">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <table class="table mt-3">
                                        <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th>Jenis</th>
                                            <th>Perkara</th>
                                            <th>Mula</th>
                                            <th>Status</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                        </thead>
                                        <tbody id="isu_table">
                                            @php
                                            $bilisu=1;
                                            @endphp
                                            @if ($isu->count() > 0)
                                                @foreach ($isu as $i)
                                                    <tr>
                                                        <td class="text-center" width="5%">{{ $bilisu++ }}</td>
                                                        <td width="15%">{{ $i->isue_type_id ? $i->jenis->isuet_name : '-' }}</td>
                                                        <td width="50%">{{ $i->isue_desc }}</td>
                                                        <td width="10%">{{ date('d/m/Y', strtotime($i->isue_sdate)) }}</td>
                                                        <td width="10%">{{ statusAktif($i->isue_status) }}</td>
                                                        <td width="10%" class="text-center">
                                                            <a href="#" class="my-edit-isu" val="{{ $i->isue_id }}" data-toggle="modal" data-target="#modal-fas">
                                                                <i class="far fa-edit"></i>
                                                            </a>
                                                            <a href="#" onclick="return confirm('Anda pasti untuk padam')" class="my-del-isu" val="{{ $i->isue_id }}">
                                                                <i class="fas fa-trash text-danger"></i>
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
                                {{-- Bayaran --}}
                                <div class="tab-pane fade" id="custom-tabs-premium-settings" role="tabpanel" aria-labelledby="custom-tabs-three-premium-tab">
                                    <div>
                                        <button id="add-new-bayar" class="btn btn-outline-success" style="float:right" data-toggle="modal" data-target="#modal-fas" value="premium">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <table class="table mt-3">
                                        <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th>Tahun</th>
                                            <th>Keterangan</th>
                                            <th>Tarikh</th>
                                            <th class="text-right">Amaun (RM)</th>
                                            <th class="text-center">Papar</th>
                                        </tr>
                                        </thead>
                                        <tbody id="bayar_table">
                                            @php
                                                $bilbyr=1;
                                            @endphp
                                            @if ($bayaran->count()>0)
                                                @foreach ($bayaran as $b)
                                                    <tr>
                                                        <td class="text-center">{{ $bilbyr++ }}</td>
                                                        <td>{{ $b->bayar_year }}</td>
                                                        <td>{{ $b->bayar_desc }}</td>
                                                        <td>{{ date('d/m/Y', strtotime($b->bayar_date)) }}</td>
                                                        <td class="text-right">@duit($b->bayar_amaun)</td>
                                                        <td class="text-center">
                                                            <a href="#" class="my-edit-bayar" val="{{ $b->bayaran_id }}" data-toggle="modal" data-target="#modal-fas">
                                                                <i class="far fa-edit"></i>
                                                            </a>
                                                            <a href="#" onclick="return confirm('Anda pasti untuk padam')" class="my-del-bayar" val="{{ $b->bayaran_id }}">
                                                                <i class="fas fa-trash text-danger"></i>
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
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-12">
            <a href="/tanah/senarai" rel="noopener" class="btn btn-danger"><i class="fas fa-chevron-left"></i> Kembali</a>
            <a href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
            <a href="/tanah/ubah/{{ encrypt($tanah->tanah_id) }}" class="btn btn-success float-right"><i class="fas fa-cog"></i> Kemakini
            </a>
            <a href="/tanah/cetak/{{ encrypt($tanah->tanah_id) }}" target="_blank" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-download"></i> Generate PDF
            </a>
            </div>
        </div>
        </div>
        <!-- /.invoice -->
    </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="modal fade" id="modal-fas">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $err)
                                {{ $err }} <br>
                            @endforeach
                        </div>
                    @endif
                    <h4 class="modal-title"><p id="form-title"></p></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="my-form"></div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('js')
    <!-- SweetAlert2 -->
    <script src="{{ asset('/template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('/template/plugins/toastr/toastr.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('/template/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>

        $(function() {
            //TOASTR
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            //MODAL
            // ADD
            $('#add-new').click(function(){
                let modul = 'fasiliti';
                myForm(modul);
            });
            $('#add-new-pen').click(function(){
                let modul = 'penilaian';
                myForm(modul);
            });
            $('#add-new-doc').click(function(){
                let modul = 'dokumen';
                myForm(modul);
            });
            $('#add-new-isu').click(function(){
                let modul = 'isu';
                myForm(modul);
            });
            $('#add-new-bayar').click(function(){
                let modul = 'bayaran';
                myForm(modul);
            });

            function myForm(modul){
                let tanah_id = $('[name=hide_tanah_id').val();
                // alert(modul);
                if(modul=='fasiliti'){
                    $('#form-title').html('Tambah Maklumat Fasiliti');
                }
                else if(modul=='penilaian'){
                    $('#form-title').html('Tambah Maklumat Penilaian');
                }
                else if(modul=='dokumen'){
                    $('#form-title').html('Tambah Maklumat Dokumen');
                }
                else if(modul=='isu'){
                    $('#form-title').html('Tambah Maklumat Perkara Berbangkit');
                }
                else{
                    $('#form-title').html('Tambah Maklumat Bayaran');
                }
                $('#my-form').load('/'+modul+'/myFormAdd/'+tanah_id);
            }

            // EDIT
            $('.my-edit').click(function(){
                let id = $(this).attr('val');
                ubah(id, 'fasiliti');
            });
            $('.my-edit-pen').click(function(){
                let id = $(this).attr('val');
                ubah(id, 'penilaian');
                // alert("TEST");
            });
            $('.my-edit-doc').click(function(){
                let id = $(this).attr('val');
                ubah(id, 'dokumen');
            });
            $('.my-edit-isu').click(function(){
                let id = $(this).attr('val');
                ubah(id, 'isu');
            });
            $('.my-edit-bayar').click(function(){
                let id = $(this).attr('val');
                ubah(id, 'bayaran');
            });

            function ubah(id, modul) {
                let tanah_id = $('[name=hide_tanah_id').val();
                if(modul=='fasiliti'){
                    $('#form-title').html('Kemaskini Maklumat Fasiliti');
                }
                else if(modul=='penilaian'){
                    $('#form-title').html('Kemaskini Maklumat Penilaian');
                    // alert("TEST");
                }
                else if(modul=='dokumen'){
                    $('#form-title').html('Kemaskini Maklumat Dokumen');
                }
                else if(modul=='isu'){
                    $('#form-title').html('Kemaskini Maklumat Perkara Berbangkit');
                    // alert(id);
                }
                else{
                    $('#form-title').html('Kemaskini Maklumat Bayaran');
                }
                $('#my-form').load('/'+modul+'/myFormEdit/'+tanah_id+'/'+id);
            }

            //DELETE
            $('.my-del').click(function(){
                let modul = 'fasiliti';
                let id = $(this).attr('val');
                myDelete(id, modul, '#fasiliti_table');
                // alert(fasiliti_id);
            });

            $('.my-del-pen').click(function(){
                let modul = 'penilaian';
                let id = $(this).attr('val');
                myDelete(id, modul, '#penilaian_table');
                // alert(fasiliti_id);
            });

            $('.my-del-isu').click(function(){
                let modul = 'isu';
                let id = $(this).attr('val');
                myDelete(id, modul, '#isu_table');
                // alert(fasiliti_id);
            });

            $('.my-del-bayar').click(function(){
                let modul = 'bayaran';
                let id = $(this).attr('val');
                myDelete(id, modul, '#bayar_table');
                // alert(fasiliti_id);
            });

            // Ubah balik coding delete
            function myDelete(delid, modul, table) {
                let tanah_id = $('[name=hide_tanah_id]').val();
                $.ajax({
                    url: "/"+modul+"/delete",
                    method:"POST",
                    data: {
                        "_token": $('#csrf-token')[0].content,
                        "delid":delid,
                        "tanah_id":tanah_id
                    },
                    success:function(result){
                        $(table).html(result);
                        if(result!="ERROR")
                            toastr.warning('Rekod berjaya dipadam');
                        else
                            toastr.danger('Rekod GAGAL dipadam');
                    }
                });
            }
        });

    </script>
    <script>

        let config = {
        minZoom: 7,
        maxZoom: 18,
        };
        const zoom = 11;
        //SET MAP VIEW
        const latCurr = {{ $tanah->tanah_latitud }};
        const lngCurr = {{ $tanah->tanah_longitud }};

        // GET ALL NEAREST FASILITIES IN THE SAME DAERAH
        let points = {!! json_encode($coordinates) !!}
        
        const map = L.map("map", config).setView([latCurr, lngCurr], zoom);


        L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(map);

        // MAKE MARKER
        for (let i = 0; i < points.length; i++) {
            const [lat, lng, popupText] = points[i];
            // POPUP NAME FOR SELECTED RECORD
            if (lat == latCurr && lng==lngCurr){                
                marker = new L.marker([lat, lng]).addTo(map).bindPopup(popupText).openPopup();
            }
            // second example
            else {
                marker = new L.marker([lat, lng]).bindPopup(popupText).addTo(map);
            }
        }
    </script>
@endsection
