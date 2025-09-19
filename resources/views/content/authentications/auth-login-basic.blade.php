@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login Basic - Pages')

@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

@section('page-style')
@vite([
    'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('vendor-script')
@vite([
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite([
    'resources/assets/js/pages-auth.js'
])
@endsection

@section('content')
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
    <div class="authentication-inner py-6">
      <!-- Login -->
      <div class="card p-md-7 p-1">
        <!-- Logo -->
        <div class="app-brand justify-content-center mt-5">
          <a href="{{ url('/') }}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros')</span>
            <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
          </a>
        </div>
        <!-- /Logo -->

        <div class="card-body mt-1">
          <h4 class="mb-1">Welcome to {{ config('variables.templateName') }}! 👋</h4>
          <p class="mb-5">Please sign-in to your account and start the adventure</p>

          <form id="formAuthentication" class="mb-5" action="{{ route('auth.login') }}" method="POST">
            @csrf
            <!-- Email / Username -->
            <div class="form-floating form-floating-outline mb-5 form-control-validation">
              <input type="text" class="form-control" id="email" name="email"
                     placeholder="Enter your email or username" autofocus />
              <label for="email">Email or Username</label>
            </div>

            <!-- Password -->
            <div class="mb-5">
              <div class="form-password-toggle form-control-validation">
                <div class="input-group input-group-merge">
                  <div class="form-floating form-floating-outline">
                    <input type="password" id="password" class="form-control" name="password"
                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                    <label for="password">Password</label>
                  </div>
                  <span class="input-group-text cursor-pointer"><i class="icon-base ri ri-eye-off-line icon-20px"></i></span>
                </div>
              </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="mb-5 d-flex justify-content-between mt-5">
              <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="remember" id="remember-me" />
                <label class="form-check-label" for="remember-me"> Remember Me </label>
              </div>
              <a href="{{ url('auth/forgot-password-basic') }}" class="float-end mb-1 mt-2">
                <span>Forgot Password?</span>
              </a>
            </div>

            <!-- Submit -->
            <div class="mb-5">
              <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
            </div>
          </form>

          <!-- Register -->
          <p class="text-center mb-5">
            <span>New on our platform?</span>
            <a href="{{ url('auth/register-basic') }}">
              <span>Create an account</span>
            </a>
          </p>

          <!-- Social Login -->
          <div class="divider my-5">
            <div class="divider-text">or</div>
          </div>
          <div class="d-flex justify-content-center gap-2">
            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-facebook">
              <i class="icon-base ri ri-facebook-fill icon-18px"></i>
            </a>
            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-twitter">
              <i class="icon-base ri ri-twitter-fill icon-18px"></i>
            </a>
            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-github">
              <i class="icon-base ri ri-github-fill icon-18px"></i>
            </a>
            <a href="javascript:;" class="btn btn-icon btn-lg rounded-pill btn-text-google-plus">
              <i class="icon-base ri ri-google-fill icon-18px"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- /Login -->

      <!-- Background Mask -->
      <img alt="mask" src="{{ asset('assets/img/illustrations/auth-basic-login-mask-'.$configData['theme'].'.png') }}"
           class="authentication-image d-none d-lg-block"
           data-app-light-img="illustrations/auth-basic-login-mask-light.png"
           data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
    </div>
  </div>
</div>
@endsection
