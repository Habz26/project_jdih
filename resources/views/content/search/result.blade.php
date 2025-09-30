@extends('layouts.blankLayout')
@section('title', 'Hasil Pencarian - RSKK')
@section('content')

    <div class="container py-4 mt-12">
        <form action="{{ route('search') }}" method="GET"
            class="input-wrapper my-4 input-group input-group-merge position-relative mx-auto" style="max-width: 480px;">

            <span class="input-group-text">
                <i class="ri ri-search-line"></i>
            </span>

            <input type="text" name="q" class="form-control" placeholder="Search dokumen..."
                value="{{ request('q') }}" required>

            <button class="btn btn-primary" type="submit">
                Cari
            </button>
        </form>
        <button onclick="window.history.back()" class="btn btn-outline-primary mb-3">
            ⬅ Kembali
        </button>
        <h4>Hasil Pencarian untuk: <strong>{{ $q }}</strong></h4>
        @if ($results->isEmpty())
            <p class="text-muted mt-3">Nggak ada dokumen yang cocok dengan pencarian kamu.</p>
        @else
            <div class="card shadow-sm border-0 mt-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk Hukum</th>
                                    <th>Tentang</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $dokumen)
                                    <tr>
                                        <td>
                                            <strong>{{ $dokumen->jenis_dokumen }}</strong><br>
                                            Nomor {{ $dokumen->nomor }} Tahun {{ $dokumen->tahun }}
                                        </td>
                                        <td>
                                            <a href="{{ route('documents.show', $dokumen->id) }}"
                                                class="fw-semibold text-primary text-decoration-none">
                                                {{ $dokumen->judul }}
                                            </a>
                                        </td>

                                        <td>
                                            @if ($dokumen->status == 'berlaku')
                                                <span class="badge bg-success rounded-pill px-3">Berlaku</span>
                                            @else
                                                <span class="badge bg-danger rounded-pill px-3">Tidak Berlaku</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ asset('storage/dokumen/' . $dokumen->file) }}"
                                                class="btn btn-sm btn-info rounded-pill px-3" target="_blank">
                                                Unduh
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
