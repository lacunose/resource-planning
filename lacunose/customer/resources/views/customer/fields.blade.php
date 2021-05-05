<div class="row">
  <div class="col">
    <div class="form-group">
      {!! Form::label('name', 'Nama') !!}
      {!! Form::text('name', $data['data']['name'], ['class' => 'form-control', 'required' => true]) !!}
      @if ($errors->has('name'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('name') }}
        </span>
      @endif
    </div>
    <div class="form-group">
      {!! Form::label('phone', 'Telepon') !!}
      {!! Form::text('phone', $data['data']['phone'], ['class' => 'form-control', 'required' => true]) !!}
      @if ($errors->has('phone'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('phone') }}
        </span>
      @endif
    </div>
    <div class="form-group">
      {!! Form::label('email', 'Email') !!}
      {!! Form::text('email', $data['data']['email'], ['class' => 'form-control', 'required' => true]) !!}
      @if ($errors->has('email'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('email') }}
        </span>
      @endif
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      {!! Form::label('pid', 'Nomor Identitas') !!}
      {!! Form::text('pid', $data['data']['pid'], ['class' => 'form-control', 'required' => true]) !!}
      @if ($errors->has('pid'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('pid') }}
        </span>
      @endif
    </div>
    <div class="form-group">
      {!! Form::label('address', 'Alamat') !!}
      {!! Form::textarea('address', $data['data']['address'], ['class' => 'form-control', 'required' => true, 'rows' => 5]) !!}
      @if ($errors->has('address'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('address') }}
        </span>
      @endif
    </div>
  </div>
</div>
