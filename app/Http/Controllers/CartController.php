<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $carts = Cart::with('product.category')->where('user_id', $user->id)->get();

        $cartTotal = 0;
        foreach ($carts as $cart) {
            $cartTotal += $cart->product->price * $cart->quantity;
        }

        // $diskonPersen = 0;
        $diskonPoin = 0;
        $totalDiskon = 0;
        $totalBayar = $cartTotal;
        $no_telp = $request->input('no_telp');
        $message = null;

        if ($no_telp) {
            $member = Member::where('no_telp', $no_telp)->first();

            if ($member) {
                if ($member->status !== 'active') {
                    $message = "Member sudah tidak aktif, diskon tidak berlaku.";
                } elseif ($member->point > 0) {
                    // $diskonPersen = $member->discount_percentage;
                    if ($member->point >= 40 && $member->point < 50) {
                        $totalDiskon = 0.4;
                    } elseif ($member->point >= 30 && $member->point < 40) {
                        $totalDiskon = 0.3;
                    } elseif ($member->point >= 20 && $member->point < 30) {
                        $totalDiskon = 0.2;
                    }
                    // 30% diskon untuk poin 30
                    $diskonPoin = $member->point;
                    $diskonNominal = ($cartTotal * $totalDiskon);
                    $totalBayar = $cartTotal - $diskonNominal;

                    // dd($totalBayar, $diskonPoin, $totalDiskon);
                }
            } else {
                $message = "Nomor telepon member tidak ditemukan.";
            }
        }

        return view('cart.index', compact('carts', 'cartTotal', 'diskonPoin', 'totalBayar', 'no_telp', 'message'));
    }

    /**
     * Tambah produk ke keranjang tanpa mengurangi stok.
     */
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->id);

        if ($product->stock <= 0) {
            return back()->with('error', 'Stok produk "' . $product->name . '" habis');
        }

        $cart = Cart::where('product_id', $product->id)
                    ->where('user_id', auth()->id())
                    ->first();

        if ($cart) {
            // Pastikan total quantity di cart tidak melebihi stok
            if ($product->stock <= $cart->quantity) {
                return back()->with('error', 'Jumlah dalam keranjang sudah sama dengan stok yang tersedia');
            }

            $cart->quantity++;
            $cart->save();
        } else {
            Cart::create([
                'product_id' => $product->id,
                'quantity' => 1,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk ' . $product->name . ' ditambahkan ke keranjang');
    }

    /**
     * Hapus item keranjang tanpa mengubah stok karena stok belum dikurangi.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang');
    }

    /**
     * Bulk action: delete, check_discount, buy.
     */
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $user = auth()->user();
        $totalDiskon = 0;
        $usedPoints = 0;

        if ($action === 'delete') {
            $selected = $request->input('selected_carts', []);
            Cart::whereIn('id', $selected)->where('user_id', $user->id)->delete();

            return redirect()->route('product.index')->with('success', 'Item keranjang berhasil dihapus.');
        }

        if ($action === 'check_discount') {
            $no_telp = $request->input('no_telp');
            return redirect()->route('cart.index', ['no_telp' => $no_telp]);
        }

        if ($action === 'buy') {
            $paidAmount = $request->input('paid_amount');
            $no_telp = $request->input('no_telp');

            // Ambil keranjang user dengan produk
            $carts = Cart::with('product')->where('user_id', $user->id)->get();

            // Hitung total harga keranjang sebelum diskon
            $cartTotal = 0;
            foreach ($carts as $cart) {
                $cartTotal += $cart->product->price * $cart->quantity;
            }

            $diskonPoin = 0;
            $member = null;

            // Cari member jika no_telp diisi
            if ($no_telp) {
                $member = Member::where('no_telp', $no_telp)->first();
                if ($member && $member->point > 0) {
                    $diskonPoin = $member->point;
                }
            }

            // Hitung total bayar setelah diskon berdasarkan poin
            if ($diskonPoin >= 40 && $diskonPoin < 50) {
                $totalDiskon = 0.4;
                $usedPoints = 40;
            } elseif ($diskonPoin >= 30 && $diskonPoin < 40) {
                $totalDiskon = 0.3;
                $usedPoints = 30;
            } elseif ($diskonPoin >= 20 && $diskonPoin < 30) {
                $totalDiskon = 0.2;
                $usedPoints = 20;
            } else {
                $totalDiskon = 0;
                $usedPoints = 0;
            }

            $totalBayar = $cartTotal - ($cartTotal * $totalDiskon);

            // Validasi bayar cukup
            if (!is_numeric($paidAmount) || $paidAmount < $totalBayar) {
                return redirect()->back()->withErrors(['paid_amount' => 'Uang dibayar kurang dari total bayar']);
            }

            // Hitung kembalian
            $change = $paidAmount - $totalBayar;

            DB::beginTransaction();
            try {
                $transactionIds = [];

                foreach ($carts as $cart) {
                    $product = $cart->product;

                    // Cek stok cukup
                    if ($product->stock < $cart->quantity) {
                        DB::rollBack();
                        return redirect()->back()->withErrors(['stock' => "Stok produk {$product->name} tidak cukup"]);
                    }

                    // Kurangi stok produk
                    $product->decrement('stock', $cart->quantity);

                    // Hitung harga final per produk setelah diskon
                    $finalPrice = ($product->price * $cart->quantity) * (1 - $totalDiskon);

                    $transaction = Transaction::create([
                        'user_id' => $user->id,
                        'member_id' => $member ? $member->id : null,
                        'product_id' => $product->id,
                        'quantity' => $cart->quantity,
                        'total_price' => $finalPrice,
                        'paid_amount' => $paidAmount,
                        'change' => $change,
                    ]);

                    $transactionIds[] = $transaction->id;
                }

                // Hapus keranjang user setelah transaksi
                Cart::where('user_id', $user->id)->delete();

                // Update poin member
                if ($member) {
                    $earnedPoints = floor($totalBayar / 10000); // 1 poin tiap 10.000
                    $member->point = ($member->point ?? 0) + $earnedPoints - $usedPoints;
                    $member->save();
                }

                DB::commit();

                return redirect()->route('invoice.show', ['ids' => implode(',', $transactionIds)])
                                 ->with('success', 'Transaksi berhasil!');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat transaksi: ' . $e->getMessage()]);
            }
        }
        return redirect()->route('cart.index');
    }

    /**
     * Fungsi scan barcode untuk tambah ke keranjang tanpa kurangi stok dulu.
     */
    public function scan(Request $request)
    {
        Log::info("Barcode scanned request masuk", [
            'auth' => Auth::id(),
            'barcode' => $request->barcode
        ]);

        $request->validate([
            'barcode' => 'required|string',
        ]);

        $product = Product::where('code', $request->barcode)->first();

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        if ($product->stock <= 0) {
            return response()->json(['message' => "Produk {$product->name} ditemukan, namun stoknya habis."], 400);
        }

        $userId = Auth::id();

        $cart = Cart::where('product_id', $product->id)
                    ->where('user_id', $userId)
                    ->first();

        if ($cart) {
            if ($product->stock <= $cart->quantity) {
                return response()->json(['message' => "Jumlah keranjang untuk produk {$product->name} sudah maksimal sesuai stok."], 400);
            }

            $cart->quantity += 1;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return response()->json([
            'message' => 'Produk ' . $product->name . ' berhasil ditambahkan ke keranjang',
            'product' => $product
        ]);
    }

    /**
     * Clear semua cart user.
     */
    public function clearExpired(Request $request)
    {
        $user = auth()->user();

        Cart::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Keranjang berhasil dikosongkan']);
    }

    /**
     * Perpanjang waktu transaksi (misal session timeout)
     */
    public function extendTime()
    {
        session(['cart_start_time' => now()]);

        return redirect()->route('cart.index')->with('info', 'Waktu transaksi telah diperpanjang.');
    }

    /**
     * Tampilkan keranjang (untuk kebutuhan khusus)
     */
    public function showCart(Request $request)
    {
        $carts = Cart::with('product.category')->get();

        $grandTotal = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        $no_telp = $request->input('no_telp');

        $diskonPersen = 0;
        $totalBayar = $grandTotal;

        if ($no_telp) {
            $member = Member::where('phone', $no_telp)->first();

            if ($member) {
                $diskonPersen = $member->point ?? 0;
                $totalBayar = $grandTotal - ($grandTotal * $diskonPersen / 100);
            }
        }

        return view('cart.index', compact('carts', 'grandTotal', 'no_telp', 'diskonPersen', 'totalBayar'));
    }
}
