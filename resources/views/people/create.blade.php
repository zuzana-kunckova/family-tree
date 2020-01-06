@extends('layouts.app')

@section('content')
<div class="flex items-center">
    <div class="md:w-1/2 md:mx-auto">

        @if (session('status'))
        <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
            {{ session('status') }}
        </div>
        @endif

        <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

            <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                Create new Person
            </div>

            <div class="w-full p-6">
                <form method="post" action="{{ route('people.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Name
                        </label>
                        <input class="shadow appearance-none border rounded w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" placeholder="Name">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="relationship">
                            Relationship
                        </label>
                        <select name="relationship" id="relationship" class="block appearance-none w-1/3 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 mb-4 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            <option>Parent</option>
                            <option>Sibling</option>
                            <option>Child</option>
                            <option>Spouse</option>
                        </select>

                        &nbsp; of

                        <select name="related_to" id="person" class="block appearance-none w-1/3 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 mt-4 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($people ?? '' as $person)
                            &bull; <option value="{{ $person->id }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
