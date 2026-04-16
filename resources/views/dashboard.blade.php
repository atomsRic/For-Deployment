@extends('layouts.app')
@section('title', 'Dashboard — Libra-Track')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    {{-- Supports both full_name and name column --}}
    <p class="page-subtitle">
        Welcome back, {{ auth()->user()->full_name ?? auth()->user()->name ?? 'User' }}!
        @if(auth()->user()->last_login ?? false)
            &nbsp;·&nbsp; Last login: {{ \Carbon\Carbon::parse(auth()->user()->last_login)->diffForHumans() }}
        @endif
    </p>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Books</div>
        <div class="stat-value stat-blue">{{ $totalBooks }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Available</div>
        <div class="stat-value stat-green">{{ $availableBooks }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Borrowed</div>
        <div class="stat-value stat-amber">{{ $borrowedBooks }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Overdue</div>
        <div class="stat-value stat-red">{{ $overdueBooks }}</div>
    </div>
    @if(auth()->user()->isAdmin() && isset($totalUsers))
    <div class="stat-card">
        <div class="stat-label">Total Users</div>
        <div class="stat-value stat-purple">{{ $totalUsers }}</div>
    </div>
    @endif
</div>

{{-- Recent Borrows --}}
<div class="card">
    <div class="card-header">
        <div class="card-title">Recent Borrowing Activity</div>
        <a href="{{ route('borrows.index') }}" class="btn btn-sm btn-secondary">View All</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Borrower</th>
                    <th>Book Title</th>
                    <th>Added By</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBorrows as $borrow)
                <tr>
                    <td>{{ $borrow->user->full_name ?? $borrow->user->name ?? $borrow->borrower_name ?? '—' }}</td>
                    <td>{{ $borrow->book->title ?? '—' }}</td>
                    <td style="color: rgba(200,215,235,0.55); font-size:0.8rem;">
                        {{ $borrow->book->addedBy->full_name ?? $borrow->book->addedBy->name ?? '—' }}
                    </td>
                    <td>{{ $borrow->borrow_date->format('M d, Y') }}</td>
                    <td>{{ $borrow->due_date->format('M d, Y') }}</td>
                    <td>
                        <span class="badge badge-{{ $borrow->status }}">
                            {{ ucfirst($borrow->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="empty-cell">No borrow records yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Quick Actions --}}
<div class="card">
    <div class="card-title" style="margin-bottom:1rem;">Quick Actions</div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Browse Books</a>
        <a href="{{ route('borrows.create') }}" class="btn btn-primary">+ New Borrow</a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('books.create') }}" class="btn btn-success">+ Add Book</a>
            <a href="{{ route('users.index') }}" class="btn btn-warning">Manage Users</a>
        @endif
    </div>
</div>
@endsection