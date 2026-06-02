<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Product;

    class ProductController extends Controller
    {
    public function index()
    {
        // Mengambil semua data produk dari database
        $products = Product::latest()->paginate(5);

        // Mengembalikan view 'index' dengan data produk
        return view('products.index', compact('products'));
    }
    public function create()
    {
        // Cukup kembalikan view untuk form tambah
        return view('products.create');
    }
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        // Buat produk baru menggunakan data dari request
        Product::create($request->all());

        // Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil ditambahkan.');
    }
    public function edit(Product $product)
    {
        // Kembalikan view 'edit' dengan data produk yang akan diubah
        return view('products.edit', compact('product'));
    }
    public function update(Request $request, Product $product)
    {
        // Validasi input form
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        // Update data produk
        $product->update($request->all());

        // Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil diperbarui.');
    }
    public function destroy(Product $product)
    {
        // Hapus produk
        $product->delete();

        // Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil dihapus.');
    }
    public function show(Product $product)
{
    // Fungsi ini akan menerima satu produk (sesuai ID di URL)
    // lalu mengirimkannya ke view bernama 'products.show'
    return view('products.show', compact('product'));
}
    }
        

