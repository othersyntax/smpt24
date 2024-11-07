@extends('layout.dashboard')
@section('breadcrumb')
@endsection
@section('custom-css')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.charts.load('current', {
        callback: function(){
            var data = new google.visualization.arrayToDataTable(@json($negeri));

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1]);

            var options = {
                region: 'MY',
                displayMode: 'regions',
                resolution: 'provinces',
                colorAxis: {minValue: 10000000, colors: ['#24b500', '#feb2ae', '#fd0202']},
                height: 550,
            };

            var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

            google.visualization.events.addListener(chart, 'select', function () {
                var selection = chart.getSelection();
                if (selection.length > 0) {
                    window.open('/kkm-utiliti/dashboard?negeri=' + data.getValue(selection[0].row, 0).slice(-2), '_self');
                }
            });
            chart.draw(data, options);
        },
        'packages':['geochart'],
        'mapsApiKey': 'AIzaSyD4lz4VTknTzKB3PCAhYnV3a1F6vJYDYt0'
    });
</script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        
        var data = google.visualization.arrayToDataTable(@json($barchart));
        var options = {
            hAxis: {title: 'Bulan',  titleTextStyle: {color: '#333'}},
            vAxis: {
                minValue: 0,
                format: 'short'
            }
        };

        var chart = new google.visualization.AreaChart(document.getElementById('barchart_material'));
        chart.draw(data, options);
      }


    // }
  </script>

@endsection
@section('content')

@php
if(request()->get('tahun')){
    $title = 'Bagi tahun '.request()->get('tahun');
}
else{
    $title = '';
}

if(request()->get('negeri')){
    $state_title = getNegeri(request()->get('negeri'));
}
else{
    $state_title = 'MALAYSIA';
}

function getNegeri($kod){
    if($kod=='01')
        return 'JOHOR';
    else if($kod=='02')
        return 'KEDAH';
    else if($kod=='03')
        return 'KELANTAN';
    else if($kod=='04')
        return 'MELAKA';
    else if($kod=='05')
        return 'NEGERI SEMBILAN';
    else if($kod=='06')
        return 'PAHANG';
    else if($kod=='07')
        return 'PUAU PINANG';
    else if($kod=='08')
        return 'PERAK';
    else if($kod=='09')
        return 'PERLIS';
    else if($kod=='10')
        return 'SELANGOR';
    else if($kod=='11')
        return 'TERENGGANU';
    else if($kod=='12')
        return 'SABAH';
    else if($kod=='13')
        return 'SARAWAK';
    else if($kod=='14')
        return 'W.P. KUALA LUMPUR';
    else if($kod=='15')
        return 'W.P. LABUAN';
    else
        return 'W.P. PUTRAJAYA';
}
    
@endphp

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
            <!-- Info boxes -->
        <form id="myForm" method="post" action="/kkm-utiliti/dashboard">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <div class="row">
                    <div class="col-sm-4 col-md-2">
                        <select class="form-control" name="negeri" id="negeri">
                            <option value="">Seluruh Malaysia</option>
                            @foreach ($lsnegeri as $neg)
                                <option  value="{{ $neg->neg_kod_negeri }}" 
                                @if($neg->neg_kod_negeri==session('negeri'))
                                    selected
                                @endif
                                >{{ $neg->neg_nama_negeri }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <select class="form-control" name="tahun" id="tahun">
                            <option value="">Tahun</option>
                            <option value="2018" 
                                @if(session('tahun') == 2018 )
                                    selected
                                @endif
                            >2018</option>
                            <option value="2019"
                                @if(session('tahun') == 2019 )
                                    selected
                                @endif
                            >2019</option>
                            <option value="2020"
                                @if(session('tahun') == 2020 )
                                    selected
                                @endif
                            >2020</option>
                            <option value="2021"
                                @if(session('tahun') == 2021 )
                                    selected
                                @endif
                            >2021</option>
                            <option value="2022"
                                @if(session('tahun') == 2022 )
                                    selected
                                @endif
                            >2022</option>
                            <option value="2023"
                                @if(session('tahun') == 2023 )
                                    selected
                                @endif
                            >2023</option>
                        </select>
                        
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <button type="button" class="btn btn-info btn-block" onclick="location.href='/kkm-utiliti/dashboard';">
                            <i class="fas fa-bars"></i> Papar Semua
                        </button>
                    </div>
                    <div class="col-sm-4 col-md-2"></div>
                    <div class="col-sm-4 col-md-4 text-right"><h3 class="text-red">(RM) {{ number_format($eletrik +  $air,2) }}</h3></div>
                    </div>
                </div>
            </div> 
        </div>
        </form>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Jumlah Bayaran Uitiliti Mengikut Negeri</h5>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="text-center text-info">
                                {{ $state_title }}
                            </h4>
                            <div id="regions_div"></div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <p class="text-center"><strong>Bayaran Utiliti {{ $title }}</strong></p>
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Negeri</th>
                                        <th class="text-right">Elektrik (RM)</th>
                                        <th class="text-right">Air (RM)</th>
                                    </tr>   
                                </thead>
                                <tbody>
                                    @php
                                        $atotal=0;
                                        $etotal=0;
                                    @endphp                                    
                                    @foreach ($statedata as $key=>$currentRow)
                                        @if ( request()->get('negeri') == $currentRow->neg_kod_negeri )
                                            <tr class="table-info">
                                                <td>{{ $currentRow->neg_nama_negeri }}</td>
                                                <td class="text-right">{{ number_format($currentRow->eletrik,2) }}</td>
                                                <td class="text-right">{{ number_format($currentRow->air,2) }}</td>                                        
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $currentRow->neg_nama_negeri }}</td>
                                                <td class="text-right">{{ number_format($currentRow->eletrik,2) }}</td>
                                                <td class="text-right">{{ number_format($currentRow->air,2) }}</td>                                        
                                            </tr>
                                        @endif
                                        @php
                                            $atotal +=  $currentRow->air;
                                            $etotal +=  $currentRow->eletrik;
                                        @endphp                                      
                                    @endforeach                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Jumlah</th>
                                        <th class="text-right">{{ number_format($etotal,2) }}</th>
                                        <th class="text-right">{{ number_format($atotal,2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            
                        </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-2 col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0.00%</span>
                                <h5 class="description-header">0.00</h5>
                                <span class="description-text">2018</span>
                            </div>
                        </div>
                        @php
                            $border = '';
                            $text = '';
                            $icon = '';
                        @endphp
                        @foreach ($tahunan as $key=>$currentRow)
                            @php
                                
                                $border = 'border-right';
                                if(isset($tahunan[$key - 1])){
                                    $nextRow = $tahunan[$key - 1];

                                    $peratus = (($currentRow->amaun - $nextRow->amaun) / $currentRow->amaun) *100;

                                    if($currentRow->amaun > $nextRow->amaun){
                                        $text = 'text-danger';
                                        $icon = 'fas fa-caret-up';                                        
                                    }
                                    else if($currentRow->amaun == $nextRow->amaun){
                                        $text = 'text-warning';
                                        $icon = 'fas fa-caret-left';
                                    }
                                    else{
                                        $text = 'text-success';
                                        $icon = 'fas fa-caret-down';
                                    }
                                }
                                else{
                                    $peratus = 0;
                                    $text = 'text-warning';
                                    $icon = 'fas fa-caret-left';
                                }
                            @endphp
                            <div class="col-sm-2 col-6">
                                <div class="description-block {{ $border }}">
                                    <span class="description-percentage {{ $text }}"><i class="{{ $icon}}"></i> {{ number_format($peratus,2)}}%</span>
                                    <h5 class="description-header">RM {{  number_format($currentRow->amaun,2) }}</h5>
                                    <span class="description-text">{{ $currentRow->tahun }}</span>
                                </div>
                            </div>
                        @endforeach                      
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h6>Senarai Hospital</h6>
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed">
                                <thead>
                                    <tr>
                                        <th width="5%">Bil</th>
                                        <th width="70%">Hospital</th>
                                        <th width="25%" class="text-right">Amaun (RM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($hospital as $hosp)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ ucfirst($hosp->hospital) }}</td>
                                            <td class="text-right"><a href="#" id="{{ $hosp->hospital_id }}" class="papar_hospital" title="Papar">
                                                {{ number_format($hosp->amaun,2) }}</a>
                                            </td>
                                        </tr>
                                    @endforeach                  
                                </tbody>                        
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <h6>Bayaran Bulanan Utiliti {{ $title }}</h6>
                        <div id="barchart_material" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- /.container-fluid -->
</section>

<div class="modal fade" id="mod_hospital">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="nama_hospital"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="barchart_material1"></div>
                <div id="testing"></div>
            </div>   
            <div class="modal-footer justify-content-between">
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button> -->
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
<!-- /.content -->
@endsection
@section('js')
    <script>
        $("#negeri").change(function(e){    
            document.getElementById("myForm").submit();
        });

        $("#tahun").change(function(e){    
            document.getElementById("myForm").submit();
        });

        $('.papar_hospital').click(function(){  
            let hospital_id = $(this).attr("id");
            let tahun = "{{ session('tahun') }}";          

            $.ajax({  
                url:"/kkm-utiliti/hospital",  
                method:"POST",  
                data:{
                    _token: "{{ csrf_token() }}",
                    hospital_id:hospital_id,
                    tahun:tahun
                },  
                dataType: "json",  
                success:function(terimadata){
                    var data_arr = [
                        ['Bulan', 'Elektrik', 'Air'],                         
                    ];

                    $.each(terimadata, function(index, value){
                        data_arr.push([value.Bulan, parseFloat(value.Elektrik), parseFloat(value.Air)]);
                    });

                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart1);

                    function drawChart1() {
                        
                        var data = google.visualization.arrayToDataTable(data_arr);
                        var options = {
                            hAxis: {title: 'Bulan',  titleTextStyle: {color: '#333'}},
                            vAxis: {
                                minValue: 0,
                                format: 'short'
                            }
                        };
                        var chart = new google.visualization.AreaChart(document.getElementById('barchart_material1'));
                        chart.draw(data, options);
                    }
                }, error: function(){
                    alert('error');
                } 
            });
            tahun_title ='';
            if(tahun !=''){
                var tahun_title = ' Bagi Tahun '+ tahun;
            }

            $('#nama_hospital').html("Bayaran Uitliti" + tahun_title);
            $('#mod_hospital').modal('show');            
        });

    </script>
    <script src="{{ asset('/template/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('/template/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('/template/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('/template/plugins/chart.js/Chart.min.js') }}"></script>
@endsection