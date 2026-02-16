<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f2f5;
            margin: 0;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        h2 {
            margin-bottom: 10px;
            color: #333;
        }

        p {
            color: #666;
            font-size: 15px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            text-align: center;
            font-size: 1.2em;
            letter-spacing: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
        }

        button:hover {
            background-color: #0056b3;
        }

        .resend-form button {
            background: none;
            border: none;
            color: #007bff;
            padding: 0;
            font-size: 14px;
            cursor: pointer;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Verifikasi Email Anda</h2>
        @if (session('email'))
        <p>Kami telah mengirimkan kode verifikasi 6 digit ke <strong>{{ session('email') }}</strong>. Silakan periksa kotak masuk Anda.</p>
        @endif

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('verification.verify') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="code">Masukkan Kode Verifikasi</label>
                <input type="text" id="code" name="code" required autofocus pattern="\d{6}" title="Harus 6 digit angka">
            </div>

            @error('code')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <button type="submit">Verifikasi Akun</button>
        </form>

        <form class="resend-form" action="{{ route('verification.resend') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">
            <button type="submit">Tidak menerima kode? Kirim ulang</button>
        </form>
    </div>
</body>

</html>