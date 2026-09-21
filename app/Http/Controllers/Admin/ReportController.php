<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\ReportUpdate;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['category', 'user'])->latest()->get();
        return view('admin.reports.index', compact('reports'));
    }

    public function show($id)
    {
        $report = Report::with(['category', 'user', 'images', 'updates.admin'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    public function updateStatus(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        
        $request->validate([
            'status' => 'required|string',
            'note' => 'nullable|string'
        ]);
        
        if (!$report->canTransitionTo($request->status)) {
            return back()->with('error', 'Status transisi tidak valid.');
        }

        $report->update(['status' => $request->status]);

        ReportUpdate::create([
            'report_id' => $report->id,
            'admin_id' => auth()->id(),
            'status' => $request->status,
            'note' => $request->note
        ]);

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
