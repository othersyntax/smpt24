@extends('layout.main')
@section('breadcrumb')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Utama</li>
            </ol>
        </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection
@section('custom-css')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
      'packages':['geochart']
    });
    google.charts.setOnLoadCallback(drawRegionsMap);

    function drawRegionsMap() {

      var data = new google.visualization.arrayToDataTable(@json($mapnegeri));
      var options = {
        region: 'MY',
        displayMode: 'regions',
        resolution: 'provinces',

        // colorAxis: {colors: ['white', 'purple']},
        colorAxis: {colors: ['#ffcce6', '#4d0026']},
        // backgroundColor: '#81d4fa',
        // datalessRegionColor: '#f8bbd0',
        // defaultColor: '#f5f5f5',

        height: 600,
        width: 600,
      };

      var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

      chart.draw(data, options);
    }
</script>
@endsection
@section('content')
  @php
      foreach($milik as $mdata){
        $bilot = $mdata->BIL;
        $ptp = $mdata->PTP;
        $rizab = $mdata->RIZAB;
        $felda = $mdata->FELDA;
        $felcra = $mdata->FELCRA;
        $kesedar = $mdata->KESEDAR;
        $lada = $mdata->LADA;
      }

      foreach($fasiliti as $fas){
        $ada = $fas->adaFasiliti;
        $xada = $fas->xadaFasiliti;
      }
  @endphp

    <div class="row">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-map"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Lot Tanah</span>
            <span class="info-box-number"> {{ $bilot }} </span>
          </div>
        <!-- /.info-box-content -->
        </div>
          <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-map-signs"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">PTP</span>
            <span class="info-box-number">{{ $ptp }}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <!-- fix for small devices only -->
      <div class="clearfix hidden-md-up"></div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-map-pin"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Bukan PTP</span>
            <span class="info-box-number">{{ $rizab + $felda + $felcra + $kesedar + $lada }}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-exclamation"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Isu Tanah</span>
            <span class="info-box-number">80</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Maklumat Tanah Negeri</h5>
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
                    <div class="col-md-12">
                      
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8">
                      <p class="text-center"><strong>Senarai Lot Tanah</strong></p>
                      <div id="regions_div"></div>
                    </div>
                    <div class="col-md-4">
                      <table class="table table-striped table-sm">
                          <thead>
                              <tr>
                                  <th width="25%">Negeri</th>
                                  <th width="25%" class="text-right">Bilangan</th>
                              </tr>
                          </thead>
                          <tbody>
                              @php
                                  $gtotal=0;
                              @endphp
                              @foreach ($bchart as $ngls)
                                <tr>
                                    <td>{{ $ngls->neg_nama_negeri }}</td>
                                    <td class="text-right">{{ $ngls->BIL }}</td>
                                </tr>
                                @php
                                    $gtotal += $ngls->BIL;
                                @endphp
                              @endforeach
                          </tbody>
                          <tfoot>
                              <tr>
                                  <th>Jumlah</th>
                                  <th class="text-right">{{ $gtotal }}</th>
                              </tr>
                          </tfoot>
                      </table>

                    </div>
                  </div>
                  <!-- /.row -->
                </div>
                <!-- ./card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-12">
          <div class="card">
              <div class="card-header">
                  <h5 class="card-title">Maklumat Tanah Mengikut Program</h5>
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
                  <div class="col-md-12">
                      <p class="text-center">
                      {{-- <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong> --}}
                      </p>

                      <div class="chart">
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                      </div>
                      <!-- /.chart-responsive -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
          </div>
          <!-- /.card -->
      </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <div class="col-md-6">
        <!-- /.col -->
        <div class="card-body">
          <p class="text-center">
          <strong>Jenis Hakmilik</strong>
          </p>

          <div class="progress-group">
            PTP
            <span class="float-right"><b>{{$ptp}}</b>/{{$bilot}}</span>
            <div class="progress progress-sm">
                <div class="progress-bar bg-primary" style="width: {{ $ptp/$bilot*100 }}%"></div>
            </div>
          </div>
          <!-- /.progress-group -->

          <div class="progress-group">
            Rizab Negeri
            <span class="float-right"><b>{{$rizab}}</b>/{{$bilot}}</span>
            <div class="progress progress-sm">
                <div class="progress-bar bg-danger" style="width: {{ $rizab/$bilot*100 }}%"></div>
            </div>
          </div>
          <!-- /.progress-group -->
          <div class="progress-group">
              FELDA
              <span class="float-right"><b>{{$felda}}</b>/{{$bilot}}</span>
              <div class="progress progress-sm">
                  <div class="progress-bar bg-warning" style="width: {{ $felda/$bilot*100 }}%"></div>
              </div>
          </div>
          <div class="progress-group">
              FELCRA
              <span class="float-right"><b>{{$felcra}}</b>/{{$bilot}}</span>
              <div class="progress progress-sm">
                  <div class="progress-bar bg-success" style="width: {{ $felcra/$bilot*100 }}%"></div>
              </div>
          </div>
          <div class="progress-group">
              KESEDAR
              <span class="float-right"><b>{{$kesedar}}</b>/{{$bilot}}</span>
              <div class="progress progress-sm">
                  <div class="progress-bar bg-primary" style="width: {{ $kesedar/$bilot*100 }}%"></div>
              </div>
          </div>
          <div class="progress-group">
              LADA
              <span class="float-right"><b>{{$lada}}</b>/{{$bilot}}</span>
              <div class="progress progress-sm">
                  <div class="progress-bar bg-success" style="width: {{ $lada/$bilot*100 }}%"></div>
              </div>
          </div>
          <!-- /.progress-group -->
      </div>
      <!-- /.col -->
        <!-- /.card -->
      </div>
      <!-- /.col -->

      <div class="col-md-6">
        <div class="card-body">
          <p class="text-center">
            <strong>Pengisian Fasiliti</strong>
          </p>
          <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
@section('js')
  <script src="{{ asset('/template/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
  <script src="{{ asset('/template/plugins/raphael/raphael.min.js') }}"></script>
  <script src="{{ asset('/template/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
  <script src="{{ asset('/template/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
  <!-- ChartJS -->
  <script src="{{ asset('/template/plugins/chart.js/Chart.min.js') }}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset('/dist/js/pages/dashboard2.js') }}"></script>
  <script>
    $(function () {
      /* ChartJS
       * -------
       * Here we will create a few charts using ChartJS
       */


      var areaChartData = {
        labels  : {!! json_encode($xdata) !!},
        datasets: [
          {
            label               : 'Tanah',
            backgroundColor     : 'rgba(124,0,165,1)',
            borderColor         : 'rgba(124,0,165,1)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(124,0,165,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(124,0,165,1)',
            data                : {!! json_encode($ydata) !!}
          },
        ]
      }

    var donutData  = {
        labels: [
            'Ada Fasiliti',
            'Kosong',
        ],
        datasets: [
          {
            data: [{{ $ada }}, {{ $xada }}],
            backgroundColor : ['#00a65a','#f56954'],
          }
        ]
      }

      //-------------
      //- PIE CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
      var pieData        = donutData;
      var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      })

      //-------------
      //- BAR CHART -
      //-------------
      var barChartCanvas = $('#barChart').get(0).getContext('2d')
      var barChartData = $.extend(true, {}, areaChartData)
      // var temp0 = areaChartData.datasets[0]
      var temp1 = areaChartData.datasets[0]
      barChartData.datasets[0] = temp1
      // barChartData.datasets[1] = temp0

      var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false
      }

      new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      })

    })
  </script>

@endsection
