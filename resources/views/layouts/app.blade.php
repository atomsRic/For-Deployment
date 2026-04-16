<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Libra-Track')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue:        #1a7fc4;
            --blue-light:  #4da6ff;
            --blue-hover:  #1567a8;
            --card-bg:     rgba(13, 22, 38, 0.78);
            --card-border: rgba(255,255,255,0.07);
            --text:        #f0f4f8;
            --text-muted:  rgba(200,215,235,0.55);
            --nav-h:       58px;
        }

        html, body { height: 100%; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background-color: #060d18;
            background-image: url('https://png.pngtree.com/background/20250205/original/pngtree-grand-library-interior-with-bookcases-and-wooden-floor-stock-photo-picture-image_15776507.jpg');
            background-size: cover;
            background-position: center top;
            background-attachment: fixed;
            color: var(--text);
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(4, 10, 22, 0.62);
            z-index: 0;
            pointer-events: none;
        }

        /* ── NAVBAR ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            height: var(--nav-h);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            background: rgba(8, 16, 30, 0.82);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        /* ── Minimal book logo ── */
        .navbar-brand {
            color: #ffffff;
            font-size: 1.05rem;
            font-weight: 600;
            text-decoration: none;
            margin-right: 2.5rem;
            letter-spacing: 0.02em;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-brand .logo-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background: var(--blue);
            border-radius: 6px;
            flex-shrink: 0;
        }
        .navbar-brand .logo-icon svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: #fff;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        .navbar-brand .brand-text { color: #ffffff; }
        .navbar-brand .brand-text span { color: var(--blue-light); }

        .navbar-nav { display: flex; align-items: center; flex: 1; }

        .nav-link {
            color: var(--text-muted);
            text-decoration: none;
            padding: 0 1rem;
            height: var(--nav-h);
            display: inline-flex;
            align-items: center;
            font-size: 0.82rem;
            font-weight: 400;
            letter-spacing: 0.03em;
            border-bottom: 2px solid transparent;
            transition: color 0.15s, border-color 0.15s;
            white-space: nowrap;
        }
        .nav-link:hover { color: #fff; }
        .nav-link.active { color: #fff; border-bottom-color: var(--blue-light); font-weight: 500; }

        .navbar-right { display: flex; align-items: center; gap: 10px; margin-left: auto; }

        .badge-role {
            font-size: 0.68rem;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 500;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .badge-admin  { background: rgba(77,166,255,0.15);  color: var(--blue-light); border: 1px solid rgba(77,166,255,0.25); }
        .badge-member { background: rgba(167,139,250,0.12); color: #c4b5fd; border: 1px solid rgba(167,139,250,0.2); }

        .user-name { color: rgba(200,215,235,0.7); font-size: 0.82rem; font-weight: 300; }

        .btn-logout {
            font-size: 0.78rem;
            padding: 5px 14px;
            background: rgba(255,255,255,0.06);
            color: rgba(200,215,235,0.7);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-logout:hover { background: rgba(255,255,255,0.1); color: #fff; }

        /* ── MAIN ── */
        .main-wrapper {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 11px 15px;
            border-radius: 6px;
            margin-bottom: 1.25rem;
            font-size: 0.83rem;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(8px);
        }
        .alert-success { background: rgba(21,128,61,0.18); color: #86efac; border: 1px solid rgba(21,128,61,0.3); }
        .alert-error   { background: rgba(185,28,28,0.18); color: #fca5a5; border: 1px solid rgba(185,28,28,0.3); }
        .alert-warning { background: rgba(180,83,9,0.18);  color: #fcd34d; border: 1px solid rgba(180,83,9,0.3); }

        /* ── CARDS ── */
        .card {
            background: var(--card-bg);
            backdrop-filter: blur(18px) saturate(1.2);
            -webkit-backdrop-filter: blur(18px) saturate(1.2);
            border: 1px solid var(--card-border);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .card-title { font-size: 0.95rem; font-weight: 600; color: #fff; letter-spacing: 0.01em; }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(155px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background: var(--card-bg);
            backdrop-filter: blur(18px) saturate(1.2);
            -webkit-backdrop-filter: blur(18px) saturate(1.2);
            border: 1px solid var(--card-border);
            border-radius: 10px;
            padding: 1.25rem;
            box-shadow: 0 8px 24px rgba(0,0,0,0.25);
            transition: transform 0.18s, box-shadow 0.18s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(0,0,0,0.35); }
        .stat-label { font-size: 0.68rem; color: var(--text-muted); margin-bottom: 8px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.1em; }
        .stat-value { font-size: 2.1rem; font-weight: 700; }
        .stat-blue   { color: var(--blue-light); }
        .stat-green  { color: #86efac; }
        .stat-amber  { color: #fcd34d; }
        .stat-red    { color: #fca5a5; }
        .stat-purple { color: #c4b5fd; }

        /* ── TABLES — bright text so it's readable ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.84rem; }
        thead th {
            background: rgba(255,255,255,0.05);
            color: rgba(200,215,235,0.65);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 10px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            text-align: left;
        }
        tbody td {
            padding: 13px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            /* ↓ bright white so it's always readable over the dark card */
            color: #e8f0fb;
            vertical-align: middle;
            font-weight: 400;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: rgba(255,255,255,0.04); }

        /* ── BADGES ── */
        .badge { display: inline-block; font-size: 0.7rem; padding: 3px 10px; border-radius: 20px; font-weight: 500; }
        .badge-available   { background: rgba(21,128,61,0.25);    color: #86efac; border: 1px solid rgba(21,128,61,0.4); }
        .badge-borrowed    { background: rgba(180,83,9,0.25);     color: #fcd34d; border: 1px solid rgba(180,83,9,0.4); }
        .badge-overdue     { background: rgba(185,28,28,0.25);    color: #fca5a5; border: 1px solid rgba(185,28,28,0.4); }
        .badge-returned    { background: rgba(3,105,161,0.25);    color: #7dd3fc; border: 1px solid rgba(3,105,161,0.4); }
        .badge-unavailable { background: rgba(255,255,255,0.06);  color: rgba(200,215,235,0.6); border: 1px solid rgba(255,255,255,0.1); }
        .badge-admin       { background: rgba(77,166,255,0.18);   color: var(--blue-light); border: 1px solid rgba(77,166,255,0.3); }
        .badge-member      { background: rgba(167,139,250,0.15);  color: #c4b5fd; border: 1px solid rgba(167,139,250,0.25); }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: 6px;
            font-size: 0.82rem; font-weight: 500;
            border: 1px solid transparent; cursor: pointer;
            text-decoration: none; font-family: 'Inter', sans-serif;
            transition: all 0.15s;
        }
        .btn-primary   { background: var(--blue);  color: #fff; border-color: var(--blue); }
        .btn-primary:hover { background: var(--blue-hover); }
        .btn-secondary { background: rgba(255,255,255,0.08); color: #e8f0fb; border-color: rgba(255,255,255,0.12); }
        .btn-secondary:hover { background: rgba(255,255,255,0.13); }
        .btn-success   { background: rgba(21,128,61,0.25);  color: #86efac; border-color: rgba(21,128,61,0.4); }
        .btn-success:hover { background: rgba(21,128,61,0.35); }
        .btn-warning   { background: rgba(180,83,9,0.25);   color: #fcd34d; border-color: rgba(180,83,9,0.4); }
        .btn-warning:hover { background: rgba(180,83,9,0.35); }
        .btn-danger    { background: rgba(185,28,28,0.2);   color: #fca5a5; border-color: rgba(185,28,28,0.35); }
        .btn-danger:hover { background: rgba(185,28,28,0.32); }
        .btn-sm { padding: 5px 10px; font-size: 0.78rem; }

        /* ── FORMS ── */
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: 0.75rem; font-weight: 500; color: var(--blue-light); margin-bottom: 6px; letter-spacing: 0.03em; }
        .form-control {
            width: 100%; padding: 9px 13px; font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 6px; color: #e8f0fb;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }
        .form-control::placeholder { color: rgba(200,215,235,0.28); }
        .form-control:focus {
            outline: none;
            border-color: var(--blue-light);
            box-shadow: 0 0 0 3px rgba(77,166,255,0.12);
            background: rgba(255,255,255,0.09);
        }
        .form-control.is-invalid { border-color: #f87171; }
        .invalid-feedback { color: #fca5a5; font-size: 0.75rem; margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }

        /* ── PAGE HEADER ── */
        .page-header { margin-bottom: 1.5rem; }
        .page-title { font-size: 1.6rem; font-weight: 700; color: #fff; margin-bottom: 4px; letter-spacing: -0.01em; }
        .page-subtitle { color: rgba(200,215,235,0.65); font-size: 0.875rem; font-weight: 300; }

        /* ── MISC ── */
        .pagination-wrap { display: flex; justify-content: center; margin-top: 1rem; }
        .search-bar { display: flex; gap: 10px; margin-bottom: 1.25rem; align-items: center; flex-wrap: wrap; }
        .search-bar .form-control { max-width: 300px; }
        .empty-cell { text-align: center; color: var(--text-muted); padding: 2rem !important; font-style: italic; }

        .danger-zone {
            border: 1px solid rgba(185,28,28,0.3);
            border-radius: 8px;
            padding: 1rem 1.25rem;
            background: rgba(185,28,28,0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .danger-zone-text  { font-size: 0.83rem; color: rgba(252,165,165,0.8); }
        .danger-zone-title { font-size: 0.88rem; font-weight: 600; color: #fca5a5; margin-bottom: 2px; }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="navbar-brand">
        {{-- Minimal book SVG logo --}}
        <div class="logo-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
        </div>
        <span class="brand-text"><span>Libra</span>-Track</span>
    </a>

    <div class="navbar-nav">
        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

        @auth
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('books.index') }}" class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}">Books</a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('books.create') }}" class="nav-link {{ request()->routeIs('books.create') ? 'active' : '' }}">Add Book</a>
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">Users</a>
        @endif
        <a href="{{ route('borrows.index') }}" class="nav-link {{ request()->routeIs('borrows.*') ? 'active' : '' }}">Borrow / Return</a>
        @endauth

        @guest
        <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
        <a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
        @endguest
    </div>

    @auth
    <div class="navbar-right">
        <span class="badge-role {{ auth()->user()->isAdmin() ? 'badge-admin' : 'badge-member' }}">
            {{ ucfirst(auth()->user()->role) }}
        </span>
        {{-- Supports both 'name' and 'full_name' column names --}}
        <span class="user-name">
            {{ auth()->user()->full_name ?? auth()->user()->name ?? 'User' }}
        </span>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
    @endauth
</nav>

<div class="main-wrapper">
    @if(session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">✕ {{ session('error') }}</div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning">⚠ {{ session('warning') }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>