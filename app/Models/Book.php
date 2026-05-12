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

    /*
    |--------------------------------------
    | RELATIONSHIP
    |--------------------------------------
    */
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    /*
    |--------------------------------------
    | SCOPE: AVAILABLE BOOKS ONLY
    |--------------------------------------
    */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /*
    |--------------------------------------
    | ACCESSOR: AVAILABLE COPIES (IMPORTANT FIX)
    |--------------------------------------
    | This prevents wrong "available" display in Blade
    */
    public function getAvailableAttribute()
    {
        $borrowed = $this->borrows()
            ->whereIn('status', ['borrowed', 'overdue'])
            ->count();

        return max(0, $this->copies - $borrowed);
    }

    /*
    |--------------------------------------
    | ACCESSOR: TOTAL COPIES (SAFER DISPLAY)
    |--------------------------------------
    */
    public function getTotalCopiesAttribute()
    {
        return $this->copies;
    }
}