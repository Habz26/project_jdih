@extends('layouts.layoutMaster')

@section('content')
<div class="container">
    <div class="row">
        <!-- Kolom Kiri: Preview File -->
        <div class="col-md-8">
            @php
                $filePath = Storage::url($document->pdf_file);
                $extension = \Illuminate\Support\Str::lower(pathinfo($document->pdf_file, PATHINFO_EXTENSION));
                $isPdf = $extension === 'pdf';
                $isOffice = in_array($extension, ['docx', 'xlsx', 'pptx']);
            @endphp

            @if($isPdf)
                {{-- Preview PDF pakai PDF.js --}}
                <div class="mb-2 d-flex align-items-center justify-content-between">
                    <div>
                        <button id="prev-page" class="btn btn-secondary btn-sm">⬅ Sebelumnya</button>
                        <button id="next-page" class="btn btn-secondary btn-sm">Berikutnya ➡</button>
                    </div>
                    <div>
                        <input type="number" id="page-num" class="form-control d-inline-block" value="1" min="1" style="width:80px;">
                        / <span id="page-count">0</span>
                    </div>
                    <div>
                        <button id="zoom-in" class="btn btn-info btn-sm">Zoom +</button>
                        <button id="zoom-out" class="btn btn-info btn-sm">Zoom -</button>
                        <a href="{{ $filePath }}" class="btn btn-success btn-sm" download>Unduh</a>
                    </div>
                </div>

                <div id="pdf-container" style="border:1px solid #ccc; height:800px; overflow:auto; text-align:center;">
                    <canvas id="pdf-render" style="max-width:100%; height:auto;"></canvas>
                </div>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
                <script>
                    const url = "{{ $filePath }}";
                    let pdfDoc = null, pageNum = 1, pageIsRendering = false, pageNumIsPending = null, scale = 1.5;
                    const canvas = document.getElementById('pdf-render'), ctx = canvas.getContext('2d');

                    const renderPage = num => {
                        pageIsRendering = true;
                        pdfDoc.getPage(num).then(page => {
                            const viewport = page.getViewport({ scale });
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;

                            page.render({canvasContext: ctx, viewport}).promise.then(() => {
                                pageIsRendering = false;
                                if(pageNumIsPending !== null){ renderPage(pageNumIsPending); pageNumIsPending = null; }
                            });

                            document.getElementById('page-num').value = num;
                            document.getElementById('page-count').textContent = pdfDoc.numPages;
                        });
                    };

                    const queueRenderPage = num => pageIsRendering ? pageNumIsPending = num : renderPage(num);

                    document.getElementById('prev-page').addEventListener('click', () => { if(pageNum>1){ pageNum--; queueRenderPage(pageNum); }});
                    document.getElementById('next-page').addEventListener('click', () => { if(pageNum<pdfDoc.numPages){ pageNum++; queueRenderPage(pageNum); }});
                    document.getElementById('page-num').addEventListener('change', e => { let p=parseInt(e.target.value); if(p>=1 && p<=pdfDoc.numPages){ pageNum=p; queueRenderPage(pageNum); }});
                    document.getElementById('zoom-in').addEventListener('click', ()=>{ scale+=0.2; queueRenderPage(pageNum); });
                    document.getElementById('zoom-out').addEventListener('click', ()=>{ if(scale>0.4){ scale-=0.2; queueRenderPage(pageNum); }});

                    pdfjsLib.getDocument(url).promise.then(pdfDoc_ => { pdfDoc=pdfDoc_; renderPage(pageNum); });
                </script>

            @elseif($isOffice)
                {{-- Preview Office pakai OnlyOffice iframe --}}
                <iframe 
                    src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode(Storage::url($document->pdf_file)) }}" 
                    width="100%" 
                    height="600px" 
                    frameborder="0">
                </iframe>

                <div class="mt-2">
                    <a href="{{ $filePath }}" class="btn btn-success btn-sm" download>Unduh</a>
                </div>

            @else
                <p>Format file tidak didukung untuk preview.</p>
            @endif
        </div>

        <!-- Kolom Kanan: Informasi Dokumen -->
        <div class="col-md-4">
            <h5>Informasi Dokumen</h5>
            <ul class="list-group">
                <li class="list-group-item"><strong>Judul:</strong> {{ $document->judul }}</li>
                <li class="list-group-item"><strong>Tahun:</strong> {{ $document->tahun }}</li>
                <li class="list-group-item"><strong>Tipe Dokumen:</strong> {{ $document->tipe_dokumen }}</li>
                <li class="list-group-item"><strong>Bidang Hukum:</strong> {{ $document->bidang_hukum }}</li>
                <li class="list-group-item"><strong>Status:</strong> {{ $document->status }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection
