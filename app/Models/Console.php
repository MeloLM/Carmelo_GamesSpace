<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Console extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'brand',
        'description',
        'user_id',
    ];
    public function user(){
        //UN UTENTE HA PIU' CONSOLE
        return $this->belongsTo(User::class);
    }
}
