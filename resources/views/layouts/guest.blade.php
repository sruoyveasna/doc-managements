<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Document Library') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-slate-50 antialiased">

<div class="min-h-screen flex flex-col">
    {{-- Top bar always visible for guest pages --}}
    @include('layouts.navigation')

    <main class="flex-1">
        {{ $slot }}
    </main>
</div>

{{-- Dark / light toggle script --}}
<script>
    (function () {
        const root = document.documentElement;
        const btn = document.getElementById('theme-toggle');
        const icon = document.getElementById('theme-toggle-icon');
        const label = document.getElementById('theme-toggle-text');

        if (!btn) return;

        function setTheme(mode) {
            if (mode === 'dark') {
                root.classList.add('dark');
                icon.textContent = '🌞';
                label.textContent = 'Light';
            } else {
                root.classList.remove('dark');
                icon.textContent = '🌙';
                label.textContent = 'Dark';
            }
        }

        const saved = localStorage.getItem('theme');
        if (saved === 'dark' || saved === 'light') {
            setTheme(saved);
        } else {
            const prefersDark = window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches;
            setTheme(prefersDark ? 'dark' : 'light');
        }

        btn.addEventListener('click', () => {
            const isDark = root.classList.contains('dark');
            const next = isDark ? 'light' : 'dark';
            setTheme(next);
            localStorage.setItem('theme', next);
        });
    })();
</script>

</body>
</html>
