@extends('owner.layouts.app')

@section('title')
  <div class="row">
    <div class="col-md-8">
      <h4 class="page-title">ENDPOINT</h4>
    </div>
    <div class="col-md-4 text-right">
      <span class="btn btn-primary" data-toggle="modal" data-target=".modal-grant">TAMBAH</span>
    </div>
  </div>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="clearfix">&nbsp;</div>
      {!! Form::open(['url' => route('owner.endpoint.get', request()->segment(2)), 'class' => 'mb-3', 'method' => 'get']) !!}
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
      @include('owner.endpoint.table')
    </div>
    @if($data['endpoints']->withQueryString()->hasPages())
      <div class="card-footer">
        {!! $data['endpoints']->withQueryString()->links('tsub::components.paginate') !!}
      </div>
    @endif
  </div>
@endsection

<div class="modal fade modal-grant" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">
          Tambah Endpoint
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
    {!! Form::open(['url' => route('owner.endpoint.post', request()->segment(2)), 'method' => 'post']) !!}
      {!! Form::hidden('website', $data['data']['website'], ['class' => 'form-control']) !!}
      <div class="modal-body text-left">
        <div class="row">
          <div class="col">
            <div class="form-group">
              {!! Form::label('name', 'Nama') !!}
              {!! Form::select('name', [], null, ['class' => 'form-control s2t', 'required' => true]) !!}
              @if ($errors->has('name'))
                <span class="invalid-feedback d-block py-1" role="alert">
                  {{ $errors->first('name') }}
                </span>
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group">
              {!! Form::label('roles[]', 'Fungsi') !!}
              {!! Form::select('roles[]', $data['opsi']['role'], null, ['class' => 'form-control s2', 'required' => true, 'multiple' => true]) !!}
              @if ($errors->has('roles[]'))
                <span class="invalid-feedback d-block py-1" role="alert">
                  {{ $errors->first('roles[]') }}
                </span>
              @endif
            </div>
            <div class="form-group">
              {!! Form::label('phone', 'Telepon') !!}
              {!! Form::text('phone', null, ['class' => 'form-control', 'required' => true]) !!}
              @if ($errors->has('phone'))
                <span class="invalid-feedback d-block py-1" role="alert">
                  {{ $errors->first('phone') }}
                </span>
              @endif
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              {!! Form::label('address', 'Alamat') !!}
              {!! Form::textarea('address', null, ['class' => 'form-control', 'required' => true, 'rows' => 5]) !!}
              @if ($errors->has('address'))
                <span class="invalid-feedback d-block py-1" role="alert">
                  {{ $errors->first('address') }}
                </span>
              @endif
            </div>
          </div>
        </div>
      </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary rounded-0">TAMBAH ENDPOINT</button>
    </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

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