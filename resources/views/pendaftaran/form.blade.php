<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pelanggan - SIPAMTINO</title>
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
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .form-control {
            border-radius: 15px;
            border: 2px solid #e9ecef;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .alert {
            border-radius: 15px;
        }
        h2 {
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
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Pendaftaran Pelanggan</h2>
                            <p class="text-muted">Silakan isi form berikut untuk mendaftar sebagai pelanggan</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="no_hp" class="form-label fw-bold">Nomor HP <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('no_hp') is-invalid @enderror" 
                                       id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                <div class="form-text">
                                    <small>Password minimal 8 karakter</small>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" name="password_confirmation" required>
                                <div class="form-text">
                                    <small>Masukkan password sekali lagi untuk konfirmasi</small>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="ktp" class="form-label fw-bold">Upload KTP <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('ktp') is-invalid @enderror" 
                                       id="ktp" name="ktp" accept=".jpg,.jpeg,.png,.pdf" required>
                                <div class="form-text">
                                    <small>Upload file KTP untuk verifikasi wilayah RT 8. Format: JPG, PNG, atau PDF. Maksimal 2MB.</small>
                                </div>
                                @error('ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <strong><i class="fas fa-info-circle me-2"></i>Informasi Penting:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Pendaftaran hanya untuk warga RT 8</li>
                                    <li>KTP akan digunakan untuk verifikasi alamat</li>
                                    <li>Setelah pendaftaran, tunggu konfirmasi dari admin</li>
                                    <li>Tarif akan ditetapkan sesuai ketentuan yang berlaku</li>
                                </ul>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Daftar Sekarang
                                </button>
                                <a href="{{ route('landing') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
    
    <script>
    // Password strength indicator
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthIndicator = document.getElementById('password-strength');
        
        if (!strengthIndicator) {
            const indicator = document.createElement('div');
            indicator.id = 'password-strength';
            indicator.className = 'mt-2';
            this.parentNode.appendChild(indicator);
        }
        
        const strength = checkPasswordStrength(password);
        const strengthIndicatorElement = document.getElementById('password-strength');
        
        if (password.length === 0) {
            strengthIndicatorElement.innerHTML = '';
            return;
        }
        
        strengthIndicatorElement.innerHTML = `
            <div class="progress" style="height: 5px;">
                <div class="progress-bar ${strength.class}" role="progressbar" 
                     style="width: ${strength.percent}%" aria-valuenow="${strength.percent}" 
                     aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted mt-1">${strength.text}</small>
        `;
    });
    
    // Password confirmation check
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        const feedback = document.getElementById('password-confirm-feedback');
        
        if (!feedback) {
            const feedbackDiv = document.createElement('div');
            feedbackDiv.id = 'password-confirm-feedback';
            feedbackDiv.className = 'mt-1';
            this.parentNode.appendChild(feedbackDiv);
        }
        
        const feedbackElement = document.getElementById('password-confirm-feedback');
        
        if (confirmPassword.length === 0) {
            feedbackElement.innerHTML = '';
            this.classList.remove('is-valid', 'is-invalid');
            return;
        }
        
        if (password === confirmPassword) {
            feedbackElement.innerHTML = '<small class="text-success"><i class="fas fa-check"></i> Password cocok</small>';
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            feedbackElement.innerHTML = '<small class="text-danger"><i class="fas fa-times"></i> Password tidak cocok</small>';
            this.classList.remove('is-valid');
            this.classList.add('is-invalid');
        }
    });
    
    function checkPasswordStrength(password) {
        let strength = 0;
        const checks = {
            length: password.length >= 8,
            lowercase: /[a-z]/.test(password),
            uppercase: /[A-Z]/.test(password),
            numbers: /\d/.test(password),
            special: /[^\w\s]/.test(password)
        };
        
        Object.values(checks).forEach(check => {
            if (check) strength++;
        });
        
        if (strength < 2) {
            return { percent: 20, class: 'bg-danger', text: 'Sangat Lemah' };
        } else if (strength < 3) {
            return { percent: 40, class: 'bg-warning', text: 'Lemah' };
        } else if (strength < 4) {
            return { percent: 60, class: 'bg-info', text: 'Sedang' };
        } else if (strength < 5) {
            return { percent: 80, class: 'bg-primary', text: 'Kuat' };
        } else {
            return { percent: 100, class: 'bg-success', text: 'Sangat Kuat' };
        }
    }
    </script>
</body>
</html>
