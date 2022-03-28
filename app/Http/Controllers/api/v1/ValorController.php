<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Valor;
use Illuminate\Http\Request;

use App\Http\Resources\v1\ValorResource;

class ValorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $valors = Valor::orderBy('valor', 'DESC')->get();

        return ValorResource::collection($valors);
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
     * @param  \App\Models\Valor  $valor
     * @return \Illuminate\Http\Response
     */
    public function show(Valor $valor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Valor  $valor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Valor $valor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Valor  $valor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Valor $valor)
    {
        //
    }
}
