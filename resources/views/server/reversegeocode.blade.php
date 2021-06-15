<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
    .modal {
        transition: opacity 0.25s ease;
    }

    body.modal-active {
        overflow-x: hidden;
        overflow-y: visible !important;
    }
    </style>

</head>
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/serverdashboard') }}">
                        <p>LocationIQ</p>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="serverdashboard">
                        {{ __('Server Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ request()->getHttpHost()  }}</div>

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
                        <!-- Authentication -->
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

            <!-- Hamburger -->
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

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ url('/serverdashboard') }}">
                {{ __('Server Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">Server</div>
                <div class="font-medium text-sm text-gray-500">DB</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
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
    {{ __('Reverse Geocode') }}
</h2>

<div class="mt-6 ml-6">
    <form method="POST" action="{{ url('/reversequery')}}" class="space-y-4 text-gray-700">
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
                            placeholder="Select table name" type="text" name="selecttable" id="selecttable" value=""
                            required />
                        <label>Insert into</lable>
                            <input
                                class="w-1/4 h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline mt-4"
                                placeholder="Insert table name" type="text" name="inserttable" id="inserttable"
                                value="" />
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
                                        placeholder="Select table name" type="text" name="selecttable" id="selecttable"
                                        value="{{ $request->input('selecttable') }}" required />
                                    <label>Insert into</lable>
                                        <input
                                            class="w-1/4 h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline mt-4"
                                            placeholder="Insert table name" type="text" name="inserttable"
                                            id="inserttable" value="{{ $request->input('inserttable') }}" />
                                        @endif
            </div>
            <div class="p-2 bg-white border-b border-gray-200">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold mt-4 py-2 px-4 rounded">Execute</button>
            </div>
        </div>
        @if (session('Error'))
        <div class="w-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 round">
            {{ session('Error') }}
        </div>
        @endif
    </form>

</div>


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if(count($coordinates)!=0)
                <form method="POST" action="{{ url('/serverreversevalidate')}}">
                    @csrf
                    <div class="w-full px-2">
                        @if($request)
                        <input
                            class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                            placeholder="Query" type="text" name="query" id="query"
                            value="{{ $request->input('query') }}" required readonly />
                        <input
                            class="w-1/4 h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline mt-4"
                            placeholder="Select table name" type="text" name="selecttable" id="selecttable"
                            value="{{ $request->input('selecttable') }}" required readonly />
                        <input
                            class="w-1/4 h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline mt-4"
                            placeholder="Insert table name" type="text" name="inserttable" id="inserttable"
                            value="{{ $request->input('inserttable') }}" required readonly />
                        @endif
                    </div>
                    <div class="mt-2">
                        <table class="w-full">
                            <thead class="bg-blue-400">
                                <tr class="border border-4 border-blue-500">
                                    @if(count($columns)!=0)
                                    @foreach ($columns as $column)
                                    @if(isset($coordinates[0] -> $column))<th>{{ $column }}</th>@endif
                                    @endforeach
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($coordinates as $coordinate)
                                <tr class="border border-4 border-blue-800">
                                    @if(count($columns)!=0)
                                    @foreach ($columns as $column)
                                    @if(isset($coordinate -> $column))<td
                                        class="border border-4 border-blue-800 text-center">{{ $coordinate->$column }}
                                    </td>@endif
                                    @endforeach
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="p-6 bg-white border-b border-gray-200">
                        @if( $request->input('inserttable') != null )
                        <button type="submit" name="action" value="validate"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold mt-4 py-2 px-4 rounded">Validate</button>
                        <button type="submit" name="action" value="validated"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold mt-4 py-2 px-4 rounded">Validated</button>
                        @endif
                        <!-- <a href="{{ url('/serverreversevalidate') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Validate</a>-->
                        <!-- <a href="{{ url('/serverreversevalidated') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 ml-10 px-4 rounded">Validated</a>  -->
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200">
                    </div>
                </form>
                @else
                <div class="">
                    <p>No coordinates for validation</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

</html>