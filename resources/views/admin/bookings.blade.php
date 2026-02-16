@include('layouts.header', ['title' => $title ?? 'Internal Engine Parts | NF GARAGE'])

@include('layouts.sidebar')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-sm-6 d-flex align-items-center">
                <a href="{{ route('dashboard') }}">Dashboard</a> /
                <h1 class="m-0 ms-2">Bookings</h1>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid py-4">

            {{-- Menampilkan pesan sukses jika ada --}}
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

                {{-- Loop untuk setiap data booking --}}
                @forelse ($bookings as $booking)
                <div class="col">
                    {{-- Setiap kartu adalah link ke halaman detail --}}
                    <a href="{{ route('bookings.show', $booking->id) }}" class="card-link">
                        <div class="card h-100 shadow-sm booking-card">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary">{{ $booking->booking_code }}</h5>
                                <p class="card-text mb-2">
                                    <i class="fas fa-user me-2"></i>{{ $booking->user->name }}
                                </p>
                                <p class="card-text text-muted mb-3">
                                    <i class="fas fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}
                                </p>
                            </div>
                            <div class="card-footer bg-light border-0">
                                @if($booking->status == 'pending')
                                <span class="badge bg-warning text-dark w-100">Menunggu Konfirmasi</span>
                                @elseif($booking->status == 'confirmed')
                                <span class="badge bg-success w-100">Terkonfirmasi</span>
                                @elseif($booking->status == 'completed')
                                <span class="badge bg-primary w-100">Selesai</span>
                                @elseif($booking->status == 'cancelled')
                                <span class="badge bg-danger w-100">Dibatalkan</span>
                                @else
                                <span class="badge bg-secondary w-100">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                {{-- Pesan jika tidak ada data booking --}}
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Tidak ada data booking yang ditemukan.
                    </div>
                </div>
                @endforelse

            </div>

            {{-- Link Paginasi --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $bookings->links() }}
            </div>

        </div>
    </section>
</div>

{{-- Style tambahan agar kartu terlihat bagus saat diklik --}}
<style>
    .card-link {
        text-decoration: none;
        color: inherit;
    }

    .booking-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
    }
</style>

@include('layouts.footer')
</div>

@include('layouts.footer')