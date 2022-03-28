<?php

namespace App\Http\Requests\v1\creditnotes;

use Illuminate\Foundation\Http\FormRequest;

class CreateCreditnoteRequest extends FormRequest
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
            'data.type' => 'required|in:creditnotes',
            'data.attributes' => 'required|array',
            'data.attributes.description' => 'required|max:200|string',  
            'data.attributes.valor' => 'sometimes|numeric|min:0',
            'data.relationships.sale.data.id' => 'required|exists:sales,id',
            'data.relationships.sucursal.data.id' => 'required|exists:sucursals,id'
        ];
    }

    public function messages()
    {
        return [
            'data.attributes.valor.required' => 'The valor field is required.',
            'data.attributes.valor.min' => 'The valor field must be at least 0',

            'data.attributes.description.required' => 'The Description field is required.',
            'data.attributes.description.max' => 'The Description must not be greater than 200 characters.',
            

            'data.relationships.sale.data.id.exists' => 'The sale id is invalid.',             
            'data.relationships.sucursal.data.id.exists' => 'The sucursal id is invalid.',             
        ];
    }
}
