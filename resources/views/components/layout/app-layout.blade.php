<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts Yeahh -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>

    @isset($styles)
        {{$styles}}
    @endisset

    <!-- Vite Styles -->
    @vite('resources/css/app.css')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
</head>

<body>
<div class="bg-secondary-100 flex flex-col items-center justify-center min-h-screen sm:py-16">
    <div class="max-w-md space-y-6 w-full">
        <div class="bg-white p-8 border-solid border bg-white rounded-lg text-teal-900 space-y-6">
            <header class="space-y-4">
                <div class="md:flex mb-5">
                    <div class="md:flex-shrink-0 my-auto">
                        <img src="{{URL::asset("/img/pnj.svg")}}" class="float-left" alt="Logo PNJ"
                             height="70" width="75">
                    </div>
                    <div class="md:ml-6 my-auto">
                        <h1 class="font-bold text-3xl font-bold">SSO</h1>
                        <h1 class="text-xl">Politeknik Negeri Jakarta</h1>
                    </div>
                </div>

                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="flex p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 inline w-8 h-8 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                {{$errors}}
                            </div>
                        </div>
                    @endforeach
                @endif


                <h1 class="font-bold text-center text-xl">{{$title}}
                </h1>
                <p class="text-sm text-center">{{$message}}</p>
            </header>
            <main class="space-y-4">
                {{ $slot }}
            </main>
            <footer>
                <p class="text-center text-gray-500 text-xs">
                    {{__('migration.doNotRefresh')}}
                </p>
            </footer>
        </div>
        <div class="flex justify-around">
            <div class="relative" x-data="{open: false}">
                <button class="inline-flex text-secondary-600 hover:text-secondary-900" @click="open = true"
                        type="button">
                    <div class="flex items-center">
                        <span class="text-sm">English</span>
                        <svg fill="none" height="1em" stroke="currentColor" viewBox="0 0 24 24" width="1em"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div class="absolute bg-white bottom-0 -left-4 max-h-80 mb-6 overflow-y-scroll rounded-lg shadow-lg"
                     x-cloak x-show="open" @click.away="open = false">
                    <div class="px-4 py-2">
                        <a class="inline-flex text-secondary-600 hover:text-secondary-900"
                           href="/realms/master/login-actions/authenticate?client_id=security-admin-console&amp;tab_id=ZGwbQR3BquU&amp;execution=61044035-364a-455f-b0a2-f7e1941eac30&amp;kc_locale=id">
                            <span class="text-sm">Indonesia</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@isset($scripts)
    {{$scripts}}
@endisset
</body>
</html>
