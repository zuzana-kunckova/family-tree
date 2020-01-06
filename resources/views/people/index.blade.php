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
                People
            </div>

            @auth
            <div class="p-6 pb-0">
                <a href="{{ route('people.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create New Person</a>
            </div>
            @endauth

            <div class="w-full p-6 leading-snug">
                @foreach ($people as $person)
                    &bull; <a href="{{ route('people.show', $person) }}" class="underline">{{ $person->name }}</a><br>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
