<div class="table-responsive mt-3">
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
                    <td style="max-width: 200px; white-space: normal; word-wrap: break-word;">
                        <a href="{{ route('documents.showVerifikasi', $doc->id) }}"
                            class="text-decoration-none text-dark fw-semibold">
                            {{ \Illuminate\Support\Str::limit($doc->judul, 255) }}
                        </a>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark" style="min-width:140px; display:inline-flex; align-items:center; justify-content:center; color:white; font-weight:500; border-radius:.395rem;">
                            {{ $tipeDokumenMap[$doc->tipe_dokumen] ?? $doc->tipe_dokumen }}
                        </span>
                    </td>
                    <td class="text-center">{{ $doc->tahun ?? '-' }}</td>
                    <td class="text-center">
                        <span class="badge d-inline-flex align-items-center justify-content-center"
                            style="min-width: 140px; @if ($doc->status_verifikasi == '2') background-color: #28a745; color: #fff; @endif @if ($doc->status_verifikasi == '0') background-color: #dc3545; color: #fff; @endif @if ($doc->status_verifikasi == '1') background-color: #ffc107; color: #212529; @endif @if ($doc->status_verifikasi == '3') background-color: #fd7e14; color: #fff; @endif">
                            @if ($doc->status_verifikasi == '2')
                                <i class="bi bi-check-circle-fill me-1"></i> Terverifikasi
                            @elseif ($doc->status_verifikasi == '0')
                                <i class="bi bi-x-circle-fill me-1"></i> Batal
                            @elseif ($doc->status_verifikasi == '1')
                                <i class="bi bi-clock-fill me-1"></i> Menunggu..
                            @elseif ($doc->status_verifikasi == '3')
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Butuh Perbaikan
                            @endif
                        </span>
                    </td>
                    <td style="max-width: 200px; white-space: normal; word-wrap: break-word;">
                        {{ $doc->catatan_admin ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('documents.showVerifikasi', $doc->id) }}" class="btn btn-info btn-sm me-1"><i
                                class="bi bi-eye"></i></a>
                        <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-warning btn-sm me-1"><i
                                class="bi bi-pencil"></i></a>
                        <a href="{{ asset('storage/' . $doc->pdf_file) }}" class="btn btn-success btn-sm me-1"
                            download><i class="bi bi-download"></i></a>
                        <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin mau hapus dokumen ini?')">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="return_url" value="{{ url()->current() }}">
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
