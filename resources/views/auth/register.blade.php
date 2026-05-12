<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Libra-Track</title>
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
            --blue: #4f9cf9;
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
            height: 580px;
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

        .card-image-top {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 1.25rem;
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

        .card-image-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.25rem;
            z-index: 2;
        }

        .branding-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.5rem;
            font-weight: 900;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            line-height: 1.1;
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.5);
        }

        .branding-title span {
            color: var(--accent);
        }

        .branding-sub {
            font-size: 0.72rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* ── RIGHT FORM PANEL ── */
        .card-form {
            padding: 2rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 580px;
            overflow-y: auto;
        }

        .form-title {
            font-family: 'Barlow', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1.25rem;
            letter-spacing: -0.01em;
        }

        /* ── ROLE SELECTOR ── */
        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 1rem;
        }

        .role-btn {
            padding: 9px 10px;
            border-radius: 9px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            color: rgba(255, 255, 255, 0.45);
            font-family: 'Barlow', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            text-align: center;
            letter-spacing: 0.02em;
        }

        .role-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .role-btn.active-student {
            background: rgba(244, 162, 97, 0.12);
            border-color: var(--accent);
            color: var(--accent);
        }

        .role-btn.active-admin {
            background: rgba(79, 156, 249, 0.12);
            border-color: var(--blue);
            color: var(--blue);
        }

        /* Fields */
        .form-group {
            margin-bottom: 0.75rem;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            font-size: 0.855rem;
            font-family: 'Barlow', sans-serif;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 9px;
            color: #fff;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(244, 162, 97, 0.1);
            background: rgba(255, 255, 255, 0.07);
        }

        .form-control.is-invalid {
            border-color: var(--red);
        }

        .invalid-feedback {
            color: var(--red);
            font-size: 0.72rem;
            margin-top: 4px;
        }

        /* Hidden fields */
        .conditional-field {
            visibility: hidden;
            opacity: 0;
            height: 0;
            overflow: hidden;
            margin: 0 !important;
            transition: opacity 0.2s;
        }

        .conditional-field.visible {
            visibility: visible;
            opacity: 1;
            height: auto;
            margin-bottom: 0.75rem !important;
        }

        /* Admin code field special styling */
        .admin-code-wrap .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(79, 156, 249, 0.1);
        }

        .admin-code-hint {
            font-size: 0.7rem;
            color: rgba(79, 156, 249, 0.6);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #1a0f00;
            font-family: 'Barlow', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            border: none;
            border-radius: 9px;
            cursor: pointer;
            transition: opacity 0.15s, transform 0.15s;
            margin-top: 0.75rem;
        }

        .btn-register:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }

        .alert-error {
            background: rgba(240, 106, 106, 0.08);
            border: 1px solid rgba(240, 106, 106, 0.2);
            color: var(--red);
            padding: 10px 14px;
            border-radius: 9px;
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }

        .login-link {
            text-align: center;
            font-size: 0.79rem;
            color: rgba(255, 255, 255, 0.35);
            margin-top: 1rem;
        }

        .login-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 680px) {
            .login-card {
                grid-template-columns: 1fr;
            }

            .card-image {
                min-height: 180px;
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
                    <div class="branding-title"><span>Libra</span>-Track</div>
                    <div class="branding-sub">Library Management System</div>
                </div>
            </div>

            {{-- ── RIGHT: FORM ── --}}
            <div class="card-form">
                <div class="form-title">Create Account</div>

                @if ($errors->any())
                    <div class="alert-error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Hidden role input (updated by JS) --}}
                    <input type="hidden" name="role" id="role-input" value="{{ old('role', 'student') }}">

                    {{-- Role Selector --}}
                    <div class="role-selector" style="margin-bottom:1rem;">
                        <button type="button" id="btn-student"
                            class="role-btn {{ old('role', 'student') === 'student' ? 'active-student' : '' }}"
                            onclick="selectRole('student')">
                            🎓 Student
                        </button>
                        <button type="button" id="btn-admin"
                            class="role-btn {{ old('role') === 'admin' ? 'active-admin' : '' }}"
                            onclick="selectRole('admin')">
                            🔑 Admin
                        </button>
                    </div>

                    {{-- Name --}}
                    <div class="form-group">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Student ID (only for students) --}}
                    <div class="form-group conditional-field {{ old('role', 'student') === 'student' ? 'visible' : '' }}"
                        id="student-id-field">
                        <input type="text" name="student_id"
                            class="form-control @error('student_id') is-invalid @enderror"
                            placeholder="Student ID (e.g. 2024-00123)" value="{{ old('student_id') }}">
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email Address (e.g. juan@example.com)" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password (min. 8 characters)" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-group">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm Password" required>
                    </div>

                    {{-- Admin Secret Code (only for admin) --}}
                    <div class="form-group conditional-field admin-code-wrap {{ old('role') === 'admin' ? 'visible' : '' }}"
                        id="admin-code-field">
                        <input type="password" name="admin_code"
                            class="form-control @error('admin_code') is-invalid @enderror"
                            placeholder="Admin Secret Code">
                        @error('admin_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="admin-code-hint">🔒 Enter the admin secret code provided by your administrator</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-register">Create Account</button>
                </form>

                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Sign In</a>
                </div>
            </div>

        </div>
    </div>

    <script>
        function selectRole(role) {
            const studentBtn = document.getElementById('btn-student');
            const adminBtn = document.getElementById('btn-admin');
            const roleInput = document.getElementById('role-input');
            const studentField = document.getElementById('student-id-field');
            const adminField = document.getElementById('admin-code-field');

            roleInput.value = role;

            if (role === 'student') {
                studentBtn.className = 'role-btn active-student';
                adminBtn.className = 'role-btn';
                studentField.classList.add('visible');
                adminField.classList.remove('visible');
            } else {
                adminBtn.className = 'role-btn active-admin';
                studentBtn.className = 'role-btn';
                adminField.classList.add('visible');
                studentField.classList.remove('visible');
            }
        }

        // Set initial state on page load
        selectRole('{{ old('role', 'student') }}');
    </script>

</body>

</html>
