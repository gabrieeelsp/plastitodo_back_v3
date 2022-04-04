<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Comprobante;
use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\Iva;

use Carbon\Carbon;

use Afip;
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
            return response()->json(['message' => 'Ya esta facturada'], 422);

        }

        //obtengo el cliente y verfico que reciba factua A
        if ( !$sale->client ) {
            return response()->json(['message' => 'El cliente debe estar registrado'], 422);
        }
        if ( 
            !$sale->client->ivacondition ||
            !$sale->client->ivacondition->accept_modelofact(1)
            ) {
            return response()->json(['message' => 'Error condicion frente al IVA'], 422);
        }

        if ( 
            !$sale->client->tipo_id ||
            $sale->client->tipo_id != 'CUIT'  
            ) {
            return response()->json(['message' => 'Error tipo de identificación del cliente'], 422);
        }
        if ( !$sale->client->numero_id ) {
            return response()->json(['message' => 'Error numero de identificación del cliente'], 422);
        }
        //date < 5 dias atras
        $date = $sale->created_at->format('Ymd');

        $ivas = array();
        
        foreach ( Iva::all() as $iva) {
            $baseImpIvaEsp = $sale->getBaseImpIvaEsp($iva->id);
            if ( $baseImpIvaEsp ){
                array_push($ivas, array(
                    'Id' 		=> $iva->codigo_afip, // Id del tipo de IVA (5 para 21%)(ver tipos disponibles) 
                    'BaseImp' 	=> $baseImpIvaEsp, // Base imponible
                    'Importe' 	=> $sale->getImpIvaEsp($iva->id) // Importe 
                ) );
            }
        }

        

        $data = array(
            'CantReg' 	=> 1,  // Cantidad de comprobantes a registrar
            'PtoVta' 	=> $sale->sucursal->punto_venta_fe,  // Punto de venta
            'CbteTipo' 	=> 1,  // Tipo de comprobante (ver tipos disponibles) 
            'Concepto' 	=> 1,  // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
            'DocTipo' 	=> 80, // Tipo de documento del comprador (99 consumidor final, ver tipos disponibles)
            'DocNro' 	=> $sale->client->numero_id,  // Número de documento del comprador (0 consumidor final)
            'CbteFch' 	=> intval($date), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
            'ImpTotal' 	=> floatval($sale->total), // Importe total del comprobante
            'ImpTotConc' 	=> 0,   // Importe neto no gravado
            'ImpNeto' 	=> round($sale->getImpNeto(), 2, PHP_ROUND_HALF_UP), // Importe neto gravado
            'ImpOpEx' 	=> 0,   // Importe exento de IVA
            'ImpIVA' 	=> round($sale->getImpIVA(), 2, PHP_ROUND_HALF_UP),  //Importe total de IVA
            'ImpTrib' 	=> 0,   //Importe total de tributos
            'MonId' 	=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
            'MonCotiz' 	=> 1,     // Cotización de la moneda usada (1 para pesos argentinos)  
            'Iva' 		=> $ivas, 
        );

        //return json_encode($data);

        $afip = new Afip(array('CUIT' => 20291188568));
        
        $res = $afip->ElectronicBilling->CreateNextVoucher($data, false);

        $comprobante = new Comprobante;

        $comprobante->punto_venta = $sale->sucursal->punto_venta_fe;
        $comprobante->numero = $res['voucher_number'];
        $comprobante->cae = $res['CAE'];

        $comprobante->cae_fch_vto = Carbon::parse($res['CAEFchVto']);

        $comprobante->comprobanteable_id = $sale->id;
        $comprobante->comprobanteable_type = "App\Models\Sale";

        $comprobante->modelofact_id = 1;

        $comprobante->save();
        return $comprobante;
    }   

    
}
