<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FiniquitosPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "persona_id" => ['required', 'numeric'],
            "nombre" => ['required'],
            "apellido_paterno" => ['required'],
            "apellido_materno" => ['required'],
            "fecha_nacimiento" => ['required', 'date'],
            "direccion" => ['max:250'],
            "sexo" => ['max:10'],
            "fecha_inicio_periodo" => ['required', 'date'],
            "fecha_termino_contrato" => ['required', 'date'],
            "regimen_id" => ['required', 'numeric'],
            "empresa_id" => ['required', 'numeric'],
            "oficio_id" => ['required', 'numeric'],
            "oficio_name" => ['required', 'max:100'],
            "tipo_cese_id" => ['required', 'numeric'],
        ];
    }
}
