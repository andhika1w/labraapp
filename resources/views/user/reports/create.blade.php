@extends('layouts.app')

@section('title', 'Buat Pengaduan')
@section('back', '/pengaduan/riwayat')
@section('back_label', 'Riwayat pengaduan')
@section('subtitle', 'Isi selengkap mungkin agar petugas sarpras bisa langsung menemukan dan memperbaiki fasilitasnya.')

@section('content')
<form action="/pengaduan/buat" method="POST" enctype="multipart/form-data" class="panel max-w-3xl"
      x-data="{ busy: false }" @submit="busy = true">
    @csrf

    <div class="panel-body space-y-8">
        <fieldset class="space-y-5">
            <legend class="section-label mb-4">Apa yang rusak?</legend>

            <div>
                <label for="title" class="label">Judul aduan</label>
                <input type="text" name="title" id="title" required maxlength="255" value="{{ old('title') }}"
                       placeholder="Contoh: AC Ruang 203 meneteskan air"
                       @class(['input', 'is-invalid' => $errors->has('title')])>
                @error('title') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="category_id" class="label">Kategori</label>
                    <select id="category_id" name="category_id" required @class(['input', 'is-invalid' => $errors->has('category_id')])>
                        <option value="">Pilih kategori</option>
                        @foreach ($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="location" class="label">Lokasi</label>
                    <input type="text" name="location" id="location" required value="{{ old('location') }}"
                           placeholder="Gedung A, Lantai 2, Ruang 203"
                           @class(['input', 'is-invalid' => $errors->has('location')])>
                    @error('location') <p class="field-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="description" class="label">Deskripsi</label>
                <textarea id="description" name="description" rows="5" required
                          placeholder="Sejak kapan rusak, seberapa parah, dan apakah mengganggu perkuliahan."
                          @class(['input', 'is-invalid' => $errors->has('description')])>{{ old('description') }}</textarea>
                @error('description') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </fieldset>

        <fieldset x-data="photoPicker(3)">
            <legend class="section-label mb-4">Foto bukti</legend>

            <div class="dropzone" :class="over && 'is-over'"
                 @dragover="over = true" @dragleave="over = false" @drop="over = false">
                <input type="file" name="images[]" id="images" multiple required
                       accept="image/jpeg,image/png,image/jpg" @change="pick($event)" aria-describedby="images-hint">
                <svg class="h-7 w-7 text-ink-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" />
                </svg>
                <p class="text-sm"><span class="font-medium text-sign underline underline-offset-2">Pilih foto</span> atau seret ke sini</p>
                <p id="images-hint" class="text-xs text-ink-3">JPG atau PNG, maksimal 3 foto</p>
            </div>

            <p x-cloak x-show="error" x-text="error" class="field-error" role="alert"></p>
            @error('images') <p class="field-error">{{ $message }}</p> @enderror
            @error('images.*') <p class="field-error">{{ $message }}</p> @enderror

            <ul x-cloak x-show="previews.length" class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3" role="list">
                <template x-for="file in previews" :key="file.url">
                    <li class="overflow-hidden rounded-md border border-line bg-sunken"
                        x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0 scale-95">
                        <img :src="file.url" :alt="'Pratinjau ' + file.name" class="aspect-[4/3] w-full object-cover">
                        <p class="truncate px-2.5 py-2 text-xs text-ink-3"><span x-text="file.name"></span> · <span class="num" x-text="file.size"></span></p>
                    </li>
                </template>
            </ul>
        </fieldset>
    </div>

    <div class="panel-foot">
        <a href="/pengaduan/riwayat" class="btn btn-quiet">Batal</a>
        <button type="submit" class="btn btn-tag" :disabled="busy">
            <span x-cloak x-show="busy" class="spinner" aria-hidden="true"></span>
            <span x-text="busy ? 'Mengirim…' : 'Kirim Pengaduan'">Kirim Pengaduan</span>
        </button>
    </div>
</form>
@endsection
