<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;
use App\Models\Watchlist;
use App\Notifications\BookAvailableNotification;


class BorrowingController extends Controller
{
    // Shows the logged-in user's borrowing history page.
    public function index()
    {
        $borrowings = Borrowing::with(['book.authors', 'book.publisher'])
            ->where('user_id', Auth::id())
            ->latest('borrowed_at')
            ->get();

        return view('my-borrowings', compact('borrowings'));
    }

    // Creates a borrowing record only if the same book is not already borrowed.
    public function store(Book $book)
    {
        $user = Auth::user();

        // A user may only keep 2 active borrowings at the same time. Boleh pinjam 2 je
        $activeBorrowingsCount = Borrowing::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();

        if ($activeBorrowingsCount >= 2) {
            return redirect()->route('books.show', $book)
                ->with('error', 'You can only borrow 2 books at one time. Please return a book first.');
        }

        $existingBorrowing = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'active')
            ->first();

        if ($existingBorrowing) {
            return redirect()->route('books.read', $book)
                ->with('success', 'You already borrowed this book.');
        }

        $bookBorrowedByAnotherUser = Borrowing::where('book_id', $book->id)
            ->where('status', 'active')
            ->exists();

        if ($bookBorrowedByAnotherUser) {
            return redirect()->route('books.show', $book)
                ->with('error', 'This book is currently borrowed. You can add it to your watchlist.');
        }

        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_at' => now()->addMinute(5),
            'status' => 'active',
        ]);

        $book->update([
            'status' => 'borrowed',
        ]);

        return redirect()->route('books.read', $book)
            ->with('success', 'Book borrowed successfully.');
    }



    // The current project uses the book page as the "read" destination after access is verified.
    public function read(Book $book)
    {
        $activeBorrowing = Borrowing::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->where('status', 'active')
            ->first();

        if (! $activeBorrowing) {
            return redirect()->route('books.show', $book)
                ->with('error', 'Borrow this book first before reading it.');
        }

        return redirect()->route('books.show', $book)
            ->with('success', 'You can read this book now.');
    }
    // Returns a book, makes it available again, and notifies watchlist users.
    public function return(Borrowing $borrowing)
    {
        if ($borrowing->user_id !== Auth::id()) {
            abort(403);
        }

        if ($borrowing->status === 'returned') {
            return redirect()->route('my.borrowings')
                ->with('error', 'This book has already been returned.');
        }

        $borrowing->update([
            'status' => 'returned',
            'returned_at' => now(),
        ]);

        $book = $borrowing->book;

        $hasActiveBorrowing = $book->borrowings()
            ->where('status', 'active')
            ->exists();

        if (! $hasActiveBorrowing) {
            $book->update([
                'status' => 'available',
            ]);

            // Everyone waiting for this book gets a database notification.
            $watchlistUsers = $book->watchlists()
                ->with('user')
                ->get()
                ->pluck('user')
                ->filter();

            foreach ($watchlistUsers as $watchlistUser) {
                $watchlistUser->notify(new BookAvailableNotification($book));
            }

            Watchlist::where('book_id', $book->id)->delete();
        }

        return redirect()->route('my.borrowings')
            ->with('success', 'Book returned successfully.');
    }
}
