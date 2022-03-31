<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Ivacondition;
use Illuminate\Http\Request;
use App\Http\Resources\v1\IvaconditionResource;

class IvaconditionController extends Controller
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
        
        $ivaconditions = Ivacondition::orderBy('name', 'ASC')
            ->where($atr)->get();

        return IvaconditionResource::collection($ivaconditions);
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
     * @param  \App\Models\Ivacondition  $ivacondition
     * @return \Illuminate\Http\Response
     */
    public function show(Ivacondition $ivacondition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ivacondition  $ivacondition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ivacondition $ivacondition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ivacondition  $ivacondition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ivacondition $ivacondition)
    {
        //
    }
}
