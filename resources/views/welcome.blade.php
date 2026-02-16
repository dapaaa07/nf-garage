<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>NF Garage</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/foto/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/template/assets/logo.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/template/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/template/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <!-- Tambahkan ini di dalam <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/template/assets/css/main.css') }}" rel="stylesheet">

    <style>
        #hero {
            position: relative;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
        }

        /* Gambar */
        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Supaya gambar tidak terdistorsi */
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            /* Gambar di bawah overlay */
        }

        /* Overlay */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.86);
            /* Overlay gelap */
            z-index: 2;
            /* Overlay di atas gambar */
        }

        /* Teks */
        #hero .container {
            margin-top: 50px;
            position: relative;
            z-index: 3;
            /* Teks di atas overlay */
            color: white;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            /* Transparan hitam */
        }

        .carousel-control-prev,
        .carousel-control-next {
            filter: grayscale(100%);
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            /* Membuat tombol lebih minimis */
        }

        /* pesan section */
        /*--------------------------------------------------------------
# Booking Section - Revamped as a Card/Form
--------------------------------------------------------------*/
        .booking {
            min-height: 80vh;
            /* Memastikan section cukup tinggi untuk memusatkan card */
            background-color: #f8f9fa;
            /* Latar belakang polos putih/abu-abu muda */
            padding: 80px 0;
        }

        .booking .booking-card {
            background: #fff;
            /* Latar belakang card putih */
            border: none;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
            /* Sedikit bayangan untuk menonjolkan card */
            transition: all 0.3s ease-in-out;
        }

        .booking .booking-card:hover {
            transform: translateY(-5px);
            /* Efek sedikit naik saat hover */
        }

        .booking .booking-card .card-img-top-container {
            max-width: 80%;
            /* Batasi lebar gambar dalam card */
            margin: 0 auto 20px auto;
            /* Pusatkan gambar secara horizontal dan beri margin bawah */
            overflow: hidden;
            /* Pastikan gambar tidak keluar dari container */
        }

        .booking .booking-card .img-fluid {
            width: 100%;
            height: auto;
            object-fit: cover;
            max-height: 250px;
            /* Batasi tinggi gambar */
        }

        .booking .booking-card .card-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--color-secondary);
            margin-bottom: 15px;
        }

        .booking .booking-card .card-text {
            font-size: 16px;
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .booking .btn-booking {
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 18px;
            letter-spacing: 1px;
            display: inline-block;
            padding: 14px 40px;
            border-radius: 50px;
            transition: 0.5s;
            margin: 10px 0;
            color: #fff;
            background: #008374;
            /* Warna utama dari template Anda */
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .booking .btn-booking:hover {
            background: #009688;
            /* Sedikit lebih terang saat hover */
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .booking .booking-card {
                padding: 30px;
            }

            .booking .booking-card .card-title {
                font-size: 24px;
            }

            .booking .booking-card .card-text {
                font-size: 15px;
            }

            .booking .btn-booking {
                padding: 12px 30px;
                font-size: 16px;
            }
        }

        .btn-booking-secondary {
            font-family: var(--font-primary);
            font-weight: 600;
            font-size: 18px;
            letter-spacing: 1px;
            display: inline-block;
            padding: 14px 40px;
            border-radius: 50px;
            transition: 0.5s;
            margin: 10px 0;
            color: #008374;
            /* Warna teks hijau */
            background: #fff;
            /* Latar belakang putih */
            border: 2px solid #008374;
            /* Garis tepi hijau */
            text-decoration: none;
        }

        .btn-booking-secondary:hover {
            color: #fff;
            /* Teks jadi putih saat hover */
            background: #008374;
            /* Latar belakang jadi hijau saat hover */
        }

        .navbar .btn-login {
            background: #008374;
            /* Warna hijau utama */
            color: #fff;
            padding: 8px 25px;
            border-radius: 50px;
            margin-left: 15px;
        }

        .navbar .btn-login:hover {
            background: #009688;
            /* Warna hijau lebih terang saat hover */
            color: #fff;
        }
    </style>


</head>

<body>
    <header id="header" class="header d-flex align-items-center">

        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <a href="{{ route('login') }}" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 style="font-family: 'raleway', sans-serif; font-weight: normal;"><img src="{{ asset('assets/foto/logo.png') }}" alt=""> NF Garage<span></span></h1>
            </a>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#portfolio">Products</a></li>
                    <li><a href="#contact">Contact</a></li>

                    {{-- Spasi pemisah --}}
                    <li class="d-none d-lg-block" style="width: 30px;"></li>

                    {{-- JIKA PENGGUNA BELUM LOGIN (GUEST) --}}
                    @guest
                    <li><a class="btn-login" href="{{ route('login') }}">Login</a></li>
                    @endguest

                    {{-- JIKA PENGGUNA SUDAH LOGIN (AUTHENTICATED) --}}
                    @auth
                    <li class="dropdown"><a href="#"><span>Welcome, {{ Auth::user()->name }}</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                            <li><a href="{{ route('bookings.index') }}">Booking Saya</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                        Logout
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endauth
                </ul>
            </nav>

            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

        </div>
    </header><!-- End Header -->
    <!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero">
        <div class="overlay"></div> <!-- Overlay -->
        <img src="{{ asset('assets/foto/depan.jpeg') }}" class="hero-image" alt="Hero Image">

        <div class="container position-relative">
            <div class="row gy-5" data-aos="fade-in">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
                    <h2>Welcome to <span>Our Workshop</span></h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti soluta, ratione nulla necessitatibus voluptatem accusamus cupiditate? Error praesentium voluptatum natus.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- End Hero Section -->

    <!-- Pesan section -->
    <section id="booking" class="booking sections-bg d-flex align-items-center justify-content-center">
        <div class="container" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-9">
                    <div class="booking-card card p-4 p-md-5 shadow-lg rounded-4 text-center">
                        <div class="card-img-top-container mb-4">
                            <img src="{{ asset('assets/foto/booking.png') }}" class="img-fluid rounded-4" alt="Booking Service Motor">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title mb-3">Siap Merawat Kendaraan Anda?</h3>
                            <p class="card-text mb-4">
                                Jangan tunda lagi perawatan motor Anda. Jadwalkan servis Anda dengan kami sekarang juga untuk memastikan performa terbaik dan keamanan berkendara.
                            </p>
                            <a href="#" class="btn-booking" data-bs-toggle="modal" data-bs-target="#bookingModal">
                                Booking Sekarang!
                            </a>
                            @auth
                            <a href="{{ route('bookings.index') }}" class="btn-booking-secondary">
                                Cek Booking Saya
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End pesan section -->

    <main id="main">

        <!-- ======= About Us Section ======= -->
        <section id="about" class="about mt-4">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>About Us</h2>
                </div>

                <div class="row gy-4">
                    <div class="col-lg-5">
                        <div id="carouselExampleAutoplay" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                            <div class="carousel-inner">
                                <!-- Gambar pertama -->
                                <div class="carousel-item active">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('assets/foto/mesin.jpeg') }}" class="d-block rounded-4 mb-4" style="max-width: 70%;" alt="Foto 1">
                                    </div>
                                </div>
                                <!-- Gambar kedua -->
                                <div class="carousel-item">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('assets/foto/mesin5.jpeg') }}" class="d-block rounded-4 mb-4" style="max-width: 70%;" alt="Foto 2">
                                    </div>
                                </div>
                                <!-- Gambar ketiga -->
                                <div class="carousel-item">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('assets/foto/mesin23.jpeg') }}" class="d-block rounded-4 mb-4" style="max-width: 70%;" alt="Foto 3">
                                    </div>
                                </div>
                            </div>
                            <!-- Tombol navigasi kiri -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplay" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <!-- Tombol navigasi kanan -->
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplay" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <!-- <img class="img-fluid rounded-4 mb-4" alt="IT Project" src="https://source.unsplash.com/random/?IT project"> -->
                    </div>
                    <div class="col-lg-6">
                        <div class="content ps-0 ps-lg-5">
                            <ul>
                                <li><i class="bi bi-check-circle-fill"></i> Layanan Berkualitas Tinggi.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Keahlian dan Pengalaman.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Layanan Cepat dan Efisien.</li>
                                <li><i class="bi bi-check-circle-fill"></i> Harga Terjangkau dan Transparan.</li>

                            </ul>
                            <p>
                                &nbsp;&nbsp;&nbsp; Bengkel kami berlokasi di Perumahan Puri Kosambi, Kecamatan Klari, Kabupaten Karawang, dan hadir sebagai solusi tepat bagi Anda yang membutuhkan perawatan kendaraan berkualitas di lingkungan yang nyaman dan terpercaya. Kami berkomitmen untuk memberikan layanan terbaik dan memastikan kendaraan Anda kembali berfungsi dengan optimal. Dengan layanan yang kami tawarkan, Anda tidak perlu khawatir soal kualitas atau biaya. Percayakan kendaraan Anda kepada kami, dan kami akan pastikan Anda merasa puas dengan hasilnya.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End About Us Section -->

        <!-- ======= Clients Section ======= -->


        <!-- ======= Our Services Section ======= -->
        <section id="services" class="services sections-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>Our Services</h2>
                    <p>
                        Kami menyediakan layanan perawatan sepeda motor anda seperti :
                    </p>
                </div>

                <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">

                    <div class="col-lg-4 col-md-6">
                        <div class="service-item  position-relative">
                            <div class="icon">
                                <i class="fas fa-wrench"></i>
                            </div>
                            <h3>Tune Up</h3>
                            <p>Tune Up pada kendaraan adalah proses perawatan berkala untuk memastikan mesin bekerja optimal. Tune up biasanya mencakup pembersihan atau penggantian busi, filter udara, filter bahan bakar, penyetelan klep, pengecekan sistem pengapian, serta pemeriksaan komponen lain seperti aki dan sensor mesin.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <h3>Bore Up</h3>
                            <p> Bore up merupakan perubahan spek mesin dengan cara memperbesar diameter piston untuk meningkatkan peforma kendaraan. Kami juga menerima bore up untuk segala sepeda motor</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="fas fa-oil-can"></i>
                            </div>
                            <h3>Servis Rutin</h3>
                            <p> Demi menjaga peforma mesin kendaraan, wajib hukumnya kita untuk selalu merawat kendaraan dimulai dari yang paling sederhana yaitu mengganti oli secara rutin lalu melakukan pembersihan pada filter udara dan lainnya..</p>
                        </div>
                    </div><!-- End Service Item -->
                </div>

            </div>
        </section><!-- End Our Services Section -->


        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio sections-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>Products</h2>
                    <p>Kami memiliki stok produk kurang lebih {{ $TotalStok }} barang.</p>
                </div>

                <div class="container">
                    <div class="row gy-3">
                        @foreach ($data as $item)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <a href="{{ route('detail.product') }}">
                            <div class="card h-100 shadow-sm">
                                <div class="card-img-top-container" style="height: 200px; overflow: hidden;">
                                    <img src="{{ asset('assets/foto/' . $item->foto) }}" class="card-img-top" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $item->nama }}">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $item->nama }}</h5>
                                    <p class="card-text">Stok: {{ $item->stok }}</p>
                                    <p class="card-text">Harga: Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>



            </div>
        </section><!-- End Portfolio Section -->


        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>Contact</h2>
                    <p>
                        Untuk info lebih lanjut tentang kami silahkan hubungi kontak dibawah ini.
                    </p>
                </div>

                <div class="row gx-lg-0 gy-4">

                    <div class="col-lg-4">

                        <div class="info-container d-flex flex-column align-items-center justify-content-center">
                            <div class="info-item d-flex">
                                <i class="bi bi-geo-alt flex-shrink-0"></i>
                                <div>
                                    <h4>Location:</h4>
                                    <p>Perumahan Puri Kosambi, Kecamatan Klari, Kabupaten Karawang</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex">
                                <i class="bi bi-envelope flex-shrink-0"></i>
                                <div>
                                    <h4>Email:</h4>
                                    <p>admin@nfgarage.my.id</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex">
                                <a href="https://wa.me/6281572680293">
                                    <i class="bi bi-phone flex-shrink-0"></i>
                                </a>
                                <div>
                                    <h4>Call:</h4>
                                    <p>+62 815-7268-0293</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex">
                                <i class="bi bi-clock flex-shrink-0"></i>
                                <div>
                                    <h4>Open Hours:</h4>
                                    <p>Mon-Sat: 11 AM - 23 PM</p>
                                </div>
                            </div><!-- End Info Item -->
                        </div>

                    </div>

                    <div class="col-lg-8">

                        <form action="{{ route('message.post') }}" method="post" role="form" enctype="multipart/form-data" class="php-email-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                            </div>
                            <div class="text-center"><button type="submit">Send Message</button></div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="container mt-4">
            <div class="copyright">
                &copy; Copyright 2025 <strong><span>Dapa</span></strong>.
            </div>
        </div>

    </footer><!-- End Footer -->
    <!-- End Footer -->

    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Buat Jadwal Booking Cepat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- Pastikan user sudah login untuk menampilkan form --}}
                    @auth
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="booking_date" class="form-label">Pilih Tanggal Booking</label>
                            <input type="date" class="form-control" id="booking_date" name="booking_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="vehicle_description" class="form-label">Deskripsi Kendaraan</label>
                            <input type="text" class="form-control" id="vehicle_description" name="vehicle_description" placeholder="Contoh: Honda Vario 125 Hitam" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Kirim Jadwal</button>
                        </div>
                    </form>
                    @else
                    {{-- Jika user belum login, tampilkan pesan ini --}}
                    <div class="text-center">
                        <p>Anda harus login terlebih dahulu untuk membuat booking.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">Login Sekarang</a>
                    </div>
                    @endauth

                </div>
            </div>
        </div>
    </div>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/template/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/template/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/template/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/template/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/template/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/template/assets/vendor/php-email-form/validate.js') }}"></script> -->

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/template/assets/js/main.js') }}"></script>

</body>

</html>