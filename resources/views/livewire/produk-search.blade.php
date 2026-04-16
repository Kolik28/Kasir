<div>
    <!-- Search Input -->
    <div class="mb-6">
        <div class="relative">
            <input 
                type="text" 
                wire:model.live="search"
                placeholder="Cari produk berdasarkan nama atau deskripsi..." 
                class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400
                focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Results Info -->
    @if($search)
        <div class="mb-4 text-sm text-slate-600">
            Ditemukan <span class="font-semibold text-slate-900">{{ count($products) }}</span> produk
        </div>
    @endif

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if(count($products) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Icon</th>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Nama</th>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Kategori</th>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Harga</th>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Stok</th>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Deskripsi</th>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($products as $product)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="w-10 h-10 bg-slate-100 rounded flex items-center justify-center overflow-hidden">
                                        @if ($product->icon)
                                            @if (str_starts_with($product->icon, '/storage/') || str_starts_with($product->icon, 'http'))
                                                <img src="{{ $product->icon }}" alt="{{ $product->nama }}" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='📦'">
                                            @else
                                                <span class="text-lg">{{ $product->icon }}</span>
                                            @endif
                                        @else
                                            <span class="text-lg">📦</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900">{{ $product->nama }}</div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900">{{ $product->kategory ? $product->kategory->nama : '-' }}</div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900">{{ $product->stok }}</div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900 max-w-[150px] truncate">{{ $product->deskripsi }}</div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('produk.show', $product->id) }}"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs transition">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                        <a href="{{ route('produk.edit', $product->id) }}"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs transition">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <button 
                                            wire:click="deleteProduk({{ $product->id }})" 
                                            wire:confirm="Yakin ingin menghapus produk ini?"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs transition">
                                            <i class="fas fa-trash mr-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif($search)
            <div class="p-8 text-center">
                <i class="fas fa-search text-4xl mb-3 text-slate-300"></i>
                <p class="text-slate-600">Tidak ada produk yang cocok</p>
            </div>
        @else
            <div class="p-8 text-center">
                <i class="fas fa-box text-4xl mb-3 text-slate-300"></i>
                <p class="text-slate-600">Mulai cari produk untuk menampilkan hasil</p>
            </div>
        @endif
    </div>
</div>
