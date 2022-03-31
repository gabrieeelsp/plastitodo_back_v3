<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ModelofactResource extends JsonResource
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
            'type' => 'modelofacts',
            'attributes' => [
                'name' => $this->name,
                'monto_max' => $this->monto_max,
                'monto_max_no_id_efectivo' => $this->monto_max_no_id_efectivo,
                'monto_max_no_id_no_efectivo' => $this->monto_max_no_id_no_efectivo,
                'is_enable' => boolval($this->is_enable),
            ]
        ]; 
        //return parent::toArray($request);
    }
}
