<div class="table-responsive text-center">
  <table class="table table-bordered table-hover">
    <thead>
      <th>Tipe</th>
      <th>Produk</th>
      <th>&nbsp;</th>
    </thead>
    <tbody>
      @forelse($data['data']['marks'] as $k => $v)
        <tr>
          <td class="text-left">{{ $v['ux_type'] }}</td>
          <td class="text-left">{{ $v['catalog_name'] }}</td>
          <td class="text-center">
            @if(in_array($data['data']['status'], ['actived']))
              <a class="btn btn-primary btn-sm rounded-0 ml-2 text-white" href="{{ route('tcust.customer.unmarked', ['id' => $data['data']['uuid'], 'unmark' => $v['id']]) }}">HAPUS</a>
            @endif
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

@if(in_array($data['data']['status'], ['actived']))
  <div class="row text-center">
    <div class="col">
        <a class="btn btn-primary btn-sm rounded-0 ml-2 text-white" data-toggle="modal" data-target=".modal-mark">TAMBAHKAN</a>
    </div>
  </div>
@endif

<div class="modal fade modal-mark" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">
          Tambah Preferensi {{ $data['data']['name'] }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      {!! Form::open(['url' => route('tcust.customer.marked', ['id' => $data['data']['uuid']]), 'method' => 'post']) !!}
      <div class="modal-body text-left">
        <div class="row">
          <div class="col">
            <div class="form-group">
              {!! Form::label('marks[type]', 'Tipe') !!}
              {!! Form::select('marks[type]', $data['opsi']['mark'], null, ['class' => 'form-control', 'required' => true]) !!}
              @if ($errors->has('marks[type]'))
                <span class="invalid-feedback d-block py-1" role="alert">
                  {{ $errors->first('marks[type]') }}
                </span>
              @endif
            </div>
            <div class="form-group">
              {!! Form::label('catalog', 'Produk') !!}
              {!! Form::hidden('marks[catalog]', null, ['class' => 'form-control marks', 'required' => true]) !!}
              {!! Form::select('catalog', [], [], ['class' => 'form-control mid', 'required' => true, 'multiple' => true]) !!}
              @if ($errors->has('catalog'))
                <span class="invalid-feedback d-block py-1" role="alert">
                  {{ $errors->first('catalog') }}
                </span>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary rounded-0">KIRIM</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

@push('js')
<script type="text/javascript">
  $( document ).ready(function() {
    //PRELOAD
    $('.modal-mark').each(function(i) {
      selectItemFromMark($(this));
    });
  });

  function selectItemFromMark(parent) {
    let marks   = parent.find('.marks').val() ? JSON.parse(parent.find('.marks').val()) : {};

    parent.find('select.mid').select2({
      ajax: {
        url: "{{ config('tcust.opsi.catalog_url') }}",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          var query = {
            filter: { search: params.term },
            sent_all: true
          }
          return query;
        },
        processResults: function (data) {
          return {
            results: data.data.datas
          };
        }
      },
      placeholder: 'Cari produk',
      minimumInputLength: 3,
      templateResult: formatItemFromMark,
      templateSelection: function(item) {
        if(item.code) {
          marks[item.code] = item.name;
          parent.find('.marks').val(JSON.stringify(marks));
        }

        return item.name || item.text;
      }
    });
  }

  function formatItemFromMark (item) {
    if (item.loading) {
      return item.name;
    }

    var $container = $(
      "<div class='select2-result-mark clearfix'>" +
        "<div class='select2-result-mark__avatar'><img src='" + (item.galleries ? item.galleries[0].url : '')+ "' style='max-width:25px;'/></div>" +
        "<div class='select2-result-mark__meta'>" +
          "<div class='select2-result-mark__title'></div>" +
          "<div class='select2-result-mark__code'></div>" +
          "<div class='select2-result-mark__statistics'>" +
            "<div class='select2-result-mark__unit'><i class='fa fa-tag'></i> </div>" +
          "</div>" +
        "</div>" +
      "</div>"
    );

    if(item.name) {
      $container.find(".select2-result-mark__title").text(item.name);
      $container.find(".select2-result-mark__code").text(item.code);
      $container.find(".select2-result-mark__unit").append(item.unit);
    }

    return $container;
  }
</script>
@endpush
