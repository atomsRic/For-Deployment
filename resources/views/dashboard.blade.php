@extends('layouts.app')
@section('title', 'Dashboard — Libra-Track')
@section('topbar-title', 'Dashboard')

@section('content')

    <style>
        .dash-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 1.5rem;
            align-items: start;
        }

        /* ── SECTION HEADER ── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
        }

        .show-all {
            font-size: 0.75rem;
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.15s;
        }

        .show-all:hover {
            opacity: 0.7;
        }

        /* ── STAT SUBJECT CARDS ── */
        .subjects-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .subject-card {
            background: var(--bg-3);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem 1.1rem;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
            display: block;
        }

        .subject-card:hover {
            background: rgba(255, 255, 255, 0.06);
            transform: translateY(-1px);
        }

        .subject-card.highlight {
            background: var(--accent);
            border-color: var(--accent);
        }

        .subject-card.highlight .subject-name,
        .subject-card.highlight .subject-count {
            color: #1a0f00;
        }

        .subject-card.highlight .subject-label {
            color: rgba(26, 15, 0, 0.65);
        }

        .subject-name {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 2px;
        }

        .subject-count {
            font-family: 'DM Sans', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text);
            line-height: 1.2;
        }

        .subject-label {
            font-size: 0.68rem;
            color: var(--text-3);
            margin-top: 1px;
        }

        /* ── BOOK CARDS (horizontal scroll) ── */
        .books-scroll {
            display: flex;
            gap: 0.875rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            scrollbar-width: none;
        }

        .books-scroll::-webkit-scrollbar {
            display: none;
        }

        .book-card {
            flex-shrink: 0;
            width: 100px;
            cursor: pointer;
            text-decoration: none;
        }

        .book-cover {
            width: 100px;
            height: 138px;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 7px;
            position: relative;
            background: var(--bg-3);
            border: 1px solid var(--border);
        }

        .book-cover-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px;
            text-align: center;
            gap: 6px;
        }

        .book-cover-title {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text);
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-cover-author {
            font-size: 0.58rem;
            color: var(--text-3);
        }

        .book-info-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text);
            line-height: 1.3;
            margin-bottom: 2px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-info-author {
            font-size: 0.68rem;
            color: var(--text-3);
        }

        /* Book cover colors by genre */
        .cover-fiction {
            background: linear-gradient(145deg, #1a2a4a, #2d4a7a);
        }

        .cover-fantasy {
            background: linear-gradient(145deg, #2a1a4a, #5a2d8a);
        }

        .cover-science {
            background: linear-gradient(145deg, #0d2a2a, #1a5a5a);
        }

        .cover-history {
            background: linear-gradient(145deg, #2a1a0d, #7a4a1a);
        }

        .cover-romance {
            background: linear-gradient(145deg, #3a0d1a, #8a2d4a);
        }

        .cover-mystery {
            background: linear-gradient(145deg, #1a1a2a, #3a3a5a);
        }

        .cover-biography {
            background: linear-gradient(145deg, #1a2a1a, #2d5a2d);
        }

        .cover-classic {
            background: linear-gradient(145deg, #2a2a0d, #5a5a1a);
        }

        .cover-default {
            background: linear-gradient(145deg, #1e2436, #2d3654);
        }

        /* ── RIGHT COLUMN ── */
        .popular-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.6rem;
            margin-bottom: 1rem;
        }

        .popular-book {
            background: var(--bg-3);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0.6rem;
            display: flex;
            gap: 8px;
            align-items: center;
            text-decoration: none;
            transition: all 0.15s;
            cursor: pointer;
        }

        .popular-book:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .popular-cover {
            width: 36px;
            height: 50px;
            border-radius: 4px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .popular-title {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--text);
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 2px;
        }

        .popular-author {
            font-size: 0.65rem;
            color: var(--text-3);
        }

        .popular-stat {
            font-size: 0.62rem;
            color: var(--accent);
            font-weight: 600;
        }

        /* ── RECENT ACTIVITY TABLE ── */
        .activity-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 0;
            border-bottom: 1px solid var(--border-2);
        }

        .activity-row:last-child {
            border-bottom: none;
        }

        .activity-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .activity-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text);
        }

        .activity-book {
            font-size: 0.72rem;
            color: var(--text-3);
        }

        .activity-date {
            font-size: 0.7rem;
            color: var(--text-3);
            margin-left: auto;
            white-space: nowrap;
        }
    </style>

    <div class="dash-grid">

        {{-- ══ LEFT COLUMN ══ --}}
        <div>

            {{-- ── Stats / Subjects ── --}}
            <div style="margin-bottom:1.5rem;">
                <div class="section-header">
                    <span class="section-title">Library Overview</span>
                </div>
                <div class="subjects-grid">
                    <a href="{{ route('books.index') }}" class="subject-card">
                        <div class="subject-name">📚 Total</div>
                        <div class="subject-count">{{ $totalBooks }}</div>
                        <div class="subject-label">books available</div>
                    </a>
                    <a href="{{ route('books.index') }}" class="subject-card highlight">
                        <div class="subject-name">✅ Available</div>
                        <div class="subject-count">{{ $availableBooks }}</div>
                        <div class="subject-label">books available</div>
                    </a>
                    <a href="{{ route('borrows.index') }}" class="subject-card">
                        <div class="subject-name">📤 Borrowed</div>
                        <div class="subject-count">{{ $borrowedBooks }}</div>
                        <div class="subject-label">currently out</div>
                    </a>
                    <a href="{{ route('borrows.index', ['status' => 'overdue']) }}" class="subject-card">
                        <div class="subject-name">⚠️ Overdue</div>
                        <div class="subject-count" style="color:var(--red);">{{ $overdueBooks }}</div>
                        <div class="subject-label">past due date</div>
                    </a>
                    @if (auth()->user()->isAdmin() && isset($totalUsers))
                        <a href="{{ route('users.index') }}" class="subject-card">
                            <div class="subject-name">👥 Students</div>
                            <div class="subject-count" style="color:var(--purple);">{{ $totalUsers }}</div>
                            <div class="subject-label">registered users</div>
                        </a>
                    @endif
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('borrows.create') }}" class="subject-card"
                            style="border: 1px dashed rgba(244,162,97,0.3); background:rgba(244,162,97,0.05);">
                            <div class="subject-name" style="color:var(--accent);">＋ New</div>
                            <div class="subject-count" style="color:var(--accent); font-size:1rem; margin-top:4px;">Borrow
                            </div>
                            <div class="subject-label">create transaction</div>
                        </a>
                    @endif
                </div>
            </div>

            {{-- ── Recent Borrows ── --}}
            <div style="margin-bottom:1.5rem;">
                <div class="section-header">
                    <span
                        class="section-title">{{ auth()->user()->isAdmin() ? 'Recent Activity' : 'My Transactions' }}</span>
                    <a href="{{ route('borrows.index') }}" class="show-all">Show all</a>
                </div>
                <div class="card" style="padding:0.25rem 1rem; margin-bottom:0;">
                    @forelse($recentBorrows as $borrow)
                        <div class="activity-row">
                            @if (auth()->user()->isAdmin())
                                <div class="activity-avatar">
                                    {{ strtoupper(substr($borrow->user->name ?? 'U', 0, 1)) }}
                                </div>
                            @endif
                            <div style="flex:1; min-width:0;">
                                @if (auth()->user()->isAdmin())
                                    <div class="activity-name">{{ $borrow->user->name ?? '—' }}</div>
                                @endif
                                <div class="activity-book">{{ $borrow->book->title ?? '—' }}</div>
                            </div>
                            <span class="badge badge-{{ $borrow->status }}">{{ ucfirst($borrow->status) }}</span>
                            <div class="activity-date">{{ $borrow->due_date->format('M d') }}</div>
                        </div>
                    @empty
                        <div style="text-align:center; color:var(--text-3); padding:2rem; font-size:0.83rem;">No records
                            yet.</div>
                    @endforelse
                </div>
            </div>

            {{-- ── New Books ── --}}
            @if (isset($newBooks) && $newBooks->count())
                <div>
                    <div class="section-header">
                        <span class="section-title">New Books</span>
                        <a href="{{ route('books.index', ['sort' => 'newest']) }}" class="show-all">Show all</a>
                    </div>
                    <div class="books-scroll">
                        @foreach ($newBooks as $book)
                            @php
                                $coverClass = match (strtolower($book->genre ?? '')) {
                                    'fiction' => 'cover-fiction',
                                    'fantasy' => 'cover-fantasy',
                                    'science' => 'cover-science',
                                    'history' => 'cover-history',
                                    'romance' => 'cover-romance',
                                    'mystery' => 'cover-mystery',
                                    'biography' => 'cover-biography',
                                    'classic' => 'cover-classic',
                                    default => 'cover-default',
                                };
                            @endphp
                            <a href="{{ route('books.show', $book->id) }}" class="book-card">
                                <x-book-cover :book="$book" width="100px" height="138px" />
                                <div class="book-info-title" style="margin-top:7px;">{{ $book->title }}</div>
                                <div class="book-info-author">{{ $book->author }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        {{-- ══ RIGHT COLUMN ══ --}}
        <div>

            {{-- ── Popular Books ── --}}
            @if (isset($popularBooks) && $popularBooks->count())
                <div style="margin-bottom:1.5rem;">
                    <div class="section-header">
                        <span class="section-title">Popular Books</span>
                        <a href="{{ route('books.index') }}" class="show-all">Show all</a>
                    </div>
                    <div class="popular-grid">
                        @foreach ($popularBooks as $book)
                            @php
                                $coverClass = match (strtolower($book->genre ?? '')) {
                                    'fiction' => 'cover-fiction',
                                    'fantasy' => 'cover-fantasy',
                                    'science' => 'cover-science',
                                    'history' => 'cover-history',
                                    'romance' => 'cover-romance',
                                    'mystery' => 'cover-mystery',
                                    'biography' => 'cover-biography',
                                    'classic' => 'cover-classic',
                                    default => 'cover-default',
                                };
                            @endphp
                            <a href="{{ route('books.show', $book->id) }}" class="popular-book">
                                <x-book-cover :book="$book" width="36px" height="50px" />
                                <div style="min-width:0;">
                                    <div class="popular-title">{{ $book->title }}</div>
                                    <div class="popular-author">{{ $book->author }}</div>
                                    <div class="popular-stat">{{ $book->borrows_count ?? 0 }} borrows</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ── Quick Actions ── --}}
            <div style="margin-bottom:1.5rem;">
                <div class="section-header">
                    <span class="section-title">Quick Actions</span>
                </div>
                <div style="display:flex; flex-direction:column; gap:8px;">
                    <a href="{{ route('books.index') }}" class="subject-card" style="padding:0.875rem 1rem;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <span style="font-size:1.1rem;">📚</span>
                            <div>
                                <div style="font-size:0.82rem; font-weight:600; color:var(--text);">Browse Books</div>
                                <div style="font-size:0.7rem; color:var(--text-3);">Search the catalog</div>
                            </div>
                        </div>
                    </a>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('borrows.create') }}" class="subject-card highlight"
                            style="padding:0.875rem 1rem;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span style="font-size:1.1rem;">＋</span>
                                <div>
                                    <div style="font-size:0.82rem; font-weight:600; color:#1a0f00;">New Borrow</div>
                                    <div style="font-size:0.7rem; color:rgba(26,15,0,0.6);">Assign book to student</div>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('books.create') }}" class="subject-card" style="padding:0.875rem 1rem;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span style="font-size:1.1rem;">📖</span>
                                <div>
                                    <div style="font-size:0.82rem; font-weight:600; color:var(--text);">Add Book</div>
                                    <div style="font-size:0.7rem; color:var(--text-3);">Add to catalog</div>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('users.index') }}" class="subject-card" style="padding:0.875rem 1rem;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span style="font-size:1.1rem;">👥</span>
                                <div>
                                    <div style="font-size:0.82rem; font-weight:600; color:var(--text);">Students</div>
                                    <div style="font-size:0.7rem; color:var(--text-3);">Manage accounts</div>
                                </div>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('borrows.index') }}" class="subject-card highlight"
                            style="padding:0.875rem 1rem;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span style="font-size:1.1rem;">📋</span>
                                <div>
                                    <div style="font-size:0.82rem; font-weight:600; color:#1a0f00;">My Transactions</div>
                                    <div style="font-size:0.7rem; color:rgba(26,15,0,0.6);">View your borrows</div>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
