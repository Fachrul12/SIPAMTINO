<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - SIPAMTINO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #28a745, #20c997);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
        }
        h1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-body p-5 text-center">
                        <div class="success-icon">
                            <i class="fas fa-check fa-2x text-white"></i>
                        </div>
                        
                        <h1 class="fw-bold mb-4">Pendaftaran Berhasil!</h1>
                        
                        <div class="alert alert-success">
                            <p class="mb-0">
                                <strong>Terima kasih telah mendaftar!</strong><br>
                                Data pendaftaran Anda telah berhasil disimpan dan akan segera diproses oleh admin.
                            </p>
                        </div>

                        <div class="alert alert-info">
                            <strong><i class="fas fa-info-circle me-2"></i>Langkah Selanjutnya:</strong>
                            <ul class="mb-0 mt-2 text-start">
                                <li>Admin akan memverifikasi KTP Anda untuk memastikan alamat berada di RT 8</li>
                                <li>Proses verifikasi biasanya memakan waktu 1-3 hari kerja</li>
                                <li>Anda akan dihubungi melalui nomor HP yang terdaftar</li>
                                <li>Setelah disetujui, akun pelanggan akan diaktifkan</li>
                            </ul>
                        </div>

                        <div class="d-grid gap-3 mt-4">
                            <a href="{{ route('landing') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-home me-2"></i>Kembali ke Beranda
                            </a>
                            <a href="{{ route('pendaftaran.form') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-plus me-2"></i>Daftarkan Orang Lain
                            </a>
                        </div>

                        <div class="mt-4 pt-4 border-top">
                            <h6 class="text-muted">Butuh bantuan?</h6>
                            <p class="text-muted small">
                                Hubungi admin SIPAMTINO jika Anda memiliki pertanyaan tentang pendaftaran.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
</body>
</html>
