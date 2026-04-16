@extends('header.app')

@section('content')
    <div class="container mx-auto px-4 py-8 text-slate-900">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">Histori Transaksi</h1>
            <p class="text-lg text-slate-600">Kelola dan lihat semua transaksi penjualan Anda</p>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-lg font-semibold mb-4">Filter & Pencarian</h2>
            <form method="GET" action="{{ route('transaksi.history') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                    <!-- Search by ID -->
                    <div>
                        <label for="id" class="block text-sm font-medium text-slate-700 mb-1">ID Transaksi</label>
                        <input type="number" id="id" name="id" value="{{ $search['id'] ?? '' }}" 
                            placeholder="Cari ID..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <!-- Search by Kasir -->
                    <div>
                        <label for="kasir" class="block text-sm font-medium text-slate-700 mb-1">Nama Kasir</label>
                        <input type="text" id="kasir" name="kasir" value="{{ $search['kasir'] ?? '' }}" 
                            placeholder="Cari kasir..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                    <div>
                        <label for="dari_tanggal" class="block text-sm font-medium text-slate-700 mb-1">Dari Tanggal</label>
                        <input type="date" id="dari_tanggal" name="dari_tanggal" value="{{ $search['dari_tanggal'] ?? '' }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label for="sampai_tanggal" class="block text-sm font-medium text-slate-700 mb-1">Sampai Tanggal</label>
                        <input type="date" id="sampai_tanggal" name="sampai_tanggal" value="{{ $search['sampai_tanggal'] ?? '' }}" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2 pt-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                        Cari
                    </button>
                    <a href="{{ route('transaksi.history') }}" class="bg-slate-300 hover:bg-slate-400 text-slate-800 font-semibold py-2 px-6 rounded-lg transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if ($transaksis->count() > 0)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-green-600 text-white">
                                <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Kasir</th>
                                <th class="px-6 py-4 text-right text-sm font-semibold">Subtotal</th>
                                <th class="px-6 py-4 text-right text-sm font-semibold">Total</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Metode</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold">Status</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($transaksis as $transaksi)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 text-sm font-medium">{{ $transaksi->id }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $transaksi->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-right">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-right font-semibold">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-block bg-slate-200 text-slate-800 px-3 py-1 rounded-full text-xs">
                                            {{ ucfirst($transaksi->metode_pembayaran) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        @if ($transaksi->status === 'selesai')
                                            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                ✓ Selesai
                                            </span>
                                        @elseif ($transaksi->status === 'pending')
                                            <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                ⏳ Pending
                                            </span>
                                        @else
                                            <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                                                ✗ {{ ucfirst($transaksi->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <div class="flex gap-2 justify-center">
                                            <a href="{{ route('transaksi.show', $transaksi->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs transition">
                                                Detail
                                            </a>
                                            <a href="{{ route('transaksi.print', $transaksi->id) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs transition">
                                                Cetak
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-slate-500">
                                        <p class="text-lg">Belum ada transaksi</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($transaksis->hasPages())
                <div class="mt-6">
                    {{ $transaksis->links() }}
                </div>
            @endif
        @else
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Tidak Ada Data</h3>
                <p class="text-blue-700">Belum ada transaksi yang tercatat. Mulai buat transaksi baru untuk melihat histori di sini.</p>
            </div>
        @endif
    </div>
@endsection