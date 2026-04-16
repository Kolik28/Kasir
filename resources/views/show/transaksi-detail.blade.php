@extends('header.app')

@section('content')
    <div class="container mx-auto px-4 py-8 text-slate-900">
        <div class="mb-8">
            <a href="{{ route('transaksi.history') }}" class="text-blue-600 hover:text-blue-800 font-medium mb-4 inline-block">
                ← Kembali ke Histori
            </a>
            <h1 class="text-3xl font-bold">Detail Transaksi #{{ $transaksi->id }}</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Utama -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Informasi Transaksi</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-slate-600 text-sm">ID Transaksi</p>
                            <p class="font-semibold text-lg">#{{ $transaksi->id }}</p>
                        </div>
                        <div>
                            <p class="text-slate-600 text-sm">Tanggal</p>
                            <p class="font-semibold">{{ $transaksi->created_at->format('d M Y H:i:s') }}</p>
                        </div>
                        <div>
                            <p class="text-slate-600 text-sm">Kasir</p>
                            <p class="font-semibold">{{ $transaksi->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-600 text-sm">Metode Pembayaran</p>
                            <p class="font-semibold">{{ ucfirst($transaksi->metode_pembayaran) }}</p>
                        </div>
                        <div>
                            <p class="text-slate-600 text-sm">Status</p>
                            <div class="mt-1">
                                @if ($transaksi->status === 'selesai')
                                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        Selesai
                                    </span>
                                @elseif ($transaksi->status === 'pending')
                                    <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        ✗ {{ ucfirst($transaksi->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item Transaksi -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-semibold">Item Transaksi</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-slate-100">
                                    <th class="px-6 py-3 text-left text-sm font-semibold">Produk</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold">Qty</th>
                                    <th class="px-6 py-3 text-right text-sm font-semibold">Harga Satuan</th>
                                    <th class="px-6 py-3 text-right text-sm font-semibold">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach ($transaksi->items as $item)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-6 py-4 text-sm">
                                            <p class="font-medium">{{ $item->produk->nama }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm">{{ $item->qty }}</td>
                                        <td class="px-6 py-4 text-right text-sm">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-right text-sm font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Pembayaran -->
            <div>
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-8">
                    <h2 class="text-xl font-semibold mb-4">Ringkasan Pembayaran</h2>
                    
                    <div class="space-y-3 mb-6 pb-6 border-b">
                        <div class="flex justify-between">
                            <span class="text-slate-700">Subtotal</span>
                            <span class="font-semibold">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if ($transaksi->pajak && $transaksi->pajak > 0)
                            <div class="flex justify-between">
                                <span class="text-slate-700">Pajak</span>
                                <span class="font-semibold">Rp {{ number_format($transaksi->pajak, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        @if ($transaksi->diskon && $transaksi->diskon > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Diskon</span>
                                <span class="font-semibold">-Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-between items-center text-lg bg-blue-50 p-4 rounded-lg">
                        <span class="font-semibold">Total</span>
                        <span class="font-bold text-blue-600">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('transaksi.history') }}" class="block text-center bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold py-2 px-4 rounded-lg transition">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
