@extends('header.app')

@section('content')
    <div id="edit-kategori" class="page px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('kategori') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Edit Kategori</h2>
            <p class="text-slate-600">Perbarui informasi kategori</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-900 mb-2">
                        Nama Kategori
                    </label>
                    <input type="text" id="name" name="nama" value="{{ old('nama', $kategori->nama) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400
                        focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                        @error('nama') border-red-500 @enderror"
                        placeholder="Masukkan nama kategori" required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-slate-900 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400
                        focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                        @error('deskripsi') border-red-500 @enderror"
                        placeholder="Masukkan deskripsi kategori (opsional)">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-4 pt-6 border-t border-slate-200">
                    <button type="submit" 
                        class="flex-1 px-6 py-2.5 bg-green-600 text-white font-semibold rounded-lg
                        hover:bg-green-700 active:bg-green-800 transition-colors
                        focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <i class="fas fa-check mr-2"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('kategori') }}"
                        class="flex-1 px-6 py-2.5 bg-slate-100 text-slate-700 font-semibold rounded-lg
                        hover:bg-slate-200 active:bg-slate-300 transition-colors text-center">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
