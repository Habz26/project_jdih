@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Verifikasi Email Basic - Halaman')

@section('page-style')
<!-- Page -->
@vite('resources/assets/vendor/scss/pages/page-auth.scss')
@endsection

@section('content')
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
    <div class="authentication-inner py-6">
      <div class="card p-md-7 p-1">
        <!-- Logo -->
        <div class="app-brand justify-content-center mt-5">
          <a href="{{url('/')}}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros')</span>
            <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
          </a>
        </div>
        <!-- /Logo -->

        <!-- Verifikasi Email -->
        <div class="card-body mt-1">
          <h4 class="mb-1">Verifikasi email Anda ✉️</h4>
          <p class="text-start mb-0">
            Tautan aktivasi akun telah dikirim ke alamat email Anda:
            <span class="h6">hello@example.com</span>.
            Silakan ikuti tautan di dalam email untuk melanjutkan.
          </p>
          <a class="btn btn-primary w-100 my-5" href="{{url('/')}}"> Lewati untuk sekarang </a>
          <p class="text-center mb-0">
            Tidak menerima email?
            <a href="javascript:void(0);"> Kirim ulang </a>
          </p>
        </div>
      </div>
      <img alt="mask" src="{{asset('assets/img/illustrations/auth-basic-login-mask-'.$configData['theme'].'.png')}}"
        class="authentication-image d-none d-lg-block"
        data-app-light-img="illustrations/auth-basic-login-mask-light.png"
        data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
      <!-- /Verifikasi Email -->
    </div>
  </div>
</div>
@endsection
