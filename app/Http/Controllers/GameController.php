<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Console;
use Illuminate\Http\Request;
use App\Http\Requests\GameRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{


    //MIDDLEWARE
    public function __construct(){
        $this->middleware('auth')->except('index', 'show');
    }



    //CRUD

    public function index(){
        $games = Game::with('user', 'consoles')->get();

        return view('game.index', compact('games'));
    }

    public function create_game(){

        $consoles = Console::all();

        return view('game.createGame',compact('consoles'));
    }

    public function store(GameRequest $request){
        $game = Game::create([
            'title'=>$request->title,
            'price'=>$request->price,
            'description'=>$request->description,
            'product'=>$request->product,
            'cover'=>$request->hasFile('cover') ? $request->file('cover')->store('public/covers') : null,
            'user_id'=> Auth::id(),
        ]);

        if ($request->consoles) {
            $game->consoles()->sync($request->consoles);
        }

        return redirect(route('game.index'))->with('gameCreated', 'Hai inserito il videogioco!');
    }

     /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        return view('game.show', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        // Usa Policy per autorizzazione
        $this->authorize('update', $game);
        
        $consoles = Console::all();

        return view('game.edit', compact('game','consoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        // Usa Policy per autorizzazione
        $this->authorize('update', $game);

        if(!$request->hasFile('cover')){
            $game->update([
                'title'=>$request->title,
                'price'=>$request->price,
                'description'=>$request->description,
            ]);
        }else{
            // Elimina il vecchio file cover se esiste
            if($game->cover){
                Storage::delete($game->cover);
            }
            $game->update([
                'title'=>$request->title,
                'price'=>$request->price,
                'description'=>$request->description,
                'cover'=>$request->file('cover')->store('public/covers'),
            ]);
        }
        $game->consoles()->sync($request->consoles);

        return redirect(route('game.index'))->with('gameUpdated', 'Hai modificato annuncio');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        // Usa Policy per autorizzazione
        $this->authorize('delete', $game);
        
        // Elimina il file cover se esiste
        if($game->cover){
            Storage::delete($game->cover);
        }
        
        // Detach tutte le relazioni in una sola query
        $game->consoles()->detach();

        $game->delete();
        return redirect(route('game.index'))->with('gameDeleted', 'Hai cancellato il post');
    }
}
