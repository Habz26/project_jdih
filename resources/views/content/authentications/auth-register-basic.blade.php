@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Register Basic - Pages')

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
      <!-- Register Card -->
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
          <h4 class="mb-1">Adventure starts here 🚀</h4>
          <p class="mb-5">Make your app management easy and fun!</p>

          <form id="formAuthentication" class="mb-5" action="{{ route('auth.register') }}" method="POST">
            @csrf

            <!-- Username -->
            <div class="form-floating form-floating-outline mb-3 form-control-validation">
              <input type="text" class="form-control @error('name') is-invalid @enderror" 
                     id="username" name="name" value="{{ old('name') }}" placeholder="Enter your username" autofocus />
              <label for="username">Username</label>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Email -->
            <div class="form-floating form-floating-outline mb-3 form-control-validation">
              <input type="email" class="form-control @error('email') is-invalid @enderror" 
                     id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" />
              <label for="email">Email</label>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Password -->
            <div class="mb-3 form-password-toggle form-control-validation">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline flex-grow-1">
                  <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                         name="password" placeholder="••••••••••••" aria-describedby="password" />
                  <label for="password">Password</label>
                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <span class="input-group-text cursor-pointer"><i class="icon-base ri ri-eye-off-line icon-20px"></i></span>
              </div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3 form-password-toggle form-control-validation">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline flex-grow-1">
                  <input type="password" id="password_confirmation" 
                         class="form-control @error('password_confirmation') is-invalid @enderror" 
                         name="password_confirmation" placeholder="••••••••••••" />
                  <label for="password_confirmation">Confirm Password</label>
                  @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <span class="input-group-text cursor-pointer"><i class="icon-base ri ri-eye-off-line icon-20px"></i></span>
              </div>
            </div>

            <!-- Terms -->
            <div class="mb-3 form-check">
              <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" 
                     id="terms-conditions" name="terms" {{ old('terms') ? 'checked' : '' }}>
              <label class="form-check-label" for="terms-conditions">
                I agree to <a href="javascript:void(0);">privacy policy & terms</a>
              </label>
              @error('terms')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <!-- Role -->
            <div class="mb-3 form-floating form-floating-outline">
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select role</option>
                    <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <label for="role">Role</label>
                @error('role')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary d-grid w-100 mb-5">Sign up</button>
          </form>

          <p class="text-center mb-5">
            <span>Already have an account?</span>
            <a href="{{ url('auth/login-basic') }}"><span>Sign in instead</span></a>
          </p>

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
            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-google-plus">
              <i class="icon-base ri ri-google-fill icon-18px"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- Register Card -->
      <img alt="mask" src="{{ asset('assets/img/illustrations/auth-basic-register-mask-'.$configData['theme'].'.png') }}"
           class="authentication-image d-none d-lg-block"
           data-app-light-img="illustrations/auth-basic-register-mask-light.png"
           data-app-dark-img="illustrations/auth-basic-register-mask-dark.png" />
    </div>
  </div>
</div>
@endsection
