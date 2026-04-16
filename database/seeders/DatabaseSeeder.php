<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrow;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Create Admin Account ──────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@library.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // ── Create Regular User Account ───────────────────────────────────
        $user = User::create([
            'name'     => 'Juan dela Cruz',
            'email'    => 'user@library.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        // ── Sample Books ──────────────────────────────────────────────────
        $books = [
            ['title' => 'Noli Me Tangere',       'author' => 'Jose Rizal',          'genre' => 'Fiction',     'isbn' => '978-971-10-0001-1', 'copies' => 3, 'shelf_location' => 'Shelf A-1', 'status' => 'available'],
            ['title' => 'El Filibusterismo',      'author' => 'Jose Rizal',          'genre' => 'Fiction',     'isbn' => '978-971-10-0002-2', 'copies' => 2, 'shelf_location' => 'Shelf A-1', 'status' => 'available'],
            ['title' => 'The Great Gatsby',       'author' => 'F. Scott Fitzgerald', 'genre' => 'Classic',     'isbn' => '978-0-7432-7356-5', 'copies' => 2, 'shelf_location' => 'Shelf B-2', 'status' => 'borrowed'],
            ['title' => 'Harry Potter and the Sorcerer\'s Stone', 'author' => 'J.K. Rowling', 'genre' => 'Fantasy', 'isbn' => '978-0-590-35340-3', 'copies' => 5, 'shelf_location' => 'Shelf C-1', 'status' => 'available'],
            ['title' => 'Pride and Prejudice',    'author' => 'Jane Austen',         'genre' => 'Romance',     'isbn' => '978-0-14-143951-8', 'copies' => 4, 'shelf_location' => 'Shelf B-3', 'status' => 'available'],
            ['title' => 'To Kill a Mockingbird',  'author' => 'Harper Lee',          'genre' => 'Fiction',     'isbn' => '978-0-06-112008-4', 'copies' => 3, 'shelf_location' => 'Shelf A-3', 'status' => 'available'],
            ['title' => '1984',                   'author' => 'George Orwell',       'genre' => 'Fiction',     'isbn' => '978-0-452-28423-4', 'copies' => 2, 'shelf_location' => 'Shelf A-2', 'status' => 'available'],
            ['title' => 'The Alchemist',          'author' => 'Paulo Coelho',        'genre' => 'Fiction',     'isbn' => '978-0-06-112241-5', 'copies' => 3, 'shelf_location' => 'Shelf D-1', 'status' => 'available'],
            ['title' => 'A Brief History of Time','author' => 'Stephen Hawking',     'genre' => 'Science',     'isbn' => '978-0-553-38016-3', 'copies' => 2, 'shelf_location' => 'Shelf E-1', 'status' => 'available'],
            ['title' => 'Florante at Laura',      'author' => 'Francisco Balagtas',  'genre' => 'Classic',     'isbn' => '978-971-10-0010-3', 'copies' => 4, 'shelf_location' => 'Shelf A-1', 'status' => 'available'],
        ];

        foreach ($books as $bookData) {
            Book::create($bookData);
        }

        // ── Sample Borrow Records ─────────────────────────────────────────
        Borrow::create([
            'user_id'        => $user->id,
            'book_id'        => 3, // The Great Gatsby
            'borrower_name'  => 'Maria Santos',
            'borrower_id_no' => '2021-00123',
            'borrow_date'    => now()->subDays(7),
            'due_date'       => now()->addDays(7),
            'status'         => 'borrowed',
        ]);

        Borrow::create([
            'user_id'        => $user->id,
            'book_id'        => 1, // Noli Me Tangere
            'borrower_name'  => 'Juan dela Cruz',
            'borrower_id_no' => '2021-00456',
            'borrow_date'    => now()->subDays(20),
            'due_date'       => now()->subDays(6),
            'status'         => 'overdue',
        ]);

        Borrow::create([
            'user_id'        => $admin->id,
            'book_id'        => 4, // Harry Potter
            'borrower_name'  => 'Ana Reyes',
            'borrower_id_no' => '2022-00789',
            'borrow_date'    => now()->subDays(30),
            'due_date'       => now()->subDays(16),
            'return_date'    => now()->subDays(15),
            'status'         => 'returned',
        ]);
    }
}
