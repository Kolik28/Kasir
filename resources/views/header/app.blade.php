<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasirku</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-slate-50 font-['Plus_Jakarta_Sans']">

    <div class="min-h-screen flex">

        <!-- SIDEBAR -->
        <aside class="w-60 flex-shrink-0 bg-white border-r border-slate-200 flex flex-col fixed top-0 left-0 h-full">

            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 h-16 border-b border-slate-200">
                <div>
                    <h1 class="font-bold text-4xl text-slate-900 uppercase">Kasirku</h1>
                </div>
            </div>

            <!-- Nav -->
            <div class="flex-1 overflow-y-auto py-3 px-2.5 flex flex-col gap-0.5">

                <p class="px-2.5 pt-3 pb-1 text-xs font-semibold tracking-widest text-slate-500 uppercase">Utama</p>

                @if (auth()->user()->role === 'admin')
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard.admin') }}"
                        class="flex items-center gap-2.5 px-2.5 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('dashboard.admin') ? 'bg-orange-100 text-orange-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}   ">
                        <span
                            class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0
                     {{ request()->routeIs('dashboard.admin') ? 'bg-orange-200' : 'bg-slate-100 group-hover:bg-slate-200' }}">
                            <svg class="w-4 h-4 text-slate-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 13h2v8H3zm4-8h2v16H7zm4-2h2v18h-2zm4 4h2v14h-2zm4-2h2v16h-2z" />
                            </svg>
                        </span>
                        Dashboard
                    </a>
                @endif

                <!-- Transaksi -->
                <a href="{{ route('transaksi') }}"
                    class="flex items-center gap-2.5 px-2.5 py-2.5 rounded-lg text-sm font-medium transition-colors
                    {{ request()->routeIs('transaksi') ? 'bg-orange-100 text-orange-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                    <span
                        class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('transaksi') ? 'bg-orange-200' : 'bg-slate-100 group-hover:bg-slate-200' }}">
                        <svg class="w-4 h-4 text-slate-700" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-0.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-0.9-2-2-2z" />
                        </svg>
                    </span>
                    Aplikasi Kasir
                </a>

                <!-- Riwayat Transaksi -->
                <a href="{{ route('transaksi.history') }}"
                    class="flex items-center gap-2.5 px-2.5 py-2.5 rounded-lg text-sm font-medium transition-colors
                    {{ request()->routeIs('transaksi.history') ? 'bg-orange-100 text-orange-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                    <span
                        class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('transaksi.history') ? 'bg-orange-200' : 'bg-slate-100 group-hover:bg-slate-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                            <path
                                d="M8.75 2.75a.75.75 0 0 0-1.5 0v3.69l-.72-.72a.75.75 0 0 0-1.06 1.06l2 2a.75.75 0 0 0 1.06 0l2-2a.75.75 0 1 0-1.06-1.06l-.72.72V2.75Z" />
                            <path
                                d="M4.784 4.5a.75.75 0 0 0-.701.483L2.553 9h2.412a1 1 0 0 1 .832.445l.406.61a1 1 0 0 0 .832.445h1.93a1 1 0 0 0 .832-.445l.406-.61A1 1 0 0 1 11.035 9h2.412l-1.53-4.017a.75.75 0 0 0-.7-.483h-.467a.75.75 0 0 1 0-1.5h.466c.934 0 1.77.577 2.103 1.449l1.534 4.026c.097.256.147.527.147.801v1.474A2.25 2.25 0 0 1 12.75 13h-9.5A2.25 2.25 0 0 1 1 10.75V9.276c0-.274.05-.545.147-.801l1.534-4.026A2.25 2.25 0 0 1 4.784 3h.466a.75.75 0 0 1 0 1.5h-.466Z" />
                        </svg>
                    </span>
                    Riwayat Transaksi
                </a>

                @if (auth()->user()->role === 'admin')
                    <!-- Produk -->
                    <a href="{{ route('produk') }}"
                        class="flex items-center gap-2.5 px-2.5 py-2.5 rounded-lg text-sm font-medium transition-colors
                    {{ request()->routeIs('produk') ? 'bg-orange-100 text-orange-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                        <span
                            class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('produk') ? 'bg-orange-200' : 'bg-slate-100 group-hover:bg-slate-200' }}">
                            <svg class="w-4 h-4 text-slate-700" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-0.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-0.9-2-2-2z" />
                            </svg>
                        </span>
                        Data Produk
                    </a>

                    <!-- Kategori -->

                    <a href="{{ route('kategori') }}"
                        class="flex items-center gap-2.5 px-2.5 py-2.5 rounded-lg text-sm font-medium transition-colors
                    {{ request()->routeIs('kategori') ? 'bg-orange-100 text-orange-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                        <span
                            class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('kategori') ? 'bg-orange-200' : 'bg-slate-100 group-hover:bg-slate-200' }}">
                            <svg class="w-4 h-4 text-slate-700" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M10 4H4c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 8H4V6h6v6zm10-8h-6c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 8h-6V6h6v6zm-6 4h-4c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h4c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2zm0 8h-4v-6h4v6zm10 0h-4v-6h4v6z" />
                            </svg>
                        </span>
                        Kategori
                    </a>

                    <!-- Supplier -->
                    <a href="{{ route('supplier') }}"
                        class="flex items-center gap-2.5 px-2.5 py-2.5 rounded-lg text-sm font-medium transition-colors
                    {{ request()->routeIs('supplier') ? 'bg-orange-100 text-orange-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                        <span
                            class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('supplier') ? 'bg-orange-200' : 'bg-slate-100 group-hover:bg-slate-200' }}">
                            <svg class="w-4 h-4 text-slate-700" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                            </svg>
                        </span>
                        Supplier
                    </a>

                    <!-- Stok Masuk -->
                    <a href="{{ route('stokmasuk') }}"
                        class="flex items-center gap-2.5 px-2.5 py-2.5 rounded-lg text-sm font-medium transition-colors
                    {{ request()->routeIs('stokmasuk') ? 'bg-orange-100 text-orange-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                        <span
                            class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('stokmasuk') ? 'bg-orange-200' : 'bg-slate-100 group-hover:bg-slate-200' }}">
                            <svg class="w-4 h-4 text-slate-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 10l-8 8-4-4" stroke="currentColor" stroke-width="2" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M6 9V5a2 2 0 012-2h8a2 2 0 012 2v4m0 0l3-3m-3 3l-3-3" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        Stok Masuk
                    </a>
                @endif


                <div class="h-px bg-slate-200 my-1.5"></div>
                <p class="px-2.5 pt-1 pb-1 text-xs font-semibold tracking-widest text-slate-500 uppercase">Manajemen</p>

                @if (auth()->user()->role === 'admin')
                    <!-- User -->
                    <a href="{{ route('user') }}"
                        class="flex items-center gap-2.5 px-2.5 py-2.5 rounded-lg text-sm font-medium transition-colors
                    {{ request()->routeIs('user') ? 'bg-orange-100 text-orange-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                        <span
                            class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('user') ? 'bg-orange-200' : 'bg-slate-100 group-hover:bg-slate-200' }}">
                            <svg class="w-4 h-4 text-slate-700" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </span>
                        User
                    </a>

                    <!-- Cetak Laporan-->
                    <a href="{{ route('laporan') }}"
                        class="flex items-center gap-2.5 px-2.5 py-2.5 rounded-lg text-sm font-medium transition-colors
                    {{ request()->routeIs('laporan.harian') ? 'bg-orange-100 text-orange-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-800' }}">
                        <span
                            class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0
                    {{ request()->routeIs('laporan.harian') ? 'bg-orange-200' : 'bg-slate-100 group-hover:bg-slate-200' }}">
                            <svg class="w-4 h-4 text-slate-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                            </svg>
                        </span>
                        Cetak Laporan
                    </a>
                @endif

                <!-- Footer user -->
                <div class="p-2.5 border-t border-slate-200">
                    <div
                        class="flex items-center gap-2.5 p-2.5 rounded-lg hover:bg-slate-100 cursor-pointer transition-colors">
                        <div class="flex-1 min-w-0">
                            <div class="text-xs font-semibold text-slate-800 truncate capitalize">
                                {{ Auth::user()->name }}</div>
                            <div class="text-xs text-slate-500 capitalize">{{ Auth::user()->role }}</div>
                        </div>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="w-6 h-6 rounded-md bg-slate-200 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf
                        </form>
                    </div>
                </div>

        </aside>

        <!-- MAIN CONTENT -->
        <main class="ml-60 flex-1 min-h-screen">
            @yield('content')
        </main>

    </div>

    <script>
        function toggleSub(btn, id) {
            const sub = document.getElementById(id);
            const chev = btn.querySelector('.chev');
            const isOpen = sub.style.maxHeight && sub.style.maxHeight !== '0px';
            sub.style.maxHeight = isOpen ? '0px' : sub.scrollHeight + 'px';
            chev.style.transform = isOpen ? '' : 'rotate(180deg)';
        }
    </script>

    @livewireScripts
</body>

</html>
