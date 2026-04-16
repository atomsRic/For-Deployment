@extends('layouts.app')
@section('title', 'Return Book — Library Management System')

@section('content')
<div class="page-header">
    <h1 class="page-title">Process Book Return</h1>
    <p class="page-subtitle">Mark this borrow record as returned.</p>
</div>

{{-- Borrow Summary Card --}}
<div class="card" style="max-width:700px; margin-bottom:1rem; background:#f8fafc; border:1px solid #e2e8f0;">
    <div class="card-title" style="margin-bottom:0.75rem;">Borrow Summary</div>
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; font-size:0.875rem;">
        <div><span style="color:#64748b;">Borrower: </span><strong>{{ $borrow->borrower_name }}</strong></div>
        <div><span style="color:#64748b;">ID No.: </span>{{ $borrow->borrower_id_no ?? '—' }}</div>
        <div><span style="color:#64748b;">Book: </span><strong>{{ $borrow->book->title }}</strong></div>
        <div><span style="color:#64748b;">Author: </span>{{ $borrow->book->author }}</div>
        <div><span style="color:#64748b;">Borrow Date: </span>{{ $borrow->borrow_date->format('M d, Y') }}</div>
        <div><span style="color:#64748b;">Due Date: </span>
            <span style="{{ $borrow->isOverdue() ? 'color:#b91c1c; font-weight:600;' : '' }}">
                {{ $borrow->due_date->format('M d, Y') }}
                @if($borrow->isOverdue()) ⚠ OVERDUE @endif
            </span>
        </div>
    </div>
</div>

<div class="card" style="max-width:700px;">
    <form method="POST" action="{{ route('borrows.update', $borrow) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="return_date">Return Date *</label>
            <input type="date" id="return_date" name="return_date"
                   class="form-control @error('return_date') is-invalid @enderror"
                   value="{{ old('return_date', date('Y-m-d')) }}"
                   style="max-width:220px;" required>
            @error('return_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div style="display:flex; gap:10px; margin-top:0.5rem;">
            <button type="submit" class="btn btn-success">Confirm Return</button>
            <a href="{{ route('borrows.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
