@extends('layouts.app')
@section('title', 'Add Book — Library Management System')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add New Book</h1>
    <p class="page-subtitle">Fill in the details below to add a book to the catalog.</p>
</div>

<div class="card" style="max-width: 700px;">
    <form method="POST" action="{{ route('books.store') }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="title">Book Title *</label>
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
                       placeholder="Enter book title" value="{{ old('title') }}" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="author">Author *</label>
                <input type="text" id="author" name="author" class="form-control @error('author') is-invalid @enderror"
                       placeholder="Author's full name" value="{{ old('author') }}" required>
                @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" class="form-control @error('isbn') is-invalid @enderror"
                       placeholder="978-x-xxx-xxxxx-x" value="{{ old('isbn') }}">
                @error('isbn') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="genre">Genre</label>
                <select id="genre" name="genre" class="form-control">
                    <option value="">Select genre</option>
                    @foreach(['Fiction','Non-Fiction','Fantasy','Classic','Science','History','Romance','Mystery','Biography','Self-Help'] as $g)
                        <option value="{{ $g }}" {{ old('genre') == $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="publisher">Publisher</label>
                <input type="text" id="publisher" name="publisher" class="form-control"
                       placeholder="Publisher name" value="{{ old('publisher') }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="year_published">Year Published</label>
                <input type="number" id="year_published" name="year_published" class="form-control"
                       placeholder="e.g. 2020" min="1000" max="{{ date('Y') }}" value="{{ old('year_published') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="copies">Number of Copies *</label>
                <input type="number" id="copies" name="copies" class="form-control @error('copies') is-invalid @enderror"
                       placeholder="1" min="1" value="{{ old('copies', 1) }}" required>
                @error('copies') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="shelf_location">Shelf Location</label>
                <input type="text" id="shelf_location" name="shelf_location" class="form-control"
                       placeholder="e.g. Shelf A-3" value="{{ old('shelf_location') }}">
            </div>
        </div>

        <div style="display:flex; gap:10px; margin-top:0.5rem;">
            <button type="submit" class="btn btn-primary">Add Book</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
