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
        $filter = $request->get('filter', 'all');
        $query = DocumentAnalytics::query();

        // Filter waktu
        if ($filter === 'week') {
            $query->where('visited_at', '>=', Carbon::now()->subWeek());
        } elseif ($filter === 'month') {
            $query->where('visited_at', '>=', Carbon::now()->subMonth());
        }

        // Statistik utama
        $totalVisits = $query->count();
        $uniqueDocuments = $query->distinct('document_id')->count('document_id');
        $uniqueUsers = $query->distinct('user_id')->count('user_id');

        // Top 10 dokumen terpopuler
        $topDocuments = Document::select(
                'documents.id',
                'documents.judul',
                DB::raw('COUNT(document_analytics.id) as total_visits')
            )
            ->leftJoin('document_analytics', 'documents.id', '=', 'document_analytics.document_id')
            ->when($filter !== 'all', function ($q) use ($filter) {
                if ($filter === 'week') {
                    $q->where('document_analytics.visited_at', '>=', Carbon::now()->subWeek());
                } elseif ($filter === 'month') {
                    $q->where('document_analytics.visited_at', '>=', Carbon::now()->subMonth());
                }
            })
            ->groupBy('documents.id', 'documents.judul')
            ->orderByDesc('total_visits')
            ->limit(10)
            ->get();

        // Data grafik kunjungan per hari (untuk Chart.js)
        $visitsPerDay = $query->select(
                DB::raw('DATE(visited_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $visitsLabels = $visitsPerDay->pluck('date');
        $visitsData = $visitsPerDay->pluck('total');

       return view('content.dashboard.dashboards-analytics', compact(
    'totalVisits',
    'uniqueDocuments',
    'uniqueUsers',
    'topDocuments',
    'filter',
    'visitsLabels',
    'visitsData'
));
    }
}
