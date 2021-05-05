<div class="row">
  <div class="col">
    <div class="form-group">
      {!! Form::label('title', 'Judul') !!}
      {!! Form::text('title', $data['data']['title'], ['class' => 'form-control', 'required' => true]) !!}
      @if ($errors->has('title'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('title') }}
        </span>
      @endif
    </div>
  </div>
</div>
