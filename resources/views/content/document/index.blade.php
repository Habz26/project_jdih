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
                <h4 class="mb-2 mb-md-0 fw-bold">Daftar Dokumen <i>(terverifikasi)</i></h4>

                <div class="d-flex gap-2">
                    <form action="{{ route('documents.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-sm me-2"
                            placeholder="Cari dokumen..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Dokumen
                    </a>
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($documents as $doc)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td style="max-width: 250px; white-space: normal; word-wrap: break-word;">
                                        <a href="{{ route('documents.show', $doc->id) }}"
                                            class="text-decoration-none text-dark fw-semibold">
                                            {{ \Illuminate\Support\Str::limit($doc->judul, 255) }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark"
                                            style="min-width:140px; display:inline-flex; align-items:center; justify-content:center; color:white; font-weight:500; border-radius:.395rem;">{{ $doc->tipe_dokumen_nama }}</span>
                                    </td>
                                    <td class="text-center">{{ $doc->tahun }}</td>
                                    <td class="text-center">
                                        @if ($doc->status == '2')
                                            <span
                                                style="min-width:160px; display:inline-flex; align-items:center; justify-content:center; color:white; font-weight:300; background-color:green; border-radius:.395rem;">
                                                <i class="bi bi-check-circle-fill me-1"></i> Berlaku
                                            </span>
                                        @elseif ($doc->status == '0')
                                            <span
                                                style="min-width:160px; display:inline-flex; align-items:center; justify-content:center; color:white; font-weight:300; background-color:red; border-radius:.395rem;">
                                                <i class="bi bi-x-circle-fill me-1"></i> Tidak Berlaku
                                            </span>
                                        @elseif ($doc->status == '1')
                                            <span
                                                style="min-width:160px; display:inline-flex; align-items:center; justify-content:center; color:black; font-weight:300; background-color:yellow; border-radius:.395rem;">
                                                <i class="bi bi-exclamation-circle-fill me-1"></i> Berlaku Sebagian
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-info btn-sm me-1"
                                            title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('documents.edit', $doc->id) }}"
                                            class="btn btn-warning btn-sm me-1" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ asset('storage/' . $doc->pdf_file) }}"
                                            class="btn btn-success btn-sm me-1" download title="Unduh">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <form action="{{ route('documents.destroy', $doc->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin mau hapus dokumen ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="return_url" value="{{ url()->current() }}">
                                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
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
