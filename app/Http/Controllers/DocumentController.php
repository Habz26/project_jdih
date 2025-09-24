<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::latest()->get();
        return view('content.document.index', compact('documents'));
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

    $document = Document::create([
        'pdf_file' => $filePath,
        'tipe_dokumen' => $request->tipe_dokumen,
        'bidang_hukum' => $request->bidang_hukum,
        'jenis_hukum' => $request->jenis_hukum,
        'jenis_dokumen' => $request->jenis_dokumen,
        'tahun' => $request->tahun,
        'judul' => $request->judul,
        'teu_badan' => $request->teu_badan,
        'tempat_penetapan' => $request->tempat_penetapan,
        'tanggal_penetapan' => $request->tanggal_penetapan,
        'tanggal_pengundangan' => $request->tanggal_pengundangan,
        'sumber' => $request->sumber,
        'subjek' => $request->subjek,
        'bahasa' => $request->bahasa,
        'lokasi' => $request->lokasi,
        'urusan_pemerintahan' => $request->urusan_pemerintahan,
        'penandatanganan' => $request->penandatanganan,
        'pemrakarsa' => $request->pemrakarsa,
        'status' => $request->status,
        'qrcode' => $request->qrcode,
    ]);
    if (!$request->hasFile('pdf_file')) {
    return back()->withErrors(['pdf_file' => 'File tidak ditemukan!']);
}


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

            return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('documents.index')->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
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

    // Ganti file PDF jika ada
    if ($request->hasFile('pdf_file')) {
        // Hapus file lama
        if ($document->pdf_file && Storage::disk('public')->exists($document->pdf_file)) {
            Storage::disk('public')->delete($document->pdf_file);
        }

        // Simpan file baru
        $filePath = $request->file('pdf_file')->store('documents', 'public');
        $document->pdf_file = $filePath;
    }

    // Update metadata
    $document->update($request->except('pdf_file'));

    return redirect()->route('documents.show', $document->id)
                     ->with('success', 'Dokumen berhasil diperbarui!');
}
}