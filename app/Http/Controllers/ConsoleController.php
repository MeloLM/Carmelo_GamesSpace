<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Console;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ConsoleRequest;

class ConsoleController extends Controller
{
    //CRUD - CREATE READ UPTADE DELETE
    
    public function __construct(){
        $this->middleware('auth')->except('index', 'show');
    }
    
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $consoles = Console::all();
        
        return view('console.index', compact('consoles'));
    }
    
    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        $games = Game::all();
        
        return view('console.create',compact('games'));
    }
    
    /**
    * Store a newly created resource in storage.
    */
    public function store(ConsoleRequest $request)
    {
        //CARMELO PREFERISCE QUESTA
        //PRENDO OGGETTO DI CLASSE CONSOLE E GLI 'ATTACCO' IL RECORD GAME
        $console = Console::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'logo' => $request->file('logo')->store('public/logos'),
            'description' => $request->description,
            'user_id'=> Auth::user()->id,
        ]);
        $console->games()->attach($request->games);
        
        
        //PRENDO OGGETTO DI CLASSE GAME E CREO CONSOLE
        // $game = Game::find($request->game);
        
        // $game->consoles()->create([
            //     'name' => $request->name,
            //     'brand' => $request->brand,
            //     'logo' => $request->file('logo')->store('public/logos'),
            //     'description' => $request->description,
            //     'user_id'=> Auth::user()->id,
            // ]);
            
        return redirect(route('console.index'))->with('consoleCreated', 'Hai creato con successo una console!');
    }
        
    /**
    * Display the specified resource.
    */
    public function show(Console $console)
    {
        return view('console.show', compact('console'));
    }
    
    /**
    * Show the form for editing the specified resource.
    */
    public function edit(Console $console)
    {
        if ($console->user_id != Auth::id()){
            return redirect(route('homepage'))->with('accessDenied','You are not authorized!');
        }
        
        $games = Game::all();
        
        return view('console.edit', compact('console','games'));
    }
        
    /**
    * Update the specified resource in storage.
    */
    public function update(ConsoleRequest $request, Console $console)
    {
        
        $console->update([
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
        ]);
        
        if($request->logo){
            $console->update([
                'logo' => $request->file('logo')->store('public/logos'),
            ]);
        }
        
        $console->games()->attach($request->games);
        
        return redirect(route('console.index'))->with('houseUpdated', 'Hai modificato annuncio');
    }
        
    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Console $console, Game $game)
    {
        foreach($console->games as $game){
            $console->games()->detach($game->id);
        }
        
        $console->delete();
        
        return redirect(route('console.index'))->with('consoleDeleted', 'Hai cancellato annuncio');
    }
}
    