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
        $rules = [
            'name' =>'required|min:2',
            'brand' =>'required',
            'description' =>'required|min:20',
            'games' => 'nullable|array',
        ];

        // Logo obbligatorio solo in creazione, opzionale in update
        if ($this->isMethod('post')) {
            $rules['logo'] = 'required|image|max:2048';
            $rules['name'] .= '|unique:consoles,name';
        } else {
            $rules['logo'] = 'nullable|image|max:2048';
            // Permette update del nome escludendo il record corrente
            $rules['name'] .= '|unique:consoles,name,' . $this->route('console')?->id;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Devi mettere il nome del boss!',
            'name.unique' => 'Questo boss esiste già!',
            'logo.required' => 'Inserire un immagine',
            'brand.required' => 'Inserire una debolezza',
            'name.min'=> 'Il nome deve contenere almeno più di 2 caratteri',
            'logo.image'=>'Cambia il formato della foto, questo non è compatibile',
            'description.min'=>'La descrizione deve contenere almeno 20 caratteri',
        ];
    }
}
