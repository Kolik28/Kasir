@extends('header.app')

@section('content')
    <div class="container px-4 py-8 text-slate-900">
        <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
            <div class="mr-6">
                <h1 class="text-4xl font-semibold mb-2">Dashboard</h1>
                <h2 class="text-gray-600 ml-0.5">Admin Dashboard</h2>
            </div>
        </div>

        <!-- KPI Cards -->
        <section class="grid md:grid-cols-2 xl:grid-cols-5 gap-4 mb-8">
            <!-- Total Produk -->
            <div class="flex items-center p-6 bg-white shadow rounded-lg">
                <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-blue-600 bg-blue-100 rounded-full mr-4">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold">{{ $totalProduk }}</span>
                    <span class="block text-gray-500 text-sm">Total Produk</span>
                </div>
            </div>

            <!-- Total Stok -->
            <div class="flex items-center p-6 bg-white shadow rounded-lg">
                <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-green-600 bg-green-100 rounded-full mr-4">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold">{{ $totalStok }}</span>
                    <span class="block text-gray-500 text-sm">Total Stok</span>
                </div>
            </div>

            <!-- Transaksi Hari Ini -->
            <div class="flex items-center p-6 bg-white shadow rounded-lg">
                <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-purple-600 bg-purple-100 rounded-full mr-4">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold">{{ $transaksiHariIni }}</span>
                    <span class="block text-gray-500 text-sm">Transaksi Hari Ini</span>
                </div>
            </div>

            <!-- Pendapatan Hari Ini -->
            <div class="flex items-center p-6 bg-white shadow rounded-lg">
                <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-yellow-600 bg-yellow-100 rounded-full mr-4">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</span>
                    <span class="block text-gray-500 text-sm">Pendapatan Hari Ini</span>
                </div>
            </div>

            <!-- Produk Stok Rendah -->
            <div class="flex items-center p-6 bg-white shadow rounded-lg">
                <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-red-600 bg-red-100 rounded-full mr-4">
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2m7-2H5m14 0a2 2 0 11-4 0 2 2 0 014 0zM7 20a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <span class="block text-2xl font-bold">{{ $produkStokRendah }}</span>
                    <span class="block text-gray-500 text-sm">Stok Rendah (&lt;10)</span>
                </div>
            </div>
        </section>

        <!-- Charts and Tables -->
        <section class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
            <!-- Chart Stok Produk -->
            <div class="md:col-span-2 bg-white shadow rounded-lg">
                <div class="px-6 py-5 font-semibold border-b border-gray-100">Stok Produk</div>
                <div class="p-4">
                    <div style="width: 100%; height: 300px;">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Transaksi Terbaru -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-5 font-semibold border-b border-gray-100">Transaksi Terbaru</div>
                <div class="divide-y divide-gray-100">
                    @forelse($transaksiTerbaru as $transaksi)
                        <div class="px-6 py-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-sm">{{ $transaksi->user->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaksi->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <p class="font-bold text-orange-600">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
                            </div>
                            <div class="mt-2">
                                <span class="inline-block px-2 py-1 text-xs rounded-full {{ $transaksi->status == 'selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($transaksi->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-4 text-center text-gray-500 text-sm">Belum ada transaksi</div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Produk Terlaris -->
        <section class="mt-6 bg-white shadow rounded-lg">
            <div class="px-6 py-5 font-semibold border-b border-gray-100">Produk Terlaris</div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">Produk</th>
                            <th class="px-6 py-3 text-left font-semibold">Terjual</th>
                            <th class="px-6 py-3 text-left font-semibold">Harga</th>
                            <th class="px-6 py-3 text-left font-semibold">Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($produkTerlaris as $produk)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 font-medium">{{ $produk->nama }}</td>
                                <td class="px-6 py-3">{{ $produk->transaksi_items_sum_qty ?? 0 }} unit</td>
                                <td class="px-6 py-3">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $produk->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $produk->stok }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada penjualan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const labels = @json($namaproduk);
        const dataStok = @json($stok);

        const colors = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
        ];

        const borderColors = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Stok Produk',
                    data: dataStok,
                    backgroundColor: colors.slice(0, dataStok.length),
                    borderColor: borderColors.slice(0, dataStok.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endsection
