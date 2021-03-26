@extends('web.layouts.app')
@section('menu')

<!-- Navbar End -->
@include('web.partials._nav')

<!-- Hero section Start -->
<section class="hero-section-2" id="home" style="background: url(web/images/bg-1.png) center center;">
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
                                        <a class="nav-link active" href="registering">Register</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="signin">Login</a>
                                    </li>
                                </ul>
                                <div class="text-center">
                                    <h5 class="form-title mb-4">Daftar</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['url' => route('registered'), 'class' => 'registration-form']) !!}
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
                                <button class="btn btn-primary btn-block btn-sm" type="submit">Register</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- Hero section End -->

@endsection