<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportImage extends Model
{
    public $timestamps = false; // Hanya ada created_at (dihandle useCurrent)

    protected $fillable = [
        'report_id',
        'image_path',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Pengaduan induk dari foto ini.
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
