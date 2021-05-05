@extends('auth.layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="p-3">
            <div class="float-right text-right">
                <h4 class="font-18 mt-3 m-b-5">Reset Password</h4>
                <p class="text-muted">Set Your new password</p>
            </div>
            <div class="logo-admin"><img src="{{config()->get('tswirl.logo')}}" alt="" height="75" class="logo-small"> </div>
        </div>
        <div class="p-3">
            {!! Form::open(['url' => route('password.update'), 'class' => 'form-horizontal']) !!}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ $password ?? old('password') }}" required autofocus>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ $password_confirmation ?? old('password_confirmation') }}" required autofocus>
                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row m-t-20">
                    <div class="col-12 text-right">
                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Reset password</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
