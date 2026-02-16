@include('layouts.header', ['title' => 'Tambah Pengeluaran Lainnya'])

@include('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- Judul Halaman --}}
                    <h1 class="m-0">Pengeluaran Lainnya</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Pengeluaran</li>
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
                    {{-- Card untuk membungkus form --}}
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Formulir Tambah Pengeluaran</h3>
                        </div>
                        <!-- /.card-header -->

                        {{-- Form Mulai --}}
                        <form action="{{ route('pengeluaran.store') }}" method="POST">
                            @csrf {{-- Token keamanan Laravel, wajib ada --}}

                            <div class="card-body">
                                {{-- Input untuk Nama Barang --}}
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                                        id="nama_barang" name="nama_barang"
                                        placeholder="Contoh: Pembelian Air Galon, Servis AC"
                                        value="{{ old('nama_barang') }}" required>
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
                                        value="{{ old('kuantitas') }}" required min="1">
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
                                        value="{{ old('harga_per_barang') }}" required min="0">
                                    @error('harga_per_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan Pengeluaran</button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
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