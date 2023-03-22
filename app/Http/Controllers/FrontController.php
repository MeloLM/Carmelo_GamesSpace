<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\Console;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
    public function homepage () {
        $games = Game::all();
            
            // return view('welcome',['games'=> $games]);
            return view('welcome', compact('games')); 
        }

    public function contact_us(){
        return view('contact_us');
    }

    public function contact_us_submit(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $message = $request->input('message');

        $userData = compact('name', 'email', 'message');
        Mail::to($email)->send(new ContactMail($userData));
        return redirect(route('homepage'))->with('Sented', 'Email inviata! Grazie per averci contattato!');
    }

    public function profile(User $user = NULL){
        //sfruttare la relazione
        // return view('profile');

        //sfruttare una query al db
        //FLUENT INTERFACE + METHOD CHAINING

        //// $consoles = Console::where('user_id', Auth::id())->orderBy('created_at','DESC')->get();

        // $query--> where--> orderBy
        //tutti i record -->recupera solo quelli dall'utente loggato--> ordino
        
        if(!user){
            $consoles = Console::where('user_id', Auth::id())->orderBy('created_at','DESC')->get();
            $games = Game::where('user_id', Auth::id())->orderBy('created_at','DESC')->get();
        } else {
            $consoles = Console::where('user_id', $user->id)->orderBy('created_at','DESC')->get();
            $games = Game::where('user_id', $user->id)->orderBy('created_at','DESC')->get();
        }

        return view ('profile', compact('consoles', 'games'));
    }

    public function changeAvatar(User $user, Request $request){

            
            $user->update([
                'avatar' => $request->file('avatar')->store('public/avatars'),
            ]);
        
        return redirect()->back();
    }
}
