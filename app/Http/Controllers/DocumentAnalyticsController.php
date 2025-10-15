<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentAnalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DocumentAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // 🧩 Jika user belum login, redirect ke login (aman)
        if (!$user) {
            return redirect()->route('login');
        }

        // 🧩 Hanya admin yang sampai ke sini
        $filter = $request->get('filter', 'all');
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $query = DocumentAnalytics::query();

        // Filter waktu berdasarkan bulan dan tahun
        if ($filter === 'month') {
            $query->whereYear('visited_at', $year)->whereMonth('visited_at', $month);
        } elseif ($filter === 'year') {
            $query->whereYear('visited_at', $year);
        }

        // Statistik utama
        $totalVisits = $query->count();
        $uniqueDocuments = $query->distinct('document_id')->count('document_id');
        $uniqueUsers = $query->distinct('user_id')->count('user_id');

        // Top 10 dokumen terpopuler
        $topDocuments = Document::select('documents.id', 'documents.jenis_dokumen', 'documents.judul', DB::raw('COUNT(document_analytics.id) as total_visits'))->leftJoin('document_analytics', 'documents.id', '=', 'document_analytics.document_id')->where('status_verifikasi', 2)->groupBy('documents.id', 'documents.jenis_dokumen', 'documents.judul')->orderByDesc('total_visits')->limit(10)->get();

        $jenisMap = [
            1 => 'Peraturan Gubernur',
            2 => 'Keputusan Gubernur',
            3 => 'Peraturan Direktur',
            4 => 'Keputusan Direktur',
            5 => 'Perizinan',
            6 => 'SOP',
        ];

        // Ganti angka jadi teks di hasil query
        $topDocuments->transform(function ($doc) use ($jenisMap) {
            $doc->jenis_dokumen = $jenisMap[$doc->jenis_dokumen] ?? 'Tidak Diketahui';
            return $doc;
        });

        // Data grafik kunjungan per hari (untuk Chart.js)
        $visitsPerDay = $query->select(DB::raw('DATE(visited_at) as date'), DB::raw('COUNT(*) as total'))->groupBy('date')->orderBy('date')->get();

        $visitsLabels = $visitsPerDay->pluck('date');
        $visitsData = $visitsPerDay->pluck('total');

        // View untuk admin
        return view('content.dashboard.dashboards-analytics', compact('totalVisits', 'uniqueDocuments', 'uniqueUsers', 'topDocuments', 'filter', 'month', 'year', 'visitsLabels', 'visitsData'));
    }
}
