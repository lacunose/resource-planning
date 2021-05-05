@extends('auth.layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="p-3">
            <div class="float-right text-right">
                <h4 class="font-18 mt-3 m-b-5">Register</h4>
                <p class="text-muted">Sign up for {{env('APP_NAME')}}</p>
            </div>
            <div class="logo-admin"><img src="{{config()->get('tswirl.logo')}}" alt="" height="75" class="logo-small"> </div>
        </div>
        <div class="p-3">
            {!! Form::open(['url' => route('register'), 'class' => 'form-horizontal m-t-10']) !!}
                <div class="form-group">
                    <label for="name" class="">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="">{{ __('E-Mail Address') }}</label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="">{{ __('Password') }}</label>

                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="">{{ __('Confirm Password') }}</label>

                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="form-group row m-t-20">
                    <div class="col-12 text-right">
                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection


@push('footer')
    <p class="text-muted">Sudah punya akun ? <a href="{{ route('login') }}" class="font-600 text-primary"> Login</a> </p>
@endpush