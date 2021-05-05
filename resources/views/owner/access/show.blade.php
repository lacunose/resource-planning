@extends('owner.layouts.app')

@section('title')
  <div class="row">
    <div class="col-md-8">
      <h4 class="page-title">Edit Akses</h4>
    </div>
  </div>
@endsection

@section('content')
  <div class="card">
    <div class="m-3">
    {!! Form::open(['url' => route('owner.access.post', request()->segment(2)), 'method' => 'post']) !!}
      {!! Form::hidden('website', $data['data']['website'], ['class' => 'form-control']) !!}
      <div class="text-left">
        <div class="row">
          <div class="col">
            <div class="form-group">
              {!! Form::label('email', 'Email') !!}
              {!! Form::email('email', $data['access']['email'], ['class' => 'form-control', 'required' => true,'readonly']) !!}
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
              {!! Form::select('role', $data['opsi']['role'], $data['access']['role'], ['class' => 'form-control s2t', 'required' => true]) !!}
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
              {!! Form::select('endpoints[]', $data['opsi']['endpoints'], $data['access']->endpoints,['class' => 'form-control s2', 'required' => true, 'multiple' => 'multiple']) !!}
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
              {!! Form::select('clients[]', $data['opsi']['clients'], $data['access']['clients'],['class' => 'form-control s2', 'required' => true, 'multiple' => 'multiple']) !!}
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
                  <input id="{{$dt['domain']}}" type="checkbox" @if(!is_null($data['data']['scopes']) && in_array($idx, $data['access']['scopes'])) checked="true" @endif name="scopes[]" value="{{$idx}}" >
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
      <button type="submit" class="btn btn-primary rounded-0">SIMPAN</button>
    </div>
      {!! Form::close() !!}
    </div>
  </div>
  @endsection
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
    </script>
  @endpush