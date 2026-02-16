@include('layouts.header', ['title' => $title ?? 'Stok | NF Garage'])

@include('layouts.sidebar')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Stok Barang</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalOli }}</h3> <!-- Menampilkan jumlah total data oli -->
                            <p>Oli</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-droplet-fill"></i>
                        </div>
                        <a href="{{ route('oli') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalRem }}<sup style="font-size: 20px"></sup></h3>

                            <p>Kampas Rem</p>
                        </div>
                        <div class="icon">
                            <i class="bi bi-gear"></i>
                        </div>
                        <a href="{{ route('rem') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalInternal }}</h3>

                            <p>Internal Engine Parts</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cogs"></i>
                        </div>
                        <a href="{{ route('internal') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalLainnya }}</h3>

                            <p>Sparepart Lainnya</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('lainnya') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>
    </section>
    <!-- /.content-wrapper -->
</div>
</div>
<!-- ./wrapper -->

@include('layouts.footer')