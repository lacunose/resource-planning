@inject('date', '\Lacunose\Subscribe\Libraries\UI\DateTimeTranslator')
@extends('owner.layouts.app')

@section('title')
  <div class="row">
    <div class="col-md-8">
      <h4 class="page-title">Tagihan</h4>
    </div>
    <div class="col-md-4 text-right">
      <span class="btn btn-light" data-toggle="modal" data-target=".modal-delete">BERHENTI LANGGANAN</span>
    </div>
  </div>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col">
          <h5>{{ $data['data']['website'] }}</h5>
        </div>
        <div class="col text-right">
          <h6 class="text-capitalize">
            @if($data['data']['is_extendable'])
              <span class="badge badge-primary">Diperpanjang otomatis pada {{ $date->formatDateTo($data['data']['ended_at']) }}</span>
            @else
              <span class="badge badge-warning">Tidak diperpanjang otomatis</span>
            @endif
          </h6>
        </div>
      </div>
    </div>
    <div class="card-body">
      {!! Form::open(['url' => route('owner.subscription.get', request()->segment(2)), 'class' => 'mb-3', 'method' => 'get']) !!}
        <div class="row">
          <div class="col">
            <div class="input-group">
              {!! Form::date('filter[date_gte]', isset(request()->get('filter')['date_gte']) ? request()->get('filter')['date_gte'] : null, ['class' => 'form-control', 'placeholder' => 'To', 'max' => now()->format('Y-m-d')]) !!}
              {!! Form::date('filter[date_lte]', isset(request()->get('filter')['date_lte']) ? request()->get('filter')['date_lte'] : null, ['class' => 'form-control', 'placeholder' => 'From', 'max' => now()->format('Y-m-d')]) !!}
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
        </div>
      {!! Form::close() !!}
      @include('owner.subscription.table')
    </div>
    @if($data['bills']->withQueryString()->hasPages())
      <div class="card-footer">
        {!! $data['bills']->withQueryString()->links('tsub::components.paginate') !!}
      </div>
    @endif
  </div>
@endsection

<div class="modal fade modal-delete" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">
          Berhenti Langganan
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      {!! Form::open(['url' => route('owner.subscription.delete', request()->segment(2)), 'method' => 'delete']) !!}
      <div class="modal-body text-left">
        <p>Layanan Anda akan dinonaktifkan pada tanggal {{ $date->formatDateTo($data['data']['ended_at']) }}. Data Anda akan tetap tersimpan dalam jangka waktu yang ditentukan dalam kebijakan privasi kami.</p>
      </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-danger rounded-0">LANJUTKAN</button>
    </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

<!-- !IMPORTANT: NEED PLUGIN SELECT2! -->
@push('css')
<style>
  .dropdown-toggle.no-caret::after {
    content: none;
  }
</style>
@endpush

@push('js')
<script type="text/javascript">
  $("input[name='filter[date_gte]']").change(function() {
    $("input[name='filter[date_lte]']").attr({'min': $(this).val()});
  })
</script>
@endpush