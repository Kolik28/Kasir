<div>
    <!-- Search Input -->
    <div class="mb-6">
        <div class="relative">
            <input 
                type="text" 
                wire:model.live="search"
                placeholder="Cari kategori berdasarkan nama atau deskripsi..." 
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
            Ditemukan <span class="font-semibold text-slate-900">{{ count($categories) }}</span> kategori
        </div>
    @endif

    <!-- Categories Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if(count($categories) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Nama</th>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Deskripsi</th>
                            <th class="px-4 lg:px-6 py-3 text-xs font-medium tracking-wider text-left text-slate-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($categories as $category)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900">{{ $category->nama }}</div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900 max-w-[200px] truncate">{{ $category->deskripsi }}</div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('kategori.edit', $category->id) }}"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs transition">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <button 
                                            wire:click="deleteKategori({{ $category->id }})" 
                                            wire:confirm="Yakin ingin menghapus kategori ini?"
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
                <p class="text-slate-600">Tidak ada kategori yang cocok</p>
            </div>
        @else
            <div class="p-8 text-center">
                <i class="fas fa-tag text-4xl mb-3 text-slate-300"></i>
                <p class="text-slate-600">Mulai cari kategori untuk menampilkan hasil</p>
            </div>
        @endif
    </div>
</div>
