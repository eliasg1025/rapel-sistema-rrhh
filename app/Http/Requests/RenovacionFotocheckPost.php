<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RenovacionFotocheckPost extends FormRequest
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
            'fecha_solicitud' => 'required|date',
            'regimen_id' => 'required|numeric',
            'zona_labor_id' => 'required|numeric',
            'motivo_perdida_fotocheck_id' => 'required|numeric',
            'color_fotocheck_id' => 'required|numeric',
            'empresa_id' => 'required|numeric'
        ];
    }

    public function messages()
    {
        //
    }
}
