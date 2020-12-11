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
            "persona.id" => ['required', 'numeric'],
            "persona.nombre" => ['required'],
            "persona.apellido_paterno" => ['required'],
            "persona.apellido_materno" => ['required'],
            "persona.fecha_nacimiento" => ['required', 'date'],
            "persona.direccion" => ['max:250'],
            "persona.sexo" => ['max:10'],
            "fecha_inicio_periodo" => ['required', 'date'],
            "fecha_termino_contrato" => ['required', 'date'],
            "regimen_id" => ['required', 'numeric'],
            "empresa_id" => ['required', 'numeric'],
            "oficio.id" => ['required', 'numeric'],
            "oficio.name" => ['required', 'max:100'],
            "tipo_cese_id" => ['required', 'numeric'],
            "fecha_finiquito" => ['date'],
            "zona_labor" => ["max:150"],
        ];
    }
}
