@extends('layouts/layoutMaster')
@php
$configData = Helper::appClasses();
@endphp

@section('title', 'Help Center Landing - Front Pages')

@section('page-style')
@vite('resources/assets/vendor/scss/pages/front-page-help-center.scss')
@endsection

@section('content')
<!-- Help Center Header: Start -->
<section class="section-py first-section-pt help-center-header position-relative overflow-hidden">
  <img class="banner-bg-img z-n1" src="{{asset('assets/img/pages/header-'.$configData['theme'].'.png') }}"
    alt="Help center header" data-app-light-img="pages/header-light.png" data-app-dark-img="pages/header-dark.png" />
  <h4 class="text-center text-primary">Cari Dokumen Perijinan & Aturan</h4>
  <div class="input-wrapper my-4 input-group input-group-merge position-relative mx-auto">
    <span class="input-group-text" id="basic-addon1"><i class="icon-base ri ri-search-line"></i></span>
    <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" />
  </div>
  <p class="text-center px-4 mb-0">Akses berbagai peraturan, keputusan direktur, dan SOP perijinan dengan mudah</p>
</section>
<!-- Help Center Header: End -->

<!-- Popular Articles: Start -->
<section class="section-py">
  <div class="container">
    <h4 class="text-center mb-5">Regulasi & Pedoman Perijinan</h4>
    <div class="row g-4">
      
      <!-- Card 1 -->
      <div class="col-sm-6 col-md-3">
        <div class="card border shadow-sm h-100">
          <div class="card-body text-center d-flex flex-column justify-content-between">
            <div>
              <i class="bi bi-journal-text text-primary" style="font-size:2.5rem;"></i>
              <h5 class="my-3">Peraturan Gubernur</h5>
              <p class="mb-3 text-muted">Referensi aturan terbaru dari pemerintah provinsi.</p>
            </div>
            <a class="btn btn-outline-primary mt-auto" href="{{ url('front-pages/help-center-article') }}">
              Lihat Detail
            </a>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-sm-6 col-md-3">
        <div class="card border shadow-sm h-100">
          <div class="card-body text-center d-flex flex-column justify-content-between">
            <div>
              <i class="bi bi-file-earmark-text text-success" style="font-size:2.5rem;"></i>
              <h5 class="my-3">Keputusan Direktur</h5>
              <p class="mb-3 text-muted">Pedoman dan keputusan penting dari direktur rumah sakit untuk mendukung operasional layanan.</p>
            </div>
            <a class="btn btn-outline-primary mt-auto" href="{{ url('front-pages/help-center-article') }}">
              Lihat Detail
            </a>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-sm-6 col-md-3">
        <div class="card border shadow-sm h-100">
          <div class="card-body text-center d-flex flex-column justify-content-between">
            <div>
              <i class="bi bi-building text-warning" style="font-size:2.5rem;"></i>
              <h5 class="my-3">Perijinan</h5>
              <p class="mb-3 text-muted">Arahan direktur rumah sakit mengenai ketentuan perijinan</p>
            </div>
            <a class="btn btn-outline-primary mt-auto" href="{{ url('front-pages/help-center-article') }}">
             Lihat Detail
            </a>
          </div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="col-sm-6 col-md-3">
        <div class="card border shadow-sm h-100">
          <div class="card-body text-center d-flex flex-column justify-content-between">
            <div>
              <i class="bi bi-clipboard-check text-danger" style="font-size:2.5rem;"></i>
              <h5 class="my-3">SOP</h5>
              <p class="mb-3 text-muted">Panduan prosedur standar untuk proses perijinan rumah sakit</p>
            </div>
            <a class="btn btn-outline-primary mt-auto" href="{{ url('front-pages/help-center-article') }}">
             Lihat Detail
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- Popular Articles: End -->

<!-- Hover Style -->
<style>
  .card:hover {
    transform: translateY(-5px);
    transition: 0.3s;
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
  }
  .card p {
    display: -webkit-box;
    -webkit-line-clamp: 2; 
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>


<!-- Knowledge Base: Start -->
<section class="section-py bg-body">
  <div class="container">
    <h4 class="text-center mb-6">Knowledge Base</h4>
    <div class="row">
      <div class="col-md-4 col-ms-6 mb-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm flex-shrink-0 me-2">
                <span class="avatar-initial bg-label-primary rounded"><i
                    class="icon-base ri ri-shopping-cart-line"></i></span>
              </div>
              <h5 class="mb-0 ms-1">Buying</h5>
            </div>
            <ul class="list-unstyled my-6">
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> What are Favourites? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> How do I purchase an item? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> How do i add or change my details? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> How do refunds work? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Can I Get A Refund? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li>
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> I'm trying to find a specific item </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
            </ul>
            <p class="mb-0 fw-medium mt-6">
              <a href="{{url('front-pages/help-center-article')}}" class="d-flex align-items-center">
                <span class="me-2">See all 10 articles</span>
                <i class="icon-base ri ri-arrow-right-line icon-sm scaleX-n1-rtl"></i>
              </a>
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-ms-6 mb-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm flex-shrink-0 me-2">
                <span class="avatar-initial bg-label-primary rounded"><i
                    class="icon-base ri ri-question-line"></i></span>
              </div>
              <h5 class="mb-0 ms-1">Item Support</h5>
            </div>
            <ul class="list-unstyled my-6">
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> What is Item Support? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> How to contact an author </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Where Is My Purchase Code? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Extend or renew Item Support </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Item Support FAQ </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li>
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Why has my item been removed? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
            </ul>
            <p class="mb-0 fw-medium mt-6">
              <a href="{{url('front-pages/help-center-article')}}" class="d-flex align-items-center">
                <span class="me-2">See all 14 articles</span>
                <i class="icon-base ri ri-arrow-right-line icon-sm scaleX-n1-rtl"></i>
              </a>
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-ms-6 mb-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm flex-shrink-0 me-2">
                <span class="avatar-initial bg-label-primary rounded"><i
                    class="icon-base ri ri-file-text-line"></i></span>
              </div>
              <h5 class="mb-0 ms-1">Licenses</h5>
            </div>
            <ul class="list-unstyled my-6">
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Can I use the same license for the same item on multiple sites?
                  </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> How do licenses work for any plugins </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> For logo what license do I need? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> I’m making a test site - it’s not for a client. Which license do I
                    need? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> which license do I need? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li>
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> I want to make multiple end products </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
            </ul>
            <p class="mb-0 fw-medium mt-6">
              <a href="{{url('front-pages/help-center-article')}}" class="d-flex align-items-center">
                <span class="me-2">See all 8 articles</span>
                <i class="icon-base ri ri-arrow-right-line icon-sm scaleX-n1-rtl"></i>
              </a>
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-ms-6 mb-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm flex-shrink-0 me-2">
                <span class="avatar-initial bg-label-primary rounded"><i
                    class="icon-base ri ri-palette-line"></i></span>
              </div>
              <h5 class="mb-0 ms-1">Template Kits</h5>
            </div>
            <ul class="list-unstyled my-6">
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Template Kits </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Elementor Template Kits: PHP Zip File Missing </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Template Kits - Imported template is blank or broken </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Troubleshooting Import Problems </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> How to use the WordPress Plugin </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li>
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> How to use the Template Kit Importer Plugin </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
            </ul>
            <p class="mb-0 fw-medium mt-6">
              <a href="{{url('front-pages/help-center-article')}}" class="d-flex align-items-center">
                <span class="me-2">See all 5 articles</span>
                <i class="icon-base ri ri-arrow-right-line icon-sm scaleX-n1-rtl"></i>
              </a>
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-ms-6 mb-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm flex-shrink-0 me-2">
                <span class="avatar-initial bg-label-primary rounded"><i class="icon-base ri ri-lock-line"></i></span>
              </div>
              <h5 class="mb-0 ms-1">Account & Password</h5>
            </div>
            <ul class="list-unstyled my-6">
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Signing in with a social account </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Locked Out of Account </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> I'm not receiving the verification email </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Forgotten Username Or Password </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> New password not accepted </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li>
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> What is Sign In Verification? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
            </ul>
            <p class="mb-0 fw-medium mt-6">
              <a href="{{url('front-pages/help-center-article')}}" class="d-flex align-items-center">
                <span class="me-2">See all 16 articles</span>
                <i class="icon-base ri ri-arrow-right-line icon-sm scaleX-n1-rtl"></i>
              </a>
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-ms-6 mb-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm flex-shrink-0 me-2">
                <span class="avatar-initial bg-label-primary rounded"><i class="icon-base ri ri-user-line"></i></span>
              </div>
              <h5 class="mb-0 ms-1">Account Settings</h5>
            </div>
            <ul class="list-unstyled my-6">
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> How do I change my password? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> How do I change my username? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> How do I close my account? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> How do I change my email address? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li class="mb-2">
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> How can I regain access to my account? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
              <li>
                <a href="{{url('front-pages/help-center-article')}}"
                  class="text-heading d-flex justify-content-between align-items-center">
                  <span class="text-truncate me-1"> Are RSS feeds available on Market? </span>
                  <i class="icon-base ri ri-arrow-right-s-line scaleX-n1-rtl text-body-secondary"></i>
                </a>
              </li>
            </ul>
            <p class="mb-0 fw-medium mt-6">
              <a href="{{url('front-pages/help-center-article')}}" class="d-flex align-items-center">
                <span class="me-2">See all 12 articles</span>
                <i class="icon-base ri ri-arrow-right-line icon-sm scaleX-n1-rtl"></i>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Knowledge Base: End -->

<!-- Keep Learning: Start -->
<section class="section-py">
  <div class="container">
    <h4 class="text-center mb-6">Keep Learning</h4>
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="row gy-6 gy-md-0">
          <div class="col-md-4">
            <div class="card border shadow-none">
              <div class="card-body text-center">
                <svg width="58" height="58" viewBox="0 0 58 58" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <g opacity="0.2">
                    <path
                      d="M9.72925 39.875V16.3125C9.72925 15.3511 10.1112 14.4291 10.791 13.7492C11.4708 13.0694 12.3928 12.6875 13.3542 12.6875H45.9792C46.9407 12.6875 47.8627 13.0694 48.5425 13.7492C49.2223 14.4291 49.6042 15.3511 49.6042 16.3125V39.875H9.72925Z"
                      fill="currentColor"></path>
                    <path
                      d="M9.72925 39.875V16.3125C9.72925 15.3511 10.1112 14.4291 10.791 13.7492C11.4708 13.0694 12.3928 12.6875 13.3542 12.6875H45.9792C46.9407 12.6875 47.8627 13.0694 48.5425 13.7492C49.2223 14.4291 49.6042 15.3511 49.6042 16.3125V39.875H9.72925Z"
                      fill="currentColor" fill-opacity="0.2"></path>
                  </g>
                  <path
                    d="M8.72925 39.875C8.72925 40.4273 9.17696 40.875 9.72925 40.875C10.2815 40.875 10.7292 40.4273 10.7292 39.875H8.72925ZM13.3542 12.6875V11.6875V12.6875ZM45.9792 12.6875V11.6875V12.6875ZM48.6042 39.875C48.6042 40.4273 49.052 40.875 49.6042 40.875C50.1565 40.875 50.6042 40.4273 50.6042 39.875H48.6042ZM6.10425 39.875V38.875C5.55196 38.875 5.10425 39.3227 5.10425 39.875H6.10425ZM53.2292 39.875H54.2292C54.2292 39.3227 53.7815 38.875 53.2292 38.875V39.875ZM6.10425 43.5H5.10425H6.10425ZM33.2917 20.9375C33.844 20.9375 34.2917 20.4898 34.2917 19.9375C34.2917 19.3852 33.844 18.9375 33.2917 18.9375V20.9375ZM26.0417 18.9375C25.4895 18.9375 25.0417 19.3852 25.0417 19.9375C25.0417 20.4898 25.4895 20.9375 26.0417 20.9375V18.9375ZM10.7292 39.875V16.3125H8.72925V39.875H10.7292ZM10.7292 16.3125C10.7292 15.6163 11.0058 14.9486 11.4981 14.4563L10.0839 13.0421C9.21652 13.9095 8.72925 15.0859 8.72925 16.3125H10.7292ZM11.4981 14.4563C11.9904 13.9641 12.6581 13.6875 13.3542 13.6875L13.3542 11.6875C12.1276 11.6875 10.9512 12.1748 10.0839 13.0421L11.4981 14.4563ZM13.3542 13.6875H45.9792V11.6875H13.3542V13.6875ZM45.9792 13.6875C46.6754 13.6875 47.3431 13.9641 47.8354 14.4563L49.2496 13.0421C48.3823 12.1748 47.2059 11.6875 45.9792 11.6875V13.6875ZM47.8354 14.4563C48.3277 14.9486 48.6042 15.6163 48.6042 16.3125H50.6042C50.6042 15.0859 50.117 13.9095 49.2496 13.0421L47.8354 14.4563ZM48.6042 16.3125V39.875H50.6042V16.3125H48.6042ZM6.10425 40.875H53.2292V38.875H6.10425V40.875ZM52.2292 39.875V43.5H54.2292V39.875H52.2292ZM52.2292 43.5C52.2292 44.1962 51.9527 44.8639 51.4604 45.3562L52.8746 46.7704C53.742 45.903 54.2292 44.7266 54.2292 43.5H52.2292ZM51.4604 45.3562C50.9681 45.8484 50.3004 46.125 49.6042 46.125V48.125C50.8309 48.125 52.0073 47.6377 52.8746 46.7704L51.4604 45.3562ZM49.6042 46.125H9.72925V48.125H49.6042V46.125ZM9.72925 46.125C9.03305 46.125 8.36538 45.8484 7.87309 45.3562L6.45888 46.7704C7.32623 47.6377 8.50262 48.125 9.72925 48.125V46.125ZM7.87309 45.3562C7.38081 44.8639 7.10425 44.1962 7.10425 43.5H5.10425C5.10425 44.7266 5.59152 45.903 6.45888 46.7704L7.87309 45.3562ZM7.10425 43.5V39.875H5.10425V43.5H7.10425ZM33.2917 18.9375H26.0417V20.9375H33.2917V18.9375Z"
                    fill="currentColor"></path>
                  <path
                    d="M8.72925 39.875C8.72925 40.4273 9.17696 40.875 9.72925 40.875C10.2815 40.875 10.7292 40.4273 10.7292 39.875H8.72925ZM13.3542 12.6875V11.6875V12.6875ZM45.9792 12.6875V11.6875V12.6875ZM48.6042 39.875C48.6042 40.4273 49.052 40.875 49.6042 40.875C50.1565 40.875 50.6042 40.4273 50.6042 39.875H48.6042ZM6.10425 39.875V38.875C5.55196 38.875 5.10425 39.3227 5.10425 39.875H6.10425ZM53.2292 39.875H54.2292C54.2292 39.3227 53.7815 38.875 53.2292 38.875V39.875ZM6.10425 43.5H5.10425H6.10425ZM33.2917 20.9375C33.844 20.9375 34.2917 20.4898 34.2917 19.9375C34.2917 19.3852 33.844 18.9375 33.2917 18.9375V20.9375ZM26.0417 18.9375C25.4895 18.9375 25.0417 19.3852 25.0417 19.9375C25.0417 20.4898 25.4895 20.9375 26.0417 20.9375V18.9375ZM10.7292 39.875V16.3125H8.72925V39.875H10.7292ZM10.7292 16.3125C10.7292 15.6163 11.0058 14.9486 11.4981 14.4563L10.0839 13.0421C9.21652 13.9095 8.72925 15.0859 8.72925 16.3125H10.7292ZM11.4981 14.4563C11.9904 13.9641 12.6581 13.6875 13.3542 13.6875L13.3542 11.6875C12.1276 11.6875 10.9512 12.1748 10.0839 13.0421L11.4981 14.4563ZM13.3542 13.6875H45.9792V11.6875H13.3542V13.6875ZM45.9792 13.6875C46.6754 13.6875 47.3431 13.9641 47.8354 14.4563L49.2496 13.0421C48.3823 12.1748 47.2059 11.6875 45.9792 11.6875V13.6875ZM47.8354 14.4563C48.3277 14.9486 48.6042 15.6163 48.6042 16.3125H50.6042C50.6042 15.0859 50.117 13.9095 49.2496 13.0421L47.8354 14.4563ZM48.6042 16.3125V39.875H50.6042V16.3125H48.6042ZM6.10425 40.875H53.2292V38.875H6.10425V40.875ZM52.2292 39.875V43.5H54.2292V39.875H52.2292ZM52.2292 43.5C52.2292 44.1962 51.9527 44.8639 51.4604 45.3562L52.8746 46.7704C53.742 45.903 54.2292 44.7266 54.2292 43.5H52.2292ZM51.4604 45.3562C50.9681 45.8484 50.3004 46.125 49.6042 46.125V48.125C50.8309 48.125 52.0073 47.6377 52.8746 46.7704L51.4604 45.3562ZM49.6042 46.125H9.72925V48.125H49.6042V46.125ZM9.72925 46.125C9.03305 46.125 8.36538 45.8484 7.87309 45.3562L6.45888 46.7704C7.32623 47.6377 8.50262 48.125 9.72925 48.125V46.125ZM7.87309 45.3562C7.38081 44.8639 7.10425 44.1962 7.10425 43.5H5.10425C5.10425 44.7266 5.59152 45.903 6.45888 46.7704L7.87309 45.3562ZM7.10425 43.5V39.875H5.10425V43.5H7.10425ZM33.2917 18.9375H26.0417V20.9375H33.2917V18.9375Z"
                    fill="currentColor" fill-opacity="0.2"></path>
                </svg>
                <h5 class="my-3">Blogging</h5>
                <p class="mb-3">Expert tips and tools to improve your website or online store using our blog.</p>
                <a href="{{url('front-pages/help-center-article')}}" class="btn btn-outline-primary">Read More</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border shadow-none">
              <div class="card-body text-center">
                <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g opacity="0.2">
                    <path
                      d="M17.8304 37.8359C15.6726 36.1581 13.925 34.0112 12.7199 31.5579C11.5148 29.1045 10.8839 26.4091 10.8749 23.6757C10.8296 13.8429 18.7367 5.66403 28.5695 5.43747C32.375 5.34725 36.1123 6.45746 39.2514 8.61062C42.3904 10.7638 44.7719 13.8506 46.0581 17.4333C47.3442 21.016 47.4698 24.9127 46.4169 28.5707C45.364 32.2288 43.1861 35.4625 40.1921 37.8132C39.5308 38.3245 38.995 38.9802 38.6259 39.7302C38.2568 40.4802 38.0641 41.3047 38.0625 42.1406V43.5C38.0625 43.9807 37.8715 44.4417 37.5316 44.7816C37.1917 45.1215 36.7307 45.3125 36.25 45.3125H21.7499C21.2692 45.3125 20.8082 45.1215 20.4683 44.7816C20.1284 44.4417 19.9374 43.9807 19.9374 43.5V42.1406C19.9318 41.3109 19.7394 40.4932 19.3747 39.748C19.0099 39.0028 18.4821 38.3493 17.8304 37.8359Z"
                      fill="currentColor"></path>
                    <path
                      d="M17.8304 37.8359C15.6726 36.1581 13.925 34.0112 12.7199 31.5579C11.5148 29.1045 10.8839 26.4091 10.8749 23.6757C10.8296 13.8429 18.7367 5.66403 28.5695 5.43747C32.375 5.34725 36.1123 6.45746 39.2514 8.61062C42.3904 10.7638 44.7719 13.8506 46.0581 17.4333C47.3442 21.016 47.4698 24.9127 46.4169 28.5707C45.364 32.2288 43.1861 35.4625 40.1921 37.8132C39.5308 38.3245 38.995 38.9802 38.6259 39.7302C38.2568 40.4802 38.0641 41.3047 38.0625 42.1406V43.5C38.0625 43.9807 37.8715 44.4417 37.5316 44.7816C37.1917 45.1215 36.7307 45.3125 36.25 45.3125H21.7499C21.2692 45.3125 20.8082 45.1215 20.4683 44.7816C20.1284 44.4417 19.9374 43.9807 19.9374 43.5V42.1406C19.9318 41.3109 19.7394 40.4932 19.3747 39.748C19.0099 39.0028 18.4821 38.3493 17.8304 37.8359Z"
                      fill="currentColor" fill-opacity="1"></path>
                  </g>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M38.6857 9.43527C35.7198 7.4009 32.1887 6.35195 28.5932 6.43719L28.5925 6.4372C28.3515 6.44275 28.1116 6.45338 27.8731 6.46896L28.5464 4.43773C32.5617 4.34269 36.5049 5.51414 39.817 7.78597C43.1293 10.0579 45.6422 13.3151 46.9993 17.0954C48.3564 20.8758 48.4889 24.9875 47.3779 28.8473C46.2669 32.7072 43.9688 36.1193 40.8097 38.5998L40.8037 38.6045L40.8037 38.6044C40.263 39.0224 39.8249 39.5585 39.5232 40.1717C39.2215 40.7847 39.0639 41.4585 39.0625 42.1416V42.1425V43.5C39.0625 44.2459 38.7661 44.9613 38.2387 45.4887C37.7112 46.0162 36.9959 46.3125 36.25 46.3125H21.75C21.004 46.3125 20.2887 46.0162 19.7612 45.4887C19.2338 44.9613 18.9375 44.2459 18.9375 43.5V42.1441C18.9323 41.4657 18.7748 40.7971 18.4765 40.1877C18.1782 39.5781 17.7466 39.0434 17.2138 38.6231L17.8866 36.5936C18.069 36.7483 18.255 36.8993 18.4442 37.0465L17.8304 37.836L18.4492 37.0504C19.2189 37.6567 19.8421 38.4284 20.2729 39.3084C20.7036 40.1884 20.9307 41.154 20.9374 42.1338L20.9375 42.1406L20.9375 43.5C20.9375 43.7155 21.0231 43.9221 21.1754 44.0745C21.3278 44.2269 21.5345 44.3125 21.75 44.3125H36.25C36.4654 44.3125 36.6721 44.2269 36.8245 44.0745C36.9768 43.9221 37.0625 43.7155 37.0625 43.5V42.1406V42.1387C37.0644 41.1503 37.2923 40.1754 37.7287 39.2886C38.1646 38.4029 38.7969 37.6285 39.5775 37.0244C42.4048 34.8035 44.4614 31.7492 45.4559 28.2941C46.4507 24.8379 46.3321 21.1562 45.1169 17.7712C43.9017 14.3862 41.6516 11.4696 38.6857 9.43527ZM17.8865 36.5936L17.8866 36.5936L27.8731 6.46896L27.8724 6.469L28.5458 4.43775C18.1651 4.67729 9.8275 13.3058 9.87496 23.6797C9.88451 26.5645 10.5504 29.4094 11.8223 31.9987C13.0938 34.5872 14.9375 36.8525 17.2138 38.6231L17.8865 36.5936ZM17.8865 36.5936C16.1041 35.0827 14.6499 33.2189 13.6175 31.117C12.4793 28.7998 11.8834 26.254 11.8749 23.6725L11.8749 23.6711C11.8332 14.6214 18.9246 7.05389 27.8724 6.469L17.8865 36.5936ZM18.9376 52.5625C18.9376 52.0102 19.3853 51.5625 19.9376 51.5625H38.0626C38.6149 51.5625 39.0626 52.0102 39.0626 52.5625C39.0626 53.1148 38.6149 53.5625 38.0626 53.5625H19.9376C19.3853 53.5625 18.9376 53.1148 18.9376 52.5625ZM31.0024 11.8828C30.4579 11.7905 29.9416 12.1571 29.8493 12.7016C29.757 13.2461 30.1236 13.7624 30.6681 13.8547C32.6793 14.1956 34.535 15.1524 35.9792 16.5929C37.4235 18.0334 38.385 19.8867 38.731 21.897C38.8247 22.4413 39.3419 22.8066 39.8862 22.7129C40.4304 22.6192 40.7957 22.102 40.702 21.5577C40.2857 19.1394 39.129 16.9098 37.3916 15.1769C35.6543 13.4439 33.4218 12.293 31.0024 11.8828Z"
                    fill="currentColor"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M38.6857 9.43527C35.7198 7.4009 32.1887 6.35195 28.5932 6.43719L28.5925 6.4372C28.3515 6.44275 28.1116 6.45338 27.8731 6.46896L28.5464 4.43773C32.5617 4.34269 36.5049 5.51414 39.817 7.78597C43.1293 10.0579 45.6422 13.3151 46.9993 17.0954C48.3564 20.8758 48.4889 24.9875 47.3779 28.8473C46.2669 32.7072 43.9688 36.1193 40.8097 38.5998L40.8037 38.6045L40.8037 38.6044C40.263 39.0224 39.8249 39.5585 39.5232 40.1717C39.2215 40.7847 39.0639 41.4585 39.0625 42.1416V42.1425V43.5C39.0625 44.2459 38.7661 44.9613 38.2387 45.4887C37.7112 46.0162 36.9959 46.3125 36.25 46.3125H21.75C21.004 46.3125 20.2887 46.0162 19.7612 45.4887C19.2338 44.9613 18.9375 44.2459 18.9375 43.5V42.1441C18.9323 41.4657 18.7748 40.7971 18.4765 40.1877C18.1782 39.5781 17.7466 39.0434 17.2138 38.6231L17.8866 36.5936C18.069 36.7483 18.255 36.8993 18.4442 37.0465L17.8304 37.836L18.4492 37.0504C19.2189 37.6567 19.8421 38.4284 20.2729 39.3084C20.7036 40.1884 20.9307 41.154 20.9374 42.1338L20.9375 42.1406L20.9375 43.5C20.9375 43.7155 21.0231 43.9221 21.1754 44.0745C21.3278 44.2269 21.5345 44.3125 21.75 44.3125H36.25C36.4654 44.3125 36.6721 44.2269 36.8245 44.0745C36.9768 43.9221 37.0625 43.7155 37.0625 43.5V42.1406V42.1387C37.0644 41.1503 37.2923 40.1754 37.7287 39.2886C38.1646 38.4029 38.7969 37.6285 39.5775 37.0244C42.4048 34.8035 44.4614 31.7492 45.4559 28.2941C46.4507 24.8379 46.3321 21.1562 45.1169 17.7712C43.9017 14.3862 41.6516 11.4696 38.6857 9.43527ZM17.8865 36.5936L17.8866 36.5936L27.8731 6.46896L27.8724 6.469L28.5458 4.43775C18.1651 4.67729 9.8275 13.3058 9.87496 23.6797C9.88451 26.5645 10.5504 29.4094 11.8223 31.9987C13.0938 34.5872 14.9375 36.8525 17.2138 38.6231L17.8865 36.5936ZM17.8865 36.5936C16.1041 35.0827 14.6499 33.2189 13.6175 31.117C12.4793 28.7998 11.8834 26.254 11.8749 23.6725L11.8749 23.6711C11.8332 14.6214 18.9246 7.05389 27.8724 6.469L17.8865 36.5936ZM18.9376 52.5625C18.9376 52.0102 19.3853 51.5625 19.9376 51.5625H38.0626C38.6149 51.5625 39.0626 52.0102 39.0626 52.5625C39.0626 53.1148 38.6149 53.5625 38.0626 53.5625H19.9376C19.3853 53.5625 18.9376 53.1148 18.9376 52.5625ZM31.0024 11.8828C30.4579 11.7905 29.9416 12.1571 29.8493 12.7016C29.757 13.2461 30.1236 13.7624 30.6681 13.8547C32.6793 14.1956 34.535 15.1524 35.9792 16.5929C37.4235 18.0334 38.385 19.8867 38.731 21.897C38.8247 22.4413 39.3419 22.8066 39.8862 22.7129C40.4304 22.6192 40.7957 22.102 40.702 21.5577C40.2857 19.1394 39.129 16.9098 37.3916 15.1769C35.6543 13.4439 33.4218 12.293 31.0024 11.8828Z"
                    fill="white" fill-opacity="0.2"></path>
                </svg>
                <h5 class="my-3">Inspiration Center</h5>
                <p class="mb-3">Inspiration from experts to help you start and grow your big ideas.</p>
                <a href="{{url('front-pages/help-center-article')}}" class="btn btn-outline-primary">Read More</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <div class="card border shadow-none">
              <div class="card-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="58" height="58" viewBox="0 0 58 58" fill="none">
                  <path opacity="0.2"
                    d="M22.8832 41.2571L20.1418 46.6946C19.9654 47.0654 19.6653 47.3632 19.2932 47.5368C18.9211 47.7105 18.5002 47.7491 18.1027 47.6462C12.5519 46.2868 7.74878 43.9305 4.25972 40.8946C3.99667 40.6625 3.80565 40.3599 3.70928 40.0226C3.61291 39.6853 3.61523 39.3275 3.71597 38.9915L11.3964 13.3446C11.4712 13.0821 11.6065 12.8409 11.7914 12.6402C11.9763 12.4395 12.2058 12.285 12.4613 12.1891C14.6312 11.2989 16.8753 10.6014 19.1675 10.1047C19.608 10.0083 20.0686 10.0774 20.4615 10.2988C20.8543 10.5203 21.1518 10.8787 21.2972 11.3055L23.0871 16.7204C27.0105 16.1766 30.9902 16.1766 34.9136 16.7204L36.7035 11.3055C36.8489 10.8787 37.1464 10.5203 37.5392 10.2988C37.932 10.0774 38.3927 10.0083 38.8332 10.1047C41.1254 10.6014 43.3695 11.2989 45.5394 12.1891C45.7949 12.285 46.0243 12.4395 46.2093 12.6402C46.3942 12.8409 46.5295 13.0821 46.6042 13.3446L54.2847 38.9915C54.3855 39.3275 54.3878 39.6853 54.2914 40.0226C54.195 40.3599 54.004 40.6625 53.741 40.8946C50.2519 43.9305 45.4488 46.2868 39.898 47.6462C39.5005 47.7491 39.0795 47.7105 38.7074 47.5368C38.3353 47.3632 38.0353 47.0654 37.8589 46.6946L35.1175 41.2571C33.0909 41.5421 31.0469 41.6859 29.0003 41.6876C26.9538 41.6859 24.9098 41.5421 22.8832 41.2571Z"
                    fill="currentColor" fill-opacity="2"></path>
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M24.4688 32.625C24.4688 34.1265 23.2515 35.3438 21.75 35.3438C20.2485 35.3438 19.0312 34.1265 19.0312 32.625C19.0312 31.1235 20.2485 29.9062 21.75 29.9062C23.2515 29.9062 24.4688 31.1235 24.4688 32.625ZM38.9688 32.625C38.9688 34.1265 37.7515 35.3438 36.25 35.3438C34.7485 35.3438 33.5312 34.1265 33.5312 32.625C33.5312 31.1235 34.7485 29.9062 36.25 29.9062C37.7515 29.9062 38.9688 31.1235 38.9688 32.625Z"
                    fill="currentColor" fill-opacity="1"></path>
                  <path
                    d="M16.8566 18.1251C20.7858 16.8936 24.8828 16.2821 29.0003 16.3126C33.1178 16.2821 37.2149 16.8936 41.1441 18.1251M41.1441 39.8751C37.2149 41.1065 33.1178 41.718 29.0003 41.6876C24.8828 41.718 20.7858 41.1065 16.8566 39.8751M35.1175 41.2571L37.8589 46.6946C38.0353 47.0654 38.3353 47.3632 38.7074 47.5368C39.0795 47.7105 39.5005 47.7491 39.898 47.6462C45.4488 46.2868 50.2519 43.9305 53.741 40.8946C54.004 40.6625 54.195 40.3599 54.2914 40.0226C54.3878 39.6853 54.3855 39.3275 54.2847 38.9915L46.6042 13.3446C46.5295 13.0821 46.3942 12.8409 46.2093 12.6402C46.0243 12.4395 45.7949 12.285 45.5394 12.1891C43.3695 11.2989 41.1254 10.6014 38.8332 10.1047C38.3926 10.0083 37.932 10.0774 37.5392 10.2988C37.1464 10.5203 36.8489 10.8787 36.7035 11.3055L34.9136 16.7204M22.8832 41.2571L20.1418 46.6946C19.9654 47.0654 19.6653 47.3632 19.2932 47.5368C18.9211 47.7105 18.5002 47.7491 18.1027 47.6462C12.5519 46.2868 7.74878 43.9305 4.25972 40.8946C3.99667 40.6625 3.80565 40.3599 3.70928 40.0226C3.61291 39.6853 3.61523 39.3275 3.71597 38.9915L11.3964 13.3446C11.4712 13.0821 11.6065 12.8409 11.7914 12.6402C11.9763 12.4395 12.2058 12.285 12.4613 12.1891C14.6312 11.2989 16.8753 10.6014 19.1675 10.1047C19.608 10.0083 20.0686 10.0774 20.4615 10.2988C20.8543 10.5203 21.1518 10.8787 21.2972 11.3055L23.0871 16.7204"
                    stroke="currentColor" stroke-opacity="1" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"></path>
                </svg>
                <h5 class="my-3">Community</h5>
                <p class="mb-3">A group of people living in the same place or having a particular.</p>
                <a href="{{url('front-pages/help-center-article')}}" class="btn btn-outline-primary">Read More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Keep Learning: End -->

<!-- Help Area: Start -->
<section class="section-py bg-body">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6 text-center">
        <h4>Still need help?</h4>
        <p>Our specialists are always happy to help.<br />Contact us during standard business hours or email us 24/7 and
          we'll get back to you.</p>
        <div class="d-flex justify-content-center flex-wrap gap-6">
          <a href="javascript:void(0);" class="btn btn-primary">Visit our community</a>
          <a href="javascript:void(0);" class="btn btn-primary">Contact us</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Help Area: End -->
@endsection
