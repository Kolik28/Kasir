@extends('header.app')

@section('content')
    <div id="edit-produk" class="page px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('produk') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Edit Produk</h2>
            <p class="text-slate-600">Perbarui informasi produk</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Icon Preview & Upload -->
                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-3">Icon Produk</label>
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 rounded-lg bg-slate-100 flex items-center justify-center border-2 border-slate-300 overflow-hidden flex-shrink-0" id="iconPreview">
                            @if ($produk->icon && str_starts_with($produk->icon, '/storage/'))
                                <img src="{{ $produk->icon }}" alt="{{ $produk->nama }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl">{{ $produk->icon ?? '📦' }}</span>
                            @endif
                        </div>
                        <label for="icon" class="flex-1 cursor-pointer">
                            <div class="px-4 py-2.5 bg-slate-50 border-2 border-dashed border-slate-300 text-slate-900 text-sm rounded-lg hover:bg-slate-100 hover:border-orange-500 transition text-center cursor-pointer"
                                id="dropZone">
                                <span class="text-xs">Pilih gambar atau drag & drop</span>
                            </div>
                            <input type="file" id="icon" name="icon" accept="image/*" class="hidden" onchange="previewIcon(event)">
                        </label>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Format: PNG, JPG, JPEG, GIF (Max 2MB)</p>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Produk -->
                <div>
                    <label for="nama" class="block text-sm font-semibold text-slate-900 mb-2">Nama Produk</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $produk->nama) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400
                        focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                        @error('nama') border-red-500 @enderror"
                        placeholder="Masukkan nama produk" required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori_id" class="block text-sm font-semibold text-slate-900 mb-2">Kategori</label>
                    <select name="kategori_id" id="kategori_id"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900
                        focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                        @error('kategori_id') border-red-500 @enderror"
                        required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategories as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $produk->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga & Stok -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="harga" class="block text-sm font-semibold text-slate-900 mb-2">Harga</label>
                        <input type="number" id="harga" name="harga" value="{{ old('harga', $produk->harga) }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400
                            focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                            @error('harga') border-red-500 @enderror"
                            placeholder="0" required>
                        @error('harga')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="stok" class="block text-sm font-semibold text-slate-900 mb-2">Stok</label>
                        <input type="number" id="stok" name="stok" value="{{ old('stok', $produk->stok) }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400
                            focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                            @error('stok') border-red-500 @enderror"
                            placeholder="0" required>
                        @error('stok')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-slate-900 mb-2">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400
                        focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                        @error('deskripsi') border-red-500 @enderror"
                        placeholder="Masukkan deskripsi produk (opsional)">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex gap-4 pt-6 border-t border-slate-200">
                    <button type="submit" 
                        class="flex-1 px-6 py-2.5 bg-green-600 text-white font-semibold rounded-lg
                        hover:bg-green-700 active:bg-green-800 transition-colors
                        focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <i class="fas fa-check mr-2"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('produk') }}"
                        class="flex-1 px-6 py-2.5 bg-slate-100 text-slate-700 font-semibold rounded-lg
                        hover:bg-slate-200 active:bg-slate-300 transition-colors text-center">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview icon on file select
        function previewIcon(event) {
            const file = event.target.files[0];
            if (file) {
                // Check file size (max 2MB)
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

        // Drag and drop support
        const iconInput = document.getElementById('icon');
        const dropZone = document.getElementById('dropZone');

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
