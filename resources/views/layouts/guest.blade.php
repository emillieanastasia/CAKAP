<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Inject Config yang sama --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            navy: '#013C58', teal: '#00537A', sky: '#A8E8F9',
                            gold: '#F5A201', lightgold: '#FFD35B', pale: '#FFBA42',
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-navy">
            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-teal shadow-2xl overflow-hidden sm:rounded-[30px] border border-sky/10">
                <div class="text-white">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>