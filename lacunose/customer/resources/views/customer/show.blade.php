@extends('dashboard.layouts.app')

@section('title')
  <h4 class="page-title">Lihat Anggota</h4>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col text-left">
          <h5>{{ $data['data']['code'] }} <span class="badge badge-{{$data['data']['ux_status_color']}}">{{$data['data']['ux_status']}}</span></h5>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-4">
          <div class="form-group">
            <label class="text-muted">Nama</label>
            <h6 class="text-capitalize">{{ $data['data']['name'] }}</h6>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-muted">Email</label>
            <h6 class="text-capitalize">{{ $data['data']['email'] }}</h6>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="text-muted">Telepon</label>
            <h6 class="text-capitalize">{{ $data['data']['phone'] }}</h6>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4">
          <div class="form-group">
            <label class="text-muted">Nomor Identitas</label>
            <h6 class="text-capitalize">{{ $data['data']['pid'] }}</h6>
          </div>
        </div>
        <div class="col-8">
          <div class="form-group">
            <label class="text-muted">Address</label>
            <h6 class="text-capitalize">{{ $data['data']['address'] }}</h6>
          </div>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
        <li class="nav-item">
          <a href="#programs" class="nav-link active" data-toggle="tab" role="tab">Program</a>
        </li>
        <li class="nav-item">
          <a href="#marks" class="nav-link" data-toggle="tab" role="tab">Preferensi</a>
        </li>
      </ul>
      <div class="tab-content">
        <div id="programs" class="tab-pane pt-3 active" role="tabpanel">
          @if(in_array($data['data']['status'], ['actived']))
            @include('tcust::customer.show_programs')
          @else
            Hanya tersedia untuk pengguna aktif
          @endif
        </div>
        <div id="marks" class="tab-pane pt-3" role="tabpanel">
          @if(in_array($data['data']['status'], ['actived']))
            @include('tcust::customer.show_marks')
          @else
            Hanya tersedia untuk pengguna aktif
          @endif
        </div>
      </div>
    </div>

    <div class="card-footer text-right">
        <a href="{{ route('tcust.customer.index', ['status' => $data['data']['status'], 'sort[code]' => 'asc']) }}" class="btn btn-secondary rounded-0 ml-2">KEMBALI</a>

        @if(in_array($data['data']['status'], ['inactived']))
          <a href="{{ route('tcust.customer.updating', ['id' => $data['data']['uuid']]) }}" class="btn btn-primary rounded-0 ml-2">UBAH</a>
          <a href="{{ route('tcust.customer.activated', ['id' => $data['data']['uuid']]) }}" class="btn btn-primary rounded-0 ml-2">AKTIFKAN</a>
        @else
          <a href="{{ route('tcust.customer.inactivated', ['id' => $data['data']['uuid']]) }}" class="btn btn-primary rounded-0 ml-2">NONAKTIFKAN</a>
        @endif
    </div>
  </div>
@endsection

@push('css')
<style>
  .dropdown-toggle.no-caret::after {
    content: none;
  }
</style>
@endpush