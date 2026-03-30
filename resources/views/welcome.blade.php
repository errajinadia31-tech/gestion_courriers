<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEC - Gestion electonique de Courrier</title>
    <script src="https://cdn.tailwindcss.com"></script>
        <link rel="shortcut icon" href="{{ asset('image/icon.ico') }}" type="image/x-icon">

</head>
<body class="bg-cover bg-center bg-gray-100" style="background-image: url('{{ asset("image/bg_maroc.png") }}'); font-family: 'Poppins', sans-serif;">

    <!-- Navbar -->
    <header class="bg-transparent w-full py-4 px-[3rem] flex justify-between items-center">
        <div class="flex items-center">
            <img src="{{ asset('image/logo.png') }}" alt="Logo" class="h-12 w-auto">
        </div>
        <div class="space-x-6 font-semibold">
            <a href="{{ route('login') }}" class="text-indigo-700 hover:text-indigo-900">Login</a>
            <a href="{{ route('register') }}" class="text-indigo-700 hover:text-indigo-900">Créer un compte</a>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="flex items-center justify-center min-h-[calc(85vh-80px)] px-6">
        <section class="text-center max-w-4xl">
            <h1 class="text-4xl md:text-4xl font-bold text-indigo-700 mb-6">
                Bienvenue sur <span class="text-indigo-600">GEC</span> - Gestion de Courrier
            </h1>
            <p class="text-gray-700 text-lg md:text-xl leading-relaxed">
                <strong>GEC</strong> est un système moderne conçu pour faciliter la gestion et le suivi des courriers au sein des organisations. 
                Grâce à notre plateforme, vous pouvez envoyer, recevoir et archiver tous vos courriers de manière efficace, sécurisée et centralisée. 
                <br><br>
                Optimisé pour la rapidité et la simplicité, <strong>GEC</strong> vous permet de gagner du temps, réduire les erreurs et améliorer la traçabilité de chaque document.
            </p>
        </section>
    </div>
        <!-- Footer -->
    <footer class="mt-10 text-center text-gray-700">
        &copy; {{ date('Y') }} GEC - Gestion de Courrier. All rights reserved.
        <a href="#" class="text-indigo-600 hover:underline">Privacy Policy</a>
    </footer>
</body>
</html>