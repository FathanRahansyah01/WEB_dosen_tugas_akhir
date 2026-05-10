@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
<div class="auth-container">
    {{-- Left Side - Hero Image --}}
    <div class="auth-hero">
        <img src="{{ asset('images/auth-hero.png') }}" alt="StressMonitor Brain Illustration" class="auth-hero-img">
        <div class="auth-hero-overlay"></div>
        <div class="auth-hero-content">
            <h1 class="auth-hero-title">StressMonitor</h1>
            <p class="auth-hero-subtitle">Bergabung untuk memantau kesehatan mental mahasiswa</p>
        </div>
    </div>

    {{-- Right Side - Register Form --}}
    <div class="auth-form-section">
        <div class="auth-form-wrapper">
            {{-- Logo --}}
            <div class="auth-logo">
                <div class="auth-logo-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <span class="auth-logo-text">StressMonitor</span>
            </div>

            {{-- Heading --}}
            <h2 class="auth-heading">Buat Akun Baru</h2>
            <p class="auth-subheading">Daftarkan diri Anda sebagai dosen</p>

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="auth-alert auth-alert-error" id="register-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="/register" id="register-form" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label for="name" class="auth-label">Nama Lengkap</label>
                    <div class="auth-input-wrapper">
                        <svg class="auth-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                               class="auth-input" placeholder="Masukkan nama lengkap">
                    </div>
                </div>

                <div class="auth-field">
                    <label for="email" class="auth-label">Email</label>
                    <div class="auth-input-wrapper">
                        <svg class="auth-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="auth-input" placeholder="nama@email.com">
                    </div>
                </div>

                <div class="auth-field">
                    <label for="password" class="auth-label">Kata Sandi</label>
                    <div class="auth-input-wrapper">
                        <svg class="auth-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input type="password" id="password" name="password" required
                               class="auth-input" placeholder="Minimal 8 karakter">
                        <button type="button" onclick="togglePassword('password')"
                                class="auth-toggle-password">
                            <svg id="eye-closed-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                            <svg id="eye-open-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <p class="auth-hint">Minimal 8 karakter</p>
                </div>

                <div class="auth-field">
                    <label for="password_confirmation" class="auth-label">Konfirmasi Kata Sandi</label>
                    <div class="auth-input-wrapper">
                        <svg class="auth-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="auth-input" placeholder="Ulangi kata sandi">
                        <button type="button" onclick="togglePassword('password_confirmation')"
                                class="auth-toggle-password">
                            <svg id="eye-closed-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                            <svg id="eye-open-password_confirmation" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" id="btn-register" class="auth-btn-primary">
                    <span>Daftar</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <p class="auth-footer-text">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="auth-footer-link" id="link-login">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const eyeOpen = document.getElementById('eye-open-' + fieldId);
        const eyeClosed = document.getElementById('eye-closed-' + fieldId);

        if (field.type === 'password') {
            field.type = 'text';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        } else {
            field.type = 'password';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        }
    }
</script>
@endsection
