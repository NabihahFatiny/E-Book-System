<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrowing extends Model
{
    // These are the borrowing fields allowed in create/update operations.
    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_at',
        'returned_at',
        'status',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    // Each borrowing record belongs to one user.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Each borrowing record belongs to one book.
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    // Small helper for checking whether the borrowing has been returned already.
    public function isReturned(): bool
    {
        return $this->status === 'returned';
    }
}
