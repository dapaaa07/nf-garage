<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Kasir - NF Garage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .card-img-top-container {
            height: 200px;
            overflow: hidden;
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1f2937;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }

        .modal-backdrop {
            transition: opacity 0.3s ease;
        }

        .modal-content {
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-200">
    <div class="flex h-screen overflow-hidden">
        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8 overflow-y-auto custom-scrollbar">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div>
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-500">Dashboard/</a>
                    <h1 class="text-3xl font-bold">Kasir</h1>
                </div>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <a href="{{ route('transaksi.riwayat') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-sm font-medium rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition whitespace-nowrap">
                        Riwayat Transaksi
                    </a>

                    {{-- Tombol keranjang dipindahkan dari sini --}}

                    <form action="{{ url('/kasir') }}" method="GET" class="w-full md:w-auto">
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            @if(request('kategori'))
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                            @endif
                            <input name="search" type="text" placeholder="Cari produk..." value="{{ request('search') }}" class="w-full md:w-64 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Category Filters -->
            @php $currentCategory = request('kategori', 'Semua'); @endphp
            <div class="flex space-x-2 mb-6 border-b border-gray-200 dark:border-gray-700 pb-2 overflow-x-auto">
                <a href="{{ url('/kasir') }}" class="px-4 py-2 text-sm font-medium rounded-md transition whitespace-nowrap {{ $currentCategory == 'Semua' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700' }}">Semua Produk</a>
                <a href="{{ url('/kasir?kategori=Oli') }}" class="px-4 py-2 text-sm font-medium rounded-md transition whitespace-nowrap {{ $currentCategory == 'Oli' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700' }}">Oli</a>
                <a href="{{ url('/kasir?kategori=Rem') }}" class="px-4 py-2 text-sm font-medium rounded-md transition whitespace-nowrap {{ $currentCategory == 'Rem' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700' }}">Sistem Rem</a>
                <a href="{{ url('/kasir?kategori=Internal') }}" class="px-4 py-2 text-sm font-medium rounded-md transition whitespace-nowrap {{ $currentCategory == 'Internal' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700' }}">Internal Mesin</a>
                <a href="{{ url('/kasir?kategori=Lainnya') }}" class="px-4 py-2 text-sm font-medium rounded-md transition whitespace-nowrap {{ $currentCategory == 'Lainnya' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700' }}">Lainnya</a>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @forelse ($data as $item)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition transform hover:-translate-y-1 hover:shadow-xl flex flex-col">
                    <div class="card-img-top-container">
                        <img src="{{ asset('assets/foto/' . $item->foto) }}" class="card-img-top" alt="{{ $item->nama }}" onerror="this.onerror=null;this.src='https://placehold.co/400x400/374151/FFFFFF?text=Gambar+Produk';">
                    </div>
                    <div class="p-4 flex flex-col justify-between flex-grow">
                        <div>
                            <h5 class="font-bold text-lg truncate">{{ $item->nama }}</h5>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Stok: {{ $item->stok }}</p>
                            <p class="font-semibold text-indigo-500 mt-1">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        </div>
                        <button class="add-to-cart-btn w-full bg-indigo-600 text-white py-2 px-4 rounded-md mt-4 hover:bg-indigo-700 transition font-semibold disabled:bg-gray-400 disabled:cursor-not-allowed"
                            data-id="{{ $item->id }}"
                            data-type="{{ strtolower($item->kategori) }}"
                            @if($item->stok <= 0) disabled @endif>
                                @if($item->stok > 0)
                                <span>+ Tambah</span>
                                @else
                                <span>Stok Habis</span>
                                @endif
                        </button>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500">Produk tidak ditemukan.</p>
                </div>
                @endforelse
            </div>
        </main>

        <aside id="order-sidebar" class="w-80 max-w-[90%] lg:w-96 bg-white dark:bg-gray-800 p-6 shadow-lg flex flex-col fixed top-0 right-0 h-full z-50 transform transition-transform duration-300 ease-in-out translate-x-full lg:relative lg:translate-x-0">
            <div class="flex justify-between items-center mb-4 border-b border-gray-200 dark:border-gray-700 pb-4">
                <h2 class="text-xl font-bold">Detail Pesanan</h2>
                <button id="close-cart-btn" class="lg:hidden p-1 rounded-full text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div id="cart-container" class="flex-1 overflow-y-auto custom-scrollbar -mr-4 pr-4">
                <div id="cart-empty-message" class="flex flex-col items-center justify-center h-full text-center text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p>Keranjang masih kosong</p>
                </div>
                <ul id="cart-items-list" class="space-y-4"></ul>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 mt-auto pt-4">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span id="cart-subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span id="cart-total">Rp 0</span>
                    </div>
                </div>
                <button id="btn-pembayaran" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg mt-4 hover:bg-indigo-700 transition" disabled>
                    Proses Pembayaran
                </button>
            </div>
        </aside>
    </div>

    <!-- Backdrop untuk sidebar mobile -->
    <div id="cart-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

    {{-- Tombol keranjang FAB --}}
    <button id="open-cart-btn" class="lg:hidden fixed bottom-6 right-6 z-50 bg-indigo-600 text-white rounded-full p-4 shadow-lg hover:bg-indigo-700 transition transform hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span id="mobile-cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center border-2 border-indigo-600 hidden">0</span>
    </button>


    <!-- Modal Pembayaran -->
    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-[60] hidden modal-backdrop">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl w-full max-w-md p-6 modal-content scale-95">
            <h2 class="text-2xl font-bold mb-4">Konfirmasi Pembayaran</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Total Belanja</label>
                    <p id="modal-total" class="text-3xl font-bold text-indigo-500">Rp 0</p>
                </div>
                <div>
                    <label for="jumlah-bayar" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Uang Dibayar (Rp)</label>
                    <input type="number" id="jumlah-bayar" class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-lg" placeholder="Contoh: 100000">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Kembalian</label>
                    <p id="modal-kembalian" class="text-2xl font-semibold">Rp 0</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button id="btn-modal-batal" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition">Batal</button>
                <button id="btn-modal-bayar" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition font-semibold disabled:bg-indigo-300 disabled:cursor-not-allowed">Bayar</button>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const cartItemsList = document.getElementById('cart-items-list');
            let grandTotal = 0;

            function updateCartUI(data) {
                const cartEmptyMessage = document.getElementById('cart-empty-message');
                const btnPembayaran = document.getElementById('btn-pembayaran');
                const mobileCartCount = document.getElementById('mobile-cart-count');
                cartItemsList.innerHTML = '';

                const cart = data.cart || {};
                const cartKeys = Object.keys(cart);
                let totalItems = 0;

                if (cartKeys.length === 0) {
                    cartEmptyMessage.style.display = 'flex';
                    btnPembayaran.disabled = true;
                    if (mobileCartCount) {
                        mobileCartCount.classList.add('hidden');
                        mobileCartCount.textContent = '0';
                    }
                } else {
                    cartEmptyMessage.style.display = 'none';
                    btnPembayaran.disabled = false;
                    cartKeys.forEach(key => {
                        const item = cart[key];
                        totalItems += parseInt(item.kuantitas, 10);
                        const itemHtml = `
                            <li class="flex items-center space-x-4">
                                <img src="{{ asset('assets/foto/') }}/${item.foto}" class="w-16 h-16 rounded-md object-cover bg-gray-200" alt="${item.nama}" onerror="this.onerror=null;this.src='https://placehold.co/100x100/374151/FFFFFF?text=Img';">
                                <div class="flex-1">
                                    <p class="font-semibold text-sm">${item.nama}</p>
                                    <p class="text-xs text-gray-500">Rp ${new Intl.NumberFormat('id-ID').format(item.harga)}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button class="btn-qty-update w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600" data-cart-id="${key}" data-amount="-1">-</button>
                                    <span class="font-medium w-5 text-center">${item.kuantitas}</span>
                                    <button class="btn-qty-update w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600" data-cart-id="${key}" data-amount="1">+</button>
                                </div>
                            </li>
                        `;
                        cartItemsList.insertAdjacentHTML('beforeend', itemHtml);
                    });

                    if (mobileCartCount) {
                        mobileCartCount.textContent = totalItems;
                        mobileCartCount.classList.remove('hidden');
                    }
                }

                document.getElementById('cart-subtotal').textContent = `Rp ${data.total.subtotal}`;
                document.getElementById('cart-total').textContent = `Rp ${data.total.total}`;
                grandTotal = parseInt(data.total.total.replace(/\./g, ''), 10) || 0;
            }

            function handleQuantityUpdate(cartId, amount) {
                fetch(`/cart/update/${cartId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            amount: amount
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data.message);
                        updateCartUI(data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message);
                    });
            }

            fetch("{{ route('cart.index') }}").then(res => res.json()).then(data => updateCartUI(data));

            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function() {
                    fetch("{{ route('cart.add') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            product_id: this.dataset.id,
                            product_type: this.dataset.type
                        })
                    }).then(res => res.json()).then(data => {
                        console.log(data.message);
                        updateCartUI(data);
                    });
                });
            });

            cartItemsList.addEventListener('click', function(event) {
                if (event.target.matches('.btn-qty-update')) {
                    handleQuantityUpdate(event.target.dataset.cartId, parseInt(event.target.dataset.amount, 10));
                }
            });

            // Logika Modal Pembayaran
            const paymentModal = document.getElementById('payment-modal');
            const btnPembayaran = document.getElementById('btn-pembayaran');
            const btnModalBatal = document.getElementById('btn-modal-batal');
            const btnModalBayar = document.getElementById('btn-modal-bayar');
            const inputJumlahBayar = document.getElementById('jumlah-bayar');
            const modalTotal = document.getElementById('modal-total');
            const modalKembalian = document.getElementById('modal-kembalian');

            btnPembayaran.addEventListener('click', () => {
                modalTotal.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(grandTotal)}`;
                inputJumlahBayar.value = '';
                modalKembalian.textContent = 'Rp 0';
                btnModalBayar.disabled = true;
                paymentModal.classList.remove('hidden');
                setTimeout(() => paymentModal.querySelector('.modal-content').classList.remove('scale-95'), 10);
                setTimeout(() => inputJumlahBayar.focus(), 100);
            });

            function hideModal() {
                paymentModal.querySelector('.modal-content').classList.add('scale-95');
                setTimeout(() => paymentModal.classList.add('hidden'), 300);
            }
            btnModalBatal.addEventListener('click', hideModal);
            paymentModal.addEventListener('click', (e) => {
                if (e.target === paymentModal) hideModal();
            });

            inputJumlahBayar.addEventListener('input', () => {
                const bayar = parseInt(inputJumlahBayar.value, 10) || 0;
                const kembalian = bayar - grandTotal;

                if (kembalian >= 0) {
                    modalKembalian.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(kembalian)}`;
                    btnModalBayar.disabled = false;
                } else {
                    modalKembalian.textContent = 'Rp 0';
                    btnModalBayar.disabled = true;
                }
            });

            btnModalBayar.addEventListener('click', () => {
                const jumlahBayar = inputJumlahBayar.value;
                btnModalBayar.textContent = 'Memproses...';
                btnModalBayar.disabled = true;

                fetch("{{ route('transactions.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            jumlah_bayar: jumlahBayar
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert(data.message);
                        window.location.href = data.redirect_url;
                    })
                    .catch(error => {
                        alert(`Error: ${error.message}`);
                        btnModalBayar.disabled = false;
                    })
                    .finally(() => {
                        btnModalBayar.textContent = 'Bayar';
                    });
            });

            // Logika buka/tutup sidebar mobile
            const openCartBtn = document.getElementById('open-cart-btn');
            const closeCartBtn = document.getElementById('close-cart-btn');
            const orderSidebar = document.getElementById('order-sidebar');
            const cartBackdrop = document.getElementById('cart-backdrop');

            function openCart() {
                orderSidebar.classList.remove('translate-x-full');
                cartBackdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                openCartBtn.classList.add('hidden'); // PERBAIKAN: Sembunyikan tombol FAB
            }

            function closeCart() {
                orderSidebar.classList.add('translate-x-full');
                cartBackdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                openCartBtn.classList.remove('hidden'); // PERBAIKAN: Tampilkan kembali tombol FAB
            }

            openCartBtn.addEventListener('click', openCart);
            closeCartBtn.addEventListener('click', closeCart);
            cartBackdrop.addEventListener('click', closeCart);
        });
    </script>
</body>

</html>