<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');
        $user   = auth()->user();

        $query = Borrow::with(['user', 'book']);

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($search && $user->isAdmin()) {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('book', fn($q) => $q->where('title', 'like', "%{$search}%"));
            });
        }

        $borrows = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $baseQuery = Borrow::query();
        if (!$user->isAdmin()) {
            $baseQuery->where('user_id', $user->id);
        }
        $counts = [
            'all'      => (clone $baseQuery)->count(),
            'borrowed' => (clone $baseQuery)->where('status', 'borrowed')->count(),
            'overdue'  => (clone $baseQuery)->where('status', 'overdue')->count(),
            'returned' => (clone $baseQuery)->where('status', 'returned')->count(),
        ];

        return view('borrows.index', compact('borrows', 'counts'));
    }

    public function create()
    {
        if (auth()->user()->role === 'student') {
            abort(403);
        }

        $books = Book::where('status', 'available')->orderBy('title')->get();

        return view('borrows.create', compact('books'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role === 'student') {
            abort(403);
        }

        $validated = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'book_id'     => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date'    => 'required|date|after:borrow_date',
            'notes'       => 'nullable|string|max:500',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($book->status !== 'available') {
            return back()->with('error', 'This book is not available.');
        }

        $validated['status'] = 'borrowed';

        Borrow::create($validated);

        $active = Borrow::where('book_id', $book->id)
                        ->whereIn('status', ['borrowed', 'overdue'])
                        ->count();

        if ($active >= $book->copies) {
            $book->update(['status' => 'borrowed']);
        }

        return redirect()->route('borrows.index')->with('success', 'Book borrowed successfully.');
    }

    public function update(Request $request, Borrow $borrow)
    {
        if (auth()->user()->role === 'student') {
            abort(403);
        }

        $request->validate([
            'return_date' => 'required|date|after_or_equal:' . $borrow->borrow_date->toDateString(),
        ]);

        $borrow->update([
            'return_date' => $request->return_date,
            'status'      => 'returned',
        ]);

        $book = $borrow->book;

        $active = Borrow::where('book_id', $book->id)
                        ->whereIn('status', ['borrowed', 'overdue'])
                        ->count();

        if ($active < $book->copies) {
            $book->update(['status' => 'available']);
        }

        return redirect()->route('borrows.index')->with('success', 'Book returned successfully.');
    }

    public function markReturn(Borrow $borrow)
{
    if (auth()->user()->role === 'student') {
        abort(403);
    }

    $borrow->update([
        'return_date' => now()->toDateString(),
        'status'      => 'returned',
    ]);

    $book = $borrow->book;

    $active = Borrow::where('book_id', $book->id)
                    ->whereIn('status', ['borrowed', 'overdue'])
                    ->count();

    if ($active < $book->copies) {
        $book->update(['status' => 'available']);
    }

    return back()->with('success', 'Book marked as returned.');
}

    public function destroy(Borrow $borrow)
    {
        if (auth()->user()->role === 'student') {
            abort(403);
        }

        $borrow->delete();

        return back()->with('success', 'Borrow record deleted.');
    }
}