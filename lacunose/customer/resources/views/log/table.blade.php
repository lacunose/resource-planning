@inject('idr', '\Lacunose\Customer\Libraries\UI\IDRTranslator')
@inject('date', '\Lacunose\Customer\Libraries\UI\DateTimeTranslator')

<div class="table-responsive text-center">
  <table class="table table-bordered table-hover">
    <thead>
      <th>No</th>
      <th colspan="2">#</th>
      <th colspan="2">Tanggal</th>
      <th>Saldo Terakhir</th>
      <th>Jumlah</th>
    </thead>
    <tbody>
      @forelse($data['logs'] as $k => $v)
        <tr>
          <td>{{ $data['logs']->firstItem() + $k }}</td>
          <td>{{ $v['no_ref'] }}</td>
          <td>{{ $v['description'] }}</td>
          <td>{{ $date->formatDateTo($v['issued_at']) }}</td>
          <td>
            @if(is_null($v['verified_at']))
              <a href="{{ route('tcust.account.verified', ['id' => $v['account']['uuid'], 'no' => $v['no_ref']]) }}" class="btn btn-primary btn-sm rounded-0 ml-2">VERIFIKASI</a>
            @else
              {{ $date->formatDateTo($v['verified_at']) }}
            @endif
          </td>
          <td class="text-right">{{ $idr->formatMoneyTo($v['previous_balance']) }}</td>
          <td class="text-right">{{ $idr->formatMoneyTo($v['amount']) }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="7">Tidak ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

