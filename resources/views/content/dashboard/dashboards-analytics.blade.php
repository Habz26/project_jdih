@php
$configData = Helper::appClasses();
use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts.layoutMaster')

@section('title', 'Dashboard Analisis Dokumen')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/swiper/swiper.scss'
])
@endsection

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/cards-statistics.scss'])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/swiper/swiper.js'
])
@endsection

@section('page-script')
@vite(['resources/assets/js/dashboards-analytics.js'])
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Simpan URL awal saat user pertama kali masuk
    if (!sessionStorage.getItem('startUrl')) {
        sessionStorage.setItem('startUrl', window.location.href);
    }
</script>
@endsection

@section('content')
<div class="row g-6">
  <!-- Gamification Card -->
  <div class="col-12">
    <div class="card w-100">
      <div class="d-flex align-items-end row">
        <div class="col-md-6 order-2 order-md-1">
          <div class="card-body">
            <h4 class="card-title mb-4">
              Haii <span class="fw-bold">{{ auth()->user()->name }} </span> 
              <span style="font-family:Roboto; font:lighter;">[{{ Auth::user()->role }}]</span>🎉
            </h4>
            <p class="mb-2">Selamat datang kembali di dashboard <i>Management!</i></p>
            <a href="{{ route('pages-account-settings-account') }}" class="btn btn-primary">Lihat Profil</a>
          </div>
        </div>
        <div class="col-md-6 text-center text-md-end order-1 order-md-2">
          <div class="card-body pb-0 px-0 pt-2">
            <img src="{{ asset('assets/img/illustrations/illustration-john-'.$configData['theme'].'.png') }}"
                 height="186"
                 class="scaleX-n1-rtl"
                 alt="View Profile"
                 data-app-light-img="illustrations/John-Gaya-removebg-preview.png"
                 data-app-dark-img="illustrations/John-Programmer-removebg-preview.png" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Gamification Card -->
</div>

@if(auth()->user()->role !== 'operator')
<div class="card shadow-sm border-0 mb-4 mt-4">
  <div class="card-header bg-white border-bottom">
    <h5 class="mb-0 text-primary">Pilih Periode</h5>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-3">
        <label for="filter-month" class="form-label">Pilih Bulan</label>
        <select id="filter-month" class="form-select">
          @for ($i = 1; $i <= 12; $i++)
            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $month == $i ? 'selected' : '' }}>
              {{ DateTime::createFromFormat('!m', $i)->format('F') }}
            </option>
          @endfor
        </select>
      </div>
      <div class="col-md-3">
        <label for="filter-year" class="form-label">Pilih Tahun</label>
        <select id="filter-year" class="form-select">
          @for ($i = date('Y'); $i >= 2000; $i--)
            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
          @endfor
        </select>
      </div>
      <div class="col-md-3 align-self-end">
        <button id="apply-filter" class="btn btn-primary">Terapkan</button>
      </div>
    </div>
  </div>
</div>
<div class="row g-3 mt-2">
  {{-- Top small cards (4) --}}
  <div class="col-sm-6 col-lg-3">
    <div class="card card-border-shadow-primary h-100 rounded-3 shadow-sm" style="background:#f6f3ff;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="avatar bg-white rounded-circle p-2 shadow-sm">
          <i class="ri-bar-chart-line text-primary" style="font-size:20px"></i>
        </div>
        <div>
          <h5 class="mb-0 fw-bold">{{ number_format($totalVisits) }}</h5>
          <small class="text-muted">Total Kunjungan</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card card-border-shadow-info h-100 rounded-3 shadow-sm" style="background:#fff9ea;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="avatar bg-white rounded-circle p-2 shadow-sm">
          <i class="ri-file-line text-warning" style="font-size:20px"></i>
        </div>
        <div>
          <h5 class="mb-0 fw-bold">{{ number_format($uniqueDocuments) }}</h5>
          <small class="text-muted">Dokumen Unik</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card card-border-shadow-warning h-100 rounded-3 shadow-sm" style="background:#f0fff6;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="avatar bg-white rounded-circle p-2 shadow-sm">
          <i class="ri-user-3-line text-success" style="font-size:20px"></i>
        </div>
        <div>
          <h5 class="mb-0 fw-bold">{{ number_format($uniqueUsers) }}</h5>
          <small class="text-muted">Pengguna Unik</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card card-border-shadow-success h-100 rounded-3 shadow-sm" style="background:#eef9ff;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="avatar bg-white rounded-circle p-2 shadow-sm">
          <i class="ri-line-chart-line text-info" style="font-size:20px"></i>
        </div>
        <div>
          <h5 class="mb-0 fw-bold">
            {{ $uniqueDocuments > 0 ? number_format($totalVisits / $uniqueDocuments, 2) : 0 }}
          </h5>
          <small class="text-muted">Rata-rata Kunjungan</small>
        </div>
      </div>
    </div>
  </div>

{{-- Second row: Overview + Shipment-like statistics --}}
<div class="col-12">
  <div class="card rounded-3 shadow-sm h-100">
    <div class="card-header d-flex align-items-center justify-content-between">
      <div class="card-title mb-0">
        <h5 class="m-0 me-2 mb-1">📈 Statistik Kunjungan Dokumen</h5>
        <p class="card-subtitle mb-0 text-muted">Total kunjungan: {{ number_format($totalVisits) }}</p>
      </div>
    </div>
    <div class="card-body">
      <canvas id="shipmentStatisticsChart" height="60"></canvas>
    </div>
  </div>
</div>
{{-- Dua card di bawah sejajar kiri-kanan --}}
<div class="col-lg-6 col-md-12">
  <div class="card rounded-3 shadow-sm h-100">
    <div class="card-body">
      <h6 class="fw-bold mb-3">Jenis Dokumen yang Paling Sering Dilihat</h6>
      <canvas id="donutChartCenter" height="220"></canvas>
      <div class="mt-3 small text-muted">
        Legend: top dokumen akses berdasarkan jenis dokumen.
      </div>
    </div>
  </div>
</div>

<div class="col-lg-6 col-md-12">
  <div class="card rounded-3 shadow-sm h-100">
    <div class="card-body">
      <h6 class="fw-bold mb-2">(Top Dokumen)</h6>
      <p class="text-muted small mb-3">{{ $topDocuments->count() }} dokumen teratas</p>
      <div class="list-group list-group-flush">
        @foreach($topDocuments->take(10) as $doc)
        <div class="list-group-item d-flex justify-content-between align-items-start">
          <div class="me-2">
            <div class="small text-muted">DOC</div>
            <div class="fw-semibold text-truncate">
  {{ \Illuminate\Support\Str::words($doc->judul, 6, '...') }}
</div>
          </div>
          <div class="text-end">
            <div class="fw-bold">{{ $doc->total_visits }}</div>
            <small class="text-muted">visits</small>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
</div>
@endif
{{-- Charts JS --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const visitsLabels = @json($visitsLabels);
    const visitsData = @json($visitsData);
    const topLabels = @json($topDocuments->pluck('jenis_dokumen'));
    const topData = @json($topDocuments->pluck('total_visits'));

    const maxVisits = visitsData.length ? Math.max(...visitsData) : 0;

    // Shipment chart
    const ctxShipment = document.getElementById('shipmentStatisticsChart').getContext('2d');
    new Chart(ctxShipment, {
      type: 'bar',
      data: {
        labels: visitsLabels,
        datasets: [
          {
            type: 'bar',
            label: 'Visits',
            data: visitsData,
            backgroundColor: 'rgba(255, 193, 7, 0.9)',
            borderRadius: 4,
            yAxisID: 'y',
          },
          {
            type: 'line',
            label: 'Trend',
            data: visitsData,
            borderColor: '#7266f6',
            backgroundColor: 'rgba(114,102,246,0.06)',
            tension: 0.35,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#7266f6',
            yAxisID: 'y'
          }
        ]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, ticks: { stepSize: Math.max(1, Math.ceil(maxVisits / 5)) } },
          x: { ticks: { maxRotation: 0, minRotation: 0 } }
        }
      }
    });

    // Donut chart
    const ctxDonut = document.getElementById('donutChartCenter').getContext('2d');
    new Chart(ctxDonut, {
      type: 'doughnut',
      data: {
        labels: topLabels,
        datasets: [{ data: topData,
          backgroundColor: [
            '#7b3ff3','#ffd666','#52c41a','#40a9ff','#fa8c16','#eb2f96','#13c2c2','#2f54eb','#fa541c','#73d13d'
          ]
        }]
      },
      options: {
        responsive: true,
        cutout: '70%',
        plugins: { legend: { position: 'bottom', labels: { boxWidth: 12 } } }
      }
    });

    const currentDate = new Date();
    const currentMonth = currentDate.toLocaleString('default', { month: 'long' }); // Nama bulan
    const currentYear = currentDate.getFullYear(); // Tahun

    // Set tombol bulan dan tahun saat ini
    const monthButton = document.querySelector('.btn-outline-primary.btn-sm');
    if (monthButton) {
      monthButton.textContent = `${currentMonth} ${currentYear}`;
    }

    // Dropdown bulan
    const dropdownItems = document.querySelectorAll('.dropdown-menu .dropdown-item');
    dropdownItems.forEach(item => {
      item.addEventListener('click', function () {
        const selectedMonth = this.textContent;
        if (monthButton) {
          monthButton.textContent = `${selectedMonth} ${currentYear}`;
        }
      });
    });
  });

  document.getElementById('apply-filter').addEventListener('click', function () {
    const month = document.getElementById('filter-month').value;
    const year = document.getElementById('filter-year').value;
    const url = new URL(window.location.href);

    url.searchParams.set('month', month);
    url.searchParams.set('year', year);
    url.searchParams.set('filter', 'month');

    window.location.href = url;
  });

  function updateMonth(selectedMonth) {
    const year = document.getElementById('filter-year').value; // Ambil tahun dari dropdown
    const url = new URL(window.location.href);

    url.searchParams.set('month', selectedMonth);
    url.searchParams.set('year', year);
    url.searchParams.set('filter', 'month');

    window.location.href = url;
  }
</script>
@endsection
