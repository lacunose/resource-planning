@inject('date', '\Lacunose\Customer\Libraries\UI\DateTimeTranslator')
@inject('idr', '\Lacunose\Customer\Libraries\UI\IDRTranslator')

<div class="table-responsive text-left">
  <table class="table table-bordered">
    <thead>
      <th>No</th>
      <th>Judul</th>
      <th>Periode</th>
      <th>&nbsp;</th>
    </thead>
    <tbody>
      @forelse($data['datas'] as $k => $v)
        <tr>
          <td class="text-center">{{ $data['datas']->firstItem() + $k }}</td>
          <td>
            {{ $v['title'] }}
          </td>
          <td>
            {{ $date->formatDateTo($v['published_at']) }} s/d {{ $v['published_until'] ? $date->formatDateTo($v['published_until']) : 'sekarang' }}
          </td>
          <td class="text-center">
            <div class="dropdown">
              <a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown">
                MORE
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('tcust.program.show', ['id' => $v['uuid']]) }}">
                  LIHAT
                </a>
                @if(in_array($v['status'], ['unpublished']))
                  <a class="dropdown-item" href="{{route('tcust.program.saving', ['id' => $v['uuid']])}}">
                    UBAH
                  </a>
                @endif
              </div>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4">Tidak ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>