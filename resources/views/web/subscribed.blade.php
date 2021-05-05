@extends('web.layouts.app')
@section('menu')

<!-- Navbar End -->
@include('web.partials._nav')

<!-- Hero section Start -->
<section class="hero-section-5" id="home" style="background: url(web/images/bg-2.png) center center;">
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-8">
              <div class="hero-wrapper text-center mb-4">
                <h1 class="hero-title mb-4">Anda telah Bergabung dengan <span class="text-primary">Soda</span></h1>
                  <p class="font-16 text-uppercase">Silahkan kunjungi Dashboard anda di <a target="_blank" href="owner.localhost:8000" class="text-primary">sini</a> (owner.localhost:8000) </p>

                  <div class="text-center mt-4">
                          <div class="subscribe">
                              <form action="{{route('logout')}}" method="post">
                                @csrf
                                <div class="row">
                                  <div class="col text-center">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log out</button>
                                  </div>
                                </div>
                              </form>
                          </div>
                      </div>
              </div>
          </div>
      </div>
      <!-- end row -->
  </div>
  <!-- end container -->
</section>
<!-- Hero section End -->
@endsection