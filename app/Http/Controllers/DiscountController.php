<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;  // Import Carbon di atas

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua diskon untuk cek status kadaluarsa
        $discounts = Discount::all();  // Ubah $allDiscounts menjadi $discounts
        $today = now()->format('Y-m-d');

        // Update status diskon jika kadaluarsa
        foreach ($discounts as $discount) {
            $status = $discount->valid_until && Carbon::parse($discount->valid_until)->isPast()
                ? 'KADALUARSA'
                : 'MASIH BERLAKU';

            // Update status otomatis pada objek diskon dan simpan
            $discount->status_otomatis = $status;
            $discount->save();
        }

        // Ambil data diskon setelah status diperbarui
        $query = Discount::query();

        // Jika ada pencarian
        if (request()->has('search') && request()->search != '') {
            $query->where('name', 'like', '%' . request()->search . '%')
                  ->orWhere('discount_percentage', 'like', '%' . request()->search . '%');
        }

        // Urutkan diskon yang aktif di atas, lalu berdasarkan tanggal kadaluarsa
        $query->orderByRaw("CASE WHEN status_otomatis = 'MASIH BERLAKU' THEN 0 ELSE 1 END")
              ->orderBy('valid_until', 'asc');

        // Ambil diskon yang sudah terurut
        $discounts = $query->get();

        return view('discount.daftar', ['title' => 'Kelola Diskon', 'discounts' => $discounts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('discount.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'valid_from' => 'required|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            // 'status' => 'required|string|in:AKTIF,TIDAK AKTIF',
        ]);

        Discount::create($validated); // Menyimpan data diskon baru

        return redirect()->route('discount.index')->with('success', 'Diskon berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $discount = Discount::findOrFail($id);

        $title = 'Edit Diskon';
        return view('discount.edit', compact('discount', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'valid_from' => 'required|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            // 'status' => 'required|in:AKTIF,TIDAK AKTIF',
        ]);

        // Temukan data diskon berdasarkan ID
        $discount = Discount::findOrFail($id);

        // Update data diskon dengan data yang sudah tervalidasi
        $discount->update($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('discount.index')->with('success', 'Diskon berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        // Menghapus diskon
        $discount->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('discount.index')->with('success', 'Diskon berhasil dihapus');
    }
}
