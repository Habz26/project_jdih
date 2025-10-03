@extends('layouts.autoLayout')

@section('title', 'Keputusan Direktur - RSKK')

@section('content')
    <section class="section-py first-section-pt py-4 mt-5">
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

                    <button onclick="window.history.back()" class="btn btn-outline-primary mb-3 float-end me-2">
                        ⬅ Kembali
                    </button>
                    <h4 class="mb-4">Dokumen Keputusan Direktur</h4>


                    <!-- Search -->
                    <!-- Search -->
                    <form action="{{ route('keputusan-direktur') }}" method="GET" class="mb-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ri ri-search-line"></i></span>
                            <input type="text" name="q" class="form-control" placeholder="Cari dokumen..."
                                value="{{ request('q') }}" />
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="card shadow-sm border-0">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 25%">Produk Hukum</th>
                                            <th style="width: 45%">Tentang</th>
                                            <th style="width: 15%">Status</th>
                                            <th style="width: 15%">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($keputusanDirektur as $dokumen)
                                            <tr>
                                                <td>
                                                    <span class="fw-semibold">{{ $dokumen->jenisDOkumenRef->deskripsi ?? 'Tidak Diketehui!' }}</span><br>
                                                    {{ $dokumen->nomor }} Tahun {{ $dokumen->tahun }}
                                                </td>
                                                <td>{{ $dokumen->judul }}</td>
                                                <td>
                                                    @if ($dokumen->status == '2')
                                                        <span class="badge rounded-pill bg-success px-3 py-2">
                                                            ✅ Berlaku
                                                        </span>
                                                    @elseif ($dokumen->status == '0')
                                                        <span class="badge rounded-pill bg-danger px-3 py-2">
                                                            ❌ Tidak Berlaku
                                                        </span>
                                                    @elseif ($dokumen->status == '1')
                                                        <span class="badge rounded-pill bg-warning px-3 py-2">
                                                            ⚠️ Berlaku Sebagian
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('documents.show', $dokumen->id) }}"
                                                            class="btn btn-sm btn-primary rounded-pill px-3">
                                                            Lihat
                                                        </a>
                                                        <a href="{{ asset('storage/dokumen/' . $dokumen->file) }}"
                                                            class="btn btn-sm btn-info rounded-pill px-3" target="_blank"
                                                            download>
                                                            Unduh
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    Belum ada dokumen keputusan Direktur yang tersedia.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
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
                        @foreach ($categoriesPeraturanGubernur as $category)
                            <li class="mb-2">
                                <a href="{{ route('peraturan-gubernur') }}"
                                    class="d-flex justify-content-between align-items-center text-heading">
                                    {{ $category->kategori }}
                                    <span class="badge bg-label-primary">{{ $category->total }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <ul class="list-unstyled mt-3">
                        @foreach ($categoriesKeputusanGubernur as $category)
                            <li class="mb-2">
                                <a href="{{ route('keputusan-gubernur') }}"
                                    class="d-flex justify-content-between align-items-center text-heading">
                                    {{ $category->kategori }}
                                    <span class="badge bg-label-primary">{{ $category->total }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <ul class="list-unstyled mt-3">
                        @foreach ($categories as $category)
                            <li class="mb-2">
                                <a href="{{ route('keputusan-direktur') }}"
                                    class="d-flex justify-content-between align-items-center text-heading">
                                    {{ $category->kategori }}
                                    <span class="badge bg-label-primary">{{ $category->total }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <ul class="list-unstyled mt-3">
                        @foreach ($categoriesPeraturanDirektur as $category)
                            <li class="mb-2">
                                <a href="{{ route('peraturan-direktur') }}"
                                    class="d-flex justify-content-between align-items-center text-heading">
                                    {{ $category->kategori }}
                                    <span class="badge bg-label-primary">{{ $category->total }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <ul class="list-unstyled mt-3">
                        @foreach ($categoriesPerizinan as $category)
                            <li class="mb-2">
                                <a href="{{ route('perizinan') }}"
                                    class="d-flex justify-content-between align-items-center text-heading">
                                    {{ $category->kategori }}
                                    <span class="badge bg-label-primary">{{ $category->total }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <ul class="list-unstyled mt-3">
                        @foreach ($categoriesSOP as $category)
                            <li class="mb-2">
                                <a href="{{ route('sop') }}"
                                    class="d-flex justify-content-between align-items-center text-heading">
                                    {{ $category->kategori }}
                                    <span class="badge bg-label-primary">{{ $category->total }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
