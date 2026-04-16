<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrower_name',
        'borrower_id_no',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date'    => 'date',
        'return_date' => 'date',
    ];

    // Relationship: belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: belongs to a book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Check if overdue
    public function isOverdue(): bool
    {
        return $this->status === 'borrowed' && $this->due_date->isPast();
    }
}
