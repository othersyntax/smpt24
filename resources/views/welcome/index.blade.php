@extends('layout.main')
@section('breadcrumb')
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Main Page</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Main Page</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                <h3>150</h3>

                <p>Senarai Tanah</p>
                </div>
                <div class="icon">
                <i class="ion ion-earth"></i>
                </div>
                <a href="#" class="small-box-footer">Selanjutnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                <h3>53</h3>

                <p>PTP</p>
                </div>
                <div class="icon">
                <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Selanjutnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                <h3>44</h3>

                <p>Bukan PTP</p>
                </div>
                <div class="icon">
                <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Selanjutnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                <h3>65</h3>

                <p>Isu Tanah</p>
                </div>
                <div class="icon">
                <i class="ion ion-map"></i>
                </div>
                <a href="#" class="small-box-footer">Selanjutnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
        
                        <p class="card-text">
                        Some quick example text to build on the card title and make up the bulk of the card's
                        content.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

@endsection