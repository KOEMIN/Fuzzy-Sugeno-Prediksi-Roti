<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Tambah Produk Baru</h2>
    <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label"><strong>Nama:</strong></label>
            <input type="text" name="name" class="form-control" placeholder="Nama Produk">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label"><strong>Harga:</strong></label>
            <input type="number" name="price" class="form-control" placeholder="Harga">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label"><strong>Deskripsi:</strong></label>
            <textarea class="form-control" style="height:150px" name="description" placeholder="Deskripsi"></textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
</div>
</body>
</html>