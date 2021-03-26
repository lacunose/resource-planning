@inject('idr', '\Lacunose\Subscribe\Libraries\UI\IDRTranslator')
@inject('date', '\Lacunose\Subscribe\Libraries\UI\DateTimeTranslator')

<div class="table-responsive text-center">
  <table class="table table-bordered table-hover">
    <thead>
      <th>No</th>
      <th colspan="3">#</th>
      <th>Tanggal Tagihan</th>
      <th>Total Tagihan</th>
      <th>Tanggal Bayar</th>
    </thead>
    <tbody>
      @forelse($data['bills'] as $k => $v)
        <tr>
          <td>{{ $data['bills']->firstItem() + $k }}</td>
          <td>
            <a href="{{route('tsub.subscription.printing', ['membership' => $v['plan']['membership'], 'id' => $v['plan']['uuid'], 'no' => $v['no']])}}" target="__blank"> 
              {{ $v['no'] }} <span class="badge badge-primary">{{ $v['biller']['website'] }}</span>
            </a>
          </td>
          <td class="text-left">
            {{ $v['ux_period'] }}
          </td>
          <td class="text-left">
            {{ $v['issuer']['period_start'] }} - {{ $v['issuer']['period_end'] }}
          </td>
          <td>{{ $date->formatDateTo($v['issued_at']) }}</td>
          <td class="text-right">{{ $idr->formatMoneyTo($v['ux_bill']) }}</td>
          <td>
            @if(is_null($v['paid_at']))
              <a class="btn btn-primary btn-sm rounded-0 ml-2" href="{{ route('owner.subscription.pay', ['order_id' => $v['no']]) }}">BAYAR</a>
            @else
              {{ $date->formatDateTo($v['paid_at']) }}
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7">Tidak ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
