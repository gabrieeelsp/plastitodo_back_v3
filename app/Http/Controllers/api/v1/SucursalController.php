<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Sucursal;
use Illuminate\Http\Request;

use App\Http\Requests\v1\sucursals\CreateSucursalRequest;
use App\Http\Requests\v1\sucursals\UpdateSucursalRequest;

use App\Http\Resources\v1\SucursalResource;

use App\Models\Empresa;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $searchText = trim($request->get('q'));
        $val = explode(' ', $searchText );
        $atr = [];
        foreach ($val as $q) {
            array_push($atr, ['name', 'LIKE', '%'.strtolower($q).'%'] );
        };

        $limit = 5;
        if($request->has('limit')){
            $limit = $request->get('limit');
        }

        
        $sucrusals = Sucursal::orderBy('name', 'ASC')
            ->where($atr)
            ->paginate($limit);
        return SucursalResource::collection($sucrusals);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSucursalRequest $request)
    {
        $data = $request->get('data');
        $empresa_id = $data['relationships']["empresa"]["data"]["id"];

        $sucursal = Sucursal::create($request->input('data.attributes'));

        $sucursal->empresa()->associate(Empresa::find($empresa_id));
        $sucursal->save();
     
        return (new SucursalResource($sucursal))
            ->response()
            ->header('Location', route('sucursals.show', ['sucursal' => $sucursal]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Sucursal $sucursal)
    {
        return new SucursalResource($sucursal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSucursalRequest $request, Sucursal $sucursal)
    {
        //return response()->json(['message' => 'Forbidden action'], 403);
        
        $sucursal->update($request->input('data.attributes'));
        
        return new SucursalResource($sucursal);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sucursal $sucursal)
    {
        //
    }
    
}
