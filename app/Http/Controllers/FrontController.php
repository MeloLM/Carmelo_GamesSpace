<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\Console;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function homepage () {
        $games = Game::all();
            
            // return view('welcome',['games'=> $games]);
            return view('welcome', compact('games')); 
        }
    public function profile(){
        //sfruttare la relazione
        return view('profile');

        //sfruttare una query al db
        //FLUENT INTERFACE + METHOD CHAINING

        //// $consoles = Console::where('user_id', Auth::id())->orderBy('created_at','DESC')->get();

        // $query--> where--> orderBy
        //tutti i record -->recupera solo quelli dall'utente loggato--> ordino
        
        ////return view ('profile', compact('consoles'));
    }

    public function changeAvatar(User $user, Request $request){

            
            $user->update([
                'avatar' => $request->file('avatar')->store('public/avatars'),
            ]);
        
        return redirect()->back();
    }
}
