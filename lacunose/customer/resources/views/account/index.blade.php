@inject('idr', '\Lacunose\Customer\Libraries\UI\IDRTranslator')

@extends('dashboard.layouts.app')

@section('title')
  <div class="row align-items-center">
    <div class="col-md-8">
      <h4 class="page-title">AKUN</h4>
    </div>
    <div class="col-md-4 text-right">
      <a href="{{ route('tcust.account.opening', [request()->segment(3), $data['data']['uuid']]) }}" class="btn btn-light">TAMBAH</a>
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
            <a href="{{ route('tcust.account.index', ['status' => $k]) }}" class="nav-link
              @if(Str::is(request()->segment(3), $k)) active @endif">{{ $v }}</a>
          </li>
        @endforeach
      </ul>
      <div class="clearfix">&nbsp;</div>
      {!! Form::open(['url' => route('tcust.account.index', [request()->segment(3)]), 'class' => 'mb-3', 'method' => 'get']) !!}
        <div class="input-group">
          {!! Form::date('filter[date_gte]', isset(request()->get('filter')['date_gte']) ? request()->get('filter')['date_gte'] : null, ['class' => 'form-control', 'placeholder' => 'To', 'max' => now()->format('Y-m-d')]) !!}
          {!! Form::date('filter[date_lte]', isset(request()->get('filter')['date_lte']) ? request()->get('filter')['date_lte'] : null, ['class' => 'form-control', 'placeholder' => 'From', 'max' => now()->format('Y-m-d')]) !!}
          {!! Form::text('filter[search]', isset(request()->get('filter')['search']) ? request()->get('filter')['search'] : null, ['class' => 'form-control', 'placeholder' => 'no ref / title']) !!}
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
    <div class="card-body">
      @include('tcust::account.table')
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
