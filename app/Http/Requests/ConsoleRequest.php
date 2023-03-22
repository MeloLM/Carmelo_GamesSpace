<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' =>'required|min:2|unique:consoles,name',
            'logo' =>'required|image',
            'brand' =>'required',
            'description' =>'required|min:20'        
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Devi mettere il nome della console!',
            'logo.required' => 'Inserire un immagine',
            'brand.required' => 'Inserire un brand',
            'name.min'=> 'Il nome deve contenere almeno più di 2 caratteri',
            'logo.image'=>'Cambia il formato della foto ,questo non è compatibile',
            'description.min'=>'La descrizioni deve conternere almeno 20 caratteri',
            'name.required'=>'Questa console esiste già'
        ];
    }
}
