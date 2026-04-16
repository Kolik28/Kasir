@extends('header.app')

@section('content')
    <div id="produk" class="page px-4 py-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Manajemen Produk</h2>
                    <p class="text-sm text-slate-600 mt-1">Kelola data produk</p>
                </div>
                <button onclick="toggleModal()"
                    class="inline-flex items-center justify-center sm:justify-start px-6 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Produk
                </button>
            </div>
        </div>

        <!-- Livewire Search Component -->
        <div class="mb-6">
            @livewire('produk-search')
        </div>
    </div>


    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white border border-slate-200 rounded-lg shadow-sm p-4 md:p-6">
                <!-- Modal header -->
                <div class="flex items-center justify-between border-b border-slate-200 pb-4 md:pb-5">
                    <h3 class="text-lg font-bold text-slate-900">
                        Tambah Produk
                    </h3>
                    <button type="button" onclick="toggleModal()"
                        class="text-slate-600 bg-transparent hover:bg-slate-100 hover:text-slate-900 rounded-lg text-sm w-9 h-9 ms-auto inline-flex justify-center items-center">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="supplierForm" action="{{ route('produk.store') }}" method="POST" class="space-y-4 md:space-y-6 py-4 md:py-6" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="icon" class="block mb-2 text-sm font-medium text-slate-900">Icon Produk</label>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-lg bg-slate-100 flex items-center justify-center border-2 border-dashed border-slate-300 overflow-hidden" id="iconPreview">
                                <span class="text-2xl">📷</span>
                            </div>
                            <label for="icon" class="flex-1 cursor-pointer">
                                <div class="relative">
                                    <input type="file" id="icon" name="icon" accept="image/*" 
                                        class="hidden"
                                        onchange="previewIcon(event)">
                                    <div class="px-4 py-2.5 bg-slate-50 border-2 border-dashed border-slate-300 text-slate-900 text-sm rounded-lg hover:bg-slate-100 hover:border-orange-500 transition text-center cursor-pointer">
                                        <span class="text-xs">Pilih gambar atau drag & drop</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">Format: PNG, JPG, JPEG, GIF (Max 2MB)</p>
                    </div>
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-slate-900">Nama Produk</label>
                        <input type="text" id="name" name="nama" 
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5"
                            placeholder="Masukkan nama Produk" required>
                    </div>
                    <div>
                        <label for="kategori" class="block mb-2 text-sm font-medium text-slate-900">Kategori</label>
                        <select name="kategori_id" id="kategori_id" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategory as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="harga" class="block mb-2 text-sm font-medium text-slate-900">Harga</label>
                        <input type="number" id="harga" name="harga" 
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5"
                            placeholder="Masukkan Harga" required>
                    </div>
                    <div>
                        <label for="stok" class="block mb-2 text-sm font-medium text-slate-900">Stok</label>
                        <input type="number" id="stok" name="stok" 
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5"
                            placeholder="Masukkan Stok" required>
                    </div>
                    <div>
                        <label for="deskripsi" class="block mb-2 text-sm font-medium text-slate-900">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="3"
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5"
                            placeholder="Masukkan Deskripsi" required></textarea>
                    </div>
                </form>
                <!-- Modal footer -->
                <div class="flex items-center border-t border-slate-200 space-x-4 pt-4 md:pt-5">
                    <button form="supplierForm" type="submit"
                        class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2.5 focus:outline-none">
                        Simpan
                    </button>
                    <button onclick="toggleModal()" type="button"
                        class="w-full text-slate-700 bg-slate-100 hover:bg-slate-200 focus:ring-4 focus:ring-slate-300 font-medium rounded-lg text-sm px-4 py-2.5 focus:outline-none">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('default-modal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }

        // Close modal when clicking outside
        document.getElementById('default-modal').addEventListener('click', function(event) {
            if (event.target === this) {
                toggleModal();
            }
        });

        function previewIcon(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB');
                    event.target.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('iconPreview');
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
                };
                reader.readAsDataURL(file);
            }
        }

        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('iconPreview');
        const dropZone = iconInput.parentElement;

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-orange-500', 'bg-orange-50');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-orange-500', 'bg-orange-50');
            }, false);
        });

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            iconInput.files = files;
            
            if (files.length > 0) {
                previewIcon({ target: { files: files } });
            }
        }
    </script>
@endsection
