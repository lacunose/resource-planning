@extends('auth.layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="p-3">
            <div class="float-right text-right">
                <h4 class="font-18 mt-3 m-b-5">Reset Password</h4>
                <p class="text-muted">Send Reset Code to Email</p>
            </div>
            <div class="logo-admin"><img src="{{config()->get('tswirl.logo')}}" alt="" height="75" class="logo-small"> </div>
        </div>
        <div class="p-3">
            {!! Form::open(['url' => route('password.email'), 'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    <label for="useremail">Email</label>
                    <input type="email" name="email" class="form-control" id="useremail" placeholder="Enter email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row m-t-20">
                    <div class="col-12 text-right">
                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Send password reset link</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection


@push('footer')
    <p class="text-muted">Ingat akun anda ? <a href="{{ route('login') }}" class="font-600 text-primary"> Login </a> </p>
@endpush