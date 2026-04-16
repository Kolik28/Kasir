@extends('header.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Laporan Penjualan</h1>
        <p class="text-gray-600">Kelola dan analisa data penjualan Anda</p>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('laporan') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" 
                    value="{{ $startDate }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" name="end_date" id="end_date" 
                    value="{{ $endDate }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                    Filter
                </button>
                <a href="{{ route('laporan.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
                    target="_blank" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition text-center">
                    Cetak
                </a>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
            <div class="text-sm font-medium opacity-90">Total Transaksi</div>
            <div class="text-3xl font-bold mt-2">{{ $stats->total_transaksi ?? 0 }}</div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
            <div class="text-sm font-medium opacity-90">Total Penjualan</div>
            <div class="text-3xl font-bold mt-2">Rp{{ number_format($stats->total_penjualan ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-md p-6 text-white">
            <div class="text-sm font-medium opacity-90">Rata-rata Penjualan</div>
            <div class="text-3xl font-bold mt-2">Rp{{ number_format($stats->rata_rata_penjualan ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
            <div class="text-sm font-medium opacity-90">Penjualan Tertinggi</div>
            <div class="text-3xl font-bold mt-2">Rp{{ number_format($stats->penjualan_tertinggi ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Metode Pembayaran -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-4">Penjualan Berdasarkan Metode Pembayaran</h2>
            <div class="space-y-3">
                @forelse($metodeStats as $metode)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <div class="font-semibold text-slate-900">{{ ucfirst($metode->metode_pembayaran) }}</div>
                            <div class="text-sm text-gray-600">{{ $metode->jumlah }} transaksi</div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-green-600">Rp{{ number_format($metode->total, 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">{{ round(($metode->total / ($stats->total_penjualan ?? 1)) * 100, 1) }}%</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-4">Tidak ada data</div>
                @endforelse
            </div>
        </div>

        <!-- Penjualan Harian -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-4">Penjualan Harian</h2>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                @forelse($harian as $hari)
                    <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                        <div>
                            <div class="font-medium text-slate-900">{{ \Carbon\Carbon::parse($hari->tanggal)->format('d M Y') }}</div>
                            <div class="text-sm text-gray-600">{{ $hari->jumlah_transaksi }} transaksi</div>
                        </div>
                        <div class="text-right text-green-600 font-semibold">
                            Rp{{ number_format($hari->total_penjualan, 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-4">Tidak ada data</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi Detail -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-slate-900 mb-4">Detail Transaksi</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b-2 border-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-900">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-900">Kasir</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-900">Subtotal</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-900">Total</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-900">Metode</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-900">Status</th>
                        <th class="px-4 py-3 text-center font-semibold text-slate-900">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $data)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-4 py-3 text-slate-900">{{ $data->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-slate-900">{{ $data->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-right text-slate-900">Rp{{ number_format($data->subtotal, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-green-600">Rp{{ number_format($data->total, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    {{ ucfirst($data->metode_pembayaran) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 {{ $data->status === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} rounded-full text-sm">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('transaksi.show', $data->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs transition">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                Tidak ada data transaksi untuk periode yang dipilih
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transaksi->hasPages())
            <div class="mt-4">
                {{ $transaksi->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    @media print {
        body {
            background: white;
        }
        .container {
            max-width: 100%;
        }
    }
</style>
@endsection