<div class="row">
  <div class="col">
    <div class="form-group">
      {!! Form::label('trigger_event', 'Saat') !!}
      {{ Form::select('trigger_event', $data['opsi']['trigger'], $data['data']['trigger_event'], ['class' => 'form-control', 'id' => 'trigger_event', 'placeholder' => 'Pilih']) }}
      @if ($errors->has('trigger_event'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('trigger_event') }}
        </span>
      @endif
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      {!! Form::label('trigger_param', 'Dengan') !!}
      {{ Form::select('trigger_param', [], [$data['data']['trigger_param'] => $data['data']['ux_trigger_param']], ['class' => 'form-control', 'id' => 'trigger_param']) }}
      @if ($errors->has('trigger_param'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('trigger_param') }}
        </span>
      @endif
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      {!! Form::label('trigger_value', 'Sama Dengan') !!}
      {{ Form::text('trigger_value', $data['data']['trigger_value'], ['class' => 'form-control']) }}
      @if ($errors->has('trigger_value'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('trigger_value') }}
        </span>
      @endif
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      {!! Form::label('trigger_loop', 'Berlaku hingga kelipatan') !!}
      {{ Form::number('trigger_loop', $data['data']['trigger_loop'], ['class' => 'form-control']) }}
      @if ($errors->has('trigger_loop'))
        <span class="invalid-feedback d-block py-1" role="alert">
          {{ $errors->first('trigger_loop') }}
        </span>
      @endif
    </div>
  </div>
</div>

@push('js')
<script type="text/javascript">
  $( document ).ready(function() {
    //PRELOAD
    $('#trigger_event').change(function() {
      changeParamFromTrigger($(this));
    });
  });

  function changeParamFromTrigger(element) {
    let type    = $(element).find(':selected').val();
    let opt     = {!! json_encode(config()->get('tcust.opsi.param')) !!};

    $('#trigger_param').text(null);
    $.each( opt[type], function(id, text) {
      $('#trigger_param').append('<option value="'+id+'"> '+text+' </option>');
    });

  }
</script>
@endpush