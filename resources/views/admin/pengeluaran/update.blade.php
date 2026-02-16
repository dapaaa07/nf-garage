@include('layouts.header', ['title' => 'Update Pengeluaran'])

@include('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Update Data Pengeluaran</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pengeluaran.index') }}">Pengeluaran</a></li>
                        <li class="breadcrumb-item active">Update</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Formulir Update Pengeluaran</h3>
                        </div>
                        <!-- /.card-header -->

                        {{-- Form Mulai --}}
                        <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST">
                            @csrf
                            @method('PUT') {{-- Method spoofing untuk request UPDATE --}}

                            <div class="card-body">
                                {{-- Input untuk Nama Barang --}}
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                                        id="nama_barang" name="nama_barang"
                                        placeholder="Contoh: Pembelian Air Galon, Servis AC"
                                        value="{{ old('nama_barang', $pengeluaran->nama_barang) }}" required>
                                    @error('nama_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Input untuk Kuantitas --}}
                                <div class="form-group">
                                    <label for="kuantitas">Kuantitas</label>
                                    <input type="number" class="form-control @error('kuantitas') is-invalid @enderror"
                                        id="kuantitas" name="kuantitas"
                                        placeholder="Contoh: 1"
                                        value="{{ old('kuantitas', $pengeluaran->kuantitas) }}" required min="1">
                                    @error('kuantitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Input untuk Harga Per Barang --}}
                                <div class="form-group">
                                    <label for="harga_per_barang">Harga Per Barang (Rp)</label>
                                    <input type="number" class="form-control @error('harga_per_barang') is-invalid @enderror"
                                        id="harga_per_barang" name="harga_per_barang"
                                        placeholder="Contoh: 50000 (tanpa titik atau koma)"
                                        value="{{ old('harga_per_barang', $pengeluaran->harga_per_barang) }}" required min="0">
                                    @error('harga_per_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">Update Pengeluaran</button>
                                <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                        {{-- Form Selesai --}}
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('layouts.footer')