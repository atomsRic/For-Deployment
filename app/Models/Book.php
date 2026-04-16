<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'genre',
        'publisher',
        'year_published',
        'copies',
        'shelf_location',
        'status',
    ];

    // Relationship: book has many borrow records
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    // Scope: only available books
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
