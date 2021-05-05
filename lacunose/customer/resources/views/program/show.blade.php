@extends('dashboard.layouts.app')

@section('title')
  <h4 class="page-title">Lihat Program</h4>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row p-2">
        <div class="col text-left">
          <h5>{{ $data['data']['code'] }} <span class="badge badge-{{$data['data']['ux_status_color']}}">{{$data['data']['ux_status']}}</span></h5>
        </div>
      </div>
    </div>
    <div class="card-body">
       <div class="row p-2">
        <div class="co">
          <div class="form-group">
            <label class="text-muted">Judul</label>
            <h6 class="text-capitalize">{{ $data['data']['title'] }}</h6>
          </div>
        </div>
      </div>

      <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
        <li class="nav-item">
          <a href="#trigger" class="nav-link active" data-toggle="tab" role="tab">Trigger</a>
        </li>
        <li class="nav-item">
          <a href="#target" class="nav-link" data-toggle="tab" role="tab">Target</a>
        </li>
      </ul>
      <div class="tab-content">
        <div id="trigger" class="tab-pane pt-3 active" role="tabpanel">
          @include('tcust::program.show_trigger')
        </div>
        <div id="target" class="tab-pane pt-3" role="tabpanel">
          @include('tcust::program.show_target')
        </div>
      </div>
    </div>
    <div class="card-footer text-right">
      <a href="{{ route('tcust.program.index', ['status' => $data['data']['status'], 'sort[title]' => 'asc']) }}" class="btn btn-secondary rounded-0 ml-2">KEMBALI</a>
      <a href="{{ route('tcust.program.saving', $data['data']['uuid']) }}" class="btn btn-primary rounded-0 ml-2">UBAH</a>
      @if(Str::is('published', $data['data']['status']))
        <a class="btn btn-primary text-white rounded-0 ml-2" data-toggle="modal" data-target=".modal-unpublished">UNPUBLISH</a>
      @else
        <a class="btn btn-primary text-white rounded-0 ml-2" data-toggle="modal" data-target=".modal-published">PUBLISH</a>
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

<div class="modal fade modal-published" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">Publish {{ $data['data']['title'] }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      {!! Form::open(['url' => route('tcust.program.published', $data['data']['uuid']), 'method' => 'post']) !!}
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <div class="form-group">
              {!! Form::label('published_at', 'Mulai') !!}
              {!! Form::date('published_at', $data['data']['published_at'], ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group">
              {!! Form::label('published_until', 'Hingga') !!}
              {!! Form::date('published_until', $data['data']['published_until'], ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary rounded-0">SIMPAN</button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

<div class="modal fade modal-unpublished" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">Unpublish {{ $data['data']['title'] }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      {!! Form::open(['url' => route('tcust.program.unpublished', $data['data']['uuid']), 'method' => 'post']) !!}
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <div class="form-group">
              {!! Form::label('published_until', 'Hingga') !!}
              {!! Form::date('published_until', $data['data']['published_until'], ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary rounded-0">SIMPAN</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>