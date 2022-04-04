<?php

namespace App\Http\Resources\v1\Sale;

use Illuminate\Http\Resources\Json\JsonResource;

use Carbon\Carbon;

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
                        'tipo' => $this->client->tipo,
                        'fact_default' => $this->client->fact_default
                    ],
                    'relationships' => [
                        'modelofact' => $this->client->modelofact ? [
                            'id' => $this->client->modelofact->id,
                            'attributes' => [
                                'name' => $this->client->modelofact->name,
                            ] 
                        ] : null,
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
                'debitnotes' => DebitnoteSaleResource::collection($this->debitnotes),
                'comprobante' => $this->comprobante ? [
                    'id' => $this->comprobante->id,
                    'attributes' => [
                        'punto_venta' => $this->comprobante->punto_venta,
                        'numero' => $this->comprobante->numero,
                        'cae' => $this->comprobante->cae,
                        'cae_fch_vto' => date('d M Y - H:i', Carbon::parse($this->comprobante->cae_fch_vto)->timestamp),
                        'tipo' => $this->comprobante->modelofact->name
                    ] 
                ] : null,
                
            ]
        ]; 
        //return parent::toArray($request);
    }
}
