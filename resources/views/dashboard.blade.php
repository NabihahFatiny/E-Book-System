@extends('layouts.user')

@section('content')
    <h1 class="mb-6 text-3xl font-bold">Dashboard</h1>

    @if(session('success'))
    <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-green-700">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-red-700">
        {{ session('error') }}
    </div>
@endif

    <div x-data="{ open: false }" class="mb-6">
        <form method="GET" action="{{ route('dashboard') }}">
            <div class="mb-4 flex items-center gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by title, author, publisher, ISBN, category..."
                    class="w-full max-w-xl rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-slate-400"
                >

                <button type="button" @click="open = !open" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>

                <button type="submit" class="rounded-lg bg-slate-900 px-6 py-2 font-bold text-white hover:bg-slate-800">
                    Search
                </button>
            </div>

            <div x-show="open" x-cloak x-transition class="mb-6 rounded-xl border border-gray-200 bg-gray-50 p-6 shadow-sm">
                <p class="mb-4 text-xs font-bold uppercase tracking-wider text-gray-500">Filter By</p>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Category</label>
                        <select name="category" class="w-full rounded-lg border-gray-300 text-sm focus:ring-slate-400">
                            <option value="">All categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Author</label>
                        <select name="author" class="w-full rounded-lg border-gray-300 text-sm focus:ring-slate-400">
                            <option value="">All authors</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Publisher</label>
                        <select name="publisher" class="w-full rounded-lg border-gray-300 text-sm focus:ring-slate-400">
                            <option value="">All publishers</option>
                            @foreach($publishers as $publisher)
                                <option value="{{ $publisher->id }}" {{ request('publisher') == $publisher->id ? 'selected' : '' }}>
                                    {{ $publisher->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex gap-2">
                    <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white">Apply Filters</button>
                    <a href="{{ route('dashboard') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Clear</a>
                </div>
            </div>
        </form>
    </div>

    @if($books->isEmpty())
        <p class="text-gray-600">No books found.</p>
    @else
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
            @foreach($books as $book)
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:-translate-y-1 hover:shadow-md">

        <a href="{{ route('books.show', $book) }}" class="block">
            <div class="mb-4 flex h-48 items-center justify-center overflow-hidden rounded-lg bg-gray-100">
                @if($book->cover_image)
                    <img
                        src="{{ asset('storage/' . $book->cover_image) }}"
                        alt="{{ $book->title }}"
                        class="h-full w-full object-cover"
                    >
                @else
                    <div class="text-sm text-gray-400">No Image</div>
                @endif
            </div>

            <h2 class="line-clamp-2 text-lg font-semibold">{{ $book->title }}</h2>

            @if($book->authors->isNotEmpty())
                <p class="mt-1 text-sm text-gray-700">{{ $book->authors->pluck('name')->join(', ') }}</p>
            @endif

            @if($book->publisher)
                <p class="text-sm text-gray-600">{{ $book->publisher->name }}</p>
            @endif

            @if($book->categories->isNotEmpty())
                <p class="text-sm text-gray-500">{{ $book->categories->pluck('name')->join(', ') }}</p>
            @endif
        </a>

        <div class="mt-3 flex items-center justify-between gap-2">
            <div>
                <div class="mt-3 flex items-center justify-between gap-2">
    <div>
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

    <div class="flex gap-2">
        <a href="{{ route('books.show', $book) }}"
           class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
            View
        </a>
    </div>
</div>
            </div>
        </div>
    </div>
@endforeach
        </div>
    @endif
@endsection
