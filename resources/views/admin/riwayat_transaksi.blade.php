<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Transaksi - NF Garage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
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
    <div class="p-6 md:p-8">
        {{-- Header Halaman --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <p class="text-sm text-gray-500">Dashboard /</p>
                <h1 class="text-3xl font-bold">Riwayat Transaksi</h1>
            </div>
            {{-- PERBAIKAN: Menambahkan flex-wrap agar tombol tidak menumpuk di layar kecil --}}
            <div class="flex items-center flex-wrap gap-2 mt-4 md:mt-0">
                <button id="btn-buka-laporan-modal" type="button" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-semibold whitespace-nowrap">Cetak Laporan</button>
                <a href="{{ route('kasir.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition font-semibold whitespace-nowrap">&larr; Kembali ke Kasir</a>
            </div>
        </div>

        {{-- PERBAIKAN: Kontainer tabel dibuat responsif, tidak lagi menggunakan <table> di mobile --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            {{-- Tampilan Tabel untuk Desktop (md dan lebih besar) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Kode Transaksi</th>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3">Kasir</th>
                            <th scope="col" class="px-6 py-3">Total Harga</th>
                            <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $transaction->kode_transaksi }}</td>
                            <td class="px-6 py-4">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">{{ $transaction->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end items-center space-x-4">
                                    <a href="{{ route('transaksi.cetak', ['transaction_id' => $transaction->id]) }}" target="_blank" class="font-medium text-indigo-600 dark:text-indigo-500 hover:underline">Cetak Struk</a>
                                    <button type="button" class="btn-kirim-struk font-medium text-green-600 dark:text-green-500 hover:underline" data-transaction-id="{{ $transaction->id }}">Kirim Struk</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada transaksi yang tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tampilan Kartu untuk Mobile (di bawah md) --}}
            <div class="grid grid-cols-1 gap-4 p-4 md:hidden">
                @forelse ($transactions as $transaction)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-4 space-y-3">
                    <div class="flex justify-between items-start">
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $transaction->kode_transaksi }}</span>
                        <span class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="space-y-1 text-sm">
                        <p><span class="text-gray-500">Kasir:</span> {{ $transaction->user->name ?? 'N/A' }}</p>
                        <p><span class="text-gray-500">Total:</span> <span class="font-bold">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span></p>
                    </div>
                    <div class="flex justify-end items-center space-x-4 pt-2 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('transaksi.cetak', ['transaction_id' => $transaction->id]) }}" target="_blank" class="font-medium text-indigo-600 dark:text-indigo-500 hover:underline">Cetak</a>
                        <button type="button" class="btn-kirim-struk font-medium text-green-600 dark:text-green-500 hover:underline" data-transaction-id="{{ $transaction->id }}">Kirim</button>
                    </div>
                </div>
                @empty
                <p class="py-12 text-center text-gray-500">Belum ada transaksi yang tercatat.</p>
                @endforelse
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">{{ $transactions->links() }}</div>
    </div>

    {{-- Modal Email (Tidak ada perubahan) --}}
    <div id="email-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden modal-backdrop">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl w-full max-w-md p-6 modal-content scale-95">
            <h2 class="text-2xl font-bold mb-4">Kirim Struk ke Email</h2>
            <form id="email-form">
                <div>
                    <label for="email-pembeli" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Pembeli</label>
                    <input type="email" id="email-pembeli" name="email" required class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-lg" placeholder="contoh@email.com">
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" id="btn-email-modal-batal" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition">Batal</button>
                    <button type="submit" id="btn-email-modal-kirim" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-semibold">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Laporan (Tidak ada perubahan) --}}
    <div id="laporan-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden modal-backdrop">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl w-full max-w-md p-6 modal-content scale-95">
            <h2 class="text-2xl font-bold mb-4">Pilih Periode Laporan</h2>
            <form id="laporan-form">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="tahun-laporan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun</label>
                        <select id="tahun-laporan" name="tahun" required class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></select>
                    </div>
                    <div>
                        <label for="bulan-laporan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bulan</label>
                        <select id="bulan-laporan" name="bulan" required class="mt-1 block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" id="btn-laporan-modal-batal" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 transition">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-semibold">Cetak</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Javascript (Tidak ada perubahan) --}}
    <script>
        const availablePeriods = @json($availablePeriods ?? []);

        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // --- Logika untuk Modal Email ---
            const emailModal = document.getElementById('email-modal');
            const emailForm = document.getElementById('email-form');
            const emailInput = document.getElementById('email-pembeli');
            const btnEmailModalBatal = document.getElementById('btn-email-modal-batal');
            const btnEmailModalKirim = document.getElementById('btn-email-modal-kirim');
            let currentTransactionId = null;

            function showEmailModal(transactionId) {
                currentTransactionId = transactionId;
                emailInput.value = '';
                emailModal.classList.remove('hidden');
                setTimeout(() => emailModal.querySelector('.modal-content').classList.remove('scale-95'), 10);
                setTimeout(() => emailInput.focus(), 50);
            }

            function hideEmailModal() {
                emailModal.querySelector('.modal-content').classList.add('scale-95');
                setTimeout(() => emailModal.classList.add('hidden'), 300);
            }

            document.querySelectorAll('.btn-kirim-struk').forEach(button => {
                button.addEventListener('click', function() {
                    showEmailModal(this.dataset.transactionId);
                });
            });

            btnEmailModalBatal.addEventListener('click', hideEmailModal);
            emailModal.addEventListener('click', (e) => {
                if (e.target === emailModal) hideEmailModal();
            });

            emailForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const email = emailInput.value;
                btnEmailModalKirim.textContent = 'Mengirim...';
                btnEmailModalKirim.disabled = true;
                const url = `/transaksi/${currentTransactionId}/kirim`;
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            email: email
                        })
                    })
                    .then(response => response.ok ? response.json() : response.json().then(err => Promise.reject(err)))
                    .then(data => {
                        alert(data.message);
                        hideEmailModal();
                    })
                    .catch(error => alert('Error: ' + (error.message || 'Terjadi kesalahan')))
                    .finally(() => {
                        btnEmailModalKirim.textContent = 'Kirim';
                        btnEmailModalKirim.disabled = false;
                    });
            });

            // --- Logika untuk Modal Laporan ---
            const laporanModal = document.getElementById('laporan-modal');
            const laporanForm = document.getElementById('laporan-form');
            const btnBukaLaporanModal = document.getElementById('btn-buka-laporan-modal');
            const btnLaporanModalBatal = document.getElementById('btn-laporan-modal-batal');
            const tahunSelect = document.getElementById('tahun-laporan');
            const bulanSelect = document.getElementById('bulan-laporan');
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

            function populateYears() {
                const years = [...new Set(availablePeriods.map(p => p.year))];
                tahunSelect.innerHTML = '';
                years.forEach(year => {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    tahunSelect.appendChild(option);
                });
                tahunSelect.dispatchEvent(new Event('change'));
            }

            function updateMonths() {
                const selectedYear = parseInt(tahunSelect.value);
                const monthsForYear = availablePeriods.filter(p => p.year === selectedYear);
                bulanSelect.innerHTML = '';
                monthsForYear.forEach(period => {
                    const option = document.createElement('option');
                    option.value = period.month;
                    option.textContent = monthNames[period.month - 1];
                    bulanSelect.appendChild(option);
                });
            }

            tahunSelect.addEventListener('change', updateMonths);

            function showLaporanModal() {
                if (availablePeriods.length === 0) {
                    alert('Tidak ada data transaksi untuk dicetak.');
                    return;
                }
                populateYears();
                laporanModal.classList.remove('hidden');
                setTimeout(() => laporanModal.querySelector('.modal-content').classList.remove('scale-95'), 10);
            }

            function hideLaporanModal() {
                laporanModal.querySelector('.modal-content').classList.add('scale-95');
                setTimeout(() => laporanModal.classList.add('hidden'), 300);
            }

            btnBukaLaporanModal.addEventListener('click', showLaporanModal);
            btnLaporanModalBatal.addEventListener('click', hideLaporanModal);
            laporanModal.addEventListener('click', (e) => {
                if (e.target === laporanModal) hideLaporanModal();
            });

            laporanForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const bulan = bulanSelect.value;
                const tahun = tahunSelect.value;
                if (!bulan || !tahun) return;
                const baseUrl = "{{ route('laporan.keuangan.cetak') }}";
                const url = `${baseUrl}?bulan=${bulan}&tahun=${tahun}`;
                window.open(url, '_blank');
                hideLaporanModal();
            });
        });
    </script>
</body>

</html>