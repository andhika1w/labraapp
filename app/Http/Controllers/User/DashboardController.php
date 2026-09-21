<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        return view('user.dashboard', [
            'total' => Report::where('user_id', $userId)->count(),
            'menunggu' => Report::where('user_id', $userId)->where('status', Report::STATUS_MENUNGGU)->count(),
            'diproses' => Report::where('user_id', $userId)->where('status', Report::STATUS_DIPROSES)->count(),
            'selesai' => Report::where('user_id', $userId)->where('status', Report::STATUS_SELESAI)->count(),
            'recentReports' => Report::where('user_id', $userId)->with('category')->latest()->take(3)->get()
        ]);
    }
}
