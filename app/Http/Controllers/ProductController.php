<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $query = Product::query()->with('category');

        if (request()->has('search') && request()->search != '') {
            $search = request()->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $products = $query->orderByRaw('stock = 0, stock DESC')->get();

        session()->forget('cart_start_time');

        return view('product.daftar', [
            'title' => 'Daftar Produk',
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.add', [
            'title' => 'TAMBAH PRODUK',
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|digits:13|unique:products,code',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'stock_unit' => 'required|in:pcs,pack,dus,kg,porsi,kaleng',
            'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'required|exists:categories,id',
        ], [
            'code.required' => 'Kode produk wajib diisi.',
            'code.digits' => 'Kode produk harus terdiri dari 13 digit.',
            'code.unique' => 'Kode produk sudah digunakan.',
        ]);

        $extension = $request->file('img')->extension();
        $imgName = Str::slug($validatedData['name']) . '.' . $extension;
        $path = Storage::putFileAs('public/product', $request->file('img'), $imgName);

        $validatedData['img'] = $path;

        // dd($validatedData);

        Product::create($validatedData);
        return redirect()->route('product.index')->with('success', 'Product berhasil ditambahkan ke keranjang');
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
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('product.edit', [
            'title' => 'UBAH PRODUK',
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:13|alpha_num|unique:products,code,' . $product->id,
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'stock_unit' => 'required|in:pcs,pack,dus,kg,porsi,kaleng',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'required|exists:categories,id',
        ], [
            'code.required' => 'Kode produk wajib diisi.',
            'code.digits' => 'Kode produk harus terdiri dari 13 digit.',
            'code.numeric' => 'Kode produk harus berupa angka.',
        ]);

        // dd($validatedData);

        // Jika ada file gambar baru diunggah
        if ($request->hasFile('img')) {
            // Hapus gambar lama jika ada
            if ($product->img) {
                Storage::delete($product->img);
            }

            // Simpan gambar baru
            $extension = $request->file('img')->extension();
            $imgName = time() . $validatedData['name'] . '.' . $extension;
            $path = Storage::putFileAs('public/product', $request->file('img'), $imgName);
            $validatedData['img'] = $path;
        } else {
            // Jika tidak ada gambar baru, gunakan gambar lama
            $validatedData['img'] = $product->img;
        }

        // dd($validatedData);

        $product->update($validatedData);

        return redirect()->route('product.index')->with('success', 'Produk berhasil di perbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully added');
    }
}
