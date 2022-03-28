<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentmethodResource extends JsonResource
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
            'type' => 'paymentmethods',
            'attributes' => [
                'name' => $this->name,
                'is_enable' => boolval($this->is_enable),
            ]
        ]; 
        //return parent::toArray($request);
    }
}
