<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;

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
}
