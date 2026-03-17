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
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
