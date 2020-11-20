<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GruposFiniquitosPost extends FormRequest
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
            'usuario_id'    => 'required|exists:App\Models\Usuario,id|numeric',
            'fecha_finiquito' => 'required|date',
            'zona_labor'    => 'required',
            'ruta'          => 'required',
            'codigo_bus'    => 'required|numeric'
        ];
    }
}
