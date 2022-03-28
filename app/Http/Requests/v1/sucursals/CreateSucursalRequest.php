<?php

namespace App\Http\Requests\v1\sucursals;

use Illuminate\Foundation\Http\FormRequest;

class CreateSucursalRequest extends FormRequest
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
            'data.type' => 'required|in:sucursals',
            'data.attributes' => 'required|array',
            'data.attributes.name' => 'required|max:30|string|unique:sucursals,name', 
            'data.attributes.direccion' => 'sometimes|max:200',
            'data.relationships.empresa.data.id' => 'required|exists:empresas,id'           
        ];
    }

    public function messages()
    {
        return [
            'data.attributes.name.required' => 'The Name field is required.',
            'data.attributes.name.max' => 'The Name must not be greater than 30 characters.',
            'data.attributes.name.unique' => 'The name has already been taken.', 

            'data.attributes.direccion.max' => 'The Dicreccion must not be greater than 200 characters.',

            'data.relationships.empresa.data.id.exists' => 'The empresa id is invalid.',            
        ];
    }
}
