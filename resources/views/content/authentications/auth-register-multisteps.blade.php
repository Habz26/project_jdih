@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Pendaftaran Multi Langkah - Halaman')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
'resources/assets/vendor/libs/select2/select2.scss',
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
'resources/assets/vendor/libs/cleave-zen/cleave-zen.js',
'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
'resources/assets/vendor/libs/select2/select2.js',
'resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite([
'resources/assets/js/pages-auth-multisteps.js'
])
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover">
  <!-- Logo -->
  <a href="{{url('/')}}" class="auth-cover-brand d-flex align-items-center gap-2">
    <span class="app-brand-logo demo">@include('_partials.macros')</span>
    <span class="app-brand-text demo text-heading fw-semibold">{{config('variables.templateName')}}</span>
  </a>
  <!-- /Logo -->
  <div class="authentication-inner row m-0">
    <!-- Gambar Kiri -->
    <div class="d-none d-lg-flex col-lg-3 align-items-center justify-content-center p-12 mt-12 mt-xxl-0">
      <img alt="ilustrasi-pendaftaran-multi-langkah"
        src="{{asset('assets/img/illustrations/auth-register-multi-steps-illustration.png')}}"
        class="h-auto mh-100 w-px-200" />
    </div>
    <!-- /Gambar Kiri -->

    <!--  Pendaftaran Multi Langkah -->
    <div class="d-flex col-lg-9 align-items-center justify-content-center authentication-bg p-5">
      <div class="w-px-700 mt-12 mt-lg-0 pt-lg-0 pt-4">
        <div id="multiStepsValidation" class="bs-stepper wizard-numbered shadow-none">
          <div class="bs-stepper-header border-bottom-0 mb-2">
            <div class="step" data-target="#accountDetailsValidation">
              <button type="button" class="step-trigger ps-0">
                <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-number">01</span>
                  <span class="d-flex flex-column ms-2">
                    <span class="bs-stepper-title">Akun</span>
                    <span class="bs-stepper-subtitle">Detail Akun</span>
                  </span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <div class="step" data-target="#personalInfoValidation">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-number">02</span>
                  <span class="d-flex flex-column ms-2">
                    <span class="bs-stepper-title">Pribadi</span>
                    <span class="bs-stepper-subtitle">Masukkan Informasi</span>
                  </span>
                </span>
              </button>
            </div>
            <div class="line"></div>
            <div class="step" data-target="#billingLinksValidation">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-number">03</span>
                  <span class="d-flex flex-column ms-2">
                    <span class="bs-stepper-title">Tagihan</span>
                    <span class="bs-stepper-subtitle">Detail Pembayaran</span>
                  </span>
                </span>
              </button>
            </div>
          </div>
          <div class="bs-stepper-content">
            <form id="multiStepsForm" onSubmit="return false">
              <!-- Detail Akun -->
              <div id="accountDetailsValidation" class="content">
                <div class="content-header mb-5">
                  <h4 class="mb-1">Informasi Akun</h4>
                  <span>Masukkan Detail Akun Anda</span>
                </div>
                <div class="row gx-5">
                  <div class="col-sm-6 mb-5 form-control-validation">
                    <div class="form-floating form-floating-outline">
                      <input type="text" name="multiStepsUsername" id="multiStepsUsername" class="form-control"
                        placeholder="johndoe" />
                      <label for="multiStepsUsername">Nama Pengguna</label>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-5 form-control-validation">
                    <div class="form-floating form-floating-outline">
                      <input type="email" name="multiStepsEmail" id="multiStepsEmail" class="form-control"
                        placeholder="john.doe@email.com" aria-label="john.doe" />
                      <label for="multiStepsEmail">Email</label>
                    </div>
                  </div>
                  <div class="col-sm-6 form-password-toggle mb-5 form-control-validation">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input type="password" id="multiStepsPass" name="multiStepsPass" class="form-control"
                          placeholder="************"
                          aria-describedby="multiStepsPass2" />
                        <label for="multiStepsPass">Kata Sandi</label>
                      </div>
                      <span class="input-group-text cursor-pointer" id="multiStepsPass2"><i
                          class="icon-base ri ri-eye-off-line ri-20px"></i></span>
                    </div>
                  </div>
                  <div class="col-sm-6 form-password-toggle mb-5 form-control-validation">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input type="password" id="multiStepsConfirmPass" name="multiStepsConfirmPass"
                          class="form-control"
                          placeholder="************"
                          aria-describedby="multiStepsConfirmPass2" />
                        <label for="multiStepsConfirmPass">Konfirmasi Kata Sandi</label>
                      </div>
                      <span class="input-group-text cursor-pointer" id="multiStepsConfirmPass2"><i
                          class="icon-base ri ri-eye-off-line ri-20px"></i></span>
                    </div>
                  </div>
                  <div class="col-md-12 mb-5">
                    <div class="form-floating form-floating-outline">
                      <input type="text" name="multiStepsURL" id="multiStepsURL" class="form-control"
                        placeholder="johndoe/profil" aria-label="johndoe" />
                      <label for="multiStepsURL">Tautan Profil</label>
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-outline-secondary btn-prev" disabled>
                      <i class="icon-base ri ri-arrow-left-line icon-16px me-sm-1_5 me-0"></i>
                      <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                    </button>
                    <button class="btn btn-primary btn-next"><span
                        class="align-middle d-sm-inline-block d-none me-sm-1_5 me-0">Berikutnya</span> <i
                        class="icon-base ri ri-arrow-right-line icon-16px"></i></button>
                  </div>
                </div>
              </div>
              <!-- Informasi Pribadi -->
              <div id="personalInfoValidation" class="content">
                <div class="content-header mb-5">
                  <h4 class="mb-1">Informasi Pribadi</h4>
                  <span>Masukkan Informasi Pribadi Anda</span>
                </div>
                <div class="row gx-5">
                  <div class="col-sm-6 mb-5 form-control-validation">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="multiStepsFirstName" name="multiStepsFirstName" class="form-control"
                        placeholder="John" />
                      <label for="multiStepsFirstName">Nama Depan</label>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-5">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="multiStepsLastName" name="multiStepsLastName" class="form-control"
                        placeholder="Doe" />
                      <label for="multiStepsLastName">Nama Belakang</label>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-5">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text">ID (+62)</span>
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="multiStepsMobile" name="multiStepsMobile"
                          class="form-control multi-steps-mobile" placeholder="08123456789" />
                        <label for="multiStepsMobile">Nomor HP</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-5">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="multiStepsPincode" name="multiStepsPincode"
                        class="form-control multi-steps-pincode" placeholder="Kode Pos" maxlength="6" />
                      <label for="multiStepsPincode">Kode Pos</label>
                    </div>
                  </div>
                  <div class="col-md-12 mb-5 form-control-validation">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="multiStepsAddress" name="multiStepsAddress" class="form-control"
                        placeholder="Alamat" />
                      <label for="multiStepsAddress">Alamat</label>
                    </div>
                  </div>
                  <div class="col-md-12 mb-5">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="multiStepsArea" name="multiStepsArea" class="form-control"
                        placeholder="Area/Patokan" />
                      <label for="multiStepsArea">Patokan</label>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-5 form-control-validation">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="multiStepsCity" class="form-control" placeholder="Jakarta" />
                      <label for="multiStepsCity">Kota</label>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-5 form-control-validation">
                    <div class="form-floating form-floating-outline">
                      <select id="multiStepsState" class="select2 form-select" data-allow-clear="true">
                        <option value="">Pilih</option>
                        <option value="JK">DKI Jakarta</option>
                        <option value="JB">Jawa Barat</option>
                        <option value="JT">Jawa Tengah</option>
                        <option value="JI">Jawa Timur</option>
                        <option value="YO">Yogyakarta</option>
                        <option value="BA">Bali</option>
                        <!-- dst sesuai kebutuhan -->
                      </select>
                      <label for="multiStepsState">Provinsi</label>
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-outline-secondary btn-prev">
                      <i class="icon-base ri ri-arrow-left-line icon-16px me-sm-1_5 me-0"></i>
                      <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                    </button>
                    <button class="btn btn-primary btn-next"><span
                        class="align-middle d-sm-inline-block d-none me-sm-1_5 me-0">Berikutnya</span> <i
                        class="icon-base ri ri-arrow-right-line icon-16px"></i></button>
                  </div>
                </div>
              </div>
              <!-- Tagihan -->
              <div id="billingLinksValidation" class="content">
                <div class="content-header mb-5">
                  <h4 class="mb-1">Pilih Paket</h4>
                  <span>Pilih paket sesuai kebutuhan Anda</span>
                </div>
                <!-- Opsi Paket -->
                <div class="row gap-md-0 gap-4 mb-12 gx-5">
                  <div class="col-md">
                    <div class="form-check custom-option custom-option-icon">
                      <label class="form-check-label custom-option-content" for="basicOption">
                        <span class="custom-option-body">
                          <span class="fs-6 d-block fw-medium text-heading mb-2">Dasar</span>
                          <small>Awal sederhana untuk startup & mahasiswa</small>
                          <span class="d-flex justify-content-center py-2">
                            <sup class="text-primary small lh-1 mt-3">Rp</sup>
                            <span class="h4 mb-0 text-primary">0</span>
                            <sub class="lh-1 mt-auto mb-3 text-body-secondary small">/bulan</sub>
                          </span>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="basicOption" />
                      </label>
                    </div>
                  </div>
                  <div class="col-md">
                    <div class="form-check custom-option custom-option-icon">
                      <label class="form-check-label custom-option-content" for="standardOption">
                        <span class="custom-option-body">
                          <span class="fs-6 d-block fw-medium text-heading mb-2">Standar</span>
                          <small>Untuk bisnis kecil hingga menengah</small>
                          <span class="d-flex justify-content-center py-2">
                            <sup class="text-primary small lh-1 mt-3">Rp</sup>
                            <span class="h4 mb-0 text-primary">99</span>
                            <sub class="lh-1 mt-auto mb-3 text-body-secondary small">/bulan</sub>
                          </span>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="standardOption"
                          checked />
                      </label>
                    </div>
                  </div>
                  <div class="col-md">
                    <div class="form-check custom-option custom-option-icon">
                      <label class="form-check-label custom-option-content" for="enterpriseOption">
                        <span class="custom-option-body">
                          <span class="fs-6 d-block fw-medium text-heading mb-2">Perusahaan</span>
                          <small>Solusi untuk perusahaan & organisasi</small>
                          <span class="d-flex justify-content-center py-2">
                            <sup class="text-primary small lh-1 mt-3">Rp</sup>
                            <span class="h4 mb-0 text-primary">499</span>
                            <sub class="lh-1 mt-auto mb-3 text-body-secondary small">/bulan</sub>
                          </span>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value=""
                          id="enterpriseOption" />
                      </label>
                    </div>
                  </div>
                </div>
                <!--/ Opsi Paket -->
                <div class="content-header mb-5">
                  <h4 class="mb-1">Informasi Pembayaran</h4>
                  <span>Masukkan informasi kartu Anda</span>
                </div>
                <!-- Detail Kartu Kredit -->
                <div class="row gx-5">
                  <div class="col-md-12 mb-5 form-control-validation">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input id="multiStepsCard" class="form-control multi-steps-card" name="multiStepsCard"
                          type="text" placeholder="1356 3215 6548 7898" aria-describedby="multiStepsCardImg" />
                        <label for="multiStepsCard">Nomor Kartu</label>
                      </div>
                      <span class="input-group-text cursor-pointer" id="multiStepsCardImg"><span
                          class="card-type"></span></span>
                    </div>
                  </div>
                  <div class="col-md-5 mb-5">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="multiStepsName" class="form-control" name="multiStepsName"
                        placeholder="John Doe" />
                      <label for="multiStepsName">Nama di Kartu</label>
                    </div>
                  </div>
                  <div class="col-6 col-md-4 mb-5">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="multiStepsExDate" class="form-control multi-steps-exp-date"
                        name="multiStepsExDate" placeholder="MM/YY" />
                      <label for="multiStepsExDate">Tanggal Kedaluwarsa</label>
                    </div>
                  </div>
                  <div class="col-6 col-md-3 mb-5">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="multiStepsCvv" class="form-control multi-steps-cvv" name="multiStepsCvv"
                          maxlength="3" placeholder="654" />
                        <label for="multiStepsCvv">Kode CVV</label>
                      </div>
                      <span class="input-group-text cursor-pointer" id="multiStepsCvvHelp"><i
                          class="icon-base ri ri-question-line" data-bs-toggle="tooltip" data-bs-placement="top"
                          title="Nilai Verifikasi Kartu"></i></span>
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-outline-secondary btn-prev">
                      <i class="icon-base ri ri-arrow-left-line icon-16px me-sm-1_5 me-0"></i>
                      <span class="align-middle d-sm-inline-block d-none">Sebelumnya</span>
                    </button>
                    <button type="submit" class="btn btn-success btn-next btn-submit">Kirim <i
                        class="icon-base ri ri-check-line icon-16px ms-1_5"></i></button>
                  </div>
                </div>
                <!--/ Detail Kartu Kredit -->
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- / Pendaftaran Multi Langkah -->
  </div>
</div>
@endsection
