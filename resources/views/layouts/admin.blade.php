
<html lang="en" style="height: auto;">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Dashboard</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<link rel="stylesheet" href="{{asset('admin-dist/css/adminlte.min.css')}}">

<script src="{{asset('admin-dist/js/adminlte.js')}}" defer></script>


<link rel="stylesheet" href="{{asset('admin-plugins/fontawesome-free/css/all.min.css')}}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href=" {{asset('admin-plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<!-- iCheck -->
<link rel="stylesheet" href="{{asset('admin-plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
<!-- JQVMap -->
<link rel="stylesheet" href="{{asset('admin-plugins/jqvmap/jqvmap.min.css')}}">
<!-- Theme style -->
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{asset('admin-plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{asset('admin-plugins/daterangepicker/daterangepicker.css')}}">
<!-- summernote -->
<link rel="stylesheet" href="{{asset('admin-plugins/summernote/summernote-bs4.css')}}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('admin-plugins/toastr/toastr.min.css')}}">



  <link rel="stylesheet" href="{{asset('css/app.css')}}" >

 <link id="noteanywherecss" media="screen" type="text/css" rel="stylesheet" href="data:text/css,.note-anywhere%20.closebutton%7Bbackground-image%3A%20url%28chrome-extension%3A//bohahkiiknkelflnjjlipnaeapefmjbh/asset/deleteButton.png%29%3B%7D%0A">

 {{-- summer note --}}
 <link rel="stylesheet" href="{{asset('admin-plugins/summernote/summernote-bs4.css')}}">


 <!-- Select2 -->
 <link rel="stylesheet" href="{{asset('admin-plugins/select2/css/select2.min.css')}}">
 <link rel="stylesheet" href="{{asset('admin-plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js-bootstrap-css/1.2.1/typeaheadjs.min.css">


<link href="{{asset('assets/lightbox/dist/css/lightbox.css')}}" rel="stylesheet" />

<link href="{{asset('admin-plugins/chartist-js-master/dist/chartist.css')}}" rel="stylesheet" />

<script src="{{asset('assets/lightbox/dist/js/lightbox.js')}}"></script>



<style>
  .note-editor.note-frame{
    width: 100%;
  }
  .navbar-badge{
    right: -5px;
    top: 10px;
    font-size: 10px;
  }
  .notification-icon{
    font-size: 16px;
  }
  .dropdown-menu{
    padding: 0;
  }
  .loading-btn{
    min-height: 28px;
    min-width: 70px;
  }

  .router-link-exact-active{
    background-color: #007bff;
    color: #fff !important;
    }
  .router-link-exact-active:hover{
    background-color: #0095ff !important;
    color: #fff !important;
  }
  [class*=sidebar-dark-] .nav-sidebar>.nav-item.menu-open>.nav-link, [class*=sidebar-dark-] .nav-sidebar>.nav-item:hover>.nav-link, [class*=sidebar-dark-] .nav-sidebar>.nav-item>.nav-link:focus{
      background-color: #0095ff !important;
      color: #fff !important;

    }
</style>


  @yield('styles')

@stack('style')
</head>
<body class="sidebar-mini fixed " style="height: auto;">
<div class="wrapper" id="admin" >

  {{--  @include('layouts.partials.swals')  --}}


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      {{--  <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>  --}}
    </ul>

    <!-- SEARCH FORM -->
    {{--  <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>  --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto" id="vue-notification" >
      <!-- Messages Dropdown Menu -->
      {{--  <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments notification-icons"></i>
          <span class="badge badge-danger navbar-badge">5</span>
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a v-for="message in messages" :href="'/'+base_url+'/messages/'+message.id" class="dropdown-item"  >
            <!-- Message Start -->
            <div class="media">

              <img v-if="message.photo" :src="'{{asset('images/profile_images')}}/'+message.photo" alt="User Avatar" class="img-size-50 mr-3 img-circle">

              <img v-else src="{{asset('img/no-image-found.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">


              <div class="media-body">
                <h3 class="dropdown-item-title">
                  @{{message.name}}

                </h3>
                <p class="text-sm" v-if="message.last_message && message.last_message.message" >@{{message.last_message.message.substr(0, 20)}}</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> @{{ message.last_message.time }}</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>

          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>  --}}
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link notification-icon" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">5</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notification-drop ">
          <span class="dropdown-header">5 Notifications</span>
          <div class="dropdown-divider"></div>

          <div>
          <a class="dropdown-item notification_rows">
            <div class="notification-title">
              <i class="fas fa-bell mr-2"></i> TITLE
            </div>
            {{--  <div class="float-right text-muted text-sm">BODY</div>  --}}
          </a>
          <div class="dropdown-divider"></div>
        </div>
          {{--  <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>  --}}
        </div>
      </li>
      {{--  <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i class="fas fa-th-large"></i></a>
      </li>  --}}
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">

      <img src="/images/GEARZ.png" alt="AdminLTE Logo" class="brand-image  elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Gearz</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          {{--  <img src="@if(auth()->user()->photo) {{asset('images/admin/'.auth()->user()->photo)}} @else {{asset('img/no-image-found.jpg')}} @endif"  class="img-circle elevation-2" alt="User Image" style="width: 50px;">  --}}
        </div>
        <div class="info" style="display: flex; align-items: center;">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               {{--  <!-- {{ strpos(url()->current() , '/admins') ? 'active' : '' }}  -->  --}}
          <li class="nav-item">
            <router-link to="/admin" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/admin/ads" class="nav-link">
              <i class="nav-icon fas fa-clone"></i>
              <p>
                Ads
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/admin/categories" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Categories
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/admin/pages" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Pages
              </p>
            </router-link>
          </li>

            <li class="nav-item">
                <a href="{{route('logout')}}" class="nav-link {{(request()->is('admin/logout*'))? 'active' : ''}}"   onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
            </li>

            {{--  <li class="nav-item">
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                <i class="nav-icon fas fa-power-off"></i>
                <p>
                  Logout
                </p>
              </a>
           </a>

           <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
               @csrf
           </form>

            </li>  --}}

        </ul>
      </nav>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: 211px;">

    <section class="content" >
      <div class="container-fluid admin" >

        <router-view></router-view>

      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  {{--  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>  --}}
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright © 2020 <a href="#">Gearz</a>.</strong>
  </footer>
<div id="sidebar-overlay"></div></div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
{{--  <script src="plugins/jquery/jquery.min.js"></script>  --}}
<!-- Bootstrap 4 -->
{{--  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>  --}}
<!-- AdminLTE App -->
{{--  <script src="dist/js/adminlte.min.js"></script>  --}}

{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> --}}

<script src="{{asset('js/admin.js')}}"  ></script>
<script src="{{asset('js/vendor.js')}}"  ></script>
<script src="{{asset('js/manifest.js')}}"  ></script>

<script src="{{asset('admin-plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<script src="{{asset('admin-plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Toastr -->
<script src="{{ asset('admin-plugins/toastr/toastr.min.js')}}"></script>

<!-- ChartJS -->
<!-- <script src="{{asset('admin-plugins/chart.js/Chart.min.js')}}"></script> -->
<!-- Sparkline -->
<!-- <script src="{{asset('admin-plugins/sparklines/sparkline.js')}}"></script> -->
<!-- JQVMap -->
<!-- <script src="{{asset('admin-plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('admin-plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
--><!-- jQuery Knob Chart -->
<!-- <script src="{{asset('admin-plugins/jquery-knob/jquery.knob.min.js')}}"></script> -->
<!-- daterangepicker -->
<script src="{{asset('admin-plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('admin-plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('admin-plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('admin-plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('admin-plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

<!-- Select2 -->
<script src="{{asset('admin-plugins/select2/js/select2.full.min.js')}}"></script>

<script src="{{asset('admin-plugins/chartist-js-master/dist/chartist.js')}}"></script>

<script src="{{asset('js/typeahead.bundle.js')}}"></script>



<!-- // <script src="{{asset('admin-dist/js/pages/dashboard.js')}}"></script> -->

<!-- AdminLTE for demo purposes -->
<script src="{{asset('admin-dist/js/demo.js')}}"></script>




<script>

  function AskBeforeDelete(id , form){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
          console.log(form)
            $('#'+form).submit();
        }
    })
}




$(function () {
  // Summernote
  $('.textarea').summernote({
    height:250,
  })

  $('.specific-textarea').summernote({
    toolbar: [
      // [groupName, [list of button]]
      //['style', ['bold', 'italic', 'underline', 'clear']],
      //['font', ['strikethrough', 'superscript', 'subscript']],
      //['fontsize', ['fontsize']],
      //['color', ['color']],
      //['height', ['height']]
      ['para', ['ul', 'ol']],
    ]
  })

  $('.select2').select2()

  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4',
    placeholder:'Select From Options',
  })


});





$(document).ready(function() {


  var readURL = function(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#image').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }


  $(".file-upload").on('change', function(){
      readURL(this);
  });

  $("#upload-button").on('click', function() {
     $(".file-upload").click();
  });
});



</script>



@yield('scripts')
@stack('script')






</body>
</html>
