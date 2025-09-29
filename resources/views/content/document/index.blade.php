@extends('layouts.layoutMaster')
<style>
    .table td,
    .table th {
        vertical-align: middle;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }

    .table td.text-center>* {
        margin-right: 4px;
    }

    .table td.text-center>*:last-child {
        margin-right: 0;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        /* smooth scroll on mobile */
    }
</style>
@section('content')
    <div class="container">
        <h2>Daftar Dokumen</h2>
        <div class="mb-3">
            <a href="{{ route('documents.create') }}" class="btn btn-primary">+ Tambah Dokumen</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
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
                    @foreach ($documents as $doc)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $doc->judul }}</td>
                            <td>{{ $doc->tipe_dokumen }}</td>
                            <td>{{ $doc->tahun }}</td>
                            <td class="text-center">
                                @if ($doc->status == 'berlaku')
                                    <span class="badge bg-success">Berlaku</span>
                                @else
                                    <span class="badge bg-danger">Tidak Berlaku</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-info btn-sm"
                                    title="Lihat"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-warning btn-sm"
                                    title="Edit"><i class="bi bi-pencil"></i></a>
                                <a href="{{ asset('storage/' . $doc->pdf_file) }}" class="btn btn-success btn-sm" download
                                    title="Unduh"><i class="bi bi-download"></i></a>
                                <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin mau hapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus"><i
                                            class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if ($documents->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">Belum ada dokumen</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
