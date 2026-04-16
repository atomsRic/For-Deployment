@extends('layouts.app')
@section('title', 'New Borrow — Library Management System')

@section('content')
<div class="page-header">
    <h1 class="page-title">New Borrow Record</h1>
    <p class="page-subtitle">Fill in the details to record a book borrowing.</p>
</div>

<div class="card" style="max-width:700px;">
    <form method="POST" action="{{ route('borrows.store') }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="borrower_name">Borrower Name *</label>
                <input type="text" id="borrower_name" name="borrower_name"
                       class="form-control @error('borrower_name') is-invalid @enderror"
                       placeholder="Full name of borrower"
                       value="{{ old('borrower_name') }}" required>
                @error('borrower_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="borrower_id_no">ID / Student No.</label>
                <input type="text" id="borrower_id_no" name="borrower_id_no"
                       class="form-control"
                       placeholder="e.g. 2021-00123"
                       value="{{ old('borrower_id_no') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="book_id">Select Book *</label>
            <select id="book_id" name="book_id"
                    class="form-control @error('book_id') is-invalid @enderror" required>
                <option value="">— Choose an available book —</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}"
                        {{ old('book_id', request('book_id')) == $book->id ? 'selected' : '' }}>
                        {{ $book->title }} — by {{ $book->author }}
                        ({{ $book->copies }} cop{{ $book->copies > 1 ? 'ies' : 'y' }})
                    </option>
                @endforeach
            </select>
            @error('book_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            @if($books->isEmpty())
                <div style="color:#b45309; font-size:0.8rem; margin-top:4px;">
                    ⚠ No books currently available for borrowing.
                </div>
            @endif
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="borrow_date">Borrow Date *</label>
                <input type="date" id="borrow_date" name="borrow_date"
                       class="form-control @error('borrow_date') is-invalid @enderror"
                       value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                @error('borrow_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="due_date">Due Date *</label>
                <input type="date" id="due_date" name="due_date"
                       class="form-control @error('due_date') is-invalid @enderror"
                       value="{{ old('due_date', date('Y-m-d', strtotime('+14 days'))) }}" required>
                @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="notes">Notes (optional)</label>
            <textarea id="notes" name="notes" class="form-control" rows="3"
                      placeholder="Any additional notes...">{{ old('notes') }}</textarea>
        </div>

        <div style="display:flex; gap:10px; margin-top:0.5rem;">
            <button type="submit" class="btn btn-primary">Record Borrow</button>
            <a href="{{ route('borrows.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
