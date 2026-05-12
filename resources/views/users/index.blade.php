@extends('layouts.app')
@section('title', 'Students — Libra-Track')
@section('topbar-title', 'Students')

@section('content')
<div class="page-header">
    <h1 class="page-title">Students</h1>
    <p class="page-subtitle">Manage all registered students and administrators.</p>
</div>

<div class="card" style="padding:0; overflow:hidden;">
    <div style="padding:1rem 1.25rem; border-bottom:1px solid var(--border-2); display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
        <span class="card-title">
            All Users
            <span style="font-weight:400; color:var(--text-3); font-size:0.8rem; margin-left:6px;">{{ $users->total() }} total</span>
        </span>
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            <form method="GET" action="{{ route('users.index') }}" style="display:flex; gap:8px;">
                <input type="text" name="search" class="form-control"
                       placeholder="Search name, email, student ID..."
                       value="{{ request('search') }}"
                       style="width:260px; padding:7px 12px; font-size:0.8rem;">
                <button type="submit" class="btn btn-secondary btn-sm">Search</button>
                @if(request('search'))
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">✕</a>
                @endif
            </form>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">+ Add Student</a>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Student ID</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:var(--text-3); font-size:0.76rem;">{{ $user->id }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:9px;">
                            <div style="width:30px; height:30px; border-radius:50%; background:linear-gradient(135deg,var(--accent),var(--accent-2)); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.75rem; flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span style="font-weight:600; color:var(--text);">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="font-family:monospace; font-size:0.8rem; color:var(--text-3);">{{ $user->student_id ?? '—' }}</td>
                    <td style="color:var(--text-3); font-size:0.82rem;">{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-student' }}">
                            {{ $user->role === 'admin' ? 'Admin' : 'Student' }}
                        </span>
                    </td>
                    <td style="font-size:0.79rem; color:var(--text-3);">{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex; gap:5px; align-items:center;">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                      onsubmit="return confirm('Delete {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @else
                                <span style="font-size:0.72rem; color:var(--text-3); font-style:italic; padding:5px 8px;">You</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-cell">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="pagination-wrap" style="padding:1rem;">
        {{ $users->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection