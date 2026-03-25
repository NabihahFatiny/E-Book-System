@extends('layouts.user')

@section('content')
    <h1 class="mb-6 text-3xl font-bold text-slate-900">My Borrowings</h1>

    @if($borrowings->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-slate-600">
            You have not borrowed any books yet.
        </div>
    @else
        <div class="space-y-4">
            @foreach($borrowings as $borrowing)
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                        <div>
                            <a href="{{ route('books.show', $borrowing->book) }}" class="text-xl font-semibold text-slate-900 hover:text-orange-600">
                                {{ $borrowing->book->title }}
                            </a>

                            @if($borrowing->book->authors->isNotEmpty())
                                <p class="mt-1 text-sm text-slate-600">
                                    {{ $borrowing->book->authors->pluck('name')->join(', ') }}
                                </p>
                            @endif

                            @if($borrowing->book->publisher)
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $borrowing->book->publisher->name }}
                                </p>
                            @endif
                        </div>

                        <div class="text-sm text-slate-600 md:text-right">
                            <span class="inline-block rounded-full px-3 py-1 font-semibold {{ $borrowing->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($borrowing->status) }}
                            </span>
                            <p class="mt-3">Borrowed: {{ $borrowing->borrowed_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                            <p class="mt-1">Due: {{ $borrowing->due_at?->format('d M Y H:i') ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
