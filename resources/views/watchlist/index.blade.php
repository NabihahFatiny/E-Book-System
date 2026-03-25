@extends('layouts.user')

@section('content')
    <h1 class="mb-6 text-3xl font-bold text-slate-900">My Watchlist</h1>

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

    @if($watchlists->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-slate-600">
            Your watchlist is empty.
        </div>
    @else
        <div class="space-y-4">
            @foreach($watchlists as $watchlist)
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                        <div>
                            <a href="{{ route('books.show', $watchlist->book) }}" class="text-xl font-semibold text-slate-900 hover:text-orange-600">
                                {{ $watchlist->book->title }}
                            </a>

                            @if($watchlist->book->authors->isNotEmpty())
                                <p class="mt-1 text-sm text-slate-600">
                                    {{ $watchlist->book->authors->pluck('name')->join(', ') }}
                                </p>
                            @endif

                            @if($watchlist->book->publisher)
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $watchlist->book->publisher->name }}
                                </p>
                            @endif

                            <p class="mt-2 text-sm text-slate-500">
                                Added on {{ $watchlist->created_at?->format('d M Y h:i A') }}
                            </p>
                        </div>

                        <div class="md:text-right">
                            <form action="{{ route('watchlist.destroy', $watchlist) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="rounded-lg bg-red-500 px-4 py-2 font-semibold text-white transition hover:bg-red-600"
                                >
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
