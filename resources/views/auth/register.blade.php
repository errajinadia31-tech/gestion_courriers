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
        <link rel="shortcut icon" href="{{ asset('image/icon.ico') }}" type="image/x-icon">
    <title>GEC - Register</title>
</head>
<body class="font-poppins min-h-screen bg-cover bg-center bg-gray-100" style="background-image: url('{{ asset("image/bg_maroc.png") }}');">

    <!-- Navbar -->
    <nav class="text-blue-700">
        <div class="max-w-7xl mx-auto flex justify-between items-center p-6">
            <div class="flex items-center">
                <div class="w-20">
               <a href="{{ route('login') }}"><img src="{{ asset('image/logo.png') }}" alt="logo" class="h-10 w-auto"></a>
            </div>
            </div>
        </div>
    </nav>

    <!-- Main Section -->
    <section class="flex items-center justify-center min-h-[calc(80vh-80px)] px-6">
        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="w-full max-w-md  p-8 rounded-lg ">
            @csrf

            <h2 class="text-3xl font-bold text-center mb-6 text-blue-700">Créer un compte</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
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

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Already registered + Register button -->
            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition">
                Register
            </button>
            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('login') }}" class="text-sm text-blue-700 hover:text-blue-700 hover:underline">
                    Already registered?
                </a>
            </div>
        </form>
    </section>

    <!-- Footer -->
    <footer class="mt-10 text-center text-gray-700">
        &copy; {{ date('Y') }} GEC - Gestion de Courrier. All rights reserved.
        <a href="#" class="text-indigo-600 hover:underline">Privacy Policy</a>
    </footer>

</body>
</html>