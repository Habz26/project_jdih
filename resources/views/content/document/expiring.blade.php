@extends('layouts.layoutMaster')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="container mt-4">
        <h4 class="mb-4">Masa Berlaku Dokumen</h4>

        @if ($documents->count() > 0)
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($documents as $doc)
                    @php
                        // Tanggal penetapan dokumen
                        $tanggalPenetapan = Carbon::parse($doc->tanggal_penetapan)->startOfDay();
                        // Tanggal expired = 6 bulan setelah penetapan
                        $expiredAt = $tanggalPenetapan->copy()->addMonths(6);
                        // Hitung selisih hari dari tanggal penetapan ke expired
                        $daysLeft = $tanggalPenetapan->diffInDays($expiredAt, false); // bisa negatif kalau tanggal expired sebelum penetapan, tapi biasanya positif
                        // Tentukan text & badge berdasarkan sisa hari
                        if ($daysLeft < 0) {
                            $daysText = 'sudah expired ' . abs($daysLeft) . ' hari dari tanggal penetapan';
                            $badgeClass = 'bg-danger';
                        } elseif ($daysLeft > 0) {
                            $daysText = 'akan expired dalam ' . $daysLeft . ' hari dari tanggal penetapan';
                            $badgeClass = $daysLeft <= 30 ? 'bg-warning text-dark' : 'bg-success';
                        } else {
                            $daysText = 'expired hari ini';
                            $badgeClass = 'bg-warning text-dark';
                        }
                    @endphp


                    <div class="col d-flex">
                        <div class="card shadow-sm border-0 flex-fill">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $doc->judul ?? 'Tanpa Judul' }}</h5>
                                <p class="card-text mb-1">
                                    Expired: <strong>{{ $expiredAt->format('d M Y') }}</strong>
                                </p>
                                <div class="mt-auto">
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($daysText) }}</span>
                                    <a href="{{ route('documents.show', $doc->id) }}"
                                        class="btn btn-sm btn-primary mt-2 w-100">Lihat Detail</a>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                Belum ada dokumen yang diverifikasi.
            </div>
        @endif
    </div>
@endsection
