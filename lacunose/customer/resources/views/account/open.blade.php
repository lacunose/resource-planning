@extends('dashboard.layouts.app')

@section('title')
  <h4 class="page-title">Tambah AKUN</h4>
@endsection

@section('content')
  <div class="card">
    <div class="card-header text-danger">
      *Keuntungan merupakan informasi tentang tagihan 
    </div>
    {!! Form::open(['url' => route('tcust.account.opened', ['id' => $data['data']['uuid']]), 'method' => 'post']) !!}
      <div class="card-body">
        @include('tcust::account.fields')
        
        <div class="clearfix">&nbsp;</div>

        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
          <li class="nav-item">
            <a href="#logs" class="nav-link active" data-toggle="tab" role="tab">Riwayat</a>
          </li>
        </ul>
        <div class="tab-content">
          <div id="logs" class="tab-pane pt-3 active" role="tabpanel">
            Data tidak dapat diubah
            <!-- @include('tcust::account.show_logs') -->
          </div>
        </div>
      </div>
      <div class="card-footer text-right">
        <a href="{{ route('tcust.account.index', ['status' => $data['data']['status']]) }}" class="btn btn-secondary rounded-0 ml-2">BATAL</a>
        <button type="submit" class="btn btn-primary rounded-0">SIMPAN</button>
      </div>
    {!! Form::close() !!}
  </div>
@endsection
