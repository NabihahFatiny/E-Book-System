<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['book.authors', 'book.publisher'])
            ->where('user_id', Auth::id())
            ->latest('borrowed_at')
            ->get();

        return view('my-borrowings', compact('borrowings'));
    }

    public function store(Book $book)
    {
        $user = Auth::user();

        $existingBorrowing = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'active')
            ->first();

        if ($existingBorrowing) {
            return redirect()->route('books.read', $book)
                ->with('success', 'You already have access to this book.');
        }

        $bookBorrowedByAnotherUser = Borrowing::where('book_id', $book->id)
            ->where('status', 'active')
            ->exists();

        if ($bookBorrowedByAnotherUser) {
            return redirect()->route('books.show', $book)
                ->with('error', 'This book is currently borrowed by another user.');
        }

        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_at' => now()->addDay(),
            'status' => 'active',
        ]);

        $book->update(['status' => 'borrowed']);

        return redirect()->route('books.read', $book)
            ->with('success', 'Book borrowed successfully.');
    }

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
}
