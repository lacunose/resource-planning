<div id="navigation">
      
  <!-- Navigation Menu-->
  <ul class="navigation-menu">
    @foreach(config()->get('web.thunder_navbar') as $kv => $nv)
      <li class="has-submenu">
        <a href="#">{{$kv}} <i class="mdi mdi-chevron-down mdi-drop"></i></a>
        <ul class="submenu text-center">
          @foreach($nv as $group => $menu)
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
  <!-- End navigation menu -->
</div>