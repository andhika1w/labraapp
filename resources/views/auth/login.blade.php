@extends('layouts.guest')

@section('content')
<h1 class="text-2xl font-semibold tracking-tight">Masuk</h1>
<p class="mt-1.5 text-sm text-ink-3">Gunakan email dan kata sandi akun kampus Anda.</p>

<form class="mt-8 space-y-5" action="/login" method="POST" x-data="{ busy: false, reveal: false }" @submit="busy = true">
    @csrf

    <div>
        <label for="email" class="label">Email</label>
        <input id="email" name="email" type="email" autocomplete="email" required autofocus
               value="{{ old('email') }}" placeholder="nama@kampus.ac.id"
               @class(['input', 'is-invalid' => $errors->has('email')])
               @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
        @error('email')
            <p id="email-error" class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="label">Kata sandi</label>
        <div class="relative">
            <input id="password" name="password" :type="reveal ? 'text' : 'password'" type="password" autocomplete="current-password" required
                   @class(['input pr-20', 'is-invalid' => $errors->has('password')])
                   @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
            <button type="button" @click="reveal = !reveal"
                    class="absolute inset-y-1 right-1 rounded px-2.5 text-xs font-medium text-ink-3 transition-colors duration-150 hover:bg-sunken hover:text-ink"
                    :aria-pressed="reveal.toString()" x-text="reveal ? 'Sembunyikan' : 'Tampilkan'">Tampilkan</button>
        </div>
        @error('password')
            <p id="password-error" class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-full" :disabled="busy">
        <span x-cloak x-show="busy" class="spinner" aria-hidden="true"></span>
        <span x-text="busy ? 'Memeriksa…' : 'Masuk'">Masuk</span>
    </button>
</form>

<p class="mt-8 border-t border-line pt-5 text-sm text-ink-3">
    Belum punya akun atau lupa kata sandi? Hubungi admin sarana prasarana kampus.
</p>
@endsection
