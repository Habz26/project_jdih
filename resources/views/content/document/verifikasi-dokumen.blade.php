@extends('layouts.autoLayout')

@section('page-content')
    <div class="container">
        <div class="row">
            <!-- Kolom Kiri: Preview File -->
            <div class="col-md-8">
                @php
                    $filePath = $document->pdf_file ? url('storage/' . $document->pdf_file) : null;
                    $extension = $document->pdf_file
                        ? \Illuminate\Support\Str::lower(pathinfo($document->pdf_file, PATHINFO_EXTENSION))
                        : '';
                    $isPdf = $extension === 'pdf';
                    $isOffice = in_array($extension, ['docx', 'xlsx', 'pptx']);
                @endphp

                @if ($filePath)
                    @if ($isPdf)
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <button id="prev-page" class="btn btn-secondary btn-sm">⬅ Sebelumnya</button>
                                <button id="next-page" class="btn btn-secondary btn-sm">Berikutnya ➡</button>
                            </div>
                            <div>
                                <input type="number" id="page-num" class="form-control d-inline-block" value="1"
                                    min="1" style="width:80px;"> /
                                <span id="page-count">0</span>
                            </div>
                            <div class="me-2">
                                <button id="zoom-in" class="btn btn-info btn-sm">Zoom +</button>
                                <button id="zoom-out" class="btn btn-info btn-sm">Zoom -</button>
                                <a href="{{ $filePath }}" class="btn btn-success btn-sm" download>Unduh</a>
                                <button onclick="window.history.back()" class="btn btn-outline-info btn-sm">⬅
                                    Kembali</button>
                            </div>
                        </div>
                        <div id="pdf-container"
                            style="border:1px solid #ccc; height:800px; overflow:auto; text-align:center;">
                            <canvas id="pdf-render" style="max-width:100%; height:auto;"></canvas>
                        </div>
                    @elseif($isOffice)
                        <iframe
                            src="http://172.20.0.59:8080/web-apps/apps/documenteditor/main/index.html?fileUrl={{ urlencode($filePath) }}"
                            width="100%" height="600" frameborder="0"></iframe>
                        <div class="mt-2">
                            <a href="{{ $filePath }}" class="btn btn-success btn-sm" download>Unduh</a>
                        </div>
                    @else
                        <p>Format file tidak didukung untuk preview.</p>
                    @endif
                @else
                    <p class="text-muted">Belum ada file diunggah.</p>
                @endif

                <!-- Catatan & Tombol Aksi -->
                <form action="{{ route('documents.updateStatusVerifikasi', $document->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mt-4 card p-3 shadow-sm">
                        <h6><strong>Catatan Verifikasi</strong></h6>
                        <textarea name="catatan_admin" class="form-control mb-3" rows="4" placeholder="Tuliskan catatan di sini...">{{ old('catatan', $document->catatan_verifikasi ?? '') }}</textarea>

                        <div class="d-flex gap-2">
                            <button type="submit" name="status_verifikasi" value="0" class="btn btn-secondary">❌
                                Batal</button>
                            <button type="submit" name="status_verifikasi" value="2" class="btn btn-success">✅
                                Verifikasi</button>
                            <button type="submit" name="status_verifikasi" value="3"
                                class="btn btn-warning text-white">⚠️ Butuh Perbaikan</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Kolom Kanan: Informasi Dokumen -->
            <div class="col-md-4">
                <h5>Informasi Dokumen</h5>
                <ul class="list-group">
                    @foreach ([
            'Tipe Dokumen' => $document->tipe_dokumen,
            'Bidang Hukum' => $document->bidang_hukum,
            'Jenis Hukum' => $document->jenis_hukum,
            'Jenis Dokumen' => $document->jenisDokumenRef->deskripsi ?? '-',
            'Tahun' => $document->tahun,
            'Judul' => $document->judul,
            'Tempat Penetapan' => $document->tempat_penetapan,
            'Tanggal Penetapan' => $document->tanggal_penetapan ? \Carbon\Carbon::parse($document->tanggal_penetapan)->format('d-m-Y') : '-',
            'Tanggal Pengundangan' => $document->tanggal_pengundangan ? \Carbon\Carbon::parse($document->tanggal_pengundangan)->format('d-m-Y') : '-',
            'Periode Berlaku' => $document->jenis_dokumen == 5 ? $document->periode_berlaku . ' Tahun' : null,
            'Sumber' => $document->sumber,
            'Subjek' => $document->subjek,
            'Bahasa' => $document->bahasa,
            'Lokasi' => $document->lokasi,
            'Urusan Pemerintahan' => $document->urusan_pemerintahan,
            'Penandatanganan' => $document->penandatanganan,
            'Pemrakarsa' => $document->pemrakarsa,
            'Status' => $document->statusDokumenRef->deskripsi ?? '-',
            'Keterangan' => $document->keterangan_dokumen,
        ] as $label => $value)
                        <li class="list-group-item"><strong>{{ $label }}:</strong> {{ $value ?? '-' }}</li>
                    @endforeach
                    <li class="list-group-item"><strong>Keterangan Dokumen:</strong>
                        @if ($document->keteranganDoc)
                            <a href="{{ asset('storage/' . $document->keteranganDoc->pdf_file) }}"
                                target="_blank">{{ $document->keteranganDoc->judul }}</a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </li>
                    <li class="list-group-item"><strong>Tanggal Perubahan:</strong>
                        {{ $document->tanggal_perubahan ? \Carbon\Carbon::parse($document->tanggal_perubahan)->format('d-m-Y') : '-' }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @if ($isPdf && $filePath)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
        <script>
            const url = "{{ $filePath }}";
            let pdfDoc = null,
                pageNum = 1,
                pageIsRendering = false,
                pageNumIsPending = null,
                scale = 1.5;
            const canvas = document.getElementById('pdf-render'),
                ctx = canvas.getContext('2d');

            const renderPage = num => {
                pageIsRendering = true;
                pdfDoc.getPage(num).then(page => {
                    const viewport = page.getViewport({
                        scale
                    });
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;
                    page.render({
                        canvasContext: ctx,
                        viewport
                    }).promise.then(() => {
                        pageIsRendering = false;
                        if (pageNumIsPending !== null) {
                            renderPage(pageNumIsPending);
                            pageNumIsPending = null;
                        }
                    });
                    document.getElementById('page-num').value = num;
                    document.getElementById('page-count').textContent = pdfDoc.numPages;
                });
            };

            const queueRenderPage = num => pageIsRendering ? pageNumIsPending = num : renderPage(num);

            document.getElementById('prev-page').addEventListener('click', () => {
                if (pageNum > 1) {
                    pageNum--;
                    queueRenderPage(pageNum);
                }
            });
            document.getElementById('next-page').addEventListener('click', () => {
                if (pageNum < pdfDoc.numPages) {
                    pageNum++;
                    queueRenderPage(pageNum);
                }
            });
            document.getElementById('page-num').addEventListener('change', (e) => {
                let p = parseInt(e.target.value);
                if (p >= 1 && p <= pdfDoc.numPages) {
                    pageNum = p;
                    queueRenderPage(pageNum);
                }
            });
            document.getElementById('zoom-in').addEventListener('click', () => {
                scale += 0.2;
                queueRenderPage(pageNum);
            });
            document.getElementById('zoom-out').addEventListener('click', () => {
                if (scale > 0.4) {
                    scale -= 0.2;
                    queueRenderPage(pageNum);
                }
            });

            pdfjsLib.getDocument(url).promise.then(pdf => {
                pdfDoc = pdf;
                renderPage(pageNum);
            });
        </script>
    @endif
@endsection
