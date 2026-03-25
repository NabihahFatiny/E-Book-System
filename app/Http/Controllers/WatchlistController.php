<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = Watchlist::with(['book.authors', 'book.publisher'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('watchlist.index', compact('watchlists'));
    }

    public function store(Book $book)
    {
        $alreadyWatching = Watchlist::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->exists();

        if ($alreadyWatching) {
            return redirect()->route('books.show', $book)
                ->with('error', 'This book is already in your watchlist.');
        }

        Watchlist::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
        ]);

        return redirect()->route('books.show', $book)
            ->with('success', 'Book added to your watchlist.');
    }

    public function destroy(Watchlist $watchlist)
    {
        if ($watchlist->user_id !== Auth::id()) {
            abort(403);
        }

        $watchlist->delete();

        return redirect()->route('my.watchlist')
            ->with('success', 'Book removed from watchlist.');
    }
}
