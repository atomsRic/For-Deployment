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

        $recentBorrows  = Borrow::with(['book', 'user'])->latest()->take(5)->get();

        // Admin-only stats
        $totalUsers = auth()->user()->isAdmin() ? User::count() : null;

        return view('dashboard', compact(
            'totalBooks', 'availableBooks', 'borrowedBooks',
            'overdueBooks', 'recentBorrows', 'totalUsers'
        ));
    }
}
