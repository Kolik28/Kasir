<div>
    <style>
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.18);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        .prod-card:hover:not(.oos) {
            border-color: #1D9E75;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(29, 158, 117, 0.12);
        }

        .prod-card:active:not(.oos) {
            transform: translateY(0);
        }

        .pay-method.selected {
            border-color: #1D9E75 !important;
            background: #E1F5EE !important;
            color: #0F6E56 !important;
            font-weight: 500;
        }

        .pay-method:hover:not(.selected) {
            border-color: rgba(0, 0, 0, 0.18);
            background: white;
        }
    </style>

    <div class="grid h-screen" style="grid-template-rows: 52px 1fr; grid-template-columns: 1fr 360px;">
        <!-- HEADER -->
        <header class="col-span-2 bg-white border-b border-black/10 flex items-center gap-4 px-5">
            <span class="text-xs text-[#6b6a65]">Kasir: <strong>{{ Auth::user()->name ?? 'Admin' }}</strong></span>
        </header>

        <!-- LEFT PANEL -->
        <div class="p-4 flex flex-col gap-3 overflow-hidden">
            <!-- Search -->
            <div class="relative">
                <input type="text" wire:model.live="search"
                    class="w-full pl-8 pr-3 py-2 text-[13px] border border-black/20 rounded-[10px] bg-white text-[#1a1a18] font-sans placeholder-[#a8a79f] focus:outline-none focus:border-accent transition-colors"
                    placeholder="Cari produk...">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <!-- Categories -->
            <div class="flex gap-1.5 flex-wrap">
                @php $allCats = ['Semua', ...$categories->pluck('nama')->toArray()]; @endphp
                @foreach ($allCats as $cat)
                    <button wire:click="setCategory('{{ $cat }}')"
                        class="text-[11px] px-3.5 py-1.5 rounded-full border border-black/10 cursor-pointer transition-all font-sans
                            {{ $activeCategory === $cat
                                ? 'bg-slate-600 text-white border-slate-600 font-medium capitalize'
                                : 'bg-white text-[#6b6a65] hover:bg-slate-50 hover:border-black/20 capitalize' }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            <!-- Product Grid -->
            <div class="grid gap-3 overflow-y-auto flex-1 pr-1"
                style="grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));">
                @forelse ($products as $product)
                    @php
                        $qty = $cart[$product->id] ?? 0;
                        $oos = $product->stok === 0;
                    @endphp
                    @if ($product->stok > 0 || ($cart[$product->id] ?? 0) > 0)
                        <div class="mt-2 prod-card bg-white border border-black/10 rounded-[14px] flex flex-col cursor-pointer transition-all relative select-none
                            {{ $oos ? 'oos opacity-50 cursor-not-allowed' : 'hover:border-green-600' }}"
                            @if (!$oos) wire:click="addToCart({{ $product->id }})" @endif
                            style="aspect-ratio: 3/4">
                            @if ($qty > 0)
                                <div
                                    class="absolute top-2 right-2 z-10 w-5 h-5 bg-orange-600 rounded-full text-[10px] font-semibold text-white flex items-center justify-center font-mono">
                                    {{ $qty }}
                                </div>
                            @endif
                            <div
                                class="aspect-square overflow-hidden bg-slate-100 flex-shrink-0 flex items-center justify-center p-2 rounded-t-[12px]">
                                @if ($product->icon)
                                    @if (str_starts_with($product->icon, '/storage/') || str_starts_with($product->icon, 'http'))
                                        <img src="{{ $product->icon }}" alt="{{ $product->nama }}"
                                            class="w-full h-full object-cover rounded-t-[12px]" loading="lazy   "
                                            onerror="this.parentElement.innerHTML='📦'">
                                    @else
                                        <span class="text-lg">{{ $product->icon }}</span>
                                    @endif
                                @else
                                    <span class="text-lg">📦</span>
                                @endif
                            </div>
                            <div class="p-3.5 flex-1 flex flex-col">
                                <div
                                    class="text-xs font-medium text-[#1a1a18] mb-1 leading-snug capitalize line-clamp-2">
                                    {{ $product->nama }}</div>
                                <div class="text-xs font-mono text-orange-700 font-medium">Rp
                                    {{ number_format($product->harga, 0, ',', '.') }}</div>
                                <div class="text-[10px] text-[#a8a79f] mt-auto">
                                    {{ $oos ? 'Stok habis' : 'Stok: ' . $product->stok }}</div>
                            </div>
                        </div>
                    @else
                        <div class="mt-2 prod-card bg-white border border-red-300 rounded-[14px] flex flex-col relative select-none oos opacity-45 cursor-not-allowed"
                            style="aspect-ratio: 3/4;">
                            <div class="absolute top-2 left-1/2 -translate-x-1/2 z-20">
                                <span
                                    class="bg-red-600 text-white px-2.5 py-1 rounded-md text-[10px] font-semibold whitespace-nowrap">Stok
                                    Habis</span>
                            </div>
                            <div
                                class="aspect-square overflow-hidden bg-slate-100 flex-shrink-0 flex items-center justify-center p-2 opacity-50 rounded-t-[12px]">
                                @if (filter_var($product->icon, FILTER_VALIDATE_URL))
                                    <img src="{{ $product->icon }}" alt="{{ $product->nama }}"
                                        class="w-full h-full object-cover rounded-t-[12px]" loading="lazy"
                                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                    <div class="hidden text-4xl">{{ $product->icon ?? '📦' }}</div>
                                @else
                                    <div class="text-4xl">{{ $product->icon ?? '📦' }}</div>
                                @endif
                            </div>
                            <div class="p-3.5 flex-1 flex flex-col opacity-60">
                                <div
                                    class="text-xs font-medium text-[#1a1a18] mb-1 leading-snug capitalize line-clamp-2">
                                    {{ $product->nama }}</div>
                                <div class="text-xs font-mono text-orange-700 font-medium">Rp
                                    {{ number_format($product->harga, 0, ',', '.') }}</div>
                                <div class="text-[10px] text-[#a8a79f] mt-auto">Stok: {{ $product->stok }}</div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-span-full text-center py-10 text-[#a8a79f] text-[13px]">Produk tidak ditemukan</div>
                @endforelse
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="bg-white border-l border-black/10 flex flex-col overflow-hidden">
            <!-- Cart Header -->
            <div class="px-4 py-3.5 border-b border-black/10 flex items-center gap-2">
                <span class="text-sm font-medium">Pesanan</span>
                <span class="font-mono text-[11px] text-[#a8a79f] flex-1">{{ count($cart) }} item</span>
                <button wire:click="clearCart()"
                    class="text-[11px] text-red-600 bg-transparent border-none cursor-pointer px-2 py-1 rounded-md hover:bg-red-50 transition-colors font-sans">
                    Hapus Semua
                </button>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-3 flex flex-col gap-2" id="cartItems">
                @if (count($cart) > 0)
                    @foreach ($cart as $produkId => $qty)
                        @php $prod = $allProducts->find($produkId); @endphp
                        @if ($prod)
                            <div class="flex items-center gap-2.5 p-2.5 bg-slate-50 rounded-[10px]"
                                wire:key="cart-{{ $produkId }}">
                                <div
                                    class="w-10 h-10 rounded-md bg-slate-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                                     @if ($prod->icon)
                                            @if (str_starts_with($prod->icon, '/storage/') || str_starts_with($prod->icon, 'http'))
                                                <img src="{{ $prod->icon }}" alt="{{ $prod->nama }}" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='📦'">
                                            @else
                                                <span class="text-lg">{{ $prod->icon }}</span>
                                            @endif
                                        @else
                                            <span class="text-lg">📦</span>
                                        @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-medium truncate">{{ $prod->nama }}</div>
                                    <div class="text-[11px] font-mono text-[#6b6a65]">Rp
                                        {{ number_format($prod->harga, 0, ',', '.') }} × {{ $qty }} = Rp
                                        {{ number_format($prod->harga * $qty, 0, ',', '.') }}</div>
                                </div>
                                <div class="flex items-center gap-1.5 flex-shrink-0">
                                    <button wire:click="removeFromCart({{ $produkId }})"
                                        class="w-6 h-6 rounded-md border border-black/20 bg-white text-[#1a1a18] text-sm cursor-pointer flex items-center justify-center font-mono transition-all hover:bg-orange-100 hover:border-orange-500 hover:text-orange-700">
                                        −
                                    </button>
                                    <span
                                        class="text-[13px] font-mono font-medium min-w-[18px] text-center">{{ $qty }}</span>
                                    <button wire:click="addToCart({{ $produkId }})"
                                        class="w-6 h-6 rounded-md border border-black/20 bg-white text-[#1a1a18] text-sm cursor-pointer flex items-center justify-center font-mono transition-all hover:bg-orange-100 hover:border-orange-500 hover:text-orange-700">
                                        +
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="flex-1 flex flex-col items-center justify-center gap-2 text-[#a8a79f] text-[13px]">
                        <div class="text-4xl opacity-35">🛒</div>
                        <span>Keranjang kosong</span>
                        <span class="text-[11px]">Pilih produk untuk memulai</span>
                    </div>
                @endif
            </div>

            <!-- Cart Footer -->
            <div class="px-4 py-3.5 border-t border-black/10 flex flex-col gap-2.5">
                <!-- Summary -->
                <div class="flex justify-between items-center text-xs text-[#6b6a65]">
                    <span>Subtotal</span>
                    <span class="font-mono font-medium text-[#1a1a18]">Rp
                        {{ number_format($totals['subtotal'], 0, ',', '.') }}</span>
                </div>
                <div
                    class="flex justify-between items-center text-[15px] font-semibold border-t border-black/10 pt-2.5">
                    <span>Total</span>
                    <span class="font-mono">Rp {{ number_format($totals['total'], 0, ',', '.') }}</span>
                </div>

                <!-- Payment Methods -->
                <p class="text-[11px] text-[#6b6a65] -mb-1">Metode Pembayaran</p>
                <div class="grid grid-cols-2 gap-1.5">
                    @foreach (['tunai' => 'Tunai', 'qris' => 'QRIS', 'debit' => 'Debit', 'kredit' => 'Kredit'] as $method => $label)
                        <button wire:click="setPaymentMethod('{{ $method }}')"
                            class="pay-method {{ $paymentMethod === $method ? 'selected' : '' }} text-[11px] py-2 px-1.5 rounded-lg border border-black/10 bg-slate-50 text-[#6b6a65] cursor-pointer transition-all text-center font-sans">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <!-- Checkout Button -->
                <button wire:click="checkout()" {{ count($cart) === 0 ? 'disabled' : '' }}
                    class="w-full py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Checkout
                </button>
            </div>
        </div>
    </div>

    <!-- CHECKOUT CONFIRMATION MODAL -->
    @if ($showReceipt && count($cart) === 0)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-8 w-[350px] max-h-[90vh] overflow-y-auto text-center shadow-2xl">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-green-600 mb-1">Transaksi Berhasil!</h3>
                    <p class="text-[13px] text-[#6b6a65]">Invoice: <span
                            class="font-mono font-semibold">{{ $invoiceNumber }}</span></p>
                    <p class="text-[12px] text-[#a8a79f] mt-2">{{ now()->format('d M Y · H:i') }}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4 mb-6 text-left max-h-[300px] overflow-y-auto">
                    <div class="text-[11px] space-y-2">
                        @php $idx = 0; @endphp
                        @foreach ($cart as $produkId => $qty)
                            @php
                                $prod = $allProducts->find($produkId);
                                $idx++;
                            @endphp
                            @if ($prod)
                                <div class="flex justify-between">
                                    <span>{{ $idx }}. {{ $prod->nama }}</span>
                                    <span class="text-right">
                                        <span class="font-mono">{{ $qty }}× Rp {{ number_format($prod->harga, 0, ',', '.') }}</span>
                                    </span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="flex gap-2.5 flex-col">
                    <button onclick="window.open('{{ route('transaksi.print', $invoiceNumber) }}', '_blank')"
                        class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                        <span>Cetak Struk</span>
                    </button>
                    <button wire:click="newTransaction()"
                        class="w-full py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                        <span>Transaksi Baru</span>
                    </button>
                </div>
                <p class="text-[11px] text-[#a8a79f] mt-4">Transaksi telah disimpan ke dalam sistem</p>
            </div>
        </div>
    @endif
</div>
