<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use Illuminate\Http\Request;
use App\Models\Sucursal;

use App\Http\Requests\v1\cajas\CreateCajaRequest;
use App\Http\Requests\v1\cajas\CloseCajaRequest;
use App\Http\Resources\v1\CajaResource;

class CajaController extends Controller
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

        
        $cajas = Caja::orderBy('created_at', 'ASC')
            ->paginate($limit);
        return CajaResource::collection($cajas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCajaRequest $request)
    {
        //verificar que no tenga otra caja abierta
        if ( $this->have_caja_open() ) {
            return response()->json(['message' => 'Ya posee una caja abierta'], 422);
        }
        $data = $request->get('data');
        $sucursal_id = $data['relationships']["sucursal"]["data"]["id"];

        $caja = Caja::create($request->input('data.attributes'));
        
        $caja->is_open = true;
        $caja->user()->associate(auth()->user());
        $caja->sucursal()->associate(Sucursal::find($sucursal_id));
        $caja->save();
     
        return (new CajaResource($caja))
            ->response()
            ->header('Location', route('cajas.show', ['caja' => $caja]));
    }

    public function close(CloseCajaRequest $request, $caja_id){
        $caja = Caja::findOrFail($caja_id);

        if ( !$caja->is_open ) {
            return response()->json(['message' => 'La caja solicitada ya se encuentra cerrada'], 422);
        }
        $data = $request->get('data');
        $dinero_final = $data['attributes']['dinero_final'];

        $caja->dinero_final = $dinero_final;

        $caja->is_open = false;

        $caja->save();

        return (new CajaResource($caja))
            ->response()
            ->header('Location', route('cajas.show', ['caja' => $caja]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function show(Caja $caja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caja $caja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caja  $caja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caja $caja)
    {
        //
    }

    public function find($sucursal_id) {
        $atr = [];

        array_push($atr, ['sucursal_id', $sucursal_id] );

        array_push($atr, ['is_open', true] );

        array_push($atr, ['user_id', auth()->user()->id] );

        $caja = Caja::where($atr)->firstOrFail();

        return new CajaResource($caja);
    }

    private function have_caja_open() {
        $atr = [];

        array_push($atr, ['is_open', true] );

        array_push($atr, ['user_id', auth()->user()->id] );

        $caja = Caja::where($atr)->get();
        if ( count($caja) !=0 ) {
            return true;
        }
        return false;
    }
}
