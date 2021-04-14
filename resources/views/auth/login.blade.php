@extends('auth.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="p-3">
                <div class="float-right text-right">
                    <h4 class="font-18 mt-3 m-b-5">Welcome Back !</h4>
                    <p class="text-muted">Sign in to {{env('APP_NAME')}}</p>
                </div>
                <div class="logo-admin"><img src="{{config()->get('tswirl.logo')}}" alt="" height="50" class="logo-small"> </div>
            </div>
            <div class="p-3">
                {!! Form::open(['url' => route('login')]) !!}
                    <div class="form-group">
                        <label class="text-muted text-left">Email</label>
                        {!! Form::text('email', request()->email, ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'email', 'autofocus' => true]) !!}

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="text-muted text-left">Password</label>
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'password']) !!}
                        {!! Form::hidden('fcm_token', null, ['class' => 'form-control', 'id' => 'fcmtoken']) !!}

                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group row m-t-30">
                        <div class="col-sm-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customControlInline">
                                <label class="custom-control-label" for="customControlInline">Remember me</label>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                    <div class="form-group m-t-30 mb-0 row">
                        <div class="col-12 text-center">
                            <a href="{{ route('password.request') }}" class="text-primary"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <!-- <p>Belum punya akun ? <a href="{{ route('register') }}" class="font-600 text-white"> Signup </a> </p> -->
@endpush

@push('js')
    @include('plugins.fcmtoken')
@endpush
