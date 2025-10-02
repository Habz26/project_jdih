<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
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

            $results = $data->map(function ($item) {
                return [
                    'id' => $item->judul,   // supaya value yg tersimpan = judul
                    'text' => $item->judul, // teks yg tampil di dropdown
                ];
            })->values();

            return response()->json(['results' => $results]);
        }
    // ========================

    public function index(Request $request)
    {
        $query = Document::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('tipe_dokumen', 'like', "%{$search}%")
                    ->orWhere('tahun', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $documents = $query->latest()->paginate(10);

        return view('content.document.index', compact('documents'));
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
        return view('content.document.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|mimes:pdf,docx,xlsx,pptx|max:20480',
            'judul' => 'required|string|max:255',
        ]);

        $filePath = $request->file('pdf_file')->store('documents', 'public');

        $document = Document::create(array_merge(
            $request->except('pdf_file'),
            ['pdf_file' => $filePath]
        ));

        return redirect()->route('documents.show', $document->id)
            ->with('success', 'Dokumen berhasil disimpan!');
    }

    public function show($id)
    {
        $document = Document::findOrFail($id);
        return view('content.document.show', compact('document'));
    }

    public function destroy($id)
    {
        try {
            $document = Document::findOrFail($id);

            if ($document->pdf_file && Storage::disk('public')->exists($document->pdf_file)) {
                Storage::disk('public')->delete($document->pdf_file);
            }

            $document->delete();

            return redirect()->route('documents.index')
                ->with('success', 'Dokumen berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('documents.index')
                ->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $document = Document::findOrFail($id);
        return view('content.document.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pdf_file' => 'nullable|mimes:pdf|max:20480',
        ]);

        $document = Document::findOrFail($id);

        if ($request->hasFile('pdf_file')) {
            if ($document->pdf_file && Storage::disk('public')->exists($document->pdf_file)) {
                Storage::disk('public')->delete($document->pdf_file);
            }

            $filePath = $request->file('pdf_file')->store('documents', 'public');
            $document->pdf_file = $filePath;
        }

        $document->update($request->except('pdf_file'));

        return redirect()->route('documents.show', $document->id)
            ->with('success', 'Dokumen berhasil diperbarui!');
    }

    // ========================
    // BAGIAN KATEGORI
    // ========================

    private function getCategories()
{
    return [
        'categories' => Document::select(
                DB::raw("'Keputusan Direktur' as kategori"),
                DB::raw('count(*) as total')
            )->where('jenis_dokumen', 'Keputusan Direktur')->get(),

        'categoriesPeraturanGubernur' => Document::select(
                DB::raw("'Peraturan Gubernur' as kategori"),
                DB::raw('count(*) as total')
            )->where('jenis_dokumen', 'Peraturan Gubernur')->get(),

        'categoriesKeputusanGubernur' => Document::select(
                DB::raw("'Keputusan Gubernur' as kategori"),
                DB::raw('count(*) as total')
            )->where('jenis_dokumen', 'Keputusan Gubernur')->get(),

        'categoriesPeraturanDirektur' => Document::select(
                DB::raw("'Peraturan Direktur' as kategori"),
                DB::raw('count(*) as total')
            )->where('jenis_dokumen', 'Peraturan Direktur')->get(),

        'categoriesPerizinan' => Document::select(
                DB::raw("'Perizinan' as kategori"),
                DB::raw('count(*) as total')
            )->where('jenis_dokumen', 'Perizinan')->get(),

        'categoriesSOP' => Document::select(
                DB::raw("'SOP' as kategori"),
                DB::raw('count(*) as total')
            )->where('jenis_dokumen', 'SOP')->get(),
    ];
}


    public function keputusanDirektur(Request $request)
    {
        $search = $request->input('q');

        $keputusanDirektur = Document::where('jenis_dokumen', 'Keputusan Direktur')
            ->when($search, fn($query) => $query->where('judul', 'like', "%{$search}%")
                ->orWhere('nomor', 'like', "%{$search}%")
                ->orWhere('tahun', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10);

        return view('kategori-dokumen.indexDir', array_merge(
            ['keputusanDirektur' => $keputusanDirektur],
            $this->getCategories()
        ));
    }

    public function peraturanGubernur(Request $request)
    {
        $search = $request->input('q');

        $peraturanGubernur = Document::where('jenis_dokumen', 'Peraturan Gubernur')
            ->when($search, fn($query) => $query->where('judul', 'like', "%{$search}%")
                ->orWhere('nomor', 'like', "%{$search}%")
                ->orWhere('tahun', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10);

        return view('kategori-dokumen.indexGub', array_merge(
            ['peraturanGubernur' => $peraturanGubernur],
            $this->getCategories()
        ));
    }

    public function keputusanGubernur(Request $request) // <<< DITAMBAHKAN
    {
        $search = $request->input('q');

        $keputusanGubernur = Document::where('jenis_dokumen', 'Keputusan Gubernur')
            ->when($search, fn($query) => $query->where('judul', 'like', "%{$search}%")
                ->orWhere('nomor', 'like', "%{$search}%")
                ->orWhere('tahun', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10);

        return view('kategori-dokumen.indexkepgub', array_merge(
            ['keputusanGubernur' => $keputusanGubernur],
            $this->getCategories()
        ));
    }

    public function perIzinan(Request $request)
    {
        $search = $request->input('q');

        $perIzinan = Document::where('jenis_dokumen', 'Perizinan')
            ->when($search, fn($query) => $query->where('judul', 'like', "%{$search}%")
                ->orWhere('nomor', 'like', "%{$search}%")
                ->orWhere('tahun', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10);

        return view('kategori-dokumen.indexIzin', array_merge(
            ['perIzinan' => $perIzinan],
            $this->getCategories()
        ));
    }
      public function peraturanDirektur(Request $request)
    {
        $search = $request->input('q');

        $peraturanDirektur = Document::where('jenis_dokumen', 'Peraturan Direktur')
            ->when($search, fn($query) => $query->where('judul', 'like', "%{$search}%")
                ->orWhere('nomor', 'like', "%{$search}%")
                ->orWhere('tahun', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10);

        return view('kategori-dokumen.indexperdir', array_merge(
            ['peraturanDirektur' => $peraturanDirektur],
            $this->getCategories()
        ));
    }

    public function SOP(Request $request)
    {
        $search = $request->input('q');

        $SOP = Document::where('jenis_dokumen', 'SOP')
            ->when($search, fn($query) => $query->where('judul', 'like', "%{$search}%")
                ->orWhere('nomor', 'like', "%{$search}%")
                ->orWhere('tahun', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10);

        return view('kategori-dokumen.indexSOP', array_merge(
            ['SOP' => $SOP],
            $this->getCategories()
        ));
    }
}
