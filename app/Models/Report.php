<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    /**
     * Status yang valid untuk pengaduan.
     */
    const STATUS_MENUNGGU    = 'Menunggu';
    const STATUS_DIVERIFIKASI = 'Diverifikasi';
    const STATUS_DIPROSES    = 'Diproses';
    const STATUS_SELESAI     = 'Selesai';
    const STATUS_DITOLAK     = 'Ditolak';

    /**
     * Transisi status yang valid sesuai business rule PRD.
     * Key = status saat ini, Value = status berikutnya yang diizinkan.
     */
    const VALID_TRANSITIONS = [
        self::STATUS_MENUNGGU     => [self::STATUS_DIVERIFIKASI, self::STATUS_DITOLAK],
        self::STATUS_DIVERIFIKASI => [self::STATUS_DIPROSES],
        self::STATUS_DIPROSES     => [self::STATUS_SELESAI],
        self::STATUS_SELESAI      => [],
        self::STATUS_DITOLAK      => [],
    ];

    protected $fillable = [
        'report_code',
        'user_id',
        'category_id',
        'title',
        'location',
        'description',
        'status',
    ];

    /**
     * Mahasiswa pemilik pengaduan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kategori pengaduan.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Foto-foto bukti pengaduan.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ReportImage::class);
    }

    /**
     * Riwayat perubahan status.
     */
    public function updates(): HasMany
    {
        return $this->hasMany(ReportUpdate::class)->latest();
    }

    /**
     * Kembalikan daftar status berikutnya yang valid dari status saat ini.
     */
    public function getValidNextStatuses(): array
    {
        return self::VALID_TRANSITIONS[$this->status] ?? [];
    }

    /**
     * Periksa apakah transisi ke status tertentu diizinkan.
     */
    public function canTransitionTo(string $newStatus): bool
    {
        return in_array($newStatus, $this->getValidNextStatuses());
    }
}
