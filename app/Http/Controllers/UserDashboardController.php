<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $categoryFilter = $request->category;
        $authorFilter = $request->author;
        $publisherFilter = $request->publisher;

        $books = Book::with(['authors', 'publisher', 'categories'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhere('isbn', 'like', '%' . $search . '%')
                        ->orWhereHas('authors', fn ($inner) => $inner->where('name', 'like', '%' . $search . '%'))
                        ->orWhereHas('publisher', fn ($inner) => $inner->where('name', 'like', '%' . $search . '%'))
                        ->orWhereHas('categories', fn ($inner) => $inner->where('name', 'like', '%' . $search . '%'));
                });
            })
            ->when($categoryFilter, function ($query) use ($categoryFilter) {
                $query->whereHas('categories', fn ($q) => $q->where('categories.id', $categoryFilter));
            })
            ->when($authorFilter, function ($query) use ($authorFilter) {
                $query->whereHas('authors', fn ($q) => $q->where('authors.id', $authorFilter));
            })
            ->when($publisherFilter, function ($query) use ($publisherFilter) {
                $query->where('publisher_id', $publisherFilter);
            })
            ->latest()
            ->get();

        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        return view('dashboard', compact('books', 'search', 'categories', 'authors', 'publishers'));
    }

    public function show(Request $request, Book $book)
    {
        $book->load(['authors', 'publisher', 'categories']);

        $activeBorrowing = $request->user()
            ->borrowings()
            ->where('book_id', $book->id)
            ->where('status', 'active')
            ->first();

        $bookHasActiveBorrower = $book->borrowings()
            ->where('status', 'active')
            ->exists();

        $canRead = (bool) $activeBorrowing;
        $canBorrow = ! $bookHasActiveBorrower;

        return view('books.show', compact('book', 'activeBorrowing', 'canRead', 'canBorrow'));
    }
}
