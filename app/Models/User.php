<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
        'nip',
        'program_studi',
        'phone',
        'photo',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password'  => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // -------------------------------------------------------
    // Helper: cek role
    // -------------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'user';
    }

    // -------------------------------------------------------
    // Relasi
    // -------------------------------------------------------

    /**
     * Pengaduan milik mahasiswa ini.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Riwayat perubahan status yang dilakukan admin ini.
     */
    public function reportUpdates(): HasMany
    {
        return $this->hasMany(ReportUpdate::class, 'admin_id');
    }
}
