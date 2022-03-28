<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleproductResource extends JsonResource
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
            'type' => 'saleproducts',
            'attributes' => [
                'name' => $this->name,
                'porc_min' => $this->porc_min,
                'porc_may' => $this->porc_may,
            ],
            'relationships' => [
                'stockproduct' => [
                    'data' => [
                        'id' => $this->stockproduct_id,
                        'type' => 'stockproducts',
                        'attributes' => [
                            'name' => $this->stockproduct->name,
                            'costo' => $this->stockproduct->costo,
                            'is_stock_unitario_kilo' => $this->stockproduct->is_stock_unitario_kilo,
                            'stock_aproximado_unidad' => $this->stockproduct->stock_aproximado_unidad
                        ]
                    ]
                ]
                
            ]
        ]; 
        //return parent::toArray($request);
    }
}
