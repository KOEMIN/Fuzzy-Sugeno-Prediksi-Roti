<form action="{{ route('products.update',$product->id) }}" method="POST">
    @csrf
    @method('PUT') <div class="mb-3">
        <label for="name" class="form-label"><strong>Nama:</strong></label>
        <input type="text" name="name" value="{{ $product->name }}" class="form-control" placeholder="Nama Produk">
    </div>
    <div class="mb-3">
        <label for="price" class="form-label"><strong>Harga:</strong></label>
        <input type="number" name="price" value="{{ $product->price }}" class="form-control" placeholder="Harga">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label"><strong>Deskripsi:</strong></label>
        <textarea class="form-control" style="height:150px" name="description" placeholder="Deskripsi">{{ $product->description }}</textarea>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Ubah</button>
    </div>
</form>