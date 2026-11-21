@extends('layouts.app')

@section('title', 'Profil Akun')
@section('heading', 'Profil Pengguna')
@section('subtitle', 'Informasi akun dan pengaturan keamanan kata sandi Anda.')

@section('content')
<div class="grid items-start gap-6 lg:grid-cols-2">
    {{-- Informasi Akun --}}
    <section class="panel" aria-labelledby="info-akun">
        <div class="panel-head">
            <h2 id="info-akun" class="panel-title">Informasi Akun</h2>
            <x-badge :status="$user->isAdmin() ? 'Aktif' : ($user->is_active ? 'Aktif' : 'Nonaktif')" />
        </div>
        <div class="panel-body">
            <div class="flex items-center gap-4 border-b border-line pb-5">
                <span class="avatar h-12 w-12 text-base" aria-hidden="true">
                    {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                </span>
                <div class="min-w-0">
                    <p class="truncate text-base font-semibold text-ink">{{ $user->name }}</p>
                    <p class="text-xs text-ink-3">
                        {{ $user->isAdmin() ? 'Administrator Sistem' : 'Mahasiswa' }}
                    </p>
                </div>
            </div>

            <dl class="mt-5 grid grid-cols-1 gap-y-4 text-sm sm:grid-cols-2">
                <div>
                    <dt class="section-label">Email</dt>
                    <dd class="mt-1 font-medium text-ink">{{ $user->email }}</dd>
                </div>

                @if ($user->nim)
                    <div>
                        <dt class="section-label">NIM</dt>
                        <dd class="num mt-1 font-medium text-ink">{{ $user->nim }}</dd>
                    </div>
                @endif

                @if ($user->nip)
                    <div>
                        <dt class="section-label">NIP</dt>
                        <dd class="num mt-1 font-medium text-ink">{{ $user->nip }}</dd>
                    </div>
                @endif

                @if ($user->program_studi)
                    <div>
                        <dt class="section-label">Program Studi</dt>
                        <dd class="mt-1 font-medium text-ink">{{ $user->program_studi }}</dd>
                    </div>
                @endif

                @if ($user->phone)
                    <div>
                        <dt class="section-label">Nomor Telepon / WA</dt>
                        <dd class="num mt-1 font-medium text-ink">{{ $user->phone }}</dd>
                    </div>
                @endif

                <div>
                    <dt class="section-label">Terdaftar Sejak</dt>
                    <dd class="num mt-1 text-ink-3 text-xs">{{ $user->created_at?->format('d F Y') ?? '-' }}</dd>
                </div>
            </dl>

            <p class="mt-6 border-t border-line pt-4 text-xs text-ink-3">
                *Jika terdapat kesalahan pada data identitas akademik Anda, silakan hubungi administrator kampus.
            </p>
        </div>
    </section>

    {{-- Ganti Kata Sandi --}}
    <section class="panel" aria-labelledby="keamanan-akun">
        <div class="panel-head">
            <h2 id="keamanan-akun" class="panel-title">Pengaturan Kata Sandi</h2>
        </div>
        <form action="/profil/password" method="POST" x-data="{ busy: false, reveal: false }" @submit="busy = true">
            @csrf
            <div class="panel-body space-y-5">
                <div>
                    <label for="current_password" class="label">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" id="current_password" required autocomplete="current-password"
                           class="input @error('current_password') is-invalid @enderror">
                    @error('current_password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="label">Kata Sandi Baru</label>
                    <input type="password" name="password" id="password" required autocomplete="new-password"
                           class="input @error('password') is-invalid @enderror">
                    <p class="hint">Minimal 8 karakter.</p>
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="label">Ulangi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                           class="input">
                </div>
            </div>

            <div class="panel-foot">
                <button type="submit" class="btn btn-primary" :disabled="busy">
                    <span x-cloak x-show="busy" class="spinner" aria-hidden="true"></span>
                    <span x-text="busy ? 'Menyimpan…' : 'Perbarui Kata Sandi'">Perbarui Kata Sandi</span>
                </button>
            </div>
        </form>
    </section>
</div>
@endsection
