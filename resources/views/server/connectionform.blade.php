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
</head>

<!-- <div class="mt-6 ml-6">
    <form method="POST" action="{{ url('/testconnection')}}" class="space-y-4 text-gray-700">
        @csrf
        <div class="flex flex-wrap -mx-2 space-y-4 md:space-y-0">
            <div class="w-full px-2 md:w-1/4">
                <label class="block mb-1" for="">Host</label>
                <input class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                    type="text" name="host" id="host" value="{{ old('host') }}" />
            </div>
            <div class="w-full px-2 md:w-1/4">
                <label class="block mb-1" for="">Database</label>
                <input class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                    type="text" name="database" id="database" value="{{ old('database') }}" />
            </div>
            <div class="w-full px-2 md:w-1/4">
                <label class="block mb-1" for="">User Name</label>
                <input class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                    type="text" name="username" id="username" value="{{ old('username') }}" />
            </div>
            <div class="w-full px-2 md:w-1/4">
                <label class="block mb-1" for="">Password</label>
                <input class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                    type="text" name="password" id="password" value="{{ old('password') }}" />
            </div>
        </div>
        <div class="py-2">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 bg-white border-b border-gray-200">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Connect</button>
                        @if($errors->any())
                        @foreach($errors->all() as $error)
                        <div class="">{{$error}}</div>
                        @endforeach
                        @endif
                        @if (session('Success'))
                        <div class="">
                            {{ session('Success') }}
                        </div>
                        @endif
                        @if (session('Error'))
                        <div class="w-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 round">
                            {{ session('Error') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div> -->


<body class="bg-blue-200">
    <div class="container w-full max-w-xs mx-auto mt-8 px-1 font-sans">
        <form method="POST" action="{{ url('/testconnection')}}"
            class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
            @csrf
            <h3 class="title text-xl mb-8 mx-auto text-center font-bold text-blue-700">Connect to Server</h3>
            <div class="mb-4 grid gap-6">
                <div>
                    <label for="host" class="block text-gray-500 font-medium text-sm mb-2">Server</label>
                    <input name="host" type="text" placeholder=""
                        class="appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" />
                </div>
                <div>
                    <label for="database" class="block text-gray-500 font-medium text-sm mb-2">Database</label>
                    <input name="database" type="text" placeholder=""
                        class="appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" />
                </div>
                <div>
                    <label for="username" class="block text-gray-500 font-medium text-sm mb-2">User Name</label>
                    <input name="username" type="text" placeholder=""
                        class="appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" />
                </div>
                <div>
                    <label for="password" class="block text-gray-500 font-medium text-sm mb-2">Password</label>
                    <input name="password" type="password" placeholder=""
                        class="appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" />
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="shadow bg-blue-500 hover:bg-blue-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded mt-4"
                        type="submit">
                        Connect
                    </button>
                </div>
                <div>
                    @if($errors->any())
                    @foreach($errors->all() as $error)
                    <div class="w-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 round">{{$error}}</div>
                    @endforeach
                    @endif
                    @if (session('Success'))
                    <div class="">
                        {{ session('Success') }}
                    </div>
                    @endif
                    @if (session('Error'))
                    <div class="w-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 round">
                        {{ session('Error') }}
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</body>

</html>