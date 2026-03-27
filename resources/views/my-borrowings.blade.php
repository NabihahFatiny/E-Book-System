@extends('layouts.user')

@section('content')
    @php
        $activeCount = $borrowings->where('status', 'active')->count();
        $returnedCount = $borrowings->where('status', 'returned')->count();
        $coverThemes = [
            'from-amber-300 via-amber-400 to-amber-500 shadow-amber-200 text-white',
            'from-emerald-300 via-emerald-500 to-emerald-700 shadow-emerald-200 text-white',
            'from-indigo-300 via-blue-500 to-indigo-600 shadow-blue-200 text-white',
            'from-rose-300 via-orange-400 to-orange-500 shadow-orange-200 text-white',
        ];
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

        <section class="relative overflow-hidden rounded-[2rem] bg-slate-900 px-6 py-8 text-white shadow-xl sm:px-8">
            <div class="absolute -right-12 top-0 h-40 w-40 rounded-full bg-orange-500/20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-36 w-36 rounded-full bg-cyan-400/10 blur-3xl"></div>

            <div class="relative flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                    </div>

                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-orange-300">Reading Shelf</p>
                    <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">My Borrowings</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300 sm:text-base">
                        View and manage all the books you’ve borrowed in one place, including due dates and return status
                </div>

                <div class="grid gap-3 sm:grid-cols-3 lg:min-w-[420px]">
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-300">Total</p>
                        <p class="mt-3 text-3xl font-bold">{{ $borrowings->count() }}</p>
                        <p class="mt-1 text-sm text-slate-300">Borrowing records</p>
                    </div>
                    <div class="rounded-2xl border border-orange-300/20 bg-orange-400/10 p-4 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-orange-200">Active</p>
                        <p class="mt-3 text-3xl font-bold">{{ $activeCount }}</p>
                        <p class="mt-1 text-sm text-orange-100">Currently borrowed</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-300/20 bg-emerald-400/10 p-4 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-200">Returned</p>
                        <p class="mt-3 text-3xl font-bold">{{ $returnedCount }}</p>
                        <p class="mt-1 text-sm text-emerald-100">Completed history</p>
                    </div>
                </div>
            </div>
        </section>

        @if($borrowings->isEmpty())
            <section class="rounded-[2rem] border border-dashed border-[#ddd0bd] bg-[#fbf8f2] px-6 py-16 text-center shadow-sm">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-white text-[#9f8f78] shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-2xl font-semibold text-[#2f2a24]">No borrowings yet</h2>
                <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-[#7a6d5c]">
                    Borrowed books will appear here in the same compact card layout, with due times and return actions ready to use.
                </p>
            </section>
        @else
            <div class="space-y-4">
                @foreach($borrowings as $borrowing)
                    @php
                        $book = $borrowing->book;
                        $isReturned = $borrowing->status === 'returned';
                        $isOverdue = $borrowing->status === 'active' && $borrowing->due_at && $borrowing->due_at->isPast();
                        $theme = $coverThemes[$loop->index % count($coverThemes)];
                        $initial = strtoupper(\Illuminate\Support\Str::substr($book?->title ?? 'B', 0, 1));
                    @endphp

                    <article class="rounded-[1.75rem] border border-[#e6d9c6] bg-[#fcfaf6] px-5 py-5 shadow-[0_10px_24px_rgba(108,85,53,0.08)] transition hover:-translate-y-0.5 hover:shadow-[0_14px_30px_rgba(108,85,53,0.12)] sm:px-6">
                        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex min-w-0 items-start gap-4 sm:gap-5">
                                <a href="{{ route('books.show', $book) }}" class="shrink-0">
                                    @if($book?->cover_image)
                                        <img
                                            src="{{ asset('storage/' . $book->cover_image) }}"
                                            alt="{{ $book->title }}"
                                            class="h-20 w-14 rounded-xl object-cover shadow-md"
                                        >
                                    @else
                                        <div class="flex h-20 w-14 items-center justify-center rounded-xl bg-gradient-to-br text-3xl font-bold shadow-md {{ $theme }}">
                                            {{ $initial }}
                                        </div>
                                    @endif
                                </a>

                                <div class="min-w-0">
                                    <a
                                        href="{{ route('books.show', $book) }}"
                                        class="block truncate text-2xl font-semibold leading-tight text-[#2f2a24] transition hover:text-[#b46a3a] sm:max-w-[280px] lg:max-w-[360px]"
                                        title="{{ $book->title }}"
                                    >
                                        {{ $book->title }}
                                    </a>

                                    @if($book->authors->isNotEmpty())
                                        <p class="mt-1 text-lg leading-6 text-[#5f564b]">
                                            {{ $book->authors->pluck('name')->join(', ') }}
                                        </p>
                                    @endif

                                    <p class="mt-1 text-base uppercase tracking-wide text-[#a19381]">
                                        {{ $book->publisher?->name ?: 'Publisher not available' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-8">
                                <div class="min-w-[240px]">
                                    <div class="mb-3 flex justify-start lg:justify-center">
                                        <span class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-semibold uppercase tracking-[0.14em]
                                            {{ $isReturned ? 'bg-emerald-100 text-emerald-700' : ($isOverdue ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                            <span class="mr-2 h-2 w-2 rounded-full
                                                {{ $isReturned ? 'bg-emerald-500' : ($isOverdue ? 'bg-rose-500' : 'bg-amber-500') }}"></span>
                                            {{ $isReturned ? 'Returned' : ($isOverdue ? 'Overdue' : 'Active') }}
                                        </span>
                                    </div>

                                    <div class="space-y-1 text-sm sm:text-base">
                                        <div class="grid grid-cols-[92px_1fr] items-center gap-3">
                                            <span class="text-right text-xs font-semibold uppercase tracking-[0.18em] text-[#b9aa97] sm:text-sm">Borrowed</span>
                                            <span class="font-medium text-[#6e6357]">{{ $borrowing->borrowed_at?->format('d M Y - H:i') ?? 'N/A' }}</span>
                                        </div>
                                        <div class="grid grid-cols-[92px_1fr] items-center gap-3">
                                            <span class="text-right text-xs font-semibold uppercase tracking-[0.18em] text-[#b9aa97] sm:text-sm">Due</span>
                                            <span class="font-medium {{ $isOverdue ? 'text-rose-700' : 'text-[#6e6357]' }}">
                                                {{ $borrowing->due_at?->format('d M Y - H:i') ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="grid grid-cols-[92px_1fr] items-center gap-3">
                                            <span class="text-right text-xs font-semibold uppercase tracking-[0.18em] text-[#b9aa97] sm:text-sm">Returned</span>
                                            <span class="font-medium {{ $isReturned ? 'text-emerald-700' : 'text-[#b7aa98]' }}">
                                                {{ $borrowing->returned_at?->format('d M Y - H:i') ?? 'Not returned yet' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="lg:min-w-[150px]">
                                    @if($isReturned)
                                        <form action="{{ route('borrowings.destroy', $borrowing) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-[#eed7d0] bg-white px-5 py-3 text-sm font-medium text-[#dc5d4c] transition hover:border-[#e4b7ae] hover:bg-[#fff5f3]"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M3 6h18"></path>
                                                    <path d="M8 6V4h8v2"></path>
                                                    <path d="M19 6l-1 14H6L5 6"></path>
                                                    <path d="M10 11v6"></path>
                                                    <path d="M14 11v6"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('borrowings.return', $borrowing) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-[#efd7c7] bg-[#fff5ef] px-5 py-3 text-sm font-medium text-[#c96d39] transition hover:border-[#e7b99d] hover:bg-[#ffede2]"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M9 14 4 9l5-5"></path>
                                                    <path d="M20 20V10a4 4 0 0 0-4-4H4"></path>
                                                </svg>
                                                Return Book
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
@endsection
