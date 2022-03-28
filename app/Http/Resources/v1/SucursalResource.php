<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class SucursalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => 'sucursal',
            'attributes' => [
                'name' => $this->name,
                'direccion' => $this->direccion
            ]
             ,
            'relationships' => [
                'empresa' => [
                    'data' => [
                        'id' => $this->empresa_id,
                        'type' => 'empresas',
                        'attributes' => [
                            'name' => $this->when( $request->has('include_empresa_name') && $request->get('include_empresa_name') == 'true' ,
                            $this->empresa->name)
                        ]
                    ]
                ]
            ]
        ];    
        //return parent::toArray($request);
    }
}
