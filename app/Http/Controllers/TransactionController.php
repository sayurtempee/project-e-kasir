<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Milon\Barcode\Facades\DNS1D;
use App\Models\Member;
use App\Services\FonnteService;

class TransactionController extends Controller
{
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }
    /**
     * Display a listing of the resource.
     * Menampilkan semua transaksi milik user.
     */
    public function index(Request $request)
    {
        $query = Transaction::with('product.category')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('date')) {
            $date = $request->input('date');
            $query->whereDate('created_at', $date);
        }

        $transactions = $query->paginate(10)->appends($request->only('search', 'date'));

        return view('transaction.index', compact('transactions'));
    }
    /**
     * Show the form for creating a new resource.
     * (Tidak digunakan dalam konteks ini)
     */
    public function create()
    {
        // Tidak ada form pembuatan manual, karena transaksi terjadi dari keranjang.
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     * Membuat transaksi dari item keranjang.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'no_telp' => 'string|nullable',
        ]);

        $cart = Cart::with('product')->where('user_id', Auth::id())->findOrFail($request->cart_id);

        // Cari data member berdasarkan user_id
        $member = Member::where('user_id', auth()->id())->first();

        // Hitung total harga tanpa diskon
        $totalHarga = $cart->product->price * $cart->quantity;

        // Cek apakah member ada
        if (!$member) {
            return redirect()->route('cart.index')->with('error', 'Anda belum terdaftar sebagai member.');
        }

        // AKTIFKAN MEMBER JIKA TIDAK AKTIF DAN TOTAL BELANJA >= 100.000
        if ($member->status === 'inactive' && $totalHarga >= 100000) {
            $member->status = 'active';
            $member->save();
        }

        // Cek ulang status member setelah kemungkinan diaktifkan
        if ($member->status !== 'active') {
            return redirect()->route('cart.index')
                ->with('error', 'Mohon maaf, diskon kadaluarsa. Akun Anda tidak aktif sebagai member.');
        }

        // Ambil diskon dari member, jika ada
        $discount = $member->discount_percentage ?? 0;

        // Hitung total harga dengan diskon
        $finalPrice = $totalHarga - ($totalHarga * $discount / 100);

        // Simpan transaksi
        Transaction::create([
            'user_id' => auth()->id(),
            'product_id' => $cart->product_id,
            'quantity' => $cart->quantity,
            'total_price' => $finalPrice,
        ]);

        // Hapus item dari keranjang
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dibeli!');
    }
    /**
     * Display the specified resource.
     * Menampilkan detail transaksi tertentu.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with('product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     * (Tidak digunakan, transaksi tidak bisa diedit)
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     * (Tidak digunakan, transaksi tidak bisa diubah)
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     * (Opsional: Menghapus transaksi dari riwayat)
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        $transaction->delete();

        return redirect()->route('transaction.index')->with('success', 'Transaksi berhasil dihapus');
    }

    // export to exel
    public function export()
    {
        return Excel::download(new TransactionExport(), 'transaksi.xlsx');
    }

    // export to pdf
    public function exportPdf()
    {
        $transactions = Transaction::with('product.category')->get();

        $pdf = Pdf::loadView('transaction.pdf', compact('transactions'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('transaksi.pdf');
    }
    public function showInvoice(Request $request, $ids)
    {
        $idsArray = explode(',', $ids);

        $transactions = Transaction::with(['product.category', 'member'])
            ->whereIn('id', $idsArray)
            ->get();

        if ($transactions->isEmpty()) {
            abort(404, 'Transaksi tidak ditemukan.');
        }

        $grandTotal = $transactions->sum('total_price');

        // Ambil dari transaksi pertama
        $firstTransaction = $transactions->first();
        $paidAmount = $firstTransaction->paid_amount ?? 0;
        $change = $firstTransaction->change ?? 0;

        return view('transaction.invoice', compact('transactions', 'grandTotal', 'paidAmount', 'change'));
    }

    public function downloadInvoicePdf($ids)
    {
        $idsArray = explode(',', $ids);

        $transactions = Transaction::with('product.category')
            ->where('user_id', auth()->id())
            ->whereIn('id', $idsArray)
            ->get();

        if ($transactions->isEmpty()) {
            abort(404, 'Transaksi tidak ditemukan.');
        }

        // Hitung subtotal tanpa diskon (harga produk * quantity)
        $subtotal = 0;
        foreach ($transactions as $trx) {
            $subtotal += $trx->product->price * $trx->quantity;
        }

        // Ambil member name dari transaksi pertama jika ada
        $memberName = optional($transactions->first()->member)->name ?? null;
        $memberPhone = optional($transactions->first()->member)->no_telp ?? null;

        // Ambil paid_amount dan change dari transaksi pertama (asumsi sama untuk semua)
        $paidAmount = $transactions->first()->paid_amount ?? 0;
        $change = $transactions->first()->change ?? 0;

        // Hitung total bayar (subtotal - diskon total)
        $totalBayar = $subtotal - ($subtotal - $transactions->sum('total_price'));

        // Atau lebih mudah, langsung total_price
        $totalBayar = $transactions->sum('total_price');

        $grandTotal = $totalBayar; // biar konsisten

        $pdf = Pdf::loadView('transaction.invoice-pdf', compact(
            'transactions',
            'grandTotal',
            'subtotal',
            'change',
            'totalBayar',
            'paidAmount',
            'memberName',
            'memberPhone'
        ));

        return $pdf->download('struk-pembelian.pdf');
    }

    public function sendWhatsappMessage(Request $request)
    {
        // Validasi input untuk memastikan target dan pesan ada dan valid
        $request->validate([
            'no_telp'    => 'required|string',
            'ids'        => 'required|string',
        ]);

        // Ambil target dan pesan dari body request
        $target         = $request->input('no_telp');

        $idsArray = explode(',', $request->input('ids'));
        $transactions = \App\Models\Transaction::with('product')->whereIn('id', $idsArray)->get();

        if ($transactions->isEmpty()) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $grandTotal = $transactions->sum('total_price');
        $paidAmount = $transactions->first()->paid_amount ?? 0;

        // Bangun pesan WhatsApp
        $message = "```\n";
        $message .= "Kasir .Mii\n";
        $message .= "Jl. Ky Tinggi Rt 009 Rw 03, No.17\n";
        $message .= "Telp: 0812-3456-7890\n";
        $message .= str_repeat('-', 47) . "\n";
        $message .= "Tanggal       : " . now()->format('d-m-Y H:i') . "\n";
        $message .= "No. Transaksi : #" . $transactions[0]->id . "\n";
        $message .= str_repeat('-', 47) . "\n";

        foreach ($transactions as $trx) {
            $namaProduk = $trx->product->name ?? '-';
            $qty = $trx->quantity . ' ' . ($trx->product->stock_unit ?? 'pcs');
            $harga = number_format($trx->product->price ?? 0, 0, ',', '.');
            $subtotal = number_format($trx->total_price, 0, ',', '.');
            $message .= "{$namaProduk}\n";
            $message .= "{$qty} x Rp{$harga} = Rp{$subtotal}\n";
        }

        $message .= str_repeat('-', 47) . "\n";

        $memberPhone = optional($transactions->first()->member)->no_telp ?? '-';
        $message .= "Nomor   : {$memberPhone}\n";
        $memberName = optional($transactions->first()->member)->name ?? '-';
        $message .= "Member     : {$memberName}\n";
        $message .= "Uang Bayar : Rp" . number_format($paidAmount, 0, ',', '.') . "\n";
        $message .= "SubTOTAL: Rp" . number_format($grandTotal, 0, ',', '.') . "\n";
        $change = $transactions->first()->change ?? 0;
        $message .= "Kembalian  : Rp" . number_format($change, 0, ',', '.') . "\n";
        $message .= str_repeat('-', 47) . "\n";
        $message .= "Terima kasih atas kunjungan Anda!\n";
        $message .= "Barang yang sudah dibeli tidak dapat dikembalikan.\n";
        $message .= '```';

        // Kirim pesan menggunakan FonnteService
        $response = $this->fonnteService->sendWhatsAppMessage($target, $message);

        // Periksa apakah API Fonnte mengembalikan status false
        if (!$response['status'] || (isset($response['data']['status']) && !$response['data']['status'])) {
            // Jika terjadi error atau status false, kembalikan pesan error
            $errorReason = $response['data']['reason'] ?? 'Unknown error occurred';
            return response()->json(['message' => 'Error', 'error' => $errorReason], 500);
        }

        // Jika berhasil, kembalikan pesan sukses
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Pesan berhasil dikirim!',
        //     'data' => $response['data']
        // ]);
        return back()->with('success', 'Data behasil dikirim ke WhatsApp!');
    }

    public function destroyAll()
    {
        \App\Models\Transaction::truncate(); // hapus semua data transaksi
        return redirect()->route('transaction.index')->with('success', 'Semua transaksi berhasil dihapus.');
    }

    public function downloadPdf(Request $request)
    {
        $date = $request->input('date');
        $transactions = Transaction::with(['product.category'])
            ->when($date, function ($query) use ($date) {
                $query->whereDate('created_at', $date);
            })
            ->get();

        $pdf = Pdf::loadView('transaction.laporan', compact('transactions', 'date'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-transaksi.pdf');
    }
}
