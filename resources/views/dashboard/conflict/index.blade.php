@extends('dashboard.layouts.app')

@section('title')
  <h4 class="page-title">{{ config()->get('management.title.conflict')[request()->segment(3)] }}</h4>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="clearfix">&nbsp;</div>
      {!! Form::open(['url' => route('app.conflict.get', request()->segment(3)), 'class' => 'mb-3', 'method' => 'get']) !!}
        <div class="row">
          <div class="col">
            <div class="input-group">
              {!! Form::text('filter[search]', isset(request()->get('filter')['search']) ? request()->get('filter')['search'] : null, ['class' => 'form-control', 'placeholder' => 'no ref / title']) !!}
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
    <div class="card-body">
      @include('dashboard.conflict.table')
    </div>
    @if($data['datas']->withQueryString()->hasPages())
      <div class="card-footer">
        {!! $data['datas']->withQueryString()->links('dashboard.components.paginate') !!}
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
<script type="text/javascript">
  $("input[name='filter[date_gte]']").change(function() {
    $("input[name='filter[date_lte]']").attr({'min': $(this).val()});
  })
</script>
@endpush