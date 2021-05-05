<div class="row">
  <label class="col-sm-8 col-form-label">ITEM</label>
  <label class="col-sm-3 col-form-label">STOCK ONHOLD</label>
  <label class="col-sm-1 col-form-label">&nbsp;</label>
</div>

<div class="form-sample">
  @forelse($data['datas'] as $v)
  <div class="row @if($loop->first) form-block @endif">
    <div class="col-sm-8">
      <div class="form-group bmd-form-group is-filled"> 
        <select class="form-control s2" name="onholds[item_code][]" required="true" aria-required="true">
          @foreach($data['opsi']['items'] as $item)
            <option @if($item['code'] == $v['item_code']) selected @endif value="{{$item['code']}}">{{$item['ux_name']}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group bmd-form-group is-filled"> 
        <input class="form-control" name="onholds[hold][]" type="numeric" placeholder="20" value="{{$v['hold']}}" required="true" aria-required="true">
      </div>
    </div>
    <div class="col-sm-1 text-left">
      <div class="form-group bmd-form-group is-filled"> 
         <a class="btn btn-link btn-sm text-danger remove-btn">Hapus</a>
      </div>
    </div>
  </div>
  @empty
  <div class="row form-block">
    <div class="col-sm-8">
      <div class="form-group bmd-form-group is-filled"> 
        <select class="form-control s2" name="onholds[item_code][]" required="true" aria-required="true">
          @foreach($data['opsi']['items'] as $item)
            <option value="{{$item['code']}}">{{$item['ux_name']}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="form-group bmd-form-group is-filled"> 
        <input class="form-control" name="onholds[hold][]" type="numeric" placeholder="20" required="true" aria-required="true">
      </div>
    </div>
    <div class="col-sm-1 text-left">
      <div class="form-group bmd-form-group is-filled"> 
         <a class="btn btn-link btn-sm text-danger remove-btn">Hapus</a>
      </div>
    </div>
  </div>
  @endforelse
</div>
<div class="form-clones">
</div>
<div class="row text-center">
  <label class="col-sm-12 col-form-label text-center"> <a class="btn-link btn-sm text-primary add-more-btn">Tambah</a></label>
</div>

@push('css')
  <link href="/plugins/select2/css/select2.css" rel="stylesheet" type="text/css" />
@endpush

@push('js')
  <script src="/plugins/select2/js/select2.min.js"></script>
  <script type="text/javascript">
    $( document ).ready(function() {
      $('select.s2').select2();
    });

    $('.add-more-btn').click(function() {
      var form = $('.form-sample .form-block');
      form.find('select.s2').select2('destroy');
      var clone = form.clone('.form-block');
      $('.form-clones').append(clone);
      $('select.s2').select2();
    });

    $('.remove-btn').click(function() {
      var clone = $(this).parents('.form-block');
      clone.remove();
    });
  </script>
@endpush
