<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'menunggu' => Report::where('status', Report::STATUS_MENUNGGU)->count(),
            'diverifikasi' => Report::where('status', Report::STATUS_DIVERIFIKASI)->count(),
            'diproses' => Report::where('status', Report::STATUS_DIPROSES)->count(),
            'selesai' => Report::where('status', Report::STATUS_SELESAI)->count(),
            'recentReports' => Report::with(['category', 'user'])->latest()->take(5)->get()
        ]);
    }

    public function statistik()
    {
        $total = Report::count();
        $menunggu = Report::where('status', Report::STATUS_MENUNGGU)->count();
        $diverifikasi = Report::where('status', Report::STATUS_DIVERIFIKASI)->count();
        $diproses = Report::where('status', Report::STATUS_DIPROSES)->count();
        $selesai = Report::where('status', Report::STATUS_SELESAI)->count();
        $ditolak = Report::where('status', Report::STATUS_DITOLAK)->count();

        // Persentase penyelesaian
        $rate = $total > 0 ? round(($selesai / $total) * 100, 1) : 0;

        // Distribusi per kategori
        $categories = Category::withCount('reports')
            ->orderByDesc('reports_count')
            ->get();

        // 5 Lokasi paling sering dilaporkan
        $topLocations = Report::select('location', DB::raw('count(*) as count'))
            ->groupBy('location')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return view('admin.statistik', compact(
            'total',
            'menunggu',
            'diverifikasi',
            'diproses',
            'selesai',
            'ditolak',
            'rate',
            'categories',
            'topLocations'
        ));
    }
}
