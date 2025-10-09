<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    private $jenisKode = [
        'Peraturan Gubernur' => 1,
        'Keputusan Gubernur' => 2,
        'Peraturan Direktur' => 3,
        'Keputusan Direktur' => 4,
        'Perizinan' => 5,
        'SOP' => 6,
    ];

    // ========================
    // AJAX UNTUK SELECT2 JUDUL
    // ========================
    public function ajaxJudul(Request $request)
    {
        $q = $request->get('q', '');

        $data = Document::query()
            ->where('judul', 'like', "%{$q}%")
            ->select('judul')
            ->distinct()
            ->limit(50)
            ->get();

        $results = $data
            ->map(function ($item) {
                return [
                    'id' => $item->judul, // value yg tersimpan = judul
                    'text' => $item->judul, // teks yg tampil di dropdown
                ];
            })
            ->values();

        return response()->json(['results' => $results]);
    }
    // ========================

    public function index(Request $request)
    {
        $query = Document::query();
        $query->where('status_verifikasi', 2);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('tipe_dokumen', 'like', "%{$search}%")
                    ->orWhere('tahun', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $documents = $query->latest()->get();

        return view('content.document.index', compact('documents'));
    }

    public function indexVerifikasiTabs(Request $request)
    {
        // Dokumen yang harus diverifikasi (status_verifikasi = 1)
        $pendingDocuments = Document::where('status_verifikasi', 1)
            ->latest()
            ->get(['*'], 'pending_page');

        // Semua dokumen untuk history
        $allDocuments = Document::latest()->get( ['*'], 'history_page');

        return view('content.document.index-verifikasi', compact('pendingDocuments', 'allDocuments'));
    }

    public function search(Request $request)
    {
        $q = $request->input('q');

        $results = Document::where('judul', 'like', "%{$q}%")
            ->orWhere('nomor', 'like', "%{$q}%")
            ->orWhere('tahun', 'like', "%{$q}%")
            ->orWhere('jenis_dokumen', 'like', "%{$q}%")
            ->get();

        $pageConfigs = ['layout' => 'blank'];

        return view('content.search.result', compact('q', 'results', 'pageConfigs'));
    }

    public function create()
    {
        $documents = Document::all(); // ambil semua dokumen
        return view('content.document.create', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|mimes:pdf,docx,xlsx,pptx|max:20480',
            'judul' => 'required|string|max:255',
        ]);

        $filePath = $request->file('pdf_file')->store('documents', 'public');

        $document = Document::create(array_merge($request->except('pdf_file'), ['pdf_file' => $filePath]));

        return redirect()->route('documents.show', $document->id)->with('success', 'Dokumen berhasil disimpan!');
    }

    public function show($id)
    {
        $document = Document::with('jenisDokumenRef')->findOrFail($id);
        return view('content.document.show', compact('document'));
    }

    public function showVerifikasi($id)
    {
        $document = Document::with(['jenisDokumenRef', 'statusDokumenRef', 'keteranganDoc'])->findOrFail($id);
        return view('content.document.verifikasi-dokumen', compact('document'));
    }

    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $documents = Document::all(); // ambil semua dokumen buat dropdown

        return view('content.document.edit', compact('document', 'documents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'status' => 'required|in:0,1,2', // 2=Berlaku, 0=Tidak Berlaku, 1=Berlaku Sebagian
            'keterangan_id' => 'nullable|integer|exists:documents,id',
            'keterangan_dokumen' => 'nullable|string|max:255',
            'pdf_file' => 'nullable|mimes:pdf|max:20480',
            'tipe_dokumen' => 'nullable|string',
            'bidang_hukum' => 'nullable|string',
            'jenis_hukum' => 'nullable|string',
            'jenis_dokumen' => 'nullable|string',
            'singkatan' => 'nullable|string|max:255',
            'nomor' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer',
            'tempat_penetapan' => 'nullable|string|max:255',
            'tanggal_penetapan' => 'nullable|date',
            'tanggal_pengundangan' => 'nullable|date',
            'sumber' => 'nullable|string|max:255',
            'subjek' => 'nullable|string|max:255',
            'bahasa' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'urusan_pemerintahan' => 'nullable|string|max:255',
            'penandatanganan' => 'nullable|string|max:255',
            'pemrakarsa' => 'nullable|string|max:255',
        ]);

        $document = Document::findOrFail($id);

        // Update tanggal_perubahan kalau status berubah
        if ($document->status != $request->status) {
            $document->tanggal_perubahan = now();
        }

        // Handle file PDF
        if ($request->hasFile('pdf_file')) {
            if ($document->pdf_file && Storage::disk('public')->exists($document->pdf_file)) {
                Storage::disk('public')->delete($document->pdf_file);
            }
            $document->pdf_file = $request->file('pdf_file')->store('documents', 'public');
        }

        // Update semua field lain (kecuali keterangan_id & keterangan_dokumen)
        $fields = ['judul', 'status', 'tipe_dokumen', 'bidang_hukum', 'jenis_hukum', 'jenis_dokumen', 'singkatan', 'nomor', 'tahun', 'tempat_penetapan', 'tanggal_penetapan', 'tanggal_pengundangan', 'sumber', 'subjek', 'bahasa', 'lokasi', 'urusan_pemerintahan', 'penandatanganan', 'pemrakarsa'];

        foreach ($fields as $field) {
            $document->$field = $request->$field;
        }

        // Reset keterangan kalau status jadi Berlaku (2), atau update kalau status bukan 2
        if ($request->status === '2') {
            $document->keterangan_id = null;
            $document->keterangan_dokumen = null;
        } else {
            $document->keterangan_id = $request->keterangan_id;
            $document->keterangan_dokumen = $request->keterangan_dokumen;
        }

        $document->save();

        return redirect()->route('documents.show', $document->id)->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function updateStatusVerifikasi(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:0,1,2,3',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $document = Document::findOrFail($id);
        $document->status_verifikasi = $request->status_verifikasi;
        $document->catatan_admin = $request->catatan_admin;
        $document->save();

        $messages = [
            0 => 'Verifikasi dibatalkan.',
            1 => 'Belum diverifikasi.',
            2 => 'Dokumen berhasil diverifikasi ✅',
            3 => 'Dokumen membutuhkan perbaikan ⚠️',
        ];

        if ($request->status_verifikasi == 0) {
            return redirect()->route('documents.verifikasi')->with('success', $messages[0]);
        }

        return redirect()
            ->route('documents.verifikasi', $id)
            ->with('success', $messages[$request->status_verifikasi]);
    }

    public function destroy($id)
    {
        try {
            $document = Document::findOrFail($id);

            if ($document->pdf_file && Storage::disk('public')->exists($document->pdf_file)) {
                Storage::disk('public')->delete($document->pdf_file);
            }

            $document->delete();

            return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('documents.index')
                ->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }

    // ========================
    // BAGIAN KATEGORI
    // ========================

    private function getCategories()
    {
        return [
            'categories' => Document::select(DB::raw("'Keputusan Direktur' as kategori"), DB::raw('count(*) as total'))
                ->where('jenis_dokumen', 4)
                ->where('status_verifikasi', 2) // hanya yang diverifikasi
                ->get(),

            'categoriesPeraturanGubernur' => Document::select(DB::raw("'Peraturan Gubernur' as kategori"), DB::raw('count(*) as total'))->where('jenis_dokumen', 1)->where('status_verifikasi', 2)->get(),

            'categoriesKeputusanGubernur' => Document::select(DB::raw("'Keputusan Gubernur' as kategori"), DB::raw('count(*) as total'))->where('jenis_dokumen', 2)->where('status_verifikasi', 2)->get(),

            'categoriesPeraturanDirektur' => Document::select(DB::raw("'Peraturan Direktur' as kategori"), DB::raw('count(*) as total'))->where('jenis_dokumen', 3)->where('status_verifikasi', 2)->get(),

            'categoriesPerizinan' => Document::select(DB::raw("'Perizinan' as kategori"), DB::raw('count(*) as total'))->where('jenis_dokumen', 5)->where('status_verifikasi', 2)->get(),

            'categoriesSOP' => Document::select(DB::raw("'SOP' as kategori"), DB::raw('count(*) as total'))->where('jenis_dokumen', 6)->where('status_verifikasi', 2)->get(),
        ];
    }

    // ========================
    // METHOD KATEGORI DOKUMEN
    // ========================

    public function handleCategory(Request $request, $jenisStr, $viewVar, $viewName)
    {
        $jenis = $this->jenisKode[$jenisStr] ?? null;

        $search = $request->input('q');

        $documents = Document::where('jenis_dokumen', $jenis)
            ->where('status_verifikasi', 2) // hanya yang sudah diverifikasi
            ->when(
                $search,
                fn($query) => $query
                    ->where('judul', 'like', "%{$search}%")
                    ->orWhere('nomor', 'like', "%{$search}%")
                    ->orWhere('tahun', 'like', "%{$search}%"),
            )
            ->latest()
            ->paginate(10);

        return view($viewName, array_merge([$viewVar => $documents], $this->getCategories()));
    }

    public function keputusanDirektur(Request $request)
    {
        return $this->handleCategory($request, 'Keputusan Direktur', 'keputusanDirektur', 'kategori-dokumen.indexDir');
    }

    public function peraturanGubernur(Request $request)
    {
        return $this->handleCategory($request, 'Peraturan Gubernur', 'peraturanGubernur', 'kategori-dokumen.indexGub');
    }

    public function keputusanGubernur(Request $request)
    {
        return $this->handleCategory($request, 'Keputusan Gubernur', 'keputusanGubernur', 'kategori-dokumen.indexkepgub');
    }

    public function perIzinan(Request $request)
    {
        return $this->handleCategory($request, 'Perizinan', 'perIzinan', 'kategori-dokumen.indexIzin');
    }

    public function peraturanDirektur(Request $request)
    {
        return $this->handleCategory($request, 'Peraturan Direktur', 'peraturanDirektur', 'kategori-dokumen.indexperdir');
    }

    public function SOP(Request $request)
    {
        return $this->handleCategory($request, 'SOP', 'SOP', 'kategori-dokumen.indexSOP');
    }
}
