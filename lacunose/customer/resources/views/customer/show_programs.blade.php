@inject('date', '\Lacunose\Customer\Libraries\UI\DateTimeTranslator')
@inject('idr', '\Lacunose\Customer\Libraries\UI\IDRTranslator')

<div class="table-responsive text-center">
  <table class="table table-bordered table-hover">
    <thead>
      <th>Judul</th>
      <th>Periode</th>
      <th>&nbsp;</th>
    </thead>
    <tbody>
      @forelse($data['data']['programs'] as $k => $v)
        <tr>
          <td class="text-left">{{ $v['title'] }}</td>
          <td>
            {{ $date->formatDateTo($v['published_at']) }} s/d {{ $v['published_until'] ? $date->formatDateTo($v['published_until']) : 'sekarang' }}
          </td>
          <td class="text-center">
            @if(in_array($data['data']['status'], ['actived']))
              <a class="btn btn-primary btn-sm rounded-0 ml-2 text-white" href="{{ route('tcust.customer.unprogrammed', ['id' => $data['data']['uuid'], 'unprogram' => [$v['id']]]) }}">HAPUS</a>
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
        <a class="btn btn-primary btn-sm rounded-0 ml-2 text-white" data-toggle="modal" data-target=".modal-program">TAMBAHKAN</a>
    </div>
  </div>
@endif

<div class="modal fade modal-program" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">
          Tambah Program {{ $data['data']['name'] }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      {!! Form::open(['url' => route('tcust.customer.programmed', ['id' => $data['data']['uuid']]), 'method' => 'post']) !!}
      <div class="modal-body text-left">
        <div class="form-group">
          {!! Form::label('program', 'Program') !!}
          {!! Form::select('program[]', [], [], ['class' => 'form-control mid', 'required' => true, 'multiple' => true]) !!}
          @if ($errors->has('program'))
            <span class="invalid-feedback d-block py-1" role="alert">
              {{ $errors->first('program') }}
            </span>
          @endif
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
    $('.modal-program').each(function(i) {
      selectItemFromProgram($(this));
    });
  });

  function selectItemFromProgram(parent) {
    parent.find('select.mid').select2({
      ajax: {
        url: "{{ config('tcust.opsi.program_url') }}",
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
      templateResult: formatItemFromProgram,
      templateSelection: function(item) {
        return item.title || item.text;
      }
    });
  }

  function formatItemFromProgram (item) {
    if (item.loading) {
      return item.title;
    }

    var $container = $(
      "<div class='select2-result-program clearfix'>" +
        "<div class='select2-result-program__avatar'><img src='" + (item.galleries ? item.galleries[0].url : '')+ "' style='max-width:25px;'/></div>" +
        "<div class='select2-result-program__meta'>" +
          "<div class='select2-result-program__title'></div>" +
          "<div class='select2-result-program__statistics'>" +
            "<div class='select2-result-program__publish'><i class='fa fa-calendar'></i> </div>" +
          "</div>" +
        "</div>" +
      "</div>"
    );

    if(item.title) {
      $container.find(".select2-result-program__title").text(item.title);
      $container.find(".select2-result-program__publish").append(item.ux_status);
    }

    return $container;
  }
</script>
@endpush
