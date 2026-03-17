@extends('layouts.user')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <form method="GET" action="{{ route('dashboard') }}" class="mb-6 flex justify-between items-center gap-4">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search by title, author, publisher, ISBN, category..."
            class="w-full max-w-xl rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-slate-400"
        >

        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-white hover:bg-slate-800">
            Search
        </button>
    </form>

    @if($books->isEmpty())
        <p class="text-gray-600">No books found.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach($books as $book)
                <div class="rounded-xl bg-white p-4 shadow-sm border border-gray-200">
                    <div class="h-48 flex items-center justify-center rounded-lg bg-gray-100 mb-4 overflow-hidden">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                 alt="{{ $book->title }}"
                                 class="h-full w-full object-cover">
                        @else
                            <div class="text-gray-400 text-sm">No Image</div>
                        @endif
                    </div>

                    <h2 class="font-semibold text-lg line-clamp-2">{{ $book->title }}</h2>

                    @if($book->author)
    <p class="text-sm text-gray-700 mt-1">{{ $book->author->name }}</p>
@endif

@if($book->publisher)
    <p class="text-sm text-gray-600">{{ $book->publisher->name }}</p>
@endif

@if($book->category)
    <p class="text-sm text-gray-500">{{ $book->category->name }}</p>
@endif

                    <div class="mt-3">
                        @if($book->status === 'available')
                            <span class="inline-block rounded-full bg-green-100 px-3 py-1 text-sm text-green-700">
                                Available
                            </span>
                        @else
                            <span class="inline-block rounded-full bg-yellow-100 px-3 py-1 text-sm text-yellow-700">
                                Borrowed
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
