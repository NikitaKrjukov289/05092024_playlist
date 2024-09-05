@extends('layouts.app')

@section('content')
<div class="w-4/5 m-auto text-center">
    <div class="py-15 border-b border-gray-200">
        <h1 class="text-6xl">

        </h1>
    </div>
</div>

@if (session()->has('message'))
    <div class="w-4/5 m-auto mt-10 pl-2">
        <p class="w-2/6 mb-4 text-gray-50 bg-green-500 rounded-2xl py-4">
            {{ session()->get('message') }}
        </p>
    </div>
@endif

@if (Auth::check())
    <div class="pt-15 w-4/5 m-auto">
        <a 
            href="/playlists/create"
            class="bg-blue-500 uppercase bg-transparent text-gray-900 text-xl font-extrabold py-3 px-5 rounded-3xl">
            Create playlist
        </a>
    </div>
@endif



@foreach ($playlists as $playlist)
    <div class="sm:grid grid-cols-2 gap-20 w-4/5 mx-auto py-15 border-b border-gray-200">
        <div>
            <img src="{{ asset('images/' . $playlist->image_path) }}" alt="">
        </div>
        <div>
            <h2 class="text-gray-700 font-bold text-5xl pb-4">
                {{ $playlist->title }}
            </h2>

            <span class="text-gray-500">
                By <span class="font-bold italic text-gray-800">{{ $playlist->user->name }}</span>, Created on {{ date('jS M Y', strtotime($playlist->updated_at)) }}
            </span>

            <p class="text-xl text-gray-700 pt-8 pb-10 leading-8 font-light">
                {{ $playlist->description }}
            </p>

            <a href="/playlists/{{ $playlist->slug }}" class="uppercase bg-blue-500 text-gray-100 text-lg font-extrabold py-4 px-8 rounded-3xl">
                Show
            </a>

            @if (isset(Auth::user()->id) && Auth::user()->id == $playlist->user_id)
                <span class="float-right">
                    <a 
                        href="/playlists/{{ $playlist->slug }}/edit"
                        class="text-gray-700 italic hover:text-gray-900 pb-1 border-b-2">
                        Edit
                    </a>
                </span>

                <span class="float-right">
                    
                     <form action="/playlists/{{ $playlist->slug }}" method="GET">
                    
                        <button
                            class="text-red-500 pr-3"
                            type="submit">
                            Delete
                        </button>
                        @csrf
                        @method('delete')
                    </form>
                </span>
            @endif
        </div>
    </div>    

@endforeach
@endsection
