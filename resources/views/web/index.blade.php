@extends('web.layouts.app')
@section('menu')

<!--Navbar Start-->
<nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark">
  <div class="container">
      <!-- LOGO -->
      <a class="navbar-font" href="/homepage">
        Soda
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <i class="mdi mdi-menu"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav ml-auto navbar-center" id="mySidenav">
              <li class="nav-item active">
                  <a href="#home" class="nav-link">Home</a>
              </li>
              <li class="nav-item">
                  <a href="#services" class="nav-link">Services</a>
              </li>
              <li class="nav-item">
                  <a href="#features" class="nav-link">Features</a>
              </li>
              <li class="nav-item">
                  <a href="#clients" class="nav-link">Clients</a>
              </li>
          </ul>
          <a href="registering" class="btn btn-success btn-rounded navbar-btn">Daftar</a>

      </div>
  </div>
</nav>
<!-- Navbar End -->


<!-- Hero section Start -->
<section class="hero-section" id="home">
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-6">
            @include('web.partials._hero')              
          </div>

          <div class="col-lg-6 col-sm-8">
              <div class="home-img mt-5 mt-lg-0">
                  <img src="web/images/home-img.png" alt="" class="img-fluid mx-auto d-block">
              </div>
          </div>
      </div>
      <!-- end row -->
  </div>
  <!-- end container -->
</section>
<!-- Hero section End -->

<!-- Services start -->
<section class="section bg-light" id="services">
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-8">
              <div class="text-center mb-5">
                  <h5 class="text-primary text-uppercase small-title">Services</h5>
                  <h4 class="mb-3">Services We Provide</h4>
                  <p>It will be as simple as occidental in fact, it will be Occidental.</p>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-xl-4 col-sm-6">
              <div class="text-center p-4 mt-3">
                  <div class="avatar-md mx-auto mb-4">
                      <span class="avatar-title rounded-circle bg-soft-primary">
                          <i data-feather="grid" class="icon-dual-primary"></i>
                      </span>
                  </div>
                  <h5 class="font-18">Bootstrap UI based</h5>
                  <p class="mb-0">To an English person, it will seem like English as skeptical.</p>
              </div>
          </div>
          <div class="col-xl-4 col-sm-6">
              <div class="text-center p-4 mt-3">
                  <div class="avatar-md mx-auto mb-4">
                      <span class="avatar-title rounded-circle bg-soft-primary">
                          <i data-feather="edit" class="icon-dual-primary"></i>
                      </span>
                  </div>
                  <h5 class="font-18">Easy to customize</h5>
                  <p class="mb-0">If several languages coalesce, the grammar of the language.</p>
              </div>
          </div>
          <div class="col-xl-4 col-sm-6">
              <div class="text-center p-4 mt-3">
                  <div class="avatar-md mx-auto mb-4">
                      <span class="avatar-title rounded-circle bg-soft-primary">
                          <i data-feather="headphones" class="icon-dual-primary"></i>
                      </span>
                  </div>
                  <h5 class="font-18">Awesome Support</h5>
                  <p class="mb-0">The languages only differ in their grammar their pronunciation</p>
              </div>
          </div>
          <div class="col-xl-4 col-sm-6">
              <div class="text-center p-4 mt-3">
                  <div class="avatar-md mx-auto mb-4">
                      <span class="avatar-title rounded-circle bg-soft-primary">
                          <i data-feather="layers" class="icon-dual-primary"></i>
                      </span>
                  </div>
                  <h5 class="font-18">Creative Design</h5>
                  <p class="mb-0">Everyone realizes why a new common would be desirable.</p>
              </div>
          </div>
          <div class="col-xl-4 col-sm-6">
              <div class="text-center p-4 mt-3">
                  <div class="avatar-md mx-auto mb-4">
                      <span class="avatar-title rounded-circle bg-soft-primary">
                          <i data-feather="code" class="icon-dual-primary"></i>
                      </span>
                  </div>
                  <h5 class="font-18">Quality Code</h5>
                  <p class="mb-0">To achieve this, it would be necessary to have uniform.</p>
              </div>
          </div>
          <div class="col-xl-4 col-sm-6">
              <div class="text-center p-4 mt-3">
                  <div class="avatar-md mx-auto mb-4">
                      <span class="avatar-title rounded-circle bg-soft-primary">
                          <i data-feather="tablet" class="icon-dual-primary"></i>
                      </span>
                  </div>
                  <h5 class="font-18">Responsive layout</h5>
                  <p class="mb-0">Their separate existence is a myth. For science, music, etc.</p>
              </div>
          </div>
      </div>
      <!-- end row -->

      <div class="row mt-4">
          <div class="col-lg-12">
              <div class="text-center">
                  <a href="#" class="btn btn-success">View more</a>
              </div>
          </div>
      </div>
      <!-- end row -->
  </div>
  <!-- end container -->
</section>
<!-- Services end -->

<!-- Features start -->
<section class="section" id="features">
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-8">
              <div class="text-center mb-5">
                  <h5 class="text-primary text-uppercase small-title">Features</h5>
                  <h4 class="mb-3">Key features of the product</h4>
                  <p>It will be as simple as occidental in fact, it will be Occidental.</p>
              </div>
          </div>
      </div>
      <!-- end row -->

      <div class="row">
          <div class="col-lg-5">
              <div>
                  <div class="avatar-md mb-4">
                      <span class="avatar-title rounded-circle bg-soft-primary">
                        <i data-feather="pie-chart" class="icon-dual-primary"></i>
                      </span>
                  </div>
                  <h5>Kerja Lebih Hemat</h5>
                  {{-- <p class="mb-4">If several languages coalesce, the grammar of the resulting language is more simple and regular.</p> --}}

                  <div class="row mt-3">
                    <div class="col-sm-12">
                        <p><i data-feather="check" class="icon-dual-success mr-2"></i> Tidak perlu tutup toko saat stok opname</p>
                    </div>
                    <div class="col-sm-12">
                        <p><i data-feather="check" class="icon-dual-success mr-2"></i> Tidak perlu khawatir salah kirim barang</p>
                    </div>
                    <div class="col-sm-12">
                        <p><i data-feather="check" class="icon-dual-success mr-2"></i> Tidak perlu cemas barang hilang</p>
                    </div>
                    <div class="col-sm-12">
                        <p><i data-feather="check" class="icon-dual-success mr-2"></i> Tidak perlu bingung kehabisan stok</p>
                    </div>
                  </div>

                  {{-- <div class="mt-4">
                      <a href="#" class="btn btn-primary">Learn more <i data-feather="arrow-right" class="icons-sm ml-1"></i></a>
                  </div> --}}
              </div>
          </div>

          <div class="col-lg-5 ml-lg-auto col-sm-8">
              <div class="card border border-light shadow-none mt-5 mt-lg-0">
                  <div class="card-header border-0 bg-transparent">
                      <div>
                          <i class="mdi mdi-circle text-danger mr-1"></i>
                          <i class="mdi mdi-circle text-warning mr-1"></i>
                          <i class="mdi mdi-circle text-success mr-1"></i>
                      </div>
                  </div>
                  <div class="card-body bg-light">
                      <div class="box-shadow">
                          <img src="web/images/features/img-1.png" alt="" class="img-fluid mx-auto d-block">
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- end row -->

      <div class="row mt-5 pt-5">
          <div class="col-lg-5 col-sm-8">
              <div class="card border border-light shadow-none">
                  <div class="card-header border-0 bg-transparent">
                      <div>
                          <i class="mdi mdi-circle text-danger mr-1"></i>
                          <i class="mdi mdi-circle text-warning mr-1"></i>
                          <i class="mdi mdi-circle text-success mr-1"></i>
                      </div>
                  </div>
                  <div class="card-body bg-light">
                      <div class="box-shadow">
                          <img src="web/images/features/img-2.png" alt="" class="img-fluid mx-auto d-block">
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-lg-5 ml-lg-auto">
              <div class="mt-4 mt-lg-0">
                  <div class="avatar-md mb-4">
                      <span class="avatar-title rounded-circle bg-soft-primary">
                        <i data-feather="bar-chart-2" class="icon-dual-primary"></i>
                      </span>
                  </div>
                  <h5>Bisnis Lebih Maju</h5>
                  {{-- <p class="mb-4">If several languages coalesce, the grammar of the resulting language is more simple and regular.</p> --}}

                  <div class="row mt-3">
                    <div class="col-sm-12">
                        <p><i data-feather="check" class="icon-dual-success mr-2"></i>Bisa punya lebih dari 1 toko di marketplace</p>
                    </div>
                    <div class="col-sm-12">
                        <p><i data-feather="check" class="icon-dual-success mr-2"></i>Bisa punya banyak supplier untuk barang yang sama</p>
                    </div>
                    <div class="col-sm-12">
                        <p><i data-feather="check" class="icon-dual-success mr-2"></i>Bisa punya banyak warehouse diberbagai kota</p>
                    </div>
                    <div class="col-sm-12">
                        <p><i data-feather="check" class="icon-dual-success mr-2"></i>Bisa punya strategi khusus untuk penjualan</p>
                    </div>
                  </div>

                  {{-- <div class="mt-4">
                      <a href="#" class="btn btn-primary">Learn more <i data-feather="arrow-right" class="icons-sm ml-1"></i></a>
                  </div> --}}
              </div>
          </div>

      </div>
      <!-- end row -->
  </div>
  <!-- end container -->
</section>
<!-- Features end -->

<!-- Testimonial start -->
<section class="section bg-light" id="clients">
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-8">
              <div class="text-center mb-5">
                  <h5 class="text-primary text-uppercase small-title">Testimonial</h5>
                  <h4 class="mb-3">What our Client Say</h4>
                  <p>It will be as simple as occidental in fact, it will be Occidental.</p>
              </div>
          </div>
      </div>
      <!-- end row -->

      <div class="row">
          <div class="col-lg-12">
              <h5 class="mb-4"><i class="mdi mdi-format-quote-open text-primary h1 mr-1"></i> 3,500 + Satisfied Client</h5>
              <div class="owl-carousel owl-theme testi-carousel" id="testi-carousel">
                  <div class="item">
                      <div class="card">
                          <div class="card-body p-4">
                              <p class="mb-4">" Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their most common words. "</p>
                              <div class="media pt-3">
                                  <div class="avatar-md mr-3">
                                      <span class="avatar-title rounded-circle bg-soft-primary text-primary font-16">
                                          H
                                      </span>
                                  </div>
                                  <div class="media-body align-self-center">
                                      <h5 class="font-16">Henry McElyea</h5>
                                      <span>- Invoza User</span>
                                  </div>
                                  <div class="text-muted ml-2 align-self-end d-none d-lg-block">
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="item">
                      <div class="card">
                          <div class="card-body p-4">
                              <p class="mb-4">" To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words. If several languages of the resulting language "</p>
                              <div class="media pt-3">
                                  <div class="avatar-md mr-3">
                                      <span class="avatar-title rounded-circle bg-soft-primary text-primary font-16">
                                          T
                                      </span>
                                  </div>
                                  <div class="media-body align-self-center">
                                      <h5 class="font-16">Timothy Fairley</h5>
                                      <span>- Invoza User</span>
                                  </div>
                                  <div class="text-muted ml-2 align-self-end d-none d-lg-block">
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="item">
                      <div class="card">
                          <div class="card-body p-4">
                              <p class="mb-4">" To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is languages are members "</p>
                              <div class="media pt-3">
                                  <div class="avatar-md mr-3">
                                      <span class="avatar-title rounded-circle bg-soft-primary text-primary font-16">
                                          J
                                      </span>
                                  </div>
                                  <div class="media-body align-self-center">
                                      <h5 class="font-16">James Brown</h5>
                                      <span>- Invoza User</span>
                                  </div>
                                  <div class="text-muted ml-2 align-self-end d-none d-lg-block">
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="item">
                      <div class="card">
                          <div class="card-body p-4">
                              <p class="mb-4">" Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this it would be necessary "</p>
                              <div class="media pt-3">
                                  <div class="avatar-md mr-3">
                                      <span class="avatar-title rounded-circle bg-soft-primary text-primary font-16">
                                          J
                                      </span>
                                  </div>
                                  <div class="media-body align-self-center">
                                      <h5 class="font-16">Jason Davis</h5>
                                      <span>- Invoza User</span>
                                  </div>
                                  <div class="text-muted ml-2 align-self-end d-none d-lg-block">
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="item">
                      <div class="card">
                          <div class="card-body p-4">
                              <p class="mb-4">" For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. "</p>
                              <div class="media pt-3">
                                  <div class="avatar-md mr-3">
                                      <span class="avatar-title rounded-circle bg-soft-primary text-primary font-16">
                                          R
                                      </span>
                                  </div>
                                  <div class="media-body align-self-center">
                                      <h5 class="font-16">Rodney Tyler</h5>
                                      <span>- Invoza User</span>
                                  </div>
                                  <div class="text-muted ml-2 align-self-end d-none d-lg-block">
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star text-warning"></i>
                                      <i class="mdi mdi-star"></i>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- end row -->

      <div class="row mt-5">
          <div class="col-xl-3 col-sm-6">
              <div class="client-images">
                  <img src="web/images/clients/1.png" alt="client-img" class="mx-auto img-fluid d-block">
              </div>
          </div>
          <div class="col-xl-3 col-sm-6">
              <div class="client-images">
                  <img src="web/images/clients/3.png" alt="client-img" class="mx-auto img-fluid d-block">
              </div>
          </div>
          <div class="col-xl-3 col-sm-6">
              <div class="client-images">
                  <img src="web/images/clients/4.png" alt="client-img" class="mx-auto img-fluid d-block">
              </div>
          </div>
          <div class="col-xl-3 col-sm-6">
              <div class="client-images">
                  <img src="web/images/clients/6.png" alt="client-img" class="mx-auto img-fluid d-block">
              </div>
          </div>
      </div>
      <!-- end row -->
  </div>
  <!-- end container -->
</section>
<!-- Testimonial end -->

<!-- Counter start -->
<section class="section bg-primary">
  <div class="container">
      <div class="row justify-content-center mb-5">
          <div class="col-lg-7">
              <div class="text-center text-white-50">
                  <h4 class="text-white">Best Solutions for your Business</h4>
                  <p>To achieve this, it would be necessary to have uniform grammar, pronunciation and more common that of the individual languages.</p>
              </div>
          </div>
      </div>
      <div class="row" id="counter">
          <div class="col-xl-3 col-sm-6">
              <div class="text-center mt-4">
                  <i data-feather="bookmark" class="icon-dual-success icons-lg"></i>
                  <h2 class="counter-value text-white mt-4" data-count="2581">10</h2>
                  <p class="font-16 text-white-50">Projects</p>
              </div>
          </div>
          
          <div class="col-xl-3 col-sm-6">
              <div class="text-center mt-4">                     
                  <i data-feather="user-plus" class="icon-dual-success icons-lg"></i>
                  <h2 class="counter-value text-white mt-4" data-count="800">2</h2>
                  <p class="font-16 text-white-50">No. of Clients</p>
              </div>
          </div>

          <div class="col-xl-3 col-sm-6">
              <div class="text-center mt-4">
                  <i data-feather="coffee" class="icon-dual-success icons-lg"></i>
                  <h2 class="counter-value text-white mt-4" data-count="128">608</h2>
                  <p class="font-16 text-white-50">Cups of coffee</p>
              </div>
          </div>
          <div class="col-xl-3 col-sm-6">
              <div class="text-center mt-4">
                  <i data-feather="award" class="icon-dual-success icons-lg"></i>
                  <h2 class="counter-value text-white mt-4" data-count="47">6</h2>
                  <p class="font-16 text-white-50">Awards</p>
              </div>
          </div>
      </div>
  </div>
  <!-- end container -->
</section>
<!-- Counter end -->

<!-- Cta start -->
<section class="section">
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-8">
              <div class="text-center mb-5">
                  <h5 class="text-primary text-uppercase small-title">Subscribe</h5>
                  <h4 class="mb-3">Subscribe to our Newsletter</h4>
                  <p>It will be as simple as occidental in fact, it will be Occidental.</p>
              </div>
          </div>

          <div class="col-xl-8 col-lg-10">
              <div class="text-center">
                  <div class="subscribe">
                      <form>
                          <div class="row">
                              <div class="col-md-9">
                                  <div>
                                      <input type="text" class="form-control" placeholder="Enter your E-mail address">
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="mt-3 mt-md-0">
                                      <button type="submit" class="btn btn-primary btn-block">Subscribe Us</button>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
      <!-- end row -->
  </div>
  <!-- end container -->
</section>
<!-- Cta end -->

@include('web.partials._footer')
@endsection