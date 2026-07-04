
<div id="modal-delete"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6 animate-fade-in">

        {{-- Tombol Close --}}
        <button onclick="hideDeleteModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Icon --}}
        <div class="flex justify-center mb-4">
            <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>

        {{-- Teks --}}
        <div class="text-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Konfirmasi Hapus</h3>
            <p class="text-sm text-gray-500">
                Apakah Anda yakin ingin menghapus
                <span id="modal-item-name" class="font-semibold text-gray-800"></span>?
            </p>
            <p class="text-xs text-red-500 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3">
            <button onclick="hideDeleteModal()"
                    class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                Batal
            </button>
            <button onclick="submitDeleteForm()"
                    class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    let _deleteFormId = null;

    function showDeleteModal(formId, itemName) {
        _deleteFormId = formId;
        document.getElementById('modal-item-name').textContent = itemName;
        const modal = document.getElementById('modal-delete');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideDeleteModal() {
        const modal = document.getElementById('modal-delete');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        _deleteFormId = null;
    }

    function submitDeleteForm() {
        if (_deleteFormId) {
            document.getElementById(_deleteFormId).submit();
        }
    }

    // Tutup modal kalau klik background
    document.getElementById('modal-delete').addEventListener('click', function(e) {
        if (e.target === this) hideDeleteModal();
    });
</script>