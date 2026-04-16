@extends('layouts.app')
@section('title', $book->title . ' — Library Management System')

@section('content')
<div class="page-header" style="display:flex; justify-content:space-between; align-items:flex-start;">
    <div>
        <h1 class="page-title">{{ $book->title }}</h1>
        <p class="page-subtitle">by {{ $book->author }}</p>
    </div>
    <div style="display:flex; gap:8px;">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">Edit</a>
            <form method="POST" action="{{ route('books.destroy', $book) }}"
                  onsubmit="return confirm('Delete this book?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        @endif
        <a href="{{ route('books.index') }}" class="btn btn-secondary">← Back</a>
    </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.5rem;">
    <div class="card">
        <div class="card-title" style="margin-bottom:1rem;">Book Details</div>
        <table style="font-size:0.875rem;">
            <tr><td style="color:#64748b;padding:6px 0;width:120px;">Title</td><td style="font-weight:500;">{{ $book->title }}</td></tr>
            <tr><td style="color:#64748b;padding:6px 0;">Author</td><td>{{ $book->author }}</td></tr>
            <tr><td style="color:#64748b;padding:6px 0;">ISBN</td><td>{{ $book->isbn ?? '—' }}</td></tr>
            <tr><td style="color:#64748b;padding:6px 0;">Genre</td><td>{{ $book->genre ?? '—' }}</td></tr>
            <tr><td style="color:#64748b;padding:6px 0;">Publisher</td><td>{{ $book->publisher ?? '—' }}</td></tr>
            <tr><td style="color:#64748b;padding:6px 0;">Year</td><td>{{ $book->year_published ?? '—' }}</td></tr>
            <tr><td style="color:#64748b;padding:6px 0;">Copies</td><td>{{ $book->copies }}</td></tr>
            <tr><td style="color:#64748b;padding:6px 0;">Shelf</td><td>{{ $book->shelf_location ?? '—' }}</td></tr>
            <tr><td style="color:#64748b;padding:6px 0;">Status</td>
                <td><span class="badge badge-{{ $book->status }}">{{ ucfirst($book->status) }}</span></td>
            </tr>
        </table>

        @if($book->status === 'available')
            <div style="margin-top:1.25rem;">
                <a href="{{ route('borrows.create') }}?book_id={{ $book->id }}" class="btn btn-primary">
                    Borrow This Book
                </a>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-title" style="margin-bottom:1rem;">Recent Borrow History</div>
        @forelse($borrows as $borrow)
            <div style="padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:0.875rem;">
                <div style="font-weight:500;">{{ $borrow->borrower_name }}</div>
                <div style="color:#64748b;">
                    {{ $borrow->borrow_date->format('M d, Y') }} →
                    {{ $borrow->due_date->format('M d, Y') }}
                    &nbsp;<span class="badge badge-{{ $borrow->status }}">{{ ucfirst($borrow->status) }}</span>
                </div>
            </div>
        @empty
            <p style="color:#94a3b8; font-size:0.875rem;">No borrow history yet.</p>
        @endforelse
    </div>
</div>
@endsection
