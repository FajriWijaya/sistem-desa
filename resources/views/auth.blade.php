<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Mandiri Desa Mondoteko - Login</title>
    <!-- Google Fonts for premium typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome for modern visual icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom styling -->
    <link rel="stylesheet" href="index.css">
    <style>
        /* -------------------------------------------------------------
 * 1. DESIGN SYSTEM & VARIABLES
 * ------------------------------------------------------------- */
:root {
    /* Fonts */
    --font-heading: 'Outfit', sans-serif;
    --font-body: 'Plus Jakarta Sans', sans-serif;

    /* Colors - Mondoteko/Rembang Green & Gold Palette */
    --color-bg-primary: #0a0f0d;
    --color-bg-card: rgba(255, 255, 255, 0.98);
    --color-green-dark: #052c1e;
    --color-green-mid: #0b462d;
    --color-green-light: #198754;
    --color-green-accent: #20c997;
    --color-gold: #ffc107;
    --color-gold-hover: #e0a800;
    
    /* Neutral Colors */
    --color-text-dark: #1e293b;
    --color-text-muted: #64748b;
    --color-border: #e2e8f0;
    --color-border-focus: #198754;
    --color-white: #ffffff;
    
    /* Styling Helpers */
    --shadow-premium: 0 20px 40px rgba(0, 0, 0, 0.15);
    --shadow-focus: 0 0 0 4px rgba(25, 135, 84, 0.15);
    --radius-lg: 24px;
    --radius-md: 12px;
    --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* -------------------------------------------------------------
 * 2. RESET & BASE STYLES
 * ------------------------------------------------------------- */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: var(--font-body);
    background-color: var(--color-bg-primary);
    background-image: 
        radial-gradient(circle at 10% 20%, rgba(11, 70, 45, 0.15) 0%, transparent 40%),
        radial-gradient(circle at 90% 80%, rgba(32, 201, 151, 0.08) 0%, transparent 40%);
    color: var(--color-text-dark);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    overflow-x: hidden;
}

/* -------------------------------------------------------------
 * 3. MAIN APP LAYOUT
 * ------------------------------------------------------------- */
.app-container {
    width: 100%;
    max-width: 1100px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-card {
    background-color: var(--color-bg-card);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-premium);
    display: grid;
    grid-template-columns: 1.1fr 1fr;
    width: 100%;
    min-height: 640px;
    overflow: hidden;
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.8);
}

/* -------------------------------------------------------------
 * 4. LEFT SIDE: BRANDING PANE
 * ------------------------------------------------------------- */
.branding-pane {
    position: relative;
    background-color: var(--color-green-dark);
    background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&q=80&w=1200');
    background-size: cover;
    background-position: center;
    color: var(--color-white);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 50px;
    z-index: 1;
}

.gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(5, 44, 30, 0.95) 0%, rgba(11, 70, 45, 0.85) 100%);
    z-index: -1;
}

/* Header Logo & Typography */
.header-logo-group {
    display: flex;
    align-items: center;
    gap: 16px;
}

.regency-logo {
    width: 56px;
    height: auto;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    animation: float 6s ease-in-out infinite;
}

.logo-text-group {
    display: flex;
    flex-direction: column;
}

.logo-text-group .sub-title {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    color: var(--color-gold);
}

.logo-text-group .main-title {
    font-family: var(--font-heading);
    font-size: 1.5rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    color: var(--color-white);
    margin-top: 2px;
}

/* Hero Message styling */
.hero-message {
    margin: 60px 0;
}

.hero-message h1 {
    font-family: var(--font-heading);
    font-size: 2.8rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 16px;
    background: linear-gradient(to right, #ffffff, #d1e7dd);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero-message .tagline {
    font-size: 1.05rem;
    line-height: 1.6;
    color: #e2e8f0;
    font-weight: 400;
}

.footer-branding {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.6);
}

/* -------------------------------------------------------------
 * 5. RIGHT SIDE: FORM PANE
 * ------------------------------------------------------------- */
.form-pane {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 50px 60px;
    background-color: var(--color-white);
}

.form-content {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
}

.form-header {
    margin-bottom: 32px;
}

.form-header h2 {
    font-family: var(--font-heading);
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-text-dark);
    margin-bottom: 8px;
}

.form-header p {
    font-size: 0.95rem;
    color: var(--color-text-muted);
    line-height: 1.5;
}

/* Form Fields */
.login-form {
    display: flex;
    flex-direction: column;
    gap: 22px;
}

.input-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.input-group label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--color-text-dark);
}

.label-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.forgot-pin-link {
    font-size: 0.825rem;
    font-weight: 600;
    color: var(--color-green-light);
    text-decoration: none;
    transition: var(--transition-smooth);
}

.forgot-pin-link:hover {
    color: var(--color-green-accent);
    text-decoration: underline;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 16px;
    color: var(--color-text-muted);
    font-size: 1.1rem;
    transition: var(--transition-smooth);
    pointer-events: none;
}

.input-wrapper input {
    width: 100%;
    padding: 14px 16px 14px 46px;
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    font-family: var(--font-body);
    font-size: 0.95rem;
    color: var(--color-text-dark);
    background-color: #f8fafc;
    transition: var(--transition-smooth);
}

.input-wrapper input::placeholder {
    color: #94a3b8;
}

/* Focus and hover styles for input */
.input-wrapper input:hover {
    border-color: #cbd5e1;
}

.input-wrapper input:focus {
    outline: none;
    border-color: var(--color-border-focus);
    background-color: var(--color-white);
    box-shadow: var(--shadow-focus);
}

.input-wrapper input:focus ~ .input-icon {
    color: var(--color-green-light);
}

/* Toggle Password (PIN) Eye Icon */
.toggle-password {
    position: absolute;
    right: 16px;
    background: none;
    border: none;
    color: var(--color-text-muted);
    cursor: pointer;
    font-size: 1.1rem;
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-smooth);
}

.toggle-password:hover {
    color: var(--color-green-light);
}

/* Checkbox Option Row */
.options-row {
    margin-top: 4px;
}

.checkbox-container {
    display: flex;
    align-items: center;
    position: relative;
    padding-left: 28px;
    cursor: pointer;
    user-select: none;
}

.checkbox-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkmark {
    position: absolute;
    left: 0;
    height: 18px;
    width: 18px;
    background-color: #f1f5f9;
    border: 1px solid var(--color-border);
    border-radius: 4px;
    transition: var(--transition-smooth);
}

.checkbox-container:hover input ~ .checkmark {
    border-color: #cbd5e1;
    background-color: #e2e8f0;
}

.checkbox-container input:checked ~ .checkmark {
    background-color: var(--color-green-light);
    border-color: var(--color-green-light);
}

.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

.checkbox-container input:checked ~ .checkmark:after {
    display: block;
}

.checkbox-container .checkmark:after {
    left: 6px;
    top: 2px;
    width: 4px;
    height: 9px;
    border: solid var(--color-white);
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.checkbox-label {
    font-size: 0.85rem;
    color: var(--color-text-muted);
    font-weight: 500;
    transition: var(--transition-smooth);
}

.checkbox-container:hover .checkbox-label {
    color: var(--color-text-dark);
}

/* Submit Button styling */
.submit-btn {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, var(--color-green-mid) 0%, var(--color-green-light) 100%);
    border: none;
    border-radius: var(--radius-md);
    color: var(--color-white);
    font-family: var(--font-body);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    transition: var(--transition-smooth);
    box-shadow: 0 4px 12px rgba(11, 70, 45, 0.2);
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(11, 70, 45, 0.3);
    filter: brightness(1.1);
}

.submit-btn:active {
    transform: translateY(0);
}

/* Support section styling */
.support-section {
    margin-top: 36px;
    text-align: center;
    border-top: 1px solid var(--color-border);
    padding-top: 24px;
}

.support-section p {
    font-size: 0.825rem;
    color: var(--color-text-muted);
    line-height: 1.6;
}

.support-link {
    color: var(--color-green-light);
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition-smooth);
}

.support-link:hover {
    color: var(--color-green-accent);
    text-decoration: underline;
}

/* -------------------------------------------------------------
 * 6. KEYFRAMES & ANIMATIONS
 * ------------------------------------------------------------- */
@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-6px);
    }
}

/* -------------------------------------------------------------
 * 7. RESPONSIVE MEDIA QUERIES
 * ------------------------------------------------------------- */
@media (max-width: 992px) {
    .login-card {
        grid-template-columns: 1fr;
        min-height: auto;
    }
    
    .branding-pane {
        padding: 40px;
        min-height: 300px;
        justify-content: center;
        gap: 30px;
    }
    
    .hero-message {
        margin: 0;
    }
    
    .hero-message h1 {
        font-size: 2.2rem;
    }
    
    .form-pane {
        padding: 40px 30px;
    }
}

@media (max-width: 576px) {
    body {
        padding: 10px;
    }
    
    .login-card {
        border-radius: var(--radius-md);
    }
    
    .branding-pane {
        padding: 30px 20px;
        min-height: 240px;
    }
    
    .regency-logo {
        width: 44px;
    }
    
    .logo-text-group .main-title {
        font-size: 1.25rem;
    }
    
    .hero-message h1 {
        font-size: 1.8rem;
    }
    
    .hero-message .tagline {
        font-size: 0.9rem;
    }
    
    .form-pane {
        padding: 30px 20px;
    }
    
    .form-header h2 {
        font-size: 1.6rem;
    }
}

    </style>
</head>
<body>
    <div class="app-container">
        <!-- Main Login Card -->
        <main class="login-card">
            
            <!-- Left Side: Branding and Hero Info -->
            <section class="branding-pane">
                <div class="gradient-overlay"></div>
                <div class="branding-content">
                    <div class="header-logo-group">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/3/3f/Seal_of_Rembang_Regency.svg" alt="Logo Kabupaten Rembang" class="regency-logo">
                        <div class="logo-text-group">
                            <span class="sub-title">PEMERINTAH KABUPATEN REMBANG</span>
                            <span class="main-title">DESA MONDOTEKO</span>
                        </div>
                    </div>
                    
                    <div class="hero-message">
                        <h1>Sistem Pencatan Mutasi Penduduk</h1>
                        <p class="tagline">Sistem Informasi Desa Mandiri Mondoteko. Memudahkan warga dalam pengajuan administrasi secara cepat, transparan, dan efisien.</p>
                    </div>

                    <div class="footer-branding">
                        <p>© 2026 Pemerintah Desa Mondoteko. All rights reserved.</p>
                    </div>
                </div>
            </section>

            <!-- Right Side: Login Form -->
            <section class="form-pane">
                <div class="form-content">
                    <div class="form-header">
                        <h2>Selamat Datang</h2>
                        <p>Silakan masuk menggunakan username Password.</p>
                    </div>

                    <div class="alert-message">
                        @if (session('errors'))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach (session('errors')->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    <form class="login-form" method="POST" action="/login">
                        @csrf
                        <!-- NIK Input -->
                        <div class="input-group">
                            <label for="nik">Username</label>
                            <div class="input-wrapper">
                                <i class="fa-regular fa-user input-icon"></i>
                                <input type="text" id="nik" name="username" placeholder="Masukkan 16 digit NIK Anda" maxlength="16" required autocomplete="off">
                            </div>
                        </div>

                        <!-- PIN Input -->
                        <div class="input-group">
                            <div class="label-row">
                                <label for="pin">Password</label>
                               
                            </div>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-lock input-icon"></i>
                                <input type="password" id="pin" name="password"  required>
                                <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan kata sandi">
                                    <i class="fa-regular fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Keep Logged In Option -->
                        <div class="options-row">
                            <label class="checkbox-container">
                                <input type="checkbox" id="remember-me">
                                <span class="checkmark"></span>
                                <span class="checkbox-label">Ingat saya di perangkat ini</span>
                            </label>
                        </div>

                        <!-- Action Button -->
                        <button type="submit" class="submit-btn">
                            <span>Masuk ke Layanan</span>
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        </button>
                    </form>

                    <!-- Alternative / Support Option -->
                    <div class="support-section">
                        <p>Belum terdaftar atau mengalami kendala? <br>Hubungi <a href="#" class="support-link">Operator Desa</a> atau kunjungi kantor balai desa.</p>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Password visibility toggle script -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#pin');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'password') {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });
    </script>
</body>
</html>
