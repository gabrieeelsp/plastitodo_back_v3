<?php

namespace App\Http\Resources\v1\Sale;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'type' => 'sales',
            'attributes' => [
                'created_at' => date('d M Y - H:i', $this->created_at->timestamp),
                'total' => $this->total
            ],
            'relationships' => [
                'client' => $this->client ? [
                    'id' => $this->client->id,
                    'attributes' => [
                        'name' => $this->client->name,
                        'tipo' => $this->client->tipo
                    ] 
                ] : null,
                'user' => [
                    'id' => $this->user->id,
                    'attributes' => [
                        'name' => $this->user->name
                    ] 
                ],
                'sucursal' => [
                    'id' => $this->sucursal->id,
                    'attributes' => [
                        'name' => $this->sucursal->name
                    ] 
                ],
                'saleitems' => SaleitemResource::collection($this->saleitems),                
                'payments' => PaymentResource::collection($this->payments),
                'refonds' => RefondResource::collection($this->refonds),
                'devolutions' => DevolutionSaleResource::collection($this->devolutions),
                'creditnotes' => CreditnoteSaleResource::collection($this->creditnotes),
                'debitnotes' => DebitnoteSaleResource::collection($this->debitnotes)
                
            ]
        ]; 
        //return parent::toArray($request);
    }
}
