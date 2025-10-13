<div id="importModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="importModalLabel" role="dialog"
    aria-modal="true">
    <div id="importModalBackdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="flex items-center justify-center min-h-screen p-4">
        <div id="importModalPanel"
            class="relative bg-white rounded-lg shadow-xl transform transition-all sm:w-full sm:max-w-lg">
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900" id="importModalLabel">
                    Import Data RTLH
                </h3>
                <button data-modal-hide="importModal" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Tutup modal</span>
                </button>
            </div>

            <form action="{{ route('rtlh.import.excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <p class="text-base leading-relaxed text-gray-500">
                        Pilih file Excel (.xlsx, .xls) yang sesuai dengan format yang telah ditentukan.
                    </p>

                    <div class="text-sm text-gray-600">
                        Belum punya template?
                        <a href="{{ asset('asset/contoh_rtlh.xlsx') }}" download
                            class="inline-flex items-center font-medium text-green-600 hover:underline">
                            <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 16 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3" />
                            </svg>
                            Unduh template di sini
                        </a>.
                    </div>

                    @if (session('import_errors'))
                        <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                            <span class="font-medium">Terjadi beberapa kesalahan:</span>
                            <ul class="mt-1.5 list-disc list-inside">
                                @foreach (session('import_errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="file" class="block mb-2 text-sm font-medium text-gray-900">File Excel:</label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                            type="file" id="file" name="file" required>
                        @error('file')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                    <button data-modal-hide="importModal" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Tutup</button>
                    <button type="submit"
                        class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Unggah
                        & Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('importModal');
        if (!modal) return;

        const modalPanel = document.getElementById('importModalPanel');
        const backdrop = document.getElementById('importModalBackdrop');
        const openModalButtons = document.querySelectorAll('[data-modal-toggle="importModal"]');
        const closeModalButtons = document.querySelectorAll('[data-modal-hide="importModal"]');

        const showModal = () => {
            modal.classList.remove('hidden');
        };

        const hideModal = () => {
            modal.classList.add('hidden');
        };

        openModalButtons.forEach(button => {
            button.addEventListener('click', showModal);
        });

        closeModalButtons.forEach(button => {
            button.addEventListener('click', hideModal);
        });

        // Tutup modal jika klik di luar panel (di backdrop)
        backdrop.addEventListener('click', hideModal);

        // Jangan tutup modal jika klik di dalam panel
        modalPanel.addEventListener('click', (event) => {
            event.stopPropagation();
        });

        // Tutup modal dengan tombol Escape
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                hideModal();
            }
        });

        // Buka modal secara otomatis jika ada error validasi dari server
        @if (session('import_errors') || $errors->any())
            showModal();
        @endif
    });
</script>
