@extends('layouts.app')
@section('title', 'User Management — Libra-Track')

@section('content')
<div class="page-header">
    <h1 class="page-title">User Management</h1>
    <p class="page-subtitle">Manage all registered members and administrators.</p>
</div>

{{-- Search + Add --}}
<div class="search-bar">
    <form method="GET" action="{{ route('users.index') }}" style="display:flex; gap:10px; flex:1; flex-wrap:wrap;">
        <input type="text" name="search" class="form-control"
               placeholder="Search by name, username or email..."
               value="{{ request('search') }}"
               style="max-width:320px;">
        <button type="submit" class="btn btn-secondary">Search</button>
        @if(request('search'))
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Clear</a>
        @endif
    </form>
    <a href="{{ route('users.create') }}" class="btn btn-primary">+ Add User</a>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">All Users</div>
        <span style="font-size:0.78rem; color:var(--text-muted);">{{ $users->total() }} total</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Last Login</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:var(--text-muted); font-size:0.78rem;">{{ $user->id }}</td>
                    <td style="font-weight:500;">{{ $user->full_name }}</td>
                    <td style="color:var(--text-muted);">@{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-member' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="font-size:0.8rem; color:var(--text-muted);">
                        {{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->diffForHumans() : 'Never' }}
                    </td>
                    <td style="font-size:0.8rem; color:var(--text-muted);">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            {{-- Cannot delete own account (business rule) --}}
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                      onsubmit="return confirm('Delete {{ $user->full_name }}? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @else
                                <span style="font-size:0.72rem; color:var(--text-muted); padding: 5px 8px; font-style:italic;">You</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="empty-cell">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
    <div class="pagination-wrap" style="margin-top:1.25rem;">
        {{ $users->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
