<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

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
                'id' => $item->judul,   // value yg tersimpan = judul
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
        $document = Document::with('jenisDokumenRef')->findOrFail($id);
        return view('content.document.show', compact('document'));
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

    // ========================
    // BAGIAN KATEGORI
    // ========================

    private function getCategories()
    {
        $types = [
            'Keputusan Direktur' => 'keputusan-direktur',
            'Peraturan Gubernur' => 'peraturan-gubernur',
            'Keputusan Gubernur' => 'keputusan-gubernur',
            'Peraturan Direktur' => 'peraturan-direktur',
            'Perizinan' => 'perizinan',
            'SOP' => 'sop',
        ];

        $categories = [];

        foreach ($types as $name => $route) {
            $categories[$name] = [
                'total' => Document::where('jenis_dokumen', $name)->count(),
                'route' => $route
            ];
        }

        return ['categories' => $categories];
    }

    // ========================
    // METHOD KATEGORI DOKUMEN
    // ========================

    private function handleCategory(Request $request, $jenis, $viewVar, $viewName)
    {
        $search = $request->input('q');

        $documents = Document::where('jenis_dokumen', $jenis)
            ->when($search, fn($query) => $query->where('judul', 'like', "%{$search}%")
                ->orWhere('nomor', 'like', "%{$search}%")
                ->orWhere('tahun', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10);

        return view($viewName, array_merge(
            [$viewVar => $documents],
            $this->getCategories()
        ));
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
