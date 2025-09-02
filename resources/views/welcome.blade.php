<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white">

    <div class="text-center p-8 max-w-xl">

      <!-- Logo/Icon -->
      <div class="flex justify-center mb-8">
        <div class="w-24 h-24 flex items-center justify-center rounded-3xl bg-white/10 backdrop-blur-lg shadow-2xl text-5xl">
          🎫
        </div>
      </div>


      <!-- Title -->
      <h1 class="text-4xl font-bold mb-4">Welcome to The Ticket System</h1>
      <p class="text-lg text-white/80 mb-8">
        Manage support requests, track issues, and provide better service.
      </p>

      <!-- Buttons -->
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        @auth
          <a href="{{ url('/dashboard') }}" class="px-6 py-3 rounded-xl bg-white text-indigo-600 font-semibold shadow hover:bg-gray-100 transition">
            Go to Dashboard
          </a>
        @else
          <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl bg-white text-indigo-600 font-semibold shadow hover:bg-gray-100 transition">
            Log in
          </a>
          <a href="{{ route('register') }}" class="px-6 py-3 rounded-xl bg-indigo-800 font-semibold shadow hover:bg-indigo-900 transition">
            Register
          </a>
        @endauth
      </div>
    </div>

  </body>
</html>
