<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // READ — list all books with filters
    public function index(Request $request)
    {
        $search = $request->input('search');
    $genre  = $request->input('genre');
    $sort   = $request->input('sort', 'alpha');
 
    $query = Book::query();
 
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('title',  'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%")
              ->orWhere('isbn',   'like', "%{$search}%");
        });
    }
 
    if ($genre) {
        $query->where('genre', $genre);
    }
 
    match ($sort) {
        'alpha'      => $query->orderBy('title', 'asc'),
        'alpha_desc' => $query->orderBy('title', 'desc'),
        'newest'     => $query->orderBy('created_at', 'desc'),
        default      => $query->orderBy('title', 'asc'),
    };
 
    $books = $query->paginate(20)->withQueryString();
 
    // Genre counts for sidebar
    $genres = Book::select('genre')
                  ->whereNotNull('genre')
                  ->where('genre', '!=', '')
                  ->get()
                  ->groupBy('genre')
                  ->map->count()
                  ->sortKeys();
 
    $totalBooks = Book::count();
 
    return view('books.index', compact('books', 'genres', 'totalBooks'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'nullable|string|unique:books,isbn',
            'genre'          => 'nullable|string|max:100',
            'publisher'      => 'nullable|string|max:255',
            'year_published' => 'nullable|integer|min:1000|max:' . date('Y'),
            'copies'         => 'required|integer|min:1',
            'shelf_location' => 'nullable|string|max:100',
        ]);

        $validated['status'] = 'available';

        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Book added successfully.');
    }

    public function show(Book $book)
    {
        $borrows = $book->borrows()->with('user')->latest()->take(5)->get();
        return view('books.show', compact('book', 'borrows'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'nullable|string|unique:books,isbn,' . $book->id,
            'genre'          => 'nullable|string|max:100',
            'publisher'      => 'nullable|string|max:255',
            'year_published' => 'nullable|integer|min:1000|max:' . date('Y'),
            'copies'         => 'required|integer|min:1',
            'shelf_location' => 'nullable|string|max:100',
            'status'         => 'required|in:available,borrowed,unavailable',
        ]);

        $book->update($validated);

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }
}