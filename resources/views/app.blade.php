<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg viewBox='0 0 64 64' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M32 2C19.748 2 10 7.368 10 7.368V30c0 15.464 22 30 22 30s22-14.536 22-30V7.368S44.252 2 32 2z' fill='%236875F5' stroke='%23000' stroke-width='2'/><path d='M20 30c0 7 6 14 12 18s12-11 12-18V9c-6-4-12-5-12-5s-6 1-12 5v21z' fill='%23fff' stroke='%23000' stroke-width='2'/><circle cx='32' cy='20' r='4' fill='%236875F5' stroke='%23000' stroke-width='2'/><path d='M28 28h8v8h-8z' fill='%236875F5' stroke='%23000' stroke-width='2'/><path d='M30 32v4m4-4v4m-4-2h4' stroke='%23fff' stroke-width='2'/></svg>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
