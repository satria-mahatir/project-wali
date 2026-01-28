<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <script>
            (function() {
                const savedTheme = localStorage.getItem('theme') || 'light';
                document.documentElement.setAttribute('data-bs-theme', savedTheme);
                if (savedTheme === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [data-bs-theme="dark"] body, 
            [data-bs-theme="dark"] .min-h-screen {
                background-color: #0f172a !important;
            }

            [data-bs-theme="dark"] .bg-white {
                background-color: #1e293b !important;
                border: 1px solid #334155 !important;
                color: #f1f5f9 !important;
            }

            [data-bs-theme="dark"] input {
                background-color: #0f172a !important;
                color: #ffffff !important;
                border: 1px solid #334155 !important;
            }

            [data-bs-theme="dark"] label, 
            [data-bs-theme="dark"] a {
                color: #94a3b8 !important;
            }

            [data-bs-theme="dark"] .bg-gray-100 {
                background-color: #0f172a !important;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-[#0f172a]">
            <div class="mb-6">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-6 bg-white dark:bg-[#1e293b] shadow-md overflow-hidden sm:rounded-2xl border dark:border-[#334155]">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>