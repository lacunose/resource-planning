@extends('owner.layouts.app')

@section('title')
  <div class="row">
    <div class="col-md-8">
      <h4 class="page-title">Akses</h4>
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
      {!! Form::open(['url' => route('owner.access.get', request()->segment(2)), 'class' => 'mb-3', 'method' => 'get']) !!}
        <div class="row">
          <div class="col">
            <div class="input-group">
              {!! Form::text('filter[search]', isset(request()->get('filter')['search']) ? request()->get('filter')['search'] : null, ['class' => 'form-control', 'placeholder' => 'no ref / title']) !!}
              {!! Form::select('filter[role]', $data['opsi']['role'], isset(request()->get('filter')['role']) ? request()->get('filter')['role'] : null, ['class' => 'form-control', 'placeholder' => 'role']) !!}
              {!! Form::select('filter[scopes]', $data['opsi']['scope'], isset(request()->get('filter')['scopes']) ? request()->get('filter')['scopes'] : null, ['class' => 'form-control', 'placeholder' => 'wewenang']) !!}
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
    <div class="card-body">
      @include('owner.access.table')
    </div>
    @if($data['accesses']->withQueryString()->hasPages())
      <div class="card-footer">
        {!! $data['accesses']->withQueryString()->links('tsub::components.paginate') !!}
      </div>
    @endif
  </div>
@endsection

<div class="modal fade modal-grant" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">
          Tambah Akses
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
    {!! Form::open(['url' => route('owner.access.post', request()->segment(2)), 'method' => 'post']) !!}
      {!! Form::hidden('website', $data['data']['website'], ['class' => 'form-control']) !!}
      <div class="modal-body text-left">
        <div class="row">
          <div class="col">
            <div class="form-group">
              {!! Form::label('email', 'Email') !!}
              {!! Form::email('email', null, ['class' => 'form-control', 'required' => true]) !!}
              @if ($errors->has('email'))
                <span class="invalid-feedback d-block py-1" role="alert">
                  {{ $errors->first('email') }}
                </span>
              @endif
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              {!! Form::label('role', 'Akses') !!}
              {!! Form::select('role', $data['opsi']['role'], null, ['class' => 'form-control s2t', 'required' => true]) !!}
              @if ($errors->has('role'))
                <span class="invalid-feedback d-block py-1" role="alert">
                  {{ $errors->first('role') }}
                </span>
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group">
              {!! Form::label('endpoints', 'Endpoint') !!}
              {!! Form::select('endpoints[]', $data['opsi']['endpoints'], null,['class' => 'form-control s2', 'required' => true, 'multiple' => 'multiple']) !!}
              @if ($errors->has('endpoints'))
                <span class="invalid-feedback d-block py-1" role="alert">
                  {{ $errors->first('endpoints') }}
                </span>
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group">
              {!! Form::label('clients', 'Client') !!}
              {!! Form::select('clients[]', $data['opsi']['clients'], null,['class' => 'form-control s2', 'required' => true, 'multiple' => 'multiple']) !!}
              @if ($errors->has('clients'))
                <span class="invalid-feedback d-block py-1" role="alert">
                  {{ $errors->first('clients') }}
                </span>
              @endif
            </div>
          </div>
        </div>
        @foreach($data['opsi']['scopes'] as $index => $dt)
          @php
              $show = false;
              foreach ($dt['scopes'] as $a => $b) {
                if(in_array($a, $data['data']['scopes'])){
                  $show = true;
                }
              }
          @endphp

          @if ($show)
          <div class="row">
            <div class="col">   
              <h4 style="display:inline">{{ $dt['domain'] }}</h4>
              <input id="{{$dt['domain']}}" class="ml-3" type="checkbox" name="checkall">
              {!! Form::label('checkall', 'Pilih Semua') !!}
              <hr>
            </div>
          </div>
          @endif
          
          <div class="row">
            @foreach($dt['scopes'] as $idx => $scope)
            
            @if(in_array($idx, $data['data']['scopes']))
              <div class="col-3">
                <div class="form-group">
                  <input id="{{$dt['domain']}}" type="checkbox" name="scopes[]" value="{{$idx}}" >
                  {!! Form::label('scopes[]', $scope) !!}
                  @if ($errors->has('scopes[]'))
                    <span class="invalid-feedback d-block py-1" role="alert">
                      {{ $errors->first('scopes[]') }}
                    </span>
                  @endif
                </div>
              </div>
            @endif
            
            @endforeach
          </div>
        @endforeach
      </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary rounded-0">TAMBAH AKSES</button>
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
  $("#Manajemen").change(function(){
    $("input[name='scopes[]'][id='Manajemen']").prop("checked",$(this).prop("checked"));
  });
  $("#Keuangan").change(function(){
    $("input[name='scopes[]'][id='Keuangan']").prop("checked",$(this).prop("checked"));
  });
  $("#Pembelian").change(function(){
    $("input[name='scopes[]'][id='Pembelian']").prop("checked",$(this).prop("checked"));
  });
  $("#Penjualan").change(function(){
    $("input[name='scopes[]'][id='Penjualan']").prop("checked",$(this).prop("checked"));
  });
  $("#Gudang").change(function(){
    $("input[name='scopes[]'][id='Gudang']").prop("checked",$(this).prop("checked"));
  });
  $("input[name='filter[date_gte]']").change(function() {
    $("input[name='filter[date_lte]']").attr({'min': $(this).val()});
  })
</script>
@endpush