<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Auto-mark overdue
        Borrow::where('status', 'borrowed')
            ->where('due_date', '<', now()->toDateString())
            ->update(['status' => 'overdue']);

        $totalBooks     = Book::count();
        $availableBooks = Book::where('status', 'available')->count();
        $borrowedBooks  = Borrow::whereIn('status', ['borrowed', 'overdue'])->count();
        $overdueBooks   = Borrow::where('status', 'overdue')->count();

        $recentBorrows  = Borrow::with(['book', 'user'])->latest()->take(6)->get();

        // Admin-only stats
        $totalUsers = auth()->user()->isAdmin() ? User::count() : null;

        // Newest books (last 8 added)
        $newBooks = Book::orderBy('created_at', 'desc')->take(8)->get();

        // Popular books (most borrowed, top 6)
        $popularBooks = Book::withCount('borrows')
                            ->orderBy('borrows_count', 'desc')
                            ->take(6)
                            ->get();

        return view('dashboard', compact(
            'totalBooks', 'availableBooks', 'borrowedBooks',
            'overdueBooks', 'recentBorrows', 'totalUsers',
            'newBooks', 'popularBooks'
        ));
    }
}