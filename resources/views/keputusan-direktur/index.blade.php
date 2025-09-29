@extends('layouts/layoutMaster')

@section('title', 'Keputusan Direktur - JDIH')

@section('content')
<section class="section-py first-section-pt">
  <div class="container">
    <div class="row g-6">
      
      <!-- Konten Utama -->
      <div class="col-lg-9">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Keputusan Direktur</li>
          </ol>
        </nav>

        <h4 class="mb-4">Dokumen Keputusan Direktur</h4>

        <!-- Search -->
        <div class="input-group input-group-merge mb-4">
          <span class="input-group-text"><i class="ri ri-search-line"></i></span>
          <input type="text" class="form-control" placeholder="Cari dokumen..." />
        </div>

        <!-- Table -->
        <div class="card">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th>Produk Hukum</th>
                  <th>Tentang</th>
                  <th>Status</th>
                  <th>Detail</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Keputusan Direktur No. 01/2025</td>
                  <td>Tentang Standar Operasional Layanan</td>
                  <td><span class="badge bg-success">Berlaku</span></td>
                  <td><a href="#" class="btn btn-sm btn-primary">Unduh</a></td>
                </tr>
                <tr>
                  <td>Keputusan Direktur No. 02/2025</td>
                  <td>Tentang Pengelolaan Perizinan</td>
                  <td><span class="badge bg-success">Berlaku</span></td>
                  <td><a href="#" class="btn btn-sm btn-primary">Unduh</a></td>
                </tr>
                <tr>
                  <td>Keputusan Direktur No. 03/2025</td>
                  <td>Tentang Penetapan Tarif Layanan</td>
                  <td><span class="badge bg-warning">Direvisi</span></td>
                  <td><a href="#" class="btn btn-sm btn-primary">Unduh</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation" class="mt-4">
          <ul class="pagination justify-content-end">
            <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Selanjutnya</a></li>
          </ul>
        </nav>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-3">
        <div class="bg-lightest py-2 px-4 rounded-3 mb-4">
          <h5 class="mb-0">Kategori Dokumen</h5>
        </div>
        <ul class="list-unstyled mt-3">
          <li class="mb-2">
            <a href="#" class="d-flex justify-content-between align-items-center text-heading">
              Peraturan Gubernur
              <span class="badge bg-label-primary">1022</span>
            </a>
          </li>
          <li class="mb-2">
            <a href="#" class="d-flex justify-content-between align-items-center text-heading">
              Keputusan Bupati
              <span class="badge bg-label-primary">447</span>
            </a>
          </li>
          <li class="mb-2">
            <a href="#" class="d-flex justify-content-between align-items-center text-heading">
              Peraturan Daerah
              <span class="badge bg-label-primary">582</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
@endsection
