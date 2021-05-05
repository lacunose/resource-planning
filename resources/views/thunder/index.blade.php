@inject('idr', '\Lacunose\Acl\Libraries\UI\IDRTranslator')
@inject('date', '\Lacunose\Acl\Libraries\UI\DateTimeTranslator')

@extends('thunder.layouts.app')

@section('title')
  <h4 class="page-title">DASHBOARD</h4>
@endsection

@section('content')
  <div class="row align-items-stretch">
    @foreach($data['cards'] as $card)
      @if(Str::is('aging', $card['mode']))
        <div class="col-8 mb-4">
          <div class="card messages h-100">
            <div class="card-body">
              <h4 class="mt-0 header-title">{{$card['title']}}</h4>
              <nav class="mt-4">
                <div class="nav nav-tabs latest-messages-tabs nav-justified" id="nav-tab" role="tablist">
                  @foreach($card['catalogs'] as $dt)
                    <a class="nav-item nav-link @if($loop->first) active @endif" id="nav-{{$dt['uuid']}}-tab" data-toggle="tab" href="#nav-{{$dt['uuid']}}" role="tab" aria-controls="nav-{{$dt['uuid']}}" aria-selected="true">
                        <h4 class="mt-0">{{$dt['documents_count']}}</h4>
                        <p class="text-muted mb-0">{{$dt['name']}}</p>
                    </a>
                  @endforeach
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                @foreach($card['catalogs'] as $dt)
                  <div class="tab-pane fade show @if($loop->first) active @endif" id="nav-{{$dt['uuid']}}" role="tabpanel" aria-labelledby="nav-{{$dt['uuid']}}-tab">
                    <div class="p-2 mt-2">
                      <ul class="list-unstyled latest-message-list mb-0">
                        @php $total = 0; @endphp
                        @foreach($dt['documents'] as $doc)
                          <li class="message-list-item">
                            <div class="media">
                              <div class="media-body">
                                  <h6 class="mt-0">{{$doc['catalog']['code']}}</h6>
                                  <p class="time text-muted">
                                    {{ $idr->formatMoneyTo($doc['total']) }}
                                    &emsp;
                                    <a class="text-primary" href="{{route('laporan.sales', ['filter[catalog_id]' => $doc['catalog_id'], 'filter[Price_id]' => $doc['price_id']])}}" target="__blank">
                                      <i class="fa fa-arrow-right"></i>
                                    </a>
                                  </p>
                              </div>
                            </div>
                          </li>
                          @php $total = $total + $doc['total']; @endphp
                        @endforeach
                      </ul>
                    </div>
                    <div>
                      <ul class="list-unstyled latest-message-list mb-0">
                        <li class="message-list-item bg-light">
                          <div class="media">
                            <div class="media-body">
                                <h6 class="p-2 mt-0">Total aging {{$dt['name']}}</h6>
                                <p class="p-2 time text-muted">{{ $idr->formatMoneyTo($total) }}</p>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      @else
        <div class="col-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <h4 class="mt-0 header-title">{{$card['title']}}</h4>
              <div class="p-2">
                  <ul class="list-unstyled rec-acti-list mb-0">
                      @foreach($card['docs'] as $doc)
                        <li class="rec-acti-list-item">
                          <div>
                            <p class="text-muted mb-0">{{$date->formatDateTo($doc['date'])}}</p>
                            <h6 class="mb-0">{{$doc['group']}}</h6>
                            <div class="delete-icon">
                              <p class="text-muted mb-0">
                                {{$idr->formatMoneyTo($doc['total'])}}
                                &emsp;
                                @if(Str::is('settled', $doc['status']))
                                  <a class="text-primary" href="{{route('document.locking', ['cause' => $doc['cause'], 'id' => $doc['uuid']])}}" target="__blank">
                                    <i class="fa fa-check"></i>
                                  </a>
                                @else
                                  <a class="text-primary" href="{{route('document.settling', ['cause' => $doc['cause'], 'id' => $doc['uuid']])}}" target="__blank">
                                    <i class="fa fa-check"></i>
                                  </a>
                                @endif
                              </p>
                            </div>
                          </div>
                        </li>
                      @endforeach
                  </ul>
              </div>
            </div>
          </div>
        </div>
      @endif
    @endforeach
  </div>
@endsection

@push('css')
<style>
  .dropdown-toggle.no-caret::after {
    content: none;
  }
</style>
@endpush