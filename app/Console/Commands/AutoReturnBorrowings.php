<?php

namespace App\Console\Commands;

use App\Models\Watchlist;
use App\Notifications\BookAvailableNotification;
use Illuminate\Console\Command;
use App\Models\Borrowing;

class AutoReturnBorrowings extends Command
{
    protected $signature = 'borrowings:auto-return';

    protected $description = 'Automatically return expired borrowings';

    public function handle(): int
    {
        $expiredBorrowings = Borrowing::with('book')
            ->where('status', 'active')
            ->where('due_at', '<=', now())
            ->get();

        foreach ($expiredBorrowings as $borrowing) {
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
        }

        return self::SUCCESS;
    }
}
