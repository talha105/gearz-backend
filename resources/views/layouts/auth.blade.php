<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Gearz Admin | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link rel="stylesheet" href="{{asset('css/app.css')}}" >
  <script src="{{asset('js/app.js')}}"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('admin-plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('admin-plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">


  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin-dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">

  {{--  @include('layouts.partials.swals')  --}}


<div class="login-box">
  <div class="login-logo">
    @yield('title')
    {{-- <a href="/"><b>PERFIT </b>ADMIN</a> --}}
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

        @yield('content')

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->



<!-- jQuery -->
{{--  <script src="{{asset('admin-plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin-plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>  --}}
<!-- AdminLTE App -->
<script src="{{asset('admin-plugins/js/adminlte.min.js')}}"></script>

</body>
</html>
