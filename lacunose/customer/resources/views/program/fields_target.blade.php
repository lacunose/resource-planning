<div class="row">
  <div class="col">
    <div class="form-group">
      {!! Form::label('target_event', 'Lakukan') !!}
      {{ Form::select('target_event', $data['opsi']['target'], $data['data']['target_event'], ['class' => 'form-control', 'id' => 'target_event', 'placeholder' => 'Pilih']) }}
      @if ($errors->has('target_event'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('target_event') }}
        </span>
      @endif
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      {!! Form::label('target_field', 'Dengan') !!}
      {{ Form::select('target_field', [$data['data']['target_field'] => $data['data']['ux_target_field']], $data['data']['target_field'], ['class' => 'form-control', 'id' => 'target_field']) }}
      @if ($errors->has('target_field'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('target_field') }}
        </span>
      @endif
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      {!! Form::label('target_value', 'Sama Dengan') !!}
      {{ Form::text('target_value', $data['data']['target_value'], ['class' => 'form-control']) }}
      @if ($errors->has('target_value'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('target_value') }}
        </span>
      @endif
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      {!! Form::label('target_gain', 'Sebanyak') !!}
      {{ Form::number('target_gain', $data['data']['target_gain'], ['class' => 'form-control']) }}
      @if ($errors->has('target_gain'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('target_gain') }}
        </span>
      @endif
    </div>
  </div>
</div>


@push('js')
<script type="text/javascript">
  $( document ).ready(function() {
    //PRELOAD
    $('#target_event').change(function() {
      changeParamFromTarget($(this));
    });
  });

  function changeParamFromTarget(element) {
    let type    = $(element).find(':selected').val();
    let opt     = {!! json_encode(config()->get('tcust.opsi.field')) !!};

    $('#target_field').text(null);
    $.each( opt[type], function(id, text) {
      $('#target_field').append('<option value="'+id+'"> '+text+' </option>');
    });
  }
</script>
@endpush