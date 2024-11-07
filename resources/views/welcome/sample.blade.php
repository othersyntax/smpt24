@extends('layout.main')
@section('breadcrumb')
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
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>

                <p class="card-text">
                Some quick example text to build on the card title and make up the bulk of the card's
                content.
                </p>
            </div>
        </div>
    
    </section>
@endsection