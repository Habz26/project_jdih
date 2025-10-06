<div class="table-responsive mt-3">
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
                    <td>
                        <a href="{{ route('documents.showVerifikasi', $doc->id) }}" class="text-decoration-none text-dark fw-semibold">
                            {{ \Illuminate\Support\Str::limit($doc->judul, 35) }}
                        </a>
                    </td>
                    <td class="text-center"><span class="badge bg-light text-dark">{{ $doc->tipe_dokumen ?? '-' }}</span></td>
                    <td class="text-center">{{ $doc->tahun ?? '-' }}</td>
                    <td class="text-center">
                        @if ($doc->status_verifikasi == '2')
                            <span class="badge bg-success">Terverifikasi</span>
                        @elseif ($doc->status_verifikasi == '0')
                            <span class="badge bg-danger">Batal</span>
                        @elseif ($doc->status_verifikasi == '1')
                            <span class="badge bg-warning text-dark">Menunggu...</span>
                        @elseif ($doc->status_verifikasi == '3')
                            <span class="badge bg-warning text-dark">Butuh Perbaikan</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('documents.showVerifikasi', $doc->id) }}" class="btn btn-info btn-sm me-1"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil"></i></a>
                        <a href="{{ asset('storage/' . $doc->pdf_file) }}" class="btn btn-success btn-sm me-1" download><i class="bi bi-download"></i></a>
                        <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus dokumen ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Tidak ada dokumen</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
