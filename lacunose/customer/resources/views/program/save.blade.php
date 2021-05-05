@extends('dashboard.layouts.app')

@section('title')
  <h4 class="page-title">Tambah Program</h4>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <h5>
        {{ $data['data']['title'] ? $data['data']['title'] : 'Untitled' }}
      </h5>
    </div>
    {!! Form::open(['url' => route('tcust.program.saved', ['id' => $data['data']['uuid']]), 'method' => 'post']) !!}
      <div class="card-body">
        @include('tcust::program.fields')
        @include('tcust::program.fields_trigger')
        @include('tcust::program.fields_target')
        <div class="clearfix">&nbsp;</div>
      </div>
      <div class="card-footer text-right">
        <a href="{{ route('tcust.program.index', ['status' => $data['data']['status'], 'sort[code]' => 'asc']) }}" class="btn btn-secondary rounded-0 ml-2">BATAL</a>
        <button type="submit" class="btn btn-primary rounded-0">SIMPAN</button>
      </div>
    {!! Form::close() !!}
  </div>
@endsection
