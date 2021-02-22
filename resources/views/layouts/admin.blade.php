<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@yield('title', __('Dashboard')) - {{ config('app.name', 'Laravel') }}</title>

        @stack('head')

        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />

        <link rel="stylesheet" href="{{ asset('admin/app.css') }}" />

        @stack('css')
    </head>
    <body x-data="data()" :class="{ 'theme-dark': dark }">
        @stack('before')

        <div
            class="flex h-screen bg-gray-50 dark:bg-gray-900"
            :class="{ 'overflow-hidden': isSideMenuOpen }"
        >
            @include('layouts.admin.desktop-sidebar')
            @include('layouts.admin.mobile-sidebar')

            <div class="flex flex-col flex-1 w-full">
                @include('layouts.admin.header')

                <main class="h-full overflow-y-auto">
                    <div class="container px-6 mx-auto grid">
                        <h2
                            class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
                        >
                            @yield('title', __('Dashboard'))
                        </h2>

                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('admin/app.js') }}"></script>

        @stack('after')
    </body>
</html>
