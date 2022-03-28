<?php

namespace App\Http\Resources\v1\Sale;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleitemResource extends JsonResource
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
            'type' => 'saleitems',
            'attributes' => [
                'cantidad' => $this->cantidad,
                'precio' => $this->precio,
                'saleproduct_id' => $this->saleproduct_id,
                'is_stock_unitario_kilo' => $this->saleproduct->stockproduct->is_stock_unitario_kilo,
                'stock_aproximado_unidad' => $this->saleproduct->stockproduct->stock_aproximado_unidad,
                'cantidad_total' => $this->cantidad_total,
                'name' => $this->saleproduct->name
            ]
        ]; 
        //return parent::toArray($request);
    }
}
