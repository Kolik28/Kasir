<div>
    <!-- Search Input -->
    <div class="mb-6">
        <div class="relative">
            <input 
                type="text" 
                wire:model.live="search"
                placeholder="Cari stok masuk berdasarkan produk atau supplier..." 
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
            Ditemukan <span class="font-semibold text-slate-900">{{ count($stokmasuk) }}</span> stok masuk
        </div>
    @endif

    <!-- Stock In Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if(count($stokmasuk) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Produk</th>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Supplier</th>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Qty</th>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($stokmasuk as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900">{{ $item->produk?->nama ?? '-' }}</div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900">{{ $item->supplier?->nama ?? '-' }}</div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900 font-semibold">{{ $item->qty }}</div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900">{{ $item->created_at?->format('d M Y') ?? '-' }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif($search)
            <div class="p-8 text-center">
                <i class="fas fa-search text-4xl mb-3 text-slate-300"></i>
                <p class="text-slate-600">Tidak ada stok masuk yang cocok</p>
            </div>
        @else
            <div class="p-8 text-center">
                <i class="fas fa-inbox text-4xl mb-3 text-slate-300"></i>
                <p class="text-slate-600">Mulai cari stok masuk untuk menampilkan hasil</p>
            </div>
        @endif
    </div>
</div>
