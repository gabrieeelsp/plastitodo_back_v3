<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Creditnote;
use App\Models\Sale;
use Illuminate\Http\Request;

use App\Http\Requests\v1\creditnote\CreateCreditnoteRequest;

use App\Http\Resources\v1\Sale\CreditnoteSaleResource;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreditnoteController extends Controller
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
    public function store(CreateCreditnoteRequest $request)
    {
        $data = $request->get('data');
        try {

            DB::beginTransaction();
            $creditnote = new Creditnote;

            $creditnote->user()->associate(Auth::user());

            $creditnote->sucursal()->associate($data['relationships']['sucursal']['data']['id']);

            $sale = Sale::find($data['relationships']['sale']['data']['id']);            

            $creditnote->sale()->associate($sale);

            $creditnote->valor = $data['attributes']['valor'];
            $creditnote->description = $data['attributes']['description'];

            $saldo_cliente = 0;

            if ( $sale->client ){
                $saldo_cliente = $sale->client->saldo;

                $saldo_cliente = $saldo_cliente - $creditnote->valor;

                $creditnote->saldo = $saldo_cliente;

                $sale->client->saldo = $saldo_cliente;
                $sale->client->save();
            }

            $creditnote->save();

            usleep(1000000);
            
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            // something went wrong
        }

        return new CreditnoteSaleResource($creditnote);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Creditnote  $creditnote
     * @return \Illuminate\Http\Response
     */
    public function show(Creditnote $creditnote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Creditnote  $creditnote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Creditnote $creditnote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Creditnote  $creditnote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Creditnote $creditnote)
    {
        //
    }
}
