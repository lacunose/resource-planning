@inject('idr', '\Lacunose\Acl\Libraries\UI\IDRTranslator')
@inject('date', '\Lacunose\Acl\Libraries\UI\DateTimeTranslator')

@extends('member.layouts.app')

@section('title')
  <h4 class="page-title">DASHBOARD</h4>
@endsection

@section('content')
<div class="table-responsive text-center">
  <table class="table table-bordered table-hover">
    <thead>
      <th>No</th>
      <th>Email</th>
      <th>Website</th>
      <th>Wewenang</th>
      <th>&nbsp;</th>
    </thead>
    <tbody>
      @forelse($data['data'] as $k => $v)
        <tr>
          <td>{{ $v['id'] }}</td>
          <td>{{ $v['email'] }}</td>
          <td>{{ $v['website'] }}</td>
          <td class="text-left">
            @foreach($data['opsi']['scopes'] as $dt)
              @php
                  $show = false;
                  foreach ($dt['scopes'] as $a => $b) {
                    if(in_array($a, $v['scopes'])){
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
        </tr>
      @empty
        <tr>
          <td colspan="4">Tidak ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection

@push('css')
<style>
  .dropdown-toggle.no-caret::after {
    content: none;
  }
</style>
@endpush