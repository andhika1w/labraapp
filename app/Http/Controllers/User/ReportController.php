<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Category;
use App\Models\ReportImage;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function index()
    {
        return view('user.reports.index', [
            'reports' => Report::where('user_id', auth()->id())->latest()->get()
        ]);
    }

    public function create()
    {
        return view('user.reports.create', [
            'categories' => Category::active()->get()
        ]);
    }

    public function show($id)
    {
        $report = Report::where('user_id', auth()->id())
            ->with(['category', 'images', 'updates.admin'])
            ->findOrFail($id);

        return view('user.reports.show', compact('report'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'required|array|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $reportCode = 'REP-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $report = Report::create([
            'report_code' => $reportCode,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'location' => $request->location,
            'description' => $request->description,
            'status' => Report::STATUS_MENUNGGU,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('reports', 'public');
                ReportImage::create([
                    'report_id' => $report->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect('/pengaduan/riwayat')->with('success', 'Pengaduan berhasil dikirim.');
    }
}
