<div class="row">
  <div class="col">
    <div class="form-group">
      {!! Form::label('customer_id', 'Anggota') !!}
      {!! Form::select('customer_id', $data['opsi']['customer'], $data['data']['customer_id'], ['class' => 'form-control s2']) !!}
      @if ($errors->has('customer_id'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('customer_id') }}
        </span>
      @endif
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      {!! Form::label('reset_period', 'Periode Reset Akun') !!}
      {!! Form::select('reset_period', $data['opsi']['period'], $data['data']['reset_period'], ['class' => 'form-control']) !!}
      @if ($errors->has('reset_period'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('reset_period') }}
        </span>
      @endif
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      {!! Form::label('currency', 'Currency Akun') !!}
      {!! Form::select('currency', $data['opsi']['currency'], $data['data']['currency'], ['class' => 'form-control']) !!}
      @if ($errors->has('currency'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('currency') }}
        </span>
      @endif
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      {!! Form::label('exchange_rate_to_idr', 'Nilai Tukar Akun (IDR)') !!}
      {!! Form::number('exchange_rate_to_idr', $data['data']['exchange_rate_to_idr'], ['class' => 'form-control', 'required' => true]) !!}
      @if ($errors->has('exchange_rate_to_idr'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('exchange_rate_to_idr') }}
        </span>
      @endif
    </div>
  </div>
</div>
