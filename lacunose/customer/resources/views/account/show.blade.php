@inject('date', '\Lacunose\Customer\Libraries\UI\DateTimeTranslator')
@inject('idr', '\Lacunose\Customer\Libraries\UI\IDRTranslator')

@extends('dashboard.layouts.app')

@section('title')
  <h4 class="page-title">Lihat AKUN</h4>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col text-left">
          <h5>{{ $data['data']['no'] }} <span class="badge badge-{{$data['data']['ux_status_color']}}">{{$data['data']['ux_status']}}</span></h5>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row mb-1 mt-2">
        <div class="col">
          <div class="form-group">
            <label class="text-muted">Pemilik</label>
            <h6 class="text-capitalize">{{ $data['data']['customer']['name'] }}</h6>
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label class="text-muted">Currency</label>
            <h6 class="text-capitalize">1 {{ $data['data']['currency'] }} = {{ $data['data']['exchange_rate_to_idr'] }} IDR</h6>
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label class="text-muted">Saldo Pending</label>
            <h6 class="text-capitalize">{{ $idr->formatMoneyTo($data['data']['pending_balance']) }}</h6>
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label class="text-muted">Saldo Verified</label>
            <h6 class="text-capitalize">{{ $idr->formatMoneyTo($data['data']['verified_balance']) }}</h6>
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label class="text-muted">Reset</label>
            <h6 class="text-capitalize">
              {{ $date->formatDateTo($data['data']['resetted_at']) ? $date->formatDateTo($data['data']['resetted_at']) : '' }} <span class="badge badge-warning">setiap {{ $data['data']['ux_reset_period'] }}</span>
            </h6>
          </div>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
        <li class="nav-item">
          <a href="#logs" class="nav-link active" data-toggle="tab" role="tab">Riwayat</a>
        </li>
      </ul>
      <div class="tab-content">
        <div id="logs" class="tab-pane pt-3 active" role="tabpanel">
          @include('tcust::account.show_logs')
        </div>
      </div>
    </div>
    <div class="card-footer text-right">
      @include('tcust::account.show_button')
    </div>
  </div>
@endsection
