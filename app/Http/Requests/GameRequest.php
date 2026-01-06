<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
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
        $rules = [
            'title'=> 'required|min:3',
            'product'=> 'max:200',
            'price'=> 'required|numeric|min:0',
            'description'=>'required|min:10',
            'consoles' => 'nullable|array',
        ];

        // Cover obbligatorio solo in creazione, opzionale in update
        if ($this->isMethod('post')) {
            $rules['cover'] = 'required|image|max:2048';
            $rules['title'] .= '|unique:games,title';
        } else {
            $rules['cover'] = 'nullable|image|max:2048';
            // Permette update del titolo escludendo il record corrente
            $rules['title'] .= '|unique:games,title,' . $this->route('game')?->id;
        }

        return $rules;
    }



    public function messages(): array
    {
        return [
            'title.required' => 'Titolo mancante. inserire titolo',
            'title.min' => 'Titolo deve contenere almeno 3 caratteri.',
            'description.required' => 'Inserire un sommario del gioco',
            'price.required' => 'Prezzo mancante. inserire prezzo',
            'price.number' => 'Inserire un prezzo valido',
            'cover.required' => 'Immagine mancante. inserire immagine',
            'cover.image' => 'Immagine non valida. inserire immagine',
            'product.required'=>'Brand gioco non inserito.',
            'product.max'=>'Hai superato il limite massimo di 200 caratteri.',
            'title.unique'=>'Questo gioco è già presente'
        ];
    }
}
