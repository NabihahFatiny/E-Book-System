<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // These are the book fields that can be mass-assigned with create/update.
    protected $fillable = [
        'cover_image',
        'title',
        'author_id',
        'publisher_id',
        'category_id',
        'isbn',
        'description',
        'status',
    ];

    // A book can have multiple authors.
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    // A book can belong to multiple categories.
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // A book belongs to one publisher.
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
    // A book can have many borrowing records over time.
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
    // A book can appear in many users' watchlists.
    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }
}
