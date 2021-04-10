<div class="table-responsive text-center">
  <table class="table table-bordered table-hover">
    <thead>
      <th>No</th>
      <th>Penyebab</th>
      <th>Perbandingan</th>
    </thead>
    <tbody>
      @forelse($data['datas'] as $k => $v)
        <tr>
          <td>{{ $data['datas']->firstItem() + $k }}</td>
          <td class="text-left">
            @if (isset($v->stakes))
              <a href="{!! $v->stakes['callback_url'] !!}" target="__blank">{!! $v->stakes['issue'] !!}</a>
            @endif
          </td>
          <td class="text-left">
            <div class="row">
              @foreach($v->histories as $hist)
                <div class="col">
                  <a href="{!! $hist['callback_url'] !!}" target="__blank">{!! $hist['title'] !!}</a>
                  <br/>
                  <ul>
                    @foreach($hist['compares'] as $compare)
                      @if(!array_diff(Arr::except($compare, ['note', 'ux']), Arr::except($hist['stake'], ['note', 'ux'])))
                        <li><span class="badge badge-warning">{!! $compare['description'] !!}</span></li>
                      @else
                        <li>{!! $compare['description'] !!}</li>
                      @endif
                    @endforeach
                  </ul>
                </div>
              @endforeach
            </div class="row">
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="3">Tidak ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>