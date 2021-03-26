<div class="table-responsive text-center">
  <table class="table table-bordered table-hover">
    <thead>
      <th>No</th>
      <th>Nama</th>
      <th>Alamat</th>
      <th>&nbsp;</th>
    </thead>
    <tbody>
      @forelse($data['endpoints'] as $k => $v)
        <tr>
          <td>{{ $data['endpoints']->firstItem() + $k }}</td>
          <td>
              <h3>{{ $v['name'] }}</h3>
              @foreach($v['roles'] as $role)
                <span class="badge badge-primary"> {{ config()->get('tacl.opsi.role')[$role] }} </span>
              @endforeach
          </td>
          <td class="text-left">
            <small>{{ $v['phone'] }}</small> <br/>
            {{ $v['address'] }}
          </td>
          <td>
            <a class="btn btn-danger btn-sm rounded-0 ml-2" href="{{ route('owner.endpoint.delete', ['id' => $v['website'], 'name' => $v['name']]) }}">NONAKTIFKAN</a>
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

