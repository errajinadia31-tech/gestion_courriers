<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', config('app.name', 'GEC'))</title>
    <!-- Tailwind + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" />
</head>

<body class="flex h-screen font-poppins bg-gray-100">

    <!-- Sidebar -->
<aside class="w-64 bg-indigo-700 text-white flex flex-col h-screen">
    <div class="flex px-6 py-3">
        <img src="{{ asset('image/logo.png') }}" alt="logo" class="h-10 w-auto">
    </div>
    <nav class="flex-1 p-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="block p-3 rounded hover:bg-indigo-800 {{ request()->routeIs('dashboard') ? 'bg-indigo-800' : '' }}">
            <i class="fa-solid fa-house ml-2"></i> Dashboard
        </a>
        <a href="{{ route('courrier') }}" class="block p-3 rounded hover:bg-indigo-800 {{ request()->routeIs('courriers.*') ? 'bg-indigo-800' : '' }}">
            <i class="fa-solid fa-file ml-2"></i> Courriers
        </a>
        <a href="#" class="block p-3 rounded hover:bg-indigo-800 {{ request()->routeIs('transmissions.*') ? 'bg-indigo-800' : '' }}">
            <i class="fa-solid fa-tower-broadcast ml-2"></i> Transmissions
        </a>
        <a href="{{ route('archive') }}" class="block p-3 rounded hover:bg-indigo-800 {{ request()->routeIs('archive') ? 'bg-indigo-800' : '' }}">
            <i class="fa-solid fa-folder ml-2"></i> Archives
        </a>
    </nav>

    <footer class="mt-auto text-xs pb-4 text-center text-white">
        &copy; {{ date('Y') }} GEC - Gestion de Courrier. All rights reserved.
        <a href="#" class="text-blue-400 hover:underline">Privacy Policy</a>
    </footer>
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
         <div class="relative inline-block text-left">
    <!-- Bouton utilisateur -->
    <button type="button"
        class="inline-flex justify-center w-full px-4 py-2 bg-white text-l font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
        onclick="document.getElementById('userDropdown').classList.toggle('hidden')">
        {{ Auth::user()->name }}
        <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div id="userDropdown" class="absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-50">
        <div class="py-1">
            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                 <i class="fa-solid fa-user"></i> Profile
            </a>
            <button onclick="openLogoutModal()"
               class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
    <!-- #region -->
                     <i class="fa-solid fa-right-from-bracket"></i>
 Se déconnecter           
 </button>
        </div>
    </div>
</div>

<!-- Modal de confirmation logout -->
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
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>
</div>

<script>
    function openLogoutModal() {
        document.getElementById('logoutModal').classList.remove('hidden');
        // on ferme le dropdown pour éviter chevauchement
        document.getElementById('userDropdown').classList.add('hidden');
    }
    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.add('hidden');
    }

    // Fermer le dropdown si clic à l'extérieur
    window.addEventListener('click', function(e){
        const dropdown = document.getElementById('userDropdown');
        const button = dropdown.previousElementSibling;
        if(!button.contains(e.target) && !dropdown.contains(e.target)){
            dropdown.classList.add('hidden');
        }
    });
</script>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-auto p-6">
            @yield('content')
        </main>

    </div>

</body>

</html>