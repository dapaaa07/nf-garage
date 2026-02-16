@include('layouts.header', ['title' => $title ?? 'Internal Engine Parts | NF GARAGE'])

@include('layouts.sidebar')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-sm-6 d-flex align-items-center">
                <a href="{{ route('stok') }}">Stok</a> /
                <h1 class="m-0 ms-2">Internal Engine Parts</h1>
            </div>
            <div class="row mt-2 mb-1">
                <div class="col-sm-6 text-end">
                    <a href="{{ route('internal.create') }}" class="btn btn-primary">
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
                    @foreach ($internal as $product)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ asset('assets/foto/' . $product->foto) }}" class="card-img-top" alt="{{ $product->name }}" />
                            <div class="card-body d-flex flex-column">
                                <div class="flex-grow-1">
                                    {{-- PERBAIKAN DIMULAI DI SINI --}}
                                    <!-- Baris 1: Nama Produk dan Harga Jual -->
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mb-0">{{ $product->nama }}</h5>
                                        <h5 class="text-dark mb-0">IDR {{ number_format($product->harga, 0, ',', '.') }}</h5>
                                    </div>

                                    <!-- Baris 2: Label Harga Beli dan Harga Beli -->
                                    <div class="d-flex justify-content-between mt-1">
                                        <p class="mb-0 text-muted"><small>Harga Beli</small></p>
                                        <p class="mb-0 text-muted"><small>IDR {{ number_format($product->harga_beli, 0, ',', '.') }}</small></p>
                                    </div>

                                    <!-- Baris 3: Stok -->
                                    <p class="text-muted mt-3 mb-3">Available: <span class="fw-bold">{{ $product->stok }}</span></p>
                                    {{-- PERBAIKAN SELESAI --}}
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('internal.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('internal.destroy', $product->id) }}" method="POST" id="delete-form-{{ $product->id }}">
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
