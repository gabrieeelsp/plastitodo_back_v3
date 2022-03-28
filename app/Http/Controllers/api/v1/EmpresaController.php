<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

use App\Http\Requests\v1\empresas\CreateEmpresaRequest;
use App\Http\Requests\v1\empresas\UpdateEmpresaRequest;

use App\Http\Resources\v1\EmpresaResource;

class EmpresaController extends Controller
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

        
        $empresas = Empresa::orderBy('name', 'ASC')
            ->where($atr)
            ->paginate($limit);
        return EmpresaResource::collection($empresas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmpresaRequest $request)
    {
        $empresa = Empresa::create([
            'name' => $request->input('data.attributes.name'),
        ]);
        return (new EmpresaResource($empresa))
            ->response()
            ->header('Location', route('empresas.show', ['empresa' => $empresa]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        return new EmpresaResource($empresa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmpresaRequest $request, Empresa $empresa)
    {
        $empresa->update($request->input('data.attributes'));
        
        return new EmpresaResource($empresa);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        //
    }
}
