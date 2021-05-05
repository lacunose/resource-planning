@inject('idr', '\Lacunose\Customer\Libraries\UI\IDRTranslator')

@extends('dashboard.layouts.app')

@section('title')
  <h4 class="page-title">{!! $data['infos']['title'] !!}</h4>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="clearfix">&nbsp;</div>
      {!! Form::open(['url' => route('tcust.report.log', request()->segment(4)), 'class' => 'mb-3', 'method' => 'get']) !!}
        <div class="row">
           <div class="col">
            <div class="input-group">
              {!! Form::date('filter[date_gte]', isset(request()->get('filter')['date_gte']) ? request()->get('filter')['date_gte'] : null, ['class' => 'form-control', 'placeholder' => 'To', 'max' => now()->format('Y-m-d')]) !!}
              {!! Form::date('filter[date_lte]', isset(request()->get('filter')['date_lte']) ? request()->get('filter')['date_lte'] : null, ['class' => 'form-control', 'placeholder' => 'From', 'max' => now()->format('Y-m-d')]) !!}
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
    <div class="card-body">
      @include('tcust::log.table')
    </div>
    @if($data['logs']->withQueryString()->hasPages())
      <div class="card-footer">
        {!! $data['logs']->withQueryString()->links('tcust::components.paginate') !!}
      </div>
    @endif
  </div>
@endsection

<!-- !IMPORTANT: NEED PLUGIN SELECT2! -->
@push('css')
<style>
  .dropdown-toggle.no-caret::after {
    content: none;
  }
</style>
@endpush

@push('js')
<script>
  $("input[name='filter[date_gte]']").change(function() {
    $("input[name='filter[date_lte]']").attr({'min': $(this).val()});
  })
</script>
@endpush