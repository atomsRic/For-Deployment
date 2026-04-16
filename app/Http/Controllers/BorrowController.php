<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    // READ — list all borrows (admin sees all, user sees own)
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $borrows = Borrow::with(['book', 'user'])->latest()->paginate(10);
        } else {
            $borrows = Borrow::with(['book', 'user'])
                ->where('user_id', auth()->id())
                ->latest()->paginate(10);
        }

        // Auto-mark overdue records
        Borrow::where('status', 'borrowed')
            ->where('due_date', '<', now()->toDateString())
            ->update(['status' => 'overdue']);

        return view('borrows.index', compact('borrows'));
    }

    // CREATE — show borrow form
    public function create()
    {
        $books = Book::where('status', 'available')->orderBy('title')->get();
        return view('borrows.create', compact('books'));
    }

    // CREATE — store borrow record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id'         => 'required|exists:books,id',
            'borrower_name'   => 'required|string|max:255',
            'borrower_id_no'  => 'nullable|string|max:50',
            'borrow_date'     => 'required|date',
            'due_date'        => 'required|date|after:borrow_date',
            'notes'           => 'nullable|string|max:500',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($book->status !== 'available') {
            return back()->with('error', 'This book is not available for borrowing.');
        }

        $validated['user_id'] = auth()->id();
        $validated['status']  = 'borrowed';

        Borrow::create($validated);

        // Update book status if no more copies
        $activeBorrows = Borrow::where('book_id', $book->id)
            ->whereIn('status', ['borrowed', 'overdue'])->count();
        if ($activeBorrows >= $book->copies) {
            $book->update(['status' => 'borrowed']);
        }

        return redirect()->route('borrows.index')
            ->with('success', 'Borrow record created successfully.');
    }

    // UPDATE — show return form
    public function edit(Borrow $borrow)
    {
        return view('borrows.edit', compact('borrow'));
    }

    // UPDATE — process return
    public function update(Request $request, Borrow $borrow)
    {
        $request->validate([
            'return_date' => 'required|date|after_or_equal:' . $borrow->borrow_date->toDateString(),
        ]);

        $borrow->update([
            'return_date' => $request->return_date,
            'status'      => 'returned',
        ]);

        // Update book status back to available
        $book = $borrow->book;
        $activeBorrows = Borrow::where('book_id', $book->id)
            ->whereIn('status', ['borrowed', 'overdue'])->count();
        if ($activeBorrows < $book->copies) {
            $book->update(['status' => 'available']);
        }

        return redirect()->route('borrows.index')
            ->with('success', 'Book returned successfully.');
    }

    // DELETE — cancel/delete borrow record (admin only)
    public function destroy(Borrow $borrow)
    {
        $borrow->delete();

        return redirect()->route('borrows.index')
            ->with('success', 'Borrow record deleted.');
    }
}
