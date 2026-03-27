@extends('layouts.user')

@section('content')
    @php
        $availableCount = $watchlists->filter(fn ($watchlist) => $watchlist->book?->status === 'available')->count();
        $waitingCount = $watchlists->count() - $availableCount;
    @endphp

    <div class="space-y-6">
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-900 via-slate-800 to-orange-900 px-6 py-8 text-white shadow-xl sm:px-8">
            <div class="absolute -right-12 top-0 h-40 w-40 rounded-full bg-orange-400/20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-36 w-36 rounded-full bg-sky-400/10 blur-3xl"></div>

            <div class="relative flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <div class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>

                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-orange-300">Saved For Later</p>
                    <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">My Watchlist</h1>
                    <p class="mt-3 max-w-xl text-sm leading-6 text-slate-300 sm:text-base">
                        Keep track of books you want to read next, see what is already available, and jump back into any title in one tap.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3 lg:min-w-[420px]">
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-300">Saved</p>
                        <p class="mt-3 text-3xl font-bold">{{ $watchlists->count() }}</p>
                        <p class="mt-1 text-sm text-slate-300">Books in queue</p>
                    </div>

                    <div class="rounded-2xl border border-emerald-300/20 bg-emerald-400/10 p-4 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-200">Available</p>
                        <p class="mt-3 text-3xl font-bold">{{ $availableCount }}</p>
                        <p class="mt-1 text-sm text-emerald-100">Ready to open</p>
                    </div>

                    <div class="rounded-2xl border border-amber-300/20 bg-amber-400/10 p-4 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-amber-200">Waiting</p>
                        <p class="mt-3 text-3xl font-bold">{{ $waitingCount }}</p>
                        <p class="mt-1 text-sm text-amber-100">Still unavailable</p>
                    </div>
                </div>
            </div>
        </section>

        @if($watchlists->isEmpty())
            <section class="overflow-hidden rounded-[2rem] border border-dashed border-slate-300 bg-white shadow-sm">
                <div class="flex flex-col items-center px-6 py-14 text-center sm:px-10">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>

                    <h2 class="mt-6 text-2xl font-semibold text-slate-900">Your watchlist is empty</h2>
                    <p class="mt-3 max-w-md text-sm leading-6 text-slate-500">
                        Save books here when they are unavailable, and we will keep them in easy reach until you are ready to revisit them.
                    </p>
                </div>
            </section>
        @else
            <div class="grid gap-5 xl:grid-cols-2">
                @foreach($watchlists as $watchlist)
                    @php
                        $book = $watchlist->book;
                        $isAvailable = $book?->status === 'available';
                    @endphp

                    <article class="group overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                        <div class="grid gap-0 sm:grid-cols-[160px_1fr]">
                            <div class="relative h-56 overflow-hidden bg-slate-100 sm:h-full">
                                @if($book?->cover_image)
                                    <img
                                        src="{{ asset('storage/' . $book->cover_image) }}"
                                        alt="{{ $book->title }}"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                    >
                                @else
                                    <div class="flex h-full items-center justify-center bg-gradient-to-br from-orange-400 via-orange-500 to-rose-500 p-6 text-center text-white">
                                        <span class="text-lg font-bold leading-7">{{ $book?->title ?? 'Book' }}</span>
                                    </div>
                                @endif

                                <div class="absolute left-4 top-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] shadow-sm {{ $isAvailable ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $isAvailable ? 'Available' : 'Waiting' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col p-5 sm:p-6">
                                <div class="flex-1">
                                    <div class="flex flex-wrap items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <a
                                                href="{{ route('books.show', $book) }}"
                                                class="text-xl font-semibold leading-8 text-slate-900 transition hover:text-orange-600"
                                            >
                                                {{ $book->title }}
                                            </a>

                                            @if($book->authors->isNotEmpty())
                                                <p class="mt-2 text-sm text-slate-600">
                                                    {{ $book->authors->pluck('name')->join(', ') }}
                                                </p>
                                            @endif
                                        </div>

                                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 20h9"></path>
                                                <path d="M12 4h9"></path>
                                                <path d="M4 9h16"></path>
                                                <path d="M4 15h16"></path>
                                            </svg>
                                            Watchlist
                                        </span>
                                    </div>

                                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Publisher</p>
                                            <p class="mt-2 text-sm font-medium text-slate-700">{{ $book->publisher?->name ?: 'Not available' }}</p>
                                        </div>

                                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Saved on</p>
                                            <p class="mt-2 text-sm font-medium text-slate-700">{{ $watchlist->created_at?->format('d M Y h:i A') }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-4 rounded-2xl px-4 py-3 text-sm {{ $isAvailable ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                        {{ $isAvailable ? 'This book is available now. You can open its details and borrow or read it right away.' : 'This book is still unavailable. Keep it here and check back when a copy becomes available.' }}
                                    </div>
                                </div>

                                <div class="mt-5 flex flex-col gap-3 sm:flex-row">
                                    <a
                                        href="{{ route('books.show', $book) }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                        </svg>
                                        View Details
                                    </a>

                                    <form action="{{ route('watchlist.destroy', $watchlist) }}" method="POST" class="sm:flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-600 transition hover:bg-rose-100"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18"></path>
                                                <path d="M8 6V4h8v2"></path>
                                                <path d="M19 6l-1 14H6L5 6"></path>
                                                <path d="M10 11v6"></path>
                                                <path d="M14 11v6"></path>
                                            </svg>
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
@endsection
