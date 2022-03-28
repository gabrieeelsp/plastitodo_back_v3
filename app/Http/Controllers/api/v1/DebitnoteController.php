<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Debitnote;
use App\Models\Sale;
use Illuminate\Http\Request;

use App\Http\Requests\v1\debitnote\CreateDebitnoteRequest;

use App\Http\Resources\v1\Sale\DebitnoteSaleResource;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class DebitnoteController extends Controller
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
    public function store(CreateDebitnoteRequest $request)
    {
        $data = $request->get('data');
        try {

            DB::beginTransaction();
            $debitnote = new Debitnote;

            $debitnote->user()->associate(Auth::user());

            $debitnote->sucursal()->associate($data['relationships']['sucursal']['data']['id']);

            $sale = Sale::find($data['relationships']['sale']['data']['id']);            

            $debitnote->sale()->associate($sale);

            $debitnote->valor = $data['attributes']['valor'];
            $debitnote->description = $data['attributes']['description'];

            $saldo_cliente = 0;

            if ( $sale->client ){
                $saldo_cliente = $sale->client->saldo;

                $saldo_cliente = $saldo_cliente + $debitnote->valor;

                $debitnote->saldo = $saldo_cliente;

                $sale->client->saldo = $saldo_cliente;
                $sale->client->save();
            }

            $debitnote->save();

            usleep(1000000);
            
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            // something went wrong
        }

        return new DebitnoteSaleResource($debitnote);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Debitnote  $debitnote
     * @return \Illuminate\Http\Response
     */
    public function show(Debitnote $debitnote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Debitnote  $debitnote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Debitnote $debitnote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Debitnote  $debitnote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Debitnote $debitnote)
    {
        //
    }
}
