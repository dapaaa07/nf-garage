@include('layouts.header', ['title' => 'Detail Booking'])
@include('layouts.sidebar')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <a href="{{ route('admin.booking') }}">Bookings</a> /
                    <h1 class="m-0 ms-2 d-inline-block">Detail Booking: {{ $booking->booking_code }}</h1>
                </div>
                <a href="{{ route('admin.booking') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Informasi Detail</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Kode Booking</dt>
                                <dd class="col-sm-8">: {{ $booking->booking_code }}</dd>

                                <dt class="col-sm-4">Nama Pelanggan</dt>
                                <dd class="col-sm-8">: {{ $booking->user->name }}</dd>

                                <dt class="col-sm-4">Email</dt>
                                <dd class="col-sm-8">: {{ $booking->user->email }}</dd>

                                <dt class="col-sm-4">Tanggal Dibuat</dt>
                                <dd class="col-sm-8">: {{ $booking->created_at->translatedFormat('l, d F Y H:i') }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">Jadwal Service</dt>
                                <dd class="col-sm-8">: {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l, d F Y') }}</dd>

                                <dt class="col-sm-4">Kendaraan</dt>
                                <dd class="col-sm-8">: {{ $booking->vehicle_description }}</dd>

                                <dt class="col-sm-4">Status Saat Ini</dt>
                                <dd class="col-sm-8">:
                                    @if($booking->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                    @else
                                    <span class="badge bg-success">Terkonfirmasi</span>
                                    @endif
                                    {{-- Tambahkan status lain jika perlu --}}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    {{-- Tampilkan tombol aksi HANYA jika status masih 'pending' --}}
                    @if ($booking->status == 'pending')
                    <!-- Form untuk Tombol Konfirmasi -->
                    <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Konfirmasi Booking
                        </button>
                    </form>

                    <!-- Form untuk Tombol Batalkan -->
                    <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')">
                            <i class="fas fa-times"></i> Batalkan Booking
                        </button>
                    </form>
                    @else
                    <p class="text-muted">Aksi tidak tersedia untuk booking dengan status '{{ $booking->status }}'.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

@include('layouts.footer')