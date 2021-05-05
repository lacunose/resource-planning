<div class="row">
	<div class="col">
      @include('tcust::log.table')
      @if($data['logs'] && $data['logs']->withQueryString()->hasPages())
        {!! $data['logs']->withQueryString()->links('tcust::components.paginate') !!}
	  @endif
	</div>
</div>

<div class="row text-center">
	<div class="col">
		@if(in_array($data['data']['status'], ['opened']))
		  <a class="btn btn-primary btn-sm rounded-0 ml-2 text-white" data-toggle="modal" data-target=".modal-customer">TAMBAH TRANSAKSI</a>
		@endif
	</div>
</div>


<div class="modal fade modal-customer" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">
        	Transaksi #{{ $data['data']['no'] }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
	  {!! Form::open(['url' => route('tcust.account.issued', ['id' => $data['data']['uuid']]), 'method' => 'post']) !!}
      <div class="modal-body text-left">
      	<div class="row">
      		<div class="col">
			    <div class="form-group">
			      {!! Form::label('issued_at', 'Tanggal') !!}
			      {!! Form::date('issued_at', now(), ['class' => 'form-control', 'required' => true, 'max' => now()]) !!}
			      @if ($errors->has('issued_at'))
			        <span class="invalid-feedback d-block py-1" role="alert">
			          {{ $errors->first('issued_at') }}
			        </span>
			      @endif
			    </div>
			    <div class="form-group">
			      {!! Form::label('no_ref', '#') !!}
			      {!! Form::text('no_ref', $data['default']['no_ref'], ['class' => 'form-control', 'required' => true]) !!}
			      @if ($errors->has('no_ref'))
			        <span class="invalid-feedback d-block py-1" role="alert">
			          {{ $errors->first('no_ref') }}
			        </span>
			      @endif
			    </div>
			    <div class="form-group">
			      {!! Form::label('description', 'Keterangan') !!}
			      {!! Form::textarea('description', '', ['class' => 'form-control', 'required' => true]) !!}
			      @if ($errors->has('description'))
			        <span class="invalid-feedback d-block py-1" role="alert">
			          {{ $errors->first('description') }}
			        </span>
			      @endif
			    </div>
			    <div class="form-group">
			      {!! Form::label('amount', 'Jumlah') !!}
			      {!! Form::number('amount', 0, ['class' => 'form-control', 'required' => true]) !!}
			      @if ($errors->has('amount'))
			        <span class="invalid-feedback d-block py-1" role="alert">
			          {{ $errors->first('amount') }}
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
