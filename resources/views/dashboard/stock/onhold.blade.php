@extends('dashboard.layouts.app')

@section('title')
  <h4 class="page-title">Pengaturan Stock On Hold</h4>
@endsection

@section('content')
  <div class="card">
    <div class="card-header text-danger">
      *pengaturan ini mengaktifkan notifikasi ke marketer untuk mencari alternatif
    </div>
    {!! Form::open(['url' => route('app.onhold.post'), 'method' => 'post']) !!}
      <div class="card-body">
        @include('dashboard.stock.fields_onhold')
      </div>
      <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary mb-3 rounded-0">SIMPAN</button>
      </div>
    {!! Form::close() !!}
  </div>
@endsection
