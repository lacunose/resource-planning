@inject('idr', '\Lacunose\Customer\Libraries\UI\IDRTranslator')
@inject('date', '\Lacunose\Customer\Libraries\UI\DateTimeTranslator')

<div class="table-responsive text-center">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">#</th>
        <th rowspan="2" colspan="2">Anggota</th>
        <th rowspan="2">Reset</th>
        <th colspan="2">Saldo</th>
        <th rowspan="2">&nbsp;</th>
      </tr>
      <tr>
        <th>Pending</th>
        <th>Verified</th>
      </tr>
    </thead>
    <tbody>
      @forelse($data['datas'] as $k => $v)
        <tr>
          <td>{{ $data['datas']->firstItem() + $k }}</td>
          <td class="text-left">
            {{ $v['no'] }}
          </td>
          <td class="text-left">
            {{ $v['customer']['name'] }}
          </td>
          <td class="text-left">
            {{ $v['customer']['phone'] }}
          </td>
          <td class="text-right">
            {{ $v['resetted_at'] ? $date->formatDateTo($v['resetted_at']) : '-' }}
          </td>
          <td class="text-right">
            {{ $idr->formatMoneyTo($v['pending_balance']) }}
          </td>
          <td class="text-right">
            {{ $idr->formatMoneyTo($v['verified_balance']) }}
          </td>
          <td class="text-center">
            <div class="dropdown">
              <a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown">
                MENU
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('tcust.account.show', ['id' => $v['uuid']]) }}">
                  LIHAT
                </a>
                <a class="dropdown-item" href="{{route('tcust.account.opening', ['id' => $v['uuid']])}}">
                  UBAH
                </a>
              </div>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8">Tidak ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>