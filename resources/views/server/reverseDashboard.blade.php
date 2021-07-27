<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LocationIQ') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
        <blade import|%20url(%26%2339%3Bhttps%3A%2F%2Ffonts.googleapis.com%2Fcss%3Ffamily%3DKarla%3A400%2C700%26display%3Dswap%26%2339%3B)%3B>.font-family-karla {
            font-family: karla;
        }

        .bg-sidebar {
            background: #3d68ff;
        }

        .cta-btn {
            color: #3d68ff;
        }

        .upgrade-btn {
            background: #1947ee;
        }

        .upgrade-btn:hover {
            background: #0038fd;
        }

        .active-nav-link {
            background: #1947ee;
        }

        .nav-item:hover {
            background: #1947ee;
        }

        .account-link:hover {
            background: #3d68ff;
        }

    </style>
</head>
<!--
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/serverdashboard') }}">
                        <p>LocationIQ</p>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="serverdashboard">
                        {{ __('Server Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ request()->getHttpHost() }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="get" action="{{ url('/disconnect') }}">
@csrf

                            <x-dropdown-link href="{{ url('/disconnect') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Disconnect') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ url('/serverdashboard') }}">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">Server</div>
                <div class="font-medium text-sm text-gray-500">DB</div>
            </div>

            <div class="mt-3 space-y-1">
                <form method="get" action="{{ url('/disconnect') }}">
@csrf

                    <x-responsive-nav-link href="{{ url('/disconnect') }}" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Disconnect') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
<h2 class="font-semibold text-xl text-gray-800 leading-tight ml-6">
    {{ __('Server Dashboard') }}
</h2>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <a href="{{ url('/serverforwardgeocode') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Forward Geocode</a>
                <a href="{{ url('/serverreversegeocode') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Reverse Geocode</a>
              </div>
@if(session('Error'))
            <div class="w-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 round">
                {{ session('Error') }}
            </div>
@endif
        </div>
    </div>
</div>
-->

<body class="bg-gray-100 font-family-karla flex">

    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
            <a class="text-white text-3xl font-semibold uppercase hover:text-gray-300">LocationIQ</a>
        </div>
        <nav class="text-white text-base font-semibold pt-3">
            <a href="{{ url('/forwarddashboard') }}" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fa fa-map-marker mr-3"></i>
                Forward Geocode
            </a>
            <a class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
                <i class="fa fa-map-marker mr-3"></i>
                Reverse Geocode
            </a>
        </nav>
    </aside>

    <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
        <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
            <div class="w-1/2"></div>
            <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <button @click="isOpen = !isOpen"
                    class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                    <img src="https://img.icons8.com/fluent-systems-regular/50/000000/settings.png" />
                </button>
                <button x-show="isOpen" @click="isOpen = false"
                    class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                    <a href="{{ url('/disconnect') }}"
                        class="block px-4 py-2 account-link hover:text-white">Disconnect</a>
                </div>
            </div>
        </header>

        <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
            <div class="flex items-center justify-between">
                <a class="text-white text-3xl font-semibold uppercase hover:text-gray-300">LocationIQ</a>
                <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                    <i x-show="!isOpen" class="fas fa-bars"></i>
                    <i x-show="isOpen" class="fas fa-times"></i>
                </button>
            </div>

            <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
                <a href="{{ url('/forwarddashboard') }}"
                    class="disabled flex items-center text-white py-2 pl-4 nav-item">
                    <i class=" fa fa-map-marker mr-3"></i>
                    Forward Geocode
                </a>
                <a class="flex items-center active-nav-link text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class=" fa fa-map-marker mr-3"></i>
                    Reverse Geocode
                </a>
                <a href="{{ url('/disconnect') }}"
                    class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Disconnect
                </a>
            </nav>
        </header>

        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <div class="mt-6 ml-6 mr-6">
                    <form method="POST" action="{{ url('/serverreversevalidate') }}" class="space-y-4 text-gray-700">
                        @csrf
                        <div class="flex flex-wrap -mx-2 space-y-4 md:space-y-0">
                            <div class="w-full px-2">
                                @if(empty($request))
                                <label>Query</lable>
                                    <input
                                        class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                                        placeholder="Query" type="text" name="query" id="query" value="" required />
                                    <br>
                                    <label>Select from</lable>
                                        <input
                                            class="w-1/4 h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline mt-4"
                                            placeholder="Select table name" type="text" name="selecttable"
                                            id="selecttable" value="" required />
                                        <label class="ml-10">Insert into</lable>
                                            <input
                                                class="w-1/4 h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline mt-4"
                                                placeholder="Insert table name" type="text" name="inserttable"
                                                id="inserttable" value="" />
                                            @else
                                            <label>Query</lable>
                                                <input
                                                    class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                                                    placeholder="Query" type="text" name="query" id="query"
                                                    value="{{ $request->input('query') }}" required />
                                                <br>
                                                <label>Select from</lable>
                                                    <input
                                                        class="w-1/4 h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline mt-4"
                                                        placeholder="Select table name" type="text" name="selecttable"
                                                        id="selecttable" value="{{ $request->input('selecttable') }}"
                                                        required />
                                                    <label class="ml-10">Insert into</lable>
                                                        <input
                                                            class="w-1/4 h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline mt-4"
                                                            placeholder="Insert table name" type="text"
                                                            name="inserttable" id="inserttable"
                                                            value="{{ $request->input('inserttable') }}" />
                                                        @endif
                            </div>
                            <div class="p-2 border-b border-gray-200">
                                <button type="submit" name="action" value="fetch"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold mt-4 py-2 px-4 rounded">Fetch
                                    records</button>
                                @if( $request->input('inserttable') != null )
                                <button type="submit" name="action" value="validate"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold ml-4 mt-4 py-2 px-4 rounded">Validate</button>
                                @endif
                            </div>
                        </div>
                        @if(session('Success'))
                        <div class="w-1/4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 round">
                            {{ session('Success') }}
                        </div>
                        @endif
                        @if(session('Error'))
                        <div class="w-1/4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 round">
                            {{ session('Error') }}
                        </div>
                        @endif
                    </form>
                </div>

                @if(count($coordinates)!=0)
                <form method="POST" action="{{ url('/serverreversevalidate') }}">
                    @csrf
                    <div class="w-full px-2">
                        @if($request)
                        <input
                            class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                            type="hidden" name="query" id="query" value="{{ $request->input('query') }}" required
                            readonly />
                        <input
                            class="w-1/4 h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline mt-4"
                            type="hidden" name="selecttable" id="selecttable"
                            value="{{ $request->input('selecttable') }}" required readonly />
                        <input
                            class="w-1/4 h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline mt-4"
                            type="hidden" name="inserttable" id="inserttable"
                            value="{{ $request->input('inserttable') }}" required readonly />
                        @endif
                        <div class="w-full mt-12">
                            <div class="bg-white overflow-auto">
                                <table class="text-left w-full border-collapse">
                                    <thead class="bg-blue-500 text-white">
                                        <tr>
                                            @if(count($columns)!=0)
                                            @foreach($columns as $column)
                                            @if(isset($coordinates[0] -> $column))
                                            <th
                                                class="py-2 px-6 bg-grey-lightest font-bold uppercase text-base text-grey-dark border-b border-grey-light">
                                                {{ $column }}</th>
                                            @endif
                                            @endforeach
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($coordinates as $coordinate)
                                        <tr class="hover:bg-grey-lighter">
                                            @if(count($columns)!=0)
                                            @foreach($columns as $column)
                                            @if(isset($coordinate -> $column))
                                            <td class="py-4 px-6 text-sm border-b border-grey-light">
                                                {{ $coordinate->$column }}
                                            </td>
                                            @endif
                                            @endforeach
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- <div class="p-6 bg-white border-b border-gray-200">
@if( $request->input('inserttable') != null )
                                    <button type="submit" name="action" value="validate"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold mt-4 py-2 px-4 rounded">Validate</button>
@endif
                                </div> -->
                            </div>
                        </div>
                </form>
                @endif
            </main>

            <footer class="w-full bg-white text-right p-4">
                LocationIQ
            </footer>
        </div>

    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>

</html>
