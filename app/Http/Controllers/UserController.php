<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\Console;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except('login', 'register');
    }

    public function login(){
        return view('auth.login');
    }
    
    public function register(){

        return view('auth.register');
    }


    public function profile(User $user = null){
        // Se non viene passato un utente, mostra il profilo dell'utente loggato
        if(!$user){
            $consoles = Console::where('user_id', Auth::id())->orderBy('created_at','DESC')->get();
            $games = Game::where('user_id', Auth::id())->orderBy('created_at','DESC')->get();
        } else {
            $consoles = Console::where('user_id', $user->id)->orderBy('created_at','DESC')->get();
            $games = Game::where('user_id', $user->id)->orderBy('created_at','DESC')->get();
        }
        
        return view ('profile', compact('consoles','games'));
    }

    public function changeAvatar(User $user, Request $request){
        // Validazione file avatar
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        if($request->hasFile('avatar')){
            $user->update([
                'avatar' => $request->file('avatar')->store('public/avatars'),
            ]);
        }
        
        return redirect()->back()->with('avatarUpdated', 'Avatar aggiornato!');
    }

    public function deleteAvatar(User $user){
        $user->update([
            'avatar' => null,
        ]);

        return redirect()->back();
    }
    public function destroy(){
        //prendo tutti i record collegati all'utente
        $user_consoles = Auth::user()->consoles;
        $user_games = Auth::user()->games;

        //Passo il vincolo all'utente con id 1 (l'admin)
        foreach($user_consoles as $console){
            $console->update([
                'user_id' => 1,
            ]);
        } 
        foreach($user_games as $game){
            $game->update([
                'user_id' => 1,
            ]);
        }
        // permette all'utente di cancellarsi
        Auth::user()->delete();

        return redirect(route('homepage'))->with('userDeleted', 'Hai cancellato il profilo , arrivederci');
    }
}
