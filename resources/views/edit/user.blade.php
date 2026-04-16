@extends('header.app')

@section('content')
    <div id="edit-user" class="page px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('user') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Edit Pengguna</h2>
            <p class="text-slate-600">Perbarui informasi pengguna</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <form action="{{ route('user.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-900 mb-2">
                        Nama Pengguna
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400
                        focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                        @error('name') border-red-500 @enderror"
                        placeholder="Masukkan nama pengguna" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-900 mb-2">
                        Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400
                        focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                        @error('email') border-red-500 @enderror"
                        placeholder="Masukkan email" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-900 mb-2">
                        Password
                        <span class="text-xs font-normal text-slate-500">(Kosongkan jika tidak ingin ubah)</span>
                    </label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400
                        focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                        @error('password') border-red-500 @enderror"
                        placeholder="Masukkan password baru (opsional)">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="role" class="block text-sm font-semibold text-slate-900 mb-2">
                        Role
                    </label>
                    <select id="role" name="role"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-slate-900
                        focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                        @error('role') border-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>
                        <option value="karyawan" {{ old('role', $user->role) === 'karyawan' ? 'selected' : '' }}>
                            Karyawan
                        </option>
                    </select>
                    @error('role')
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
                    <a href="{{ route('user') }}"
                        class="flex-1 px-6 py-2.5 bg-slate-100 text-slate-700 font-semibold rounded-lg
                        hover:bg-slate-200 active:bg-slate-300 transition-colors text-center">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
