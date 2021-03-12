<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanillaManualPost extends FormRequest
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
            'fecha_planilla' => 'required|date',
            'regimen_id' => 'required|numeric',
            'zona_labor_id' => 'required|numeric',
            'empresa_id' => 'required|numeric',
            'motivo_planilla_manual_id' => 'required|numeric',
        ];
    }
}
