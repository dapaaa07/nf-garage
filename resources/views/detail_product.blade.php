<!DOCTYPE html>
<html lang="id">

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

                    <li class="d-none d-lg-block" style="width: 30px;"></li>

                    @guest
                    <li><a class="btn-login" href="{{ route('login') }}">Login</a></li>
                    @endguest
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
    </header>

    <!-- End Header -->
    <div class="container">

        <aside class="product-list">
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Oli Super Matic</td>
                        <td>Rp 55.000</td>
                        <td>120</td>
                    </tr>
                    <tr>
                        <td>Kampas Rem Depan</td>
                        <td>Rp 48.000</td>
                        <td>85</td>
                    </tr>
                    <tr>
                        <td>Busi Iridium</td>
                        <td>Rp 75.000</td>
                        <td>200</td>
                    </tr>
                    <tr>
                        <td>Filter Udara</td>
                        <td>Rp 35.000</td>
                        <td>150</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </aside>

        <main class="product-detail">

            <div class="product-image-box">
                FOTO PRODUK
                <div class="date-box">Date: 28/10/2025</div>
            </div>

            <h2>Detail Produk</h2>
            <p>
                Ini adalah area untuk deskripsi detail produk. Teks ini mewakili
                garis-garis bergelombang yang Anda gambar di buku catatan. Anda bisa
                menjelaskan spesifikasi, keunggulan, atau informasi lainnya di sini.
            </p>
            <p>
                Paragraf kedua untuk melanjutkan deskripsi. Semakin banyak teks
                yang Anda tambahkan, akan semakin menyerupai desain awal Anda.
            </p>
            <p>
                Paragraf ketiga dan seterusnya...
            </p>

        </main>

    </div>

</body>

</html>