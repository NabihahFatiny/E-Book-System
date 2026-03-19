@extends('layouts.user')

@section('content')
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">
            Back to dashboard
        </a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
        <div class="grid gap-8 p-8 lg:grid-cols-[260px_minmax(0,1fr)]">
            <div>
                <div class="overflow-hidden rounded-2xl bg-gradient-to-br from-orange-300 via-orange-500 to-orange-700 p-4 text-white shadow-sm">
                    <div class="aspect-[3/4] overflow-hidden rounded-xl bg-white/10">
                        @if($book->cover_image)
                            <img
                                src="{{ asset('storage/' . $book->cover_image) }}"
                                alt="{{ $book->title }}"
                                class="h-full w-full object-cover"
                            >
                        @else
                            <div class="flex h-full items-center justify-center px-6 text-center">
                                <div>
                                    <p class="text-sm uppercase tracking-[0.3em] text-white/70">Novel</p>
                                    <p class="mt-4 text-3xl font-bold leading-tight">{{ $book->title }}</p>
                                    @if($book->authors->isNotEmpty())
                                        <p class="mt-6 text-sm text-white/80">
                                            {{ $book->authors->pluck('name')->join(' - ') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <button
                    type="button"
                    class="mt-5 w-full rounded-2xl bg-orange-600 px-6 py-4 text-lg font-semibold text-white hover:bg-orange-700"
                >
                    Read
                </button>
            </div>

            <div>
                <div class="flex flex-wrap items-center gap-4">
                    <h1 class="text-4xl font-bold text-slate-900">{{ $book->title }}</h1>

                    <div class="flex items-center gap-3 text-2xl text-slate-600">
                        <span>&mdash;</span>

                        @if($book->status === 'available')
                            <span class="rounded-full bg-green-100 px-4 py-1 text-lg font-semibold text-green-700">
                                Available
                            </span>
                        @else
                            <span class="rounded-full bg-yellow-100 px-4 py-1 text-lg font-semibold text-yellow-700">
                                Borrowed
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-8 space-y-5 text-slate-800">
                    <div class="grid gap-3 sm:grid-cols-[140px_minmax(0,1fr)]">
                        <p class="text-2xl font-semibold">ISBN</p>
                        <p class="text-2xl">{{ $book->isbn ?: '-' }}</p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-[140px_minmax(0,1fr)]">
                        <p class="text-2xl font-semibold">Authors</p>
                        <div class="flex flex-wrap gap-3">
                            @forelse($book->authors as $author)
                                <span class="rounded-full bg-amber-100 px-4 py-1 text-xl font-medium text-amber-800">
                                    {{ $author->name }}
                                </span>
                            @empty
                                <span class="text-2xl">-</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-[140px_minmax(0,1fr)]">
                        <p class="text-2xl font-semibold">Categories</p>
                        <div class="flex flex-wrap gap-3">
                            @forelse($book->categories as $category)
                                <span class="rounded-full bg-blue-100 px-4 py-1 text-xl font-medium text-blue-800">
                                    {{ $category->name }}
                                </span>
                            @empty
                                <span class="text-2xl">-</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-[140px_minmax(0,1fr)]">
                        <p class="text-2xl font-semibold">Publisher</p>
                        <p class="text-2xl">{{ $book->publisher?->name ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h2 class="text-2xl font-semibold text-slate-800">Description</h2>
                    <p class="mt-3 text-xl leading-relaxed text-slate-700">
                        {{ $book->description ?: 'No description available.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
