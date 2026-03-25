<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white p-6">
            <h2 class="text-xl font-bold mb-6">USER</h2>

            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('dashboard') ? 'bg-slate-700' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('my.borrowings') }}"
                   class="block px-4 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('my.borrowings') ? 'bg-slate-700' : '' }}">
                    My Borrowings
                </a>


                <a href="{{ route('my.watchlist') }}"
   class="block px-4 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('my.watchlist') ? 'bg-slate-700' : '' }}">
    My Watchlist
</a>

<a href="{{ route('my.notifications') }}"
   class="block px-4 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('my.notifications') ? 'bg-slate-700' : '' }}">
    My Notifications
</a>

    <form method="POST" action="{{ route('logout') }}" class="mt-6">
    @csrf
    <button type="submit"
        class="block w-full rounded-lg px-4 py-3 text-left text-white hover:bg-slate-700">
        Logout
    </button>
</form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
