<?php

namespace App\Http\Requests\v1\sucursals;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSucursalRequest extends FormRequest
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
            'data.type' => 'required|in:sucursals',
            'data.attributes' => 'required|array',
            'data.attributes.name' => 'sometimes|max:30|required|string|unique:sucursals,name,'.$this->input('data.id'),
            'data.attributes.is_enable' => 'sometimes|boolean',  
            'data.attributes.direccion' => 'sometimes|max:200',          
        ];
    }

    public function messages()
    {
        return [
            'data.attributes.name.required' => 'The Name field is required.',
            'data.attributes.name.max' => 'The Name must not be greater than 30 characters.',
            'data.attributes.name.unique' => 'The name has already been taken.',  
            
            'data.attributes.direccion.max' => 'The direccion must not be greater than 200 characters.',
        ];
    }
}
