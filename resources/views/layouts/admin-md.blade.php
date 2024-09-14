<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="HandheldFriendly" content="true" />

  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Gearz Admin</title>
  <!-- Font Awesome -->

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>

  {{--  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />  --}}
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="{{ asset('admin-mdb/css/mdb.min.css')}}" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="{{ asset('admin-mdb/css/admin.css')}}" />

  <link rel="stylesheet" href="{{ asset('css/app.css')}}" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
    crossorigin="anonymous"></script>

    <style>
      .navbar-brand{
        display: block;
        text-align: center;
        width: auto;
        flex-grow: 1;
      }
      .navbar-brand img{
        width: 60px;
        height: 35px;
        object-fit: cover;
      }
    </style>
</head>

<body>
  <!--Main Navigation-->
  <div class="admin" id="admin">
  <header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky h-100" style="overflow: auto">
        <div class="list-group list-group-flush mx-3 mt-4">


          <router-link onclick="closeNav()" to="/admin/dashboard" class="list-group-item list-group-item-action py-2 " aria-current="true">
            <i class="fas fa-tachometer-alt fa-fw me-3" ></i><span>Dashboard</span>
          </router-link>

          @can('view listings')
          <router-link onclick="closeNav()"  to="/admin/listings" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-clone fa-fw me-3" ></i><span>Listings</span>
          </router-link>
          @endcan

          @if(auth()->user()->is_super_admin)
          <router-link onclick="closeNav()"  to="/admin/admins" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-user-shield fa-fw me-3" ></i><span>Admins</span>
          </router-link>
          <router-link onclick="closeNav()"  to="/admin/roles" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-shield-check fa-fw me-3" ></i><span>Roles</span>
          </router-link>
          @endif

          @can('view categories')
          <router-link onclick="closeNav()"  to="/admin/categories" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-list-alt fa-fw me-3" ></i><span>Categories</span>
          </router-link>
          @endcan

          @can('view makes')
          <router-link onclick="closeNav()"  to="/admin/makes" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-random fa-fw me-3" ></i><span>Makes</span>
          </router-link>
          @endcan

          @can('view genre')
          <router-link onclick="closeNav()"  to="/admin/genres" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fad fa-cars fa-fw me-3" ></i><span>Genre</span>
          </router-link>
          @endcan

          @can('view transmission')
          <router-link onclick="closeNav()"  to="/admin/transmissions" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-cogs fa-fw me-3" ></i><span>Transmissions</span>
          </router-link>
          @endcan

          @can('view transmission')
          <router-link onclick="closeNav()"  to="/admin/subscription" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fa-solid fa-bell"></i></i><span>Subscriptions</span>
          </router-link>
          @endcan

          @can('view sellers')
          <router-link onclick="closeNav()"  to="/admin/sellers" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-users fa-fw me-3" ></i><span>Sellers</span>
          </router-link>
          @endcan


          @can('view users')
          <router-link onclick="closeNav()"  to="/admin/users" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-user-friends fa-fw me-3" ></i><span>Users</span>
          </router-link>
          @endcan

          @can('view reviews')
          <router-link onclick="closeNav()"  to="/admin/reviews" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-star fa-fw me-3" ></i><span>Reviews</span>
          </router-link>
          @endcan
          @can('view query')
          <router-link onclick="closeNav()"  to="/admin/queries" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-question fa-fw me-3" ></i><span>Queries</span>
          </router-link>
          @endcan
          <router-link onclick="closeNav()"  to="/admin/profile" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-user-cog fa-fw me-3" ></i><span>Profile</span>
          </router-link>

          @can('view display blocks')
          <router-link onclick="closeNav()"  to="/admin/display-blocks" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-cubes fa-fw me-3" ></i><span>Display Blocks</span>
          </router-link>
          @endcan

          <router-link onclick="closeNav()"  to="/admin/contact-details" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-phone fa-fw me-3" ></i><span>Contact us</span>
          </router-link>

          <router-link onclick="closeNav()"  to="/admin/terms" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-file-alt fa-fw me-3" ></i><span>Terms</span>
          </router-link>

          <router-link onclick="closeNav()"  to="/admin/settings" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-cog fa-fw me-3" ></i><span>Settings</span>
          </router-link>

          @can('view reports')
          <router-link onclick="closeNav()"  to="/admin/reported-listings" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-clone fa-fw me-3" ></i><span>Reported</span>
          </router-link>
          @endcan

          <router-link onclick="closeNav()"  to="/admin/banners" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-images fa-fw me-3" ></i><span>Banners</span>
          </router-link>
          @can('view push notifications')
          <router-link onclick="closeNav()"  to="/admin/push-notifications" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-bell fa-fw me-3" ></i><span>Push Notify</span>
          </router-link>
          @endcan

          <router-link onclick="closeNav()"  to="/admin/logo-update" class="list-group-item list-group-item-action py-2 "  aria-current="true">
            <i class="fas fa-box-check fa-fw me-3" ></i><span>Logo</span>
          </router-link>
          <a href="{{route('logout')}}" class="list-group-item list-group-item-action py-2 "   onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>
                <i class="fas fa-sign-out-alt fa-fw me-3"></i>
                Logout
            </a>
        </div>
      </div>
    </nav>
    <!-- Sidebar -->

    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <!-- Container wrapper -->
      <div class="container-fluid">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
          aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>

        <!-- Brand -->
        <a class="navbar-brand" href="#">
          @if(isset($page) && $page->content)
          <img src="{{ asset('images/'.$page->content) }}" height="25" alt="" loading="lazy"  />
          @else
          <img src="{{ asset('images/GEARZ.png') }}" height="25" alt="" loading="lazy"  />
          @endif

          {{--  <img src="{{asset('images/GEARZ.png')}}" height="25" alt="" loading="lazy" />  --}}
          {{--  <img src="https://mdbootstrap.com/img/logo/mdb-transaprent-noshadows.png" height="25" alt="" loading="lazy" />  --}}
        </a>


        <!-- Right links -->
        <ul class="navbar-nav ms-auto d-flex flex-row">
          <!-- Avatar -->
          {{--  <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#"
              id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
              <img src="https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg" class="rounded-circle" height="22"
                alt="" loading="lazy" />
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="#">My profile</a></li>
              <li><a class="dropdown-item" href="#">Settings</a></li>
              <li><a class="dropdown-item" href="#">Logout</a></li>
            </ul>
          </li>  --}}
        </ul>
      </div>
      <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
  </header>


  <!--Main Navigation-->

  <!--Main layout-->
  <main style="margin-top: 58px">
    <div class="container-fluid pt-1">
        <div class="wrapper">
          <admin-app
            :current_admin="{{ auth()->user() }}"
            :token="{{ json_encode($token) }}"
            :current_admin_permissions="{{ auth()->user()->getAllPermissions()->pluck('name') }}" ></admin-app>
        </div>
    </div>
</main>

</div>

  <!--Main layout-->
  <!-- MDB -->
  <script type="text/javascript" src="{{asset('admin-mdb/js/mdb.min.js')}}"></script>
  <!-- Custom scripts -->
  <script type="text/javascript" src="{{asset('admin-mdb/js/admin.js')}}"></script>

  <script src="{{asset('/js/admin.js')}}"></script>
  <script src="{{asset('/js/manifest.js')}}"></script>
  <script src="{{asset('/js/vendor.js')}}"></script>

  <script>
    function closeNav(){
      if(screen.width < 800){
        const myCollapse = document.getElementById('sidebarMenu')
        const bsCollapse = new mdb.Collapse(myCollapse)
        bsCollapse.hide()
      }
    }
  </script>

</body>

</html>
