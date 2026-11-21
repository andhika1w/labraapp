import './bootstrap';
import Alpine from 'alpinejs';

/**
 * Pratinjau foto bukti sebelum dikirim, dengan batas jumlah file.
 */
Alpine.data('photoPicker', (max = 3) => ({
    previews: [],
    error: '',
    over: false,

    pick(event) {
        const files = Array.from(event.target.files || []);

        this.previews.forEach((preview) => URL.revokeObjectURL(preview.url));
        this.previews = [];
        this.error = '';

        if (files.length > max) {
            this.error = `Maksimal ${max} foto. Anda memilih ${files.length}, silakan pilih ulang.`;
            event.target.value = '';
            return;
        }

        this.previews = files.map((file) => ({
            name: file.name,
            size: file.size < 1048576 ? `${Math.round(file.size / 1024)} KB` : `${(file.size / 1048576).toFixed(1)} MB`,
            url: URL.createObjectURL(file),
        }));
    },
}));

window.Alpine = Alpine;

Alpine.start();
