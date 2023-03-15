<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'product',
        'description',
        'cover',
        'user_id',
    ];

    //UN OGGETTO DI CLASSE GAME PUO' ESSERE RELAZIONATO A UN SOLO UTENTE
    public function user(){
        return $this->belongsTo(User::class);
    }

}
