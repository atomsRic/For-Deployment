@extends('layouts.app')
@section('title', 'Edit Profile — Libra-Track')
@section('topbar-title', 'Edit Profile')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Profile</h1>
        <p class="page-subtitle">Update your account information and password.</p>
    </div>

    {{-- Profile Info --}}
    <div class="card" style="max-width:600px;">
        <div class="card-header">
            <div class="card-title">Account Information</div>
        </div>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Profile Photo --}}
            <div class="form-group" style="display:flex; align-items:center; gap:1.25rem; margin-bottom:1.5rem;">
                {{-- Current Avatar --}}
                @if (auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" id="avatar-preview"
                        style="width:72px; height:72px; border-radius:50%; object-fit:cover; border:2px solid var(--accent);">
                @else
                    <div id="avatar-preview-initials"
                        style="width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg,var(--accent),var(--accent-2)); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.5rem; flex-shrink:0;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <img id="avatar-preview"
                        style="display:none; width:72px; height:72px; border-radius:50%; object-fit:cover; border:2px solid var(--accent);">
                @endif

                <div>
                    <label class="form-label" style="margin-bottom:8px;">Profile Photo</label>
                    <input type="file" id="profile_photo" name="profile_photo"
                        accept="image/jpg,image/jpeg,image/png,image/webp" style="display:none;"
                        onchange="previewPhoto(this)">
                    <div style="display:flex; gap:8px; align-items:center;">
                        <button type="button" class="btn btn-secondary btn-sm"
                            onclick="document.getElementById('profile_photo').click()">
                            📷 Choose Photo
                        </button>
                        @if (auth()->user()->profile_photo)
                            <span style="font-size:0.75rem; color:var(--green);">✓ Photo set</span>
                        @endif
                    </div>
                    <p style="font-size:0.72rem; color:var(--text-3); margin-top:5px;">JPG, PNG or WEBP. Max 2MB.</p>
                    @error('profile_photo')
                        <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email"
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}"
                    required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if ($user->student_id)
                <div class="form-group">
                    <label class="form-label">Student ID</label>
                    <input type="text" class="form-control" value="{{ $user->student_id }}" readonly
                        style="opacity:0.5; cursor:not-allowed;">
                    <small style="color:var(--text-3); font-size:0.75rem;">Student ID cannot be changed. Contact
                        admin.</small>
                </div>
            @endif

            @if ($user->wasChanged('email'))
                <p style="font-size:0.78rem; color:var(--amber);">⚠ Your email has changed. Please verify your new email.
                </p>
            @endif

            @if (session('status') === 'profile-updated')
                <p style="font-size:0.78rem; color:var(--green);">✓ Profile updated successfully.</p>
            @endif

            <div style="margin-top:0.75rem;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="card" style="max-width:600px;">
        <div class="card-header">
            <div class="card-title">Change Password</div>
        </div>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password"
                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                    autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">New Password</label>
                <input type="password" id="password" name="password"
                    class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                    autocomplete="new-password">
                @error('password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                    autocomplete="new-password">
            </div>

            @if (session('status') === 'password-updated')
                <p style="font-size:0.78rem; color:var(--green);">✓ Password updated successfully.</p>
            @endif

            <div style="margin-top:0.75rem;">
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
        </form>
    </div>

    {{-- Danger Zone --}}
    @if (!auth()->user()->isAdmin())
        <div class="card" style="max-width:600px;">
            <div class="danger-zone">
                <div>
                    <div class="danger-zone-title">Delete Account</div>
                    <div class="danger-zone-text">Permanently deletes your account. This cannot be undone.</div>
                </div>
                <form method="POST" action="{{ route('profile.destroy') }}"
                    onsubmit="return confirm('Are you sure? This cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <input type="password" name="password" class="form-control" placeholder="Enter password to confirm"
                        style="margin-bottom:8px; max-width:220px;">
                    <button type="submit" class="btn btn-danger btn-sm">Delete Account</button>
                </form>
            </div>
        </div>
    @endif

    <script>
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('avatar-preview');
                    const initials = document.getElementById('avatar-preview-initials');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    if (initials) initials.style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection
