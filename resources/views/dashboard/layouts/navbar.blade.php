<nav id="navigation" class="navbar navbar-expand-lg p-1" style="display: flex;">
  <a class="navbar-brand mr-5 d-none d-md-block" href="{{ route('dashboard') }}">
    <img src="{{config()->get('tswirl.logo-invert')}}" alt="" height="35" class="logo-small"> 
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
    <i class="fa fa-bars"></i>
    {{-- <span class="navbar-toggler-icon"></span> --}}
  </button>
  <div class="collapse navbar-collapse ml-5" id="main_nav">
    <ul class="navbar-nav navigation-menu">
      @foreach(config()->get('menu.dashboard') as $kv => $nv)
        <li class="nav-item has-megamenu has-submenu">
          <a class="nav-link dropdown-toggle menu-navbar" href="#" data-toggle="dropdown"> {{$kv}}  </a>
          <ul class="dropdown-menu submenu megamenu {{ $kv === 'KEUANGAN' ? 'submenu-right' : '' }}">
            @foreach($nv as $group => $menus)
              <li>
                <ul>
                  <li class="dropdown-item"><strong>{{$group}}</strong></li>
                  <li class="dropdown-divider"></li>
                  @foreach($menus as $menu)
                    @if(in_array($menu['scope'], Auth::user()->scopes))
                      <li><a href="{{route($menu['url'], $menu['param'])}}">{{$menu['title']}}</a></li>
                    @else
                      <li><a class="text-secondary">{{$menu['title']}}</a></li>
                    @endif
                  @endforeach
                </ul>
              </li>
            @endforeach
          </ul>
        </li>
      @endforeach
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