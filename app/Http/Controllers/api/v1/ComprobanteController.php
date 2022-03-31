<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Comprobante;
use Illuminate\Http\Request;

use App\Models\Sale;

class ComprobanteController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function show(Comprobante $comprobante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comprobante $comprobante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comprobante $comprobante)
    {
        //
    }

    public function make_comprobante_factura ( Request $request ) 
    {
        $sale = Sale::findOrFail($request->get('sale_id'));
        if ( $sale->comprobante ) {
            return "Ya esta facturada";
        }

        //obtengo el cliente y verfico que reciba factua A
        




        $comprobante = new Comprobante;

        $comprobante->punto_venta = '001';
        $comprobante->numero = '00003';

        $comprobante->comprobanteable_id = $sale->id;
        $comprobante->comprobanteable_type = "App\Models\Sale";

        $comprobante->save();
    }

    private function 
}
