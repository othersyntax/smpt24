<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/template/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="shortcut icon" href="{{ asset('/template/dist/img/favicon.ico') }}">
  @yield('custom-css')
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/template/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/template/dist/css/customstyle.css') }}">
</head>
<body class="sidebar-mini layout-fixed layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    @include('layout.topmenu')

    @include('layout.top-right-menu')
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-indigo elevation-4" style="background: #14001a">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('/template/dist/img/brand_logo_bg.png') }}" alt="eSMPT Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">eSMPT</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{  asset('storage/'.session('loginImage')) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/profile/papar" class="d-block">{{ session('loginName') }}</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      @include('layout.menu')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    {{-- Breadcrumb --}}
    @yield('breadcrumb')

    <!-- Main content -->
    <section class="content">
      @if (session()->has('msg'))
        <div class="row card">
            <div class="col-md-12 card-body" id='msg' style="background-color: rgb(146, 248, 189);">
                <div class="text-white">
                    {{ session('msg') }}
                </div>
            </div>
        </div>
      @endif
      <div class="container-fluid">
      @yield('content')
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Versi</b> 2.0
    </div>
    <strong>Hakcipta &copy; {{ date('Y') }} <a href="#">SMPT</a>.</strong> Bahagian Pembangunan.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('/template/plugins/jquery/jquery.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('/template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/template/dist/js/adminlte.js') }}"></script>
@yield('js')
<script>
  setTimeout(() => {
    $('#msg').hide('slow');
  }, 3000);
</script>
</body>
</html>
