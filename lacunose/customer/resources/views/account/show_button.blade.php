<a href="{{ route('tcust.account.index', ['status' => $data['data']['status']]) }}" class="btn btn-secondary rounded-0 ml-2">KEMBALI</a>


@if(in_array($data['data']['status'], ['closed']))
	<a href="{{ route('tcust.account.opening', ['id' => $data['data']['uuid']]) }}" class="btn btn-primary rounded-0 ml-2">UBAH</a>
@else
	<a href="{{ route('tcust.account.closed', ['id' => $data['data']['uuid']]) }}" class="btn btn-danger rounded-0 ml-2">NONAKTIFKAN</a>
@endif

