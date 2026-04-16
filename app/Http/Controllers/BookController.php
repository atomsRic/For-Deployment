<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // READ — list all books with optional search
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('author', 'like', "%$search%")
                  ->orWhere('isbn', 'like', "%$search%")
                  ->orWhere('genre', 'like', "%$search%");
            });
        }

        $books = $query->latest()->paginate(10);

        return view('books.index', compact('books'));
    }

    // CREATE — show form
    public function create()
    {
        return view('books.create');
    }

    // CREATE — store new book
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
            ->with('success', 'Book "' . $validated['title'] . '" added successfully.');
    }

    // READ — show single book detail
    public function show(Book $book)
    {
        $borrows = $book->borrows()->with('user')->latest()->take(5)->get();
        return view('books.show', compact('book', 'borrows'));
    }

    // UPDATE — show edit form
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    // UPDATE — save changes
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
            ->with('success', 'Book "' . $book->title . '" updated successfully.');
    }

    // DELETE — remove book
    public function destroy(Book $book)
    {
        $title = $book->title;
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book "' . $title . '" deleted successfully.');
    }
}
