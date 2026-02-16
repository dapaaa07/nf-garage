@include('layouts.header', ['title' => $title ?? 'lainnya Engine Parts | NF GARAGE'])

@include('layouts.sidebar')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-sm-6 d-flex align-items-center">
                <a href="{{ route('stok') }}">Stok</a> /
                <h1 class="m-0 ms-2">Sparepart Lainnya</h1>
            </div>
            <div class="row mt-2 mb-1">
                <div class="col-sm-6 text-end">
                    <a href="{{ route('lainnya.create') }}" class="btn btn-primary">
                        + Add Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content" style="background-color: #eee;">
        <div class="container-fluid">
            <div class="container py-5">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
                    @foreach ($lainnya as $product)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ asset('assets/foto/' . $product->foto) }}" class="card-img-top" alt="{{ $product->name }}" />
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">{{ $product->nama }}</h5>
                                    <h5 class="text-dark mb-0">IDR {{ number_format($product->harga, 0, ',', '.') }}</h5>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <p class="mb-0 text-muted"><small>Harga Beli</small></p>
                                    <p class="mb-0 text-muted"><small>IDR {{ number_format($product->harga_beli, 0, ',', '.') }}</small></p>
                                </div>
                                <p class="text-muted mb-2">Available: <span class="fw-bold">{{ $product->stok }}</span></p>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('lainnya.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('lainnya.destroy', $product->id) }}" method="POST" id="delete-form-{{ $product->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $product->id }}')">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>

@include('layouts.footer')