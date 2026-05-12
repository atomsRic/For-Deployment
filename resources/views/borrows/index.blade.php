@extends('layouts.app')
@section('title', 'Borrow / Return — Libra-Track')
@section('topbar-title', auth()->user()->isAdmin() ? 'Borrow / Return' : 'My Transactions')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ auth()->user()->isAdmin() ? 'Borrow / Return' : 'My Transactions' }}</h1>
    <p class="page-subtitle">
        {{ auth()->user()->isAdmin() ? 'Manage all borrow and return transactions.' : 'View the status of your borrowed books.' }}
    </p>
</div>

<div class="page-with-sidebar">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar">
        <div class="sidebar-title">Status</div>
        <a href="{{ request()->fullUrlWithQuery(['status' => '', 'page' => 1]) }}"
            class="sidebar-item {{ !request('status') ? 'active' : '' }}">
            All <span class="sidebar-count">{{ $counts['all'] }}</span>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['status' => 'borrowed', 'page' => 1]) }}"
            class="sidebar-item {{ request('status') === 'borrowed' ? 'active' : '' }}">
            Borrowed <span class="sidebar-count">{{ $counts['borrowed'] ?? 0 }}</span>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['status' => 'overdue', 'page' => 1]) }}"
            class="sidebar-item {{ request('status') === 'overdue' ? 'active' : '' }}"
            style="{{ ($counts['overdue'] ?? 0) > 0 ? 'color:var(--red);' : '' }}">
            Overdue
            <span class="sidebar-count"
                style="{{ ($counts['overdue'] ?? 0) > 0 ? 'background:rgba(240,106,106,0.12);color:var(--red);' : '' }}">
                {{ $counts['overdue'] ?? 0 }}
            </span>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['status' => 'returned', 'page' => 1]) }}"
            class="sidebar-item {{ request('status') === 'returned' ? 'active' : '' }}">
            Returned <span class="sidebar-count">{{ $counts['returned'] ?? 0 }}</span>
        </a>
    </aside>

    {{-- ── CONTENT ── --}}
    <div class="content-area">
        <div class="card" style="padding:0; overflow:hidden;">
            <div style="padding:1rem 1.25rem; border-bottom:1px solid var(--border-2); display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
                <span class="card-title">
                    {{ request('status') ? ucfirst(request('status')) : 'All Transactions' }}
                    <span style="font-weight:400; color:var(--text-3); font-size:0.8rem; margin-left:6px;">
                        {{ $borrows->total() }} {{ Str::plural('record', $borrows->total()) }}
                    </span>
                </span>
                <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                    @if(auth()->user()->isAdmin())
                        <form method="GET" action="{{ route('borrows.index') }}" style="display:flex; gap:8px;">
                            <input type="hidden" name="status" value="{{ request('status') }}">
                            <input type="text" name="search" class="form-control"
                                   placeholder="Search student or book..."
                                   value="{{ request('search') }}"
                                   style="width:230px; padding:7px 12px; font-size:0.8rem;">
                            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
                            @if(request('search'))
                                <a href="{{ request()->fullUrlWithQuery(['search' => '']) }}" class="btn btn-sm btn-secondary">✕</a>
                            @endif
                        </form>
                        <a href="{{ route('borrows.create') }}" class="btn btn-primary btn-sm">+ New Borrow</a>
                    @endif
                </div>
            </div>

            <div class="table-wrap">
                <table style="min-width:700px;">
                    <thead>
                        <tr>
                            @if(auth()->user()->isAdmin()) <th>Student</th> @endif
                            <th>Book Title</th>
                            <th>Borrow Date</th>
                            <th>Due Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                            @if(auth()->user()->isAdmin()) <th style="width:160px;">Actions</th> @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrows as $borrow)
                        <tr>
                            @if(auth()->user()->isAdmin())
                                <td style="font-weight:600; color:var(--text);">{{ $borrow->user->name ?? '—' }}</td>
                            @endif
                            <td>{{ $borrow->book->title ?? '—' }}</td>
                            <td style="font-size:0.8rem; color:var(--text-3);">{{ $borrow->borrow_date->format('M d, Y') }}</td>
                            <td style="font-size:0.8rem; {{ $borrow->status === 'overdue' ? 'color:var(--red); font-weight:600;' : 'color:var(--text-3);' }}">
                                {{ $borrow->due_date->format('M d, Y') }}
                            </td>
                            <td style="font-size:0.8rem; color:var(--text-3);">
                                {{ $borrow->return_date ? $borrow->return_date->format('M d, Y') : '—' }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $borrow->status }}">{{ ucfirst($borrow->status) }}</span>
                            </td>
                            @if(auth()->user()->isAdmin())
                            <td style="white-space:nowrap;">
                                <div style="display:flex; gap:5px;">
                                    @if($borrow->status === 'borrowed' || $borrow->status === 'overdue')
                                        <form method="POST" action="{{ route('borrows.return', $borrow->id) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">✓ Return</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('borrows.destroy', $borrow->id) }}"
                                          onsubmit="return confirm('Delete this transaction?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? 7 : 5 }}" class="empty-cell">
                                No {{ request('status') ?? '' }} transactions found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($borrows->hasPages())
            <div class="pagination-wrap" style="padding:1rem;">
                {{ $borrows->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection