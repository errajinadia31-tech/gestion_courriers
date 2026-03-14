<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>GEC - Gestion de Courrier</title>
</head>
<body class="font-poppins min-h-screen bg-cover bg-center bg-gray-100" style="background-image: url('{{ asset("image/bg_maroc.png") }}');">

    <!-- Navbar -->
    <nav class="text-blue-700">
        <div class="max-w-7xl mx-auto flex justify-between items-center p-6">
            <div class="flex items-center">
                <div class="w-20">
                    <img src="{{ asset('image/logo.png') }}" alt="logo" class="h-10 w-auto">
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Section -->
    <section class="flex items-center justify-center min-h-[calc(80vh-80px)] px-6">
        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="w-full max-w-md  p-8 rounded-lg ">
            @csrf

            <h2 class="text-3xl font-bold text-center mb-6 text-blue-700">Authentification</h2>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember + Forgot -->
            <div class="flex items-center justify-between mb-6 text-sm">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-gray-600">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">Forgot password?</a>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition">
                Login
            </button>
            <!-- Under Login Submit Button -->
<div class="mt-4 text-center text-sm text-gray-600">
    Vous n'avez pas de compte ?
    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-semibold">
        Créer un compte
    </a>
</div>
        </form>
    </section>

    <!-- Footer -->
    <footer class="mt-10">
        <div class="text-center p-4 text-gray-700">
            &copy; {{ date('Y') }} GEC - Gestion de Courrier. All rights reserved.
            <a href="#" class="text-indigo-600 hover:underline">Privacy Policy</a>
        </div>
    </footer>

</body>
</html>