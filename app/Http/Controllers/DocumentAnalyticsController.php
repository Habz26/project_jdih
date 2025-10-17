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
        if (!$user) return redirect()->route('login');

        // 🧩 Filter
        $filter = $request->get('filter', 'all');
        $month  = $request->get('month', date('m'));
        $year   = $request->get('year', date('Y'));

        // 🔍 Query dasar analitik
        $query = DocumentAnalytics::query()
            ->join('documents', 'document_analytics.document_id', '=', 'documents.id')
            ->where('documents.status_verifikasi', 2); // Hanya dokumen terverifikasi

        // Filter waktu
        if ($filter === 'month') {
            $query->whereYear('visited_at', $year)
                  ->whereMonth('visited_at', $month);
        } elseif ($filter === 'year') {
            $query->whereYear('visited_at', $year);
        }

        // 📈 Statistik utama
        $totalVisits           = $query->count();
        $uniqueDocuments       = $query->distinct('document_id')->count('document_id');
        $uniqueUsers           = $query->distinct('user_id')->count('user_id');
        // Query dasar dokumen (sesuaikan periode)
$docQuery = Document::query();

// Filter periode untuk dokumen
if ($filter === 'month') {
    $docQuery->whereYear('tanggal_penetapan', $year)
             ->whereMonth('tanggal_penetapan', $month);
} elseif ($filter === 'year') {
    $docQuery->whereYear('tanggal_penetapan', $year);
}

// Dokumen terverifikasi (status_verifikasi = 2 & pakai tanggal_verifikasi)
$dokumenTerverifikasi = Document::where('status_verifikasi', 2)
    ->when($filter === 'month', fn($q) => $q->whereYear('tanggal_verifikasi', $year)
                                           ->whereMonth('tanggal_verifikasi', $month))
    ->when($filter === 'year', fn($q) => $q->whereYear('tanggal_verifikasi', $year))
    ->count();

// Dokumen belum verifikasi (status_verifikasi != 2)
$dokumenBelumVerifikasi = Document::where('status_verifikasi', 1)
    ->when($filter === 'month', fn($q) => $q->whereYear('tanggal_penetapan', $year)
                                           ->whereMonth('tanggal_penetapan', $month))
    ->when($filter === 'year', fn($q) => $q->whereYear('tanggal_penetapan', $year))
    ->count();

// Dokumen berlaku / tidak berlaku / sebagian (hanya yg terverifikasi)
$dokumenBerlaku        = (clone $docQuery)->where('status', 2)->count();
$dokumenTidakBerlaku   = (clone $docQuery)->where('status', 0)->count();
$dokumenBerlakuSebagian = (clone $docQuery)->where('status', 1)->count();

// Total dokumen (sesuai periode penetapan)
$totaldokumen          = (clone $docQuery)->count();


        // 🏆 Top 10 dokumen terpopuler (dalam filter)
        $topDocuments = (clone $query)
            ->select(
                'documents.id',
                'documents.jenis_dokumen',
                'documents.judul',
                DB::raw('COUNT(document_analytics.id) as total_visits')
            )
            ->groupBy('documents.id', 'documents.jenis_dokumen', 'documents.judul')
            ->orderByDesc('total_visits')
            ->limit(10)
            ->get();

        $jenisMap = [
            1 => 'Peraturan Gubernur',
            2 => 'Keputusan Gubernur',
            3 => 'Peraturan Direktur',
            4 => 'Keputusan Direktur',
            5 => 'Perizinan',
            6 => 'SOP',
        ];

        $topDocuments->transform(function ($doc) use ($jenisMap) {
            $doc->jenis_dokumen = $jenisMap[$doc->jenis_dokumen] ?? 'Tidak Diketahui';
            return $doc;
        });

        // 🍩 Donut Chart per jenis_dokumen (terfilter & semua jenis muncul)
        $rawVisits = (clone $query)
            ->select('documents.jenis_dokumen', DB::raw('COUNT(document_analytics.id) as total_visits'))
            ->groupBy('documents.jenis_dokumen')
            ->get();

        $visitsByJenis = collect($jenisMap)->map(function ($label, $key) use ($rawVisits) {
            $found = $rawVisits->firstWhere('jenis_dokumen', $key);
            return (object)[
                'jenis_dokumen' => $label,
                'total_visits'  => $found ? $found->total_visits : 0,
            ];
        })->values();

        $donutLabels = $visitsByJenis->pluck('jenis_dokumen');
        $donutData   = $visitsByJenis->pluck('total_visits');

        // 📊 Line/Bar Chart (kunjungan harian/bulanan)
        if ($filter === 'month') {
            $visitsPerDay = (clone $query)
                ->select(DB::raw('DATE(visited_at) as date'), DB::raw('COUNT(*) as total'))
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $visitsLabels = $visitsPerDay->pluck('date');
            $visitsData   = $visitsPerDay->pluck('total');
        } elseif ($filter === 'year') {
            $months = collect(range(1, 12));
            $visitsPerMonth = $months->map(function ($m) use ($query, $year) {
                $count = (clone $query)
                    ->whereYear('visited_at', $year)
                    ->whereMonth('visited_at', $m)
                    ->count();
                return [
                    'month' => Carbon::create($year, $m, 1)->format('F'),
                    'total' => $count
                ];
            });

            $visitsLabels = $visitsPerMonth->pluck('month');
            $visitsData   = $visitsPerMonth->pluck('total');
        } else {
            $visitsPerDay = (clone $query)
                ->select(DB::raw('DATE(visited_at) as date'), DB::raw('COUNT(*) as total'))
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $visitsLabels = $visitsPerDay->pluck('date');
            $visitsData   = $visitsPerDay->pluck('total');
        }

        // 🎯 View
        return view('content.dashboard.dashboards-analytics', compact(
            'totalVisits',
            'uniqueDocuments',
            'uniqueUsers',
            'dokumenTerverifikasi',
            'dokumenBelumVerifikasi',
            'dokumenBerlaku',
            'dokumenTidakBerlaku',
            'dokumenBerlakuSebagian',
            'totaldokumen',
            'topDocuments',
            'filter',
            'month',
            'year',
            'visitsLabels',
            'visitsData',
            'donutLabels',
            'donutData'
        ));
    }
}
