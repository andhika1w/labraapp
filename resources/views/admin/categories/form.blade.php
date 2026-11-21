{{-- Dipakai bersama oleh halaman tambah & edit kategori --}}
<form action="{{ $action }}" method="POST" class="panel max-w-2xl" x-data="{ busy: false }" @submit="busy = true">
    @csrf
    <div class="panel-body space-y-5">
        <div>
            <label for="name" class="label">Nama kategori</label>
            <input type="text" name="name" id="name" required value="{{ old('name', $category->name ?? '') }}"
                   placeholder="Contoh: Laboratorium"
                   @class(['input', 'is-invalid' => $errors->has('name')])>
            @error('name') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="label">Deskripsi <span class="label-opt">(opsional)</span></label>
            <textarea id="description" name="description" rows="3" class="input"
                      placeholder="Jenis kerusakan yang termasuk kategori ini">{{ old('description', $category->description ?? '') }}</textarea>
        </div>

        <label class="choice">
            <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $category->is_active ?? true))>
            <span>
                <span class="block text-sm font-medium">Aktifkan kategori</span>
                <span class="mt-0.5 block text-[13px] text-ink-3">Jika dimatikan, kategori tidak bisa dipilih untuk laporan baru.</span>
            </span>
        </label>
    </div>

    <div class="panel-foot">
        <a href="/admin/kategori" class="btn btn-quiet">Batal</a>
        <button type="submit" class="btn btn-primary" :disabled="busy">
            <span x-cloak x-show="busy" class="spinner" aria-hidden="true"></span>
            {{ $submit }}
        </button>
    </div>
</form>
