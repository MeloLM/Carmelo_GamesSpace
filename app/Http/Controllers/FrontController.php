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
        $games = Game::with('user')->get();
            
            return view('welcome', compact('games')); 
        }

    public function contact_us(){
        return view('contact_us');
    }

    public function contact_us_submit(Request $request){
        // Validazione input
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $message = $request->input('message');

        $userData = compact('name', 'email', 'message');
        Mail::to($email)->send(new ContactMail($userData));
        return redirect(route('homepage'))->with('Sented', 'Email inviata! Grazie per averci contattato!');
    }
}
