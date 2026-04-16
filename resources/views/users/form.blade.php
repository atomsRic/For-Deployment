@extends('layouts.app')
@section('title', isset($user) ? 'Edit User — Libra-Track' : 'Add User — Libra-Track')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($user) ? 'Edit User' : 'Add New User' }}</h1>
    <p class="page-subtitle">
        {{ isset($user) ? 'Update account details and role for ' . $user->full_name . '.' : 'Create a new member or admin account.' }}
    </p>
</div>

<div class="card" style="max-width: 620px;">
    <div class="card-header">
        <div class="card-title">{{ isset($user) ? 'Account Details' : 'New Account' }}</div>
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">← Back to Users</a>
    </div>

    <form method="POST"
          action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}">
        @csrf
        @if(isset($user)) @method('PUT') @endif

        {{-- Full Name --}}
        <div class="form-group">
            <label class="form-label" for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name"
                   class="form-control @error('full_name') is-invalid @enderror"
                   placeholder="Juan dela Cruz"
                   value="{{ old('full_name', $user->full_name ?? '') }}" required>
            @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Username --}}
        <div class="form-group">
            <label class="form-label" for="username">Username</label>
            <input type="text" id="username" name="username"
                   class="form-control @error('username') is-invalid @enderror"
                   placeholder="juandelacruz"
                   value="{{ old('username', $user->username ?? '') }}" required>
            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" id="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="you@example.com"
                   value="{{ old('email', $user->email ?? '') }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Role --}}
        <div class="form-group">
            <label class="form-label" for="role">Role</label>
            <select id="role" name="role"
                    class="form-control @error('role') is-invalid @enderror">
                <option value="member"  {{ old('role', $user->role ?? 'member') === 'member'  ? 'selected' : '' }}>Member</option>
                <option value="admin"   {{ old('role', $user->role ?? '')        === 'admin'   ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Password (required only on create, optional on edit) --}}
        <div class="form-group">
            <label class="form-label" for="password">
                Password {{ isset($user) ? '(leave blank to keep current)' : '' }}
            </label>
            <input type="password" id="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="{{ isset($user) ? '••••••••' : 'At least 8 characters' }}"
                   {{ isset($user) ? '' : 'required' }}>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="form-control"
                   placeholder="Repeat password"
                   {{ isset($user) ? '' : 'required' }}>
        </div>

        <div style="display:flex; gap:10px; margin-top:0.5rem;">
            <button type="submit" class="btn btn-primary">
                {{ isset($user) ? 'Save Changes' : 'Create User' }}
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

    {{-- Danger Zone: only show on edit, and only if not own account --}}
    @if(isset($user) && $user->id !== auth()->id())
    <div style="margin-top: 2rem;">
        <div class="danger-zone">
            <div>
                <div class="danger-zone-title">Delete Account</div>
                <div class="danger-zone-text">
                    Permanently removes {{ $user->full_name }}'s account and all associated data.
                </div>
            </div>
            <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                  onsubmit="return confirm('Permanently delete {{ $user->full_name }}? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete User</button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
