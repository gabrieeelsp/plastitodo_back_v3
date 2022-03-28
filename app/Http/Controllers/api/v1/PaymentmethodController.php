<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Paymentmethod;
use Illuminate\Http\Request;
use App\Http\Resources\v1\PaymentmethodResource;

class PaymentmethodController extends Controller
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

        //filtering is_enable
        if ( $request->has('filter_is_enable')) {
            $filter_is_enable = $request->get('filter_is_enable');
            if ( $filter_is_enable == 2 ) { array_push($atr, ['is_enable', true]); }
            if ( $filter_is_enable == 3 ) { array_push($atr, ['is_enable', false]); }
        }

        

        
        $paymentmethods = Paymentmethod::orderBy('name', 'ASC')
            ->where($atr)->get();

        return PaymentmethodResource::collection($paymentmethods);
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
     * @param  \App\Models\Paymentmethod  $paymentmethod
     * @return \Illuminate\Http\Response
     */
    public function show(Paymentmethod $paymentmethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paymentmethod  $paymentmethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paymentmethod $paymentmethod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paymentmethod  $paymentmethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paymentmethod $paymentmethod)
    {
        //
    }
}
