<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <title>{{env('APP_NAME')}}</title>
  <meta content="{{env('APP_NAME')}}" name="description" />
  <meta content="hello@thunderlab.id" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  
  <!-- App Icons -->
  <link rel="shortcut icon" href="{{ config()->get('tswirl.favicon') }}">
  
  <!-- App css -->
  <link href="{{ asset('dashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('dashboard/css/icons.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet" type="text/css" />
  <!-- Plugin css -->
  <link href="{{ asset('plugins/alertify/css/alertify.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('plugins/select2/css/select2.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('plugins/alertify/css/alertify.css') }}" rel="stylesheet" type="text/css">
  @stack('css')
</head>
<body>
  
  <!-- Loader -->
  <div id="preloader"><div id="status"><div class="spinner"></div></div></div>
  
  <div class="header-bg pb-0">
    <!-- Navigation Bar-->
    <header id="topnav">
      {{-- <div class="topbar-main">
        <div class="container-fluid">
          <!-- Logo-->
          <div class="d-block d-lg-none mr-5">
            <a href="#" class="logo">
              <img src="{{config()->get('tswirl.logo-invert')}}" alt="" height="50" class="logo-small"> 
            </a>
          </div>
          <!-- End Logo-->
          
          <div class="menu-extras topbar-custom navbar p-0">
            <ul class="list-inline flags-dropdown d-none d-lg-block mb-0">
              <li class="list-inline-item text-white-50 mr-3">
                <span class="font-13">WA : {{config()->get('tswirl.whatsapp')}}</span>
              </li>
            </ul>
            
            <!-- Search input -->
            <div class="search-wrap" id="search-wrap">
              <div class="search-bar">
                <input class="search-input" type="search" placeholder="Search" />
                <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                  <i class="mdi mdi-close-circle"></i>
                </a>
              </div>
            </div>
            
            <ul class="list-inline ml-auto mb-0">
              <!-- User-->
              <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                  <span class="d-none d-md-inline-block ml-1"> {{Auth::user()->name}} <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                  <form action="{{route('logout')}}" method="post">
                    @csrf
                    <button class="dropdown-item" type="submit"><i class="dripicons-exit text-muted"></i> Logout</button>
                  </form>
                </div>
              </li>
              <li class="menu-item list-inline-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle nav-link">
                  <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                  </div>
                </a>
                <!-- End mobile menu toggle-->
              </li>
            </ul>
          </div>
          <!-- end menu-extras -->
          <div class="clearfix"></div>
        </div> <!-- end container -->
      </div> --}}
      <!-- end topbar-main -->
    
      <!-- MENU Start -->
      <div class="navbar-custom">
        <div class="container-fluid">
          <!-- Logo-->
          {{-- <div class="d-none d-lg-block">
            <a href="#" class="logo text-white">
              <img src="{{config()->get('tswirl.logo-invert')}}" alt="" height="50" class="logo-small"> 
            </a>
          </div> --}}
            <!-- End Logo-->
            @include('thunder.layouts.navbar') <!-- end #navigation -->
        </div> <!-- end container -->
      </div> <!-- end navbar-custom -->
    </header>
    <!-- End Navigation Bar-->
  </div>
  
  <div class="wrapper">
    <div class="container-fluid">
      <!-- Page-Title -->
      <div class="row">
        <div class="col-sm-12">
          <div class="page-title-box text-dark pt-1">
            @yield('title')
          </div>
        </div>
      </div>
      <!-- end page title end breadcrumb -->
    </div>
    <div class="container-fluid">
      <div class="clearfix">&nbsp;</div>
      @include('flash::message')
      @yield('content')
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
    </div> <!-- end container-fluid -->
  </div>
  <!-- end wrapper -->
  
  
  <!-- Footer -->
  <footer class="footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          {{env('APP_NAME')}} © 2020 <span class="d-none d-md-inline-block"> by <a href="https://thunderlab.id" class="text-primary" target="__blank"> THUNDERLAB </a>.</span>
        </div>
      </div>
    </div>
  </footer>
  <!-- End Footer -->
  
  <!-- jQuery  -->
  <script src="{{ asset('dashboard/js/plugins.js') }}"></script>
  <!-- App js -->
  <script src="{{ asset('dashboard/js/apps.js') }}"></script>    
  <!-- PLUGINS -->
  <script src="{{ asset('plugins/alertify/js/alertify.js') }}"></script>
  <script src="{{ asset('plugins/number/jquery.number.min.js') }}"></script>
  <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
  <script src="{{ asset('plugins/alertify/js/alertify.js') }}"></script>
  
  @include('plugins.fcmtoken')
  <script type="text/javascript">
    $( document ).ready(function() {
      $('select.s2').select2();
      $("select.s2t").select2({ tags: true });
    });
  </script>
  @stack('js')
</body>
</html>