@extends('layouts.app')
@section('title', isset($user) ? 'Edit User — Libra-Track' : 'Add User — Libra-Track')
@section('topbar-title', isset($user) ? 'Edit User' : 'Add User')

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($user) ? 'Edit User' : 'Add New User' }}</h1>
    <p class="page-subtitle">
        {{ isset($user) ? 'Update account details for ' . $user->name . '.' : 'Create a new student or admin account.' }}
    </p>
</div>

<div class="card" style="max-width:580px;">
    <div class="card-header">
        <div class="card-title">{{ isset($user) ? 'Account Details' : 'New Account' }}</div>
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">← Back to Students</a>
    </div>

    <form method="POST"
          action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}">
        @csrf
        @if(isset($user)) @method('PUT') @endif

        {{-- Name --}}
        <div class="form-group">
            <label class="form-label" for="name">Full Name *</label>
            <input type="text" id="name" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name ?? '') }}"
                   placeholder="Enter full name" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Student ID --}}
        <div class="form-group">
            <label class="form-label" for="student_id">Student ID</label>
            <input type="text" id="student_id" name="student_id"
                   class="form-control @error('student_id') is-invalid @enderror"
                   value="{{ old('student_id', $user->student_id ?? '') }}"
                   placeholder="e.g. 2024-00123">
            @error('student_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                <option value="student" {{ old('role', $user->role ?? 'student') === 'student' ? 'selected' : '' }}>
                    Student — can browse books and view transactions
                </option>
                <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>
                    Admin — full system access
                </option>
            </select>
            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Password --}}
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
                   class="form-control" placeholder="Repeat password"
                   {{ isset($user) ? '' : 'required' }}>
        </div>

        <div style="display:flex; gap:10px; margin-top:0.75rem;">
            <button type="submit" class="btn btn-primary">
                {{ isset($user) ? 'Save Changes' : 'Create User' }}
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

    {{-- Danger Zone --}}
    @if(isset($user) && $user->id !== auth()->id())
    <div class="danger-zone">
        <div>
            <div class="danger-zone-title">Delete Account</div>
            <div class="danger-zone-text">
                Permanently removes {{ $user->name }}'s account. This cannot be undone.
            </div>
        </div>
        <form method="POST" action="{{ route('users.destroy', $user->id) }}"
              onsubmit="return confirm('Permanently delete {{ $user->name }}?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete User</button>
        </form>
    </div>
    @endif
</div>
@endsection