@extends('layouts.layoutMaster')

@section('page-style')
    <style>
        .table thead {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table tbody tr:hover {
            background-color: #fdfdfd;
        }

        .badge {
            font-size: 0.8rem;
            padding: .4em .7em;
        }

        .btn-sm {
            border-radius: 6px;
            padding: .35rem .7rem;
        }

        .table td,
        .table th {
            vertical-align: middle;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .card {
            border-radius: 10px;
            border: 1px solid #eaeaea;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <h4 class="mb-2 mb-md-0 fw-bold">Status Verifikasi Dokumen</h4>

                <div class="d-flex gap-2">
                    <form action="{{ route('status-dokumen.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-sm me-2"
                            placeholder="Cari dokumen..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tipe Dokumen</th>
                                <th>Tahun</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($documents as $doc)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td style="max-width: 250px; white-space: normal; word-wrap: break-word;">
                                        <a href="{{ route('status-dokumen.show', $doc->id) }}"
                                            class="text-decoration-none text-dark fw-semibold">
                                            {{ \Illuminate\Support\Str::limit($doc->judul, 255) }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">{{ $doc->tipe_dokumen }}</span>
                                    </td>
                                    <td class="text-center">{{ $doc->tahun }}</td>
                                    <td class="text-center">
                                        @if ($doc->status_verifikasi == '2')
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @elseif ($doc->status_verifikasi == '0')
                                            <span class="badge bg-danger">Batal</span>
                                        @elseif ($doc->status_verifikasi == '1')
                                            <span class="badge bg-warning text-dark">Menunggu..</span>
                                        @elseif ($doc->status_verifikasi == '3')
                                            <span class="badge bg-warning text-dark">Butuh Perbaikan</span>
                                        @endif
                                    </td>
                                    <td style="max-width: 250px; white-space: normal; word-wrap: break-word;">
                                        <span title="{{ $doc->catatan_admin }}">
                                            {{ $doc->catatan_admin ? \Illuminate\Support\Str::limit($doc->catatan_admin, 255, '...') : '-' }}
                                        </span>
                                    </td>
                                    <td class="">
                                        <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-info btn-sm me-1"
                                            title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if ($doc->status_verifikasi != 2)
                                            <a href="{{ route('documents.edit', $doc->id) }}"
                                                class="btn btn-warning btn-sm me-1" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Belum ada dokumen
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection