@extends('layouts.user')

@section('content')

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-100 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-xl bg-red-100 px-4 py-3 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="flex items-center text-sm font-medium text-slate-500 transition-colors hover:text-orange-600">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to dashboard
        </a>
    </div>

    <div class="max-w-5xl overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="grid gap-10 p-8 lg:grid-cols-[240px_1fr]">

            <div>
                <div class="relative aspect-[3/4] overflow-hidden rounded-2xl bg-orange-100 shadow-md">
                    @if($book->cover_image)
                        <img
                            src="{{ asset('storage/' . $book->cover_image) }}"
                            alt="{{ $book->title }}"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <div class="flex h-full items-center justify-center bg-gradient-to-br from-orange-400 to-orange-600 p-6 text-center text-white">
                            <span class="text-xl font-bold italic">{{ $book->title }}</span>
                        </div>
                    @endif
                </div>

                <div class="mt-6">
                    @if($canRead)
                        <a
                            href="{{ route('books.read', $book) }}"
                            class="block w-full rounded-xl bg-slate-900 px-6 py-3 text-center text-lg font-bold text-white shadow-lg shadow-slate-200 transition-all hover:bg-slate-800"
                        >
                            Read Now
                        </a>
                    @elseif($canBorrow)
                        <form action="{{ route('borrowings.store', $book) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full rounded-xl bg-[#E85D33] px-6 py-3 text-lg font-bold text-white shadow-lg shadow-orange-200 transition-all hover:bg-orange-700 active:scale-95">
                                Borrow to Read
                            </button>
                        </form>
                    @else
                        <button
                            type="button"
                            disabled
                            class="w-full cursor-not-allowed rounded-xl bg-slate-300 px-6 py-3 text-lg font-bold text-slate-600"
                        >
                            Currently Unavailable
                        </button>
                    @endif
                </div>
            </div>

            <div class="flex flex-col">
                <div class="flex items-center gap-4">
                    <h1 class="text-3xl font-extrabold text-slate-800">{{ $book->title }}</h1>

                    <span class="text-2xl text-slate-300">&mdash;</span>

                    @if($book->status === 'available')
                        <span class="rounded-full bg-[#D1FAE5] px-4 py-1 text-sm font-bold text-[#065F46]">
                            Available
                        </span>
                    @else
                        <span class="rounded-full bg-[#FEF3C7] px-4 py-1 text-sm font-bold text-[#92400E]">
                            Borrowed
                        </span>
                    @endif
                </div>

                <div class="mt-8 space-y-4">
                    <div class="grid grid-cols-[100px_1fr] items-center gap-4">
                        <span class="text-base font-bold text-slate-900 uppercase tracking-tight">Isbn</span>
                        <span class="text-base font-medium text-slate-600">{{ $book->isbn ?: 'N/A' }}</span>
                    </div>

                    <div class="grid grid-cols-[100px_1fr] items-center gap-4">
                        <span class="text-base font-bold text-slate-900 uppercase tracking-tight">Authors</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($book->authors as $author)
                                <span class="rounded-full bg-[#FEF3C7] px-4 py-1 text-sm font-bold text-[#92400E]">
                                    {{ $author->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-[100px_1fr] items-center gap-4">
                        <span class="text-base font-bold text-slate-900 uppercase tracking-tight">Categories</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($book->categories as $category)
                                <span class="rounded-full bg-[#DBEAFE] px-4 py-1 text-sm font-bold text-[#1E40AF]">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-[100px_1fr] items-center gap-4">
                        <span class="text-base font-bold text-slate-900 uppercase tracking-tight">Publisher</span>
                        <span class="text-base font-medium text-slate-600">{{ $book->publisher?->name ?: '-' }}</span>
                    </div>
                </div>

                <div class="my-8 h-px w-full bg-slate-100"></div>

                @if($activeBorrowing)
                    <div class="mb-8 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                        <p class="font-semibold">Your borrowing is active.</p>
                        <p class="mt-1 text-sm">
                            Borrowed {{ $activeBorrowing->borrowed_at?->format('d M Y H:i') }}.
                            Due {{ $activeBorrowing->due_at?->format('d M Y H:i') ?? 'N/A' }}.
                        </p>
                    </div>
                @endif

                <div>
                    <h2 class="text-lg font-bold text-slate-900 uppercase tracking-tight">Description</h2>
                    <p class="mt-2 text-base leading-relaxed text-slate-500">
                        {{ $book->description ?: 'No description available for this book.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
