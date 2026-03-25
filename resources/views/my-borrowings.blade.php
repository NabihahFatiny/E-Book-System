@extends('layouts.user')

@section('content')
    {{-- Page that lists the logged-in user's borrowing records. --}}
    <h1 class="mb-6 text-3xl font-bold text-slate-900">My Borrowings</h1>

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

                            @if($borrowing->returned_at)
                                <p class="mt-1">Returned: {{ $borrowing->returned_at?->format('d M Y H:i') }}</p>
                            @endif

                            {{-- Only active borrowings can still be returned by the user. --}}
                            @if($borrowing->status === 'active')
                                <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="rounded-lg bg-red-500 px-4 py-2 font-semibold text-white transition hover:bg-red-600"
                                    >
                                        Return Book
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
