<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'GEC') }}</title>

    <!-- Tailwind + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" />
</head>

<body class="flex h-screen font-poppins bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-indigo-700 text-white flex flex-col">
        <div class="flex px-6 py-3">
            <img src="{{ asset('image/logo.png') }}" alt="logo" class="h-10 w-auto">
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block p-3 rounded hover:bg-indigo-600">
                <i class="fa-solid fa-house ml-2"></i> Dashboard
            </a>
            <a href="" class="block p-3 rounded hover:bg-indigo-600">
                <i class="fa-solid fa-file ml-2"></i> Courriers
            </a>
            <a href="" class="block p-3 rounded hover:bg-indigo-600">
                <i class="fa-solid fa-tower-broadcast ml-2"></i> Transmissions
            </a>
            <a href="{{ route('archive') }}" class="block p-3 rounded hover:bg-indigo-600">
                <i class="fa-solid fa-folder ml-2"></i> Archives
            </a>
            <a href="{" class="block p-3 rounded hover:bg-indigo-600">
                <i class="fa-solid fa-users ml-2"></i> Utilisateurs
            </a>
        </nav>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col">

        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <form class="flex-1">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
                    <input type="search"
                        placeholder="Recherche Courrier..."
                        class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-600">
                </div>
            </form>

            <!-- User Info + Logout -->
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-auto p-6">
            @yield('content')
        </main>

    </div>

</body>

</html>