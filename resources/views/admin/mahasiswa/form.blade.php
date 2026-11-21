{{-- Dipakai bersama oleh halaman tambah & edit mahasiswa --}}
@php
    $u = $user ?? null;
    $editing = (bool) $u;
    $fields = [
        ['name', 'Nama lengkap', 'text', 'sm:col-span-2', 'name'],
        ['nim', 'NIM', 'text', '', 'off'],
        ['program_studi', 'Program studi', 'text', '', 'off'],
        ['email', 'Email', 'email', '', 'email'],
        ['phone', 'Nomor telepon / WA', 'tel', '', 'tel'],
    ];
@endphp

<form action="{{ $action }}" method="POST" class="panel max-w-3xl" x-data="{ busy: false }" @submit="busy = true">
    @csrf

    <div class="panel-body space-y-8">
        <fieldset>
            <legend class="section-label mb-4">Identitas</legend>
            <div class="grid gap-5 sm:grid-cols-2">
                @foreach ($fields as [$key, $label, $type, $span, $auto])
                    <div class="{{ $span }}">
                        <label for="{{ $key }}" class="label">{{ $label }}</label>
                        <input type="{{ $type }}" name="{{ $key }}" id="{{ $key }}" required autocomplete="{{ $auto }}"
                               value="{{ old($key, $u?->{$key}) }}"
                               @class(['input', 'num' => $key === 'nim', 'is-invalid' => $errors->has($key)])>
                        @error($key) <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                @endforeach
            </div>
        </fieldset>

        <fieldset class="border-t border-line pt-6">
            <legend class="section-label float-left mb-1 w-full">Kata sandi</legend>
            <p class="hint clear-both mb-4 mt-0">{{ $editing ? 'Kosongkan jika tidak ingin mengganti kata sandi.' : 'Minimal 8 karakter. Sampaikan ke mahasiswa secara langsung.' }}</p>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="label">{{ $editing ? 'Kata sandi baru' : 'Kata sandi' }}</label>
                    <input type="password" name="password" id="password" autocomplete="new-password" @required(! $editing)
                           @class(['input', 'is-invalid' => $errors->has('password')])>
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="label">Ulangi kata sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" @required(! $editing) class="input">
                </div>
            </div>
        </fieldset>
    </div>

    <div class="panel-foot">
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-quiet">Batal</a>
        <button type="submit" class="btn btn-primary" :disabled="busy">
            <span x-cloak x-show="busy" class="spinner" aria-hidden="true"></span>
            {{ $submit }}
        </button>
    </div>
</form>
