<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Requests\GameRequest;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{


    //MIDDLEWARE
    public function __construct(){
        $this->middleware('auth')->except('index', 'show');
    }



    //CRUD
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
            'cover'=>$request->file('cover')->store('public/covers'),
            'user_id'=> Auth::user()->id,
        ]);

        return redirect(route('homepage'))->with('gameCreated', 'hai inserito il video gioco');
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
        return view('game.edit', compact('game'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        if($request->cover){
            $game->update([
                'title'=>$request->title,
                'price'=>$request->price,
                'description'=>$request->description,
                'cover'=>$request->file('cover')->store('public/foto'),
            ]);
        }else{
            $game->update([
                'title'=>$request->title,
                'price'=>$request->price,
                'description'->$request->description,
            ]);
        }

        return redirect(route('homepage'))->with('houseUpdated', 'Hai modificato annuncio');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        foreach($console->games as $game){
            $console->games()->detach($game->id);
        }

        $game->delete();
        return redirect(route('homepage'))->with('gameDeleted', 'Hai cancellato il post');
    }
}
