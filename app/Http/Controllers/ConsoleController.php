<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Console;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ConsoleRequest;

class ConsoleController extends Controller
{
    //CRUD - CREATE READ UPDATE DELETE
    
    public function __construct(){
        $this->middleware('auth')->except('index', 'show');
    }
    
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $consoles = Console::with('user', 'games')->get();
        
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
        $console = Console::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'logo' => $request->hasFile('logo') ? $request->file('logo')->store('public/logos') : null,
            'description' => $request->description,
            'user_id'=> Auth::id(),
        ]);

        if ($request->games) {
            $console->games()->sync($request->games);
        }
            
        return redirect(route('console.index'))->with('consoleCreated', 'Hai creato con successo il boss!');
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
        // Usa Policy per autorizzazione
        $this->authorize('update', $console);
        
        $games = Game::all();
        
        return view('console.edit', compact('console','games'));
    }
        
    /**
    * Update the specified resource in storage.
    */
    public function update(ConsoleRequest $request, Console $console)
    {
        // Usa Policy per autorizzazione
        $this->authorize('update', $console);
        
        $console->update([
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
        ]);
        
        if($request->hasFile('logo')){
            // Elimina il vecchio logo se esiste
            if($console->logo){
                Storage::delete($console->logo);
            }
            $console->update([
                'logo' => $request->file('logo')->store('public/logos'),
            ]);
        }
        
        $console->games()->sync($request->games);
        
        return redirect(route('console.index'))->with('consoleUpdated', 'Hai modificato il boss!');
    }
        
    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Console $console)
    {
        // Usa Policy per autorizzazione
        $this->authorize('delete', $console);
        
        // Elimina il file logo se esiste
        if($console->logo){
            Storage::delete($console->logo);
        }
        
        // Detach tutte le relazioni in una sola query
        $console->games()->detach();
        
        $console->delete();
        
        return redirect(route('console.index'))->with('consoleDeleted', 'Hai cancellato il boss!');
    }
}
    