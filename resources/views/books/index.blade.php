@extends('layouts.app')
@section('title', 'Books — Libra-Track')
@section('topbar-title', 'Books')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Books</h1>
        <p class="page-subtitle">Browse and search the library catalog.</p>
    </div>

    <div class="page-with-sidebar">

        {{-- ── SIDEBAR ── --}}
        <aside class="sidebar">
            <div class="sidebar-title">Sort</div>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'alpha', 'page' => 1]) }}"
                class="sidebar-item {{ request('sort', 'alpha') === 'alpha' ? 'active' : '' }}">A → Z</a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'alpha_desc', 'page' => 1]) }}"
                class="sidebar-item {{ request('sort') === 'alpha_desc' ? 'active' : '' }}">Z → A</a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest', 'page' => 1]) }}"
                class="sidebar-item {{ request('sort') === 'newest' ? 'active' : '' }}">Newest First</a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-title">Genre</div>
            <a href="{{ request()->fullUrlWithQuery(['genre' => '', 'page' => 1]) }}"
                class="sidebar-item {{ !request('genre') ? 'active' : '' }}">
                All Genres <span class="sidebar-count">{{ $totalBooks }}</span>
            </a>
            @foreach ($genres as $genre => $count)
                <a href="{{ request()->fullUrlWithQuery(['genre' => $genre, 'page' => 1]) }}"
                    class="sidebar-item {{ request('genre') === $genre ? 'active' : '' }}">
                    {{ $genre }} <span class="sidebar-count">{{ $count }}</span>
                </a>
            @endforeach
        </aside>

        {{-- ── CONTENT ── --}}
        <div class="content-area">
            <div class="card" style="padding:0; overflow:hidden;">
                <div
                    style="padding:1rem 1.25rem; border-bottom:1px solid var(--border-2); display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
                    <span class="card-title">
                        {{ request('genre') ?: 'All Books' }}
                        <span style="font-weight:400; color:var(--text-3); font-size:0.8rem; margin-left:6px;">
                            {{ $books->total() }} {{ Str::plural('book', $books->total()) }}
                        </span>
                    </span>
                    <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                        <form method="GET" action="{{ route('books.index') }}" style="display:flex; gap:8px;">
                            <input type="hidden" name="genre" value="{{ request('genre') }}">
                            <input type="hidden" name="sort" value="{{ request('sort', 'alpha') }}">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search title, author, ISBN..." value="{{ request('search') }}"
                                style="width:230px; padding:7px 12px; font-size:0.8rem;">
                            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
                            @if (request('search'))
                                <a href="{{ route('books.index') }}" class="btn btn-sm btn-secondary">✕</a>
                            @endif
                        </form>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('books.create') }}" class="btn btn-primary btn-sm">+ Add Book</a>
                        @endif
                    </div>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>ISBN</th>
                                <th>Genre</th>
                                <th>Copies</th>
                                <th>Available</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                                <tr>
                                    <td style="color:var(--text-3); font-size:0.76rem;">
                                        {{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}</td>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <x-book-cover :book="$book" width="32px" height="44px" />
                                            <span style="font-weight:600; color:var(--text);">{{ $book->title }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $book->author }}</td>
                                    <td style="font-family:monospace; font-size:0.78rem; color:var(--text-3);">
                                        {{ $book->isbn ?? '—' }}</td>
                                    <td>
                                        @if ($book->genre)
                                            <span
                                                style="font-size:0.72rem; background:rgba(255,255,255,0.06); padding:2px 9px; border-radius:20px; color:var(--text-3);">{{ $book->genre }}</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>{{ $book->total_copies }}</td>
                                    <td>{{ $book->available }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $book->available > 0 ? 'badge-available' : 'badge-unavailable' }}">
                                            {{ $book->available > 0 ? 'Available' : 'Unavailable' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display:flex; gap:5px;">
                                            <a href="{{ route('books.show', $book->id) }}"
                                                class="btn btn-sm btn-secondary">View</a>
                                            @if (auth()->user()->isAdmin())
                                                <a href="{{ route('books.edit', $book->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form method="POST" action="{{ route('books.destroy', $book->id) }}"
                                                    onsubmit="return confirm('Delete this book?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="empty-cell">No books found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($books->hasPages())
                    <div class="pagination-wrap" style="padding:1rem;">
                        {{ $books->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
