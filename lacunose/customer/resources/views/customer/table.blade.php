<div class="table-responsive text-left">
  <table class="table table-bordered">
    <thead>
      <th>No</th>
      <th>Kode</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Telepon</th>
      <th>&nbsp;</th>
    </thead>
    <tbody>
      @forelse($data['datas'] as $k => $v)
        <tr>
          <td class="text-center">{{ $data['datas']->firstItem() + $k }}</td>
          <td>
            {{ $v['code'] }}
          </td>
          <td>
            {{ $v['name'] }}
          </td>
          <td>
            {{ $v['email'] }}
          </td>
          <td>
            {{ $v['phone'] }}
          </td>
          <td class="text-center">
            <div class="dropdown">
              <a href="#" class="dropdown-toggle btn btn-primary" data-toggle="dropdown">
                MENU
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('tcust.customer.show', ['id' => $v['uuid']]) }}">
                  LIHAT
                </a>

                @if(in_array($v['status'], ['inactived']))
                  <a class="dropdown-item" href="{{route('tcust.customer.updating', ['id' => $v['uuid']])}}">
                    UBAH
                  </a>
                @endif
              </div>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6">Tidak ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>