<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use App\Models\Saleitem;
use App\Models\Payment;
use App\Models\Caja;
use App\Models\Stocksucursal;
use App\Models\Client;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\Http\Resources\v1\Sale\SaleResource;
use App\Http\Resources\v1\SaleList\SaleListResource;


use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Builder;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = 5;
        if($request->has('limit')){
            $limit = $request->get('limit');
        }


        $atr = [];

        $client_id = null;
        if ( $request->has('client_id')){
            array_push($atr, ['client_id', '=', $request->get('client_id')] );
        }

        $user_id = null;
        if ( $request->has('user_id')){
            array_push($atr, ['user_id', '=', $request->get('user_id')] );
        }

        $date_from = null;
        $date_to = null;
        if ( $request->has('date_from') ) {
            $date_from = $request->get('date_from');
            if ( $request->has('date_to' )) {
                $date_to = $request->get('date_to');
            }else {
                $date_to = $request->get('date_from');
            }
        }

        // date_from----
        if ( $date_from ){

            $sales = Sale::orderBy('id', 'DESC')
                ->where($atr)
                ->whereBetween('created_at', [$date_from, $date_to . ' 23:59:59'])
                ->paginate($limit);
            return SaleListResource::collection($sales);
        }

        // sin date_ftom-------
        $sales = Sale::orderBy('id', 'DESC')
            ->where($atr)
            ->where($atr)
            ->paginate($limit);
        return SaleListResource::collection($sales);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        
        $caja = null;
        if($request->has('caja_id')){
            $caja = Caja::find($request->get('caja_id'));
        }
        if ( $request->has('payments') && !$caja ){
            return response()->json(['message' => 'Caja inexistente'], 422);
        }
        if ( $request->has('payments') && !$caja->is_open ){
            return response()->json(['message' => 'Caja Cerrada'], 422);
        }

        try {

            DB::beginTransaction();
            $sale = Sale::create();

            $sale->user()->associate(Auth::user());

            $sale->sucursal()->associate($request->get('sucursal_id'));

            $sale->total = $request->get('total');

            $saldo_cliente = 0;
            $client = null;

            $client_id = null;
            if($request->has('client_id')){
                $client = User::find($request->get('client_id'));
                $sale->client()->associate($client);

                $saldo_cliente = $client->saldo;

                $saldo_cliente = $saldo_cliente + $sale->total;

                $sale->saldo = $saldo_cliente;

            }
            
            $items = $request->get('items');
            foreach ( $items as $item) {
                $saleItem = new Saleitem;

                $saleItem->sale()->associate($sale);

                $saleItem->saleproduct()->associate($item['sale_product_id']);
                $saleItem->precio = $item['precio'];
                $saleItem->cantidad = $item['cantidad'];
                
                if ( $saleItem->saleproduct->stockproduct->is_stock_unitario_kilo ) {
                    $saleItem->cantidad_total = $item['cantidad_total'];
                }
                
                $saleItem->save();
                
                // actualizo el stock  
                             
                $stocksucursal = Stocksucursal::where('stockproduct_id', $saleItem->saleproduct->stockproduct_id)
                    ->where('sucursal_id', $request->get('sucursal_id'))
                    ->first();
                //return round($item['cantidad'] * $saleItem->saleproduct->relacion_venta_stock, 6, PHP_ROUND_HALF_UP);
                $stocksucursal->stock = $stocksucursal->stock - round($item['cantidad'] * $saleItem->saleproduct->relacion_venta_stock, 6, PHP_ROUND_HALF_UP);
                
                $stocksucursal->save();

            }

            if ( $request->has('payments') ) {
                $payments = $request->get('payments');
                $i = 0;
                foreach ( $payments as $payment) {
                    $i = $i + 1;
                    $salePayment = new Payment;

                    $salePayment->sale()->associate($sale);
                    $salePayment->paymentmethod()->associate($payment['paymentmethod_id']);

                    $salePayment->valor = $payment['valor'];
                    $salePayment->caja()->associate($caja);                
                    
                    if($request->has('client_id')){
                        $saldo_cliente = $saldo_cliente - $salePayment->valor;

                        $salePayment->saldo = $saldo_cliente;
                    }

                    $salePayment->save();
                    
                    $salePayment->created_at=Carbon::parse( $salePayment->created_at)->addSeconds();
                    
                    $salePayment->save();

                }
            }
            

            if($request->has('client_id')){
                $client->saldo = $saldo_cliente;
                $client->save();
            }
            $sale->save();
            usleep(1000000);
            
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            // something went wrong
        }
        

        
        return $sale;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return new SaleResource($sale);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function make_devolution( $sale_id ) {
        $sale = Sale::findOrFail($sale_id);

        $devitems = [];
        foreach($sale->saleItems as $saleitem) {
            $devitem = [];
            $devitem['saleitem_id'] = $saleitem->id;
            $devitem['name'] = $saleitem->saleproduct->name;
            $devitem['precio'] = $saleitem->precio;
            $devitem['is_stock_unitario_kilo'] = $saleitem->saleproduct->stockproduct->is_stock_unitario_kilo;
            $devitem['cant_disponible_devolucion'] = $saleitem->get_cant_disponible_devolucion();
            $devitem['cant_total_disponible_devolucion'] = $saleitem->get_cant_total_disponible_devolucion();
            
            array_push($devitems, $devitem);
        }

        $devolution = [];
        $devolution['devitems'] = $devitems;


        return json_encode($devolution);
    }
}
