<?php

namespace App\Livewire;

use App\Models\Produk;
use App\Models\Kategory;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('Transaksi POS')]
class TransaksiPOS extends Component
{
    public $search = '';
    public $activeCategory = 'Semua';
    public $cart = [];
    public $paymentMethod = 'tunai';
    public $showReceipt = false;
    public $invoiceNumber = '';
    
    public function render()
    {
        $allProducts = Produk::with('kategory')->get();
        $products = $allProducts;
        
        if ($this->search) {
            $products = $products->filter(function ($p) {
                return str_contains(strtolower($p->nama), strtolower($this->search));
            });
        }
        
        if ($this->activeCategory !== 'Semua') {
            $products = $products->filter(function ($p) {
                return $p->kategory && $p->kategory->nama === $this->activeCategory;
            });
        }
        
        $categories = Kategory::all();
        $totals = $this->calculateTotals();

        return view('livewire.transaksi-pos', [
            'products' => $products,
            'allProducts' => $allProducts,
            'categories' => $categories,
            'totals' => $totals,
        ]);
    }

    public function setCategory($cat)
    {
        $this->activeCategory = $cat;
    }

    public function addToCart($produkId)
    {
        $product = Produk::find($produkId);
        if (!$product || $product->stok === 0) return;

        if (!isset($this->cart[$produkId])) {
            $this->cart[$produkId] = 0;
        }

        if ($this->cart[$produkId] < $product->stok) {
            $this->cart[$produkId]++;
        }
    }

    public function removeFromCart($produkId)
    {
        if (isset($this->cart[$produkId])) {
            $this->cart[$produkId]--;
            if ($this->cart[$produkId] <= 0) {
                unset($this->cart[$produkId]);
            }
        }
    }

    public function clearCart()
    {
        $this->cart = [];
    }

    public function setPaymentMethod($method)
    {
        $this->paymentMethod = $method;
    }

    public function calculateTotals()
    {
        $subtotal = 0;
        foreach ($this->cart as $produkId => $qty) {
            $product = Produk::find($produkId);
            if ($product) {
                $subtotal += $product->harga * $qty;
            }
        }

        return [
            'subtotal' => $subtotal,
            'total' => $subtotal,
        ];
    }

    public function checkout()
    {
        if (empty($this->cart)) return;

        $items = [];
        foreach ($this->cart as $produkId => $qty) {
            $product = Produk::find($produkId);
            if ($product) {
                $items[] = [
                    'produk_id' => $product->id,
                    'qty' => $qty,
                    'harga_satuan' => $product->harga,
                ];
            }
        }

        $totals = $this->calculateTotals();

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'subtotal' => $totals['subtotal'],
            'pajak' => 0,
            'diskon' => 0,
            'total' => $totals['total'],
            'metode_pembayaran' => $this->paymentMethod,
            'status' => 'selesai'
        ]);

        foreach ($items as $item) {
            TransaksiItem::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item['produk_id'],
                'qty' => $item['qty'],
                'harga_satuan' => $item['harga_satuan'],
                'subtotal' => $item['qty'] * $item['harga_satuan']
            ]);

            $product = Produk::find($item['produk_id']);
            $product->decrement('stok', $item['qty']);
        }

        $this->cart = [];
        $this->invoiceNumber = $transaksi->id;
        $this->showReceipt = true;
        $this->dispatch('transaction-completed', transaksiId: $transaksi->id);
    }

    public function newTransaction()
    {
        $this->cart = [];
        $this->showReceipt = false;
        $this->invoiceNumber = '';
        $this->paymentMethod = 'tunai';
        $this->search = '';
        $this->activeCategory = 'Semua';
    }
}
