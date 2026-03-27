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
        <!-- Sidebar navigation for normal users. -->
        <aside class="w-64 bg-slate-900 text-white p-6">
            <h2 class="text-xl font-bold mb-6">USER</h2>
<nav class="space-y-2">
    <a href="{{ route('dashboard') }}"
       class="flex items-center gap-3 px-4 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('dashboard') ? 'bg-slate-700' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
        </svg>
        Dashboard
    </a>

    <a href="{{ route('my.borrowings') }}"
       class="flex items-center gap-3 px-4 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('my.borrowings') ? 'bg-slate-700' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
        </svg>
        Borrowings
    </a>

    <!-- Watchlist page: books the user is waiting for. -->
    <a href="{{ route('my.watchlist') }}"
       class="flex items-center gap-3 px-4 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('my.watchlist') ? 'bg-slate-700' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
        </svg>
        Watchlist
    </a>

    <!-- Notifications page: messages such as a watched book becoming available. -->
    <a href="{{ route('my.notifications') }}"
       class="flex items-center gap-3 px-4 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('my.notifications') ? 'bg-slate-700' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        Notifications
    </a>

    <a href="{{ route('profile.edit') }}"
       class="flex items-center gap-3 px-4 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('profile.*') ? 'bg-slate-700' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21a8 8 0 1 0-16 0"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
        Edit Profile
    </a>
</nav>

 <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit"
        class="flex items-center gap-3 w-full px-4 py-2 rounded text-left hover:bg-slate-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
        Logout
    </button>
</form>
        </aside>


        <!-- Every page that extends this layout will appear here. -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
