<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Libra-Track</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=1600&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(5, 10, 20, 0.50);
            z-index: 0;
        }
        .page {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            min-height: 100vh;
            padding: 0 6%;
        }
        .left-pane { flex: 1; max-width: 460px; padding-right: 2rem; }
        .brand-heading {
            font-size: clamp(1.9rem, 3.5vw, 2.8rem);
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 1rem;
            letter-spacing: -0.01em;
        }
        .brand-sub { font-size: 0.95rem; font-weight: 300; color: rgba(255,255,255,0.55); }
        .right-pane { flex-shrink: 0; }
        .auth-card {
            width: 340px;
            background: rgba(13, 22, 38, 0.92);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 10px;
            padding: 2.5rem 2rem 2rem;
            box-shadow: 0 24px 64px rgba(0,0,0,0.6);
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #ffffff;
            text-align: center;
            margin-bottom: 2rem;
        }
        .alert-error-box {
            background: rgba(220,50,50,0.15);
            color: #fca5a5;
            border: 1px solid rgba(220,50,50,0.3);
            border-radius: 6px;
            padding: 9px 13px;
            margin-bottom: 1.25rem;
            font-size: 0.8rem;
        }
        .form-group { margin-bottom: 1.75rem; }
        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 500;
            color: #4da6ff;
            margin-bottom: 8px;
        }
        .form-control {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1.5px solid rgba(255,255,255,0.22);
            border-radius: 0;
            padding: 5px 0 9px;
            font-size: 0.92rem;
            font-family: 'Inter', sans-serif;
            font-weight: 300;
            color: #ffffff;
            outline: none;
            transition: border-color 0.2s;
            caret-color: #4da6ff;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.18); }
        .form-control:focus { border-bottom-color: #4da6ff; }
        .form-control.is-invalid { border-bottom-color: #f87171; }
        .invalid-feedback { color: #fca5a5; font-size: 0.75rem; margin-top: 5px; }
        .btn-submit {
            width: 100%;
            padding: 11px 16px;
            background: #1a7fc4;
            color: #ffffff;
            border: none;
            border-radius: 25px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: 0.02em;
            cursor: pointer;
            margin-top: 0.25rem;
            transition: background 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .btn-submit:hover { background: #1567a8; box-shadow: 0 6px 20px rgba(26,127,196,0.4); }
        .auth-footer {
            text-align: center;
            font-size: 0.78rem;
            font-weight: 300;
            color: rgba(255,255,255,0.38);
            margin-top: 1.5rem;
        }
        .auth-link { color: #4da6ff; font-weight: 400; text-decoration: none; display: block; margin-top: 4px; }
        .auth-link:hover { text-decoration: underline; }
        @media (max-width: 700px) {
            .page { flex-direction: column; justify-content: center; gap: 2.5rem; padding: 3rem 6%; }
            .left-pane { max-width: 100%; padding-right: 0; text-align: center; }
            .auth-card { width: 100%; max-width: 360px; }
        }
    </style>
</head>
<body>
<div class="page">
    <div class="left-pane">
        <h1 class="brand-heading">Welcome to<br>Libra-Track</h1>
        <p class="brand-sub">Log in to continue...</p>
    </div>
    <div class="right-pane">
        <div class="auth-card">
            <div class="card-title">Log in</div>

            @if($errors->any())
                <div class="alert-error-box">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="you@example.com"
                           value="{{ old('email') }}" required autofocus>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn-submit">Log in &nbsp;»</button>
            </form>

            <div class="auth-footer">
                Don't have an account?
                <a href="{{ route('register') }}" class="auth-link">Sign up now</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>