<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Watchlist extends Model
{
    // These are the fields saved when a user adds a book to their watchlist.
    protected $fillable = [
        'user_id',
        'book_id',
    ];

    // Each watchlist row belongs to one user.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Each watchlist row belongs to one book.
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
