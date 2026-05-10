<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Monitoring Stres Mahasiswa">
    <title>@yield('title', 'Stress Monitor') - Monitoring Stres Mahasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ============================================
           AUTH PAGES - SPLIT SCREEN LAYOUT
           ============================================ */

        .auth-container {
            display: flex;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        /* ----- Hero Side (Left) ----- */
        .auth-hero {
            position: relative;
            width: 45%;
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
        }

        .auth-hero-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .auth-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to top,
                rgba(30, 27, 75, 0.95) 0%,
                rgba(30, 27, 75, 0.6) 40%,
                rgba(30, 27, 75, 0.3) 100%
            );
        }

        .auth-hero-content {
            position: relative;
            z-index: 10;
            padding: 3rem;
        }

        .auth-hero-title {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .auth-hero-subtitle {
            font-size: 1rem;
            color: rgba(199, 210, 254, 0.8);
            font-weight: 400;
            line-height: 1.6;
        }

        /* ----- Form Side (Right) ----- */
        .auth-form-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        /* Decorative floating orbs */
        .auth-form-section::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -120px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: floatOrb 8s ease-in-out infinite;
        }

        .auth-form-section::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.06) 0%, transparent 70%);
            border-radius: 50%;
            animation: floatOrb 10s ease-in-out infinite reverse;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(20px, -30px) scale(1.05); }
            66% { transform: translate(-15px, 20px) scale(0.95); }
        }

        .auth-form-wrapper {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 10;
        }

        /* ----- Logo ----- */
        .auth-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .auth-logo-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.25);
        }

        .auth-logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: -0.01em;
        }

        /* ----- Headings ----- */
        .auth-heading {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .auth-subheading {
            font-size: 0.938rem;
            color: #64748b;
            margin-bottom: 2rem;
            font-weight: 400;
        }

        /* ----- Alerts ----- */
        .auth-alert {
            padding: 0.875rem 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .auth-alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .auth-alert-error ul {
            list-style: disc;
            padding-left: 1.25rem;
        }

        .auth-alert-error ul li + li {
            margin-top: 0.25rem;
        }

        .auth-alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }

        /* ----- Form Fields ----- */
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .auth-field {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .auth-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }

        .auth-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .auth-input-icon {
            position: absolute;
            left: 14px;
            width: 18px;
            height: 18px;
            color: #94a3b8;
            pointer-events: none;
            transition: color 0.2s;
        }

        .auth-input {
            width: 100%;
            padding: 0.75rem 0.875rem 0.75rem 2.75rem;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            color: #1e293b;
            font-size: 0.938rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: all 0.3s ease;
        }

        .auth-input::placeholder {
            color: #94a3b8;
        }

        .auth-input:focus {
            border-color: #6366f1;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12), 0 0 20px rgba(99, 102, 241, 0.06);
        }

        .auth-input:focus + .auth-input-icon,
        .auth-input:focus ~ .auth-input-icon {
            color: #818cf8;
        }

        /* Fix icon color on focus - target the wrapper's icon */
        .auth-input-wrapper:focus-within .auth-input-icon {
            color: #6366f1;
        }

        .auth-toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .auth-toggle-password:hover {
            color: #6366f1;
        }

        .auth-hint {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        /* ----- Options Row (Remember + Forgot) ----- */
        .auth-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .auth-remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #475569;
            cursor: pointer;
        }

        .auth-checkbox {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1.5px solid #cbd5e1;
            background: #f8fafc;
            cursor: pointer;
            accent-color: #6366f1;
        }

        .auth-forgot-link {
            font-size: 0.875rem;
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .auth-forgot-link:hover {
            color: #4f46e5;
            text-decoration: underline;
        }

        /* ----- Primary Button ----- */
        .auth-btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.3);
            margin-top: 0.5rem;
        }

        .auth-btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            box-shadow: 0 8px 28px rgba(99, 102, 241, 0.4);
            transform: translateY(-1px);
        }

        .auth-btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
        }

        /* ----- Footer Text ----- */
        .auth-footer-text {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        .auth-footer-link {
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .auth-footer-link:hover {
            color: #4f46e5;
            text-decoration: underline;
        }

        /* ----- Utility ----- */
        .hidden { display: none !important; }
        .w-5 { width: 1.25rem; }
        .h-5 { height: 1.25rem; }

        /* ============================================
           RESPONSIVE
           ============================================ */

        @media (max-width: 1024px) {
            .auth-hero {
                width: 40%;
            }
        }

        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
            }

            .auth-hero {
                width: 100%;
                min-height: 220px;
                max-height: 280px;
            }

            .auth-hero-content {
                padding: 1.5rem;
            }

            .auth-hero-title {
                font-size: 1.5rem;
            }

            .auth-hero-subtitle {
                font-size: 0.875rem;
            }

            .auth-form-section {
                padding: 2rem 1.25rem 3rem;
            }

            .auth-heading {
                font-size: 1.5rem;
            }

            .auth-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .auth-form-section {
                padding: 1.5rem 1rem 2.5rem;
            }

            .auth-form-wrapper {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
