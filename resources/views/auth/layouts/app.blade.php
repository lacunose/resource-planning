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
  </head>
  <body>
    <!-- Loader -->
    <div id="preloader"><div id="status"><div class="spinner"></div></div></div>
    <div class="wrapper-page">
      @yield('content')
      <div class="m-t-40 text-center text-white-50">
        @stack('footer')
        <p class="text-muted">{{env('APP_NAME')}} © 2020 <span class="d-none d-md-inline-block"> by <a href="https://thunderlab.id" class="text-primary" target="__blank"> THUNDERLAB </a>.</span></p>
        </div>
    </div>

    <!-- jQuery  -->
    <script src="{{ asset('dashboard/js/plugins.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('dashboard/js/apps.js') }}"></script>    
    @stack('js')
  </body>
</html>