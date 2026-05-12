@extends('layouts.app')
@section('title', $book->title . ' — Libra-Track')
@section('topbar-title', 'Book Detail')

@section('content')
<div class="page-header" style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:1rem;">
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

<div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem;">

    <div class="card">
        <div class="card-title" style="margin-bottom:1.25rem;">Book Details</div>
        <table style="font-size:0.84rem; width:100%;">
            <tr>
                <td style="color:var(--text-3); padding:7px 0; width:120px;">Title</td>
                <td style="font-weight:600; color:var(--text);">{{ $book->title }}</td>
            </tr>
            <tr>
                <td style="color:var(--text-3); padding:7px 0;">Author</td>
                <td>{{ $book->author }}</td>
            </tr>
            <tr>
                <td style="color:var(--text-3); padding:7px 0;">ISBN</td>
                <td style="font-family:monospace; font-size:0.8rem;">{{ $book->isbn ?? '—' }}</td>
            </tr>
            <tr>
                <td style="color:var(--text-3); padding:7px 0;">Genre</td>
                <td>{{ $book->genre ?? '—' }}</td>
            </tr>
            <tr>
                <td style="color:var(--text-3); padding:7px 0;">Publisher</td>
                <td>{{ $book->publisher ?? '—' }}</td>
            </tr>
            <tr>
                <td style="color:var(--text-3); padding:7px 0;">Year</td>
                <td>{{ $book->year_published ?? '—' }}</td>
            </tr>
            <tr>
                <td style="color:var(--text-3); padding:7px 0;">Copies</td>
                <td>{{ $book->copies }}</td>
            </tr>
            <tr>
                <td style="color:var(--text-3); padding:7px 0;">Available</td>
                <td>{{ $book->available }}</td>
            </tr>
            <tr>
                <td style="color:var(--text-3); padding:7px 0;">Shelf</td>
                <td>{{ $book->shelf_location ?? '—' }}</td>
            </tr>
            <tr>
                <td style="color:var(--text-3); padding:7px 0;">Status</td>
                <td><span class="badge badge-{{ $book->status }}">{{ ucfirst($book->status) }}</span></td>
            </tr>
        </table>

        @if(auth()->user()->isAdmin() && $book->available > 0)
        <div style="margin-top:1.25rem;">
            <a href="{{ route('borrows.create') }}?book_id={{ $book->id }}" class="btn btn-primary">
                + Borrow This Book
            </a>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="card-title" style="margin-bottom:1.25rem;">Recent Borrow History</div>
        @forelse($borrows as $borrow)
        <div style="padding:10px 0; border-bottom:1px solid var(--border-2); font-size:0.83rem;">
            <div style="font-weight:600; color:var(--text); margin-bottom:3px;">{{ $borrow->borrower_name ?? $borrow->user->name ?? '—' }}</div>
            <div style="color:var(--text-3); font-size:0.78rem;">
                {{ $borrow->borrow_date->format('M d, Y') }} → {{ $borrow->due_date->format('M d, Y') }}
                &nbsp;<span class="badge badge-{{ $borrow->status }}">{{ ucfirst($borrow->status) }}</span>
            </div>
        </div>
        @empty
        <p style="color:var(--text-3); font-size:0.83rem;">No borrow history yet.</p>
        @endforelse
    </div>

</div>
@endsection