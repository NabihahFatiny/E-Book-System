@extends('layouts.user')

@section('content')
    {{-- Page that shows database notifications for the logged-in user. --}}
    <h1 class="mb-6 text-3xl font-bold text-slate-900">My Notifications</h1>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-100 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($notifications->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-slate-600">
            You have no notifications yet.
        </div>
    @else
        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="rounded-2xl border p-5 shadow-sm {{ $notification->read_at ? 'border-slate-200 bg-white' : 'border-orange-200 bg-orange-50' }}">
                    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                        <div>
                            <p class="text-base font-semibold text-slate-900">
                                {{ $notification->data['message'] ?? 'Notification' }}
                            </p>

                            @if(!empty($notification->data['book_id']))
                                <a href="{{ route('books.show', $notification->data['book_id']) }}" class="mt-2 inline-block text-sm font-medium text-orange-600 hover:text-orange-700">
                                    View Book
                                </a>
                            @endif

                            <p class="mt-2 text-sm text-slate-500">
                                {{ $notification->created_at?->format('d M Y h:i A') }}
                            </p>
                        </div>

                        <div class="md:text-right">
                            {{-- Unread notifications can be marked as read from this page. --}}
                            @if(!$notification->read_at)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="rounded-lg bg-slate-900 px-4 py-2 font-semibold text-white transition hover:bg-slate-800"
                                    >
                                        Mark as Read
                                    </button>
                                </form>
                            @else
                                <span class="inline-block rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">
                                    Read
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
