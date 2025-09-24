@extends('layouts.layoutMaster')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Kolom Kiri: Preview File -->
            <div class="col-md-8">
                <div class="mb-3">
                    @php
                        $filePath = asset('storage/' . $document->pdf_file); // Path file dokumen
                        $extension = \Illuminate\Support\Str::lower(pathinfo($document->pdf_file, PATHINFO_EXTENSION));
                        $isPdf = $extension === 'pdf';
                        $isOffice = in_array($extension, ['docx', 'xlsx', 'pptx']);
                    @endphp

                    @if ($isPdf)
                        {{-- Preview PDF (kode kamu yang sudah ada) --}}
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <button id="prev-page" class="btn btn-secondary btn-sm">⬅ Sebelumnya</button>
                                <button id="next-page" class="btn btn-secondary btn-sm">Berikutnya ➡</button>
                            </div>

                            <div>
                                <input type="number" id="page-num" class="form-control d-inline-block" value="1"
                                    min="1" style="width:80px;">
                                / <span id="page-count">0</span>
                            </div>

                            <div>
                                <button id="zoom-in" class="btn btn-info btn-sm">Zoom +</button>
                                <button id="zoom-out" class="btn btn-info btn-sm">Zoom -</button>
                                <a href="{{ $filePath }}" class="btn btn-success btn-sm" download>Unduh</a>
                            </div>
                        </div>

                        <div id="pdf-container"
                            style="border:1px solid #ccc; height:800px; overflow:auto; text-align:center;">
                            <canvas id="pdf-render" style="max-width:100%; height:auto;"></canvas>
                        </div>
                    @elseif($isOffice)
                        {{-- Preview DOCX, XLSX, PPTX pakai OnlyOffice iframe --}}
                        <iframe src="http://172.20.0.59:8080/web-apps/apps/documenteditor/main/index.html?fileUrl={{ urlencode($filePath) }}" width="100%" height="600" frameborder="0"></iframe>
                        <div class="mt-2">
                            <a href="{{ $filePath }}" class="btn btn-success btn-sm" download>Unduh</a>
                        </div>
                    @else
                        <p>Format file tidak didukung untuk preview.</p>
                    @endif

                </div>
            </div>

            <!-- Kolom Kanan: Informasi Dokumen -->
            <div class="col-md-4">
                <h5>Informasi Dokumen</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Tipe Dokumen:</strong> {{ $document->tipe_dokumen }}</li>
                    <li class="list-group-item"><strong>Bidang Hukum:</strong> {{ $document->bidang_hukum }}</li>
                    <li class="list-group-item"><strong>Jenis Hukum:</strong> {{ $document->jenis_hukum }}</li>
                    <li class="list-group-item"><strong>Jenis Dokumen:</strong> {{ $document->jenis_dokumen }}</li>
                    <li class="list-group-item"><strong>Tahun:</strong> {{ $document->tahun }}</li>
                    <li class="list-group-item"><strong>Judul:</strong> {{ $document->judul }}</li>
                    <li class="list-group-item"><strong>TEU Badan:</strong> {{ $document->teu_badan }}</li>
                    <li class="list-group-item"><strong>Tempat Penetapan:</strong> {{ $document->tempat_penetapan }}</li>
                    <li class="list-group-item"><strong>Tanggal Penetapan:</strong>
                        {{ \Carbon\Carbon::parse($document->tanggal_penetapan)->format('d-m-Y') }}</li>
                    <li class="list-group-item"><strong>Tanggal Pengundangan:</strong>
                        {{ \Carbon\Carbon::parse($document->tanggal_pengundangan)->format('d-m-Y') }}</li>
                    <li class="list-group-item"><strong>Sumber:</strong> {{ $document->sumber }}</li>
                    <li class="list-group-item"><strong>Subjek:</strong> {{ $document->subjek }}</li>
                    <li class="list-group-item"><strong>Bahasa:</strong> {{ $document->bahasa }}</li>
                    <li class="list-group-item"><strong>Lokasi:</strong> {{ $document->lokasi }}</li>
                    <li class="list-group-item"><strong>Urusan Pemerintahan:</strong> {{ $document->urusan_pemerintahan }}
                    </li>
                    <li class="list-group-item"><strong>Penandatanganan:</strong> {{ $document->penandatanganan }}</li>
                    <li class="list-group-item"><strong>Pemrakarsa:</strong> {{ $document->pemrakarsa }}</li>
                    <li class="list-group-item"><strong>Status:</strong> {{ $document->status }}</li>
                    <li class="list-group-item"><strong>QR Code:</strong> {{ $document->qrcode }}</li>
                </ul>
            </div>
        </div>
    </div>

    @if ($isPdf)
        <!-- PDF.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
        <script>
            const url = "{{ $filePath }}";

            let pdfDoc = null,
                pageNum = 1,
                pageIsRendering = false,
                pageNumIsPending = null,
                scale = 1.5;

            const canvas = document.getElementById('pdf-render'),
                ctx = canvas.getContext('2d'),
                container = document.getElementById('pdf-container');

            // Render page
            const renderPage = num => {
                pageIsRendering = true;

                pdfDoc.getPage(num).then(page => {
                    const viewport = page.getViewport({
                        scale: scale
                    });
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const renderCtx = {
                        canvasContext: ctx,
                        viewport
                    };

                    page.render(renderCtx).promise.then(() => {
                        pageIsRendering = false;

                        if (pageNumIsPending !== null) {
                            renderPage(pageNumIsPending);
                            pageNumIsPending = null;
                        }
                    });

                    // Update page counters
                    document.getElementById('page-num').value = num;
                    document.getElementById('page-count').textContent = pdfDoc.numPages;
                });
            };

            const queueRenderPage = num => {
                if (pageIsRendering) {
                    pageNumIsPending = num;
                } else {
                    renderPage(num);
                }
            };

            // Event tombol navigasi
            document.getElementById('prev-page').addEventListener('click', () => {
                if (pageNum <= 1) return;
                pageNum--;
                queueRenderPage(pageNum);
            });

            document.getElementById('next-page').addEventListener('click', () => {
                if (pageNum >= pdfDoc.numPages) return;
                pageNum++;
                queueRenderPage(pageNum);
            });

            document.getElementById('page-num').addEventListener('change', (e) => {
                let desiredPage = parseInt(e.target.value);
                if (desiredPage >= 1 && desiredPage <= pdfDoc.numPages) {
                    pageNum = desiredPage;
                    queueRenderPage(pageNum);
                }
            });

            // Zoom control
            document.getElementById('zoom-in').addEventListener('click', () => {
                scale += 0.2;
                queueRenderPage(pageNum);
            });

            document.getElementById('zoom-out').addEventListener('click', () => {
                if (scale > 0.4) { // jangan terlalu kecil
                    scale -= 0.2;
                    queueRenderPage(pageNum);
                }
            });

            // Load PDF
            pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
                pdfDoc = pdfDoc_;
                renderPage(pageNum);
            });
        </script>
    @endif
@endsection
