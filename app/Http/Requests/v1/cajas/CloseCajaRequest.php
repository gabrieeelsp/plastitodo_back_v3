<?php

namespace App\Http\Requests\v1\cajas;

use Illuminate\Foundation\Http\FormRequest;

class CloseCajaRequest extends FormRequest
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
            'data' => 'required|array',
            'data.id' => 'required|string',
            'data.type' => 'required|in:cajas',
            'data.attributes' => 'required|array',
            'data.attributes.dinero_final' => 'required|numeric|min:0'          
        ];
    }

    public function messages()
    {
        return [
            'data.attributes.dinero_inicial.numeric' => 'The Dinero Inicial field must be numeric',
            'data.attributes.dinero_inicial.min' => 'The dinero inicial field must be at least 0',
        ];
    }
}
