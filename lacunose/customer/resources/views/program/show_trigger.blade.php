<div class="table-responsive">
  <table class="table table-bordered table-hover table-sm">
    <tr>
      <td>Saat</td>
      <td>{{ $data['data']['ux_trigger_event'] }}</td>
    </tr>
    <tr>
      <td>Dengan</td>
      <td>{{ $data['data']['ux_trigger_param'] }} = {{ $data['data']['trigger_value'] }}</td>
    </tr>
    <tr>
      <td>Berlaku hingga kelipatan</td>
      <td>{{ $data['data']['trigger_loop'] }}</td>
    </tr>
  </table>
</div>