<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Refond;
use Illuminate\Http\Request;

use App\Models\Caja;
use App\Models\Sale;

use App\Http\Requests\v1\refonds\CreateRefondRequest;

use App\Http\Resources\v1\Sale\RefondResource;

use Illuminate\Support\Facades\DB;

class RefondController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRefondRequest $request)
    {
        $data = $request->get('data');

        $caja = Caja::find($data['relationships']['caja']['data']['id']);

        if ( !$caja->is_open ){
            return response()->json(['message' => 'Caja Cerrada'], 422);
        }

        $sale = Sale::find($data['relationships']['sale']['data']['id']);

        try{
            DB::beginTransaction();

            $saleRefond = new Refond;

            $saleRefond->sale()->associate($sale);
            $saleRefond->paymentmethod()->associate($data['relationships']['paymentmethod']['data']['id']);
            $saleRefond->caja()->associate($caja);

            $saleRefond->valor = $data['attributes']['valor'];

            if ( $sale->client ){
                $saldo_cliente = $sale->client->saldo;
                $saldo_cliente = $saldo_cliente + $saleRefond->valor;

                $saleRefond->saldo = $saldo_cliente;
                $sale->client->save();
            }

            $saleRefond->save();

            usleep(1000000);
            
            DB::commit();
            // all good

        }  catch (\Exception $e) {
            DB::rollback();
            return $e;
            // something went wrong
        } 
        return new RefondResource($saleRefond);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Refond  $refond
     * @return \Illuminate\Http\Response
     */
    public function show(Refond $refond)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Refond  $refond
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Refond $refond)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Refond  $refond
     * @return \Illuminate\Http\Response
     */
    public function destroy(Refond $refond)
    {
        //
    }
}
