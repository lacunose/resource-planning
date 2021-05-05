@inject('idr', '\Lacunose\Finance\Libraries\UI\CurrencyTranslator')

@extends('dashboard.layouts.app')

@section('title')
  <div class="row align-items-center">
    <div class="col-md-8">
      <h4 class="page-title">Pengaturan Anggota</h4>
    </div>
    <div class="col-md-4 text-right">
      <div class="dropdown">
        <button id="btn-add" class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          TAMBAH
        </button>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
          <a class="dropdown-item" href="{{ route('tcust.customer.updating', [$data['data']['uuid']]) }}">MANUAL</a>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="clearfix">&nbsp;</div>
      <ul class="nav nav-tabs" role="tablist">
        @foreach($data['stats']['status'] as $k => $v)
          <li class="nav-item">
            <a href="{{ route('tcust.customer.index', ['status' => $k, 'sort[code]' => 'asc']) }}" class="nav-link
              @if(Str::is(request()->segment(4), $k)) active @endif">{{ $v }}</a>
          </li>
        @endforeach
      </ul>
      <div class="clearfix">&nbsp;</div>
      {!! Form::open(['url' => route('tcust.customer.index', ['status' => request()->segment(4), 'sort[code]' => 'asc']), 'class' => 'mb-3', 'method' => 'get']) !!}
        <div class="input-group">
          {!! Form::text('filter[search]', isset(request()->get('filter')['search']) ? request()->get('filter')['search'] : null, ['class' => 'form-control', 'placeholder' => 'no ref / title']) !!}
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
    <div class="card-body">
      @include('tcust::customer.table')
    </div>
    @if($data['datas']->withQueryString()->hasPages())
      <div class="card-footer text-right">
        {!! $data['datas']->withQueryString()->links('tcust::components.paginate') !!}
      </div>
    @endif
  </div>
@endsection

@push('css')
<style>
  .dropdown-toggle.no-caret::after {
    content: none;
  }
</style>
@endpush
