<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Libra-Track</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Barlow+Condensed:wght@700;800;900&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --accent: #f4a261;
            --accent-2: #e76f51;
            --red: #f06a6a;
        }

        html,
        body {
            height: 100%;
            font-family: 'Barlow', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* ── FULL PAGE BG IMAGE ── */
        .page-bg {
            min-height: 100vh;
            background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1800&q=85&fit=crop');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }

        .page-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(8, 10, 16, 0.72);
        }

        /* ── CARD ── */
        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 780px;
            background: rgba(18, 22, 34, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.07);
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.6);
        }

        /* ── LEFT IMAGE PANEL ── */
        .card-image {
            position: relative;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .card-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom,
                    rgba(10, 13, 22, 0.3) 0%,
                    rgba(10, 13, 22, 0.15) 50%,
                    rgba(10, 13, 22, 0.75) 100%);
        }

        /* Top bar on image */
        .card-image-top {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 1.25rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 2;
        }

        .logo-icon {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-icon svg {
            width: 15px;
            height: 15px;
            fill: none;
            stroke: #fff;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .brand-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .brand-name span {
            color: var(--accent);
        }

        /* Bottom label on image */
        .card-image-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.25rem;
            z-index: 2;
        }

        .card-image-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.5rem;
            font-weight: 900;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            line-height: 1.1;
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.5);
        }

        .card-image-label span {
            color: var(--accent);
        }

        .card-image-sublabel {
            font-size: 0.72rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* ── RIGHT FORM PANEL ── */
        .card-form {
            padding: 2.75rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-title {
            font-family: 'Barlow', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1.75rem;
            letter-spacing: -0.01em;
        }

        /* Fields */
        .form-group {
            margin-bottom: 0.875rem;
        }

        .form-control {
            width: 100%;
            padding: 13px 16px;
            font-size: 0.875rem;
            font-family: 'Barlow', sans-serif;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #fff;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(244, 162, 97, 0.12);
            background: rgba(255, 255, 255, 0.07);
        }

        .invalid-feedback {
            color: var(--red);
            font-size: 0.73rem;
            margin-top: 4px;
        }

        .forgot-row {
            text-align: right;
            margin-bottom: 1.25rem;
        }

        .forgot-link {
            font-size: 0.78rem;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 1rem 0;
            color: rgba(255, 255, 255, 0.2);
            font-size: 0.78rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }

        /* Buttons */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #1a0f00;
            font-family: 'Barlow', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: opacity 0.15s, transform 0.15s;
            margin-top: 0.5rem;
        }

        .btn-login:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }

        .alert-error {
            background: rgba(240, 106, 106, 0.08);
            border: 1px solid rgba(240, 106, 106, 0.2);
            color: var(--red);
            padding: 10px 14px;
            border-radius: 9px;
            font-size: 0.81rem;
            margin-bottom: 1.25rem;
        }

        .signup-link {
            text-align: center;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.35);
            margin-top: 1.25rem;
        }

        .signup-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 680px) {
            .login-card {
                grid-template-columns: 1fr;
            }

            .card-image {
                height: 200px;
            }
        }
    </style>
</head>

<body>

    <div class="page-bg">
        <div class="login-card">

            {{-- ── LEFT: IMAGE ── --}}
            <div class="card-image">
                <img src="https://images.unsplash.com/photo-1568667256549-094345857637?w=600&q=85&fit=crop"
                    alt="Library"
                    onerror="this.src='https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&q=85&fit=crop'">
                <div class="card-image-overlay"></div>

                <div class="card-image-top">
                    <div class="logo-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                        </svg>
                    </div>
                    <span class="brand-name"><span>Libra</span>-Track</span>
                </div>

                <div class="card-image-bottom">
                    <div class="card-image-label"><span>Libra</span>-Track</div>
                    <div class="card-image-sublabel">Library Management System</div>
                </div>
            </div>

            {{-- ── RIGHT: FORM ── --}}
            <div class="card-form">
                <div class="form-title">Welcome To Libra-Track</div>

                @if ($errors->any())
                    <div class="alert-error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}" required autofocus autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required
                            autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="forgot-row">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-login">Login</button>
                </form>

                @if (Route::has('register'))
                    <div class="signup-link">
                        Don't Have An Account? <a href="{{ route('register') }}">Sign Up</a>
                    </div>
                @endif
            </div>

        </div>
    </div>

</body>

</html>
