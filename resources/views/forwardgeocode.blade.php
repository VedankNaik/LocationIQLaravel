<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Forward Geocode') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            http://
                        </span>
                        <input type="text" name="url" id="url" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="ApiUrl">
                    </div>
                    <div class="pt-5">
                        <div class="mt-1">
                            <textarea id="query" name="query" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Query"></textarea>
                        </div>
                    </div> -->
                    @if(count($addresses)!=0)
                    <form method="POST" action="{{ url('/forwardvalidate')}}" enctype="multipart/form-data">                  
                        @csrf
                    <div class="">                  
                    <table class="w-full">
                        <thead class="bg-blue-400">
                            <tr class="border border-4 border-blue-500">
                            <th>EGID</th>
                            <th>Street</th>
                            <th>Zip</th>
                            <th>Town</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        @foreach ($addresses as $address)
                            <tr class="border border-4 border-blue-800">
                            <td class="border border-4 border-blue-800 text-center">{{$address->EGID}}</td>
                            <td class="border border-4 border-blue-800 text-center">{{$address->Street}}</td>
                            <td class="border border-4 border-blue-800 text-center">{{$address->Zip}}</td>
                            <td class="border border-4 border-blue-800 text-center">{{$address->Town}}</td>
                            </tr> 
                        @endforeach                                  
                        </tbody>
                    </table>
                    <div> {{ $addresses->links() }}</div>       
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200">
                        <a href="{{ url('/forwardvalidate') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Validate</a>
                        <a href="{{ url('/forwardvalidated') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 ml-10 px-4 rounded">Validated</a>
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

</x-app-layout>