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

<div class="mt-6 ml-6">
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
</div>

</html>