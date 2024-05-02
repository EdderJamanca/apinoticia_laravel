<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticiaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "CategoriaId"=>"required|integer",
            "Titulo"=>"required|string|max:255",
            "Resumen"=>"required",
            "Img"=>"string",
            "Contenido"=>"required",
            "Calificacion"=>"required|in:0,1,2,3,4,5",
            "Nom_Autor"=>"required"
        ];
    }
}
