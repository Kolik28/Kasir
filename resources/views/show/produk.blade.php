@extends('header.app')

@section('content')
    <div id="show-produk" class="page px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('produk') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Detail Produk</h2>
            <p class="text-slate-600">Lihat informasi lengkap produk</p>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Icon Section -->
                <div class="flex flex-col items-center lg:items-start">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Icon Produk</label>
                    <div class="w-100 aspect-square bg-slate-100 rounded-lg flex items-center justify-center border border-slate-200 overflow-hidden flex-shrink-0">
                        @if ($produk->icon && str_starts_with($produk->icon, '/storage/'))
                            <img src="{{ $produk->icon }}" alt="{{ $produk->nama }}" class="w-full h-full object-cover">
                        @elseif ($produk->icon)
                            <span class="text-3xl">{{ $produk->icon }}</span>
                        @else
                            <span class="text-3xl">📦</span>
                        @endif
                    </div>
                </div>

                <!-- Information Section -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Nama Produk -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Produk</label>
                        <p class="text-lg font-medium text-slate-900">{{ $produk->nama }}</p>
                    </div>

                    <!-- Grid: Kategori & Harga -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                            <p class="text-slate-900">{{ $produk->kategory ? $produk->kategory->nama : '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Harga</label>
                            <p class="text-lg font-semibold text-orange-600">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Stok</label>
                        <div class="flex items-center gap-3">
                            <span class="text-2xl font-bold text-slate-900">{{ $produk->stok }}</span>
                            <span class="text-xs px-3 py-1 rounded-full {{ $produk->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $produk->stok > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                        <p class="text-slate-700 leading-relaxed {{ !$produk->deskripsi ? 'italic text-slate-500' : '' }}">
                            {{ $produk->deskripsi ?? 'Tidak ada deskripsi' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-200 my-8"></div>

            <!-- Additional Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-600 uppercase tracking-wide mb-1">ID Produk</p>
                    <p class="text-lg font-semibold text-slate-900">#{{ $produk->id }}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-600 uppercase tracking-wide mb-1">Dibuat</p>
                    <p class="text-lg font-semibold text-slate-900">{{ $produk->created_at->format('d M Y') }}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-600 uppercase tracking-wide mb-1">Diperbarui</p>
                    <p class="text-lg font-semibold text-slate-900">{{ $produk->updated_at->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('produk.edit', $produk->id) }}"
                    class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-lg
                    hover:bg-blue-700 active:bg-blue-800 transition-colors
                    focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 inline-flex items-center gap-2">
                    <i class="fas fa-edit"></i> Edit Produk
                </a>
                <button onclick="confirmDelete()"
                    class="px-6 py-2.5 bg-red-600 text-white font-semibold rounded-lg
                    hover:bg-red-700 active:bg-red-800 transition-colors
                    focus:ring-2 focus:ring-red-500 focus:ring-offset-2 inline-flex items-center gap-2">
                    <i class="fas fa-trash"></i> Hapus Produk
                </button>
                <a href="{{ route('produk') }}"
                    class="px-6 py-2.5 bg-slate-100 text-slate-700 font-semibold rounded-lg
                    hover:bg-slate-200 active:bg-slate-300 transition-colors inline-flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteForm" action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDelete() {
            if (confirm('Yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
@endsection
