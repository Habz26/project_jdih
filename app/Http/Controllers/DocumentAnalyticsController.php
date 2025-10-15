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
        $dokumenTerverifikasi = Document::where('status_verifikasi', 2)->count();
        $dokumenBelumVerifikasi = Document::where('status_verifikasi', '!=', 2)->count();
        $dokumenBerlaku = Document::where('status', 2)->count();
        $dokumenTidakBerlaku = Document::where('status', 0)->count();
        $dokumenBerlakuSebagian = Document::where('status', 1)->count();
        $totaldokumen = Document::count();

        // Top 10 dokumen terpopuler
        $topDocuments = Document::select(
                'documents.id', 
                'documents.jenis_dokumen', 
                'documents.judul', 
                DB::raw('COUNT(document_analytics.id) as total_visits')
            )
            ->leftJoin('document_analytics', 'documents.id', '=', 'document_analytics.document_id')
            ->where('status_verifikasi', 2)
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

        // Ganti angka jadi teks di hasil query
        $topDocuments->transform(function ($doc) use ($jenisMap) {
            $doc->jenis_dokumen = $jenisMap[$doc->jenis_dokumen] ?? 'Tidak Diketahui';
            return $doc;
        });

        // 🔹 Data grafik kunjungan
        if ($filter === 'month') {
            // Chart harian lengkap tiap tanggal
            $dates = collect();
            $start = Carbon::create($year, $month, 1);
            $end = $start->copy()->endOfMonth();

            while ($start->lte($end)) {
                $dates->push($start->toDateString());
                $start->addDay();
            }

            $visitsPerDay = $dates->map(function ($date) use ($query) {
                $count = (clone $query)->whereDate('visited_at', $date)->count();
                return ['date' => $date, 'total' => $count];
            });

            $visitsLabels = $visitsPerDay->pluck('date');
            $visitsData = $visitsPerDay->pluck('total');

        } elseif ($filter === 'year') {
            // Chart bulanan
            $months = collect(range(1, 12));
            $visitsPerDay = $months->map(function ($m) use ($query, $year) {
                $count = (clone $query)->whereYear('visited_at', $year)->whereMonth('visited_at', $m)->count();
                return ['month' => Carbon::create($year, $m, 1)->format('F'), 'total' => $count];
            });

            $visitsLabels = $visitsPerDay->pluck('month');
            $visitsData = $visitsPerDay->pluck('total');
        } else {
            // Semua data
            $visitsPerDay = $query->select(DB::raw('DATE(visited_at) as date'), DB::raw('COUNT(*) as total'))
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $visitsLabels = $visitsPerDay->pluck('date');
            $visitsData = $visitsPerDay->pluck('total');
        }

        // View untuk admin
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
            'visitsData'
        ));
    }
}
