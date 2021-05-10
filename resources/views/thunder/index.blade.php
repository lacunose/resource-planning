@inject('idr', '\Lacunose\Acl\Libraries\UI\IDRTranslator')
@inject('date', '\Lacunose\Acl\Libraries\UI\DateTimeTranslator')

@extends('thunder::app')

@section('title')
  <h4 class="page-title">DASHBOARD</h4>
@endsection

@section('content')
  EMPTY
@endsection

@push('css')
<style>
  .dropdown-toggle.no-caret::after {
    content: none;
  }
</style>
@endpush