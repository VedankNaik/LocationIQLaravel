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
    <form method="POST" action="{{ url('/executequery')}}" class="space-y-4 text-gray-700">
        @csrf
        <div class="flex flex-wrap -mx-2 space-y-4 md:space-y-0">
            <div class="w-full px-2 md:w-1/4">
                <label class="block mb-1" for="">Query</label>
                @if(empty($request))
                <input class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                    type="text" name="query" id="query" value="" />
                @else
                <input class="w-full h-10 px-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline"
                    type="text" name="query" id="query" value="{{ $request->input('query') }}" />
                @endif
            </div>
            <div class="p-2 bg-white border-b border-gray-200">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold mt-4 py-2 px-4 rounded">Execute</button>
                <a href="{{ url('/disconnect') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 ml-10 px-4 rounded">Disconnect</a>
            </div>
        </div>
    </form>

</div>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if(count($result)!=0)
                <div class="">
                    <table class="w-full">
                        <thead class="bg-blue-400">
                            <tr class="border border-4 border-blue-500">
                                @if(isset($result[0]->EGID))<th>EGID</th>@endif
                                @if(isset($result[0]->Street))<th>Street</th>@endif
                                @if(isset($result[0]->Zip))<th>Zip</th>@endif
                                @if(isset($result[0]->Town))<th>Town</th>@endif
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($result as $res)
                            <tr class="border border-4 border-blue-800">
                                @if(isset($res->EGID))<td class="border border-4 border-blue-800 text-center">
                                    {{$res->EGID}}</td>@endif
                                @if(isset($res->Street))<td class="border border-4 border-blue-800 text-center">
                                    {{$res->Street}}</td>@endif
                                @if(isset($res->Zip))<td class="border border-4 border-blue-800 text-center">
                                    {{$res->Zip}}</td>@endif
                                @if(isset($res->Town))<td class="border border-4 border-blue-800 text-center">
                                    {{$res->Town}}</td>@endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ url('/forwardvalidate') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Validate</a>
                    <a href="{{ url('/forwardvalidated') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 ml-10 px-4 rounded">Validated</a>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                </div>
                </form>
                @else
                <div class="">
                    <p>No addresses for validation</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

</html>