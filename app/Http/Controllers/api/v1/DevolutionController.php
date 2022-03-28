<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Devolution;
use App\Models\Devolutionitem;
use App\Models\Caja;
use App\Models\Refound;
use App\Models\Sale;
use App\Models\Stocksucursal;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use App\Http\Resources\v1\Devolution\DevolutionResource;
use App\Http\Resources\v1\Sale\DevolutionSaleResource;


class DevolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devolutions =  Devolution::all();
        return DevolutionResource::collection($devolutions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            DB::beginTransaction();
            $devolution = Devolution::create();

            $devolution->user()->associate(Auth::user());

            $devolution->sucursal()->associate($request->get('sucursal_id'));

            $sale = Sale::find($request['sale_id']);            

            $devolution->sale()->associate($sale);

            $devolution->total = $request->get('total');

            $saldo_cliente = 0;

            if ( $sale->client ){
                $saldo_cliente = $sale->client->saldo;

                $saldo_cliente = $saldo_cliente - $devolution->total;

                $devolution->saldo = $saldo_cliente;

                $sale->client->saldo = $saldo_cliente;
                $sale->client->save();
            }
            
            $items = $request->get('items');
            foreach ( $items as $item) {
                
                $devolutionItem = new Devolutionitem;

                $devolutionItem->devolution()->associate($devolution);

                
                $devolutionItem->saleitem()->associate($item['saleitem_id']);
                
                $devolutionItem->cantidad = $item['cantidad'];
                
                if ( $devolutionItem->saleitem->saleproduct->stockproduct->is_stock_unitario_kilo ) {
                    $devolutionItem->cantidad_total = $item['cantidad_total'];
                }
                
                $devolutionItem->save();
                
                // actualizo el stock  
                             
                $stocksucursal = Stocksucursal::where('stockproduct_id', $devolutionItem->saleitem->saleproduct->stockproduct_id)
                    ->where('sucursal_id', $request->get('sucursal_id'))
                    ->first();
                    
                $stocksucursal->stock = $stocksucursal->stock + $item['cantidad'];
                
                $stocksucursal->save();

            }

            $devolution->save();

            usleep(1000000);
            
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            // something went wrong
        }

        return new DevolutionSaleResource($devolution);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Devolution  $devolution
     * @return \Illuminate\Http\Response
     */
    public function show(Devolution $devolution)
    {

        return new DevolutionResource($devolution);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Devolution  $devolution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Devolution $devolution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Devolution  $devolution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Devolution $devolution)
    {
        //
    }
}
