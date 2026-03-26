@extends('layouts.user')

@section('content')
    @php
        $unreadCount = $notifications->whereNull('read_at')->count();
        $readCount = $notifications->count() - $unreadCount;
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
                <div class="max-w-2xl">
                    <div class="mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </div>

                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-orange-300">Notification Center</p>
                    <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">My Notifications</h1>
                    <p class="mt-3 max-w-xl text-sm leading-6 text-slate-300 sm:text-base">
                        Stay on top of book availability updates and recent activity from your account.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3 lg:min-w-[420px]">
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-300">Total</p>
                        <p class="mt-3 text-3xl font-bold">{{ $notifications->count() }}</p>
                        <p class="mt-1 text-sm text-slate-300">All messages</p>
                    </div>

                    <div class="rounded-2xl border border-orange-300/20 bg-orange-400/10 p-4 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-orange-200">Unread</p>
                        <p class="mt-3 text-3xl font-bold">{{ $unreadCount }}</p>
                        <p class="mt-1 text-sm text-orange-100">Pending Review</p>
                    </div>

                    <div class="rounded-2xl border border-emerald-300/20 bg-emerald-400/10 p-4 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-200">Read</p>
                        <p class="mt-3 text-3xl font-bold">{{ $readCount }}</p>
                        <p class="mt-1 text-sm text-emerald-100">Reviewed items</p>
                    </div>
                </div>
            </div>
        </section>

        @if($notifications->isEmpty())
            <section class="overflow-hidden rounded-[2rem] border border-dashed border-slate-300 bg-white shadow-sm">
                <div class="flex flex-col items-center px-6 py-14 text-center sm:px-10">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </div>

                    <h2 class="mt-6 text-2xl font-semibold text-slate-900">No notifications yet</h2>
                    <p class="mt-3 max-w-md text-sm leading-6 text-slate-500">
                        When a book from your watchlist becomes available, it will appear here with quick actions so you can jump straight to it.
                    </p>
                </div>
            </section>
        @else
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    @php
                        $isUnread = is_null($notification->read_at);
                        $bookTitle = $notification->data['book_title'] ?? null;
                    @endphp

                    <article class="group relative overflow-hidden rounded-[2rem] border bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg sm:p-6 {{ $isUnread ? 'border-orange-200 shadow-orange-100/60' : 'border-slate-200' }}">
                        <div class="absolute inset-y-0 left-0 w-1.5 {{ $isUnread ? 'bg-orange-400' : 'bg-slate-200' }}"></div>

                        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex gap-4">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl {{ $isUnread ? 'bg-orange-100 text-orange-600' : 'bg-slate-100 text-slate-500' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                    </svg>
                                </div>

                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] {{ $isUnread ? 'bg-orange-100 text-orange-700' : 'bg-slate-100 text-slate-600' }}">
                                            {{ $isUnread ? 'Unread' : 'Read' }}
                                        </span>

                                        <span class="text-xs font-medium uppercase tracking-[0.18em] text-slate-400">Book Update</span>
                                    </div>

                                    <p class="mt-4 text-lg font-semibold leading-7 text-slate-900">
                                        {{ $notification->data['message'] ?? 'Notification' }}
                                    </p>

                                    @if($bookTitle)
                                        <p class="mt-2 text-sm font-medium text-slate-600">
                                            Title: <span class="text-slate-900">{{ $bookTitle }}</span>
                                        </p>
                                    @endif

                                    <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-slate-500">
                                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                            {{ $notification->created_at?->format('d M Y h:i A') }}
                                        </span>

                                        @if($notification->read_at)
                                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-emerald-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M20 6 9 17l-5-5"></path>
                                                </svg>
                                                Read {{ $notification->read_at?->format('d M Y h:i A') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row lg:w-auto lg:flex-col lg:items-stretch">
                                @if(!empty($notification->data['book_id']))
                                    <a
                                        href="{{ route('books.show', $notification->data['book_id']) }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-orange-200 hover:text-orange-600"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                        </svg>
                                        View Book
                                    </a>
                                @endif

                                @if($isUnread)
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            type="submit"
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg>
                                            Mark as Read
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
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
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
@endsection
