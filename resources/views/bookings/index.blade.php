<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking Saya - NF Garage</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .booking-card {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
        }

        .booking-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }

        .badge {
            font-size: 0.9em;
        }
    </style>
</head>

<body>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-10 mx-auto">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="bi bi-journal-text"></i> Riwayat Booking Anda</h2>
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Homepage
                    </a>
                </div>

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @forelse ($bookings as $booking)
                <div class="card booking-card mb-3">
                    <div class="card-header bg-light d-flex justify-content-between">
                        <strong>Kode Booking: {{ $booking->booking_code }}</strong>
                        <small class="text-muted">Dibuat pada: {{ $booking->created_at->format('d M Y, H:i') }}</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1"><strong><i class="bi bi-calendar-event"></i> Jadwal Service:</strong></p>
                                <p>{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('l, d F Y') }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong><i class="bi bi-bicycle"></i> Kendaraan:</strong></p>
                                <p>{{ $booking->vehicle_description }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong><i class="bi bi-hourglass-split"></i> Status:</strong></p>
                                <p>
                                    @if($booking->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                    @elseif($booking->status == 'confirmed')
                                    <span class="badge bg-success">Terkonfirmasi</span>
                                    @elseif($booking->status == 'completed')
                                    <span class="badge bg-primary">Selesai</span>
                                    @elseif($booking->status == 'cancelled')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                    @else
                                    <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-info text-center">
                    <h4 class="alert-heading">Belum Ada Riwayat</h4>
                    <p>Anda belum pernah membuat booking. Silakan buat booking baru dari halaman utama.</p>
                </div>
                @endforelse

                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>