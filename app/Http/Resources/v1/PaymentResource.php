<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'type' => 'payments',
            'attributes' => [
                'valor' => $this->valor
            ],
            'relationships' => [
                'paymentmethod' => new PaymentmethodResource($this->paymentmethod)
                
            ]

        ]; 
        //return parent::toArray($request);
    }
}
