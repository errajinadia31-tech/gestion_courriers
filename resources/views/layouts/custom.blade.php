<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Nadia Erraji - Full-stack Developer / Acteur">
    <meta name="role" content="Developer">
    <title>@yield('title', config('app.name', 'GEC'))</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" />
    <link rel="shortcut icon" href="{{ asset('image/icon.ico') }}" type="image/x-icon">
</head>

<body class="flex h-screen  bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-indigo-700 text-white flex flex-col h-screen">
        <div class="flex px-6 py-3">
            <img src="{{ asset('image/logo.png') }}" alt="logo" class="h-10 w-auto">
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block p-3 rounded hover:bg-indigo-800 {{ request()->routeIs('dashboard') ? 'bg-indigo-800' : '' }}">
                <i class="fa-solid fa-house ml-2"></i> Dashboard
            </a>
            <a href="{{ route('courrier') }}" class="block p-3 rounded hover:bg-indigo-800 {{ request()->routeIs('courrier') ? 'bg-indigo-800' : '' }}">
                <i class="fa-solid fa-file ml-2"></i> Courriers
            </a>
            <a href="{{ route('transmissions.list') }}" class="block p-3 rounded hover:bg-indigo-800 {{ request()->routeIs('transmissions.*') ? 'bg-indigo-800' : '' }}">
                <i class="fa-solid fa-tower-broadcast ml-2"></i> Transmissions
            </a>
            <a href="{{ route('archive') }}" class="block p-3 rounded hover:bg-indigo-800 {{ request()->routeIs('archive') ? 'bg-indigo-800' : '' }}">
                <i class="fa-solid fa-folder ml-2"></i> Archives
            </a>
        </nav>

      <footer class="mt-auto text-xs pb-4 text-center text-white">
    &copy; {{ date('Y') }} GEC - Gestion de Courrier. All rights reserved.
    <a href="#" class="text-blue-400 hover:underline">Privacy Policy </a> <br>
</footer>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
     <header class="bg-white shadow p-4">
    <div class="flex items-center justify-between">
        <!-- Search Bar -->
        <form method="GET" action="{{ route('courrier') }}" class="flex items-center space-x-2">
            <div class="relative w-64">
                <input
                    type="text"
                    name="search"
                    placeholder="Recherche Courrier..."
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                <span class="absolute inset-y-0 right-3 flex items-center text-gray-400 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
            </div>
        </form>

        <div class="relative inline-block text-left">
            <button type="button"
                class="inline-flex justify-center items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
                onclick="document.getElementById('userDropdown').classList.toggle('hidden')">
                {{ Auth::user()->name }}
                <i class="fa-solid fa-chevron-down ml-2"></i>
            </button>

            <div id="userDropdown" class="absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-50">
                <div class="py-1">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fa-solid fa-user"></i> Profile
                    </a>
                    <button onclick="openLogoutModal()"
                        class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        <i class="fa-solid fa-right-from-bracket"></i> Se déconnecter
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-lg w-96 p-6 text-center relative">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Se déconnecter</h2>
            <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir vous déconnecter ?</p>
            <div class="flex justify-center gap-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                        Oui
                    </button>
                </form>
                <button onclick="closeLogoutModal()" class="bg-gray-300 text-gray-700 px-5 py-2 rounded-lg hover:bg-gray-400 transition">
                    Non
                </button>
            </div>
            <button onclick="closeLogoutModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <script>
        function openLogoutModal() {
            document.getElementById('logoutModal').classList.remove('hidden');
            document.getElementById('userDropdown').classList.add('hidden');
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.add('hidden');
        }

        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const button = dropdown.previousElementSibling;
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</header>

        <main class="flex-1 overflow-auto p-6">
            @yield('content')
        </main>

    </div>

</body>

</html>