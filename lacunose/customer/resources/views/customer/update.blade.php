@extends('dashboard.layouts.app')

@section('title')
  <h4 class="page-title">Tambah Anggota</h4>
@endsection

@section('content')
  <div class="card">
    <div class="card-header text-danger">
      *Anggota akan langsung aktif
    </div>
    {!! Form::open(['url' => route('tcust.customer.updated', ['id' => $data['data']['uuid']]), 'method' => 'post']) !!}
      <div class="card-body">
        @include('tcust::customer.fields')
      </div>
      <div class="card-footer text-right">
        <a href="{{ route('tcust.customer.index', ['status' => $data['data']['status'], 'sort[code]' => 'asc']) }}" class="btn btn-secondary rounded-0 ml-2">BATAL</a>
        <button type="submit" class="btn btn-primary rounded-0">SIMPAN</button>
      </div>
    {!! Form::close() !!}
  </div>
@endsection
