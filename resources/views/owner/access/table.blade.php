@inject('idr', '\Lacunose\Subscribe\Libraries\UI\IDRTranslator')
@inject('date', '\Lacunose\Subscribe\Libraries\UI\DateTimeTranslator')

<div class="table-responsive text-center">
  <table class="table table-bordered table-hover">
    <thead>
      <th>No</th>
      <th>Nama</th>
      <th>Wewenang</th>
      <th>&nbsp;</th>
    </thead>
    <tbody>
      @forelse($data['accesses'] as $k => $v)
        <tr>
          <td>{{ $data['accesses']->firstItem() + $k }}</td>
          <td>
              <h3>{{ $v['user'] ? $v['user']['name'] : '-' }}</h3>
              <small>{{ $v['email'] }}</small><br/>
              <small>{{ $v['role'] }} sejak <i>{{ $v['accepted_at'] ? $date->formatDateTo($v['accepted_at']) : '-' }}</i></small>
              <hr/>
              <h6>Endpoint</h6>
              @foreach($v->endpoints as $p)
                <small class="badge badge-primary">{{$p['ux_name']}}</small>&nbsp;
              @endforeach
              <hr/>
              <h6>Klien</h6>
              @foreach($data['opsi']['clients'] as $idx => $client)
                  @if(!empty($v['clients']) && in_array($idx, $v['clients']))
                    <small class="badge badge-primary">{{ $client }}</small>&nbsp;
                  @else
                    <small class="badge badge-secondary">{{ $client }}</small>&nbsp;
                  @endif
              @endforeach
          </td>
          <td class="text-left">
            @foreach($data['opsi']['scopes'] as $dt)
            @php
              $show = false;
              foreach ($dt['scopes'] as $a => $b) {
                if(in_array($a, $data['data']['scopes'])){
                  $show = true;
                }
              }
            @endphp
            @if ($show)
              <div class="row">
                <div class="col">
                  <h5>{{ $dt['domain'] }}</h5>
                </div>
              </div>
              <div class="row">
                @foreach($dt['scopes'] as $idx => $scope)
                <div class="col-4">
                  @if(!empty($v['scopes']) && in_array($idx, $v['scopes']))
                    <small class="badge badge-primary">{{ $scope }}</small>&nbsp;
                  @else
                    <small class="badge badge-secondary">{{ $scope }}</small>&nbsp;
                  @endif
                </div>
              @endforeach
              </div>
              @if (!end($data['data']))   
              <hr/>
              @endif

            @endif
            @endforeach
          </td>
          <td class="text-center">
            <a class="btn btn-primary mb-2 btn-sm rounded-0" href="{{ route('owner.access.show', ['id' => $v['website'], 'email' => $v['email']]) }}">EDIT</a>
            <a class="btn btn-danger btn-sm rounded-0" href="{{ route('owner.access.delete', ['id' => $v['website'], 'email' => $v['email']]) }}">NONAKTIFKAN</a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4">Tidak ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

