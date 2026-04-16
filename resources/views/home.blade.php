@extends('layouts.app')
@section('title', 'Home — Library Management System')

@section('content')
<div style="text-align:center; padding: 4rem 1rem;">
    <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
    <h1 style="font-size: 2.5rem; font-weight: 700; color: #0f172a; margin-bottom: 1rem;">
        Library Management System
    </h1>
    <p style="font-size: 1.1rem; color: #64748b; max-width: 500px; margin: 0 auto 2rem;">
        Manage books, track borrowing records, and keep your library organized — all in one place.
    </p>
    @auth
        <a href="{{ route('dashboard') }}" class="btn btn-primary" style="font-size:1rem; padding: 12px 28px;">
            Go to Dashboard
        </a>
    @else
        <div style="display:flex; gap:12px; justify-content:center;">
            <a href="{{ route('login') }}" class="btn btn-primary" style="font-size:1rem; padding: 12px 28px;">
                Sign In
            </a>
            <a href="{{ route('register') }}" class="btn btn-secondary" style="font-size:1rem; padding: 12px 28px;">
                Register
            </a>
        </div>
    @endauth
</div>

<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap:1.5rem; margin-top:2rem;">
    <div class="card" style="text-align:center;">
        <div style="font-size:2rem; margin-bottom:0.5rem;">🔍</div>
        <h3 style="font-weight:600; color:#1e293b; margin-bottom:6px;">Browse Books</h3>
        <p style="color:#64748b; font-size:0.875rem;">Search and explore our complete book catalog.</p>
    </div>
    <div class="card" style="text-align:center;">
        <div style="font-size:2rem; margin-bottom:0.5rem;">📋</div>
        <h3 style="font-weight:600; color:#1e293b; margin-bottom:6px;">Track Borrowing</h3>
        <p style="color:#64748b; font-size:0.875rem;">Manage borrow and return transactions with ease.</p>
    </div>
    <div class="card" style="text-align:center;">
        <div style="font-size:2rem; margin-bottom:0.5rem;">🔒</div>
        <h3 style="font-weight:600; color:#1e293b; margin-bottom:6px;">Secure Access</h3>
        <p style="color:#64748b; font-size:0.875rem;">Role-based access for Admins and Users.</p>
    </div>
</div>
@endsection
