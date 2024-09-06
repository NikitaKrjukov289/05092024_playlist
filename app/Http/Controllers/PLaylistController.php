<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PLaylist;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PlaylistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('playlists.index')
            ->with('playlists', Playlist::orderBy('updated_at', 'DESC')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('playlists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            
        ]);

   

        Post::create([
            'title' => $request->input('title'),
            
            'slug' => SlugService::createSlug(Playlist::class, 'slug', $request->title),
           
            'user_id' => auth()->user()->id
        ]);

        return redirect('/playlists')
            ->with('message', 'Your playlist has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return view('playlists.show')
            ->with('playlist', Playlist::where('slug', $slug)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        return view('playlists.edit')
            ->with('playlist', Playlist::where('slug', $slug)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required',
            
        ]);

       
            Playlist::where('slug', $slug)
                ->update([
                    'title' => $request->input('title'),
        
                    'slug' => SlugService::createSlug(Playlist::class, 'slug', $request->title),
                    'user_id' => auth()->user()->id
                ]);
        

        return redirect('/playlists')
            ->with('message', 'Your playlist has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function KeepReading($slug)


    {
        $playlist = Playlist::where('slug', $slug);

        $playlist->delete();

        return redirect('/playlists')
            ->with('message', 'Your playlist has been deleted!');
    }
}
