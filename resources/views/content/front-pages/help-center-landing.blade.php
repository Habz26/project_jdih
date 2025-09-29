@extends('layouts.layoutMaster')
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

  <!-- Search Form -->
<form action="{{ route('search') }}" method="GET" 
      class="input-wrapper my-4 input-group input-group-merge position-relative mx-auto" 
      style="max-width: 480px;">
  
  <span class="input-group-text">
    <i class="ri ri-search-line"></i>
  </span>
  
  <input type="text" name="q" class="form-control" 
         placeholder="Search dokumen..." 
         value="{{ request('q') }}" required>
  
  <button class="btn btn-primary" type="submit">
    Cari
  </button>
</form>


  <p class="text-center px-4 mb-0">Akses berbagai peraturan, keputusan direktur, dan SOP perijinan dengan mudah</p>
</section>
<!-- Help Center Header: End -->


<!-- Popular Articles: Start -->
<section class="section-py">
  <div class="container">
    <h4 class="text-center mb-2">Regulasi & Pedoman Perijinan</h4>
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
            <a class="btn btn-outline-primary mt-auto" href="{{ url('peraturan-gubernur') }}">
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
            <a class="btn btn-outline-primary mt-auto" href="{{ url('keputusan-direktur') }}">
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
              <h5 class="my-3">Perizinan</h5>
              <p class="mb-3 text-muted">Arahan direktur rumah sakit mengenai ketentuan perizinan</p>
            </div>
            <a class="btn btn-outline-primary mt-auto" href="{{ url('perizinan') }}">
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
            <a class="btn btn-outline-primary mt-auto" href="{{ url('sop') }}">
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
{{-- <style>
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
</style> --}}

<div class="container mb-6">
  <div class="row">
    <!-- Kolom Kiri -->
    <div class="col-md-6">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
          <h5 class="mb-0 text-primary">Dokumen Terbaru</h5>
        </div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush">
            @foreach ($documents as $doc)
              <li class="list-group-item px-3 py-3 d-flex justify-content-between align-items-start">
                <div class="me-3">
                  <a href="{{ url('documents/'.$doc->id) }}" class="fw-bold text-primary d-block mb-1">
                    {{ \Illuminate\Support\Str::limit($doc->judul, 61) }}
                  </a>
                  <div class="text-muted small">
                    {{ \Illuminate\Support\Str::limit($doc->pemrakarsa, 100) }}
                  </div>
                </div>
                @if($doc->status === 'berlaku')
                  <span class="badge bg-warning text-dark align-self-start mt-1">Berlaku</span>
                @endif
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>


    <!-- Kolom Kanan (kosong dulu) -->
    <div class="col-md-6">
      <!-- Konten lain nanti -->
    </div>
  </div>
</div>



@endsection
