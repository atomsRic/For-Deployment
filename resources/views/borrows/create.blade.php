@extends('layouts.app')
@section('title', 'New Borrow — Libra-Track')
@section('topbar-title', 'New Borrow')

@section('content')
<div class="page-header">
    <h1 class="page-title">New Borrow</h1>
    <p class="page-subtitle">Assign a book to a student.</p>
</div>

@if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
@endif

<div class="card" style="max-width:620px;">
    <div class="card-header">
        <div class="card-title">Borrow Details</div>
        <a href="{{ route('borrows.index') }}" class="btn btn-sm btn-secondary">← Back</a>
    </div>

    <form method="POST" action="{{ route('borrows.store') }}">
        @csrf

        {{-- Student Lookup --}}
        <div class="form-group">
            <label class="form-label" for="student_id_input">Student ID</label>
            <div style="display:flex; gap:8px;">
                <input type="text" id="student_id_input"
                       class="form-control"
                       placeholder="Enter student ID number..."
                       style="flex:1;"
                       autocomplete="off">
                <button type="button" class="btn btn-secondary" onclick="lookupStudent()">Look Up</button>
            </div>
            <div id="student-feedback" style="margin-top:6px; font-size:0.78rem;"></div>
        </div>

        {{-- Hidden user_id --}}
        <input type="hidden" id="user_id" name="user_id" value="{{ old('user_id') }}">

        {{-- Student Name (auto-filled) --}}
        <div class="form-group">
            <label class="form-label">Student Name</label>
            <input type="text" id="student_name_display"
                   class="form-control"
                   placeholder="Auto-filled after lookup"
                   readonly
                   style="opacity:0.6; cursor:default;">
        </div>

        {{-- Book --}}
        <div class="form-group">
            <label class="form-label" for="book_id">Book</label>
            <select id="book_id" name="book_id"
                    class="form-control @error('book_id') is-invalid @enderror" required>
                <option value="">— Select a book —</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}"
                            {{ old('book_id') == $book->id ? 'selected' : '' }}
                            {{ $book->available < 1 ? 'disabled' : '' }}>
                        {{ $book->title }} — {{ $book->author }}
                        ({{ $book->available }} available)
                    </option>
                @endforeach
            </select>
            @error('book_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="borrow_date">Borrow Date</label>
                <input type="date" id="borrow_date" name="borrow_date"
                       class="form-control @error('borrow_date') is-invalid @enderror"
                       value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                @error('borrow_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="due_date">Due Date</label>
                <input type="date" id="due_date" name="due_date"
                       class="form-control @error('due_date') is-invalid @enderror"
                       value="{{ old('due_date', date('Y-m-d', strtotime('+14 days'))) }}" required>
                @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div style="display:flex; gap:8px; margin-top:0.75rem;">
            <button type="submit" class="btn btn-primary" id="submit-btn" disabled
                    style="opacity:0.5; transition:opacity 0.2s;">
                Create Borrow
            </button>
            <a href="{{ route('borrows.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
async function lookupStudent() {
    const input     = document.getElementById('student_id_input').value.trim();
    const feedback  = document.getElementById('student-feedback');
    const nameField = document.getElementById('student_name_display');
    const hiddenId  = document.getElementById('user_id');
    const submitBtn = document.getElementById('submit-btn');

    if (!input) {
        feedback.innerHTML = '<span style="color:var(--red);">Please enter a student ID.</span>';
        return;
    }

    feedback.innerHTML = '<span style="color:var(--text-3);">Looking up...</span>';

    try {
        const response = await fetch(`/student/${encodeURIComponent(input)}`);
        const data = await response.json();

        if (data && data.found) {
            nameField.value    = data.name;
            hiddenId.value     = data.id;
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            feedback.innerHTML = `<span style="color:var(--green);">✓ Student found: ${data.name}</span>`;
        } else {
            nameField.value    = '';
            hiddenId.value     = '';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
            feedback.innerHTML = '<span style="color:var(--red);">✕ No student found with that ID.</span>';
        }
    } catch (e) {
        feedback.innerHTML = '<span style="color:var(--red);">Error connecting to server.</span>';
    }
}

document.getElementById('student_id_input').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') { e.preventDefault(); lookupStudent(); }
});
</script>
@endsection