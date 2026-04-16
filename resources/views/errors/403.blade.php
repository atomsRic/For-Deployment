@extends('layouts.app')
@section('title', '403 Unauthorized — Library Management System')

@section('content')
<div style="text-align:center; padding: 4rem 1rem;">
    <div style="font-size: 4rem; margin-bottom: 1rem;">🔒</div>
    <h1 style="font-size: 2rem; font-weight: 700; color: #b91c1c; margin-bottom: 0.75rem;">
        Access Denied
    </h1>
    <p style="font-size: 1rem; color: #64748b; max-width: 420px; margin: 0 auto 2rem;">
        You do not have permission to access this page.
        This area is restricted to <strong>Admin</strong> users only.
    </p>
    <div style="display:flex; gap:12px; justify-content:center;">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">View Books</a>
    </div>
</div>
@endsection
