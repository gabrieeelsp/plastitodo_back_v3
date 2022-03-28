<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'type' => 'clients',
            'attributes' => [
                'name' => $this->name,
                'surname' => $this->surname,
                'tipo' => $this->tipo,
                'direccion' => $this->direccion,
                'telefono' => $this->telefono,
                'saldo' => $this->saldo,

                'cuit' => $this->cuit,
                'direccion_fact' => $this->direccion_fact,

                'coments_client' => $this->coments_client
            ]
        ]; 
        //return parent::toArray($request);
    }
}
