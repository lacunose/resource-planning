@extends('web.layouts.app')
@section('menu')

<!-- Navbar End -->
@include('web.partials._nav')

<!-- Hero section Start -->
<section class="hero-section-2" id="home" style="background: url(web/images/bg-1.png) center center; padding-bottom: 6em">
    <div class="container">
        <div class="row vertical-content justify-content-center">
            <div class="col-lg-6">
                @include('web.partials._hero')  
            </div>

            <div class="col-lg-4 offset-lg-2">
                <div class="card mx-auto p-4 rounded mt-5 mt-lg-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mb-4">
                                <ul class="nav nav-pills pricing-nav-tabs mb-4">
                                    <li class="nav-item">
                                        <a class="nav-link" href="registering">Register</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="signin">Login</a>
                                    </li>
                                </ul>
                                <div class="text-center">
                                    <h5 class="form-title mb-4">Login</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['url' => route('login'), 'class' => 'registration-form']) !!}
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
                            <div class="col-sm-12 text-right mt-3">
                                <button class="btn btn-primary btn-block btn-sm" type="submit">Log In</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <p><a href="{{ route('password.request') }}" class="text-muted">Lupa Password?</a> </p>
                </div>
                
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- Hero section End -->

@endsection

@push('js')
    @include('plugins.fcmtoken')
@endpush
