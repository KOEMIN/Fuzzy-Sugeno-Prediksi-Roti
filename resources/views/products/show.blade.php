<!DOCTYPE html>
<html>
<head>
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <h2>Detail Produk</h2>
            <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">Kembali ke Daftar Produk</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <strong>Nama Produk:</strong>
                <p>{{ $product->name }}</p>
            </div>
            <div class="mb-3">
                <strong>Harga:</strong>
                {{-- Format harga agar mudah dibaca --}}
                <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
            <div class="mb-3">
                <strong>Deskripsi:</strong>
                <p>{{ $product->description }}</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>