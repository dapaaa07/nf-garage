@include('layouts.header', ['title' => $title ?? 'Rem | NF GARAGE'])

@include('layouts.sidebar')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-sm-6 d-flex align-items-center">
                <a href="{{ route('stok') }}">Stok</a> /
                <a href="{{ route('rem') }}">Kampas Rem</a> /
                <h1 class="m-0 ms-2">Add Product</h1>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content" style="background-color: #eee;">
        <div class="container-fluid">
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="m-0">Add New Rem Product</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('rem.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="nama" name="nama" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="harga" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="harga" name="harga" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="harga_beli" class="form-label">Harga Beli</label>
                                        <input type="number" class="form-control" id="harga_beli" name="harga_beli" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stok" class="form-label">Stock</label>
                                        <input type="number" class="form-control" id="stok" name="stok" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto" class="form-label">Product Image</label>
                                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Product</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('layouts.footer')