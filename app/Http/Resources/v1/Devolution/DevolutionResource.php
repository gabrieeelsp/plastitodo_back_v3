<?php

namespace App\Http\Resources\v1\Devolution;

use Illuminate\Http\Resources\Json\JsonResource;

class DevolutionResource extends JsonResource
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
            'type' => 'devolutions',
            'attributes' => [
                'created_at' => date('d M Y - H:i', $this->created_at->timestamp),
                'total' => $this->total
            ],
            'relationships' => [
                'user' => [
                    'id' => $this->caja->user->id,
                    'attributes' => [
                        'name' => $this->caja->user->name
                    ] 
                ],
                'devolutionitems' => DevolutionitemResource::collection($this->devolutionitems),
                
            ]
        ]; 
        //return parent::toArray($request);
    }
}
