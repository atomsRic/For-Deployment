<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Libra-Track')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap"
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
            --bg: #0f1117;
            --bg-2: #161b27;
            --bg-3: #1e2436;
            --surface: rgba(255, 255, 255, 0.04);
            --border: rgba(255, 255, 255, 0.07);
            --border-2: rgba(255, 255, 255, 0.04);
            --text: #f0f2f8;
            --text-2: #a8b0c8;
            --text-3: #5a6380;
            --accent: #f4a261;
            --accent-2: #e76f51;
            --blue: #4f9cf9;
            --green: #2dd4a0;
            --amber: #f4a261;
            --red: #f06a6a;
            --purple: #a78bfa;
            --nav-w: 220px;
            --radius: 14px;
            --radius-sm: 9px;
            --shadow: 0 2px 12px rgba(0, 0, 0, 0.4);
            --shadow-md: 0 8px 32px rgba(0, 0, 0, 0.5);
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
        }

        /* ── SIDEBAR NAV ── */
        .sidenav {
            width: var(--nav-w);
            min-height: 100vh;
            background: var(--bg-2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 200;
            padding: 0 0 1.5rem;
        }

        .sidenav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 1.4rem 1.25rem 1rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 0.75rem;
            text-decoration: none;
        }

        .logo-icon {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(244, 162, 97, 0.35);
        }

        .logo-icon svg {
            width: 17px;
            height: 17px;
            fill: none;
            stroke: #fff;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .brand-text {
            font-family: 'Syne', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.01em;
        }

        .brand-text span {
            color: var(--accent);
        }

        .sidenav-section {
            padding: 0 0.75rem;
            margin-bottom: 0.25rem;
        }

        .sidenav-label {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-3);
            padding: 0.5rem 0.5rem 0.4rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--text-2);
            text-decoration: none;
            transition: all 0.15s;
            margin-bottom: 2px;
        }

        .nav-link svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            opacity: 0.7;
        }

        .nav-link:hover {
            color: var(--text);
            background: var(--surface);
        }

        .nav-link.active {
            color: var(--accent);
            background: rgba(244, 162, 97, 0.1);
        }

        .nav-link.active svg {
            opacity: 1;
        }

        .sidenav-bottom {
            margin-top: auto;
            padding: 0 0.75rem;
            border-top: 1px solid var(--border);
            padding-top: 1rem;
        }

        /* ── TOPBAR ── */
        .topbar {
            height: 58px;
            background: var(--bg-2);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-title {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .badge-role {
            font-size: 0.65rem;
            padding: 3px 9px;
            border-radius: 20px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .badge-admin {
            background: rgba(79, 156, 249, 0.15);
            color: var(--blue);
        }

        .badge-student {
            background: rgba(167, 139, 250, 0.15);
            color: var(--purple);
        }

        /* ── PROFILE AVATAR ── */
        #profile-wrapper {
            position: relative;
            display: inline-block;
        }

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 9px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 30px;
            padding: 4px 12px 4px 4px;
            cursor: pointer;
            transition: all 0.15s;
        }

        .profile-btn:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.12);
        }

        .avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.78rem;
            flex-shrink: 0;
            object-fit: cover;
        }

        .avatar-lg {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            flex-shrink: 0;
            object-fit: cover;
        }

        .profile-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text);
        }

        /* ── PROFILE POPUP ── */
        #profile-panel {
            display: none;
            position: absolute;
            right: 0;
            top: 46px;
            width: 270px;
            background: var(--bg-3);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            z-index: 999;
            padding: 1.25rem;
            animation: fadeIn 0.15s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .panel-user {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1rem;
        }

        .panel-user-name {
            font-weight: 700;
            color: var(--text);
            font-size: 0.9rem;
        }

        .panel-user-role {
            font-size: 0.72rem;
            color: var(--text-3);
            margin-top: 2px;
        }

        .panel-info {
            font-size: 0.78rem;
            color: var(--text-2);
            margin-bottom: 5px;
        }

        .panel-divider {
            height: 1px;
            background: var(--border);
            margin: 10px 0;
        }

        .panel-link {
            display: block;
            font-size: 0.82rem;
            color: var(--accent);
            text-decoration: none;
            margin-bottom: 8px;
            transition: opacity 0.15s;
        }

        .panel-link:hover {
            opacity: 0.75;
        }

        .panel-logout-btn {
            background: none;
            border: none;
            color: var(--red);
            font-size: 0.82rem;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            padding: 0;
            transition: opacity 0.15s;
        }

        .panel-logout-btn:hover {
            opacity: 0.75;
        }

        /* ── MAIN CONTENT ── */
        .page-wrap {
            margin-left: var(--nav-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-wrapper {
            padding: 2rem 1.75rem;
            flex: 1;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 1.25rem;
            font-size: 0.83rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: rgba(45, 212, 160, 0.1);
            color: var(--green);
            border: 1px solid rgba(45, 212, 160, 0.2);
        }

        .alert-error {
            background: rgba(240, 106, 106, 0.1);
            color: var(--red);
            border: 1px solid rgba(240, 106, 106, 0.2);
        }

        .alert-warning {
            background: rgba(244, 162, 97, 0.1);
            color: var(--amber);
            border: 1px solid rgba(244, 162, 97, 0.2);
        }

        /* ── CARDS ── */
        .card {
            background: var(--bg-2);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            padding-bottom: 0.875rem;
            border-bottom: 1px solid var(--border-2);
        }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text);
        }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(155px, 1fr));
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .stat-card {
            background: var(--bg-2);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 1.25rem 1.25rem 1rem;
            transition: transform 0.15s, box-shadow 0.15s;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--stat-color, var(--accent));
            opacity: 0.6;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .stat-label {
            font-size: 0.66rem;
            color: var(--text-3);
            margin-bottom: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .stat-blue {
            color: var(--blue);
            --stat-color: var(--blue);
        }

        .stat-green {
            color: var(--green);
            --stat-color: var(--green);
        }

        .stat-amber {
            color: var(--amber);
            --stat-color: var(--amber);
        }

        .stat-red {
            color: var(--red);
            --stat-color: var(--red);
        }

        .stat-purple {
            color: var(--purple);
            --stat-color: var(--purple);
        }

        /* ── TABLES ── */
        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.83rem;
        }

        thead th {
            background: var(--bg);
            color: var(--text-3);
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            text-align: left;
        }

        tbody td {
            padding: 13px 14px;
            border-bottom: 1px solid var(--border-2);
            color: var(--text-2);
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        /* ── BADGES ── */
        .badge {
            display: inline-block;
            font-size: 0.68rem;
            padding: 3px 9px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        .badge-available {
            background: rgba(45, 212, 160, 0.12);
            color: var(--green);
        }

        .badge-borrowed {
            background: rgba(244, 162, 97, 0.12);
            color: var(--amber);
        }

        .badge-overdue {
            background: rgba(240, 106, 106, 0.12);
            color: var(--red);
        }

        .badge-returned {
            background: rgba(79, 156, 249, 0.12);
            color: var(--blue);
        }

        .badge-unavailable {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-3);
        }

        .badge-admin {
            background: rgba(79, 156, 249, 0.12);
            color: var(--blue);
        }

        .badge-student {
            background: rgba(167, 139, 250, 0.12);
            color: var(--purple);
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 0.81rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--accent);
            color: #1a0f00;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: var(--accent-2);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.07);
            color: var(--text-2);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.11);
        }

        .btn-success {
            background: rgba(45, 212, 160, 0.12);
            color: var(--green);
            border: 1px solid rgba(45, 212, 160, 0.2);
        }

        .btn-success:hover {
            background: rgba(45, 212, 160, 0.2);
        }

        .btn-warning {
            background: rgba(244, 162, 97, 0.12);
            color: var(--amber);
            border: 1px solid rgba(244, 162, 97, 0.2);
        }

        .btn-warning:hover {
            background: rgba(244, 162, 97, 0.22);
        }

        .btn-danger {
            background: rgba(240, 106, 106, 0.1);
            color: var(--red);
            border: 1px solid rgba(240, 106, 106, 0.2);
        }

        .btn-danger:hover {
            background: rgba(240, 106, 106, 0.18);
        }

        .btn-sm {
            padding: 5px 11px;
            font-size: 0.75rem;
        }

        /* ── FORMS ── */
        .form-group {
            margin-bottom: 1.1rem;
        }

        .form-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text-3);
            margin-bottom: 6px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .form-control {
            width: 100%;
            padding: 10px 13px;
            font-size: 0.875rem;
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text);
            transition: border-color 0.15s, box-shadow 0.15s;
            box-sizing: border-box;
            -webkit-appearance: none;
        }

        .form-control::placeholder {
            color: var(--text-3);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(244, 162, 97, 0.12);
        }

        .form-control.is-invalid {
            border-color: var(--red);
        }

        .invalid-feedback {
            color: var(--red);
            font-size: 0.74rem;
            margin-top: 4px;
            font-weight: 500;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        select.form-control option {
            background: var(--bg-3);
            color: var(--text);
        }

        /* ── PAGE HEADER ── */
        .page-header {
            margin-bottom: 1.75rem;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.65rem;
            color: var(--text);
            margin-bottom: 4px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .page-subtitle {
            color: var(--text-3);
            font-size: 0.83rem;
        }

        /* ── SEARCH BAR ── */
        .search-bar {
            display: flex;
            gap: 8px;
            margin-bottom: 1.1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-bar .form-control {
            max-width: 300px;
        }

        /* ── MISC ── */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }

        .empty-cell {
            text-align: center;
            color: var(--text-3);
            padding: 3rem !important;
            font-size: 0.83rem;
        }

        .danger-zone {
            border: 1px solid rgba(240, 106, 106, 0.2);
            border-radius: var(--radius);
            padding: 1rem 1.25rem;
            background: rgba(240, 106, 106, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .danger-zone-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--red);
            margin-bottom: 2px;
        }

        .danger-zone-text {
            font-size: 0.78rem;
            color: rgba(240, 106, 106, 0.6);
        }

        /* ── SIDEBAR LAYOUT (page-level) ── */
        .page-with-sidebar {
            display: flex;
            gap: 1.25rem;
            align-items: flex-start;
        }

        .sidebar {
            width: 210px;
            flex-shrink: 0;
            background: var(--bg-2);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 1rem;
            position: sticky;
            top: 1.5rem;
        }

        .sidebar-title {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--text-3);
            margin-bottom: 0.6rem;
            padding: 0 4px;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 7px 10px;
            border-radius: var(--radius-sm);
            font-size: 0.81rem;
            font-weight: 500;
            color: var(--text-2);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.12s;
            margin-bottom: 2px;
        }

        .sidebar-item:hover {
            background: var(--surface);
        }

        .sidebar-item.active {
            background: rgba(244, 162, 97, 0.1);
            color: var(--accent);
        }

        .sidebar-count {
            font-size: 0.66rem;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.06);
            color: var(--text-3);
            padding: 2px 7px;
            border-radius: 10px;
        }

        .sidebar-item.active .sidebar-count {
            background: rgba(244, 162, 97, 0.15);
            color: var(--accent);
        }

        .sidebar-divider {
            height: 1px;
            background: var(--border);
            margin: 0.75rem 0;
        }

        .content-area {
            flex: 1;
            min-width: 0;
        }
    </style>
</head>

<body>

    {{-- ── SIDE NAVIGATION ── --}}
    <nav class="sidenav">
        <a href="{{ route('home') }}" class="sidenav-brand">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                </svg>
            </div>
            <span class="brand-text"><span>Libra</span>-Track</span>
        </a>

        @auth
            <div class="sidenav-section">
                <div class="sidenav-label">Main</div>
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="9" />
                        <rect x="14" y="3" width="7" height="5" />
                        <rect x="14" y="12" width="7" height="9" />
                        <rect x="3" y="16" width="7" height="5" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('books.index') }}" class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                    </svg>
                    Books
                </a>
                <a href="{{ route('borrows.index') }}"
                    class="nav-link {{ request()->routeIs('borrows.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                    </svg>
                    {{ auth()->user()->isAdmin() ? 'Borrow / Return' : 'My Transactions' }}
                </a>

                @if (auth()->user()->isAdmin())
                    <div class="sidenav-label" style="margin-top:1rem;">Admin</div>
                    <a href="{{ route('users.index') }}"
                        class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                        Students
                    </a>
                    <a href="{{ route('books.create') }}"
                        class="nav-link {{ request()->routeIs('books.create') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="16" />
                            <line x1="8" y1="12" x2="16" y2="12" />
                        </svg>
                        Add Book
                    </a>
                    <a href="{{ route('borrows.create') }}"
                        class="nav-link {{ request()->routeIs('borrows.create') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        New Borrow
                    </a>
                @endif
            </div>

            <div class="sidenav-bottom">
                <a href="{{ route('home') }}" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Home
                </a>
            </div>
        @endauth

        @guest
            <div class="sidenav-section">
                <a href="{{ route('login') }}"
                    class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                <a href="{{ route('register') }}"
                    class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
            </div>
        @endguest
    </nav>

    {{-- ── PAGE WRAP ── --}}
    <div class="page-wrap">

        {{-- ── TOPBAR ── --}}
        <header class="topbar">
            <span class="topbar-title">@yield('topbar-title', 'Libra-Track')</span>

            @auth
                <div class="topbar-right">
                    <span class="badge-role {{ auth()->user()->isAdmin() ? 'badge-admin' : 'badge-student' }}">
                        {{ auth()->user()->isAdmin() ? 'Admin' : 'Student' }}
                    </span>

                    <div id="profile-wrapper">
                        <button class="profile-btn" onclick="toggleProfilePanel()">
                            @if (auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="avatar"
                                    alt="Profile">
                            @else
                                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                            @endif
                            <span class="profile-name">{{ auth()->user()->name }}</span>
                        </button>

                        <div id="profile-panel">
                            <div class="panel-user">
                                @if (auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="avatar-lg"
                                        alt="Profile">
                                @else
                                    <div class="avatar-lg">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                                @endif
                                <div>
                                    <div class="panel-user-name">{{ auth()->user()->name }}</div>
                                    <div class="panel-user-role">{{ ucfirst(auth()->user()->role) }}</div>
                                </div>
                            </div>
                            <div class="panel-info">📧 {{ auth()->user()->email }}</div>
                            @if (auth()->user()->student_id)
                                <div class="panel-info">🪪 ID: {{ auth()->user()->student_id }}</div>
                            @endif
                            <div class="panel-divider"></div>
                            <a href="{{ route('profile.edit') }}" class="panel-link">✏️ Edit Profile</a>
                            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                @csrf
                                <button type="submit" class="panel-logout-btn">🚪 Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
        </header>

        {{-- ── CONTENT ── --}}
        <div class="main-wrapper">
            @if (session('success'))
                <div class="alert alert-success">✓ {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">✕ {{ session('error') }}</div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning">⚠ {{ session('warning') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        function toggleProfilePanel() {
            const panel = document.getElementById('profile-panel');
            panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
        }
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('profile-wrapper');
            const panel = document.getElementById('profile-panel');
            if (panel && wrapper && !wrapper.contains(e.target)) {
                panel.style.display = 'none';
            }
        });
    </script>

</body>

</html>
