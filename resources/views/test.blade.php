<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Hub</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-900 text-white">
<header class="bg-gray-800 p-4">
    <nav class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Gaming Hub</h1>
        <ul class="flex space-x-4">
            <li><a href="#streamers" class="hover:underline">Streamers</a></li>
            <li><a href="#guides" class="hover:underline">Guides</a></li>
            <li><a href="#achievements" class="hover:underline">Achievements</a></li>
        </ul>
    </nav>
</header>
<main class="container mx-auto p-6">
    <!-- Streamers Section -->
    <section id="streamers" class="my-12">
        <h2 class="text-3xl font-bold mb-4">Top Streamers</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @include('components.streamer-card', ['streamers' => $streamers])
        </div>
    </section>

    <!-- Guides Section -->
    <section id="guides" class="my-12">
        <h2 class="text-3xl font-bold mb-4">Game Guides</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @include('components.guide-card', ['guides' => $guides])
        </div>
    </section>

    <!-- Achievements Section -->
    <section id="achievements" class="my-12">
        <h2 class="text-3xl font-bold mb-4">User Achievements</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @include('components.user-achievement-card', ['achievements' => $achievements])
        </div>
    </section>
</main>
<footer class="bg-gray-800 p-4 text-center">
    <p>&copy; 2024 Gaming Hub. All rights reserved.</p>
</footer>
</body>
</html>
