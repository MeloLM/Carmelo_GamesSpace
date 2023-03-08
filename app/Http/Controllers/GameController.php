<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Requests\GameRequest;

class GameController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except('index', 'show');
    }


    public function homepage () {
        $games = Game::all();
            
            // return view('welcome',['games'=> $games]);
            return view('welcome', compact('games')); 
        }

    public function create_game(){
        return view('game.createGame');
    }

    public function store(GameRequest $request){



        $game = Game::create([
            'title'=>$request->title,
            'price'=>$request->price,
            'description'=>$request->description,
            'product'=>$request->product,
            'cover'=>$request->file('cover')->store('public/covers'),
        ]);
        return redirect(route('homepage'))->with('gameCreated', 'hai inserito il video gioco');
    }
}
