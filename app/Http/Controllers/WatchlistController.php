<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function store(Book $book)
    {
        $alreadyWatching = Watchlist::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->exists();

        if (! $alreadyWatching) {
            Watchlist::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
            ]);
        }

        return redirect()->route('books.show', $book)
            ->with('success', 'Book added to your watchlist.');
    }
}
