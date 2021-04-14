@extends('web.layouts.app')
@section('menu')

<!-- Navbar End -->
@include('web.partials._nav')

<!-- Hero section Start -->
<section class="hero-section-2" id="home" style="background: url(web/images/bg-1.png) center center;">
    <div class="container">
        <div class="row vertical-content justify-content-center">
            <div class="col-lg-6">
                <!-- Pricing start -->
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($data['packages'] as $pack)
                        <div class="carousel-item  {{$loop->index == 0 ? 'active' : ''}}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="pricing-plan card text-center">
                                        <div class="card-body p-4">
                                            <h5 class="mt-2 mb-5">Economy</h5>
            
                                            <h1 class="mb-5"><sup><small>$</small></sup>19/ <span class="font-16">Mo</span></h1>
            
                                            <div class="plan-features mt-5">
                                                <p>Bandwidth : <span class="text-success">1GB</span></p>
                                                <p>Onlinespace : <span class="text-success">50MB</span></p>
                                                <p>Support : <span class="text-success">No</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if (count($data['packages']) > 1)
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" style="color: blue !important" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
                </div>
                
            </div>

            <div class="col-lg-4 offset-lg-2">
                <div class="card mx-auto p-4 rounded mt-5 mt-lg-0">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mb-4">
                                <div class="text-center">
                                    <h5 class="form-title mb-4">Daftar</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['url' => route('subscribed'), 'class' => 'form-horizontal m-t-10']) !!}

                        <!-- BILLING INFO -->
                        <div class="form-group">
                            <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="name" type="hidden" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="">{{ __('Telepon') }}</label>

                            <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address" class="">{{ __('Alamat') }}</label>

                            <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" required>
                            </textarea>

                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price_id" class="">{{ __('Paket Langganan') }}</label>

                            <select id="price_id" class="form-control @error('price_id') is-invalid @enderror" name="price_id" required>
                                @foreach($data['packages'] as $pack)
                                    <option value="{{ $pack->id }}">{{ $pack->title }} - {{ number_format($pack->ux_contract) }} / {{ $pack->ux_period }}</option>
                                @endforeach
                            </select>

                            @error('price_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="business" class="">{{ __('Business') }}</label>
                            <input id="business" type="text" class="form-control @error('business') is-invalid @enderror" name="business" value="{{ old('business') }}" required autocomplete="business" autofocus>

                            @error('business')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="website" class="">{{ __('Website') }}</label>
                            <input id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website') }}" required autocomplete="website" autofocus>

                            @error('website')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row m-t-20">
                            <div class="col-12 text-right">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Lanjutkan</button>
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
{{-- @extends('auth.layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="p-3">
            <div class="float-right text-right">
                <h4 class="font-18 mt-3 m-b-5">Subscribe</h4>
                <p class="text-muted">Berlangganan {{env('APP_NAME')}}</p>
            </div>
            <div class="logo-admin"><img src="{{config()->get('tswirl.logo')}}" alt="" height="75" class="logo-small"> </div>
        </div>
        <div class="p-3">
            {!! Form::open(['url' => route('subscribed'), 'class' => 'form-horizontal m-t-10']) !!}

                <!-- BILLING INFO -->
                <div class="form-group">
                    <label for="email" class="">{{ __('E-Mail Address') }}</label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name" class="">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="">{{ __('Telepon') }}</label>

                    <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address" class="">{{ __('Alamat') }}</label>

                    <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" required>
                    </textarea>

                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price_id" class="">{{ __('Paket Langganan') }}</label>

                    <select id="price_id" class="form-control @error('price_id') is-invalid @enderror" name="price_id" required>
                        @foreach($data['packages'] as $pack)
                            <option value="{{ $pack->id }}">{{ $pack->title }} - {{ number_format($pack->ux_contract) }} / {{ $pack->ux_period }}</option>
                        @endforeach
                    </select>

                    @error('price_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="website" class="">{{ __('Website') }}</label>
                    <input id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website') }}" required autocomplete="website" autofocus>

                    @error('website')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row m-t-20">
                    <div class="col-12 text-right">
                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Lanjutkan</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div> --}}

{{-- @endsection


@push('footer')
    <p>Sudah punya akun ? <a href="{{ route('login') }}" class="font-600 text-white"> Login</a> </p>
@endpush --}}