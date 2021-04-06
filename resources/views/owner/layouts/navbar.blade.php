<nav id="navigation" class="navbar navbar-expand-lg p-1" style="display: flex;">
  <a class="navbar-brand mr-5 d-none d-md-block" href="{{ route('dashboard') }}">
    <img src="{{config()->get('web.logo-invert')}}" alt="" height="45" class="logo-small"> 
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
    <i class="fa fa-bars"></i>
    {{-- <span class="navbar-toggler-icon"></span> --}}
  </button>
  <div class="collapse navbar-collapse ml-5" id="main_nav">
    <ul class="navbar-nav navigation-menu">
    @foreach(Auth::user()->subs as $v)
      <li class="has-submenu">
      <a href="#">{{$v['website']}} <i class="mdi mdi-chevron-down mdi-drop"></i></a>
        <ul class="submenu text-center">
          <li><a href="{{ route('owner.subscription.get', ['id' => $v['website']]) }}">TAGIHAN</a></li>
          @if(in_array($v['membership'], ['professional']))
          <li><a href="{{ route('owner.endpoint.get', ['id' => $v['website']]) }}">ENDPOINT</a></li>
          <li><a href="{{ route('owner.access.get', ['id' => $v['website']]) }}">AKSES</a></li>
          <li><a href="{{$v['ux_website']}}">DASHBOARD</a></li>
          @endif
        </ul>
      </li>
    @endforeach
    <li><a href="{{ route('subscribing') }}">____.{{ env('APP_BASE', 'localhost') }}</a></li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <!-- User-->
      <li class="list-inline-item dropdown notification-list">
        <a class="nav-link dropdown-toggle arrow-no" data-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" aria-expanded="false">
          <span class="ml-1 text-uppercase"> {{Auth::user()->name}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
          <form action="{{route('logout')}}" method="post" class="mb-0">
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
  </div> <!-- navbar-collapse.// -->
</nav>