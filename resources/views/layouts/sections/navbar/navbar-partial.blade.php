@php
  use Illuminate\Support\Facades\Auth;
@endphp

<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme px-3"
  id="layout-navbar">

  <!-- Left side -->
  <div class="d-flex align-items-center me-auto mt-2 mb-2 mb-xl-0">
    <!-- Brand -->
    @auth
      <a href="{{ route('dashboard-analytics-pages') }}" class="navbar-brand me-4">
        <span class="fw-bold fs-5">Dashboard Management</span>
      </a>
    @else
      <a href="{{ url('/') }}" class="navbar-brand me-4">
        <span class="fw-bold fs-5">Document Portal</span>
      </a>
    @endauth

    <!-- Search Form -->
    <form action="{{ route('search') }}" method="GET" class="d-flex" style="min-width: 280px;">
      <input type="text" name="q" class="form-control rounded-start" placeholder="Search..." value="{{ request('q') }}">
      <button class="btn btn-outline-secondary rounded-end" type="submit">
        <i class="ri ri-search-line"></i>
      </button>
    </form>
  </div>

  <!-- Right side -->
  <ul class="navbar-nav flex-row align-items-center">

    {{-- Kalau Guest --}}
    {{-- @guest
      <li class="nav-item me-2">
        <a href="{{ route('auth-login-basic') }}" class="btn btn-outline-primary">Login</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('auth-register-basic') }}" class="btn btn-primary">Register</a>
      </li>
    @endguest --}}

    {{-- Kalau sudah login --}}
    @auth
      {{-- Contoh: fitur khusus user login --}}
      <li class="nav-item me-3">
        <a href="{{ route('documents.index') }}" class="nav-link">
          <i class="ri ri-file-list-line me-1"></i> Dokumen
        </a>
      </li>

      {{-- Kalau role admin/operator bisa akses input dokumen --}}
      @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('operator'))
        <li class="nav-item me-3">
          <a href="{{ route('documents.create') }}" class="btn btn-sm btn-success">
            <i class="ri ri-add-line"></i> Input Document
          </a>
        </li>
      @endif

      <!-- User Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button"
          data-bs-toggle="dropdown" aria-expanded="false">
          <i class="ri ri-user-line me-2"></i>
          <span>{{ Auth::user()->username ?? Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li>
            <a class="dropdown-item" href="{{ url('pages/account-settings-account') }}">
              <i class="ri ri-settings-4-line me-2"></i> Settings
            </a>
          </li>
          <li>
            <form method="POST" action="{{ route('auth.logout') }}">
              @csrf
              <button type="submit" class="dropdown-item">
                <i class="ri ri-logout-box-r-line me-2"></i> Logout
              </button>
            </form>
          </li>
        </ul>
      </li>
    @endauth
  </ul>
</nav>
<!-- /Navbar -->
