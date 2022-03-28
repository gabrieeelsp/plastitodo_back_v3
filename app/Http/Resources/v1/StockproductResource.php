<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class StockproductResource extends JsonResource
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
            'type' => 'stockproducts',
            'attributes' => [
                'name' => $this->name,
                'costo' => $this->costo,
                'porc_min' => $this->porc_min,
                'porc_may' => $this->porc_may,
            ]
        ]; 
        //return parent::toArray($request);
    }
}
