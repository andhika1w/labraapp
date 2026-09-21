<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportUpdate extends Model
{
    public $timestamps = false; // Hanya ada created_at

    protected $fillable = [
        'report_id',
        'admin_id',
        'status',
        'note',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Pengaduan yang bersangkutan.
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    /**
     * Admin yang melakukan perubahan status.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
