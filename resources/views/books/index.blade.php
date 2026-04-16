@extends('layouts.app')
@section('title', 'Books — Library Management System')

@section('content')
<div class="page-header">
    <h1 class="page-title">Book Catalog</h1>
    <p class="page-subtitle">Browse and manage all books in the library.</p>
</div>

{{-- Search + Add Button --}}
<form method="GET" action="{{ route('books.index') }}" class="search-bar">
    <input type="text" name="search" class="form-control"
           placeholder="Search by title, author, or ISBN..."
           value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary">Search</button>
    @if(request('search'))
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Clear</a>
    @endif
    @if(auth()->user()->isAdmin())
        <a href="{{ route('books.create') }}" class="btn btn-success" style="margin-left:auto;">
            + Add New Book
        </a>
    @endif
</form>

<div class="card" style="padding:0; overflow:hidden;">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Copies</th>
                    <th>Shelf</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td style="color:#94a3b8;">{{ $book->id }}</td>
                    <td style="font-weight:500; color:#0f172a;">{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->genre ?? '—' }}</td>
                    <td>{{ $book->copies }}</td>
                    <td>{{ $book->shelf_location ?? '—' }}</td>
                    <td>
                        <span class="badge badge-{{ $book->status }}">
                            {{ ucfirst($book->status) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-secondary">View</a>

                            {{-- Admin-only: Edit and Delete --}}
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form method="POST" action="{{ route('books.destroy', $book) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this book?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:#94a3b8; padding:2rem;">
                        No books found. @if(auth()->user()->isAdmin()) <a href="{{ route('books.create') }}">Add one?</a> @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div class="pagination-wrap">
    {{ $books->appends(request()->query())->links() }}
</div>
@endsection
